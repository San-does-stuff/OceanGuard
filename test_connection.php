<?php

include "config/database.php";


$sql = "SELECT * FROM users";

$result = $conn->query($sql);


while($row = $result->fetch(PDO::FETCH_ASSOC)) {

    echo $row['name'];
    echo "<br>";

}

?>