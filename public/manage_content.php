<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin';?>
<?php include('../includes/layouts/header.php');
check_logged_in_status(); 
?>
		<div class="row" id="page-content">				
				<?php include('../includes/layouts/sidebar.php')?>

	 			<section class="container column col-7" id="main-content">

					<a class="submit" href="" onclick='return window.history.back();'>&larr; Go Back</a>
					<h2>Manage Content</h2>
					<h3><u>Categories</u></h3>
					<?php echo info(); ?>
					<?php 
						$categories = get_categories( false );
						if( mysqli_num_rows( $categories ) > 0 ){								
						echo '<table id="categories" cellspacing="4"  border="0">
						<thead> 
							<th>Category Name</th>
							<th>Status</th>
							<th>Options</th>
						</thead>
						';
							
							while( $category = mysqli_fetch_assoc( $categories ) ){
								if( $category['category_id'] != 0 ){
								echo '<tr><td class="category-name">'.htmlentities( $category['category_name'] ).'</td>
								<td class="category-status">'.( htmlentities( $category['visible'] ) == 1 ? 'Visible' : 'Not Visible' ) .'</td>
								<td> <a href="edit_category.php?category='.urlencode( $category['category_id'] ).'">Edit</a> </td>
								<td> <a href="delete_category.php?category='.urlencode( $category['category_id'] ).'" onclick="return confirm(\'Are you sure you want to delete this category?\');">Remove</a> </td>
								<td> <a href="new_post.php?category='.urlencode( $category['category_id'] ).'">Add a post under this category</a></td>
								</tr>';
								}
							} 
							echo '</table><!--/categories--> <a href="new_category.php">Add a new category</a>';
						}else {
							echo 'No Categories yet';
						}?>
						
						<h3><u>Posts</u></h3>
						<?php 
						$posts = get_posts( false );
						if( mysqli_num_rows( $posts ) > 0 ){								
						
						echo '<table id="posts" cellspacing="4"  border="0">
						<thead> 
							<th>Category</th>
							<th>Post Title</th>
							<th>Post Author</th>
							<th>Status</th>
							<th>Options</th>
						</thead>
						';
							
							while( $post = mysqli_fetch_assoc( $posts ) ){
								$category_name = find_category_name( $post['post_cat_id'] , false ); //relate posts to their categories using post_cat_id
								echo '<tr><td class="post-category">'.htmlentities( $category_name ).'</td>
								<td class="post-title">'.htmlentities( $post['post_title'] ).'</td>
								<td class="post-author">'.htmlentities( $post['author'] ).'</td>
								<td class="post-status">'.( htmlentities( $post['visible'] ) == 1 ? 'Visible' : 'Not Visible' ) .'</td>
								<td> <a href="edit_post.php?post='.urlencode( $post['id'] ).'">Edit</a> </td>
								<td> <a href="delete_post.php?post='.urlencode( $post['id'] ).'" onclick="return confirm(\'Are you sure you want to delete this post?\');">Remove</a> </td>
								</tr>';
							} 
						}else{
							echo 'No Posts yet<br/>';
						}
						echo '</table> <a href="new_post.php">Add a new post</a>';
						?>
					
					
				</section><!--main-content-->
			</div> <!--page-content-->
		
		

			<script src='js/jquery-1.9.1.min.js'></script>
			<script src="js/stacktable.min.js" ></script>
			<script>
				$('table').stacktable();
			</script>
<?php include('../includes/layouts/footer.php');?>