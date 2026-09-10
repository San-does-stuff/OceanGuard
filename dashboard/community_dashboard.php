<?php

include "../includes/auth_check.php";

include "../includes/role_check.php";


checkRole("Community Member");


?>


<h1>
OceanGuard Community Dashboard
</h1>


<h3>
Welcome:

<?php echo $_SESSION['name']; ?>

</h3>


<hr>


<h2>Available Actions</h2>


<ul>

<li>
Submit Pollution Report
</li>


<li>
View My Reports
</li>


<li>
Update Profile
</li>


</ul>


<a href="../authentication/logout.php">

Logout

</a>