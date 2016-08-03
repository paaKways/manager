<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin';
check_logged_in_status();
?>

<?php  
	$post = get_post_by_id( $_GET['post'] , false );
	if ( !$post ){
		//missing id
		redirectTo('manage_content.php');
	}
	
	$id = $post['id'];
	
	$query = "DELETE FROM posts WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($link, $query);
	
	if( $result && mysqli_affected_rows($link) == 1 ){
		//Success
		$_SESSION['info'] = "Post Deleted";
		redirectTo('manage_content.php');
	}else{
		$_SESSION['info'] = '<div class="info">Post deletion failed</div>';
		redirectTo('manage_content.php');
	}
	
?>
