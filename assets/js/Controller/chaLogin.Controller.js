app.controller('chaLoginController', ['$scope', '$location', '$window',
	function ($scope, $location, $window) {
		/* Config */
		$scope.login = {
			'username': '',
			'password': ''
		};

		$scope.validate = function (loginForm) {
			if (!loginForm.$valid) {
				return;
			}

			if ($scope.login.username != '' && $scope.login.password != '') {
				window.location.reload();
				$location.path("importSeaList");
			}
			else {
				alert("Invalid credentials");ß
			}
		}

	}]);