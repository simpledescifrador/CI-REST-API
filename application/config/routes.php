<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//Login & Registration Routes
$route['api/register']['post'] = 'api/auth/registration';
$route['api/login']['post'] = 'api/auth/login';
//Report Routes
$route['api/report/lost']['post'] = 'api/report/lost';
$route['api/report/found']['post'] = 'api/report/found';
//Item Routes
$route['api/lost/update/(:num)']['put'] = 'api/itemController/updateLost/$1';
$route['api/found/update/(:num)']['put'] = 'api/itemController/updateFound/$1';
$route['api/item/lost']['get'] = 'api/itemController/lost';
$route['api/item/found']['get'] = 'api/itemController/found';
$route['api/item/feed']['get'] = 'api/itemController/feed';
$route['api/item/total']['get'] = 'api/itemController/total';
$route['api/item/delete/(:num)']['delete'] = 'api/itemController/deleteItem/$1';

//Account Routes
$route['api/account/search']['get'] = 'api/accountController/searchAccount';
$route['api/account/update/(:num)']['put'] = 'api/accountController/updateAccountById/$1';
$route['api/account/delete/(:num)']['delete'] = 'api/accountController/deleteAccountById/$1';

//Barangay Routes
$route['api/barangay']['get'] = 'api/barangayController';