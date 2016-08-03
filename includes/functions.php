<?php
//Useful functions
function clean_sql( $string ){
	global $link;
	return mysqli_real_escape_string( $link, $string );
}

function redirectTo( $url ){
	header('Location: '.$url);
	exit;
}

function confirm_query( $results ){
	if( !$results ){
		global $link;
		die('Error retrieving info.'.mysqli_error( $link ) );
	}
}

function get_posts( $public=true ){
	global $link;
	$query = "SELECT * FROM posts";
	if( $public ){
		$query .=" WHERE visible = 1";
	}
	$query .= " ORDER by post_time DESC";
	$post_set = mysqli_query( $link, $query );
	confirm_query( $post_set );
	return $post_set;
}

function get_categories( $public=true ){
	global $link;
	$query = "SELECT * FROM categories";
	if( $public ){
		$query .=" WHERE visible = 1";
	}
	$query .= " ORDER by created ASC";
	$category_set = mysqli_query( $link, $query );
	confirm_query( $category_set );
	return $category_set;
}

function get_posts_for_category( $category_id , $public=true ){
	global $link;
	$query = "SELECT * FROM posts WHERE post_cat_id = {$category_id}";
	
	if( $public ){
		$query .= " AND visible = 1";
	}
	$query .= " ORDER by post_time ASC";
	
	$post_set = mysqli_query( $link, $query );
	confirm_query($post_set);
	return $post_set;
}

function get_category_by_id( $category_id , $public=true){
	global $link;
	
	$safe_category_id = clean_sql( $category_id );
	
	$query = "SELECT * FROM categories WHERE category_id = {$safe_category_id} ";
	if( $public ){
		$query .= "AND visible = 1 ";
	}
	$query .= "LIMIT 1";
	$category_set = mysqli_query( $link, $query );
	confirm_query( $category_set );
	if( $category = mysqli_fetch_assoc( $category_set )){
		return $category;
	}else{
		return null;
	}
}

function get_post_by_id( $post_id, $public=true ){
	global $link;
	
	$safe_post_id = clean_sql( $post_id );
	
	$query = "SELECT * FROM posts WHERE id = {$safe_post_id}";
	if( $public ){
		$query .= " AND visible = 1";
	}
	$query .= " LIMIT 1";
	$post_set = mysqli_query( $link, $query );
	confirm_query( $post_set );
	if( $post = mysqli_fetch_assoc( $post_set ) ){
		return $post;
	}else{
		return null;
	}
}

function get_default_post_for_category( $category_id ){
	$post_set = get_posts_for_category( $category_id );
	
	if( $first_post = mysqli_fetch_assoc( $post_set ) ){
		return $first_post;
	}else{
		return null;
	}
}

function get_next_category_id(){
	$categories = get_categories();
	return mysqli_num_rows( $categories );
}

function display_posts( $posts ){
	foreach ( $posts as $post ){
		
		$output = 
		'<article class="article">
		<div class="post-info">
			<small class="owner">'.htmlentities( $post['author'] ).'</small>
			<small class="post-time">'.htmlentities( $post['post_time'] ).'</small> </div>
			<h2>'.htmlentities( $post['post_title'] ).'</h2>';	
		if( isset( $post['feature_img'] ) ){
			$output .= '<img class="post-img" src=".'.htmlentities( $post['feature_img'] ).'"/>';
		}
		$output .= '<div class="post">'.htmlentities( $post['post_excerpt'] ).'...</div>
			<a role="button" class="button read-more" href="posts.php?post='.urlencode( $post['id'] ).'">Read More</a>
		</article>';
		echo $output;
		}
}

function display_single_post( $post ){
	$output = 
		'<article id="viewed" class="article">
		<div class="post-info">
			<small class="owner">'.htmlentities( $post['author'] ).'</small>
			<small class="post-time">'.htmlentities( $post['post_time'] ).'</small> </div>
			<h2>'.htmlentities( $post['post_title'] ).'</h2>';	
		if( isset( $post['feature_img'] ) ){
			$output .= '<img class="post-img" src=".'.htmlentities( $post['feature_img'] ).'"/>';
		}
		$output .= '<div class="post">'.nl2br( htmlentities( $post['post_content'] ) ).'</div>
		</article>';
		echo $output;
}

function trim_str( $str, $length ){
	return substr( $str, 0, $length );
}

function find_selection( $public=false ){
	global $post;
	global $category;
	
	$category = null;
	$post = null;
	
	if( isset( $_GET['category'] )){
		$category = get_category_by_id( $_GET['category'], $public );
		
		if( $category && $public ){
			$post = get_default_post_for_category( $category['category_id'] );
		}else{
			$post = null;
		}
	}else if( isset( $_GET['post'] ) ){
		$post = get_post_by_id( $_GET['post'] , $public );
		$category = null;
	} 
}

function get_all_admins(){
	global $link;
	
	$q = "SELECT * FROM admins";
	$q .= " ORDER BY username ASC";
	$admin_set = mysqli_query( $link, $q );
	confirm_query( $admin_set );
	return $admin_set;
}

function get_admin_by_id( $admin_id ){
	global $link;
	
	$id = clean_sql( $admin_id );
	
	$query = "SELECT * FROM admins WHERE id = {$id} LIMIT 1";
	$admin_set = mysqli_query( $link, $query );
	confirm_query( $admin_set );
	if ( $admin = mysqli_fetch_assoc( $admin_set ) ){
		return $admin;
	}else{
		return null;
	}
}

function get_admin_by_username($admin_username){
	global $link;
	
	$admin_username = clean_sql($admin_username);
	
	$query = "SELECT * FROM admins WHERE username = '{$admin_username}' LIMIT 1";
	$admin_username_set = mysqli_query( $link, $query );
	confirm_query( $admin_username_set );
	if ($admin = mysqli_fetch_assoc( $admin_username_set ) ){
		return $admin;
	}else{
		return null;
	}
}

function find_category_name( $post_cat_id , $public ){
	$category = get_category_by_id( $post_cat_id , $public );
	return $category['category_name'];
}

function password_encrypt( $password ){
	$hash_format = '$2y$10$'; //Blowfish
	$salt_length = 22;
	$salt = generate_salt( $salt_length );
	$format_n_salt = $hash_format.$salt;
	$hash = crypt( $password , $format_n_salt );
	if( $hash == $password ){
		return false;
	}else{
		return $hash;	
	}
}

function generate_salt( $length ){
	//returns 32 characters
	$unique_random_string =  md5( uniqid( mt_rand() ,true) );
	
	$base64_string = base64_encode( $unique_random_string );
	
	//change concat operators '+' in base64 to '.'
	$modded_base64_string = str_replace( '+','.',$base64_string );
	
	//truncate to correct length
	return ( substr( $modded_base64_string, 0, $length ));
}

function password_check( $password , $existing_hash ){
	$hash = crypt( $password, $existing_hash );
	if( $hash == $existing_hash ){
		return true;
	}else{
		return false;
	}	
}

function attempt_login( $username, $password ){
	 $admin = get_admin_by_username( $username );
	 if( $admin ){
		 //returns true if the passwords match
		 if( password_check( $password, $admin['password'] ) ){
			 return $admin;
		 }else{
			 return false;
		 } 
	 }else{
		 return false;
	 }
}

function check_logged_in_status(){
	if( !isset( $_SESSION['admin_id'] ) ){
	redirectTo('login.php');
}
return true;
}
?>