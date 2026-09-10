<?php

session_start();

include "../config/database.php";


if($_SESSION['role'] != "Marine Researcher"){

header(
"Location: ../authentication/login.php"
);

exit();

}



$sql = "

SELECT *

FROM marine_data

ORDER BY recorded_date DESC

";



$stmt=$conn->prepare($sql);

$stmt->execute();



$data=$stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<h2>
Marine Environmental Dataset
</h2>



<table border="1">


<tr>

<th>Source</th>

<th>Type</th>

<th>Parameter</th>

<th>Value</th>

<th>Unit</th>

<th>Latitude</th>

<th>Longitude</th>

<th>Date</th>


</tr>



<?php foreach($data as $row){ ?>


<tr>


<td>

<?php echo $row['source']; ?>

</td>


<td>

<?php echo $row['data_type']; ?>

</td>


<td>

<?php echo $row['parameter']; ?>

</td>


<td>

<?php echo $row['value']; ?>

</td>


<td>

<?php echo $row['unit']; ?>

</td>


<td>

<?php echo $row['latitude']; ?>

</td>


<td>

<?php echo $row['longitude']; ?>

</td>


<td>

<?php echo $row['recorded_date']; ?>

</td>


</tr>


<?php } ?>


</table>