<?php
//Useful classes
class PostController {
	
	//properties
	
	/*
	private $post_title;
	private $post_content;
	private $post_time;
	private $post_cat_id;
	private $post_excerpt;
	*/
	
	public $post_set;
	public $post_count;
	
	//constructor
	public function __construct( $post_set ){
		$this->post_set = $post_set;
		$this->post_count = $this->get_number_of_posts();
	}
	
	//methods
	public function get_posts(){
		return $this->post_set ;
	}
	
	public function get_number_of_posts(){
		 return mysqli_num_rows( $this->post_set );
	}
	
	public function get_first_post(){
		return $this->post_set[0];
	}

}

?>