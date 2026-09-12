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

    margin-right:10px;

    margin-bottom:10px;

}


</style>


</head>



<body>


<h1>

Welcome,

<?php echo htmlspecialchars($_SESSION['name']); ?>

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

Browse available cleanup campaigns and participate in community environmental activities.

</p>


<button>

<a href="../campaigns/view_available_campaigns.php">

Browse Campaigns

</a>

</button>


<br>


<button>

<a href="../campaigns/my_participations.php">

My Participations

</a>

</button>


</div>





<br>


<a href="../authentication/logout.php"
   style="color:black;">

Logout

</a>



</body>


</html>