<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();
?>

<?php $layout_context = 'admin';?>

<?php find_selection(); 

	/*if( !$category ){
		//subject_id could not be found
		$_SESSION['info'] = 'No category found for selection';
		redirectTo('manage_content.php');
	}*/
?>
<?php include('../includes/layouts/header.php');?>
<?php
	
	if( isset( $_POST['submit'] ) ){
	//process the form, clean input

	$category_id = $category['category_id'];
	$category_name = clean_sql( $_POST['category_name'] );
	$visible = (int) $_POST['visible'];
	 
	//Perform query
	$query = "UPDATE categories SET category_name = '{$category_name}', visible = {$visible} WHERE category_id = {$category_id} LIMIT 1";
	$result = mysqli_query( $link , $query );
	
	if( $result && mysqli_affected_rows( $link ) >= 0 ){
		//Success
		$_SESSION['info'] = 'Category info updated successfully!';
		redirectTo('manage_content.php');	}
	else{
		//failure
		$info = 'There was an error updating the category information ...';
		redirectTo('edit_category.php?category='.urlencode( $category['category_id'] ) );
	}	
	
}else{
	//shooo! Get away, GET requests!!! **redirect GET requests.	
}
?>
	<div class="row" id="page-content">				
			<?php include('../includes/layouts/sidebar.php')?>

			<section class="container column col-6" id="main-content">
				<?php
				if( !empty( $info ) ){
					echo '<div class="info">'.htmlentities( $info ).'</div>';
				}?>
				
				<h2>Edit Category</h2>
				<form action="edit_category.php?category=<?php echo urlencode( $category['category_id'] );?>" method="POST">
					<p>
						Category Name :<input required type="text" name="category_name" value="<?php echo htmlentities( $category['category_name'] );?>" placeholder="Category Name"/>
					</p>
					
					<p>Visible : 
						Yes<input required type="radio" name="visible" value="1"<?php if( $category['visible'] == 1 )echo 'checked';?>/>
						No<input required type="radio" name="visible" value="0" <?php if( $category['visible'] == 0 )echo 'checked';?>/>
					</p>
					
					<a class="submit" href="manage_content.php">Cancel</a>
					<a class="submit" href="delete_category.php?category=<?php echo urlencode($category['category_id']);?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
					<input name="submit" type="submit" value="Save Changes"/>
				</form>
						
			</section><!--main-content-->
		</div> <!--page-content-->
		


<?php include('../includes/layouts/footer.php');?>