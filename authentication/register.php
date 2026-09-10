<?php

include "../config/database.php";


if(isset($_POST['register'])){


    $name = trim($_POST['name']);

    $email = trim($_POST['email']);

    $password = $_POST['password'];

    $role = $_POST['role'];



    // Check existing email

    $check = $conn->prepare(
        "SELECT * FROM users WHERE email=?"
    );

    $check->execute([$email]);


    if($check->rowCount() > 0){

        echo "Email already exists";

    }

    else{


        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );



        $sql = "INSERT INTO users
                (name,email,password,role)

                VALUES
                (?,?,?,?)";



        $stmt = $conn->prepare($sql);



        $stmt->execute([

            $name,

            $email,

            $hashed_password,

            $role

        ]);



        echo "Registration Successful";


    }


}

?>



<form method="POST">


Name:

<input type="text" name="name" required>


<br><br>


Email:

<input type="email" name="email" required>


<br><br>


Password:

<input type="password" name="password" required>


<br><br>


Role:

<select name="role">


<option value="Community Member">
Community Member
</option>


<option value="Environmental Officer">
Environmental Officer
</option>


<option value="Cleanup Coordinator">
Cleanup Coordinator
</option>


<option value="Marine Researcher">
Marine Researcher
</option>


<option value="Administrator">
Administrator
</option>


</select>


<br><br>


<button name="register">

Register

</button>


</form>