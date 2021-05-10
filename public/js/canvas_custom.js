  
var element = $("#datagrid8"); // global variable
var theCanvas; // global variable


    $("#btnSave1").on('click', function () { 
		triggerImage();
	});  
	$("#btnSave2").on('click', function () { 
		triggerImage();
	});  
	 
	$("#btnSaveNZD").on('click', function () { 
		triggerImage();
	}); 
	
	$("#btnSaveAUD").on('click', function () { 
		triggerImage();
	}); 

	$("#btnSave").on('click', function () { 
		triggerImage();
	}); 

	$("#btnSaveSkinnedsite").on('click', function () { 
		 triggerImage();
		console.log("Skinned site button")
	}); 

  function updateQuote(){
	  //alert("Testing");
	  triggerImage();
  }	

  function downloadQuoteImage(){ 
	  triggerImage(1);
  }	



	 
  function triggerImage(optQuote){
			var optQuote = optQuote || null;
			   
		 
			$('#img-out img').remove();
			 

			$(".hidequote").css("display","block");
			$("#removeImg").remove();  
			var scaleBy = 2;
			var w = 949;
			var h = 600;
			var div = document.querySelector('#datagrid8');
			var testcanvas = document.createElement('canvas');
			testcanvas.width = w;
			testcanvas.height = h;
			testcanvas.style.width = w + 'px';
			testcanvas.style.height = h + 'px'; 
			var context = testcanvas.getContext('2d');
  			context.scale(2, 2);

			html2canvas(div).then(canvas => {
			 //console.log(canvas);
			 //document.body.appendChild(canvas)
			 var ctx = canvas.getContext('2d');
			 ctx.webkitImageSmoothingEnabled = false;
			 ctx.mozImageSmoothingEnabled = false;
			 ctx.imageSmoothingEnabled = false;

						var link = canvas.toDataURL("image/png;base64;");
						//console.log(link);
						$( "#filterUpdateComment" ).removeData( "info" );
						var imageName  = $('#filterUpdateComment').data('info'); 

						if(optQuote == 1){
							Canvas2Image.saveAsPNG(canvas);
							generateImage(link); 
							 $(".hidequote").css("display","none"); 
							
							return;
						}

						
						//Update 
						
						
						if(optQuote == 2){   
							//console.log("eto imageName = " + imageName);
							closeDelete(imageName); 
							$(".hidequote").css("display","none");
							return;
						}

						//console.log("eto imageName = " + imageName);
						if (typeof imageName !== "undefined" || imageName !== null || imageName !== "undefined" ) { 
							closeDelete(imageName);
						}
						if(!optQuote){
							//console.log("Napunta rito?");
							generateImage(link); 
						}
						
					
						$(".hidequote").css("display","none");
					


			});
			 

			/*
			 
			 html2canvas(div, {
				canvas:canvas,
				onrendered: function (canvas) {  
					theCanvas = canvas;
				 
					var link = canvas.toDataURL("image/png;base64;");

					$( "#filterUpdateComment" ).removeData( "info" );
			  		var imageName  = $('#filterUpdateComment').data('info'); 

					if(optQuote == 1){
						Canvas2Image.saveAsPNG(canvas);
						$(".hidequote").css("display","none"); 
					}

					 
					//Update 
					
					
					if(optQuote == 2){   
						closeDelete(imageName); 
						$(".hidequote").css("display","none");
						return;
					}

					console.log("eto imageName = " + imageName);
					if (typeof imageName !== "undefined" || imageName !== null || imageName !== "undefined" ) { 
						closeDelete(imageName);
					}
					  
					 generateImage(link); 
				 
					$(".hidequote").css("display","none");
				} 
			}); */
  }

	function closeDelete(imageName) {  
				//console.log(imageName);
				$.post("/Canvas/CanvasPost",{ mode: 2, imgName: imageName }); 
	}

  	function generateImage(link){

					$.post("/Canvas/CanvasPost",{ mode: 1, imgBase64: link }, function( data ) {
						 
						 var dataParse = data.split('~');
						 //console.log(dataParse);
						 if(dataParse[0]==1) { 
							 var url = '//' + window.location.host;
							 $('#img-out').html('<img src="'+url+'/QuickQuoteIMG/'+dataParse[1]+'.png" />'); 
							 id = '/QuickQuoteIMG/'+dataParse[1]+'.png';
							 $('#filterUpdateComment').attr('data-info', id);
						 } else {
							 console.log("error");
						 }
					 });  
  	}
	 