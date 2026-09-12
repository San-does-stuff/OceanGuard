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





$sql = "

SELECT 

    cleanup_campaign.*,

    users.name AS coordinator_name


FROM cleanup_campaign


JOIN users

ON cleanup_campaign.coordinator_id = users.user_id


WHERE cleanup_campaign.status = 'Upcoming'


ORDER BY cleanup_campaign.campaign_date ASC


";



$stmt = $conn->prepare($sql);


$stmt->execute();



?>



<!DOCTYPE html>

<html>


<head>

<title>

Available Cleanup Campaigns

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



button{

    background:#007bff;

    border:none;

    padding:10px;

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

Available Cleanup Campaigns

</h1>



<a href="../dashboard/community_dashboard.php"
style="color:black;">

Back to Dashboard

</a>




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

<strong>Date:</strong>

<?php echo htmlspecialchars($row['campaign_date']); ?>

</p>




<p>

<strong>Coordinator:</strong>

<?php echo htmlspecialchars($row['coordinator_name']); ?>

</p>




<p>

<strong>Status:</strong>

<?php echo htmlspecialchars($row['status']); ?>

</p>




<form action="join_campaign.php" method="POST">


<input 

type="hidden"

name="campaign_id"

value="<?php echo $row['campaign_id']; ?>">



<button type="submit">


<a href="#">

Join Campaign

</a>


</button>



</form>




</div>



<?php


}



}

else{


echo "<p>No upcoming cleanup campaigns available.</p>";


}



?>



</body>


</html>