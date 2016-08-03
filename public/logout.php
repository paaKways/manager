<?php require_once('../includes/session.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();?>
<?php
	//Session is active at the beginning.
	$_SESSION['admin_id'] = null;
	$_SESSION['admin_username'] = null;
	redirectTo('login.php');

?>