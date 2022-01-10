<?php
    ob_start();
    namespace App;
    require __DIR__ . '/vendor/autoload.php';
    use App\Facebook;
    include_once 'facebook/Purchase.php';
    include_once 'facebook/_Pageview.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    if(isset($_POST['submit'])){
        readfile('pages/purchase.html');
        $data = array();
        $purchase = new Facebook\Purchase($data);
    }
    else{
        readfile('pages/home.html');
        try{
            $pageview = new Facebook\Pageview();
        }catch (exception $e){
            echo 'caugt exception', $e->getMessage();
        }

    }
    ob_end_flush()
?>
