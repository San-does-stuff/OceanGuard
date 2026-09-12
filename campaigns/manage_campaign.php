<?php

session_start();

include "../includes/role_check.php";
include "../config/database.php";

checkRole("Cleanup Coordinator");


$coordinator_id = $_SESSION['user_id'];


// Update campaign status

if(isset($_POST['update_status'])){

    $campaign_id = $_POST['campaign_id'];
    $status = $_POST['status'];

    $sql = "UPDATE cleanup_campaign
            SET status = ?
            WHERE campaign_id = ?
            AND coordinator_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $status,
        $campaign_id,
        $coordinator_id
    ]);

    $message = "Campaign status updated successfully.";

}


// Fetch coordinator campaigns

$sql = "SELECT *
        FROM cleanup_campaign
        WHERE coordinator_id = ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $coordinator_id
]);

?>

<!DOCTYPE html>

<html>

<head>

<title>Manage Campaigns</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<h1>
Manage Cleanup Campaigns
</h1>


<a href="../dashboard/cleanup_dashboard.php">

Back to Dashboard

</a>


<br><br>


<?php

if(isset($message)){

    echo "<p>" . htmlspecialchars($message) . "</p>";

}

?>


<?php

if($stmt->rowCount() > 0){

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

?>

<div class="dashboard-card">


<h2>

<?php echo htmlspecialchars($row['title']); ?>

</h2>


<p>

<strong>Location:</strong>

<?php echo htmlspecialchars($row['location']); ?>

</p>


<p>

<strong>Date:</strong>

<?php echo htmlspecialchars($row['campaign_date']); ?>

</p>


<p>

<strong>Current Status:</strong>

<?php echo htmlspecialchars($row['status']); ?>

</p>


<form method="POST">


<input
    type="hidden"
    name="campaign_id"
    value="<?php echo $row['campaign_id']; ?>"
>


<label>

Update Status

</label>


<select name="status">

<option value="Upcoming"
<?php
if($row['status'] == "Upcoming"){
    echo "selected";
}
?>
>
Upcoming
</option>


<option value="Completed"
<?php
if($row['status'] == "Completed"){
    echo "selected";
}
?>
>
Completed
</option>


<option value="Cancelled"
<?php
if($row['status'] == "Cancelled"){
    echo "selected";
}
?>
>
Cancelled
</option>

</select>


<br><br>


<button
    type="submit"
    name="update_status"
>

Update Status

</button>


</form>


<?php

if($row['status'] == "Completed"){

?>

<br>


<a href="add_impact.php?campaign_id=<?php echo $row['campaign_id']; ?>">

Add Cleanup Impact

</a>


<?php

}

?>


</div>


<br>


<?php

    }

}

else{

    echo "<p>No campaigns available.</p>";

}

?>


</body>

</html>