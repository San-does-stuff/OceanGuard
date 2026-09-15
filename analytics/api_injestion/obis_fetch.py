import requests

from data_cleaner import clean_obis_record



def fetch_obis_data():

    url = "https://api.obis.org/v3/occurrence"


    params = {

        "scientificname": "Chelonia mydas",

        "size": 50

    }


    response = requests.get(
        url,
        params=params,
        timeout=30
    )


    response.raise_for_status()


    return response.json()



if __name__ == "__main__":


    response_data = fetch_obis_data()


    records = response_data["results"]


    print(
        "Records received:",
        len(records)
    )


    first_record = records[0]


    cleaned_record = clean_obis_record(
        first_record
    )


    print("\nCleaned OBIS Data:")

    print(cleaned_record)