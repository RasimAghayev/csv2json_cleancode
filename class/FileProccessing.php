<?php

class FileProccessing
{
    private $arr=[];
    public function readLineCSV($fileName){
        $count = 0;
        if ($file = fopen($fileName, "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                $line=$this->splitCheck($line);
                $count++;
                echo '<pre>';
                print_r($line);
            }
            fclose($file);
        }
    }
    private function splitCheck($line){
        $line=$this->cleanit($line);
        $exp=explode(';',$line);
        if(count($exp)!==4) die('; inaccuracy in distribution.');
        $exp=$this->itemName($exp);
        return $exp;
    }
    private function cleanit($input){
        return preg_replace('/\"/s', '', $input);
    }
    private function itemName($exp){
        $exp_0=$exp[0];
        if($exp[1]=='Изделия и компоненты'){
            $this->arr[]=['itemName'=>$exp[0]];
        }else{
            $this->parent($exp,$exp_0);
        };
        return $this->arr;
    }
    private function parent($exp,$exp_0){
        if($exp[1]=='Варианты комплектации'){
            $this->arr[]=['parent'=>$exp[0]];
        }else{
            $this->children($exp);
        };
        return $this->arr;
    }
    private function children($exp){
        $exp_0=$exp[0];
        if($exp[1]=='Прямые компоненты'){
            $this->arr[]=['children'=>$exp[0]];
        }
        return $this->arr;
    }

}