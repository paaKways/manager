<?php require_once('../includes/session.php');?>
<?php require_once('../includes/functions.php');?>
<?php $layout_context = 'admin';?>
<?php include('../includes/layouts/header.php');
check_logged_in_status();
?>
	<div class="row" id="page-content">				
		<!--Sidebar-->
		<?php include('../includes/layouts/sidebar.php')?>

		<section class="container column col-6" id="main-content">
			<h2>Admin Menu</h2>
			<p>Welcome to Admin area<?php echo ', '.htmlentities( $_SESSION['admin_first_name'] );?>.</p>
			
			<ul>
				<li><a href="manage_content.php">Manage Website Content</a></li>
				<li><a href="manage_admins.php">Managing Admin Users</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</section>

	</div>	
<?php include('../includes/layouts/footer.php');?>