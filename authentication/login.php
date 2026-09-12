<?php

session_start();

include "../config/database.php";


if(isset($_POST['login'])){


$email = $_POST['email'];

$password = $_POST['password'];



$sql = "SELECT *
        FROM users
        WHERE email=?";



$stmt = $conn->prepare($sql);


$stmt->execute([$email]);



$user = $stmt->fetch(PDO::FETCH_ASSOC);



if($user && password_verify(

    $password,

    $user['password']

)){


$_SESSION['user_id'] = $user['user_id'];

$_SESSION['name'] = $user['name'];

$_SESSION['role'] = $user['role'];



switch($user['role']){


case "Community Member":

header(
"Location: ../dashboard/community_dashboard.php"
);

break;



case "Environmental Officer":

header(
"Location: ../dashboard/officer_dashboard.php"
);

break;



case "Cleanup Coordinator":

header(
"Location: ../dashboard/cleanup_dashboard.php"
);

break;



case "Marine Researcher":

header(
"Location: ../dashboard/researcher_dashboard.php"
);

break;



case "Administrator":

header(
"Location: ../dashboard/admin_dashboard.php"
);

break;



default:

echo "Role not recognized";

break;


}



exit();


}



else{


echo "Invalid Login";


}


}


?>



<form method="POST">


Email:

<input type="email" name="email" required>


<br><br>


Password:

<input type="password" name="password" required>


<br><br>


<button name="login">

Login

</button>
<p>
Need an account?
<a href="register.php">
Register
</a>
</p>

</form>