
<?php
    $this->load->view('header/header');
    
    $characters = '01234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

?> 
 
<div class="container-fluid">
	<div class="jumbotron customer" >
        <div class="row">
            <div class="col-md-6"> <h2>Order Dashboard  </h2> </div>
            <div class="col-md-6 "> 

                <?php 

                    if($CustomerOrdersCount >= 300 && $displayAll == 0){
                        $CustomerOrdersCountDisplay = 300; 
                    }else{ 
                        $CustomerOrdersCountDisplay = $CustomerOrdersCount;
                    }	

                ?>
                <div class="row margin-top-less top-dashboard" >
                    <div class="col-md-3"> 
                            &nbsp;
                    </div>
                    <div class="col-md-6 text-left"> 
                            <ul class="ullistkey">
                                <li><span class="listkey" ><span class="square yellow"></span> Pre-Production </span> </li>
                                <li><span class="listkey" ><span class="square teal"> </span> In Production  </span> </li>
                                <li><span class="listkey" ><span class="square green"> </span> Complete </span>  </li>
                            </ul>    
                             
                    </div>
                    
                    <div class="col-md-3 paginationbtns text-right">
                            <div class="row dashboard-pagination" ng-cloak >
                                        <div class="col-md-6 text-right"     ng-class="tableTwo == true? 'col-md-11' : '' ">  
                                            <small ng-if="tableOne" class="inlineblock">Page {{currentPage}} of   {{noOfPages}}   </small> 
                                            <small ng-if="tableTwo"  class="inlineblock ">Page 1 of 1 </small>
                                    
                                        </div>
                                        <div class="col-md-4 text-left"> 
                                            <uib-pagination ng-hide="tableTwo" ng-click="closePopup()" total-items="totalItems" max-size= "maxSizeValue" items-per-page="entryLimit" next-text=">" previous-text="<" ng-model="currentPage" max-size="noOfPages" class="pagination-sm"  boundary-link-numbers="true"></uib-pagination>  
                                        </div>
                                </div>
                    </div>
                </div>
             
                
                
            </div>
        </div>
        
	</div>
</div>
<div class="main-customer-wrapper" >
    <div class="container-fluid div-tables" >
        <div class="row heading" ng-cloak>
            <div class="col-md-1 start" ng-click="closeCalendar()"> 
                
                    <a href="#" ng-click="orderByField='StatusNumber'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="The current status of your order in our production system." > Status<span ng-show="orderByField == 'StatusNumber'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                                                    
                                                    <!--<ul class="dropdown-customers"> 
                                                            <li>
                                                                <span class="select-drop" ng-if="!statusIncludesFound">--Select-- </span>
                                                                <span class="select-drop" ng-if="statusIncludesFound" ng-cloak >{{statusIncludesDisplay}}</span>
                                                                <ul class="dropdown" ng-cloak >
                                                                    <li  ><span class="clickall" ng-click="selectAllStatus()" ng-if="selectAllStat">[Select All]</span>  <span ng-if="unselectAllStat" class="clickall" ng-click="unselectAllStatus()">[Unselect All]</span> </li>
                                                                    <li ng-repeat ="chk in statusCheckBoxes" ><label for="{{$index}}{{chk}}"> <input id="{{$index}}{{chk}}" type="checkbox" ng-click="includeStatus(chk)" ng-model="checkboxesStatus[$index]"/> {{chk}} </label> </li>
                                                                
                                                                </ul>
                                                            </li> 
                                                    </ul> -->

                                                    <select ng-model="queryQ.checkboxesStatusQ" ng-change="timeoutChange()"  class="select-input"  ng-options="chk  for chk in statusCheckBoxes"> 
                                                        <option value="">-- Select --</option>
                                                    </select>
            </div>
            <div class="col-md-1 pon-column" ng-click="closeCalendar()"> 
                <a class="display-block" href="#" ng-click="orderByField='PON'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Your Purchase Order number."> PO # <span ng-show="orderByField == 'PON'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.PONQ" ng-change="timeoutChange()" maxlength="50">
            </div>
            <div class="col-md-1  ordernum" ng-click="closeCalendar()">
                <a href="#" ng-click="orderByField='SalesOrder'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="TRENDS order number."> Order # <span ng-show="orderByField == 'SalesOrder'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.SalesOrderQ" ng-change="timeoutChange()" maxlength="7">
            </div>
            <div class="col-md-1 col-more productdesc" ng-click="closeCalendar()"> 
                <a href="#" ng-click="orderByField='ProductDescription'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Product name"> Product<span ng-show="orderByField == 'ProductDescription'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.ProductDescriptionQ" ng-change="timeoutChange()" maxlength="50">
            </div>
            <div class="col-md-1 col-more" ng-click="closeCalendar()">
                <a href="#" ng-click="orderByField='JobDescription'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="TRENDS reference to the job, usually the most dominant text within the artwork. "> Job Desc.<span ng-show="orderByField == 'JobDescription'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.JobDescriptionQ" ng-change="timeoutChange()" maxlength="50">
            </div>
            <div class="col-md-1 col-more-light" ng-click="closeCalendar()">
                <a href="#" ng-click="orderByField='DecorationProcess'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="The decoration method for the order."> Decoration <span ng-show="orderByField == 'DecorationProcess'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                                                        

                                                       <!--<ul class="dropdown-customers"> 
                                                            <li>
                                                                <span class="select-drop" ng-if="!decorationIncludesFound">--Select-- </span>
                                                                <span class="select-drop" ng-if="decorationIncludesFound" ng-cloak >{{decorationIncludesDisplay}}</span>
                                                                <ul class="dropdown" ng-cloak >
                                                                    <li  ><span class="clickall" ng-click="selectAllDecorations()" ng-if="selectAll">[Select All]</span>  <span ng-if="unselectAll" class="clickall" ng-click="unselectAllDecorations()">[Unselect All]</span> </li>
                                                                    <li ng-repeat ="chk in decorationsCheckBoxes" ><label for="{{$index}}{{chk}}"> <input id="{{$index}}{{chk}}" type="checkbox" ng-click="includeDecorations(chk)" ng-model="checkboxes[$index]"/> {{chk}} </label> </li>
                                                                
                                                                </ul>
                                                            </li> 
                                                        </ul>  -->

                                                         <select ng-model="queryQ.checkboxesDecorationsQ" ng-change="timeoutChange()"  class="select-input  "  ng-options="chk  for chk in decorationsCheckBoxes"> 
                                                            <option value="">-- Select --</option>
                                                        </select>
                                                        
            </div>
            <div class="col-md-1 col-less qty-column" ng-click="closeCalendar()">
                <a href="#" ng-click="orderByField='Quantity'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Quantity ordered." >Qty <span ng-show="orderByField == 'Quantity'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.QuantityQ" ng-change="timeoutChange(); checkNumber(1, queryQ.QuantityQ)" maxlength="7" >
            </div>
            <div class="col-md-1 col-value " ng-click="closeCalendar()">
                <div class="padding-value"> 
                    <a href="#" ng-click="orderByField='OrderValue'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Total value of the order, excluding GST."> Value <span ng-show="orderByField == 'OrderValue'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                    <input type="text" class="filter-input col-md-12" ng-model="queryQ.OrderValueQ" ng-change="timeoutChange(); checkNumber(2, queryQ.OrderValueQ)" maxlength="7">
                </div>
            </div>
            <div class="col-md-1 col-lesser order-date">
                <a href="#" ng-click="orderByField='OrderDateParse'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="The date the order was received by TRENDS."> Order Date <span ng-show="orderByField == 'OrderDateParse'" ng-cloak><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <!--<input type="text" class="filter-input col-md-12 date-picker" ng-model="tempdates.thisOrderDateTemp" ng-change="changeOrderDate(tempdates.thisOrderDateTemp)"    ng-click="calendarOrderDate(calendarOpen)">-->
                <input type="text" class="filter-input col-md-12 date-picker" ng-model="queryQ.OrderDateTextbox" ng-change="inputChange()"    ng-click="calendarOrderDate(calendarOpen)">
                                                        
                                                        <div class="absolute-datepicker "  ng-if="calendarOpen" ng-cloak >
                                                            <!--<div uib-datepicker ng-model="ThisDate.OrderDate" class="well well-sm" datepicker-options="options" ng-change="selectDateOrder(ThisDate.OrderDate)" ></div>-->
                                                            <div uib-datepicker ng-model="queryQ.OrderDate" class="well well-sm" datepicker-options="options" ng-change="timeoutChange()" max-date="maxDate"  ></div> 
                                                            <!--<span class="btn btn btn-primary  btn-block" ng-click="selectDateOrder(ThisDate.OrderDate)"  >Select</span>-->
                                                        </div>
            </div>
            <div class="col-md-1 col-lesser">
                <a href="#" ng-click="orderByField='ShipDateParse'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Expected ship date from TRENDS. Please note, this is an estimate only until the order is approved."> Ship Date <span ng-show="orderByField == 'ShipDateParse'" ng-cloak><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <!--<input type="text" class="filter-input col-md-12  date-picker" ng-model="tempdates.thisShipDateTemp" ng-change="changeShipDate(tempdates.thisShipDateTemp)"  ng-click="calendarShipDate(calendarOpenShip)">-->
                <input type="text" class="filter-input col-md-12  date-picker" ng-model="queryQ.ShipDateTextbox" ng-change="inputChange()"  ng-click="calendarShipDate(calendarOpenShip)">
                                                        <div class="absolute-datepicker "  ng-if="calendarOpenShip" ng-cloak >
                                                            <!--<div uib-datepicker ng-model="ThisDate.ShipDate" class="well well-sm" datepicker-options="options" ng-change="selectDateShip(ThisDate.ShipDate)"  ></div> -->
                                                            <div uib-datepicker ng-model="queryQ.ShipDate" class="well well-sm" datepicker-options="options"  ng-change="timeoutChange()" ></div> 
                                                            <!--<span class="btn btn btn-primary  btn-block" ng-click="selectDateShip(ThisDate.ShipDate)"  >Select</span>-->
                                                        </div>
            </div>
            <div class="col-md-1" style="max-width: 9%;" ng-click="closeCalendar()"> 
                <a href="#" class="display-block" ng-click="orderByField='EmailContact'; reverseSort = !reverseSort; closePopup()" data-toggle="tooltip" data-placement="top" title="Email contact for the order."> Email  <span ng-show="orderByField == 'EmailContact'"><span ng-show="!reverseSort"> <i class="fa fa-caret-up"></i> </span><span ng-show="reverseSort"> <i class="fa fa-caret-down"></i> </span></span></a>
                <input type="text" class="filter-input col-md-12" ng-model="queryQ.EmailContactQ" ng-change="timeoutChange()" maxlength="255">
            </div>
            <div class="col-md-1 col-lesser" style="max-width: 5.3%;"  ng-click="closeCalendar()">
                <span data-toggle="tooltip" data-placement="top" title="Invoice Number and access to the PDF Invoice.">Invoice</span>
                <input type="text" class="filter-input col-md-11" ng-model="queryQ.InvoiceQ"  ng-change="timeoutChange(); checkNumber(3, queryQ.InvoiceQ)" maxlength="7">
            </div>
            <div class="col-md-1 col-less" ng-click="closeCalendar()"> <span data-toggle="tooltip" data-placement="top" title="PDF artwork proof for the order.">Proof</span> </div>
            <div class="col-md-1 col-less" ng-click="closeCalendar()"><span data-toggle="tooltip" data-placement="top" title="Photo of the finished product.">Photo</span></div>
            
            <div class="col-md-1 col-less" style="max-width:4%; flex: 0 0 4%;"  ng-click="closeCalendar()"><span data-toggle="tooltip" data-placement="top" title="Online tracking for an order." style="position:relative; left: 5px">Track </span></div> 
        </div>  
        
        <p class="text-center margin-top" ng-show="loading"><img src="<?php echo base_url();?>Images/loading-dashboard.gif" width="50" height="50"/> Loading... </p>



                    
        <!-- Row loop ONE With Filter-->  
        <div class="abouttext" style="min-height:660px;" ng-cloak ng-show="tableOne"   >    <!--<span id="appendThisToCount"  > {{filtered.length}} </span>  -->
            
            <div class="col-md-12 text-center margin-top"      ng-if="filtered.length == 0 && !loading && tableOne"  > <h5>No Records Found</h5> </div> <!-- For search ===> | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit  -->  
            <div  ng-if="!loading "   id="{{$index}}customerRow"      ng-repeat="customer in filtered=(customers |  myfilter:  thisOrderDate:  thisShipDate: 'ShipDateParse'  | filter:decorationFilter  |   filter:statusNewFilter  | filter:query | filter: query.DecorationProcess : true  | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit     | orderBy:orderByField:reverseSort) as filtered track by $index "  class="{{customer.rowBG}} customertableRow row parentDashboard {{customer.StatusColour}}  "  >
             
                <div class="col-md-1 border-rights start  tooltips" ng-click="getOrderLines($index, customer.SalesOrder)" >  
                    <span class="tooltiptexts"    > {{customer.Status}} </span> 
                    <span class="list-customer status-list-dashboard"     >   {{customer.StatusShort}}  </span> 
                </div>
                <div class="col-md-1  border-rights tooltips pon-column" ng-click="getOrderLines($index, customer.SalesOrder)" > 
                    <span class="tooltiptexts"   > {{customer.PON}}</span>
                    <span class="list-customer po-list-dashboard"    >    {{customer.PONShort}}</span>
                </div>
                <div class="col-md-1   border-rights  ordernum" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"  > <span   > {{customer.SalesOrder}}</span></span>
                </div>
                <div class="col-md-1   border-rights col-more productdesc tooltips" ng-click="getOrderLines($index, customer.SalesOrder)"  > 
                    <span class="tooltiptexts"  > {{customer.ProductDescription }} </span>
                    <span class="list-customer product-list-dashboard"   >    {{customer.ProductDescriptionShort }}</span>
                </div>
                <div class="col-md-1   border-rights  col-more tooltips" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="tooltiptexts"   > {{customer.JobDescription}}</span>
                    <span class="list-customer job-list-dashboard"     >    {{customer.JobDescriptionShort}}</span>
                </div>
                <div class="col-md-1   border-rights col-more-light" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer decoration-list-dashboard"   >  {{customer.DecorationProcess}} </span>
                </div>
                <div class="col-md-1   border-rights col-less text-right qty qty-column" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"   >    {{customer.Quantity | number}}</span>
                </div>
                <div class="col-md-1   border-rights col-value" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer span-value"   >  {{customer.OrderValue |  currency }}</span>
                </div>
                <div class="col-md-1   border-rights col-lesser order-date" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"  >     {{customer.OrderDateParse | date:'dd/MM/yy' }} </span>
                </div>
                <div class="col-md-1   border-rights col-lesser" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer" ng-if="customer.StatusNumber >= 8 " >     {{customer.ShipDateParse | date:'dd/MM/yy'}}</span>
                </div>
                <div class="col-md-1   border-rights tooltips" style="max-width: 9%;"  ng-click="getOrderLines($index, customer.SalesOrder)" > 
                    <span class="tooltiptexts emailtooltip"  > {{customer.EmailContact}}</span>
                    <span class="list-customer email-list-dashboard"     > {{customer.EmailContactShort}} </span>
                </div>
                <div class="col-md-1   border-rights col-lesser" style="max-width: 5.3%;">
                    <span class="list-customer"  ng-if="customer.HasInvoice == 1"  >   <a href="<?=base_url();?>files?pdf=1&{{customer.JobNumberEncrypt}}" target="_blank" class="invoicelink">{{customer.Invoice}}</a> </span>
                </div>
                <div class="col-md-1   border-rights col-less tooltips text-center"> 
                    <span class="tooltiptexts proof" style="text-transform: none !important;" ng-if="customer.HasProof == 1"  > <a href="<?=base_url();?>files?proof=1&{{customer.JobNumberEncrypt}}" target="_blank" class="text-white"> Artwork Proof </a> </span>
                    <span class="list-customer link-icon"  ng-if="customer.HasProof == 1"  >   <a href="<?=base_url();?>files?proof=1&{{customer.JobNumberEncrypt}}" target="_blank"> <img src="<?=base_url();?>Images/Dashboard/artwork.png" style="position:relative; top:-3px"/></a> </span>
                </div>
                <div class="col-md-1   border-rights col-less tooltips  text-center">
                    <span class="tooltiptexts proof" style="text-transform: none !important;" ng-if="customer.HasPhoto == 1" ng-click="getPhoto(customer.SalesOrder)" data-toggle="modal" data-target="#photoModal"   > Photo </span>
                    <span class="list-customer customericons"  ng-if="customer.HasPhoto == 1"   > <span class="cursor-point" ng-click="getPhoto(customer.SalesOrder)" data-toggle="modal" data-target="#photoModal"  style="position:relative; left: -2px" > <i class="fa  fa-camera"></i> </span>  </span>
                </div>
                
                <div class="col-md-1 col-less track text-center tooltips" style="max-width:4.9%; flex: 0 0 4.9%;">
                    <span class="tooltiptexts tracking" style="text-transform: none !important;" ng-if="customer.FreightTracking && customer.DeliveryStatus == 'Despatched' "  > <a  href="{{customer.FreightTracking}}" target="_blank" class="text-white" > Once despatched, your shipment can take up to eight hours before it will appear on Track and Trace. </a> </span>
                    <span class="list-customer"   >   <a ng-if="customer.FreightTracking" href="{{customer.FreightTracking}}" target="_blank"  style="color:#63676b; font-size:11px" > <!--<i class="fa  fa-truck"></i>--> <u>{{customer.DeliveryStatus}}</u> </a> </span>
                </div>    

                <div class="myProgress {{$index}}myProgress" style="display:none">
                    <div id="{{$index}}loadingBar" class="loadingBar"></div>
                </div>

                <div class="col-md-12 popcustomer {{$index}}customerRow">   
                                                
                        <div class="row" ng-cloak>
                       
                                <div ng-class="(customer.FreightInstructions && customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' ) || (customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ) ||  (customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;') || (customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;') || (customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;') || (customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;') ? 'col-md-7 border-right' : 'border-right col-md-9' ">
                                       
                                        <div  ng-bind-html="OrderTable | trust"></div>
                                         <!--div ng-if="orderLines && orderLines != 'none' " ng-bind-html="orderLines | trust"></div>-->
                                        <span ng-if="orderLines == 'none' ">No data</span>
                                </div>  
                                <div class="col-md-2 freight border-right" ng-if="(customer.FreightInstructions && customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' ) || (customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ) ||  (customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;') || (customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;') || (customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;') || (customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;') ">
                                                        <p class="ordertitle"><b>Delivery Address:</b></p>
                                                        
                                                    
                                                        <span ng-if="customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ">{{customer.ShipAddress1}}</span> 
                                                        <span ng-if="customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;'">{{customer.ShipAddress2}}</span> 
                                                        <span ng-if="customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;'">{{customer.ShipAddress3}}</span> 
                                                        <span ng-if="customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;'">{{customer.ShipAddress4}}</span> 
                                                        <span ng-if="customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;'">{{customer.ShipAddress5}}</span> 
                                                        
                                                        
                                                        <p class="margin-top" ng-if="customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' "><b>Freight Instructions:</b><br /> <span >{{customer.FreightInstructions}} </span></p>


                                </div> 

                                <div class="col-md-3 border-right">
                                    <p class="ordertitle"><b>Time Stamps:</b></p> 

                                    <table class="table">
                                        
                                        <tbody>
                                            <tr> 
                                                <td>Order Received</td>
                                                <td>{{OrderReceived}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Last Proofed</td>
                                                <td>{{LastProofed}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Order Approved</td>
                                                <td>{{OrderApproved}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Dispatched</td>
                                                <td>{{Dispatched}} </td> 
                                            </tr>
                                            <tr ng-show="Delivered"> 
                                                <td>Delivered</td>
                                                <td>{{Delivered}} </td> 
                                            </tr>
                                            
                                        </tbody>
                                    </table>


                                </div>

                        </div>  

                        <div class="row margin-top"> 
                            <div class="col-md-4 text-right">
                                &nbsp;
                            </div>
                            <div class="col-md-5 text-right">  
                                 
                                <p  class=" text-right buttonrepeat  buttonRepeat{{customer.SalesOrder}} "  style="max-width:96%; margin-top:1.2%" ng-if="POD" > <span class="btn btn-teal text-white  " data-toggle="modal" data-target="#podModal" ng-click="podImage(POD, Signatory, Delivered)">Proof of Delivery </span> </p>  
                            </div>
                            <div class="col-md-3 text-right">
                                <p  class=" text-right buttonrepeat  buttonRepeat{{customer.SalesOrder}} "  style="max-width:96%; margin-top:1.2%" ng-if="customer.StatusNumber >= 8 " > <span class="btn btn-teal text-white  " data-toggle="modal" data-target="#repeatOrderModal" ng-click="repeatOrder($index, customer)">Place Repeat Order </span> </p>  
                            </div>
                        </div>    
                        
                       
                </div> 
                
               


            </div> 
        </div>     
        <!-- Row loop ONE--> 






 
        <!-- Row loop TWO --> 
        <div class="abouttext" style="min-height:660px;" ng-cloak ng-show="tableTwo"         >     
            <div class="col-md-12 text-center margin-top"   ng-if="filtered2.length == 0 && !loading && tableTwo"  > <h5>No Records Found</h5> </div> <!-- For search ===> | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit  -->  
            <div  ng-if="!loading "   id="{{$index}}customerRow"   ng-repeat="customer in filtered2=(customers |  myfilter:  thisOrderDate:  thisShipDate: 'ShipDateParse'  | filter:decorationFilter  |   filter:statusNewFilter  | filter:query | filter: query.DecorationProcess : true  |   limitTo:searchLimit     | orderBy:orderByField:reverseSort) as filtered2 track by $index "  class="{{customer.rowBG}} customertableRow row parentDashboard {{customer.StatusColour}}  "  >
                
                   
                <div class="col-md-1 border-rights start  tooltips" ng-click="getOrderLines($index, customer.SalesOrder)" >  
                    <span class="tooltiptexts"    > {{customer.Status}} </span> 
                    <span class="list-customer status-list-dashboard"     >   {{customer.StatusShort}}  </span> 
                </div>
                <div class="col-md-1  border-rights tooltips pon-column" ng-click="getOrderLines($index, customer.SalesOrder)" > 
                    <span class="tooltiptexts"   > {{customer.PON}}</span>
                    <span class="list-customer po-list-dashboard"    >    {{customer.PONShort}}</span>
                </div>
                <div class="col-md-1   border-rights  ordernum" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"  > <span   > {{customer.SalesOrder}}</span></span>
                </div>
                <div class="col-md-1   border-rights col-more productdesc tooltips" ng-click="getOrderLines($index, customer.SalesOrder)"  > 
                    <span class="tooltiptexts"  > {{customer.ProductDescription }} </span>
                    <span class="list-customer product-list-dashboard"   >    {{customer.ProductDescriptionShort }}</span>
                </div>
                <div class="col-md-1   border-rights  col-more tooltips" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="tooltiptexts"   > {{customer.JobDescription}}</span>
                    <span class="list-customer job-list-dashboard"     >    {{customer.JobDescriptionShort}}</span>
                </div>
                <div class="col-md-1   border-rights col-more-light" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer decoration-list-dashboard"   >  {{customer.DecorationProcess}} </span>
                </div>
                <div class="col-md-1   border-rights col-less text-right qty qty-column" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"   >    {{customer.Quantity | number}}</span>
                </div>
                <div class="col-md-1   border-rights col-value" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer span-value"   >  {{customer.OrderValue |  currency }}</span>
                </div>
                <div class="col-md-1   border-rights col-lesser order-date" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer"  >     {{customer.OrderDateParse | date:'dd/MM/yy' }} </span>
                </div>
                <div class="col-md-1   border-rights col-lesser" ng-click="getOrderLines($index, customer.SalesOrder)" >
                    <span class="list-customer" ng-if="customer.StatusNumber >= 8 " >     {{customer.ShipDateParse | date:'dd/MM/yy'}}</span>
                </div>
                <div class="col-md-1   border-rights tooltips" style="max-width: 9%;"  ng-click="getOrderLines($index, customer.SalesOrder)" > 
                    <span class="tooltiptexts emailtooltip"  > {{customer.EmailContact}}</span>
                    <span class="list-customer email-list-dashboard"     > {{customer.EmailContactShort}} </span>
                </div>
                <div class="col-md-1   border-rights col-lesser" style="max-width: 5.3%;">
                    <span class="list-customer"  ng-if="customer.HasInvoice == 1"  >   <a href="<?=base_url();?>files?pdf=1&{{customer.JobNumberEncrypt}}" target="_blank" class="invoicelink">{{customer.Invoice}}</a> </span>
                </div>
                <div class="col-md-1   border-rights col-less tooltips text-center"> 
                    <span class="tooltiptexts proof" style="text-transform: none !important;" ng-if="customer.HasProof == 1"  > <a href="<?=base_url();?>files?proof=1&{{customer.JobNumberEncrypt}}" target="_blank" class="text-white"> Artwork Proof </a> </span>
                    <span class="list-customer link-icon"  ng-if="customer.HasProof == 1"  >   <a href="<?=base_url();?>files?proof=1&{{customer.JobNumberEncrypt}}" target="_blank"> <img src="<?=base_url();?>Images/Dashboard/artwork.png" style="position:relative; top:-3px"/></a> </span>
                </div>
                <div class="col-md-1   border-rights col-less tooltips  text-center">
                    <span class="tooltiptexts proof" style="text-transform: none !important;" ng-if="customer.HasPhoto == 1" ng-click="getPhoto(customer.SalesOrder)" data-toggle="modal" data-target="#photoModal"   > Photo </span>
                    <span class="list-customer customericons"  ng-if="customer.HasPhoto == 1"   > <span class="cursor-point" ng-click="getPhoto(customer.SalesOrder)" data-toggle="modal" data-target="#photoModal"  style="position:relative; left: -2px" > <i class="fa  fa-camera"></i> </span>  </span>
                </div>
                
                <div class="col-md-1 col-less track text-center tooltips" style="max-width:4.9%; flex: 0 0 4.9%;">
                    <span class="tooltiptexts tracking" style="text-transform: none !important;" ng-if="customer.FreightTracking   && customer.DeliveryStatus == 'Despatched'  "  > <a  href="{{customer.FreightTracking}}" target="_blank" class="text-white" > Once despatched, your shipment can take up to eight hours before it will appear on Track and Trace. </a> </span>
                    <span class="list-customer"   >   <a ng-if="customer.FreightTracking" href="{{customer.FreightTracking}}" target="_blank" style="color:#63676b; font-size:11px" > <!--<i class="fa  fa-truck"></i>--> <u> {{customer.DeliveryStatus}}</u> </a> </span>
                </div>    

                <div class="myProgress {{$index}}myProgress" style="display:none">
                    <div id="{{$index}}loadingBar" class="loadingBar"></div>
                </div>

                <div class="col-md-12 popcustomer {{$index}}customerRow">   
                                                
                        <div class="row" ng-cloak>
                       
                                <div ng-class="(customer.FreightInstructions && customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' ) || (customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ) ||  (customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;') || (customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;') || (customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;') || (customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;') ? 'col-md-7 border-right' : 'border-right col-md-9' ">
                                       
                                        <div  ng-bind-html="OrderTable | trust"></div>
                                        
                                        <span ng-if="orderLines == 'none' ">No data</span>
                                </div>  
                                <div class="col-md-2 freight border-right" ng-if="(customer.FreightInstructions && customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' ) || (customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ) ||  (customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;') || (customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;') || (customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;') || (customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;') ">
                                                        <p class="ordertitle"><b>Delivery Address:</b></p>
                                                        
                                                    
                                                        <span ng-if="customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;' ">{{customer.ShipAddress1}}</span> 
                                                        <span ng-if="customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;'">{{customer.ShipAddress2}}</span> 
                                                        <span ng-if="customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;'">{{customer.ShipAddress3}}</span> 
                                                        <span ng-if="customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;'">{{customer.ShipAddress4}}</span> 
                                                        <span ng-if="customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;'">{{customer.ShipAddress5}}</span> 
                                                        
                                                        
                                                        <p class="margin-top" ng-if="customer.FreightInstructions != '' && customer.FreightInstructions != '.' && customer.FreightInstructions != ' ' && customer.FreightInstructions != '&nbsp;' "><b>Freight Instructions:</b><br /> <span >{{customer.FreightInstructions}} </span></p>


                                </div> 

                                <div class="col-md-3 border-right">
                                    <p class="ordertitle"><b>Time Stamps:</b></p> 

                                    <table class="table">
                                        
                                        <tbody>
                                            <tr> 
                                                <td>Order Received</td>
                                                <td>{{OrderReceived}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Last Proofed</td>
                                                <td>{{LastProofed}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Order Approved</td>
                                                <td>{{OrderApproved}} </td> 
                                            </tr>
                                            <tr> 
                                                <td>Dispatched</td>
                                                <td>{{Dispatched}} </td> 
                                            </tr>
                                            <tr ng-show="Delivered"> 
                                                <td>Delivered</td>
                                                <td>{{Delivered}} </td> 
                                            </tr>
                                            
                                        </tbody>
                                    </table>


                                </div>

                        </div> 
                        
                        <div class="row margin-top"> 
                            <div class="col-md-4 text-right">
                                &nbsp;
                            </div>
                            <div class="col-md-5 text-right"> 
                                <p  class=" text-right buttonrepeat  buttonRepeat{{customer.SalesOrder}} "  style="max-width:96%; margin-top:1.2%" ng-if="POD" > <span class="btn btn-teal text-white  " data-toggle="modal" data-target="#podModal" ng-click="podImage(POD, Signatory, Delivered)">Proof of Delivery </span> </p>  
                            </div>
                            <div class="col-md-3 text-right">
                                <p  class=" text-right buttonrepeat  buttonRepeat{{customer.SalesOrder}} "  style="max-width:96%; margin-top:1.2%" ng-if="customer.StatusNumber >= 8 " > <span class="btn btn-teal text-white  " data-toggle="modal" data-target="#repeatOrderModal" ng-click="repeatOrder($index, customer)">Place Repeat Order </span> </p>  
                            </div>
                        </div>    
                         
                         
                </div> 
                
               


            </div> 
        </div>     
       <!-- Row loop TWO -->                                     

    </div> 


        <div class="container-fluid"> 
            <!-- Pagination -->

            <div class="row margin-top  top-dashboard" >
                    
                    <div class="col-md-6 bottom text-left"> 
                           &nbsp;     
                    </div>
                    
                    <div class="col-md-6  bottom text-right">
                            <div class="row dashboard-pagination" style="position:relative; left: -6%" ng-cloak >
                                        <div class="col-md-11 text-right"     ng-class="tableTwo == true? 'col-md-11' : '' ">  
                                            <small ng-if="tableOne" class="inlineblock">Page {{currentPage}} of   {{noOfPages}}   </small> 
                                            <small ng-if="tableTwo"  class="inlineblock ">Page 1 of 1 </small>
                                    
                                        </div>
                                        <div class="col-md-1 text-left"> 
                                            <uib-pagination ng-hide="tableTwo" total-items="totalItems" max-size= "maxSizeValue" items-per-page="entryLimit" next-text=">" previous-text="<" ng-model="currentPage" max-size="noOfPages" class="pagination-sm"  boundary-link-numbers="true"></uib-pagination>  
                                        </div>
                            </div>
                    </div>
             </div> 
             
            <!-- Pagination -->     
        </div> 
                 
</div>
 

<?php
	$this->load->view('footer/footer');
?> 