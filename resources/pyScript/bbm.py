import pandas as pd
import pymysql
import os


file_xlsx = './storage/app/public/bbm/bbm.xlsx'
file_xls = '../storage/app/public/bbm/bbm.xls'

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

# Membaca nama-nama sheet
excel_file = pd.ExcelFile(file_path, engine=engine)

# Membaca sdata
df = pd.read_excel(file_path, engine=engine)

# Process data
df[['Lokasi', 'STO']] = df['Lokasi'].str.split(' - ', expand=True)
df.sort_values(by='UPDATED_AT')
df = df[df['Lokasi'] == 'MALANG']
data = df[['Lokasi', 'STO', 'BBM_L','UPDATED_AT']]



# Menyimpan dataframe yang telah diubah ke file Excel baru

print(data)


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
    cursor.execute("TRUNCATE TABLE bbm")

    for index, row in data.iterrows():
        sql = """INSERT INTO bbm (Lokasi, STO, BBM_L, UPDATED_AT)
                 VALUES (%s, %s, %s, %s)"""
        cursor.execute(sql, (row['Lokasi'], row['STO'], row['BBM_L'], row['UPDATED_AT']))

    connection.commit()

finally:
    cursor.close()
    connection.close()

print("Data inserted successfully")
