<?php

session_start();

include "../includes/role_check.php";

checkRole("Cleanup Coordinator");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Cleanup Coordinator Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<h1>
    Welcome Cleanup Coordinator
</h1>


<p>
    Manage environmental cleanup campaigns and community activities.
</p>



<div class="dashboard-card">

    <h2>
        Cleanup Campaign Management
    </h2>


    <p>
        Create, view, and manage cleanup campaigns.
    </p>


    <a href="../campaigns/create_campaign.php">
        Create Campaign
    </a>


    <br><br>


    <a href="../campaigns/view_campaigns.php">
        View My Campaigns
    </a>

    <br><br>

    <a href="../campaigns/manage_campaign.php">
    Manage Campaigns
    </a>

    <br><br>
    <a href="../campaigns/view_impact.php">

    View Cleanup Impact

    </a>

</div>



</body>

</html>