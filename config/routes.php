<?php
	/** маршруты	**/
	return array (
		'edit/([0-9]+)'		=>	'admin/edit/$1',
		'update/([0-9]+)'	=>	'admin/update/$1',
		'delete/([0-9]+)'	=>	'admin/delete/$1',

	//	'index.php'		=>	'main/index',
		'task'			=>	'main/index',
		'task?.+'		=>	'main/index',
		'check'			=>	'main/check',

		'reg'			=>	'reg/index',
		'reg_in'		=>	'reg/check',

		'auth'			=>	'auth/index',
		'auth_in'		=>	'auth/check',
		'logout'		=>	'auth/logout',

		'admin'			=>	'admin/index',
		'adminCheck'	=>	'admin/check',
	);