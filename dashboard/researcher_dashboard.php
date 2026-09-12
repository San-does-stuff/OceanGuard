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

font-family: Arial;

}


.card{


border:1px solid #ccc;

padding:20px;

margin:20px;

width:300px;


}


button{


padding:10px;

background:#007bff;

border:none;

border-radius:5px;


}


a{

color:white;

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



<div class="card">


<h3>
Marine Environmental Data
</h3>


<p>
View biodiversity and ocean condition datasets.
</p>


<button>


<a href="../researcher/view_marine_data.php">

View Marine Data

</a>


</button>


</div>




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

<br><br>

<div class="card">

<h3>
SDG-14 Impact Report
</h3>


<p>

Analyze OceanGuard environmental sustainability outcomes.

</p>


<button>

<a href="../reports/sdg14_report.php">

View SDG-14 Report

</a>

</button>


</div>

</div>




<br>


<a href="../authentication/logout.php">

Logout

</a>


</body>


</html>