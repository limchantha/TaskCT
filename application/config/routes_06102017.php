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
$route['404_override'] = 'errors/error_404';
$route['default_controller'] = 'site/landing/index';
$route['user_login'] = 'site/user/user_login';
$route['user_signup'] = 'site/user/user_signup';
$route['dashboard'] = 'site/user/dashboard';
$route['account'] = 'site/user/account';
$route['logout'] = 'site/user/logout';
$route['inbox'] = 'site/user/inbox';
$route['add_task/(:num)'] = 'site/user/add_task/$1';
$route['add_task_description/(:num)'] = 'site/user/add_task_description/$1';
$route['task_compare/(:num)'] = 'site/user/task_compare/$1';
$route['book_tasker/(:num)'] = 'site/user/book_tasker/$1';
$route['booking_confirm'] = 'site/user/booking_confirm/$1';
/*tasker*/
$route['become-a-tasker'] = 'site/tasker/tasker_signup';
$route['tasker_step1'] = 'site/tasker/tasker_step1';
$route['tasker_step2'] = 'site/tasker/tasker_step2';
$route['tasker_step3'] = 'site/tasker/tasker_step3';
$route['tasker_step4'] = 'site/tasker/tasker_step4';
$route['block_dates'] = 'site/tasker/block_dates';
$route['tasker/(:num)'] = 'site/tasker/tasker/$1';
$route['tasker_reviews/(:num)'] = 'site/tasker/tasker_reviews/$1';
$route['hireme/(:num)'] = 'site/tasker/hireme/$1';
$route['page/(:any)'] = 'site/cms/page/$1';
$route['services/(:any)/(:num)'] = 'site/cms/services/$1/$1';
$route['contact_us'] = 'site/landing/contact_us';
/*tasker*/
//admin
$route['admin'] = 'admin/admin_settings/login';
$route['admin/dashboard'] = 'admin/admin_settings/dashboard';



/*Mobile*/
$route['json/user_signup'] = 'site/mobile/user_signup';
$route['json/user_login_process'] = 'site/mobile/user_login_process';
$route['json/upload_profile_picture'] = 'site/mobile/upload_profile_picture';
$route['json/available_balance'] = 'site/mobile/available_balance';
$route['json/change_user_password'] = 'site/mobile/change_user_password';
$route['json/deactivate_myaccount'] = 'site/mobile/deactivate_myaccount';
$route['json/save_notification'] = 'site/mobile/save_notification';
/*Mobile*/
