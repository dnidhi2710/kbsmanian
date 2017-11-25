app.controller('chaParentController', ['$scope', '$location', '$window',
	function ($scope, $location, $window) {
		/* Config */
		$scope.locationPath = window.location.hash;
		$scope.activeMenu = function (path, type) {
			if (type !== null) {
				$location.path("/" + path + "/" + type);
			} else {
				$location.path("/" + path);

			}
		}

	}]);
