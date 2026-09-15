import mysql.connector



def connect_database():

    connection = mysql.connector.connect(

        host="localhost",

        user="root",

        password="",

        database="oceanguard"

    )

    return connection




def insert_species_observation(data):


    db = connect_database()

    cursor = db.cursor()



    sql = """

    INSERT INTO species_observation

    (

        external_id,

        source_id,

        species_name,

        scientific_name,

        kingdom,

        latitude,

        longitude,

        observation_date,

        observation_count,

        conservation_status

    )


    VALUES

    (

        %s,

        %s,

        %s,

        %s,

        %s,

        %s,

        %s,

        %s,

        %s,

        %s

    )


    ON DUPLICATE KEY UPDATE


        species_name = VALUES(species_name),

        scientific_name = VALUES(scientific_name),

        kingdom = VALUES(kingdom),

        latitude = VALUES(latitude),

        longitude = VALUES(longitude),

        observation_date = VALUES(observation_date),

        observation_count = VALUES(observation_count),

        conservation_status = VALUES(conservation_status)

    """



    values = (

        data["external_id"],

        1,

        data["species_name"],

        data["scientific_name"],

        data["kingdom"],

        data["latitude"],

        data["longitude"],

        data["observation_date"],

        data["observation_count"],

        data["conservation_status"]

    )



    cursor.execute(

        sql,

        values

    )



    db.commit()



    cursor.close()

    db.close()



    print(

        "OBIS record inserted successfully"

    )