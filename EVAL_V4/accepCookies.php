<?php
session_start();
	if(isset($_GET['id'])){
		
		setcookie("accepter",$_GET['id'],time()+3600);
		header('Location : http://192.168.128.13/~e180810/EVAL_V5/index.php');
	}
?>
