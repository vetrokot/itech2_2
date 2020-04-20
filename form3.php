<?php 
header('Content-Type: text/xml');
    header("Cache-Control: no-cache, must-revalidate");
    echo '<?xml version="1.0" encoding="utf8" ?>';
    echo "<root>";
	
require 'db_connect.php';


$vendor=$_GET['vendorname'];

$car2=$dbh->prepare("SELECT cars.Name AS Name, cars.Race AS Race FROM cars, vendors WHERE vendors.Name=:vendor AND cars.FID_Vendors = vendors.ID_Vendors");
$car2->bindParam(':vendor', $vendor, PDO::PARAM_STR);
    $car2->execute();
	
	$result=$car2->fetchAll(PDO::FETCH_ASSOC);
	 foreach($result as $row)
    {
        echo "<row><Name>$row[Name]</Name><Race>$row[Race]</Race></row>"; 
    }
    
    echo "</root>";
	


	
?>

