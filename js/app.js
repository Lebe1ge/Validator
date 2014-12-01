(function () {
	
	var app = angular.module('connect', []);
	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', function ($http, $scope) {
				var url_sitemap = '';
				$scope.sitemap = {};
				$scope.urls = [];
				$scope.reponse = {};
								
				////////////////////////////////////////////////////
				//////////////// FONCTION VALIDATOR ////////////////
				////////////////////////////////////////////////////
				function validator(url) {
							$http.get('./recup.php?url=' + url)
							.success(function (data) {
								$scope.urls.push(data);
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
						$http.get('./decoupage.php?sitemap=' + url_sitemap, {onComplete: validator})
						.success(function (data) {
						 	$scope.sitemap = data;
							if ($scope.sitemap !== '') {
								for (var key = 0; key < $scope.sitemap.length; ++key)
						 		{
						 			url = $scope.sitemap[key].loc;
						 			setTimeout(validator(url), 10000);
						 		}
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
						
						$http.get('./copy_sitemap.php?url=' + $scope.search.url, {onComplete: callback})
						.success(function (data) {
							// Data = URL du sitemap
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
