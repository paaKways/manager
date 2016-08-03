<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();
?>
<?php $layout_context = 'admin';?>
<?php 
	find_selection(); 
	/*if( !$category ){
		//category_id could not be found
		$_SESSION['info'] = 'Saved to Uncategorised';
	}*/
	
?>
<?php include('../includes/layouts/header.php');?>

<?php if( isset( $_POST['submit'] ) ){
	//process the form, clean input
	
	if( $_GET['category'] == 0 && isset( $_POST['post_cat_id'] ) ) {
		//if I'm adding a post to database without a category, then give it a category I choose in new_post.php form.. otherwise..
		$post_cat_id = clean_sql( $_POST['post_cat_id'] );
		$info = 'true';
	}else{
		//... set the category to 'Uncategorised'
		$post_cat_id = clean_sql( $_GET['category'] );
	}
	
	$post_title = clean_sql( $_POST['post_title'] );
	$visible = (int) $_POST['visible'];
	$post_content = clean_sql( $_POST['post_content'] );
	$post_excerpt = clean_sql( $_POST['post_excerpt'] );
	$author = $_SESSION['admin_first_name'];
	 
	//Perform query
	$query = "INSERT INTO `posts` ( post_title , post_content , post_excerpt , post_time , visible , post_cat_id , author ) VALUES ( '{$post_title}', '{$post_content}', '{$post_excerpt}', NOW() , {$visible}, {$post_cat_id}, '{$author}' )";
	$result = mysqli_query( $link , $query );
	
	if( $result && mysqli_affected_rows( $link ) >= 0 ){
		//Success
		$_SESSION['info'] = 'Post added successfully!';
		if( $post_cat_id == 0 ){
			$_SESSION['info'] .= ' Saved to Uncategorised';
		}
		redirectTo('manage_content.php');	
		}
	else{
		//failure
		$info = 'Sorry. Post was not created !';
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
			echo '<div class="info">'.htmlentities( $info ).'</div>';
		}
		?>
		
		<h2>Add a new post <?php echo isset( $category ) ? ('to '.$category['category_name']) : '' ?></h2>
		<?php //if we try to create a post without a category outside our database.?>
		<form action="new_post.php?category=<?php echo !isset( $category['category_id'] ) ? 0 : urlencode( $category['category_id'] ) ;?>" method="POST">
			<p>
				<label for="post_title">Post Title</label>
				<input required type="text" name="post_title" value="" placeholder="Post Title"/>
			</p>
			
			<?php if( !isset( $category ) ){
				echo '<p>
				<label for="post_cat_id">Post Category</label>
				<select name="post_cat_id" type="dropdown">
					<option selected disabled>Choose a category</option>';
					
					$categories = get_categories( false );
					foreach( $categories as $category ){
					echo '<option value="'.htmlentities( $category['category_id'] ).'">'.htmlentities( $category['category_name'] ).'</option>';
					}
				echo '</select>
			</p>';
			} ?>
			
			<p>	
				<label for="visible">Visible</label> 
				Yes <input required type="radio" name="visible" value="1"/>
				No <input required type="radio" name="visible" value="0"/>
			</p>
			
			<p>
				<label for="post_content">Content</label>
				<textarea id="post-content" placeholder="Content" name="post_content"></textarea>
			</p>
			
			<p>
				<label for="post_excerpt">Excerpt ( About 200 characters )</label>
				<textarea id="post-excerpt" placeholder="A brief two-line excerpt of post" name="post_excerpt" ></textarea>
			</p>
			
			<a class="submit" href="manage_content.php"> &larr; Go Back</a>
			<input name="submit" type="submit" value="Create Post"/>
			
		</form>
		
	
		</section><!--main-content-->
	</div> <!--page-content-->


<?php include('../includes/layouts/footer.php');?>