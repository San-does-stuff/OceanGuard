<?php

session_start();


include "../includes/auth_check.php";


// Allow logged-in users to view impact


include "../config/database.php";





$sql = "

SELECT


    cleanup_campaign.title,

    cleanup_campaign.location,

    cleanup_campaign.campaign_date,


    cleanup_impact.volunteers_count,

    cleanup_impact.waste_collected,

    cleanup_impact.completion_date,

    cleanup_impact.remarks,


    users.name AS coordinator_name



FROM cleanup_impact



JOIN cleanup_campaign

ON cleanup_impact.campaign_id = cleanup_campaign.campaign_id



JOIN users

ON cleanup_campaign.coordinator_id = users.user_id



ORDER BY cleanup_impact.completion_date DESC


";




$stmt = $conn->prepare($sql);


$stmt->execute();



?>



<!DOCTYPE html>

<html>


<head>

<title>

Cleanup Impact Report

</title>



<style>


body{

    font-family:Arial;

}



.card{

    border:1px solid #ccc;

    padding:20px;

    margin:20px;

    width:400px;

}



</style>


</head>



<body>



<h1>

Cleanup Impact Report

</h1>



<a href="../index.php">

Back Home

</a>



<br><br>





<?php



if($stmt->rowCount() > 0){



while($row = $stmt->fetch(PDO::FETCH_ASSOC)){



?>



<div class="card">


<h2>

<?php echo htmlspecialchars($row['title']); ?>

</h2>



<p>

<strong>Location:</strong>

<?php echo htmlspecialchars($row['location']); ?>

</p>




<p>

<strong>Cleanup Date:</strong>

<?php echo htmlspecialchars($row['completion_date']); ?>

</p>




<p>

<strong>Campaign Date:</strong>

<?php echo htmlspecialchars($row['campaign_date']); ?>

</p>




<p>

<strong>Coordinator:</strong>

<?php echo htmlspecialchars($row['coordinator_name']); ?>

</p>




<p>

<strong>Volunteers:</strong>

<?php echo htmlspecialchars($row['volunteers_count']); ?>

</p>




<p>

<strong>Waste Collected:</strong>

<?php echo htmlspecialchars($row['waste_collected']); ?>

</p>




<p>

<strong>Remarks:</strong>

<br>

<?php echo htmlspecialchars($row['remarks']); ?>

</p>



</div>



<?php


}



}

else{


echo "<p>No cleanup impact recorded yet.</p>";


}



?>



</body>

</html>