<?php

session_start();

include "../includes/role_check.php";
include "../config/database.php";


checkRole("Cleanup Coordinator");


// Get logged-in coordinator ID

$coordinator_id = $_SESSION['user_id'];


// Fetch campaigns created by this coordinator

$sql = "SELECT *
        FROM cleanup_campaign
        WHERE coordinator_id = ?
        ORDER BY created_at DESC";


$stmt = $conn->prepare($sql);

$stmt->execute([$coordinator_id]);


?>


<!DOCTYPE html>

<html>

<head>

<title>My Cleanup Campaigns</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<h1>
    My Cleanup Campaigns
</h1>



<a href="../dashboard/cleanup_dashboard.php">

    Back to Dashboard

</a>



<br><br>



<?php


// Check if campaigns exist

if($stmt->rowCount() > 0){


    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){


?>


<div class="dashboard-card">


    <h2>
        <?php echo htmlspecialchars($row['title']); ?>
    </h2>



    <p>

        <strong>Description:</strong>

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

        <strong>Created:</strong>

        <?php echo htmlspecialchars($row['created_at']); ?>

    </p>


</div>



<br>



<?php


    }


}

else{


?>


<p>
    No campaigns created yet.
</p>


<?php


}


?>


</body>

</html>