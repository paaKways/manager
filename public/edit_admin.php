<?php require_once('../includes/session.php');?>
<?php require_once('../includes/connection.php');?>
<?php require_once('../includes/functions.php');
check_logged_in_status();
?>

<?php
	if( isset( $_GET['id'] ) ) {
		$admin = get_admin_by_id( $_GET['id'] );
		$info = null;
	}
	else if( !$admin ){
		//missing or invalid admin id.
		redirectTo('manage_admins.php');
	}
?>
<?php
if( isset( $_POST['submit'] ) ){
	$id = $admin['id'];
	$first_name = clean_sql( $_POST['first_name'] );
	$last_name = clean_sql( $_POST['last_name'] );
	$username = clean_sql( $_POST['username'] );
	$password = password_encrypt( $_POST['password'] );
	
	//Perform query
	$query= "UPDATE `admins` SET username = '{$username}', password = '{$password}', first_name = '{$first_name}', last_name = '{$last_name}' WHERE id = {$id} LIMIT 1";
	$result = mysqli_query( $link , $query );

	if( $result && mysqli_affected_rows( $link ) >= 0 ){
		//Success
		$_SESSION['info'] = 'Admin credentials successfully updated';
		redirectTo('manage_admins.php');	
		}
	else{
		//failure
		$info = 'Sorry. Admin credentials could not updated ...';
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
							
				<?php echo info(); echo $info; ?>
				<h2>Edit Admin Credentials</h2>
				<form action="edit_admin.php?id=<?php echo urlencode( $admin['id'] );?>" method="POST">
					<p>
						<label for="first_name" >First Name</label>
						<input type="text" name="first_name" placeholder="First name" value="<?php echo htmlentities( $admin['first_name'] );?>"/>
					</p>	
					<p>
						<label for="last_name" >Last Name</label>
						<input type="text" name="last_name" placeholder="Last name" value="<?php echo htmlentities( $admin['last_name'] );?>"/>
					</p>
					<p> <label for="username" >Username</label> <input type="text" name="username" placeholder="Username" value="<?php echo htmlentities( $admin['username'] );?>"/></p>
					<p> <label for="password" >Password</label> <input type="password" name="password" placeholder="Password" value=""/></p>
					
					<a class="submit" href="manage_admins.php">Cancel</a>
					<input type="submit" value="Save Changes" name="submit"/>
				</form>
			
			</section><!--main-content-->
		</div> <!--page-content-->
			
	
<? include('../includes/layouts/footer.php')?>	