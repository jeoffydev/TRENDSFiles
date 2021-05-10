<?php
 
/* Switch account model */
class Switchaccount_Model extends CI_Model {
 

	 
	public function findAndSetNewCurrency($id, $userID){
		$results = array();
		$query = $this->db->query("SELECT * FROM secondaryUserAccount  WHERE id=".$id." AND userID = ".$userID."  ");
		if ($query->num_rows() > 0) { 
			$results['secondaryAccountArray'] = $query->result();
			$results['secondaryAccountFound'] = 1;
		}	
		return $results;
	}

	 

}
