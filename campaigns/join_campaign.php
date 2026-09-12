<?php

session_start();


include "../includes/auth_check.php";


// Only Community Members can access

if($_SESSION['role'] != "Community Member"){

    header(
        "Location: ../authentication/login.php"
    );

    exit();

}


include "../config/database.php";





if(isset($_POST['campaign_id'])){


    $campaign_id = $_POST['campaign_id'];


    $user_id = $_SESSION['user_id'];





    // Check if already joined

    $check_sql = "

    SELECT *

    FROM campaign_participant

    WHERE campaign_id = ?

    AND user_id = ?

    ";


    $check_stmt = $conn->prepare($check_sql);


    $check_stmt->execute([

        $campaign_id,

        $user_id

    ]);





    if($check_stmt->rowCount() > 0){


        echo "

        <script>

        alert('You already joined this campaign.');

        window.location='view_available_campaigns.php';

        </script>

        ";


        exit();


    }







    // Insert participation


    $sql = "

    INSERT INTO campaign_participant

    (

        campaign_id,

        user_id

    )


    VALUES

    (

        ?,

        ?

    )

    ";




    $stmt = $conn->prepare($sql);



    if($stmt->execute([

        $campaign_id,

        $user_id

    ])){



        echo "

        <script>

        alert('Successfully joined campaign.');

        window.location='my_participations.php';

        </script>

        ";


    }



    else{


        echo "

        <script>

        alert('Failed to join campaign.');

        window.location='view_available_campaigns.php';

        </script>

        ";


    }



}



else{


    header(
        "Location: view_available_campaigns.php"
    );


}


?>