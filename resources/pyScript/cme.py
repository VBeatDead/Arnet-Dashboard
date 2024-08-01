#!/usr/bin/env python
# coding: utf-8

# # Import Library #
# - pip install numpy
# - pip install matplotlib
# - pip install pandas

# In[12]:


import numpy as np
import pandas as pd
import pymysql
import os
import openpyxl
import xlrd


# ### Read Data ###

# In[13]:


file_xlsx = '../storage/app/public/cme/Cme.xlsx'
file_xls = '../storage/app/public/cme/Cme.xls'

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
    raise FileNotFoundError("Neither CME.xlsx nor CME.xls were found.")

# Membaca file Excel
df = pd.read_excel(file_path, engine=engine)



# In[14]:


stoDevice = df[['sto', 'kategori']]

stoDevice = df.groupby(['sto', 'kategori']).size(
).reset_index(name='total per unit')

print(stoDevice)


# In[15]:


current_year = pd.Timestamp('now').year


df['age'] = current_year - df['periode']

bins = [0, 5, 10, df['age'].max()]
labels = ['underfive', 'morethanfive', 'morethanten']

# Create a new column in the DataFrame based on the conditions
df['age_range'] = pd.cut(df['age'], bins=bins, labels=labels, right=True)

# Group by 'sto' and 'age_range' and count occurrences
pivot_benar = df.groupby(['sto', 'kategori', 'age_range']).size().unstack(
    fill_value=0).reset_index()

pivot_benar.head(15)


# In[16]:


pivot_benar = pd.merge(stoDevice, pivot_benar, on=[
                       'sto', 'kategori'], how='left')

pivot_benar.head(15)


# yang benar

# In[ ]:


# In[17]:


db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'arnet'

# Establish the database connection
connection = pymysql.connect(
    host=db_host,
    user=db_user,
    password=db_password,
    database=db_name
)


def get_sto_from_dropdown(value):
    try:
        cursor = connection.cursor()
        # Normalize whitespace and special characters in the input value
        normalized_value = value.replace(
            ' ', '').replace('/', '').replace('\t', '')

        # Define the SQL query with a single placeholder for parameterized input
        query = """
        SELECT id 
        FROM dropdowns 
        WHERE type = 'sto' 
          AND REPLACE(REPLACE(REPLACE(subtype, ' ', ''), '/', ''), '\t', '') LIKE %s
        """

        # Execute the query with the normalized value wrapped with '%' for LIKE pattern matching
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


def get_category_from_dropdown(value):
    try:
        cursor = connection.cursor()
        # Normalize whitespace and special characters in the input value
        normalized_value = value.replace(
            ' ', '').replace('/', '').replace('\t', '')

        # Define the SQL query with a single placeholder for parameterized input
        query = """
        SELECT id 
        FROM dropdowns 
        WHERE type = 'category' 
          AND REPLACE(REPLACE(REPLACE(subtype, ' ', ''), '/', ''), '\t', '') LIKE %s
        """

        # Execute the query with the normalized value wrapped with '%' for LIKE pattern matching
        cursor.execute(query, ('%' + normalized_value + '%',))
        result = cursor.fetchone()
        cursor.close()

        if result:
            return result[0]
        else:
            return None
    except pymysql.MySQLError as e:
        print(f"Error fetching 'category' ID: {e}")
        return None


try:
    cursor = connection.cursor()

    # Truncate the table to clear existing data
    cursor.execute("TRUNCATE TABLE cmes")

    # Define the SQL INSERT statement
    insert_query = """
    INSERT INTO cmes (sto_id, type_id, underfive, morethanfive, morethanten, count)
    VALUES (%s, %s, %s, %s, %s, %s)
    """

    # Iterate over the DataFrame rows and insert each row into the table
    for index, row in pivot_benar.iterrows():
        sto_id = get_sto_from_dropdown(row['sto'])
        type_id = get_category_from_dropdown(row['kategori'])
        if sto_id is not None:
            cursor.execute(insert_query, (
                sto_id,
                type_id,
                row['underfive'],
                row['morethanfive'],
                row['morethanten'],
                row['total per unit']
            ))
        else:
            print(f"Warning: No 'sto' ID found for value: {row['sto']}")

    # Commit the transaction
    connection.commit()

except pymysql.MySQLError as e:
    print(f"Error during database operations: {e}")

finally:
    # Close the cursor and the connection
    cursor.close()
    connection.close()

print("Data inserted successfully")


# In[18]:


# df = pd.read_excel('../../storage/app/public/cme/Data Potensi CME Malang Juli 2024.xlsx')
# df.head()


# # Making Pivot #

# In[19]:


# category_counts = df.groupby(['sto', 'kategori']).size().reset_index(name='total')

# # Pivot the table
# pivot_table = category_counts.pivot_table(index='sto', columns='kategori', values='total', fill_value=0)

# pivot_table = pivot_table.astype(int)

# pivot_table['Total'] = pivot_table.sum(axis=1)
# # Reset index to make 'sto' a column again
# pivot_table = pivot_table.reset_index()


# pivot_table.head(15)


# ## Sorting the year ##

# #### Converting the Age ####

# In[20]:


# current_year=2024

# df['age'] = current_year - df['periode']


# #### Count the Number of Products in Each Age Range ####

# In[21]:


# bins = [0, 5, 10, df['age'].max()]
# labels = ['underfive', 'morethanfive', 'morethanten']

# # Create a new column in the DataFrame based on the conditions
# df['age_range'] = pd.cut(df['age'], bins=bins, labels=labels, right=True)

# # Group by 'sto' and 'age_range' and count occurrences
# age_range_counts = df.groupby(['sto', 'age_range']).size().unstack(fill_value=0).reset_index()

# print(age_range_counts)


# ## Combining Tables ##

# In[22]:


# combined_df = pd.merge(pivot_table, age_range_counts, on='sto')

# combined_df.head(40)


# ### Importing To MySql ###

# In[23]:


# db_host = 'localhost'
# db_user = 'root'
# db_password = ''
# db_name = 'arnet'

# connection = pymysql.connect(
#     host=db_host,
#     user=db_user,
#     password=db_password,
#     database=db_name
# )

# # Step 1: Mapping 'sto' and 'category' to their respective ids from the 'dropdown' table
# sto_mapping = {}
# category_mapping = {}

# def get_sto_from_dropdown(value):
#     cursor = connection.cursor()
#     query = "SELECT id FROM dropdowns WHERE type = 'sto' AND subtype LIKE %s"
#     cursor.execute(query, ('%' + value + '%',))
#     result = cursor.fetchone()
#     cursor.close()
#     if result:
#         return result[0]
#     else:
#         return None


# def get_category_from_dropdown(value):
#     cursor = connection.cursor()
#     query = "SELECT id FROM dropdowns WHERE type = 'category' AND subtype LIKE %s"
#     cursor.execute(query, ('%' + value + '%',))
#     result = cursor.fetchone()
#     cursor.close()
#     if result:
#         return result[0]
#     else:
#         return None


# try:
#     cursor = connection.cursor()

#     # Truncate the table to clear existing data
#     cursor.execute("TRUNCATE TABLE cmes")

#     # Define the SQL INSERT statement
#     insert_query = """
#     INSERT INTO cmes (sto_id, underfive, morethanfive, morethanten, total)
#     VALUES (%s, %s, %s, %s, %s, %s)
#     """


#     # Iterate over the DataFrame rows and insert each row into the table
#     for index, row in combined_df.iterrows():
#         cursor.execute(insert_query, (
#             # get sto id
#             get_sto_from_dropdown(row['sto']),
#             row['underfive'],
#             row['morethanfive'],
#             row['morethanten'],
#             row['Total']
#         ))

#     # Commit the transaction
#     connection.commit()

# finally:
#     # Close the cursor and the connection
#     cursor.close()
#     connection.close()

# print("Data inserted successfully")


# # This is for creating seeder only run if neccesery #

# In[24]:


# # Get unique values of 'sto', 'ruangan', and 'kategori' columns
# sto = df['sto'].unique()
# sto = sorted(sto)
# rooms = df['ruangan'].unique()
# category = df['kategori'].unique()

# # Prepare the data for seeder
# dropdowns = {}

# # Create a dictionary with 'sto' values
# for index, s in enumerate(sto):
#     dropdowns[str(index)] = {
#         'type': ['sto'],
#         'subtype': [s]
#     }

# # Create a dictionary with 'room' values starting from len(sto)
# start_index = len(sto)
# for index, room in enumerate(rooms):
#     dropdowns[str(start_index + index)] = {
#         'type': ['room'],
#         'subtype': [room]
#     }

# # Create a dictionary with 'category' values starting from len(sto) + len(rooms)
# start_index = len(sto) + len(rooms)
# for index, c in enumerate(category):
#     dropdowns[str(start_index + index)] = {
#         'type': ['category'],
#         'subtype': [c]
#     }

# # Convert the dictionary to PHP-like array syntax
# def dict_to_php_array(d):
#     php_array = "{\n"
#     for key, value in d.items():
#         php_array += f"    '{key}' => [\n"
#         php_array += f"        'type' => {value['type']},\n"
#         php_array += f"        'subtype' => {value['subtype']},\n"
#         php_array += "    ],\n"
#     php_array += "}\n"
#     return php_array

# php_array_str = dict_to_php_array(dropdowns)
# print(php_array_str)
