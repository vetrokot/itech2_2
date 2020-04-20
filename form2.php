<?php 

require 'db_connect.php';

$car=$_GET['date2'];
$car2=$dbh->prepare("SELECT Name, Price FROM cars WHERE ID_Cars NOT IN (SELECT FID_Car FROM rent WHERE (rent.Date_start<:date2 OR rent.Date_end>:date2))");
$car2->bindParam(':date2', $car, PDO::PARAM_STR);
    $car2->execute();
	$result=$car2->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode ($result);
?>


