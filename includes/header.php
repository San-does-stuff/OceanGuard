<?php

if(session_status() === PHP_SESSION_NONE){

    session_start();

}

?>


<!DOCTYPE html>

<html>


<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
OceanGuard
</title>


<link rel="stylesheet" href="../assets/css/style.css">


</head>



<body>


<header class="navbar">


<div class="logo">

<a href="../index.php">

OceanGuard

</a>

</div>




<nav>


<?php if(isset($_SESSION['role'])): ?>



<?php

$dashboard_link = "../dashboard/";


switch($_SESSION['role']){


    case "Community Member":

        $dashboard_link .= "community_dashboard.php";

        break;



    case "Environmental Officer":

        $dashboard_link .= "officer_dashboard.php";

        break;



    case "Cleanup Coordinator":

        $dashboard_link .= "cleanup_dashboard.php";

        break;



    case "Marine Researcher":

        $dashboard_link .= "researcher_dashboard.php";

        break;



    case "Administrator":

        $dashboard_link .= "admin_dashboard.php";

        break;


}

?>



<a href="<?= $dashboard_link; ?>">

Dashboard

</a>




<a href="../authentication/logout.php">

Logout

</a>



<?php endif; ?>



</nav>



</header>



<main class="container page-content">