<?php

session_start();

include "../config/database.php";


if($_SESSION['role'] != "Marine Researcher"){

header(
"Location: ../authentication/login.php"
);

exit();

}



if(isset($_POST['upload'])){


$file = $_FILES['csv_file']['tmp_name'];



if(($handle = fopen($file,"r")) !== FALSE){



// Remove header row

fgetcsv($handle);



while(($data = fgetcsv($handle,1000,",")) !== FALSE){



$sql="

INSERT INTO marine_data

(
source,
data_type,
parameter,
value,
unit,
latitude,
longitude,
recorded_date
)

VALUES(?,?,?,?,?,?,?,?)

";



$stmt=$conn->prepare($sql);



$stmt->execute([

$data[0],

$data[1],

$data[2],

$data[3],

$data[4],

$data[5],

$data[6],

$data[7]

]);


}



fclose($handle);



echo "Marine data imported successfully";


}


}


?>


<h2>
Import Marine Environmental Dataset
</h2>



<form method="POST" enctype="multipart/form-data">


<input 
type="file"
name="csv_file"
accept=".csv"
required
>


<br><br>


<button name="upload">

Upload CSV

</button>


</form> 