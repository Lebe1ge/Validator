(function () {
	
	var app = angular.module('connect', []);
	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', function ($http, $scope) {
				var sitemap = '';
				$scope.urls = {};
				
				////////////////////////////////////////////////////
				////////////// FONCTION DECOUP + W3C ///////////////
				////////////////////////////////////////////////////
				function callback(url_sitemap) {
					if (url_sitemap !== '') {
						$http.get('./decoupage.php?sitemap=' + url_sitemap)
						.success(function (data) {
							$scope.urls = data;
							//console.log(data);
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
							sitemap = data;
							callback(sitemap);
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
