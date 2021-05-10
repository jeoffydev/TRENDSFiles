
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

<div class="jumbotron">
        <h1>Oooops – Not Found</h1>
        <p class="lead">Sorry, the page you requested does not exist.  </p>
        <p><a class="btn btn-lg btn-success" href="/" role="button">Go Back to Main Page</a></p>
</div>

<?php include('footer.php') ?>