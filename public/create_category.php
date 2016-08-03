<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin';?>

<?php if( isset( $_POST['submit'] ) ){
	//process the form, clean input

	$category_name = clean_sql( $_POST['category_name'] );
	$category_id = clean_sql( $_POST['category_id'] );
	$visible = (int) $_POST['visible'];
	
	//Perform query
	$query = "INSERT INTO categories ( category_name , category_id , visible , created ) VALUES ( '{$category_name}' , {$category_id} , {$visible} , NOW() ) ";
	$result = mysqli_query( $link , $query );
	
	if( $result ){
		//Success
		$_SESSION['info'] = 'Category created successfully!';
		redirectTo('manage_content.php');
	}
	else{
		//failure
		$_SESSION['info'] = 'There was an error adding the new category ...';
		redirectTo('new_category.php');
	}	
}else{
	//redirect GET requests.
		redirectTo('new_category.php');
}

if( isset( $link )){
	mysqli_close( $link );
	} 
?>