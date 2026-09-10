<?php


function checkRole($requiredRole)
{


    if(!isset($_SESSION['role'])){


        header(
            "Location: ../authentication/login.php"
        );

        exit();


    }



    if($_SESSION['role'] != $requiredRole){


        echo "Access Denied";

        exit();


    }


}


?>