<?php
	define('PREFIX', str_replace('public', '', url('/')).'/');

	//Design Source File Paths
	define('CSS', PREFIX.config('lmanager_path').'/public/assets/css/');
	define('JS', PREFIX.config('lmanager_path').'/public/assets/js/');

	//LANGUAGES MODULE
	define('URL_LANGUAGES_LIST', url('admin/languages/list'));
	define('URL_LANGUAGE_TOKEN_LIST', url('admin/languages/token_list'));
	define('URL_LANGUAGES_ADD', url('admin/languages/add'));
	define('URL_LANGUAGES_EDIT', url('admin/languages/edit'));
	define('URL_LANGUAGES_UPDATE_STRINGS', url('admin/languages/update-strings/'));
	define('URL_LANGUAGES_DELETE', url('admin/languages/delete').'/');
	define('URL_LANGUAGES_GETLIST', url('admin/languages/getList/'));
	define('URL_LANGUAGES_MAKE_DEFAULT', url('admin/languages/make-default').'/');
	define('URL_LANGUAGES_CREATE_TOKEN', url('admin/languages/create-token/'));
	define('URL_LANGUAGES_EDIT_TOKEN', url('admin/languages/edit-token/'));
	define('URL_LANGUAGES_UPDATE_TOKEN', url('admin/languages/update-token/'));
	define('URL_LANGUAGE_TOKEN_ADD', url('admin/languages/add_token'));
	define('URL_LANGUAGE_TOKEN_DELETE', url('admin/languages/delete-token').'/');

	define('URL_LANGUAGE_PAGE_LIST', url('admin/languages/page_list'));
	define('URL_LANGUAGE_PAGE_ADD', url('admin/languages/add_page'));
	define('URL_LANGUAGES_EDIT_PAGE', url('admin/languages/edit-page/'));
	define('URL_LANGUAGE_PAGE_DELETE', url('admin/languages/delete-page').'/');

	//users
	define('URL_USER_EDIT_PAGE', url('admin/user/update-user/'));