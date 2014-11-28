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
				//////////////// AFFICHAGE ERREURS /////////////////
				////////////////////////////////////////////////////
				
				$scope.tab_err = -1;
				$scope.isSet_err = function (checkTab_err) {
					return $scope.tab_err === checkTab_err;
				};

				$scope.setTab_err = function (setTab_err) {
					if($scope.tab_err == setTab_err)
						setTab_err = -1;
					$scope.tab_err = setTab_err;
				};
				////////////////////////////////////////////////////
								
				////////////////////////////////////////////////////
				//////////////// AFFICHAGE WARNING /////////////////
				////////////////////////////////////////////////////
				
				$scope.tab_warn = -1;
				$scope.isSet_warn = function (checkTab_warn) {
					return $scope.tab_warn === checkTab_warn;
				};

				$scope.setTab_warn = function (setTab_warn) {
					if($scope.tab_warn == setTab_warn)
						setTab_warn = -1;
					$scope.tab_warn = setTab_warn;
				};
				////////////////////////////////////////////////////
				
				
				////////////////////////////////////////////////////
				////////////// FONCTION DECOUP + W3C ///////////////
				////////////////////////////////////////////////////
				function callback(url_sitemap) {
					if (url_sitemap !== '') {
						$http.get('./decoupage.php?sitemap=' + url_sitemap)
						.success(function (data) {
							$scope.urls = data;
							console.log(data);
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
