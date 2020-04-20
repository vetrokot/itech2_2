<?php 

require 'db_connect.php';
$cost=$_GET['date1'];

$cost2=$dbh->prepare("SELECT SUM(Cost) AS sum_cost FROM rent WHERE `Date_end` < :cost");
$cost2->bindParam(':cost', $cost, PDO::PARAM_STR);
    $cost2->execute();
	$result=$cost2->fetchAll();
?>

<table border=1>
<tr>
<td>Date</td>
<td>Sum</td>

</tr>
<?php foreach($result as $row){ ?>
<tr>
<td><?php echo $cost; ?></td>
<td><?php echo round($row['sum_cost'], 2); ?></td>

</tr>
<?php } ?>

</table>


