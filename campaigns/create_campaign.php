<?php

session_start();

include "../includes/role_check.php";
include "../config/database.php";

checkRole("Cleanup Coordinator");


$message = "";


if(isset($_POST['submit'])){


    $coordinator_id = $_SESSION['user_id'];

    $title = $_POST['title'];

    $description = $_POST['description'];

    $location = $_POST['location'];

    $campaign_date = $_POST['campaign_date'];


    $sql = "INSERT INTO cleanup_campaign
            (
                coordinator_id,
                title,
                description,
                location,
                campaign_date
            )

            VALUES
            (
                '$coordinator_id',
                '$title',
                '$description',
                '$location',
                '$campaign_date'
            )";


    if($conn->query($sql)){

        $message = "Campaign created successfully.";

    }

    else{

        $message = "Error creating campaign: ".$conn->error;

    }


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Create Cleanup Campaign</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<h1>
Create Cleanup Campaign
</h1>


<?php

if($message!=""){

    echo "<p>".$message."</p>";

}

?>



<form method="POST">


<label>
Campaign Title
</label>

<br>

<input 
type="text"
name="title"
required>


<br><br>



<label>
Description
</label>

<br>

<textarea 
name="description"
rows="5">
</textarea>


<br><br>



<label>
Cleanup Location
</label>

<br>

<input
type="text"
name="location"
required>


<br><br>



<label>
Campaign Date
</label>

<br>

<input
type="date"
name="campaign_date"
required>


<br><br>



<button type="submit" name="submit">

Create Campaign

</button>


</form>



<br>


<a href="../dashboard/cleanup_dashboard.php">

Back to Dashboard

</a>



</body>

</html>