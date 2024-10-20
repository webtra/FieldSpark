import requests
from bs4 import BeautifulSoup
import time
import mysql.connector

# Database connection details
db_config = {
    'user': 'ojpsjxez_controlpanel',
    'password': 'WebtraW12@',
    'host': '148.251.246.72',
    'database': 'ojpsjxez_controlpanel',
    'autocommit': True,  # Enabling autocommit mode for immediate commit of each insertion
    'raise_on_warnings': True
}

# Base URLs
main_page_base_url = "https://www.vivc.de/index.php?r=flaechen%2Findex&FlaechenSearch%5Bcountries%5D%5B0%5D=SOUTH+AFRICA&page={}"
passport_base_url = "https://www.vivc.de/index.php?r=passport%2Fview&id={}"  # Will append VIVC number

# Function to scrape a single page and extract prime name, VIVC number, and country
def scrape_main_page(page_number, cursor, connection):
    url = main_page_base_url.format(page_number)
    response = requests.get(url)
    
    if response.status_code == 200:
        soup = BeautifulSoup(response.content, 'html.parser')
        table = soup.find('table')  # Adjust based on actual structure
        
        if table:
            rows = table.find_all('tr')
            for row in rows[1:]:  # Skip header row
                cells = row.find_all('td')
                if len(cells) > 1:
                    prime_name = cells[0].text.strip()  # First column (Prime Name)
                    vivc_number = cells[1].text.strip()  # Second column (Variety Number VIVC)
                    country = cells[2].text.strip()  # Third column (Country)
                    
                    # Only proceed if the country is "South Africa"
                    if country.lower() == 'south africa':
                        additional_data = scrape_passport_page(vivc_number)  # Fetch additional data from passport page
                        if additional_data:
                            # Display the cultivar currently being scraped
                            print(f"Currently scraping cultivar: {prime_name}")
                            # Insert the data into the database
                            insert_data_into_db([prime_name, vivc_number, country] + additional_data, cursor, connection)
    else:
        print(f"Failed to load page {page_number}. Status code: {response.status_code}")

# Function to scrape passport page using the VIVC number
def scrape_passport_page(vivc_number):
    url = passport_base_url.format(vivc_number)
    response = requests.get(url)
    
    if response.status_code == 200:
        soup = BeautifulSoup(response.content, 'html.parser')
        try:
            prime_name = extract_passport_field(soup, 'Prime name')
            color_of_berry_skin = extract_passport_field(soup, 'Color of berry skin')
            country_of_origin = extract_passport_field(soup, 'Country or region of origin of the variety')
            species = extract_passport_field(soup, 'Species')
            return [color_of_berry_skin, country_of_origin, species]
        except AttributeError:
            print(f"Failed to parse data for VIVC {vivc_number}.")
            return ['N/A', 'N/A', 'N/A']  # Return N/A if data is missing or cannot be parsed
    else:
        print(f"Failed to retrieve passport page for VIVC {vivc_number}. Status code: {response.status_code}")
    return []

# Helper function to extract a field by label from the passport page
def extract_passport_field(soup, field_label):
    field_row = soup.find('th', string=lambda text: text and field_label.lower() in text.lower())
    if field_row:
        return field_row.find_next_sibling('td').text.strip()
    return 'N/A'

# Function to insert data into the database in real-time
def insert_data_into_db(data, cursor, connection):
    try:
        # Ensure the number of placeholders matches the number of values being inserted (7 placeholders for 7 fields)
        insert_query = """
            INSERT INTO cultivars (prime_name, variety_number, country, color_of_berry_skin, country_of_origin, species, created_at, updated_at)
            VALUES (%s, %s, %s, %s, %s, %s, NULL, NULL)
            ON DUPLICATE KEY UPDATE
            prime_name = VALUES(prime_name),
            country = VALUES(country),
            color_of_berry_skin = VALUES(color_of_berry_skin),
            country_of_origin = VALUES(country_of_origin),
            species = VALUES(species),
            updated_at = NULL
        """
        
        # Debugging: Print out the data to be inserted
        print(f"Inserting into DB: {data}")
        
        # Execute the insert query
        cursor.execute(insert_query, data)
        
        # Explicitly commit after each row insertion
        connection.commit()
        print(f"Data committed for cultivar: {data[0]}")
    
    except mysql.connector.Error as err:
        print(f"Error inserting data: {err}")
    
    except Exception as e:
        print(f"Unexpected error: {e}")

# Function to scrape multiple pages with real-time data insertion
def scrape_multiple_pages(start_page, end_page, cursor, connection):
    total_pages = end_page - start_page + 1
    for current_page in range(start_page, end_page + 1):
        print(f"Scraping main page {current_page}...")

        # Scrape data for the current page and insert records in real-time
        scrape_main_page(current_page, cursor, connection)

        # Calculate percentage completion and display it
        progress = (current_page - start_page + 1) / total_pages * 100
        print(f"Progress: {progress:.2f}% complete")

        # Delay to avoid overloading the server
        time.sleep(1)  

# Main script execution
if __name__ == "__main__":
    try:
        # Connect to the database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()

        # Set autocommit to True to ensure each statement is committed immediately
        connection.autocommit = True

        # Truncate the table to reset auto-increment ID to 1
        truncate_query = "TRUNCATE TABLE cultivars"
        cursor.execute(truncate_query)
        connection.commit()

        # Define the page range
        start_page = 1
        end_page = 3  # Adjust the number of pages to scrape

        # Scrape and insert data in real-time
        scrape_multiple_pages(start_page, end_page, cursor, connection)

        print("Data successfully scraped and saved to the database.")
    
    except mysql.connector.Error as err:
        print(f"Error connecting to database: {err}")
    
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
            print("Database connection closed.")
