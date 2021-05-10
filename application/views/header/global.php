 

<?php   
/* Global variables after controllers */

$randNum = rand();

/* User Login */
$siteLogcheckLoggedIn = $siteLogcheck['loggedIn'];
$siteLogcheckUserDatasCount = count($siteLogcheck['userDatas']);

if($siteLogcheckUserDatasCount > 0): 
    echo "Logged In";
    $userCustomerName = $siteLogcheck['userDatas'][0]->CustomerName;
    $userCustomerNumber = $siteLogcheck['userDatas'][0]->CustomerNumber;
    $userID = $siteLogcheck['userDatas'][0]->userID;
    $userAcct = $siteLogcheck['userDatas'][0]->userAcct;
    $userEmail = $siteLogcheck['userDatas'][0]->userEmail;
    $userType = $siteLogcheck['userDatas'][0]->userType;
    $userMultiCurrency = $siteLogcheck['userDatas'][0]->multiCurrency;
    $userQuoteStyle = $siteLogcheck['userDatas'][0]->quoteStyle;
    $userFreightStyle = $siteLogcheck['userDatas'][0]->freightStyle;
    $userApiReq = $siteLogcheck['userDatas'][0]->apiReq;
    $userApiAcc = $siteLogcheck['userDatas'][0]->apiAcc;
    $userSkinnedWebsites = $siteLogcheck['userDatas'][0]->skinnedWebsites;
    $userCustomSiteUser = $siteLogcheck['userDatas'][0]->customSiteUser;
    $userMarkup1 = $siteLogcheck['userDatas'][0]->markup1;
    $userMarkup2 = $siteLogcheck['userDatas'][0]->markup2;
    $userMarkup3 = $siteLogcheck['userDatas'][0]->markup3;
    $userMarkup4 = $siteLogcheck['userDatas'][0]->markup4;
    $userMarkup5 = $siteLogcheck['userDatas'][0]->markup5;
    $userMarkup6 = $siteLogcheck['userDatas'][0]->markup6;
    $userSetupMarkup = $siteLogcheck['userDatas'][0]->setupMarkup;
    $userQuickQuoteComment = $siteLogcheck['userDatas'][0]->quickQuoteComment;
    $userVisualAccess = $siteLogcheck['userDatas'][0]->visualAccess;
    $userCurrency = $siteLogcheck['userDatas'][0]->Currency;
    $userThemedSiteMax = $siteLogcheck['userDatas'][0]->ThemedSiteMax;
endif;    

/* Skinnedsite or skinned  user */

$customThemeArrayCount = count($customArray['themeArray']);
$mainPage = strtoupper($customArray['customHome']);


?> 
 