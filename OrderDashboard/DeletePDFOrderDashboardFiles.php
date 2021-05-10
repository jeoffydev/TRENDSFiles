<?php 

/************** INVOICE *************/
$invoiceFiles = glob($_SERVER['DOCUMENT_ROOT']."/OrderDashboard/Invoice/*");  

//print_r($invoiceFiles);
foreach($invoiceFiles as $invoiceF){ // iterate files
	 //echo $invoiceF. " / ";
	 if(is_file($invoiceF))
		unlink($invoiceF); // delete file
		echo "Deleted Invoice ";
}




/************** INVOICE *************/
$artworkFiles = glob($_SERVER['DOCUMENT_ROOT']."/OrderDashboard/Artwork/*");  
 
foreach($artworkFiles as $artworkF){ // iterate files
	 //echo $invoiceF. " / ";
	 if(is_file($artworkF))
		unlink($artworkF); // delete file
		echo "Deleted Artwork ";
}


?>