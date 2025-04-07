<?php

class Custom {
    public static function getAdminSection()
    {
        $section = new AdminSection('Custom Modules');
        $section->addAction(new AdminAction('Create Custom', 'Create Custom Module', '/Custom/Create'), [true]);
        $section->addAction(new AdminAction('Open Greenhouse', 'shortcut to greenhouse', '/Greenhouse/Home'), true);
        return $section;
    }
}
?>