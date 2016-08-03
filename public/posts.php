<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php')?>
<?php include('../includes/layouts/header.php');

find_selection( true );

if( !$post ){
	$info = 'No post found for selection';
}
?>
			<div class="row" id="page-content">				
				<?php include('../includes/layouts/sidebar.php')?>

				<section class="container column col-6" id="main-content">
					
					<h2>Posts</h2>
					
					<?php echo $info;?>
					<small></small>
					
					<div id="single-post">
					
						<?php 
						if( $post ){
							$new_post = get_post_by_id( $post['id'] );
							if(  $new_post ){
								display_single_post( $new_post );
							}
							else{
								echo 'No posts yet';
							}
						}
						?>			
					
					</div><!--single-post-->
					
				</section><!--main-content-->
			</div> <!--page-content-->
		
		
<?php include('../includes/layouts/footer.php')?>