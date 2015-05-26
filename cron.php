<?php include "conn.php"; 

//SQL Queries for Status Management.
$expiredsql = "UPDATE `customers` SET `Action`='Give Flyer and Attempt Renewal',`SubStatus`='Expired' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) < 0 and SubStatus != 'Expired'";

$expiringsql = "UPDATE `customers` SET `Action`='Flag and Flyer',`SubStatus`='Expiring Soon' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) between 0 and 30 and SubStatus != 'Expiring Soon'";

$activesql = "UPDATE `customers` SET `Action`='Set Up Flag',`SubStatus`='Active' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) >= 30 and SubStatus != 'Active'";


//Executing the SQL Queries
if ($con->query($expiredsql) === TRUE) {
    $ExpirationResult = "Expired Records Updated";
} 
else {
    $ExpirationResult = "Error updating Expired records: " . $con->error;
}

if ($con->query($expiringsql) === TRUE) {
    $ExpiringResult = "Expiring Records Updated";
} 
else {
    $ExpiringResult = "Error updating Expiring records: " . $con->error;
}

if ($con->query($activesql) === TRUE) {
    $ActiveResult = "Active Records Updated";
} 
else {
    $ActiveResult = "Error updating Active records: " . $con->error;
}

//Echo the Results

echo $ExpirationResult . "<br / >";
echo $ExpiringResult . "<br / >";
echo $ActiveResult . "<br / >";

?>