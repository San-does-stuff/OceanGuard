<?php

session_start();

include "../includes/auth_check.php";
include "../config/database.php";


// Allowed roles

$allowed_roles = [

    "Community Member",
    "Marine Researcher",
    "Administrator"

];


if(!in_array($_SESSION['role'], $allowed_roles)){


    header("Location: ../authentication/login.php");

    exit();

}



// Different views based on role

if($_SESSION['role'] == "Community Member"){


    $user_id = $_SESSION['user_id'];


    // Community Member sees only own reports

    $sql = "

    SELECT *

    FROM pollution_report

    WHERE user_id = ?

    ORDER BY report_id DESC

    ";


    $stmt = $conn->prepare($sql);


    $stmt->execute([

        $user_id

    ]);



}
else{


    // Researchers and Admins see all reports

    $sql = "

    SELECT *

    FROM pollution_report

    ORDER BY report_id DESC

    ";


    $stmt = $conn->prepare($sql);


    $stmt->execute();


}



$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<!DOCTYPE html>

<html>


<head>


<title>

Pollution Reports

</title>


<link rel="stylesheet" href="../assets/css/style.css">


</head>



<body>



<?php include "../includes/header.php"; ?>



<div class="container">



<h2>


<?php


if($_SESSION['role'] == "Community Member"){


    echo "My Pollution Reports";


}

else{


    echo "Environmental Pollution Reports";


}


?>


</h2>





<?php if(count($reports) > 0): ?>



<table border="1" cellpadding="10" width="100%">



<tr>


<th>
Report ID
</th>


<th>
Title
</th>


<th>
Description
</th>


<th>
Location
</th>


<th>
Status
</th>


<th>
Submitted Date
</th>


</tr>





<?php foreach($reports as $report): ?>



<tr>



<td>

<?= htmlspecialchars($report['report_id']); ?>

</td>




<td>

<?= htmlspecialchars($report['title']); ?>

</td>




<td>

<?= htmlspecialchars($report['description']); ?>

</td>




<td>


<?php


if(!empty($report['location'])){


    echo htmlspecialchars($report['location']);


}

elseif(!empty($report['latitude']) && !empty($report['longitude'])){


    echo "Lat: " . htmlspecialchars($report['latitude']);

    echo "<br>";

    echo "Lng: " . htmlspecialchars($report['longitude']);


}

else{


    echo "Not Provided";


}


?>


</td>




<td>

<?= htmlspecialchars($report['status']); ?>

</td>




<td>

<?= htmlspecialchars($report['created_at']); ?>

</td>



</tr>



<?php endforeach; ?>



</table>




<?php else: ?>



<p>

No pollution reports available.

</p>



<?php endif; ?>




<br>



<?php


if($_SESSION['role'] == "Community Member"){


?>


<a href="../dashboard/community_dashboard.php">

Back to Dashboard

</a>


<?php


}

elseif($_SESSION['role'] == "Marine Researcher"){


?>


<a href="../dashboard/researcher_dashboard.php">

Back to Dashboard

</a>


<?php


}

else{


?>


<a href="../dashboard/admin_dashboard.php">

Back to Dashboard

</a>


<?php


}


?>



</div>



<?php include "../includes/footer.php"; ?>



</body>


</html>