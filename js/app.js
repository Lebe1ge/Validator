(function () {
	
	var app = angular.module('connect', []);
	
	app.controller('SitemapController', [ '$scope', function ($scope) {
	}]);
	
	
	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', function ($http, $scope) {
				var sitemap = '';
				$scope.urls = {};
				
				////////////////////////////////////////////////////
				//////////// AFFICHAGE ERREURS /////////////////////
				
				$scope.tab = -1;
				$scope.isSet = function (checkTab) {
					return $scope.tab === checkTab;
				};

				$scope.setTab = function (setTab) {
					if($scope.tab == setTab)
						setTab = -1;
					$scope.tab = setTab;
				};
				
				////////////////////////////////////////////////////////
				
				
				function callback(url_sitemap) {
					if (url_sitemap !== '') {
						$http.get('./decoupage.php?sitemap=' + url_sitemap)
						.success(function (data) {
							$scope.urls = data;
						}).error(function (data, status, headers, config) {
							console.log("ERREUR");
						});
					}
					else 
					{ console.log("Sitemap VIDE"); }
				}
				
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
            }],
            controllerAs: "search"
        };
    });
})();
