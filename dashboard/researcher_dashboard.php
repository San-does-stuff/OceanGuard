<?php

session_start();

include "../includes/auth_check.php";


// Only researchers allowed

if($_SESSION['role'] != "Marine Researcher"){

    header(
        "Location: ../authentication/login.php"
    );

    exit();

}

?>


<!DOCTYPE html>

<html>


<head>

<title>
Marine Researcher Dashboard
</title>


<style>


body{

    font-family: Arial, sans-serif;

    background:#f5f8fa;

    padding:20px;

}



h1,h2{

    color:#003b5c;

}



.dashboard-container{

    display:flex;

    flex-wrap:wrap;

    gap:20px;

}



.card{


    background:white;

    border:1px solid #ddd;

    padding:20px;

    width:300px;

    border-radius:10px;

    box-shadow:0px 2px 5px rgba(0,0,0,0.1);

}



.card h3{

    color:#0077b6;

}



.card p{

    min-height:50px;

}



button{


    padding:10px 15px;

    background:#007bff;

    border:none;

    border-radius:5px;

    cursor:pointer;

}



button:hover{

    background:#0056b3;

}



button a{


    color:white;

    text-decoration:none;

}



.logout{


    margin-top:30px;

}



.logout a{


    color:red;

    text-decoration:none;

}


</style>


</head>



<body>



<h1>

Welcome,

<?php echo $_SESSION['name']; ?>

</h1>



<h2>
Marine Researcher Dashboard
</h2>



<div class="dashboard-container">



<!-- Marine Environmental Data -->

<div class="card">


<h3>
Marine Environmental Data
</h3>


<p>

View stored marine datasets and environmental records.

</p>


<button>

<a href="../researcher/view_marine_data.php">

View Marine Data

</a>

</button>


</div>





<!-- NEW OBIS BIODIVERSITY MODULE -->

<div class="card">


<h3>
Marine Biodiversity Monitoring
</h3>


<p>

Explore OBIS biodiversity observations,
species records and geographic distribution.

</p>


<button>

<a href="../researcher/biodiversity_dashboard.php">

Open Biodiversity Dashboard

</a>

</button>


</div>





<!-- Future Ocean Conditions -->

<div class="card">


<h3>
Ocean Conditions Monitoring
</h3>


<p>

View temperature, salinity and ocean condition data.

<br><br>

<i>
Copernicus / IMOS integration coming in Phase 6.
</i>


</p>


<button disabled>

Coming Soon

</button>


</div>





<!-- Pollution Reports -->

<div class="card">


<h3>
Pollution Information
</h3>


<p>

Review verified marine pollution incidents.

</p>


<button>


<a href="../reports/view_reports.php">

View Reports

</a>


</button>


</div>





<!-- Data Import -->

<div class="card">


<h3>
Data Import
</h3>


<p>

Import external environmental datasets.

</p>


<button>


<a href="../researcher/import_marine_data.php">

Import CSV Dataset

</a>


</button>


</div>





<!-- SDG Report -->

<div class="card">


<h3>
SDG-14 Impact Report
</h3>


<p>

Analyse OceanGuard sustainability outcomes
and environmental impact.

</p>


<button>


<a href="../reports/sdg14_report.php">

View SDG-14 Report

</a>


</button>


</div>




</div>



<div class="logout">


<a href="../authentication/logout.php">

Logout

</a>


</div>



</body>


</html>