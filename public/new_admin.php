<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');?>
<?php 

check_logged_in_status();

if( isset($_POST['submit']) ){
	//process the form, clean input

	$password = password_encrypt( $_POST['password'] );
	$username = clean_sql( $_POST['username'] );
	$first_name = clean_sql( $_POST['first_name'] );
	$last_name = clean_sql( $_POST['last_name'] );
	
	//Perform query
	$query = "INSERT INTO `admins` ( username, password, first_name, last_name ) VALUES ( '{$username}', '{$password}', '{$first_name}', '{$last_name}' )";
	$result = mysqli_query( $link , $query );
	
	if( $result && mysqli_affected_rows($link) >= 0 ){
		//Success
		$_SESSION['info'] = 'Admin added successfully';
		redirectTo('manage_admins.php');	
		}
	else{
		//failure
		$info = 'Sorry. Admin was not added !';
		}		
		
}else{
	//redirect GET requests.
}
?>
<?php $layout_context = 'admin';?>
<?php include('../includes/layouts/header.php');?>
			<div class="row" id="page-content">				
				<?php include('../includes/layouts/sidebar.php')?>

				<section class="container column col-6" id="main-content">
				<?php /*any post operation info here */ echo info();?>	<h2>Create An Admin</h2>
					<form action="new_admin.php" method="POST">
						<p>
							<label for="first_name">First Name</label> 
							<input type="text" name="first_name" placeholder="First Name" value=""/>
						</p>
						<p>
							<label for="first_name">Last Name</label> 
							<input type="text" name="last_name" placeholder="Last Name" value=""/>
						</p>
						<p>
							<label for="first_name">Username</label> 	
							<input type="text" name="username" placeholder="Username" value=""/>
						</p>
						<p>
							<label for="first_name">Password</label>
							<input type="password" name="password" placeholder="Password" value=""/>	
						</p>
						
						<a class="submit" href="manage_admins.php">Cancel</a>
						<input type="submit" value="Create Admin" name="submit"/>
					</form>
					<br />
					
				</section><!--main-content-->
			</div> <!--page-content-->
	
<?php include('../includes/layouts/footer.php');?>	