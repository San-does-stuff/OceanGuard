<?php

session_start();


include "../includes/auth_check.php";


// Only Community Members can access

if($_SESSION['role'] != "Community Member"){

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
Community Dashboard
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


a{

    text-decoration:none;

    color:white;

}


button{

    background:#007bff;

    border:none;

    padding:10px;

    border-radius:5px;

}


</style>


</head>



<body>


<h1>

Welcome,

<?php echo $_SESSION['name']; ?>

</h1>



<h2>
Community Member Dashboard
</h2>



<div class="card">


<h3>
Report Marine Pollution
</h3>


<p>

Submit information about pollution incidents.

</p>


<button>

<a href="../reports/create_reports.php">

Create Report

</a>

</button>


</div>





<div class="card">


<h3>
My Reports
</h3>


<p>

View previously submitted pollution reports.

</p>


<button>

<a href="../reports/view_reports.php">

View Reports

</a>

</button>


</div>





<div class="card">


<h3>
Cleanup Activities
</h3>


<p>

Join future environmental cleanup campaigns.

</p>


<button disabled>

Coming Soon

</button>


</div>





<br>


<a href="../authentication/logout.php">

Logout

</a>



</body>


</html>