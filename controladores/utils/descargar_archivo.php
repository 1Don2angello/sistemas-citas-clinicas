<?php

    $file = $_GET["file_path"];

    header("Content-disposition: attachment; filename=" . basename($file));
    header("Content-type: application/vnd.ms-excel");
    readfile($file);

    unlink($file);

?>