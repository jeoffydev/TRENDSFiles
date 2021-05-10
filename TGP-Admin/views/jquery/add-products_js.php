<?php

 

$sql= getProductsBeta($table); 

if($sql == 0){
    $sql = array('');
}

?>

<script>

   
      
var obj = [];
var arr = []; 
var functionObject = function() {
        var results = [];
        obj = <?php echo json_encode($sql); ?>; 
        var newCount = obj.length - 1;
        for(var x= 0; x <= newCount; x++){  
            arr.push(obj[x]);  
        } 
        //console.log(newCount);
        return arr; 
   
};
  
   
data =   functionObject(); 

$('#newproducts').jexcel({
    data:data, 
    colHeaders: ['Code', 'Name', 'Size', 'Category1', 'Category2', 'Category3', 'Category4', 'Category5', 'Category6', 'Category7', 'Category8', 'Status', 'Description' , 'Dimension1', 'Dimension2', 'Dimension3', 'sizingLine1', 'sizingLine2', 'sizingLine3', 'sizingLine4', 'PrintType1', 'PrintDescription1', 'PrintType2', 'PrintDescription2', 'PrintType3', 'PrintDescription3', 'PrintType4', 'PrintDescription4', 'PrintType5', 'PrintDescription5', 'PrintType6', 'PrintDescription6', 'PrintType7', 'PrintDescription7', 'PrintType8', 'PrintDescription8', 'PrintType9', 'PrintDescription9', 'PrintType10', 'PrintDescription10', 'Colours', 'ColoursSecondary', 'video', 'Packing', 'cartonLength', 'cartonWidth', 'cartonHeight', 'cartonWeight', 'cartonQuantity', 'Keywords', 'ColorSearch', 'StockComment', 'PenIndent', 'PlacementWeighting',  'ImageCount',  'FullColour',  'IsMixMatch',  'IsPen',  'StockWizDisable',  'PDFDisable',  'Active',  'ExclusiveItem',  'visualsAvailable',  'IsIndent', 'IsIndentExpress',  'featuredItem', 'HitSKU', 'Materials', 'Specifications' ],
    colWidths: [ 90, 300, 60, 60, 60, 60, 60, 60, 60, 60, 60, 60, 200, 60, 60, 60, 60, 60, 60, 60, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200, 60, 200],
    columns: [
        { type: 'numeric' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },

        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },

        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },

        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },

        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'text' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'text' },

        { type: 'text' },
        { type: 'text' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },

        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'text' },
        { type: 'text' },
        { type: 'numeric' },
        { type: 'numeric' },
        { type: 'text' },
        { type: 'text' }, 
    ]
}); 



$( "#getDataButton" ).click(function() {
   var dataString = $('#newproducts').jexcel('getData', false);
    console.log(dataString);
     
    $.ajax({
			url: '<?php echo $baseUrl; ?>/angu-post/add-products_js_post.php',
			type: 'POST',
			data: {
                option: 1, 
                many: dataString.length,
				dataString: JSON.stringify(dataString), 
			}, 
			dataType: "html",
			success: function (result) { 
                console.log(result);
                location.reload();
			}
	});	 

});

$( "#deleteDataButton" ).click(function() {
    if (confirm("Are you sure you want to delete all the items on productsCurrentBeta?")) { 
        $.ajax({
			url: '<?php echo $baseUrl; ?>/angu-post/add-products_js_post.php',
			type: 'POST',
			data: {
				option: 2,  
			}, 
			dataType: "html",
			success: function (result) { 
                console.log(result);
                location.reload();
			}
	    });	 
    }
});  

</script>