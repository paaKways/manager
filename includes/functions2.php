<?php 
//Useful functions

function clean_sql($string){
	global $link;
	return mysqli_real_escape_string($link, $string);
}

function redirectTo( $url ){
	header('Location: '.$url);
	exit;
}

function confirm_query( $results ){
	if(!$results){
		global $link;
		die('Error retrieving info.'.mysqli_error($link) );
	}
}

function get_subjects($public=true){
	global $link;
	$q = "SELECT * FROM subjects";
	if($public){
		$q .=" WHERE visible =1";
	}
	$q .= " ORDER by position ASC";
	$subject_set = mysqli_query( $link, $q );
	confirm_query($subject_set);
	return $subject_set;
}

function get_pages_for_subject( $subject_id , $public=true){
	global $link;
	$q = "SELECT * FROM pages WHERE subject_id = {$subject_id}";
	if($public){
		$q .= " AND visible = 1";
	}
	$q .= " ORDER by position ASC";
	
	$page_set = mysqli_query( $link, $q );
	confirm_query($page_set);
	return $page_set;
}

//Private viewer . Navigation takes two arguments, current page array and current subject array or null for each.
function get_navigation( $subjectArray, $pageArray ){
	$output = '<ul class="subjects">';
	$subject_set = get_subjects(false);
	while( $subject = mysqli_fetch_assoc($subject_set) )
		{
			//List opening tag formatting.
			$output .= '<li';
			if( $subjectArray && $subject['id'] == $subjectArray['id'] ){
			$output.=' class="selected"';
				}
			$output .= '>';
			
			//an enclosed anchor tag within the list element.
			$output .='<a href="manage_content.php?subject='.urlencode($subject['id']).'">';		
			$output .= htmlentities($subject['title']); 
			$output .= '</a>';
			
			//Pages
			$page_set = get_pages_for_subject($subject['id'],false);
		    $output .=	'<ul class="pages">';
	
			while( $page = mysqli_fetch_assoc($page_set) )
				{
					//List opening tag formatting.
					$output .= '<li ';
					if( $pageArray && $page['id'] == $pageArray['id'] )
					{
						$output .= 'class="selected"';
					}
					$output .= '>';
					$output .= '<a href="manage_content.php?page='.urlencode($page['id']).'">';
					$output .= htmlentities($page['title']) ; 
					$output .= '</a></li>';
				}
				mysqli_free_result($page_set);
				$output .= '</ul></li>';
		}
		mysqli_free_result($subject_set);
		$output .= '<hr>';
		return $output;
}

//Public viewer. 
function get_public_navigation( $subjectArray, $pageArray ){
	$output = '<ul class="subjects">';
	$subject_set = get_subjects();
	while( $subject = mysqli_fetch_assoc($subject_set) )
		{
			//List opening tag formatting.
			$output .= ' <li';
			if( $subjectArray && $subject['id'] == $subjectArray['id'] ){
			$output.=' class="selected"';
				}
			$output .= '>';
			
			//an enclosed anchor tag within the list element.
			$output .='<a href="index.php?subject='.urlencode($subject['id']).'">';		
			$output .= htmlentities($subject['title']); 
			$output .= '</a>';
			
			//This conditional allows display if only the subject has been clicked.
			if($subjectArray['id'] == $subject['id'] || $pageArray['subject_id'] == $subject['id'] ){
			
			$page_set = get_pages_for_subject($subject['id']);
		    $output .=	'<ul class="pages">';
	
		//display pages under subject
			while( $page = mysqli_fetch_assoc($page_set) )
				{
					//List opening tag formatting.
					$output .= '<li ';
					if( $pageArray && $page['id'] == $pageArray['id'] )
					{
						$output .= 'class="selected"';
					}
					$output .= '>';
					$output .= '<a href="index.php?page='.urlencode($page['id']).'">';
					$output .= htmlentities($page['title']) ; 
					$output .= '</a></li>';
				}
				$output .= '</ul>';
				mysqli_free_result($page_set);
				
			}	
				$output .= '</li>';
		}
		mysqli_free_result($subject_set);
		$output .= '</ul><hr>';
		return $output;
}

function get_subject_by_id( $subject_id , $public=true){
	global $link;
	
	$safe_subject_id = mysqli_real_escape_string($link, $subject_id);
	
	$q = "SELECT * FROM subjects WHERE id = {$safe_subject_id} ";
	if($public){
		$q .= "AND visible = 1 ";
	}
	$q .= "LIMIT 1";
	$subject_set = mysqli_query( $link, $q );
	confirm_query($subject_set);
	if( $subject = mysqli_fetch_assoc($subject_set)){
		return $subject;
	}else{
		return null;
	}
}

function get_page_by_id( $page_id , $public=true){
	global $link;
	
	$safe_page_id = mysqli_real_escape_string($link, $page_id);
	
	$q = "SELECT * FROM pages WHERE id = {$safe_page_id} ";
	if($public){
		$q .= "AND visible = 1 ";
	}
	$q .= "LIMIT 1";
	$page_set = mysqli_query( $link, $q );
	confirm_query($page_set);
	if( $page = mysqli_fetch_assoc($page_set)){
		return $page;
	}else{
		return null;
	}
}

function get_default_page_for_subject($subject_id){
	$page_set = get_pages_for_subject( $subject_id );
	
	//fetch_assoc return results in order, first then second. So, normally a while loop is used to extract its contents
	if($first_page = mysqli_fetch_assoc($page_set)){
		return $first_page;
	}else{
		return null;
	}
}

function find_selected_page($public=false){
	global $current_page;
	global $current_subject;
	
    $current_page = null;
	$current_subject = null;
	
	if( isset($_GET['subject']) ){
		$current_subject = get_subject_by_id($_GET['subject'], $public);
		
		if($current_subject && $public){
			$current_page = get_default_page_for_subject($current_subject['id']);
		}else $current_page = null;
		
	}else if ( isset($_GET['page']) ){
		$current_page = get_page_by_id($_GET['page'] , $public);
		$current_subject = null;
		}
}

function get_all_admins(){
	global $link;
	
	$q = "SELECT * FROM admins";
	$q .= " ORDER BY username ASC";
	$admin_set = mysqli_query( $link, $q );
	confirm_query($admin_set);
	return $admin_set;
}

function get_admin_by_id($admin_id){
	global $link;
	
	$id = clean_sql($admin_id);
	
	$q = "SELECT * FROM admins WHERE id = {$id} LIMIT 1";
	$admin_set = mysqli_query( $link, $q );
	confirm_query($admin_set);
	if ($admin = mysqli_fetch_assoc($admin_set) ){
		return $admin;
	}else{
		return null;
	}
}

function get_admin_by_username($admin_username){
	global $link;
	
	$admin_username = clean_sql($admin_username);
	
	$q = "SELECT * FROM admins WHERE username = '{$admin_username}' LIMIT 1";
	$admin_username_set = mysqli_query( $link, $q );
	confirm_query($admin_username_set);
	if ($admin = mysqli_fetch_assoc($admin_username_set) ){
		return $admin;
	}else{
		return null;
	}
}

function password_encrypt( $password ){
	$hash_format = '$2y$10$'; //Blowfish
	$salt_length = 22;
	$salt = generate_salt( $salt_length );
	$format_n_salt = $hash_format.$salt;
	$hash = crypt( $password , $format_n_salt );
	if($hash == $password ){
		return false;
	}else{
		return $hash;	
	}
}

function generate_salt($length){
	//returns 32 characters
	$unique_random_string =  md5( uniqid(mt_rand() ,true) );
	
	$base64_string = base64_encode( $unique_random_string );
	
	//change concat operators '+' in base64 to '.'
	$modded_base64_string = str_replace('+','.',$base64_string);
	
	//truncate to correct length
	return (substr($modded_base64_string, 0, $length));
}

function password_check($password , $existing_hash){
	$hash = crypt($password, $existing_hash);
	if( $hash == $existing_hash ){
		return true;
	}else{
		return false;
	}	
}

function attempt_login($username, $password){
	 $admin = get_admin_by_username($username);
	 if($admin){
		 //returns true if the passwords match
		 if( password_check($password, $admin['password']) ){
			 return $admin;
		 }else{
			 return false;
		 } 
	 }else{
		 return false;
	 }
}

function check_logged_in_status(){
	if( !isset($_SESSION['admin_id'])){
	redirectTo('login.php');
}
}

function get_fields( $optionsList , $type='str' , $subtype='str'){
	$str = '';
	for($i = 0; $i < (count($optionsList) ); $i++) {
		
		if( $type == 'var'){
			
			if( $subtype == 'str'){
				$optionsList[$i] = wrap_with_quotes(var_brackets($optionsList[$i]));
				$str .= $optionsList[$i];
			}else{
				$optionsList[$i] = var_brackets($optionsList[$i]);
				$str .= $optionsList[$i];
			}
			if( $i < (count($optionsList)-1)  ){
				$str .= ' ,';
			} 
		}
		else{
			if( $subtype == 'str'){
				$str .= $optionsList[$i];
			}
			if( $i < (count($optionsList)-1)  ){
			$str .= ' ,';
			} 
		}
	}
	return $str;
}

function wrap_with_quotes( $str ){
	return "'".$str."'";
}

function var_brackets( $str ){
	return  ('{ $'.$str.' }');
}

function get_values($optionsList, $datatype='other'){
	if($datatype == 'str'){
		$format = get_fields($optionsList, $type='var', $subtype=$datatype);
	}else{
		$format = get_fields($optionsList, $type='var' , $subtype=$datatype);
	}

	return $format;
}
?>