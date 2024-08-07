import numpy as np
import pandas as pd
import pymysql
import os

# Path to Excel files
file_xlsx = '../storage/app/public/bbm/Bbm.xlsx'
file_xls = '../storage/app/public/bbm/Bbm.xls'

# Check if the file exists
file_exists_xlsx = os.path.exists(file_xlsx)
file_exists_xls = os.path.exists(file_xls)

# If both files exist, compare modification times
if file_exists_xlsx and file_exists_xls:
    time_xlsx = os.path.getmtime(file_xlsx)
    time_xls = os.path.getmtime(file_xls)

    # Choose the most recently edited file
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
    raise FileNotFoundError("Neither bbm.xlsx nor bbm.xls were found.")

# Load the Excel file
df = pd.read_excel(file_path, engine=engine, skiprows=1)

# Print the column names to verify the correct columns are loaded
print("Columns in the DataFrame:", df.columns)

# Assuming the 'Lokasi' column now exists and is correctly named
df[['Lokasi', 'STO']] = df['Lokasi'].str.split(' - ', expand=True)
df.sort_values(by='UPDATED_AT')
df = df[df['Lokasi'] == 'MALANG']
data = df[['Lokasi', 'STO', 'BBM_L', 'UPDATED_AT']]

# Database connection parameters
db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'arnet'

# Connect to the database
connection = pymysql.connect(
    host=db_host,
    user=db_user,
    password=db_password,
    database=db_name
)


def get_sto_id(value):
    try:
        cursor = connection.cursor()
        # Normalize the input value for matching
        normalized_value = value.replace(
            ' ', '').replace('/', '').replace('\t', '')

        # Query to fetch the sto_id based on the normalized STO name
        query = """
        SELECT id 
        FROM dropdowns 
        WHERE type = 'sto' 
          AND REPLACE(REPLACE(REPLACE(subtype, ' ', ''), '/', ''), '\t', '') LIKE %s
        """

        cursor.execute(query, ('%' + normalized_value + '%',))
        result = cursor.fetchone()
        cursor.close()

        if result:
            return result[0]
        else:
            print(f"No 'sto' ID found for value: {value}")
            return None
    except pymysql.MySQLError as e:
        print(f"Error fetching 'sto' ID: {e}")
        return None


try:
    cursor = connection.cursor()
    cursor.execute("TRUNCATE TABLE bbm")

    for index, row in data.iterrows():
        sto_id = get_sto_id(row['STO'])
        if sto_id is not None:
            sql = """INSERT INTO bbm (Lokasi, sto_id, BBM_L, UPDATED_AT)
                     VALUES (%s, %s, %s, %s)"""
            cursor.execute(sql, (row['Lokasi'], sto_id,
                           row['BBM_L'], row['UPDATED_AT']))
        else:
            print(f"Warning: No 'sto' ID found for value: {row['STO']}")

    connection.commit()

finally:
    cursor.close()
    connection.close()

print("Data inserted successfully")
