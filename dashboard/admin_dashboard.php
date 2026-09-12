<?php

session_start();

include "../includes/role_check.php";
include "../config/database.php";


checkRole("Administrator");


// Total users

$user_sql = "SELECT COUNT(*) FROM users";

$user_stmt = $conn->prepare($user_sql);

$user_stmt->execute();

$total_users = $user_stmt->fetchColumn();



// Total pollution reports

$report_sql = "SELECT COUNT(*) FROM pollution_report";

$report_stmt = $conn->prepare($report_sql);

$report_stmt->execute();

$total_reports = $report_stmt->fetchColumn();



// Total campaigns

$campaign_sql = "SELECT COUNT(*) FROM cleanup_campaign";

$campaign_stmt = $conn->prepare($campaign_sql);

$campaign_stmt->execute();

$total_campaigns = $campaign_stmt->fetchColumn();



// Total participants

$participant_sql = "SELECT COUNT(*) FROM campaign_participant";

$participant_stmt = $conn->prepare($participant_sql);

$participant_stmt->execute();

$total_participants = $participant_stmt->fetchColumn();



// Total cleanup impact records

$impact_sql = "SELECT COUNT(*) FROM cleanup_impact";

$impact_stmt = $conn->prepare($impact_sql);

$impact_stmt->execute();

$total_impacts = $impact_stmt->fetchColumn();



?>


<!DOCTYPE html>

<html>


<head>

<title>
Administrator Dashboard
</title>


<style>


body{

font-family:Arial;

}


.card{

border:1px solid #ccc;

padding:20px;

margin:20px;

width:300px;

}



</style>


</head>



<body>


<h1>

Welcome Administrator

</h1>


<h2>

OceanGuard System Overview

</h2>




<div class="card">

<h3>

Registered Users

</h3>

<p>

<?php echo $total_users; ?>

</p>

</div>




<div class="card">

<h3>

Pollution Reports

</h3>

<p>

<?php echo $total_reports; ?>

</p>

</div>




<div class="card">

<h3>

Cleanup Campaigns

</h3>

<p>

<?php echo $total_campaigns; ?>

</p>

</div>




<div class="card">

<h3>

Volunteer Participation

</h3>

<p>

<?php echo $total_participants; ?>

</p>

</div>




<div class="card">

<h3>

Cleanup Impact Records

</h3>

<p>

<?php echo $total_impacts; ?>

</p>

</div>
<br><br>

<a href="../reports/sdg14_report.php">

View SDG-14 Impact Report

</a>


<br>


<a href="../authentication/logout.php">

Logout

</a>



</body>

</html>