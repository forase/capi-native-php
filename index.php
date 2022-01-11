<?php namespace App;
    require __DIR__ . '/vendor/autoload.php';
    use App\Facebook;
    include_once 'facebook/Purchase.php';
    include_once 'facebook/Pageview.php';
    error_reporting(E_ALL ^ E_DEPRECATED);
    ini_set('display_errors', 'on');
    if(isset($_POST['submit'])){
        include'pages/purchase.html';
        try{
            $data = array();
            $purchase = new Facebook\Purchase($data);
        }catch (exception $e){
            echo 'caugt exception', $e->getMessage();
        }
    }
    else{
        include'pages/home.html';
        try{
            $pageview = new Facebook\Pageview();
        }catch (exception $e){
            echo 'caugt exception', $e->getMessage();
        }
    }
?>
