<?php
$files = glob('motifpic/*'); // glob() function searches for all the path names matching pattern
foreach($files as $file){
    if(is_file($file))
        unlink($file); // delete
}
$name = $_GET['name'];
$tissue = $_GET['tissue'];
$batch = $_GET['batch'];
$consensus = $_GET['consensus']; // get your consensus
$consensus_str = '"'.$consensus.'"';
$name_str = '"'.$name.'"';
$tissue_str = '"'.$tissue.'"';
$batch_str = '"'.$batch.'"';
$dir = $name.'/'.$tissue.'/'.$batch.'/';
$filedir = scandir($dir);
if(empty($filedir)){
    echo "Warning: You have not saved the data in the current database, please save it directly";
    echo "<br></br>";
    exit();

}else{

    $cmd="Rscript /var/www/html/sysbiomotif/comp.R $name_str $tissue_str $batch_str $consensus_str";
    $simi=shell_exec($cmd);
    echo "the similarity is $simi";
    echo "<br>";
    echo '<img loading="lazy" alt="your results are not successfully shown,please debug" width="600" height="400" src="motifpic/motifpic.png">';
    echo "<br>";

}





?>
