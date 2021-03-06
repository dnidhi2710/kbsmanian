app.controller('chaImportAirController', ['$scope', '$location', '$window', '$http', 'usSpinnerService', 'dbConfigService',
	function ($scope, $location, $window, http, spinner, dbConfigService) {
		/* Config */
		init();

		function init() {
			spinner.spin('spinner-1');
			var url = dbConfigService.getUrl() + "getSummary/getSummaryData.php";
			var obj = {
				'action': "get_import_air"
			};
			http.post(url, obj).then(function (response) {
				if (angular.isDefined(response.data) && response.data.status === 'success') {
					$scope.getImportData = response.data.data;
					spinner.stop('spinner-1');
				} else {
					spinner.stop('spinner-1');
				}
			});
		}
		$scope.section1 = true;
		$scope.section2 = false;
		$scope.section3 = false;
		$scope.section4 = false;
		$scope.section5 = false;
		$scope.section6 = false;
		$scope.section7 = false;
		
		$scope.yearValue = dbConfigService.getJobid();
		$scope.navigate = function (id) {
			id = encodeSlash(id);
			$location.path("/createImportAir/" + id);
		}

		function encodeSlash(jobid) {
			jobid = jobid.replace(/[/]/g, "?");
			return jobid;
		}
		$scope.activeMenu = function (val) {
			if (val == 1) {
				$scope.section1 = true;
				$scope.section2 = false;
				$scope.section3 = false;
				$scope.section4 = false;
				$scope.section5 = false;
				$scope.section6 = false; ß
				$scope.section7 = false;
			}
			else if (val == 2) {
				$scope.section1 = false;
				$scope.section2 = true;
				$scope.section3 = false;
				$scope.section4 = false;
				$scope.section5 = false;
				$scope.section6 = false;
				$scope.section7 = false;
			}
			else if (val == 3) {
				$scope.section1 = false;
				$scope.section2 = false;
				$scope.section3 = true;
				$scope.section4 = false;
				$scope.section5 = false;
				$scope.section6 = false;
				$scope.section7 = false;
			}
			else if (val == 4) {
				$scope.section1 = false;
				$scope.section2 = false;
				$scope.section3 = false;
				$scope.section4 = true;
				$scope.section5 = false;
				$scope.section6 = false;
				$scope.section7 = false;
			}
			else if (val == 5) {
				$scope.section1 = false;
				$scope.section2 = false;
				$scope.section3 = false;
				$scope.section4 = false;
				$scope.section5 = true;
				$scope.section6 = false;
				$scope.section7 = false;
			}
			else if (val == 6) {
				$scope.section1 = false;
				$scope.section2 = false;
				$scope.section3 = false;
				$scope.section4 = false;
				$scope.section5 = false;
				$scope.section6 = true;
				$scope.section7 = false;
			}
			else if (val == 7) {
				$scope.section1 = false;
				$scope.section2 = false;
				$scope.section3 = false;
				$scope.section4 = false;
				$scope.section5 = false;
				$scope.section6 = false;
				$scope.section7 = true;
			}
		}


	}]);