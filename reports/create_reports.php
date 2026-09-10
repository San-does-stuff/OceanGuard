<?php

session_start();

include "../config/database.php";


if(!isset($_SESSION['user_id'])){

    header("Location: ../authentication/login.php");

    exit();

}



if(isset($_POST['submit'])){


    $user_id = $_SESSION['user_id'];

    $title = $_POST['title'];

    $description = $_POST['description'];

    $pollution_type = $_POST['pollution_type'];

    $location = $_POST['location'];

    $latitude = $_POST['latitude'];

    $longitude = $_POST['longitude'];



    $image = null;



    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){


        $image_name = time() . "_" . $_FILES['image']['name'];


        $target = "../uploads/" . $image_name;


        move_uploaded_file(

            $_FILES['image']['tmp_name'],

            $target

        );


        $image = $image_name;

    }




    $status = "Pending Verification";



    $sql = "INSERT INTO pollution_report

    (
    user_id,
    title,
    description,
    pollution_type,
    location,
    latitude,
    longitude,
    image,
    status
    )

    VALUES

    (?,?,?,?,?,?,?,?,?)";



    $stmt = $conn->prepare($sql);



    $stmt->execute([

        $user_id,

        $title,

        $description,

        $pollution_type,

        $location,

        $latitude,

        $longitude,

        $image,

        $status

    ]);



    echo "Report Submitted Successfully";


}


?>



<h2>
Submit Pollution Report
</h2>



<form method="POST" enctype="multipart/form-data">


Title:

<br>

<input type="text" name="title" required>


<br><br>



Description:

<br>

<textarea name="description"></textarea>


<br><br>



Pollution Type:

<br>


<select name="pollution_type">


<option>
Plastic Waste
</option>


<option>
Oil Spill
</option>


<option>
Chemical Pollution
</option>


<option>
Other
</option>


</select>


<br><br>



Location:

<br>

<input type="text" name="location">


<br><br>



Latitude:

<br>

<input type="text" name="latitude">


<br><br>



Longitude:

<br>

<input type="text" name="longitude">


<br><br>



Upload Evidence:

<br>

<input type="file" name="image">


<br><br>



<button name="submit">

Submit Report

</button>


</form>