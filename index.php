<?php 
//require __DIR__ . '/vendor/autoload.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    if(isset($_POST['submit'])){
        readfile('pages/purchase.html');
    }
    else{
        readfile('pages/home.html');
        //$pageview = new Pageview();
    }
?>