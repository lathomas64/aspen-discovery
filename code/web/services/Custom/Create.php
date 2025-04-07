<?php
require_once ROOT_DIR . '/Action.php';

class Custom_Create extends Action {
    function launch() {
		global $interface;
		//$interface->assign('showBreadcrumbs', false);
        $interface->assign('errorMessage', 'TODO: change this to an editor for modules');
		$this->display('default.tpl', 'Create Module ', false);
	}

	function getBreadcrumbs(): array {
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
        $breadcrumbs[] = new Breadcrumb('', 'Create Custom');
		return $breadcrumbs;
	}
}
?>