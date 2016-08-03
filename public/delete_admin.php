<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();
?>
<?php
	$admin = get_admin_by_id($_GET['id']);
	
	if( !$admin ){
		//missing or invalid admin id.
		redirectTo('manage_admins.php');
	}

	$id = $admin['id'];
	
	//Perform query
	$query = "DELETE FROM `admins` WHERE id = {$id} LIMIT 1";
	$result = mysqli_query( $link , $query );
	
	if( $result && mysqli_affected_rows($link) == 1 ){
		//Success
		$_SESSION['info'] = 'Admin successfully deleted';
		redirectTo('manage_admins.php');	
		}
	else{
		//failure
		$_SESSION['info'] = 'Sorry. Admin deletion failed!';
		redirectTo('manage_admins.php');
	}	
	
?>