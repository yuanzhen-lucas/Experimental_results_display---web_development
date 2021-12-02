<?php
$q = isset($_GET['q'])? htmlspecialchars($_GET['q']) : '';
if($q=="yes"){
echo "We will run for a few minutes. . . .";
    $cmd="Rscript /var/www/html/motifdb/addmotif.R ";
    $numbm=shell_exec($cmd);
    echo "<br>";
    echo "Thank you for adding new motifs to our database!, There are now $numbm motifs in the database";
}elseif($q=="no"){
echo "Thank you for your hard work";
}else{
echo "You better have your own unique insights";
}
?>
