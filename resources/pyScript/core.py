import numpy as np
import pandas as pd
import pymysql
import argparse
import sys
import os
import openpyxl
import xlrd

file_xlsx = '../storage/app/public/core/Core.xlsx'
file_xls = '../storage/app/public/core/Core.xls'

# Cek apakah file ada
file_exists_xlsx = os.path.exists(file_xlsx)
file_exists_xls = os.path.exists(file_xls)

# Jika kedua file ada, bandingkan waktu modifikasinya
if file_exists_xlsx and file_exists_xls:
    # Mendapatkan waktu modifikasi file
    time_xlsx = os.path.getmtime(file_xlsx)
    time_xls = os.path.getmtime(file_xls)

    # Memilih file yang paling baru diedit
    if time_xlsx > time_xls:
        file_path = file_xlsx
        engine = 'openpyxl'
    else:
        file_path = file_xls
        engine = 'xlrd'
elif file_exists_xlsx:
    file_path = file_xlsx
    engine = 'openpyxl'
elif file_exists_xls:
    file_path = file_xls
    engine = 'xlrd'
else:
    raise FileNotFoundError("Neither Core.xlsx nor Core.xls were found.")

# Membaca file Excel
df = pd.read_excel(file_path, engine=engine)



# Process data
grouped_df = df['Ruas'].value_counts().reset_index()
grouped_df.columns = ['Ruas', 'Jumlah']

core = df.groupby('Ruas').agg({
    'Idle Baik': 'sum',
    'Idle Rusak': 'sum',
    'Core Operasi': 'sum'
})

core = core.astype(int)

pivot_table = df.pivot_table(
    index='Ruas',
    aggfunc={'Idle Baik': 'sum',
                'Idle Rusak': 'sum',
                'Core Operasi': 'sum',
                'Ruas': 'count'
                },
)

pivot_table = pivot_table.astype(int)
pivot_table = pivot_table.rename(columns={'Ruas': 'Jumlah Kabel'})
pivot_table['Total'] = pivot_table[['Idle Baik', 'Idle Rusak', 'Core Operasi']].sum(axis=1)

# Database connection parameters
db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'arnet'

# Connect to the database and insert data
connection = pymysql.connect(
    host=db_host,
    user=db_user,
    password=db_password,
    database=db_name
)

try:
    cursor = connection.cursor()
    cursor.execute("TRUNCATE TABLE cores")

    for index, row in pivot_table.iterrows():
        sql = """INSERT INTO cores (segment, good, bad, used, ccount, total)
                    VALUES (%s, %s, %s, %s, %s, %s)"""
        cursor.execute(sql, (index, row['Idle Baik'], row['Idle Rusak'],
                    row['Core Operasi'], row['Jumlah Kabel'], row['Total']))

    connection.commit()

finally:
    cursor.close()
    connection.close()

print("Data inserted successfully")
