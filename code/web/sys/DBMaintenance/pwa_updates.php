<?php
/** @noinspection SqlResolve */
function getPWAUpdates() {
	return [
		'create_pwa_module' => [
			'title' => 'Create Progressive Web App Module',
			'description' => 'Setup Progressive Web Application module',
			'sql' => [
				"INSERT INTO modules (name, indexName, backgroundProcess) VALUES ('PWA', '', '')",
			],
		],
		'create_pwa_settings' => [
			'title' => 'Create PWA Settings',
			'description' => 'Create database table for progressive web app settings',
			'sql' => [
				"CREATE TABLE `pwa_settings` (
					`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`name` varchar(50) NOT NULL,
					`autoRotateCard` tinyint(1) DEFAULT 0,
					`enableSelfRegistration` tinyint(4) DEFAULT 0,
					`showMoreInfoBtn` tinyint(1) DEFAULT 1,
					`manifestID` varchar(50) NOT NULL,
					`startURL`  varchar(50) DEFAULT '/',
					`slug`  varchar(50) NOT NULL,
					`sha256CertFingerprint`  varchar(200) NOT NULL,
					`firebaseAPIKey` varchar(50) NOT NULL,
					`firebaseAuthDomain` varchar(50) NOT NULL,
					`firebaseProjectID` varchar(50) NOT NULL,
					`firebaseStorageBucket` varchar(50) NOT NULL,
					`firebaseMessagingSenderID` varchar(50) NOT NULL,
					`firebaseAppID` varchar(50) NOT NULL,
					`firebaseMeasurementID` varchar(50) NOT NULL,
					`vapidKey` varchar(50) NOT NULL,
				  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;"
			]
		]
	];
}