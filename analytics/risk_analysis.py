import mysql.connector
import pandas as pd
import numpy as np


# =========================
# Database Connection
# =========================


connection = mysql.connector.connect(

    host="localhost",

    user="root",

    password="",

    database="oceanguard"

)



print("Database connection successful")





# =========================
# Load Pollution Data
# =========================


pollution_query = """

SELECT *

FROM pollution_report

"""


pollution_data = pd.read_sql(

    pollution_query,

    connection

)



print("\nPollution Data")

print(pollution_data)





# =========================
# Load Assessment Data
# =========================


assessment_query = """

SELECT *

FROM environmental_assessment

"""


assessment_data = pd.read_sql(

    assessment_query,

    connection

)



print("\nAssessment Data")

print(assessment_data)





# =========================
# Load Marine Data
# =========================


marine_query = """

SELECT *

FROM marine_data

"""


marine_data = pd.read_sql(

    marine_query,

    connection

)



print("\nMarine Data Count:")

print(len(marine_data))





# =========================
# Risk Calculation
# =========================


total_reports = len(pollution_data)



verified_reports = len(

pollution_data[
pollution_data["status"]=="Verified"
]

)



# -------------------------
# Frequency Score
# -------------------------


if total_reports <= 2:

    frequency_score = 5


elif total_reports <=5:

    frequency_score = 15


elif total_reports <=10:

    frequency_score = 25


else:

    frequency_score = 30





# -------------------------
# Verification Score
# -------------------------


if total_reports == 0:

    verification_rate = 0


else:

    verification_rate = (

        verified_reports /

        total_reports

    ) * 100




if verification_rate <=30:

    verification_score = 5


elif verification_rate <=70:

    verification_score = 10


else:

    verification_score = 20





# -------------------------
# Severity Score
# -------------------------


severity_score = 0



pollution_types = (

pollution_data["pollution_type"]

.unique()

)



if "Oil Spill" in pollution_types:

    severity_score = max(

        severity_score,

        30

    )



elif "Chemical Pollution" in pollution_types:

    severity_score = max(

        severity_score,

        30

    )



elif "Plastic Waste" in pollution_types:

    severity_score = max(

        severity_score,

        20

    )



else:

    severity_score = 10





# -------------------------
# Environmental Sensitivity
# -------------------------


if len(marine_data) > 0:

    sensitivity_score = 20


else:

    sensitivity_score = 0





# =========================
# Final Score
# =========================


risk_score = (

frequency_score

+

verification_score

+

severity_score

+

sensitivity_score

)



if risk_score <=30:

    risk_level = "Low"



elif risk_score <=70:

    risk_level = "Medium"



else:

    risk_level = "High"





# =========================
# Display Result
# =========================


print("\n===================")

print("Environmental Risk Analysis")

print("===================")


print(

"Total Reports:",

total_reports

)


print(

"Verified Reports:",

verified_reports

)


print(

"Risk Score:",

risk_score

)


print(

"Risk Level:",

risk_level

)

# =========================
# Recommendation Generation
# =========================


if risk_level == "High":

    recommendation = (
        "Immediate cleanup and environmental monitoring recommended."
    )


elif risk_level == "Medium":

    recommendation = (
        "Increase monitoring frequency and review pollution sources."
    )


else:

    recommendation = (
        "Continue regular environmental monitoring."
    )





# =========================
# Store Analysis Result
# =========================


insert_query = """

INSERT INTO environmental_analysis

(
location,
total_reports,
verified_reports,
risk_score,
risk_level,
recommendation
)

VALUES

(%s,%s,%s,%s,%s,%s)

"""



cursor = connection.cursor()



cursor.execute(

insert_query,

(

"Coastal Monitoring Area",

total_reports,

verified_reports,

risk_score,

risk_level,

recommendation

)

)



connection.commit()



print("\nAnalysis saved successfully!")



cursor.close()



connection.close()


