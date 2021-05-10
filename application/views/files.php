<!DOCTYPE html>
<html lang="en" ng-app='tgpApp' >

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<title>TRENDS |  Files</title>  

</head> 
<body ng-controller="filesCtrl"  >
 
 <?php  
/*
  
 $explodes = explode(".", $jobNumber);

 if($explodes[1]){
	$jobNumber = $explodes[1];
 }else{
	 redirect('/');
 }   */ 

	if($option == 1){  
			 
			$jobNumberFin = $this->general_model->getDecrypt($jobNumber);
			$files = $this->dashboard_model->media($jobNumberFin, "invoice");
			 
			$cleanfilename = substr($this->general_model->cleanString($jobNumber), 0, 10);
			$cleanfilename = str_replace("/","", $cleanfilename);
			$fname = $cleanfilename.".pdf";  

			if(!$files){
				redirect('/');
			}

			$file_path  = $_SERVER['DOCUMENT_ROOT']."/OrderDashboard/Invoice/".$fname;

			$base64string =  base64_encode($files); 

			 

				if (!empty($base64string)) {

					// Detects if there is base64 encoding header in the string.
					// If so, it needs to be removed prior to saving the content to a phisical file.
					if (strpos($base64string, ',') !== false) {
						@list($encode, $base64string) = explode(',', $base64string);
					} 
					$base64data = base64_decode($base64string, true); 
					// Return the number of bytes saved, or false on failure
					$result = file_put_contents($file_path, $base64data);

					redirect('/OrderDashboard/Invoice/'.$fname);
				}else{
					redirect('/');
				} 
				
			 
   

	}

	
	if($option == 2){
		$jobNumberFin = $this->general_model->getDecrypt($jobNumber);
		$files = $this->dashboard_model->media($jobNumberFin, "proof");
	    
		/* if(!$files){
			redirect('/');
		 }  

		$base64 =  base64_encode($files); */

			$cleanfilename = substr($this->general_model->cleanString($jobNumber), 0, 10);
			$cleanfilename = str_replace("/","", $cleanfilename);
			$fname = $cleanfilename.".pdf";  

			if(!$files){
				redirect('/');
			}

			$file_path  = $_SERVER['DOCUMENT_ROOT']."/OrderDashboard/Artwork/".$fname;

			$base64string =  base64_encode($files); 

			 

				if (!empty($base64string)) { 
					if (strpos($base64string, ',') !== false) {
						@list($encode, $base64string) = explode(',', $base64string);
					} 
					$base64data = base64_decode($base64string, true); 
					// Return the number of bytes saved, or false on failure
					$result = file_put_contents($file_path, $base64data);

					redirect('/OrderDashboard/Artwork/'.$fname);
				}else{
					redirect('/');
				}  
				
			 
   

	}  


	if($option == 3){  
			 
		$jobNumberFin = $this->general_model->getDecrypt($jobNumber);  
		$image = $this->dashboard_model->ConvertToImage($jobNumberFin); 
		echo '<img src="data:image/gif;base64, ' .$image. ' " class="img-fluid"   />'; 
		exit();
	}

	if($option == 1 || $option == 2 ){  
 
	?>

		<script>
					var byteString = atob('<?=$base64?>');
					//console.log(byteString);
					var ab = new ArrayBuffer(byteString.length);
					var ia = new Uint8Array(ab);
					for (var i = 0; i < byteString.length; i++) {
						ia[i] = byteString.charCodeAt(i);
					}

					// Blob for saving.
					var blob = new Blob([ia], { type: "application/pdf" });

					//console.log(blob); 

					// Tell the browser to save as report.pdf.
					//document.location.href = window.URL.createObjectURL(blob);
				 

					 //document.location.href = reader.readAsDataURL(blob);

					
			</script>

	<?php
	}

	$this->load->view('footer/footer');
?> 