def calculate_biodiversity_risk(status):


    if status == "CR":

        return "Critical"



    elif status == "EN":

        return "High"



    elif status == "VU":

        return "Medium"



    elif status == "NT":

        return "Low-Medium"



    elif status == "LC":

        return "Low"



    else:

        return "Unknown"