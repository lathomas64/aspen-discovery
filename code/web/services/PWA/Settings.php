<?php

require_once ROOT_DIR . '/services/Admin/ObjectEditor.php';
require_once ROOT_DIR . '/sys/PWA/Setting.php';

class PWA_Settings extends ObjectEditor {
	function getObjectType(): string {
		return 'PWASetting';
	}

	function getToolName(): string {
		return 'Settings';
	}

	function getModule(): string {
		return 'PWA';
	}

	function getPageTitle(): string {
		return 'Progressive Web Application Settings';
	}

	function getAllObjects($page, $recordsPerPage): array {
		$list = [];

		$object = new PWASetting();
		$object->orderBy($this->getSort());
		$this->applyFilters($object);
		$object->limit(($page - 1) * $recordsPerPage, $recordsPerPage);
		$object->find();
		while ($object->fetch()) {
			$list[$object->id] = clone $object;
		}

		return $list;
	}

	function getDefaultSort(): string {
		return 'name asc';
	}

	function getObjectStructure($context = ''): array {
		return PWASetting::getObjectStructure($context);
	}

	function getPrimaryKeyColumn(): string {
		return 'id';
	}

	function getIdKeyColumn(): string {
		return 'id';
	}

	function getBreadcrumbs(): array {
		$breadcrumbs = [];
		$breadcrumbs[] = new Breadcrumb('/Admin/Home', 'Administration Home');
		$breadcrumbs[] = new Breadcrumb('/Admin/Home#pwa', 'PWA');
		$breadcrumbs[] = new Breadcrumb('/PWA/Settings', 'PWA Settings');
		return $breadcrumbs;
	}

	function getActiveAdminSection(): string {
		return 'pwa';
	}

	function canView(): bool {
		// TODO should we change this to a PWA specific Permission?
		return UserAccount::userHasPermission('Administer Aspen LiDA Settings');
	}
}