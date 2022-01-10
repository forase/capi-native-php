<?php 
namespace App;
    require __DIR__ . '/vendor/autoload.php';
    use App\Facebook;
    include_once 'facebook/Purchase.php';
    include_once 'facebook/_Pageview.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    if(isset($_POST['submit'])){
        header('Location:pages/purchase.html');
        $data = array();
        $purchase = new Facebook\Purchase($data);
    }
    else{
        header('Location:pages/home.html');
        
        try{
		echo "string";
            $pageview = new Facebook\Pageview();
		echo "string";
        }catch (exception $e){
            echo 'caugt exception', $e->getMessage();
        }
    }
?>
