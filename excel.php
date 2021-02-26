<?php

function exportExcel($filename='ExportExcel',$columns=array(),$data=array(),$replaceDotCol=array()){
    header('Content-Encoding: UTF-8');
    header('Content-Type: text/plain; charset=utf-8');
    header("Content-disposition: attachment; filename=".$filename.".xls");
    echo "\xEF\xBB\xBF"; // UTF-8 BOM

    $say=count($columns);

    echo '<table border="1"><tr>';
    foreach($columns as $v){
        echo '<th style="background-color:#FFA500">'.trim($v).'</th>';
    }
    echo '</tr>';

    foreach($data as $val){
        echo '<tr>';
        for($i=0; $i < $say; $i++){

            if(in_array($i,$replaceDotCol)){
                echo '<td>'.str_replace('.',',',$val[$i]).'</td>';
            }else{
                echo '<td>'.$val[$i].'</td>';
            }
        }
        echo '</tr>';
    }
}