<?php
class Uploader
{
    private $destinationPath;
    private $errorMessage;
    private $extensions;
    private $maxSize;
    private $maxRowCount=20000;
    private $uploadName;
    public $name='Uploader';

    function setDir($path){
        $this->destinationPath  =   $path;
    }

    function setMaxSize($sizeMB){
        $this->maxSize  =   $sizeMB * (1024*1024);
    }

    function setMaxRowCount($sizeRowCount){
        $this->maxRowCount  =   count($sizeRowCount);
    }

    function setExtensions($options){
        $this->extensions   =   $options;
    }

    function setMessage($message){
        $this->errorMessage =   $message;
    }

    function getMessage(){
        return $this->errorMessage;
    }

    function getUploadName(){
        return $this->uploadName;
    }

    function uploadFile($fileBrowse){
        $result =   false;
        $size   =   $_FILES[$fileBrowse]["size"];
        ($size===0)?die():'';
        $name   =   $_FILES[$fileBrowse]["name"];
        $rowCount   =   count(file($_FILES[$fileBrowse]["tmp_name"]));
        $ext    =   pathinfo($name,PATHINFO_EXTENSION);
//        print_r([$size,$name,$rowCount,$ext]);
//        die();
        $this->uploadName=  $name;

        if(empty($name))
        {
            $this->setMessage("File not selected ");
        }
        else if($size>$this->maxSize)
        {
            $this->setMessage("Too large file !");
        }
        else if($rowCount>$this->maxRowCount)
        {
            $this->setMessage("The number of lines in the file is more than 20k.");
        }
        else if(!in_array($ext,$this->extensions))
        {
            $this->setMessage("Invalid file format !");
        }
        else
        {
            if(!is_dir($this->destinationPath))
                mkdir($this->destinationPath);
            if(!is_dir($this->destinationPath.'/'.$ext))
                mkdir($this->destinationPath.'/'.$ext);

            if(file_exists($this->destinationPath.'/'.$ext.'/'.$this->uploadName))
                $this->setMessage("File already exists. !");
            else if(!is_writable($this->destinationPath.'/'.$ext))
                $this->setMessage("Destination is not writable !");
            else
            {
                if(move_uploaded_file($_FILES[$fileBrowse]["tmp_name"],$this->destinationPath.'/'.$ext.'/'.$this->uploadName))
                {
                    $result =   true;
                }
                else
                {
                    $this->setMessage("Upload failed , try later !");
                }
            }
        }
        $this->uploadName=$this->destinationPath.'/'.$ext.'/'.$this->uploadName;
        return $result;
    }

    function deleteUploaded($fileBrowse){
        $name   =   $_FILES[$fileBrowse]["name"];
        $ext    =   pathinfo($name,PATHINFO_EXTENSION);
        unlink($this->destinationPath.'/'.$ext.'/'.$this->uploadName);
    }
}
?>