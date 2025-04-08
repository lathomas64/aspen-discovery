<?php
require_once ROOT_DIR . '/Action.php';

class Custom_Template extends Action {
	function launch() {
		global $interface;
		//$interface->assign('showBreadcrumbs', false);
		$interface->assign('errorMessage', 'This is a stub we will do something here');
		$this->display('default.tpl', 'Hello World!', false);
	}

	function getBreadcrumbs(): array {
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('', 'Create Custom');
		return $breadcrumbs;
	}
}
?>