<?php
require_once("pages/page_header.php");

/* If page does not exist load home page */
// if(!isset($_GET['page'])){
	// $page = "pages/home.php";
// }else{
	// $page = 'pages/'.$_GET['page'];
	$page = 'pages/records.php';
// }

require_once($page);

require_once("pages/page_footer.php");
?>
