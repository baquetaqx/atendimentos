<?php
 
 if (!empty($_GET['file'])) {
    $fileName=basename($_GET['file']);
    $filePath = 'tsqws/arquivos/'.$fileName;
    if (!empty($fileName) && file_exists($filePath)) {
        header("Cache-Control: public");
        header('Content-type: octet/stream');
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header('Content-Length: '.filesize($filePath));
        if (strpos($fileName, "pdf")===0) {
            header("Content-Type: pdf");
        }
        if (strpos($fileName, "jpeg")===0) {
            header("Content-Type: jpeg");
        }
        if (strpos($fileName, "png")===0) {
            header("Content-Type: png");
        }
        if (strpos($fileName, "xls")===0) {
            header("Content-Type: xls");
        }
        if (strpos($fileName, "jpg")===0) {
            header("Content-Type: jpg");
        }
        if (strpos($fileName, "doc")===0) {
            header("Content-Type: doc");
        }
        if (strpos($fileName, "docx")===0) {
            header("Content-Type: docx");
        }
        if (strpos($fileName, "exe")===0) {
            header("Content-Type: exe");
        }
        if (strpos($fileName, "txt")===0) {
            header("Content-Type: txt");
        }

        header("Content-Transfer-Encoding: binary");

    // read the file from disk
        readfile($filePath);
        exit;    
    }
}

?>