<?php

// error report
ini_set('desplay_error', 'on');

error_reporting(E_ALL);

include 'admin/connect.php';

$sessionuser = '';

if(isset($_SESSION['user'])) {

	$sessionuser = $_SESSION['user'];
}


// pathes & roots

$tmp1 = 'includes/templets/'; //templet header & footer directory 

$lang = 'includes/langs/'; 

$func = 'includes/functions/'; // functions directory

$css = 'Design/css/'; // Css directory 

$js = 'Design/js/'; // js directory 



// imortant files 

include $func . 'function.php';

 include $lang . 'english.php'; // must be file language first

 include $tmp1 . "header.php";
