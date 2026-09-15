import mysql.connector

from biodiversity_risk import calculate_biodiversity_risk



def connect_database():

    return mysql.connector.connect(

        host="localhost",

        user="root",

        password="",

        database="oceanguard"

    )



db = connect_database()

cursor = db.cursor(dictionary=True)



# Get biodiversity records

cursor.execute(

"""

SELECT

species_name,

scientific_name,

conservation_status

FROM species_observation

"""

)



records = cursor.fetchall()



insert_query = """

INSERT INTO biodiversity_analysis

(

species_name,

scientific_name,

conservation_status,

risk_level

)

VALUES

(%s,%s,%s,%s)

"""



for record in records:


    risk = calculate_biodiversity_risk(

        record["conservation_status"]

    )


    cursor.execute(

        insert_query,

        (

            record["species_name"],

            record["scientific_name"],

            record["conservation_status"],

            risk

        )

    )



db.commit()



print(
    "Biodiversity risk analysis completed"
)



cursor.close()

db.close()