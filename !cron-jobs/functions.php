<?
	//output to console function
	
	function debug_to_console($data,$alert=0) {
		$output = "";
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz"){
			if(is_array( $data )) {
				$output = "<script>console.log(\"Debug Objects: ".implode(',',$data)."\");</script>";
			} else {
				$output = "<script>console.log(\"Debug Objects: ".$data."\");</script>";
			}
			
			if($alert == 1) {
				$output .= "<script>alert('".$data."')</script>";
			}
			
			echo $output;
		}
	}
	
	//database read function
	
	function dbPuller($queryInput,$queryMode,$showOutput=1,$frame=0) {
		if($showOutput == 1){ debug_to_console( "queryInput: ".$queryInput);}
		$rnd1 = rand(1,5);
		do {
		  $rnd2 = rand(1,5);
		} while ($rnd1 == $rnd2);
		
		$queryTXT = str_replace(array("'", "\"", "&quot;","\n", "\t"), "", $queryInput);
		
		if($showOutput == 1){ debug_to_console( "queryTXT: ".$queryTXT);}
		
		$SQLHost = "localhost";
	
		$SQLNameRD = "trends_WebView".$rnd1;
		$SQLNameRDBackup = "trends_WebView".$rnd2;
		$SQLPwdRD = "JtmNbJ06yA";
		
		$SQLNameWR = "trends_WebWrite";
		$SQLPwdWR = "cwpTtvtC5VkA3kOVyFko";
		
		$SQLdb = "trends_collection";
		
		if($queryMode == 0) { //read mode
			$userUsed = "Main";
			if($showOutput == 1){ debug_to_console( "READ MODE, Main: ".$SQLNameRD.", Backup: ".$SQLNameRDBackup.", Used: ".$userUsed.", Query: ".$queryTXT);}
			
			$global_dbh = mysqli_connect($SQLHost, $SQLNameRD, $SQLPwdRD, $SQLdb, 3306);
			
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			
			global $rowsReturned;
			$rowsReturned = mysqli_num_rows($queryOutput);
			
			if(!$queryOutput) {
				$global_dbh = mysqli_connect($SQLHost, $SQLNameRDBackup, $SQLPwdRD, $SQLdb, 3306);
				$queryOutput = mysqli_query( $global_dbh, $queryInput);
				$userUsed = "Backup";
			}
			if($showOutput == 1){
				debug_to_console( "Number of Rows returned: ".$rowsReturned);
			}
			
		} else { //write mode
			if($showOutput == 1){ debug_to_console( "WRITE MODE, Query: ".$queryTXT);}
			$global_dbh = mysqli_connect($SQLHost, $SQLNameWR, $SQLPwdWR, $SQLdb, 3306);
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			if($queryMode == 2) {
				$queryOutput = mysqli_insert_id($global_dbh);
				if($showOutput == 1){ debug_to_console( "New Primary key: ".$queryOutput);}
			}
		}
		
		if(!$queryOutput) {
			if($showOutput == 1){
				debug_to_console("Error: ".mysqli_error($queryOutput));
				error_log("mySQLi Error: '".$queryInput."' (".$_SERVER['REMOTE_ADDR'].", )".basename($_SERVER['PHP_SELF']),0);
			}
			if($queryMode == 0) {
				if($frame == 0) {
					include("Error.php");
				} else {
					include("ErrorFrame.php");
				}
			} else {
				echo "<div class='bodyText'>There was an database issue, please try again.</div>";
			}
			exit;	
		}
		
		//mysqli_close($global_dbh);
		//mysqli_close($global_dbh_Backup);
		
		return $queryOutput;
	}
	
	//icon maker
	
	function iconMaker($row, $priceShowVal=NULL, $padMe=NULL, $id=NULL,  $skinDataArray=NULL) {
		global $imgAppend; 
		global $loggedIn;
		global $custShowPricing;
		global $custMarkups;
		global $custMarkupBranding;
		global $idSafe;
		global $exclusiveAccessShow;


		 //Passing SkinData arrays for filter advance
		 if($skinDataArray['customCustomShowPricing'] != null){
			$custShowPricing = $skinDataArray['customCustomShowPricing']; 
		}else{
			$custShowPricing = $custShowPricing; 
		} 
		if($skinDataArray['custMarkups'] != null){
			$custMarkups = $skinDataArray['custMarkups']; 
		}else{
			$custMarkups = $custMarkups; 
		} 
		if($skinDataArray['custMarkupBranding'] != null){
			$custMarkupBranding = $skinDataArray['custMarkupBranding']; 
		}else{
			$custMarkupBranding = $custMarkupBranding; 
		} 

		//Additional changes April 06 from Sarah  skinned login 
		if($idSafe){
			 $custShowPricing =   skinnedLoginPricing($skinDataArray['showPricing'], $skinDataArray['loginSkinnedSite']); 
		}
		
		debug_to_console("iconMaker loggedIn: ".$loggedIn);
		debug_to_console("iconMaker custShowPricing: ".$custShowPricing);
		$priceShow = "";
		$inclusion = "";
		$price2Use = "";
		$height = "";
		
		if($row['Price6'] != '0') {  
			$price2Use = $row['Price6'] * (($custMarkups[6] * 0.01)+1);
		} else {
			if($row['Price5'] != '0') {
				$price2Use = $row['Price5'] * (($custMarkups[5] * 0.01)+1);
			} else {
				if($row['Price4'] != '0') {
					$price2Use = $row['Price4'] * (($custMarkups[4] * 0.01)+1);
				} else {
					if($row['Price3'] != '0') {
						$price2Use = $row['Price3'] * (($custMarkups[3] * 0.01)+1);
					} else {
						if($row['Price2'] != '0') {
							$price2Use = $row['Price2'] * (($custMarkups[2] * 0.01)+1);
						} else {
							if($row['Price1'] != '0') {
								$price2Use = $row['Price1'] * (($custMarkups[1] * 0.01)+1);
							} else {
								$price2Use = "";
							}
						}
					}
				}
			}		
		}
		if($row['PriceType'] == "U"){
			$inclusion = "Branded";
			$priceShow = number_format($price2Use + ($row['AdditionalCost1'] * (($custMarkupBranding * 0.01)+1)), 2);
		}
		if($row['PriceType'] == "B"){
			$inclusion = "Branded";
			if($price2Use !== "") {
				$priceShow = number_format($price2Use, 2);
			} else {
				$priceShow = $price2Use;
			}
		}
		if($row['PriceType'] == "N"){
			$inclusion = "Unbranded";
			if($price2Use !== "") {
				$priceShow = number_format($price2Use, 2);
			} else {
				$priceShow = $price2Use;
			}
		}
		if($loggedIn == 1) {
			if(!empty($idSafe)) {
				if($custShowPricing == 0) {
					$priceShow = "";
					$height = "style='height:373px !important;'";
				}
			}
		} else {
			if($custShowPricing == 0) {
				$height = "style='height:373px !important;'";
			}
		}
		$padMeResult = "";
		if($padMe == 1) {
			$padMeResult = "style='padding-left:0px !important' ";
		}
		if($padMe == 2) {
			$padMeResult = "style='padding-right:0px !important' ";
		}
		?>
		<span class="categoryOuter" <? echo $padMeResult; ?> id="cat<? echo $row['Code']; ?>">
		<?php 
			//Include the quickView  plugin and the ID above span.categoryOuter id="cat<? echo $row['Code'].$id; // 
			 include('QuickView/quickview.php');
		?>
			<!--<a href="/item/<? echo $row['Code'].$id; ?>">-->
			<span class="categoryBox">
				<div class="fancy" <? echo $height; ?> > 
						<!--<img src="/Images/ProductImgSML/<? echo $row['Code']; ?>.jpg?<? echo $imgAppend; ?>" border="0" width="282" height="282" class="fancyX" />-->
						<?php 
							//Jeoffy added this for category images slider
							include("CategorySlider/categoryslider.php");  
						?>
					<a href="/item/<? echo $row['Code'].$id; ?>">	 
					<div class="snipe">
						<? 
							echo "<span style='font-weight: 400;font-size:15px;'>".$row['Code']."</span><br />";
							//added this for tooltip on title
							if(strlen($row['Name']) >= 29){
								$attrs = 'data-toggle="tooltip"   title="'.$row['Name'].'" ';
								$attrClass = 'cat-tooltip-title';
						   }else{
							   $attrs = '';
							   $attrClass = '';
						   }
						   echo '<span class="cats-title '.$attrClass.'" '.$attrs.'>'.$row['Name'].'</span>';
						   //end added this for tooltip on title
							if(is_null($priceShow) == FALSE) {
								if(($loggedIn == 1) || ($custShowPricing == 1)) {
									if($priceShow !== "") {
										echo "<br /><span style='font-size:13px;font-weight: 400;'>".$inclusion." From As Low As</span>";
										echo "<br />$".$priceShow;
									} 
								}
							}
							echo "<div style='padding-top:5px;padding-bottom:5px'>";
								if($row['IsIndent'] != "") {
									$lead = "Indent: ".$row['IsIndent']." week lead time.";
									$img = "worldSourceAlt.png";
									echo "<img src='/Images/Statuses/s/".$img."' title='".$lead."' />";
								}
								if($row['IsIndentExpress'] != "") {
									$lead = "Indent Express: ".$row['IsIndentExpress']." working day lead time.";
									$img = "worldSource.png";
									echo "<img src='/Images/Statuses/s/".$img."' title='".$lead."' />";
								}
								if($row['Status']=='N') {
									echo "<img src='/Images/Statuses/s/new.png' title='New Item.' />";
								}
								if($row['FullColour']=='1') {
									echo "<img src='/Images/Statuses/s/fullColour.png' title='Full colour branding available.' />";
								}
								if($row['IsMixMatch']=='1') {
									echo "<img src='/Images/Statuses/s/mixMatch.png' title='Mix and match item.' />";
								}
								
								if(($row['ExclusiveItem']=='1') && ($exclusiveAccessShow == 1)
									
								
								
								
								
								
								) {
									//echo "<img src='/Images/Statuses/s/exclusiveItems.png' title='Exclusive Item.' />";
								}
								if($row['Eco'] =='1') {
									echo "<img src='/Images/Statuses/s/eco.png'  title='Eco Friendly' />";
								}
								if($row['Recycle'] =='1') {
									echo "<img src='/Images/Statuses/s/recycle.png'  title='Recyclable' />";
								}
								if($row['Status']=='D') {
									echo "<img src='/Images/Statuses/s/discontinued.png' title='Discontinued Item – while stocks last.' />";
								}

								if($row['availNZ'] == '1' && $row['availAU'] == '0'){
									echo "<img src='/Images/Statuses/s/nzd.png'  title='Available for New Zealand Delivery Only.' />";
								} 
								if($row['availNZ'] == '0' && $row['availAU'] == '1'){
									echo "<img src='/Images/Statuses/s/aus.png' title='Available for Australian Delivery Only.' />";
								}

								
							echo "</div>";
						?>
					</div></a>
				</div>
			</span><!--</a>-->
		</span>	
	<?
	}
	
	//Image update icon maker
	
	function imageUpdateMaker($imgCount, $padMe=NULL) {
		$padMeResult = "";
		if($padMe == 1) {
			$padMeResult = "style='padding-left:0px !important' ";
		}
		if($padMe == 2) {
			$padMeResult = "style='padding-right:0px !important' ";
		}
		?>
		<span class="categoryOuter" <? echo $padMeResult; ?>>
			<span class="categoryBox">
				<div class="fancy nohover" style="height:353px !important;">
					<img src='/Images/newImage.png' border='0' class='fancyX' id='Imager<? echo $imgCount; ?>'/>
                    <img src='/Images/blank.gif' width='282px' height='282px' border='0' class='imgOverlay' id='ImagerX<? echo $imgCount; ?>'/>
					<div class="snipe">
						<? echo "Image ".$imgCount; ?>
						<div style='padding-top:5px;padding-bottom:5px'>
                        	<form enctype="multipart/form-data" id="id="formLoader-<? echo $imgCount; ?>">
                                <input type="submit" class="addImageButt" id="addImage-<? echo $imgCount; ?>" value="Upload Image" disabled="disabled" style="width:94px" />
                                <input type="file" name="fileLoader" id="fileLoader-<? echo $imgCount; ?>" accept=".jpg" style='display:none;'/>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="submit" class="delImageButt" id="delImage-<? echo $imgCount; ?>" value="Delete Image" disabled="disabled" style="width:94px" />
                            </form>	
						</div>
					</div>
				</div>
			</span>
		</span>	
	<?
	}
	
	//Banner Editor
	function bannerUpdateMaker($imgCount,$mini=NULL) {
		if($mini == NULL) {
			$style1 = '1205px';
			$style2 = '450px';
			$style2a = '400px';
			$style3 = '831px';
			$style4 = '';
			$style5 = "Images/newBanner.png";
			$style6 = "itemid";
			$style7 = "width:94px";
		} else {
			$style1 = '385px';
			$style2 = '265px';
			$style2a = '200px';
			$style3 = '320px';
			$style4 = 'display:inline !important;';
			$style5 = "Images/newBannerMini.png";
			$style6 = "itemidX";
			$style7 = "width:160px";
		}
		?>
		<span id="movable-<? echo $imgCount; ?>" <? echo $style6; ?>='<? echo $imgCount; ?>' class="categoryOuter ui-state-disabled" style='padding-left:0px !important; padding-right:0px !important;<? echo $style4; ?>'>
		
			<div class="categoryBox" style="height:<? echo $style2; ?> !important;width:<? echo $style1; ?> !important;margin-left:6px !important; margin-right:6px !important;padding-left:0px !important; padding-right:0px !important;" >
				<div class="fancy nohover" style="height:<? echo $style2; ?> !important;width:<? echo $style1; ?> !important" id="movableCursor<? echo $imgCount; ?>">
					<div class="bannerHelper"><? echo $style1." x ".$style2a; ?></div>
						<img src='<? echo $style5; ?>' width='<? echo $style1; ?>' height='<? echo $style2a; ?>' border='0' class='fancyX' id='Banner<? echo $imgCount; ?>'/>
						<img src='/Images/blank.gif' width='<? echo $style1; ?>' height='<? echo $style2; ?>' border='0' class='imgOverlay' id='ImagerX<? echo $imgCount; ?>'/>
						<div class="snipe" style="width:<? echo $style1; ?> !important;max-width:<? echo $style1; ?> !important">
							<div style='padding-top:5px;padding-bottom:5px'>
								<form enctype="multipart/form-data" id="formLoader-<? echo $imgCount; ?>">
									URL: <input type="text" id="urlText-<? echo $imgCount; ?>" value="" placeholder="www.domain.com/example" disabled="disabled" data-validation-engine="validate[required]" class="text-input specialColor urlText" style="width:<? echo $style3; ?>" />
									<? if($mini !== NULL) {
										echo "<div style='min-height:5px'></div>";
									} ?>
									<input type="submit" class="updateURLButt" id="updateURL-<? echo $imgCount; ?>" value="Save" disabled="disabled" style="<? echo $style7; ?>" />
									<input type="submit" class="addImageButt" id="addImage-<? echo $imgCount; ?>" value="Upload Image" disabled="disabled" style="<? echo $style7; ?>" />
									<input type="file" name="fileLoader" id="fileLoader-<? echo $imgCount; ?>" accept=".jpg" style='display:none;'/>
									<? if($mini == NULL) { ?>
										<input type="submit" class="delImageButt" id="delImage-<? echo $imgCount; ?>" value="Delete Image" disabled="disabled" style="<? echo $style7; ?>" />
									<? } ?>
								</form>	
							</div>
						</div>
				</div>
			</div>
			
		</span>	
	<?
	}
	
	// logo maker
	function doLoggo($RefID=NULL,$extraStyle=NULL) {
		global $randNum;
		global $liveSite;
		global $domainCheck;
		global $idSafe;
		if((($RefID !== NULL) || ($domainCheck == 1)) && ($liveSite == 1)) {
			//$idSafe = substr($RefID,3);
			$logoLocation = 'Images/TopMenu/customerLogos/'.$idSafe.'.png';
			debug_to_console("Logo: ".$_SERVER['DOCUMENT_ROOT'].'/'.$logoLocation);
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$logoLocation)) {
				list($width, $height) = getimagesize($logoLocation);
				debug_to_console("Logo exists: w=".$width."px, h=".$height);
				if($width > 700) {
					debug_to_console("Logo too wide");
					$width = 700;
				}
				if($height > 87) {
					debug_to_console("Logo too high");
					$height = 87;
				}
				$logoClass = "titleImageSpec";
				echo ("<style>.titleImageSpec { background: url('/".$logoLocation."?".$randNum."') left center no-repeat; width: ".$width."px;}</style>");
			} else {
				$logoLocation = 'Images/TopMenu/customerLogos/'.$idSafe.'.jpg';
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$logoLocation)) {
					list($width, $height) = getimagesize($logoLocation);
					debug_to_console("Logo exists: w=".$width."px, h=".$height);
					if($width > 700) {
						debug_to_console("Logo too wide");
						$width = 700;
					}
					if($height > 87) {
						debug_to_console("Logo too high");
						$height = 87;
					}
					$logoClass = "titleImageSpec";
					echo ("<style>.titleImageSpec { background: url('/".$logoLocation."?".$randNum."') left center no-repeat; width: ".$width."px;}</style>");
				} else {
					$logoLocation = 'Images/TopMenu/customerLogos/'.$idSafe.'.gif';
					if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$logoLocation)) {
						list($width, $height) = getimagesize($logoLocation);
						debug_to_console("Logo exists: w=".$width."px, h=".$height);
						if($width > 700) {
							debug_to_console("Logo too wide");
							$width = 700;
						}
						if($height > 87) {
							debug_to_console("Logo too high");
							$height = 87;
						}
						$logoClass = "titleImageSpec";
						echo ("<style>.titleImageSpec { background: url('/".$logoLocation."?".$randNum."') left center no-repeat; width: ".$width."px; background-size: 100% 100%;}</style>");
					} else {
						echo ("<style>.titleImageSpec { background: url('/Images/blank.gif') left center no-repeat; width: 429px; height: 87px;background-size: 100% 100%;}</style>");
						$logoLocation = 'Images/blank.gif';
						$logoClass = "titleImageSpec";
					}
				}
			}
			if($domainCheck == 1) {$RefID = "/";}
		} else {
			$logoLocation = 'Images/TopMenu/logo.png';
			$logoClass = "titleImage";
			$RefID = "/";
		}
		echo "<a href='".$RefID."' class='".$logoClass."' style='".$extraStyle."'>".$logoName."</a>";	
	}
	
	// main page icon maker ---------RETIRED
	function iconMakerProduct($link, $name=NULL, $hideName=NULL, $size='155') {
		global $imgAppend;
		global $tableCategories;
		global $dev;
		global $idOutput;
		
		if($name == NULL) {
			$Query = "SELECT * FROM ".$tableCategories." WHERE CategoryNum LIKE '".$link."'";
			$CatName = dbPuller($Query,0);
			if ($CatName = mysqli_fetch_array($CatName)) { 
				$name = $CatName['CategoryName'];
			}
		}
		?>
		<span style="position:relative;display:inline-block;padding-left:7px;padding-right:7px;padding-bottom:15px;">
			<span class="categoryBox-200" style="width:<? echo $size; ?>px;min-width:<? echo $size; ?>px;">
				<div class="fancy-200" style="width:<? echo $size; ?>px;height:<? echo $size; ?>px;border-radius: <? echo ($size*0.16); ?>px;" id="fancy-200Txt">
					<a href="<? echo $dev; ?>/category/<? echo $link; ?>/all<? echo $idOutput; ?>">
						<img src="<? echo $dev; ?>/Images/ProductCats/<? echo $link; ?>.jpg?<? echo $imgAppend; ?>" width="<? echo $size; ?>" height="<? echo $size; ?>" border="0" class="fancyX" style="border-radius: <? echo ($size*0.16); ?>px;"/>
						<? if ($hideName == NULL || $hideName !== 2) {
                    		echo "<div id='categoryTextTxt' class='categoryText'>".$name."</div>";
                        } ?>
                    </a>
				</div>
			</span>
                <? if ($hideName == 2) { ?>
                	<a href="<? echo $dev; ?>/category/<? echo $link; ?>/all<? echo $idOutput; ?>">
						<div class='categoryText2' style='width:<? echo $size; ?>px;'>
							<div class='categoryText2a' style="width:<? echo $size; ?>px;"><? echo $name; ?></div>
                        </div>
                    </a>
				<? } ?>
		</span>
	<? }
	
	// top menu icon maker
	function iconMakerMenu($link, $name=NULL, $hideName=NULL, $size='155',$specialLink=NULL, $linkDir="/Images/ProductCats/", $linkType=NULL, $edge=NULL) {
		global $idOutput;
		global $imgAppend;
		global $tableCategories;
		
		if($edge == NULL) {
			$widthInserter1 = 1.39; //1.35
		} else {
			$widthInserter1 = 1;
		}
			
		$widthInserter2 = ((($widthInserter1*100)/2)-($size/2))/100;
		$widthInserter3 = $size*$widthInserter2;
		
		
		if($name == NULL) {
			$Query = "SELECT * FROM ".$tableCategories." WHERE CategoryNum LIKE '".$link."'";
			$CatName = dbPuller($Query,0);
			if ($CatName = mysqli_fetch_array($CatName)) { 
				$name = $CatName['CategoryName'];
			}
		}
		?>
		<span style="position:relative;display:inline-block;padding-bottom:15px;padding-right:10px;">
			<span class="categoryBox-200" style="padding-left:<? echo $widthInserter3 ?>px;width:<? echo ($size*$widthInserter1); ?>px;min-width:<? echo ($size*$widthInserter1); ?>px;">
				<div class="fancy-200" style="width:<? echo $size; ?>px;height:<? echo $size; ?>px;border-radius: <? echo ($size*0.16); ?>px;" id="fancy-200Txt">
					<? if($specialLink==NULL) {
                    	echo "<a href='/category/".$link."/all".$idOutput."'>";
                    } else {
                    	echo "<a ".$linkType." href='/".$specialLink."'>";
                    } ?>
						<img src="<? echo $linkDir.$link; ?>.jpg?<? echo $imgAppend; ?>" width="<? echo $size; ?>" height="<? echo $size; ?>" border="0" class="fancyX" style="border-radius: <? echo ($size*0.16); ?>px;"/>
						<? if ($hideName == NULL || $hideName !== 2) {
                    		echo "<div id='categoryTextTxt' class='categoryText'>".$name."</div>";
                        } ?>
                    </a>
				</div>
			</span>
                <? if ($hideName == 2) {
                	if($specialLink==NULL) {
                    	echo "<a href='/category/".$link."/all".$idOutput."'>";
                    } else {
                    	echo "<a ".$linkType." href='/".$specialLink.$idOutput."'>";
                    } ?>
						<div class='categoryText2' style='width:<? echo ($size*$widthInserter1); ?>px;'>
							<div class='categoryText2a' style="width:<? echo ($size*$widthInserter1); ?>px;"><? echo $name; ?></div>
                        </div>
                    </a>
				<? } ?>
		</span>
	<? }
	
	function goAway($user="unknown",$page="unknown") {
		$userAuth = 2;
		if (isset($_SESSION)) {
			session_destroy();
		}
		setcookie("user", "", 1, '/'); //eat the cookie
		error_log("Logging out userID ".$user." (".$_SERVER['REMOTE_ADDR'].") from ".$page,0);
		debug_to_console("Logging out userID ".$user." from ".$page);
	}
	
	function checkUser($userCheck,$checkType,$companyName=0) {
		if($checkType == 0) {
			$appender = " userID='".$userCheck."'";
		} else {
			$appender = " userEmail LIKE '".$userCheck."'";
		}
		
		if($companyName == 1) {
			$resulter = dbPuller("SELECT * FROM userData LEFT OUTER JOIN customerData ON customerData.CustomerNumber = userData.userAcct WHERE".$appender,0,0);
		} else {
			$resulter = dbPuller("SELECT * FROM userData WHERE".$appender,0,0);
		}
		return $resulter;
	}
	
	function brandCHK($brandMeth,$brandValue) {
		global $idOutput;
		if(!is_null($idOutput)) {
			$idOutput2 = "&ID=".substr($idOutput,3);
		}//Added this
		if(isset($idOutput2)){
			$idOutput2 = $idOutput2;
		}else{
			$idOutput2 = '';
		} 
		$brandMeth = trim($brandMeth);
		$brandTypes = array("Pad Print",
		"Rotary Digital Print",
		"Screen Print",
		"Screen Print Transfer", 
		"Laser Engraving",
		"Resin Coated Finish",
		"Digital Label",
		"Digital Print",
		"Digital Transfer",  
		"Sublimation Print",
		"Kiln Fired Decal",
		"Offset Transfer",
		"Imitation Etch",  
		"Direct Digital",
		"Debossing",
		"Embroidery");
		echo "<div class='bodyTextMeth'>";
		if (in_array($brandMeth, $brandTypes)) {
			echo "<a data-fancybox-type='iframe' id='branding' href='/brandPopup.php?type=".$brandMeth.$idOutput2."'>".$brandMeth."</a>:<span class='bodyText'> ".$brandValue."</span>";
		} else {
			echo $brandMeth.":<span class='bodyText'> ".$brandValue."</span>";
		}
		echo "</div>";
	}
	
	// file size formatter
	function human_filesize($bytes, $decimals = 2,$format = "GB") {
		if($format == "GB"){
			$final = (($bytes /1024)/1024)/1024;
		} else {
			$final = ($bytes /1024)/1024;
		}
		return round($final,$decimals).$format;
		//$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		//$factor = floor((strlen($bytes) - 1) / 3);
		//return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}
	
	//include_once("SimpleImage.php");
	
	// email spambot stopper
	function hide_email($email){
		$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
		$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
		for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
		$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
		$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
		$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
		$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
		$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
		return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
	}

	
	function filesChecker($user) {
		$result = dbPuller("SELECT * FROM visualsRequests WHERE userID=".$user."  AND submitted=0 ORDER BY uid LIMIT 1",0,0);
		$count = 0;
		$ping = 9;
		$row = mysqli_fetch_array($result);
		$uid = $row['uid'];
		
		while(($ping == 9) && ($count < 4)) {
			$count++;
			if(is_null($row['file'.$count])) {
				$ping = 1;
			}
		}
		$out['count'] = $count;
		$out['uid'] = $uid;
		$out['full'] = $ping;
		return $out;
	}


	function checkTotalRoundUp($tempTotal){
		
				if($tempTotal <= 100){
					//echo "Less or equal 100 <br />";
					$valRound =  $tempTotal;
				}
				if($tempTotal >= 100 && $tempTotal <= 1000){
					//echo "Greater 100/Less than 1k  <br />";
					$valRound =  roundUp($tempTotal, 10);
				}
				if($tempTotal >= 1000 && $tempTotal <= 5000){
					//echo "Greater 1000/Less than 5k  <br />";
					$valRound =  roundUp($tempTotal, 50);
				} 
				if($tempTotal >= 5000){
					//echo "Greater than 5k  <br />";
					$valRound =  roundUp($tempTotal, 100);
				} 
				return $valRound;  
			}
	function roundUp($totalFormat, $num){
			$roundTotal = floor($totalFormat / $num) * $num;
			return $roundTotal;
	}

	function skinnedLoginPricing($showPricing, $loginSkinnedSite){
		
		switch ($showPricing) {
			case 0:
				$custShowPricing = 0;
				break;
			case 1:
				$custShowPricing = 1;
				break;
			case 2: 
				if($loginSkinnedSite ==  2){
					$custShowPricing = 1;
				}else{
					$custShowPricing = 0;
				}
				break;
		} 
		return $custShowPricing;
		 
	}


	/* slider */
	function eachBannerCheck($url){
		$urlGiven = $url; 
		$toCheck   = 'trendscollection';  
		 
		 if( strpos( $urlGiven, $toCheck) !== false) {
			//$eachBannerUrl = substr($urlGiven, 0, 26); 
			//$eachBannerUrl =  str_replace($toCheck, "", $urlGiven);
			$exploded_url = explode('/', $urlGiven); 
			  
			if(count($exploded_url) > 1){
				$exploaded = $exploded_url[0];  
				if( strpos( $urlGiven, $exploaded) !== false) {
					$eachBannerUrl =  str_replace($exploaded, "", $urlGiven);
				} 
			}else{
				$eachBannerUrl = "//".$urlGiven;
			} 

		}else{
			$eachBannerUrl = $urlGiven;
		}  
		return $eachBannerUrl;
	}

	function getFullUrl(){
		$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
			"https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
			$_SERVER['REQUEST_URI']; 

		return $link; 
	}

	function checkTarget($opts){ 
		if($opts == 1){
			$target = '_blank ';
		}else{
			$target = '';
		}
		return $target;
	} 

	function checkPopup($opts){ 
		if($opts == 1){
			$pops = array(0 => 'iframe', 1 => 'branding', 2=> '');
		} 
		if($opts == 0){
			$pops = array(0 => '', 1 => '', 2=> '');
		}
		if($opts == 2){
			$pops = array(0 => '', 1 => '', 2=> '_blank');
		}
		return $pops;
	} 
	/* slider */

?>