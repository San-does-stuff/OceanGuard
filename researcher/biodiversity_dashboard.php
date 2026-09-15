<?php

session_start();


include "../includes/auth_check.php";


// Only researchers and admin

if(
    $_SESSION['role'] != "Marine Researcher" &&
    $_SESSION['role'] != "System Administrator"
){

    header(
        "Location: ../authentication/login.php"
    );

    exit();

}


include "../config/database.php";



// =====================================
// TOTAL OBSERVATIONS
// =====================================


$stmt = $conn->prepare(

"
SELECT COUNT(*)
FROM species_observation
"

);


$stmt->execute();


$total_observations = $stmt->fetchColumn();





// =====================================
// TOTAL SPECIES
// =====================================


$stmt = $conn->prepare(

"
SELECT COUNT(DISTINCT scientific_name)
FROM species_observation
"

);


$stmt->execute();


$total_species = $stmt->fetchColumn();





// =====================================
// MOST OBSERVED SPECIES
// =====================================


$stmt = $conn->prepare(

"
SELECT

species_name,

scientific_name,

COUNT(*) AS total


FROM species_observation


GROUP BY scientific_name


ORDER BY total DESC


LIMIT 1

"

);


$stmt->execute();


$top_species = $stmt->fetch(PDO::FETCH_ASSOC);





// =====================================
// BIODIVERSITY RISK SUMMARY
// =====================================


$stmt = $conn->prepare(

"
SELECT

risk_level,

COUNT(*) AS total


FROM biodiversity_analysis


GROUP BY risk_level

"

);


$stmt->execute();


$risk_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Default values

$risk_data = [

    "Critical" => 0,

    "High" => 0,

    "Medium" => 0,

    "Low-Medium" => 0,

    "Low" => 0,

    "Unknown" => 0

];



foreach($risk_summary as $risk){

    $risk_data[$risk['risk_level']] = $risk['total'];

}





// =====================================
// OBSERVATION TIMELINE
// =====================================


$stmt = $conn->prepare(

"

SELECT

YEAR(observation_date) AS year,

COUNT(*) AS total


FROM species_observation


WHERE observation_date IS NOT NULL


GROUP BY YEAR(observation_date)


ORDER BY year

"

);


$stmt->execute();


$timeline = $stmt->fetchAll(PDO::FETCH_ASSOC);





// =====================================
// OBSERVATION RECORDS
// =====================================


$stmt = $conn->prepare(

"

SELECT

species_name,

scientific_name,

latitude,

longitude,

observation_date


FROM species_observation


ORDER BY observation_date DESC


LIMIT 20

"

);


$stmt->execute();


$observations = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Convert for Leaflet

$map_data = json_encode($observations);



?>



<!DOCTYPE html>

<html>


<head>


<title>
Marine Biodiversity Dashboard
</title>



<link rel="stylesheet"

href="https://unpkg.com/leaflet/dist/leaflet.css"
/>


<script src="https://unpkg.com/leaflet/dist/leaflet.js">

</script>




<style>


body{

font-family:Arial, sans-serif;

background:#f4f8fb;

padding:20px;

}



h1,h2{

color:#003b5c;

}



.dashboard{

display:flex;

flex-wrap:wrap;

gap:20px;

}



.card{

background:white;

border-radius:10px;

padding:20px;

width:250px;

box-shadow:0px 2px 5px #ccc;

}



.card h3{

color:#0077b6;

}



.risk-card{

border-left:8px solid #0077b6;

}



#map{

height:500px;

width:90%;

margin-top:20px;

border-radius:10px;

}



table{

border-collapse:collapse;

width:90%;

background:white;

}



th{

background:#0077b6;

color:white;

}



td,th{

border:1px solid #ddd;

padding:10px;

}


</style>


</head>



<body>



<h1>
Marine Biodiversity Monitoring
</h1>



<p>
Live biodiversity data integrated from OBIS API.
</p>





<!-- =========================
SUMMARY CARDS
========================= -->


<div class="dashboard">



<div class="card">

<h3>
Total Observations
</h3>


<h2>

<?php echo $total_observations; ?>

</h2>


</div>





<div class="card">

<h3>
Species Recorded
</h3>


<h2>

<?php echo $total_species; ?>

</h2>


</div>





<div class="card">

<h3>
Most Observed Species
</h3>


<h2>

<?php

echo $top_species['species_name'] ?? "N/A";

?>

</h2>


<p>

Records:

<?php

echo $top_species['total'] ?? 0;

?>

</p>


</div>



</div>





<!-- =========================
RISK ANALYSIS
========================= -->


<h2>

Biodiversity Risk Assessment

</h2>



<div class="dashboard">



<div class="card risk-card">

<h3>
Critical Risk
</h3>


<h2>

<?php echo $risk_data["Critical"]; ?>

</h2>


<p>
Critically endangered observations
</p>


</div>





<div class="card risk-card">

<h3>
High Risk
</h3>


<h2>

<?php echo $risk_data["High"]; ?>

</h2>


<p>
Endangered observations
</p>


</div>





<div class="card risk-card">

<h3>
Medium Risk
</h3>


<h2>

<?php echo $risk_data["Medium"]; ?>

</h2>


<p>
Vulnerable observations
</p>


</div>





<div class="card risk-card">

<h3>
Low Risk
</h3>


<h2>

<?php echo $risk_data["Low"]; ?>

</h2>


<p>
Least concern observations
</p>


</div>



</div>







<h2>

Biodiversity Observation Map

</h2>



<div id="map"></div>






<h2>

Observation Timeline

</h2>




<table>


<tr>

<th>
Year
</th>


<th>
Observations
</th>


</tr>



<?php foreach($timeline as $row){ ?>


<tr>


<td>

<?php echo $row['year']; ?>

</td>


<td>

<?php echo $row['total']; ?>

</td>


</tr>


<?php } ?>


</table>






<h2>

Recent OBIS Observations

</h2>





<table>


<tr>

<th>
Species
</th>


<th>
Scientific Name
</th>


<th>
Latitude
</th>


<th>
Longitude
</th>


<th>
Date
</th>


</tr>




<?php foreach($observations as $row){ ?>


<tr>


<td>

<?php echo $row['species_name']; ?>

</td>


<td>

<?php echo $row['scientific_name']; ?>

</td>


<td>

<?php echo $row['latitude']; ?>

</td>


<td>

<?php echo $row['longitude']; ?>

</td>


<td>

<?php echo $row['observation_date']; ?>

</td>


</tr>


<?php } ?>



</table>







<script>


var map = L.map('map')

.setView(

[0,0],

2

);



L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png',

{

attribution:
'© OpenStreetMap contributors'

}

).addTo(map);




var observations =

<?php echo $map_data; ?>;



var markers=[];



observations.forEach(function(data){



if(

data.latitude &&
data.longitude

){



var marker = L.marker(

[

data.latitude,

data.longitude

]

)

.addTo(map);



marker.bindPopup(

`

<b>

${data.species_name}

</b>

<br>

Scientific Name:

${data.scientific_name}

<br>

Observed:

${data.observation_date}

<br>

Source:

OBIS

`

);



markers.push(marker);



}


});





if(markers.length > 0){


var group = new L.featureGroup(markers);


map.fitBounds(

group.getBounds()

);


}



</script>




</body>


</html>