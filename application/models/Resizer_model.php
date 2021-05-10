<?php

 
 
class Resizer_Model extends CI_Model {

	public function __construct(){ 
		parent:: __construct();  
	 
		/* Variables  */
		
		
 
 
	}

	public function index($filename, $size){

			$result = 1;
			// Configuration
			$config['image_library'] = 'gd2';
			$config['source_image'] =  './Images/ProductImg/'.$filename;
			$config['new_image'] = './resizer/'.$size.'/'.$filename;
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = $size;
			$config['height'] = $size;
			// Load the Library
			$this->load->library('image_lib'); 

			$this->image_lib->initialize($config);
			// Do your manipulation

			// resize image
			$this->image_lib->resize();

			// handle if there is any problem
			if ( ! $this->image_lib->resize()){ 
				$result = $this->image_lib->display_errors();
			}else{
				$result = 1;
			}

			return $result;

			$this->image_lib->clear();
		 
	}
 
 
 
 
 
}
