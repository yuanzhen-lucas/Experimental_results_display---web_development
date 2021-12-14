<?php
/*error_reporting(E_ERROR);
ini_set("display_errors","Off");*/
$qname = $_GET['qname'];
$name_str = '"'.$qname.'"';

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





// Formulate Query
// This is the best way to perform an SQL query
// For more examples, see mysql_real_escape_string()
$query = sprintf("SELECT motif,name,tissue,batch,submission_date FROM atimotif_yz
    WHERE name='%s' OR tissue='%s'" ,
    mysqli_real_escape_string($conn,$qname),
    mysqli_real_escape_string($conn,$qname))
;
// Perform Query
$result = mysqli_query($conn,$query);

// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysqli_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

// Use result
// Attempting to print $result won't allow access to information in the resource
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
while ($row = mysqli_fetch_assoc($result)) {
    echo "<h2>your results</h2>";
    echo $row['motif'];
    echo "<br></br>";
    echo $row['name'];
    echo "<br></br>";
    echo $row['tissue'];
    echo "<br></br>";
    echo $row['batch'];
    echo "<br></br>";
    echo $row['submission_date'];
}

// Free the resources associated with the result set
// This is done automatically at the end of the script
mysqli_free_result($result);



mysqli_close($conn);




?>
