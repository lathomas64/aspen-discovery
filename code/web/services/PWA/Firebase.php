<?php

require_once ROOT_DIR . '/Action.php';
require_once ROOT_DIR . '/sys/PWA/Setting.php';

class PWA_Firebase extends Action {

	function launch() {
		header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('content-type: text/javascript; charset=utf-8');
		http_response_code(200);
		echo "if (typeof navigator.serviceWorker !== 'undefined') {
					console.log('sup');
					navigator.serviceWorker.register('/interface/themes/responsive/js/aspen/serviceWorker.js',{
						type: 'module'
					})
				}";
	}

	function getBreadcrumbs(): array {
		return [];
	}
}
?>