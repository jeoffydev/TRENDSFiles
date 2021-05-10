 

<?php   
    /* Google Anayltics */
    $trendsDomain = 'trends.nz';  
?>
<script type="text/javascript">
<?php 
if(count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->googleAnalyticsID){
    $googleAnalyticsID = $customArray['themeArray'][0]->googleAnalyticsID;

    if($customSiteDomain = $customArray['themeArray'][0]->Domain){  
        
        $firstW = substr($customSiteDomain, 0, 4);  
        if($firstW != 'www.'){
            $customSiteDomainFin = $customSiteDomain; 
        }else{
            $customSiteDomainFin = substr($customSiteDomain, 4); 
        }
      
        $dom = $customSiteDomainFin; 

    }else{ 
        $dom = $trendsDomain; 
    }  ?>

            var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $googleAnalyticsID; ?>']);
        _gaq.push(['_setDomainName', '<?php echo $dom; ?>']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_trackPageview']);  
  
<?php }else{  ?>
            var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-147122271-1']);
        _gaq.push(['_setDomainName', '<?php echo $trendsDomain; ?>']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_trackPageview']);  
<?php } ?> 
 
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
 