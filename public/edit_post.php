<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();
?>
<?php $layout_context = 'admin';?>
<?php find_selection(); 

	if( !$post ){
		//post could not be found
		$_SESSION['info'] = 'No post found for selection';
		redirectTo('manage_content.php');
	}
?>
<?php include('../includes/layouts/header.php');

	if( isset( $_POST['submit'] ) ){
	//process the form, clean input

	$post_id = $post['id'];
	$post_title = clean_sql( $_POST['post_title'] );
	$post_cat_id = clean_sql( $_POST['post_cat_id'] );
	$visible = (int) $_POST['visible'];
	$post_content = clean_sql( $_POST['post_content'] );
	$post_excerpt = clean_sql( $_POST['post_excerpt'] );
	
	//Perform query
	$query = "UPDATE posts SET post_title = '{$post_title}', visible = {$visible}, post_content = '{$post_content}', post_excerpt = '{$post_excerpt}', post_cat_id = '{$post_cat_id}' WHERE id = {$post_id} LIMIT 1";
	$result = mysqli_query( $link , $query );
	
	if( $result && mysqli_affected_rows( $link ) >= 0 ){
		//Success
		$_SESSION['info'] = 'The post was successfully edited !';
		redirectTo('manage_content.php');	
		}else {
		//failure
		$info = 'There was a problem submitting the post... !';
		redirectTo('edit_post.php?post='.urlencode( $post['id'] ));
	}	
	
}else{
	//redirect GET requests.
}
?>
		 <div class="row" id="page-content">				
			<?php include('../includes/layouts/sidebar.php')?>

			<section class="container column col-6" id="main-content">
					
		<?php	
				if( !empty( $info ) ){
				echo '<div class="info">'.htmlentities( $info ).'</div>'; }?>
			
			<h2>Edit Post </h2>
			<small>Editing as <?php echo htmlentities( $_SESSION['admin_username'] )?></small>
			<form action="edit_post.php?post=<?php echo urlencode( $post['id'] );?>" method="POST">
				<p>
					Post Title : <input required type="text" name="post_title" value="<?php echo htmlentities( $post['post_title'] );?>" placeholder="Post Title"/>
				</p>
				
				<p>
					<label for="post_cat_id">Post Category</label>
					<select name="post_cat_id" type="dropdown">
						<?php $categories = get_categories( false );
						foreach( $categories as $retrieved_category ){
							$option = '<option';
							if( $retrieved_category['category_id'] == $post['post_cat_id'] ){
								$option .= ' selected value="'.htmlentities( $retrieved_category['category_id'] ).'">';
							}else{
								$option .= ' value="'.htmlentities( $retrieved_category['category_id'] ).'">';
							}
							$option .= htmlentities( $retrieved_category['category_name'] ).'</option>';
							echo $option;
						}
						?></select>
				</p>
				
				<p>
					<label for="visible">Visible</label> 
					Yes <input required type="radio" name="visible" value="1" <?php if( $post['visible'] == 1 )echo 'checked';?>/>
					No <input required type="radio" name="visible" value="0" <?php 	if( $post['visible'] == 0 )echo 'checked';?>/>
				</p>
				
				<p>
					<label for="post_content">Content</label> 
					<textarea id="post-content" placeholder="Post Content" name="post_content"><?php echo htmlentities( $post['post_content'] );?></textarea>
				</p>
				
				<p>
					<label for="post_excerpt">Excerpt ( About 200 characters )</label>
					<textarea id="post-excerpt" placeholder="A brief two line excerpt of post" name="post_excerpt" ><?php echo htmlentities( $post['post_excerpt'] );?></textarea>
				</p>
				
				<a class="submit" href="manage_content.php">Cancel</a>
				<a class="submit" href="delete_post.php?post=<?php echo urlencode( $post['id'] );?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
		
				<input name="submit" type="submit" value="Save Changes"/>
			</form>
			<br/>
			
		</section><!--main-content-->
	</div> <!--page-content-->

<?php include('../includes/layouts/footer.php');?>