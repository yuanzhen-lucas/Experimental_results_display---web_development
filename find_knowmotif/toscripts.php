<?php
$files = glob('output/*'); // glob() function searches for all the path names matching pattern
foreach($files as $file){
    if(is_file($file))
        unlink($file); // delete
}

$consensus = $_GET['consensus']; // get your consensus
$consensus_str = '"'.$consensus.'"';
echo "<br>";
echo "you can clik to see your results";
echo "<br>";
// execute R script from shell
$numb=9;
$cmd="Rscript /var/www/html/motifdb/cons2db.R $consensus_str $numb 2&>1";
shell_exec($cmd);
echo '<a href="http://59.79.233.205/motifdb/output/output.html">results</a>';
?>
