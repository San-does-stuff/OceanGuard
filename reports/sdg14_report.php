<?php

session_start();


include "../includes/auth_check.php";

include "../config/database.php";



// Allow Admin and Researcher


if(
    $_SESSION['role'] != "Administrator"
    &&
    $_SESSION['role'] != "Marine Researcher"
){

    header(
        "Location: ../authentication/login.php"
    );

    exit();

}



// Pollution statistics


$report_sql = "

SELECT COUNT(*)

FROM pollution_report

";


$stmt = $conn->prepare($report_sql);

$stmt->execute();

$total_reports = $stmt->fetchColumn();




// Verified reports


$verified_sql = "

SELECT COUNT(*)

FROM environmental_assessment

WHERE verification_status = 'Verified'

";


$stmt = $conn->prepare($verified_sql);

$stmt->execute();

$verified_reports = $stmt->fetchColumn();




// High risk reports


$risk_sql = "

SELECT COUNT(*)

FROM environmental_assessment

WHERE risk_level = 'High'

";


$stmt = $conn->prepare($risk_sql);

$stmt->execute();

$high_risk = $stmt->fetchColumn();





// Campaign statistics


$campaign_sql = "

SELECT COUNT(*)

FROM cleanup_campaign

";


$stmt = $conn->prepare($campaign_sql);

$stmt->execute();

$total_campaigns = $stmt->fetchColumn();




// Completed campaigns


$completed_sql = "

SELECT COUNT(*)

FROM cleanup_campaign

WHERE status='Completed'

";


$stmt = $conn->prepare($completed_sql);

$stmt->execute();

$completed_campaigns = $stmt->fetchColumn();





// Volunteers


$volunteer_sql = "

SELECT COUNT(*)

FROM campaign_participant

";


$stmt = $conn->prepare($volunteer_sql);

$stmt->execute();

$total_volunteers = $stmt->fetchColumn();





// Cleanup impact


$impact_sql = "

SELECT COUNT(*)

FROM cleanup_impact

";


$stmt = $conn->prepare($impact_sql);

$stmt->execute();

$total_impacts = $stmt->fetchColumn();



?>



<!DOCTYPE html>

<html>


<head>

<title>

SDG-14 Impact Report

</title>


<style>


body{

font-family:Arial;

}


.card{

border:1px solid #ccc;

padding:20px;

margin:20px;

width:350px;

}


</style>


</head>



<body>


<h1>

SDG-14 Life Below Water Impact Report

</h1>


<p>

OceanGuard environmental sustainability summary.

</p>




<div class="card">

<h3>
Pollution Reports Submitted
</h3>

<p>

<?php echo $total_reports; ?>

</p>

</div>





<div class="card">

<h3>
Verified Environmental Incidents
</h3>

<p>

<?php echo $verified_reports; ?>

</p>

</div>





<div class="card">

<h3>
High Risk Environmental Issues
</h3>

<p>

<?php echo $high_risk; ?>

</p>

</div>





<div class="card">

<h3>
Cleanup Campaigns Created
</h3>

<p>

<?php echo $total_campaigns; ?>

</p>

</div>





<div class="card">

<h3>
Completed Cleanup Activities
</h3>

<p>

<?php echo $completed_campaigns; ?>

</p>

</div>





<div class="card">

<h3>
Community Volunteers
</h3>

<p>

<?php echo $total_volunteers; ?>

</p>

</div>





<div class="card">

<h3>
Recorded Cleanup Impacts
</h3>

<p>

<?php echo $total_impacts; ?>

</p>

</div>



<br>


<a href="../dashboard/admin_dashboard.php">

Back to Dashboard

</a>



</body>

</html>