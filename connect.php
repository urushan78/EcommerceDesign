<?php $conn = oci_connect('77227238', 'Nepal123$', '//localhost/xe'); 

    if (!$conn) {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;
    }
?>