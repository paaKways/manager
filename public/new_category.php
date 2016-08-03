<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin'; include('../includes/layouts/header.php');
check_logged_in_status();
?>

<?php find_selection(); ?>

			<div class="row" id="page-content">				
				<?php include('../includes/layouts/sidebar.php')?>

				
				<section class="container column col-6" id="main-content">						
				<h2>Add a new category</h2>
				<?php echo info(); ?>	
				<form action="create_category.php" method="POST">
					<p>
						<label for="category_name">Category Name</label> 
						<input required type="text" name="category_name" value="" placeholder="Category Name"/>
					</p>
					
					<p> 
						<label for="visible">Visible</label> 
						Yes<input required type="radio" name="visible" value="1" />
						No<input required type="radio" name="visible" value="0" />
					</p>
					
					<input hidden required type="text" name="category_id" value="<?php echo get_next_category_id();?>"/>
										
					<a class="submit" href="manage_content.php">Cancel</a>
					<input name="submit" type="submit" value="Create Category"/>
				</form>
				<br/>
				<!--a href="new_post.php?category=<?php echo urlencode( $category['category_id'] )?>">Add a post under this category</a-->
			
			</section><!--main-content-->
		</div> <!--page-content-->

<?php include('../includes/layouts/footer.php');?>