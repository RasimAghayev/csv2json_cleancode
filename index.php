
<form method="post" enctype="multipart/form-data">
    <div>
        <span>Choose file</span>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br/>
        <input type="submit" name="fupload" id="fupload">
    </div>
</form>
<?php
include ('class/Uploader.php');
include ('class/FileProccessing.php');
if(isset($_POST['fupload'])) {
    $uploader = new Uploader();
    $uploader->setDir('uploads');
    $uploader->setExtensions(array('csv'));  //allowed extensions list//
    $uploader->setMaxSize(3);                          //set max file size to be allowed in MB//
    $fileProccesing = new FileProccessing();

    if ($uploader->uploadFile('fileToUpload')) {   //fileToUpload is the file browse element name //
        $csv = $uploader->getUploadName(); //get uploaded file name, renames on upload//
        echo $csv." successfully uploaded";
        $fileProccesing->readLineCSV(__DIR__.'/'.$csv);
    } else {//upload failed
        echo $uploader->getMessage(); //get upload error message
    }
}
?>