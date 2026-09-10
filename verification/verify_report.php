<?php

session_start();

include "../config/database.php";


if($_SESSION['role'] != "Environmental Officer"){

header(
"Location: ../authentication/login.php"
);

exit();

}



$report_id=$_GET['id'];



if(isset($_POST['verify'])){


$risk=$_POST['risk'];

$remarks=$_POST['remarks'];

$officer=$_SESSION['user_id'];



$sql="

INSERT INTO environmental_assessment

(report_id, officer_id, risk_level, remarks)

VALUES(?,?,?,?)

";



$stmt=$conn->prepare($sql);


$stmt->execute([

$report_id,

$officer,

$risk,

$remarks

]);




// Update report status


$update=$conn->prepare(

"UPDATE pollution_report

SET status='Verified'

WHERE report_id=?"

);


$update->execute([$report_id]);



echo "Report Verified";


}



?>


<h2>
Verify Pollution Report
</h2>



<form method="POST">


Risk Level:


<select name="risk">


<option>
Low
</option>


<option>
Medium
</option>


<option>
High
</option>


<option>
Critical
</option>


</select>



<br><br>



Remarks:


<br>


<textarea name="remarks"></textarea>



<br><br>


<button name="verify">

Verify Report

</button>



</form>