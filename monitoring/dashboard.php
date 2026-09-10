<?php

session_start();

include "../config/database.php";


// ==========================
// Access Control
// ==========================


if(
!isset($_SESSION['role']) ||
(
$_SESSION['role'] != "Environmental Officer"
&&
$_SESSION['role'] != "Administrator"
&&
$_SESSION['role'] != "Marine Researcher"
)
){

header(
"Location: ../authentication/login.php"
);

exit();

}

// ==========================
// Environmental Insight
// ==========================


$analysisQuery = $conn->query(

"SELECT *

FROM environmental_analysis

ORDER BY created_at DESC

LIMIT 1"

);


$latestAnalysis = $analysisQuery->fetch(PDO::FETCH_ASSOC);


// ==========================
// Dashboard Statistics
// ==========================


// Total reports

$totalQuery = $conn->query(

"SELECT COUNT(*) 
FROM pollution_report"

);

$totalReports = $totalQuery->fetchColumn();




// Verified reports

$verifiedQuery = $conn->query(

"SELECT COUNT(*)
FROM pollution_report
WHERE status='Verified'"

);

$verifiedReports = $verifiedQuery->fetchColumn();




// Pending reports

$pendingQuery = $conn->query(

"SELECT COUNT(*)
FROM pollution_report
WHERE status='Pending Verification'"

);

$pendingReports = $pendingQuery->fetchColumn();




// High risk incidents

$riskQuery = $conn->query(

"SELECT COUNT(*)
FROM environmental_assessment
WHERE risk_level='High'
OR risk_level='Critical'"

);

$highRisk = $riskQuery->fetchColumn();





// ==========================
// Pollution Map Data
// ==========================


$pollutionQuery = $conn->query(

"SELECT

title,

latitude,

longitude,

status,

'pollution' AS type

FROM pollution_report

WHERE latitude IS NOT NULL

AND longitude IS NOT NULL"

);



$pollutionLocations = 
$pollutionQuery->fetchAll(PDO::FETCH_ASSOC);







// ==========================
// Marine Environmental Data
// ==========================


$marineQuery = $conn->query(

"SELECT

parameter,

value,

unit,

latitude,

longitude,

data_type,

'science' AS type

FROM marine_data

WHERE latitude IS NOT NULL

AND longitude IS NOT NULL"

);



$marineLocations = 
$marineQuery->fetchAll(PDO::FETCH_ASSOC);






// Combine Map Data

$mapData = array_merge(

$pollutionLocations,

$marineLocations

);



?>



<!DOCTYPE html>

<html>


<head>


<title>
OceanGuard Environmental Monitoring
</title>



<link rel="stylesheet"

href="https://unpkg.com/leaflet/dist/leaflet.css"

/>



<style>


#map{

height:500px;

width:90%;

}



.card{

display:inline-block;

border:1px solid #ccc;

padding:20px;

margin:10px;

width:180px;

}


</style>



</head>



<body>



<h1>
OceanGuard Environmental Monitoring
</h1>





<div class="card">

<h3>
Total Reports
</h3>

<p>

<?php echo $totalReports; ?>

</p>

</div>





<div class="card">

<h3>
Verified
</h3>

<p>

<?php echo $verifiedReports; ?>

</p>

</div>





<div class="card">

<h3>
Pending
</h3>

<p>

<?php echo $pendingReports; ?>

</p>

</div>





<div class="card">

<h3>
High Risk
</h3>

<p>

<?php echo $highRisk; ?>

</p>

</div>


<div class="card">


<h3>
Environmental Risk
</h3>


<?php if($latestAnalysis){ ?>


<p>

Risk Level:

<strong>

<?php echo $latestAnalysis['risk_level']; ?>

</strong>

</p>


<p>

Score:

<?php echo $latestAnalysis['risk_score']; ?>

/100

</p>


<p>

Reports:

<?php echo $latestAnalysis['total_reports']; ?>

</p>



<p>

Recommendation:

<br>

<?php echo $latestAnalysis['recommendation']; ?>

</p>


<?php }

else{

echo "No analysis available";

}

?>


</div>


<h2>
Environmental Map
</h2>



<div id="map"></div>





<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



<script>


// ==========================
// Initialize Map
// ==========================


var map = L.map('map');



L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png',

{

attribution:'OpenStreetMap'

}

).addTo(map);




// Receive PHP Data


var environmentalData = 
<?php echo json_encode($mapData); ?>;



console.log(
"Environmental Data:",
environmentalData
);




// Store markers

var markers = [];




// Create markers


environmentalData.forEach(function(data){



var latitude = parseFloat(data.latitude);

var longitude = parseFloat(data.longitude);



if(
isNaN(latitude)
||
isNaN(longitude)
){

return;

}




var marker = L.marker([

latitude,

longitude

])

.addTo(map);



markers.push(marker);





// Pollution popup


if(data.type === "pollution"){


marker.bindPopup(

"<b>Pollution Incident</b><br><br>" +

"<b>Title:</b> "

+

data.title

+

"<br><b>Status:</b> "

+

data.status

);


}




// Marine data popup


else{


marker.bindPopup(

"<b>Marine Environmental Data</b><br><br>" +

"<b>Parameter:</b> "

+

data.parameter

+

"<br><b>Value:</b> "

+

data.value

+

" "

+

data.unit

);


}



});




// ==========================
// Auto Zoom to Markers
// ==========================


if(markers.length > 0){


var markerGroup = L.featureGroup(markers);


map.fitBounds(

markerGroup.getBounds(),

{

padding:[50,50]

}

);


}

else{


// Default world view if no markers

map.setView(

[0,0],

2

);


}



</script>



</body>


</html>