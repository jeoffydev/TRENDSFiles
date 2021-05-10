
		<div ng-repeat="detail in details">	

				<p ng-if="detail.Description"><strong>Description</strong><br /> {{detail.Description}} </p>
				 
				<p ng-if="detail.availCountryDetails"><strong>Delivery Limitations</strong><br /> {{detail.availCountryDetails}} </p>

				<p ng-if="detail.Colours"><strong>Colours</strong><br /> {{detail.Colours}} 
					<span ng-if="detail.ColoursSecondary"><br />{{detail.ColoursSecondary}}</span>
					<span ng-if="detail.ThirdColours"><br />{{detail.ThirdColours}}</span>
				 	<span ng-if="detailsPMS" ng-click="getPMS(detail.Code, detail.Name)" class="cursorpoint"  ><br /><u>PMS Colours  </u></span></p>
				 
				
											
				<div ng-if="detail.sizingLine1 == '' ">
					<p ng-if="detail.Dimension1"><strong>Dimensions</strong><br /> {{detail.Dimension1}} <span ng-if="detail.Dimension2"><br /> {{detail.Dimension2}}</span> <span ng-if="detail.Dimension3"><br /> {{detail.Dimension3}}</span> </p>
				</div>

				<div ng-if="detail.sizingLine1">
					<strong>Sizes</strong><br /> <div ng-bind-html="PreviewTableResult | trust"></div>
				</div>

				<p ng-if="detail.Materials">
					<strong>Materials</strong><br /> {{detail.Materials}} 
				</p>

				<div ng-if="detail.PrintType1 || detail.PrintType2" class="detailBranding">
					<strong>Branding Options</strong><br />    
					<!--
					<p><span ng-if="detail.PrintType1" ng-click="getPopup(detail.PrintType1)" > <strong> <span ng-bind-html="detail.PrintType1A | trust"></span><span class="cursorpoint" ng-show="IEBrowser">{{detail.PrintType1}}</span>:</strong> {{detail.PrintDescription1}} <br /> </span>
                        <span ng-if="detail.PrintType2" ng-click="getPopup(detail.PrintType2)"  > <strong><span ng-bind-html="detail.PrintType2A | trust"></span><span class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType2}}</span>:</strong> {{detail.PrintDescription2}}<br />  </span>
                        <span ng-if="detail.PrintType3" ng-click="getPopup(detail.PrintType3)"  > <strong><span ng-bind-html="detail.PrintType3A | trust"></span><span class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType3}}</span>:</strong> {{detail.PrintDescription3}}<br />  </span>
                        <span ng-if="detail.PrintType4" ng-click="getPopup(detail.PrintType4)"  > <strong><span ng-bind-html="detail.PrintType4A | trust"></span><span class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType4}}</span>:</strong> {{detail.PrintDescription4}}<br />  </span>
                        <span ng-if="detail.PrintType5" ng-click="getPopup(detail.PrintType5)"  > <strong><span ng-bind-html="detail.PrintType5A | trust"></span><span class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType5}}</span>:</strong> {{detail.PrintDescription5}}<br /> </span>
                        <span ng-if="detail.PrintType6" ng-click="getPopup(detail.PrintType6)"  > <strong><span ng-bind-html="detail.PrintType6A | trust"></span><span class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType6}}</span>:</strong> {{detail.PrintDescription6}}<br /> </span>
                        <span ng-if="detail.PrintType7" ng-click="getPopup(detail.PrintType7)"  > <strong><span ng-bind-html="detail.PrintType7A | trust"></span><span class="cursorpoint"   ng-show="IEBrowser">{{detail.PrintType7}}</span>:</strong> {{detail.PrintDescription7}}<br />  </span>
                        <span ng-if="detail.PrintType8" ng-click="getPopup(detail.PrintType8)"  > <strong><span ng-bind-html="detail.PrintType8A | trust"></span><span  class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType8}}</span>:</strong> {{detail.PrintDescription8}}<br />  </span>
                        <span ng-if="detail.PrintType9" ng-click="getPopup(detail.PrintType9)"  > <strong><span ng-bind-html="detail.PrintType9A | trust"></span><span  class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType9}}</span>:</strong> {{detail.PrintDescription9}} <br /> </span>
                        <span ng-if="detail.PrintType10" ng-click="getPopup(detail.PrintType10)"  > <strong><span ng-bind-html="detail.PrintType10A | trust"></span><span  class="cursorpoint"  ng-show="IEBrowser">{{detail.PrintType10}}</span>:</strong> {{detail.PrintDescription10}}  </span>
					</p> -->
					<p style="margin-top:4px;"><span ng-if="detail.PrintType1" > <strong  ng-if="detail.PrintType1 != '...' "> <span ng-click="getPopup(detail.PrintType1Popup)"  ng-bind-html="detail.PrintType1 | trust" ></span></strong> <span style="display:block"  ng-bind-html="detail.PrintDescription1 | trust"></span> </span>
                        <span ng-if="detail.PrintType2"  > <strong ng-if="detail.PrintType2 != '...' "><span ng-click="getPopup(detail.PrintType2Popup)"  ng-bind-html="detail.PrintType2 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription2 | trust"></span> </span>
                        <span ng-if="detail.PrintType3"   > <strong ng-if="detail.PrintType3 != '...' "><span ng-click="getPopup(detail.PrintType3Popup)" ng-bind-html="detail.PrintType3 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription3 | trust"></span> </span>
                        <span ng-if="detail.PrintType4"   > <strong ng-if="detail.PrintType4 != '...' "><span ng-click="getPopup(detail.PrintType4Popup)" ng-bind-html="detail.PrintType4 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription4 | trust"></span> </span>
                        <span ng-if="detail.PrintType5"  > <strong ng-if="detail.PrintType5 != '...' "><span ng-click="getPopup(detail.PrintType5Popup)"  ng-bind-html="detail.PrintType5 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription5 | trust"></span> </span>
                        <span ng-if="detail.PrintType6"  > <strong ng-if="detail.PrintType6 != '...' "><span ng-click="getPopup(detail.PrintType6Popup)"  ng-bind-html="detail.PrintType6 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription6 | trust"></span> </span>
                        <span ng-if="detail.PrintType7"  > <strong ng-if="detail.PrintType7 != '...' "><span ng-click="getPopup(detail.PrintType7Popup)"  ng-bind-html="detail.PrintType7 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription7 | trust"></span> </span>
                        <span ng-if="detail.PrintType8"  > <strong ng-if="detail.PrintType8 != '...' "><span ng-click="getPopup(detail.PrintType8Popup)"  ng-bind-html="detail.PrintType8 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription8 | trust"></span>  </span>
                        <span ng-if="detail.PrintType9"   > <strong ng-if="detail.PrintType9 != '...' "><span ng-click="getPopup(detail.PrintType9Popup)" ng-bind-html="detail.PrintType9 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription9 | trust"></span> </span>
                        <span ng-if="detail.PrintType10"   > <strong ng-if="detail.PrintType10 != '...' "><span ng-click="getPopup(detail.PrintType10Popup)" ng-bind-html="detail.PrintType10 | trust" ></span></strong> <span style="display:block" ng-bind-html="detail.PrintDescription10 | trust"></span> </span>
					</p> 
					
				</div>

				<!--<div ng-if="detail.PenIndent > 0 ">
					<strong>Indent</strong><br />
					<p>Available on indent with printing for a minimum of {{detail.PenIndent}} pcs. Indent printing areas may vary from those illustrated.</p>
				</div>-->

				<div ng-if="packagingCalc">
					<strong>Packaging</strong><br />
					<p>{{detail.Packing}}<br />
                        <strong>Carton Dimensions:</strong> {{cL}} cm x {{cW}} cm x  {{cH}} cm <br />
                        <strong>Carton Cube:</strong> {{totalCartonCube}} m&sup3; <br />
                        <span ng-if="cQ"> <strong>Carton Quantity:</strong>  {{cQ}} pieces <br /></span>
                        <span ng-if="cWt"> <strong>Carton Weight:</strong>  {{cWt}}kg</span>
					</p>
				</div>
											

		</div>
 