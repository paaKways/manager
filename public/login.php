<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
?>
<?php 

 if( isset( $_SESSION['admin_id'] ) ){
	redirectTo('admin.php'); 	 
 }

if( isset( $_POST['submit'] ) ){
	//process the form, clean input

	$username = clean_sql( $_POST['username'] );
	$password = clean_sql( $_POST['password'] );
	 
	$found_admin = attempt_login( $username, $password ); 
	 
	if( $found_admin ) {
		//Success , mark user as logged in.
		$_SESSION['admin_id'] = $found_admin['id'];
		$_SESSION['admin_username'] = $found_admin['username'];
		$_SESSION['admin_first_name'] = $found_admin['first_name'];
		redirectTo('admin.php');
	}else{
		$_SESSION['info'] = 'Failed Login operation';
	}
}else{
	//redirect GET requests.
}
?>
<?php include('../includes/layouts/header.php');?>
	<div class="row" id="page-content">				
		
		<!--Sidebar-->
		<?php include('../includes/layouts/sidebar.php')?>

		<section class="container column col-6" id="main-content">
				
			<h2>Login to Admin</h2>
			<small>Enter a valid username and password to login</small>
					
			<form id="login-form" action="login.php" method="POST">
				<p>
					<label for="username">Username </label>
					<input type="text" name="username" placeholder="Username" value="<?php echo htmlentities( $username );?>" required />
				</p>
				<p>	
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Password" value="" required />	
				</p>
				<input type="submit" value="Log In" name="submit"/>
			</form><!--form-->
			
		</section><!--main-content-->
	</div> <!--page-content-->
			
	
<?php include('../includes/layouts/footer.php');?>	