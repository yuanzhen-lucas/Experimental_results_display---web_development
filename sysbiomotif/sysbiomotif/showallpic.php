<?php

$hostdir=dirname(__FILE__).'/motifindex/';


$url = '/sysbiomotif/motifindex/';

$filesnames = scandir($hostdir);

// print_r($filesnames);exit;


$www = 'http://59.79.233.205';

foreach ($filesnames as $name) {
    if($name != '.' && $name != '..'){
        echo "<style>
              .test{
                         float: left;
                 width: 25%;
                 box-sizing: border-box;
                 padding: 10px;
                 min-width: 150px;
             }
             
             .container{
                         width: 100%;
             }
             
             @media (max-width:615px ) {
                         .test{
                                 float: left;
                    width: 33%;
                     box-sizing: border-box;
                     padding: 10px;
                     min-width: 150px;
                 }
             }
             
             @media (max-width:465px ) {
                         .test{
                                 float: left;
                     width: 50%;
                     box-sizing: border-box;
                     padding: 10px;
                     min-width: 150px;
                 }
            }
             
            @media (max-width:315px ) {
                        .test{
                                 float: left;
                     width: 100%;
                     box-sizing: border-box;
                     padding: 10px;
                     
                }
             }
             
         </style>";
        echo '<script src="http://59.79.233.205/sysbiomotif/jquery.min.js"></script>';
        echo '   <style type="text/css">
        img {
            transition:transform 0.25s ease;
        }

        img:hover {
            -webkit-transform:scale(3);
            transform:scale(3);
        }
    </style>';
//        $aurl= "<img width='100' height='100' src='".$www.$url.$name."' alt = '".$name."'>";
        echo '<div class="container" style="text-align: center">
                    <div class="test" >
                         <img src='.$www.$url.$name.' style="max-width: 100%;"/>
                       <h4>'.$name.'</h4>
             </div>
        </div>';
//        echo $aurl . "<br/>";
    }

}


?>

