<?php
$files = glob('motifpic/*'); // glob() function searches for all the path names matching pattern
foreach($files as $file){
    if(is_file($file))
        unlink($file); // delete
}

$consensus = $_GET['consensus']; // get your consensus
$consensus_str = '"'.$consensus.'"';
// execute R script from shell
$cmd="Rscript /var/www/html/motifdb/comp.R $consensus_str 2&>1";

$simi=shell_exec($cmd);

    echo "the similarity is $simi";
    echo "<br>";
    echo '<img loading="lazy" alt="your results are not successfully shown,please debug" width="600" height="400" src="motifpic/motifpic.png">';
    echo "<br>";
    echo "to see more detail,you can see";
    echo "<br>";
    echo "<a href='http://59.79.233.205/motifdb/showpic.html'>see more and decide drop it or not</a>";

?>
