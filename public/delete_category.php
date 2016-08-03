<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin';?>
<?php check_logged_in_status();?>
<?php  

	$category = get_category_by_id( $_GET['category'] );
	if ( !$category ){
		//missing id
		$_SESSION['info'] = 'Sorry . No category found for that selection.';
		redirectTo('manage_content.php');
	}
	
	//If I try to delete a category with posts ... don't allow it.
	$post_set =  get_posts_for_category( $category['category_id'] );
	if( mysqli_num_rows( $post_set ) > 0 ){
		$_SESSION['info'] = "Sorry. Cannot delete a category with pages. Delete pages under category first";
		redirectTo("manage_content.php");
	}
	
	$category_id = $category['category_id'];
	
	$query = "DELETE FROM categories WHERE category_id = {$category_id} LIMIT 1";
	$result = mysqli_query( $link, $query );
	
	if( $result && mysqli_affected_rows( $link ) == 1 ){
		//Success
		$_SESSION['info'] = "Category deleted.";
		redirectTo('manage_content.php');
	}else{
		//failure
		$info = '<div class="info">Category deletion failed</div>';
		redirectTo('manage_content.php');
	}
	
?>
