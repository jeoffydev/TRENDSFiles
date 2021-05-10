 

<?php  if(count($customArray['themeArray'])>0):  ?> 

    <style type="text/css">
    <?php foreach($customArray['themeArray'] as $theme){ ?>
        
       

        body, a.normalhyperlink, a, h2 span.title-featured, h1, h2, h3, h4, h5, h6, .breadcrumbnew a{
            color: #<? echo $theme->paragraphTextColour; ?> !important; 
        }
        
        <?php if($theme->paragraphTextColour == 'ffffff' || $theme->paragraphTextColour == 'FFFFFF'){  ?>
            .itemproducts .card p, .itemproducts .card h6{
                color:#626469 !important;
            }
        <?php } ?>
         
        body, .modal-content {
            background-color: #<?php echo $theme->BackgroundColour; ?> !important;
        }

        .mainMenu{
            background-color: #<?php echo $theme->headerTrimColour; ?> !important;
        }

        .mainMenu .nav-item a{
            color: #<?php echo $theme->menuHighlightColour; ?> !important;
        }

        .mainMenu .dropdown-item, #navbarSupportedContentMenu .dropdown-item, .headerSearch  .ui-select-choices-row, .ui-select-bootstrap .ui-select-choices-row  > span a, .form-search-top, .hovericons-container{
            color: #63676b !important;
        }

         .border-featured{
            background-color: #<? echo $theme->paragraphTextColour; ?> !important; 
         }
        
        
         .combine_scroll,   .modal-header,  h5.mobile-only,  .btn-skinned  {
            background-color:   #<?php echo $theme->headerBackground; ?> !important;  
            
        } 
        /* Select 2 DROPDOWN SELECT FORM SEARCH 
        .select2-results ul li:hover{
            background-color:   #<?php echo $theme->headerBackground; ?> !important;  
        } 
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color:   #<?php echo $theme->headerBackground; ?> !important;  
        }
        */

         #topBtn{
            background-color:#<?php echo $theme->tabColour; ?>  !important; 
        }

        .categories_menu{
            background-color:#<?php echo $theme->CategoryIconOverlay; ?>  !important; 
        }

        #topBtn i.fa{
            color: #<?php echo $theme->tabTextColour; ?> !important; 
        }
        .categories_menu .nav-item > a{
            color: #<?php echo $theme->tabTextColourHover; ?> !important; 
        }

        .main-menus h5{
            color:   #<?php echo $theme->headerBackground; ?> !important;  
        }
         
     
         .mobile-dropdown-transfer h5.mobile-only, h5.modal-title {
            color: #<? echo $theme->headerTextColour; ?> !important; 
        }
        
        .themeskinned-menu-mobile i {
             color:   #<?php echo $theme->headerBackground; ?> !important;  
        }
         

         #frmSearch .btn-secondary,  .modal-header, .modal-header .close, .btn-skinned, 
        .categories_menu .nav-item .dropdown-menu a:hover, .mainMenu .dropdown-item:hover, .modal-footer .btn-secondary, .modal-content .btn-primary, #navbarSupportedContentMenu .dropdown-item:hover {
            color: #<? echo $theme->headerTextColour; ?> !important; 
        }
        .btn-primary, .btn-primary.disabled, .btn-primary:disabled, #frmSearch .btn-secondary, .modal-footer .btn-secondary{
            background-color: #<?php echo $theme->headerBackground; ?> !important;  
            border-color:#<?php echo $theme->headerBackground; ?> !important;  
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #<?php echo $theme->headerBackground; ?> !important;  
            border-color: #<?php echo $theme->headerBackground; ?> !important;  
        }
        
        /*.dropdown-item:hover{
            background-color:#<?php echo $theme->headerBackground; ?> 
        } */
         
        .table .thead-dark th     { 
            background-color: #<?php echo $theme->tableHeaderColour; ?> !important;
            color: #<?php echo $theme->tableHeaderTextColour; ?> !important; 
        }
        
       
        .table td.groupRightborder{
            border-right: 1px !important;
        }
        .table {
            background-color: #<?php echo $theme->tableCellColour; ?> !important
        }
        .table td{
            color: #<?php echo $theme->tableCellTextColour; ?> !important
        }
        /* Search */
        .headerSearch .ui-select-search:focus{
            box-shadow: 0px 0px 5px 2px #<?php echo $theme->textHighlightColour; ?> !important; 
        }

        div.ui-select-match {
            border: 0px none !important
        }
        .headerSearch .ui-select-container .btn-default, .headerSearch #dropdownMenuButton, .btn-primary.contact-btn{
            background-color: #<? echo $theme->searchBoxColour; ?> !important;
            color: #<? echo $theme->searchBoxTextColour; ?> !important;
            border: 1px solid #<? echo $theme->searchBoxTextColour; ?> !important;
        }
       
        /* .headerSearch  .ui-select-choices-row{
            background-color: #<? echo $theme->searchBoxColour; ?> !important;
            
        } */
        .headerSearch .ui-select-placeholder{
            color: #<? echo $theme->searchBoxTextColour; ?> !important
        }
        /*
        .headerSearch  .ui-select-choices-row-inner div{
            color: #<? echo $theme->searchBoxTextColour; ?> !important
        } */
         
        .ui-select-bootstrap .ui-select-choices-row.active > span, 
        .ui-select-choices-row:hover, 
        .ui-select-choices-row:hover .ui-select-choices-row-inner div,
        .ui-select-choices-row.active .ui-select-choices-row-inner div,
        .ui-select-bootstrap .ui-select-choices-row > span:hover, 
        .ui-select-bootstrap .ui-select-choices-row > span:focus{
            background-color:#<?php echo $theme->tabColour; ?>  !important; 
            color: #<?php echo $theme->tabTextColour; ?> !important; 
        }

        #searchForm_category { 
            border: 0px none;
        }

        /* Tabs */
        .TGPContentTabs a.nav-link,  #accordion .card-header, .mobile-item-accordion .card-header{
            background-color:#<?php echo $theme->tabColour; ?>  !important; 
            border-color:#<?php echo $theme->tabColour; ?>  !important; 
            color: #<?php echo $theme->tabTextColour; ?> !important; 
        }
        .TGPContentTabs a.active {
            color: #<?php echo $theme->tabSelectedText; ?> !important; 
            background-color:#<?php echo $theme->tabSelectedColour; ?>  !important; 
            border-color:#<?php echo $theme->tabSelectedColour; ?>  !important; 
        }
        .mobile-item-accordion .card-header .btn.btn-link{
            color: #<?php echo $theme->tabTextColour; ?> !important; 
        }

        /* Footer */
        .footer-container .row{  
            background-color: #<?php echo $theme->CategoryIconOverlay; ?> 
        }
        .footer-container, .floating-footer{
            background-color: #<?php echo $theme->CategoryIconOverlay; ?> 
        }

        /* Breadcrumbs */
        .btn-breadcrumb .btn-default {  
            color: #<?php echo $theme->tabTextColour; ?> !important;  
        }  
		 .btn-breadcrumb .btn-default {   
            background-color: #<?php echo $theme->tabColour; ?> !important;   
        }
		.btn-breadcrumb .btn-default:not(:first-child) {   
				   -webkit-box-shadow: inset 35px 0px 42px -31px rgba(0,0,0,0.41);
				   -moz-box-shadow: inset 35px 0px 42px -31px rgba(0,0,0,0.41);
				   box-shadow: inset 35px 0px 42px -31px rgba(0,0,0,0.41);
		}
	    .btn-breadcrumb .btn:last-child{ 
            background-color: #<?php echo $theme->tabColour; ?> !important;     
        } 
		.btn-breadcrumb .btn:last-child:hover{ 
            color: #<?php echo $theme->tabSelectedText; ?> !important;    
        } 
		.btn-breadcrumb .btn.btn-default:not(:last-child):after { 
            border-left: 10px solid  #<?php echo $theme->tabColour; ?> !important;       
        }
		.btn-breadcrumb .btn.btn-default:not(:last-child):before { 
            border-left: 10px #<?php echo $theme->tabColour; ?> !important;         
            }

		.btn-breadcrumb .btn-default:hover { 
            background-color: #<?php echo $theme->tabSelectedColour; ?> !important; 
            color: #<?php echo $theme->tabSelectedText; ?> !important;  
        }
		.btn-breadcrumb .btn.btn-default:hover:not(:last-child):after { 
            border-left: 10px solid #<?php echo $theme->tabSelectedColour; ?> !important; 
        }  
		.btn-breadcrumb .btn.btn-default:hover:not(:last-child):before { 
            border-left: 10px solid #<?php echo $theme->tabSelectedColour; ?> !important; 
        }  
		.btn-breadcrumb .btn.btn-default:hover:not(:last-child):before { 
            border-left: 10px solid #<?php echo $theme->tabSelectedColour; ?> !important; 
        }
        .btn-breadcrumb  .btn {
            border-color:#<?php echo $theme->tabColour; ?> !important; 
        }

        .icons-sidebar .icon-box{
            background-color:#<?php echo $theme->tableBorderColour; ?> !important; 
        }
        .breadcrumbnew a:hover{
            color: #<?php echo $theme->tabSelectedColour; ?> !important; 
        }

        <?php list($r, $g, $b) = sscanf($theme->tabColour, "%02x%02x%02x");   ?>
         
        .quickview-images li img:hover, .horizontal-list-img li img:hover{
            box-shadow: 0px 4px 6px rgba(<?php echo $r.", ".$g.", ".$b; ?>, 1)  !important; 
        }

        <?php if($theme->headerBackground == 'ffffff' || $theme->headerBackground == 'FFFFFF'){  ?>
            
           /* SEARCH DROPDOWN COLOR .select2-results ul li:hover{
                color: #<? echo $theme->headerTextColour; ?> !important; 
            } 
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                color: #<? echo $theme->headerTextColour; ?> !important;   
            } */
             
            .headerSearch .ui-select-choices-row.active .ui-select-choices-row-inner div, 
            .headerSearch .ui-select-choices-row:hover .ui-select-choices-row-inner div, 
            .ui-select-bootstrap .ui-select-choices-row.active > span a,  .main-menus h5, .mobile-dropdown-transfer h5.mobile-only{
                color: #<? echo $theme->headerTextColour; ?> !important; 
            }

             .ui-select-choices-row:hover, .ui-select-bootstrap .ui-select-choices-row > span a:hover, .headerSearch .ui-select-choices-row-inner:hover div{  
                 color: #<?php echo $theme->tabTextColour; ?> !important; 
            }
            
        <?php } ?>

        .dropdown-item:hover{
            background-color:#<?php echo $theme->menuHoverBackground; ?> !important; 
        }

        .floating-footer a, .skinnedfooter, .footer-container{
            color:#<?php echo $theme->tabTextColourHover; ?> !important; 
        }

        .navbar-light .navbar-toggler{
            color:#<?php echo $theme->menuHoverBackground; ?> !important; 
        }
        .themeskinned-menu-mobile{
            background-color: #<? echo $theme->menuHoverBackground; ?> !important; 
        }

        /* Select 2 */


       .quickquoteSkinnedsite .btn-dark{ 
            color: #<? echo $theme->headerTextColour; ?> !important; 
        }
        .quickquoteSkinnedsite .btn-dark {
            background-color:   #<?php echo $theme->headerBackground; ?> !important;  
        } 
        .quickquoteSkinnedsite button.close  {
            outline: none !important; 
        }

        
        

        .skinnedQuickButton {
            background-color: #<? echo $theme->tableBorderColour; ?> !important;
            color: #fff !important;
            border:0px !important;
        }

        .modal.quickquoteSkinnedsite .btn{
            background-color: #<?php echo $theme->tableHeaderColour; ?> !important;
            color: #<?php echo $theme->tableHeaderTextColour; ?> !important; 
            border:0px !important;
        }


        .icons-sidebar  .icon-box, .quickquoteSkinnedsite .modal-header{
            background-color: #<? echo $theme->tableBorderColour; ?> !important;
        } 

        .quickquoteSkinnedsite button.close  span, .quickquoteSkinnedsite .modal-header  h4 {
            color: #fff !important;
        }
        /*.icons-sidebar  .icon-box i{
            color: #<? echo $theme->searchBoxTextColour; ?> !important;
        } */
        
       

        #quickQuoteModalSkinnedsite .modal-dialog {
            max-width: 1000px;
        }
        #quickQuoteModalSkinnedsite .modal-header {
            padding: 0.4rem !important;
        }
        .quickquoteSkinnedsite button.close{
            opacity: 1 !important;
        }

        .select2-results ul li:hover{
            background-color: #ddd !important;  
        } 
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #ddd  !important;  
        }

        .select2-results ul li:hover{
                color: #444 !important
        } 
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
                color:  #444 !important  
        } 
        
        /* Select 2 */

        .btn{
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }
        .item-card { 
            min-height: 400px !important;
        }
        .skinnedsearchbox .headerSearch {
            top: 37% !important;
        }
        .skinnedsearchbox .headerSearch.skinnedoriglogo{
            top: 32% !important;
        }
        .skinned_noauth_menu .normal-navtop.skinned_extendable li.nav-item a, .skinned_noauth_menu .normal-navtop.skinned_normal li.nav-item a{
            padding-right: 2.3rem !important;
            padding-left: 2.2rem !important;
        }
        .mobile-dropdown-transfer h5.mobile-only{
            margin-bottom: 0px !important;
        }

        .debossHighlight { 
            background-color: #eced00 !important;
            color: #<?php echo $theme->tableCellTextColour; ?> !important
        }

        .home-indicators .active{
            background-color: #<?php echo $theme->headerBackground; ?> !important;  
        }

        .itemproducts .card-body, .itemproducts .card-title{
            color: #<?php echo $theme->categoryTextColour; ?> !important
        }

        /* Microsoft edge */ 
        @supports (-ms-ime-align: auto) {
            .skinned_noauth_menu .normal-navtop.skinned_extendable li.nav-item a, .skinned_noauth_menu .normal-navtop.skinned_normal li.nav-item a{
                padding-right: 2.2rem !important;
                padding-left: 2.1rem !important;
            }
        }

        

        /* IE 10 + */
     
        @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {    
            .skinned_noauth_menu .normal-navtop.skinned_extendable li.nav-item a, .skinned_noauth_menu .normal-navtop.skinned_normal li.nav-item a{
                padding-right: 2.2rem !important;
                padding-left: 2.1rem !important;
            }
        }
 
       @media screen and (max-width: 768px) {
            #navbarSupportedContentMenu ul.navbar-nav, #navbarSupportedContentMenu ul.navbar-nav li .dropdown-menu,
            #menu_home .navbar-nav li.dropdown .dropdown-menu, .categories_menu {
                background-color:   #<?php echo $theme->headerBackground; ?> !important;  
            
            }
            .mobile-dropdown-transfer a.nav-link, #navbarSupportedContentMenu a.dropdown-item{
               color: #<? echo $theme->headerTextColour; ?> !important; 
           }
            
        }  
        

    <?php } ?>    
    </style>
<?php endif; ?>