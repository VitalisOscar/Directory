<?php
require __DIR__ . '/../../init.php';

redirect(url(ROUTE_SIGNIN, ['return' => ROUTE_ADMIN_HOME, 'role' => 'admin']));
?>
