<?php

session_start();

include "../includes/role_check.php";
include "../config/database.php";


checkRole("Administrator");



// ===============================
// UPDATE USER ROLE
// ===============================

if(isset($_POST['update_role'])){


    $user_id = $_POST['user_id'];

    $role = $_POST['role'];



    $sql = "

    UPDATE users

    SET role = ?

    WHERE user_id = ?

    ";



    $stmt = $conn->prepare($sql);


    $stmt->execute([

        $role,

        $user_id

    ]);



    echo "

    <script>

    alert('User role updated successfully.');

    window.location='manage_users.php';

    </script>

    ";


    exit();

}





// ===============================
// DELETE USER
// ===============================


if(isset($_GET['delete'])){


    $delete_id = $_GET['delete'];



    // Prevent deleting yourself

    if($delete_id == $_SESSION['user_id']){


        echo "

        <script>

        alert('You cannot delete your own administrator account.');

        window.location='manage_users.php';

        </script>

        ";


        exit();

    }




    $sql = "

    DELETE FROM users

    WHERE user_id = ?

    ";



    $stmt = $conn->prepare($sql);



    $stmt->execute([

        $delete_id

    ]);




    echo "

    <script>

    alert('User deleted successfully.');

    window.location='manage_users.php';

    </script>

    ";


    exit();


}





// ===============================
// FETCH USERS
// ===============================


$sql = "

SELECT *

FROM users

ORDER BY user_id DESC

";



$stmt = $conn->prepare($sql);


$stmt->execute();



$users = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>

<html>


<head>


<title>

Manage Users

</title>



<style>


body{

font-family:Arial;

}



table{

border-collapse:collapse;

width:90%;

}



th,td{

border:1px solid #ccc;

padding:10px;

text-align:center;

}



button{

padding:6px 10px;

cursor:pointer;

}



.update{

background:#28a745;

color:white;

border:none;

}



.delete{

background:#dc3545;

color:white;

border:none;

}



select{

padding:5px;

}



</style>


</head>



<body>



<h1>

User Management

</h1>



<a href="../dashboard/admin_dashboard.php">

Back to Dashboard

</a>



<br><br>



<table>



<tr>

<th>
ID
</th>


<th>
Name
</th>


<th>
Email
</th>


<th>
Role
</th>


<th>
Update
</th>


<th>
Delete
</th>

</tr>





<?php foreach($users as $user): ?>



<tr>



<td>

<?= htmlspecialchars($user['user_id']); ?>

</td>




<td>

<?= htmlspecialchars($user['name']); ?>

</td>




<td>

<?= htmlspecialchars($user['email']); ?>

</td>




<td>


<form method="POST">



<input 
type="hidden"
name="user_id"
value="<?= $user['user_id']; ?>">



<select name="role">



<option value="Community Member"

<?= ($user['role']=="Community Member") ? "selected" : ""; ?>

>

Community Member

</option>



<option value="Environmental Officer"

<?= ($user['role']=="Environmental Officer") ? "selected" : ""; ?>

>

Environmental Officer

</option>



<option value="Cleanup Coordinator"

<?= ($user['role']=="Cleanup Coordinator") ? "selected" : ""; ?>

>

Cleanup Coordinator

</option>



<option value="Marine Researcher"

<?= ($user['role']=="Marine Researcher") ? "selected" : ""; ?>

>

Marine Researcher

</option>



<option value="Administrator"

<?= ($user['role']=="Administrator") ? "selected" : ""; ?>

>

Administrator

</option>



</select>



</td>




<td>



<button 

type="submit"

name="update_role"

class="update"

>

Save

</button>



</form>



</td>





<td>


<?php if($user['user_id'] != $_SESSION['user_id']): ?>



<button

class="delete"

onclick="deleteUser(<?= $user['user_id']; ?>)"

>

Delete

</button>



<?php else: ?>


<strong>

Current Account

</strong>


<?php endif; ?>



</td>



</tr>



<?php endforeach; ?>



</table>




<script>


function deleteUser(id){


let confirmDelete = confirm(

"Are you sure you want to delete this user?"

);



if(confirmDelete){


window.location = 

"manage_users.php?delete=" + id;


}


}


</script>



</body>


</html>