def clean_obis_record(record):

    cleaned_data = {

        "external_id":
            record.get("occurrenceID"),


        "species_name":
            record.get("species"),


        "scientific_name":
            record.get("scientificName"),


        "kingdom":
            record.get("kingdom"),


        "latitude":
            record.get("decimalLatitude"),


        "longitude":
            record.get("decimalLongitude"),


        "observation_date":
            record.get("eventDate"),

        "conservation_status":
            record.get("category"),


        "observation_count":
            int(
                record.get(
                    "individualCount",
                    1
                )
            )

    }


    return cleaned_data