// Define the `phonecatApp` module
var tgpApp = angular.module('tgpApp',    ['ui.sortable', 'ngFileUpload', 'angularUtils.directives.dirPagination', 'textAngular', 'colorpicker.module', 'ngSanitize', 'ui.select', 'infinite-scroll', 'ngclipboard', 'ngRangeSlider', 'slick', 'ui.bootstrap']); 



tgpApp.directive("fileInput", function($parse){  
  return{  
       link: function($scope, element, attrs){  
            element.on("change", function(event){  
                 var files = event.target.files;  
                 //console.log(files[0].name);  
                 $parse(attrs.fileInput).assign($scope, element[0].files);  
                 $scope.$apply();    
                 //console.log(element[0].files);  
                 $scope.uploadFile();
            });  
       }  
  }  
});  
 


tgpApp.directive('allowOnlyNumbers', function () {  
            return {  
                restrict: 'A',  
                link: function (scope, elm, attrs, ctrl) {  
                    elm.on('keydown', function (event) {  
                        if (event.which == 64 || event.which == 16) {  
                            // to allow numbers  
                            return false;  
                        } else if (event.which >= 48 && event.which <= 57) {  
                            // to allow numbers  
                            return true;  
                        } else if (event.which >= 96 && event.which <= 105) {  
                            // to allow numpad number  
                            return true;  
                        } else if ([8, 13, 27, 37, 38, 39, 40].indexOf(event.which) > -1) {  
                            // to allow backspace, enter, escape, arrows  
                            return true;  
                        } else if(event.which == 9){
                           return true;
                        }else {  
                            event.preventDefault();  
                            // to stop others  
                            return false;  
                        }  
                    });  
                }  
            }  
        });  

 
tgpApp.directive('smartFloat', function() {
  
  return {  
    restrict: 'A',  
    link: function (scope, elm, attrs, ctrl) {  
        elm.on('keydown', function (event) {  
          
            if (event.which == 64 || event.which == 16) {  
                // to allow numbers  
                return false;  
            } else if (event.which >= 48 && event.which <= 57) {  
                // to allow numbers  
                return true;  
            } else if (event.which >= 96 && event.which <= 105) {  
                // to allow numpad number  
                return true;  
            } else if ([8, 13, 27, 37, 38, 39, 40].indexOf(event.which) > -1) {  
                // to allow backspace, enter, escape, arrows  
                return true;  
            } else if ( event.which == 190 || event.which == 110){
               return true;  
            }  else {  
                event.preventDefault();  
                // to stop others  
                return false;  
            }  
        });  
    }  
  }  
  
}); 
       

tgpApp.filter('customNumber', function() {
    return function(value) {
        //return parseInt(value, 10); 
        return parseFloat(Math.round(value * 100) / 100).toFixed(2);
    }
})
 
tgpApp.filter("trust", ['$sce', function($sce) {
    return function(htmlCode){
      return $sce.trustAsHtml(htmlCode);
    }
  }]); 

tgpApp.filter('cutTitle', function() {
    return function(value) {
        var count = 20; 
        return value.slice(0, count) + (value.length > count ? "..." : "");
    }
})  


tgpApp.directive('ngEnter', function () { //a directive to 'enter key press' in elements with the "ng-enter" attribute

        return function (scope, element, attrs) {

            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                        scope.$eval(attrs.ngEnter);
                    });

                    event.preventDefault();
                }
            });
        };
})

tgpApp.filter("myfilter", function($filter) {
    return function(items, from, to, dateField) {
      startDate = moment(from);
      endDate = moment(to);
      // console.log(startDate + " / " );
       //console.log(  endDate  );
      return $filter('filter')(items, function(elem) {
        var date = moment(elem[dateField]);
         //console.log(date >= startDate && date <= endDate);
        return date >= startDate && date <= endDate;
     });
    };
});