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


include "../config/database.php";



$user_id = $_SESSION['user_id'];




// Fetch joined campaigns


$sql = "

SELECT

    cleanup_campaign.*,

    campaign_participant.joined_date,

    users.name AS coordinator_name


FROM campaign_participant



JOIN cleanup_campaign

ON campaign_participant.campaign_id = cleanup_campaign.campaign_id



JOIN users

ON cleanup_campaign.coordinator_id = users.user_id



WHERE campaign_participant.user_id = ?



ORDER BY campaign_participant.joined_date DESC


";




$stmt = $conn->prepare($sql);


$stmt->execute([

    $user_id

]);



?>



<!DOCTYPE html>

<html>


<head>

<title>

My Cleanup Participations

</title>



<style>


body{

    font-family: Arial;

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

My Cleanup Participations

</h1>




<a href="../dashboard/community_dashboard.php">

Back to Dashboard

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

<strong>Description:</strong>

<br>

<?php echo htmlspecialchars($row['description']); ?>

</p>




<p>

<strong>Location:</strong>

<?php echo htmlspecialchars($row['location']); ?>

</p>




<p>

<strong>Campaign Date:</strong>

<?php echo htmlspecialchars($row['campaign_date']); ?>

</p>




<p>

<strong>Status:</strong>

<?php echo htmlspecialchars($row['status']); ?>

</p>




<p>

<strong>Coordinator:</strong>

<?php echo htmlspecialchars($row['coordinator_name']); ?>

</p>




<p>

<strong>Joined On:</strong>

<?php echo htmlspecialchars($row['joined_date']); ?>

</p>



</div>



<?php


}



}

else{


echo "<p>You have not joined any cleanup campaigns yet.</p>";


}



?>



</body>

</html>