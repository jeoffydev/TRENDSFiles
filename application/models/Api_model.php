<?php
 
class Api_Model extends CI_Model {

	public function __construct(){ 
		parent:: __construct();  
	 
		/* Variables  */
		$this->domainCheck = "0";  
		$this->userDataTable = 'userData'; 

	}
	 
	function updateAPiRequest($userID){
		    $data = [
			'apiReq' => 1,
		    ];
		    $this->db->where('userID',  $userID);
		    $updated = $this->db->update($this->userDataTable, $data);
		    return $updated;
	}
	 
}
