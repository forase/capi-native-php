<?php
    namespace App;

    require __DIR__ . '/vendor/autoload.php';
    use App\Facebook;
    // include_once 'facebook/Purchase.php';
    include_once 'facebook/_Pageview.php';

    $path = Config;
    echo $path;

    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    if(isset($_POST['submit'])){
        readfile('pages/purchase.html');
        // $purchase = new Purchase();
    }
    else{
        readfile('pages/home.html');
        try{
            // include 'facebook/pageview.php';
            $pageview = new Facebook\Pageview();
        }catch (exception $e){
            echo 'caugt exception', $e->getMessage();
        }

    }
?>
