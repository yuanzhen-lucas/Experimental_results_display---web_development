<?php
/*error_reporting(E_ERROR);
ini_set("display_errors","Off");*/
$name = $_GET['name'];
$tissue = $_GET['tissue'];
$batch = $_GET['batch'];
$consensus = $_GET['consensus']; // get your consensus
$consensus_str = '"'.$consensus.'"';
$name_str = '"'.$name.'"';
$tissue_str = '"'.$tissue.'"';
$batch_str = '"'.$batch.'"';


// execute R script from shell
$cmd="Rscript /var/www/html/sysbiomotif/addmotif.R $name $tissue $batch $consensus_str 2&>1";
shell_exec($cmd);

$dbhost = "localhost";  // mysql sever ip
$dbuser = "root";            // mysql user name
$dbpass = "hbmcsysbio";          // mysql user password

$conn= mysqli_connect($dbhost, $dbuser, $dbpass,"motifdb_yz");
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "<br></br>";
echo "Success: A proper connection to MySQL was made! The motifdb_yz database is great." . PHP_EOL;
echo "<br></br>";
echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;
echo "<br></br>";

/* return name of current default database */
if ($result = mysqli_query($conn, "SELECT DATABASE()")) {
    $row = mysqli_fetch_row($result);
    printf("Default database is %s.\n", $row[0]);
    mysqli_free_result($result);
}

echo "<br></br>";

$sql = "INSERT INTO atimotif_yz (motif,name,tissue,batch,submission_date) VALUES ('$consensus_str','$name_str','$tissue_str','$batch_str',NOW())";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
echo "<br></br>";
echo "Data inserted successfully";
echo "<br></br>";
mysqli_close($conn);
echo "Thank you for your hard work";
echo "<br></br>";
echo "come on";
echo "<br></br>";
echo "let us explore the mystery of plant regeneration and evolution together";

?>
