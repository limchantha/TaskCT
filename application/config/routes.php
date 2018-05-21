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
$route['contact_us'] = 'site/landing/contact_us';
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
/*tasker*/
//admin
$route['admin'] = 'admin/admin_settings/login';
$route['admin/dashboard'] = 'admin/admin_settings/dashboard';



/*Mobile*/
$route['json/user_signup'] = 'site/mobile/user_signup';
$route['json/user_login_process'] = 'site/mobile/user_login_process';
$route['json/upload_profile_picture'] = 'site/mobile/upload_profile_picture';
$route['json/upload_profile_picture_new'] = 'site/mobile/upload_profile_picture_new';
$route['json/available_balance'] = 'site/mobile/available_balance';
$route['json/change_user_password'] = 'site/mobile/change_user_password';
$route['json/deactivate_myaccount'] = 'site/mobile/deactivate_myaccount';
$route['json/save_notification'] = 'site/mobile/save_notification';
$route['json/transaction_list'] = 'site/mobile/transaction_list';
$route['json/home_page'] = 'site/mobile/home_page';
$route['json/booking_step1'] = 'site/mobile/booking_step1';
$route['json/booking_step1_new'] = 'site/mobile/booking_step1_new';
$route['json/find_tasker'] = 'site/mobile/find_tasker';
$route['json/booking_page'] = 'site/mobile/booking_page';
$route['json/save_booking_confirm'] = 'site/mobile/save_booking_confirm';
$route['json/dashboard_user_task_history_pending'] = 'site/mobile/dashboard_user_task_history_pending';
$route['json/dashboard_user_task_history_approved'] = 'site/mobile/dashboard_user_task_history_approved';
$route['json/dashboard_user_task_history_completed'] = 'site/mobile/dashboard_user_task_history_completed';
$route['json/dashboard_user_task_history_cancelled'] = 'site/mobile/dashboard_user_task_history_cancelled';
$route['json/user_active_task'] = 'site/mobile/user_active_task';
$route['json/user_cancel_task'] = 'site/mobile/user_cancel_task';
$route['json/task_completed'] = 'site/mobile/task_completed';
$route['json/billing_info'] = 'site/mobile/billing_info';
$route['json/save_review'] = 'site/mobile/save_review';
$route['json/inbox'] = 'site/mobile/inbox';
$route['json/unreadmessage_count'] = 'site/mobile/unreadmessage_count';
$route['json/chat_inner'] = 'site/mobile/chat_inner';
$route['json/send_message'] = 'site/mobile/send_message';

$route['json/tasker_signup'] = 'site/mobile/tasker_signup';
$route['json/tasker_about_us'] = 'site/mobile/tasker_about_us';
$route['json/save_tasker_about_us'] = 'site/mobile/save_tasker_about_us';
$route['json/get_services_listing_inof'] = 'site/mobile/get_services_listing_inof';
$route['json/get_subcategory'] = 'site/mobile/get_subcategory';
$route['json/get_experience'] = 'site/mobile/get_experience';
$route['json/save_service_category'] = 'site/mobile/save_service_category';
$route['json/delete_tasker_category'] = 'site/mobile/delete_tasker_category';
$route['json/get_existing_tasker_info'] = 'site/mobile/get_existing_tasker_info';
$route['json/tasker_signup_pay'] = 'site/mobile/tasker_signup_pay';
$route['json/tasker_active_task'] = 'site/mobile/tasker_active_task';
$route['json/tasker_pending_task'] = 'site/mobile/tasker_pending_task';
$route['json/tasker_approved_task'] = 'site/mobile/tasker_approved_task';
$route['json/tasker_completed_task'] = 'site/mobile/tasker_completed_task';
$route['json/tasker_enquires_load_cancel'] = 'site/mobile/tasker_enquires_load_cancel';
$route['json/tasker_task_respond'] = 'site/mobile/tasker_task_respond';
$route['json/get_task_info'] = 'site/mobile/get_task_info';
$route['json/get_tasker_info'] = 'site/mobile/get_tasker_info';
$route['json/get_tasker_document_picture'] = 'site/mobile/get_tasker_document_picture';
$route['json/upload_tasker_document_picture'] = 'site/mobile/upload_tasker_document_picture';
$route['json/stripe_setting'] = 'site/mobile/stripe_setting';
$route['json/stripe_connect'] = 'site/mobile/stripe_connect';
$route['json/stripe_connect_success'] = 'site/mobile/stripe_connect_success';
$route['json/stripe_connect_failure'] = 'site/mobile/stripe_connect_failure';
$route['json/get_blocked_dates'] = 'site/mobile/get_blocked_dates';
$route['json/save_block_date'] = 'site/mobile/save_block_date';
$route['json/delete_block_dates'] = 'site/mobile/delete_block_dates';
$route['json/forgot_password'] = 'site/mobile/forgot_password';
$route['json/get_message_list'] = 'site/mobile/get_message_list';
$route['json/get_message_list_tasker'] = 'site/mobile/get_message_list_tasker';
$route['json/chat_inner_tasker'] = 'site/mobile/chat_inner_tasker';

$route['json/tasker_login_process'] = 'site/mobile/tasker_login_process';
$route['json/logout'] = 'site/mobile/logout';
$route['json/get_existing_card_info'] = 'site/mobile/get_existing_card_info';
$route['json/social_login_process'] = 'site/mobile/social_login_process';
$route['json/tasker_transaction_list'] = 'site/mobile/tasker_transaction_list';
$route['json/update_message_status'] = 'site/mobile/update_message_status';
$route['json/check_tasker_available'] = 'site/mobile/check_tasker_available';
/*Mobile*/
