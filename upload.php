<?php

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] .'/ApresentacaoSirNelsonNovais24844/assets/';
        
        $dest_path = $uploadFileDir . $newFileName;

        if(move_uploaded_file($fileTmpPath, $dest_path))
        {
            echo "done";
            header('Location: uplink.php');
        }
        else
        {
            echo "error";
        }
        }
    }
?>