<?php
require_once ROOT_DIR . '/Action.php';

class Custom_Test extends Action {
    function launch() {
		global $interface;

        //replace this with whatever code you want to test
		//$interface->assign('showBreadcrumbs', false);
        $interface->assign('errorMessage', "Replace this with whatever you want to test in Custom/Test.php");
		$this->display('default.tpl', 'Testing Ground!', false);
	}

	function getBreadcrumbs(): array {
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
        $breadcrumbs[] = new Breadcrumb('', 'Create Custom');
		return $breadcrumbs;
	}
}
?>