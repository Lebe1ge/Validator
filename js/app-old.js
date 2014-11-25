	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', function ($http, $scope) {
                $scope.addSearch = function (url) {
                    if (url.$valid) {
                        $scope.urls = [{'name': $scope.search.url}];
                        $scope.urls.push({ "name": $scope.search.url});
						
						$http.get('./exec.php?url='+$scope.search.url).success(function (data) {
							$scope.urls= data;
						}).error(function (data, status, headers, config) {
                            alert("failure message: " + JSON.stringify({data: data}));
						});

                    }
                };
				                $scope.addSearch = function (url) {
                    if (url.$valid) {
					
						
						
						
						$http.get('./exec.php?url='+$scope.search.url).success(function (data) {
							$scope.urls= data;
						}).error(function (data, status, headers, config) {
                            alert("failure message: " + JSON.stringify({data: data}));
						});

                    }
                };
            }],
            controllerAs: "search"
        };
    });
	
	app.controller('SitemapController', ['$http', function($http){
		var store = this;
		store.products = [];
		$http.get('/store-products.json').success( function(data){
			store.products = data;
		});
	}];

    app.directive("resultat", function () {
        return {
            restrict: 'E',
            templateUrl: "result.php",
            controller: ['$http', function ($http) {
                var sitemap = this;
                sitemap.urls = [];
                $http.get('./sitemap.json').success(function (data) {
                    sitemap.urls = data;
                });
            }],
            controllerAs: "sitemap"
        };
    });