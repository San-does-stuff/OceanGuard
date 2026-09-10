<?php

session_start();

include "../config/database.php";


if($_SESSION['role'] != "Environmental Officer"){

header(
"Location: ../authentication/login.php"
);

exit();

}



$sql = "

SELECT *

FROM pollution_report

WHERE status='Pending Verification'

";



$stmt=$conn->prepare($sql);

$stmt->execute();


$reports=$stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<h2>
Pending Pollution Reports
</h2>



<table border="1">


<tr>

<th>ID</th>

<th>Title</th>

<th>Type</th>

<th>Location</th>

<th>Action</th>

</tr>



<?php foreach($reports as $report){ ?>


<tr>


<td>

<?php echo $report['report_id']; ?>

</td>



<td>

<?php echo $report['title']; ?>

</td>



<td>

<?php echo $report['pollution_type']; ?>

</td>



<td>

<?php echo $report['location']; ?>

</td>



<td>


<a href="verify_report.php?id=<?php echo $report['report_id']; ?>">

Review

</a>


</td>


</tr>


<?php } ?>


</table>