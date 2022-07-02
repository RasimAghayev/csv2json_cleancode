<?php

$uploader   =   new Uploader();
$uploader->setDir('uploads/csv/');
$uploader->setExtensions(array('csv'));  //allowed extensions list//
$uploader->setMaxSize(.5);                          //set max file size to be allowed in MB//

if($uploader->uploadFile('txtFile')){   //txtFile is the filebrowse element name //
    $image  =   $uploader->getUploadName(); //get uploaded file name, renames on upload//

}else{//upload failed
    $uploader->getMessage(); //get upload error message
}


?>