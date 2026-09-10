<?php

include "../includes/auth_check.php";

include "../includes/role_check.php";


checkRole("Environmental Officer");


?>


<h1>
Environmental Officer Dashboard
</h1>


<h3>
Welcome:

<?php echo $_SESSION['name']; ?>

</h3>


<hr>


<h2>Officer Actions</h2>


<ul>

<li>
View Pollution Reports
</li>


<li>
Verify Environmental Incidents
</li>


<li>
Update Report Status
</li>


<li>
Assign Risk Level
</li>


</ul>


<a href="../authentication/logout.php">

Logout

</a>