<?php

include "../includes/auth_check.php";

include "../includes/role_check.php";


checkRole("Administrator");


?>


<h1>
System Administrator Dashboard
</h1>


<h3>

Welcome:

<?php echo $_SESSION['name']; ?>

</h3>


<hr>


<ul>

<li>
Manage Users
</li>


<li>
System Configuration
</li>


<li>
Database Management
</li>


</ul>


<a href="../authentication/logout.php">

Logout

</a>