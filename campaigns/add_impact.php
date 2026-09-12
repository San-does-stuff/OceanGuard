<?php

session_start();


include "../includes/role_check.php";
include "../config/database.php";


checkRole("Cleanup Coordinator");



$coordinator_id = $_SESSION['user_id'];



// Check campaign ID

if(!isset($_GET['campaign_id'])){

    header("Location: manage_campaign.php");

    exit();

}



$campaign_id = $_GET['campaign_id'];




// Fetch campaign information


$sql = "

SELECT *

FROM cleanup_campaign

WHERE campaign_id = ?

AND coordinator_id = ?

AND status = 'Completed'

";


$stmt = $conn->prepare($sql);


$stmt->execute([

    $campaign_id,

    $coordinator_id

]);



$campaign = $stmt->fetch(PDO::FETCH_ASSOC);



if(!$campaign){

    echo "Invalid campaign or campaign is not completed.";

    exit();

}




// Check if impact already exists


$check_sql = "

SELECT *

FROM cleanup_impact

WHERE campaign_id = ?

";



$check_stmt = $conn->prepare($check_sql);


$check_stmt->execute([

    $campaign_id

]);



if($check_stmt->rowCount() > 0){

    echo "

    <script>

    alert('Impact record already exists for this campaign.');

    window.location='manage_campaign.php';

    </script>

    ";

    exit();

}





// Insert impact record


if(isset($_POST['submit'])){


    $volunteers = $_POST['volunteers_count'];

    $waste = $_POST['waste_collected'];

    $completion_date = $_POST['completion_date'];

    $remarks = $_POST['remarks'];



    $insert_sql = "

    INSERT INTO cleanup_impact

    (

        campaign_id,

        volunteers_count,

        waste_collected,

        completion_date,

        remarks

    )


    VALUES

    (

        ?, ?, ?, ?, ?

    )

    ";



    $insert_stmt = $conn->prepare($insert_sql);



    if($insert_stmt->execute([

        $campaign_id,

        $volunteers,

        $waste,

        $completion_date,

        $remarks

    ])){



        echo "

        <script>

        alert('Cleanup impact added successfully.');

        window.location='view_impact.php';

        </script>

        ";


    }


}



?>


<!DOCTYPE html>

<html>


<head>

<title>

Add Cleanup Impact

</title>


<link rel="stylesheet" href="../assets/css/style.css">


</head>



<body>


<h1>

Add Cleanup Impact

</h1>



<h2>

<?php echo htmlspecialchars($campaign['title']); ?>

</h2>



<p>

Location:

<?php echo htmlspecialchars($campaign['location']); ?>

</p>



<p>

Date:

<?php echo htmlspecialchars($campaign['campaign_date']); ?>

</p>




<form method="POST">


<label>

Number of Volunteers

</label>

<br>


<input

type="number"

name="volunteers_count"

required>


<br><br>



<label>

Waste Collected

</label>

<br>


<input

type="text"

name="waste_collected"

placeholder="Example: 50 kg plastic"

required>


<br><br>



<label>

Completion Date

</label>

<br>


<input

type="date"

name="completion_date"

required>


<br><br>



<label>

Remarks

</label>

<br>


<textarea

name="remarks"

rows="5"

cols="40">

</textarea>


<br><br>



<button

type="submit"

name="submit">

Save Impact

</button>



</form>



<br>


<a href="manage_campaign.php">

Back to Campaign Management

</a>



</body>

</html>