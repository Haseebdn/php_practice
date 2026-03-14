<?php

if (isset($_POST) and !empty($_POST)) {

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    // header("location:../php_classes/class2.php ");   // cannot be used simultaneously with print or echo
    header("refresh:3;url=../php_classes/class2.php");
}
?>;