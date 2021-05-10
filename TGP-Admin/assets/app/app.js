// Define the `phonecatApp` module
var tgpApp = angular.module('tgpApp',    ['ui.sortable', 'ngFileUpload', 'angularUtils.directives.dirPagination', 'textAngular', 'colorpicker.module']); 

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
  /*return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl) {
      ctrl.$render = function () {
          var value = ctrl.$viewValue || '';
          elm.val(value);

      }
      ctrl.$parsers.unshift(function(viewValue) {
        var FLOAT_REGEXP = /^\-?\d+(\.\d+)?$/;

        if (FLOAT_REGEXP.test(viewValue)) {
          ctrl.$setValidity('float', true);
          return parseFloat(Math.round(viewValue * 100) / 100).toFixed(2);

        } else {
          ctrl.$setValidity('float', false);
         return undefined;
        }
      });
        elm.bind('keyup', function () {

          scope.$apply(function () {
            //console.log(ctrl.$valid)
            if(ctrl.$valid){
              viewValue=ctrl.$viewValue || '';
              ctrl.$setViewValue(parseFloat(Math.round(viewValue * 100) / 100).toFixed(2));
              elm.val(ctrl.$viewValue);
            }else{
              ctrl.$viewValue=''
              elm.val('');

            }
          });
        });
    }
  }; */

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
       
/*   
tgpApp.controller('bodyController', function bodyController($scope) {
  $scope.phones = [
    {
      name: 'Nexus S',
      snippet: 'Fast just got faster with Nexus S.',
      age: 1
    }, {
      name: 'Motorola XOOM™ with Wi-Fi',
      snippet: 'The Next, Next Generation tablet.',
      age: 2
    }, {
      name: 'MOTOROLA XOOM™',
      snippet: 'The Next, Next Generation tablet.',
      age: 3
    }
  ];
  $scope.orderProp = 'age';
}); */

 /*
tgpApp.controller("demoCtrl",function($scope){
  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = '<?php echo $my_demos; ?>';
  $scope.orderProp="name";                
});   */