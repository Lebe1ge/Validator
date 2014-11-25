var services = angular.module('services', []);

services.factory('decoupage', function() {
  var decoupage = {};

  var active = false; // par défaut le service est désactivé

  // Retourne la date et l'heure courante
  var currentDateTime = function() {
    var currentdate = new Date();
    var datetime = currentdate.getDate() + '/' +
                   (currentdate.getMonth() + 1) + '/' +
                   currentdate.getFullYear() + ' ' +
                   currentdate.getHours() + ':' +
                   currentdate.getMinutes() + ':' +
                   currentdate.getSeconds();
    return datetime;
  }

  logger.turnOn = function() {
    active = true;
  };

  logger.turnOff = function() {
    active = false;
  };

  // Retourne le message reçu précédé de la date et de l'heure,
  // avec le niveau d'alerte voulu
	decoupage.retour = function (url) {
		
		$http.get($scope.sitemap).then(function (response) {
			var urlElems = angular.element(response.data.trim()).find("loc");
			for (var i = 0; i < urlElems.length; i++) {
				var url = urlElems.eq(i);
				$scope.urls.push({ name: url.text() });
			}
		});
	};

  return decoupage;
});