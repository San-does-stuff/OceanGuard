<?php

session_start();

include "../includes/auth_check.php";


if($_SESSION['role'] != "Environmental Officer"){

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
Environmental Officer Dashboard
</title>


<style>

body{

    font-family: Arial;

}


.card{

    border:1px solid #ccc;

    padding:20px;

    margin:15px;

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
Environmental Officer Dashboard
</h2>



<div class="card">


<h3>
Pollution Verification
</h3>


<p>
Review and verify submitted pollution reports.
</p>



<button>

<a href="../verification/view_pending_reports.php">

View Pending Reports

</a>

</button>


</div>





<div class="card">


<h3>
Environmental Monitoring
</h3>


<p>
View verified incidents, pollution statistics and map visualization.
</p>



<button>

<a href="../monitoring/dashboard.php">

Open Monitoring Dashboard

</a>

</button>


</div>





<div class="card">


<h3>
Account

</h3>


<button>

<a href="../authentication/logout.php">

Logout

</a>

</button>


</div>



</body>


</html>