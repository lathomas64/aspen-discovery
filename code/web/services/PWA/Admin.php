<?php
class PWA_Admin {
	public static function getAdminSection()
	{
		$section = new AdminSection('Progressive Web App');
		$section->addAction(new AdminAction('PWA Settings', 'Progressive Web application settings', '/PWA/Settings'), [true]);

		return $section;
	}
}
?>