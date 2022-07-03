<?php

class FileProccessing
{

    public function readLineCSV($fileName){
        if ($file = fopen($fileName, "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                $line=$this->splitCheck($line);
                echo $line.'<br>';
            }
            fclose($file);
        }
    }
    private function splitCheck($line){
        $line=$this->cleanit($line);
        $exp=explode(';',$line);
        if(count($exp)!==4) die('; inaccuracy in distribution.');
        return $line;
    }
    private function cleanit($input){
        return preg_replace('/\"/s', '', $input);
    }
    private function itemName(){

    }
}