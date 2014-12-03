(function () {
	
	var app = angular.module('connect', []);
	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', '$timeout', function ($http, $scope, $timeout) {
				var url_sitemap = '';
				$scope.sitemap = {};
				$scope.urls = [];
								
				////////////////////////////////////////////////////
				//////////////// FONCTION VALIDATOR ////////////////
				////////////////////////////////////////////////////
				function validator(url) {
					
							// onComplete: function() {$timeout(validator($scope.sitemap[key++].loc), 10000);}})
							$http.get('./recup.php?url=' + url)
									  
							.success(function (data) {
								$scope.urls.push(data);
								if(++$scope.key < $scope.sitemap.length)
									//$timeout(validator($scope.sitemap[key].loc),5000)
									$timeout(function() {validator($scope.sitemap[$scope.key].loc);}, 1000);
							}).error(function (data, status, headers, config) {
								console.log("ERREUR");
							});
					
				}
				////////////////////////////////////////////////////
				
				////////////////////////////////////////////////////
				////////////// FONCTION DECOUP + W3C ///////////////
				////////////////////////////////////////////////////
				function callback(url_sitemap) {
					if (url_sitemap !== '') {
						$http.get('./decoupage.php?sitemap=' + url_sitemap)
						.success(function (data) {
						 	$scope.sitemap = data;
							if ($scope.sitemap !== '') {
								$scope.key = 0;
								//for (var key = 0; key < $scope.sitemap.length; ++key)
						 		//{
						 			//url = $scope.sitemap[key].loc;
									//$interval(validator(url), 10000);
									//validator(url);
									validator($scope.sitemap[$scope.key].loc);
						 		//}
						 	}
						}).error(function (data, status, headers, config) {
							console.log("ERREUR");
						});
					}
					else 
					{ console.log("Sitemap VIDE"); }
				}
				////////////////////////////////////////////////////
				
				////////////////////////////////////////////////////
				////////////FONCTION COPIE SITEMAP LOCAL////////////
				////////////////////////////////////////////////////
				$scope.addSearch = function (url) {
					if (url.$valid) {
						
						var url_sitemap = '';
						$scope.sitemap = {};
						$scope.urls = [];
						
						$http.get('./copy_sitemap.php?url=' + $scope.search.url, {onComplete: callback})
						.success(function (data) {
							// Data = URL de la copie sitemap
							callback(data);
						}).error(function (data, status, headers, config) {
							console.log("ERREUR");
						});
					}
                };
				////////////////////////////////////////////////////
            }],
            controllerAs: "search"
        };
    });
})();
