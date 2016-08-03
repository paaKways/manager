<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php $admin_set = get_all_admins();?>
<?php $layout_context = 'admin'; include('../includes/layouts/header.php');
check_logged_in_status();
?>
		
		<div class="row" id="page-content">				
			<?php include('../includes/layouts/sidebar.php')?>

			<section class="container column col-6" id="main-content">
				<h2>Manage Admins</h2>
				<?php echo info(); ?>
				<table cellspacing="4" border="0">
					<tr>
						<th>Username</th>
						<th>Actions</th>
					</tr>
					<?php
					while( $admin = mysqli_fetch_assoc($admin_set) ){
					?>
					<tr>
						<td><?php echo htmlentities( $admin['username'] );?></td>
						<td><a href="edit_admin.php?id=<?php echo urlencode( $admin['id'] );?>">Edit</a></td>
						<td><a href="delete_admin.php?id=<?php echo urlencode( $admin['id'] );?>" onclick="return confirm('Are you sure you want to delete this admin?');">Remove Admin</a></td>
					</tr>
					<?php } ?>
				</table>
				<br />
				<a href="new_admin.php">Add a new admin.</a>
				
			</section><!--main-content-->
		</div> <!--page-content-->
		
<?php include('../includes/layouts/footer.php');?>	