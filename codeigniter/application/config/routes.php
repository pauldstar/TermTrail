<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/* 
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['(:any)'] = 'index/user/$1'; 
*/

$route['logout'] = 'dashboard/logout';
$route['drop_db'] = 'database/drop_db';
$route['drop_db/(:any)'] = 'database/drop_db';
$route['create_db'] = 'database/create_db';
$route['create_db/(:any)'] = 'database/create_db';
$route['dashboard'] = 'dashboard/dashboard';
$route['test_banks'] = 'test/test_banks';
$route['test_body'] = 'test/test_body';
$route['add_question_comment'] = 'test/add_question_comment';
$route['add_question'] = 'test/add_question';
$route['add_bank'] = 'test/add_bank';
$route['add_chapter'] = 'test/add_chapter';
$route['add_course'] = 'test/add_course';
$route['add_school'] = 'test/add_school';
$route['login'] = 'landing/login';
$route['signup'] = 'landing/signup';
$route['default_controller'] = 'landing/login';
