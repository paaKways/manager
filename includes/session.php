<?php
	session_start();
	
	function info(){
		if( isset( $_SESSION['info'] )){
			$output = '<div class="info">'.htmlentities( $_SESSION['info'] ).'</div>';
			$_SESSION['info'] = null; 
			return $output;
		} 
	}

?>