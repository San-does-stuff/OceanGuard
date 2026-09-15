from obis_fetch import fetch_obis_data

from data_cleaner import clean_obis_record

from database_insert import insert_species_observation



response_data = fetch_obis_data()



records = response_data["results"]



print(
    "Records received:",
    len(records)
)



successful = 0

failed = 0



for record in records:


    try:


        cleaned = clean_obis_record(
            record
        )


        insert_species_observation(
            cleaned
        )


        successful += 1



    except Exception as e:


        print(
            "Import failed:",
            e
        )


        failed += 1




print("\n===================")

print("Import Completed")

print(
    "Successful:",
    successful
)

print(
    "Failed:",
    failed
)

print("===================")