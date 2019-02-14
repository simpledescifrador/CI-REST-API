<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//Login & Registration Routes
$route['api/register']['post'] = 'api/auth/register';
$route['api/login']['post'] = 'api/auth/login';
//Report Routes
$route['api/report/lost']['post'] = 'api/report/lost';
$route['api/report/found']['post'] = 'api/report/found';
$route['api/report/pet']['post'] = 'api/report/report_pet';
$route['api/report/person']['post'] = 'api/report/report_person';
//Item Routes
$route['api/lost/update/(:num)']['put'] = 'api/itemController/updateLost/$1';
$route['api/found/update/(:num)']['put'] = 'api/itemController/updateFound/$1';
$route['api/item/lost']['get'] = 'api/itemController/lost';
$route['api/item/found']['get'] = 'api/itemController/found';
$route['api/item/feed']['get'] = 'api/itemController/feed';
$route['api/item/feed/v2']['get'] = 'api/itemController/feed_v2';
$route['api/item/total']['get'] = 'api/itemController/total';
$route['api/item/delete/(:num)']['delete'] = 'api/itemController/deleteItem/$1';
$route['api/item/update']['put'] = 'api/itemController/update_item_status';
//Account Routes
$route['api/account/search']['get'] = 'api/accountController/searchAccount';
$route['api/account/update/(:num)']['put'] = 'api/accountController/updateAccountById/$1';
$route['api/account/delete/(:num)']['delete'] = 'api/accountController/deleteAccountById/$1';

//Barangay Routes
$route['api/barangay']['get'] = 'api/barangayController';

$route['logout'] = 'login/logout';
$route['b_logout'] = 'login/b_logout'; //logout route for barangay
$route['dashboard'] = "dashboard_controller/home";
$route['barangay'] = "barangay_home/home";