<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php')?>
<?php include('../includes/layouts/header.php')?>
		
			<div class="row" id="page-content">				
				<?php include('../includes/layouts/sidebar.php')?>

				<section class="container column col-6" id="main-content">
					
					<h2>Welcome to this site</h2>
					<p>Recent posts</p>
					
					<div id="recent-posts">
					
						<?php 
						$available_categories = get_categories();
						foreach( $available_categories as $available ){
							$post_cat_id = $available['category_id'];
							$post_set = get_posts_for_category( $post_cat_id );
							
							//$post_set = get_posts();
							if( mysqli_num_rows( $post_set ) > 0 ){
								display_posts( $post_set );
							}
						}
						/*else{
							echo 'No posts yet';
						}*/
						
						?>			
					
					</div><!--recent-posts-->
					
				</section><!--main-content-->
				
			
			</div> <!--page-content-->
		</div><!--outer-->
		
<?php include('../includes/layouts/footer.php')?>