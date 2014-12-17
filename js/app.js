(function () {

	var app = angular.module('connectController', ['ng']);
	
	app.directive("search", function () {
        return {
            restrict: 'E',
            templateUrl: "search.php",
            controller: ['$http', '$scope', '$timeout', function ($http, $scope, $timeout) {
				var url_sitemap = '';
				$scope.sitemap = {};
				$scope.urls = [];
				$scope.message = '';
				$scope.progress = 0;
				var nberreur =0;
				var nbwarning =0;
				$scope.value = [];
				$scope.value["warning"] = [];
				$scope.value["error"] = [];
				$scope.pause = 0;
				$scope.pauseKey = '';
				$scope.nonTraite = 0;
				$scope.searchUrl = '';

				$scope.stop = function(){
					if ($scope.pause == 1)
					{
						$scope.pause = 0;
						validator($scope.pauseKey);
					}
					else
						$scope.pause = 1;
				}
				////////////////////////////////////////////////////
				////////////////  FONCTION COULEUR  ////////////////
				////////////////////////////////////////////////////
				$scope.getClass=function( nberreur, nbwarning){
					if( nbwarning > 0)
					{
						if( nberreur > 0)
							return 'bg-danger';
						else
							return 'bg-warning';
					}
					else
						return 'bg-success';
				};
				////////////////////////////////////////////////////
				
				////////////////////////////////////////////////////
				////////////// FONCTION ACTIVE BOUTON //////////////
				////////////////////////////////////////////////////
				$scope.changeClassError = function($index){
						if ($scope.value["error"][$index] == $index)
							$scope.value["error"][$index] = "vide";
						 else
							$scope.value["error"][$index] = $index;
				};
				$scope.changeClassWarning = function($index){
						if ($scope.value["warning"][$index] == $index)
							$scope.value["warning"][$index] = "vide";
						 else
							$scope.value["warning"][$index] = $index;
				};
				
				////////////////////////////////////////////////////

				////////////////////////////////////////////////////
				//////////////// FONCTION VALIDATOR ////////////////
				////////////////////////////////////////////////////
				function validator(url) {
					
							$http.get('./recup.php?url=' + url)
									  
							.success(function (data) {
								if(data.loc == "undefined")
									$scope.nonTraite++;
								else
									$scope.urls.push(data);
								
								if($scope.pause == 0)
								{
									if(++$scope.key < $scope.sitemap.length){
										$scope.value["warning"][$scope.key] = "vide";
										$scope.value["error"][$scope.key] = "vide";
										$timeout(function() {validator($scope.sitemap[$scope.key].url);}, 3000);
									}
								}
								else
								{
									$scope.pauseKey = $scope.sitemap[++$scope.key].loc;
								}

								$scope.progress = ($scope.key/$scope.sitemap.length)*100;
								
							}).error(function (data, status, headers, config) {
								console.log("ERREUR");
							});
				}
				////////////////////////////////////////////////////
				
				////////////////////////////////////////////////////
				///////////////  FONCTION DECOUPAGE  ///////////////
				////////////////////////////////////////////////////
				$scope.addSearch = function (url) {
					if (url.$valid) {
						var extension = $scope.search.url.substring($scope.search.url.lastIndexOf("."))
						if(extension.toLowerCase() == ".xml")
						{
							$scope.message = '';
							$scope.urls = [];
							$scope.pause = 0;
							$scope.pauseKey = 0;
							$scope.nonTraite = 0;

							$http.get('./decoupage.php?sitemap=' + $scope.search.url)
							.success(function (data) {
								console.log(data);
								$scope.sitemap = data;
								if ($scope.sitemap !== '') 
								{
									$scope.key = 0;
									$scope.value["warning"][$scope.key] = "vide";
									$scope.value["error"][$scope.key] = "vide";
									validator($scope.sitemap[$scope.key].url);
								}
							}).error(function (data, status, headers, config) {
								console.log("ERREUR");
							});
						}
						else
						{
							$scope.message = 'Merci de saisir une URL de la forme http://www.monsite.fr/sitemap.xml';
							$scope.search.url = '';
						}
					}
                };
				////////////////////////////////////////////////////
            }],
            controllerAs: "search"
        };
    });
})();
