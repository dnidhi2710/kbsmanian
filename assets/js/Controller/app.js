'use strict';

var url = "prod"; // dev || staging || prod || offline

var app = angular.module('chaWebApp', ['ngRoute', 'angularSpinner','ngSanitize','ui.bootstrap']);

app.config(['$routeProvider', function ($routeProvider) {
	$routeProvider
		.when('/login', {
			activetab: 'login',
			controller: 'chaLoginController',
			templateUrl: 'assets/templates/login/login.html',
		})
		.when('/importSeaList', {
			activetab: 'importSeaList',
			controller: 'chaImportSeaController',
			templateUrl: 'assets/templates/import_sea/listing.html',
		})
		.when('/createImportSea/:id', {
			activetab: 'importSea',
			controller: 'createOrEditISController',
			templateUrl: 'assets/templates/import_sea/section1.html',
		})
		.when('/importAirList', {
			activetab: 'importAirList',
			controller: 'chaImportAirController',
			templateUrl: 'assets/templates/import_air/listing.html',
		})
		.when('/createImportAir/:id', {
			activetab: 'importAir',
			controller: 'createOrEditIAController',
			templateUrl: 'assets/templates/import_air/section1.html',
		})
		.when('/exportAirSeaList/:type', {
			activetab: 'exportAirSeaList',
			controller: 'chaExportAirController',
			templateUrl: 'assets/templates/export_air_sea/listing.html',
		})
		.when('/createExport/:id/:type', {
			activetab: 'exportAirSea',
			controller: 'createOrEditExportController',
			templateUrl: 'assets/templates/export_air_sea/section1.html',
		})
		.when('/exportSeaList/:type', {
			activetab: 'exportAirSeaList',
			controller: 'chaExportSeaController',
			templateUrl: 'assets/templates/export_sea/listing.html',
		})
		.when('/createExportSea/:id/:type', {
			activetab: 'exportAirSea',
			controller: 'createOrEditExportSeaController',
			templateUrl: 'assets/templates/export_sea/section1.html',
		})
		.otherwise({
			redirectTo: '/importSeaList'
		});
}]);

