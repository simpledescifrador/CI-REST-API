<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* API Routes */
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//Login & Registration Routes
$route['api/register']['post'] = 'api/auth/register';
$route['api/login']['post'] = 'api/auth/login';
//Firebase Register Token
$route['api/auth/token/register']['post'] = 'api/auth/register_token';
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
$route['api/item/get']['get'] = 'api/itemController/get_feed_detail';
$route['api/item/generate/qrcode']['post'] = 'api/itemController/generate_item_qrcode';
// $route['api/item/feed']
//Search Routes
$route['api/search/items']['get'] = 'api/searchController/search_items';
//Account Routes
$route['api/account/search']['get'] = 'api/accountController/searchAccount';
$route['api/account/update/(:num)']['put'] = 'api/accountController/updateAccountById/$1';
$route['api/account/delete/(:num)']['delete'] = 'api/accountController/deleteAccountById/$1';
$route['api/accounts/names']['get'] = 'api/accountController/all_account_names';
//Account Notifications
$route['api/account/notifications']['get'] = 'api/accountController/load_notifications';
$route['api/account/notification/total/(:num)']['get'] = 'api/accountController/total_notifications/$1';
$route['api/account/notification/unviewed/(:num)']['get'] = 'api/accountController/unread_notification_count/$1';
$route['api/account/notification/mark/viewed/(:num)']['put'] = 'api/accountController/mark_notification_as_viewed/$1';
$route['api/account/notification/mark/unviewed/(:num)']['put'] = 'api/accountController/mark_notification_as_unviewed/$1';
$route['api/account/notification/delete/(:num)']['put'] = 'api/accountController/delete_notification/$1';
//Account Rating
$route['api/account/rating/new']['post'] = 'api/accountController/new_rating';
$route['api/account/rating/avg/(:num)']['get'] = 'api/accountController/average_rating/$1';
$route['api/account/transactions/(:num)']['get'] = 'api/accountController/account_transactions/$1';
//Chat Routes
$route['api/chat/create/room']['post'] = 'api/chatController/create_chat_room';
$route['api/chat/send/message']['post'] = 'api/chatController/add_message';
$route['api/chat/rooms']['get'] = 'api/chatController/chat_rooms';
$route['api/chat/room/(:num)/messages']['get'] = 'api/chatController/chat_room_messages/$1';
//Get Baragay Data
$route['api/barangay']['get'] = 'api/barangayController';
//Transaction Routes
$route['api/transaction/return']['post'] = 'api/transaction/return_transaction/';
$route['api/transaction/pending/(:num)/(:num)']['get'] = 'api/transaction/check_pending_trans/$1/$2';
$route['api/transaction/item/confirmed']['post'] = 'api/transaction/confirm_item_returned';
$route['api/transaction/item/denied']['post'] = 'api/transaction/denied_item_returned';

/* -----------  API Version 1   -----------*/
//Authentication
$route['api/v1/auth/login']['post'] = 'api/v1/authentication/request_login';
$route['api/v1/auth/register']['post'] = 'api/v1/authentication/register_account';
$route['api/v1/auth/change_password']['post'] = 'api/v1/authentication/change_password';
$route['api/v1/auth/check_makatizen']['get'] = 'api/v1/authentication/check_makatizen';
$route['api/v1/auth/forgot_password']['post'] = 'api/v1/authentication/request_password_reset';
$route['api/v1/auth/reset_password']['post'] = 'api/v1/authentication/reset_password';
$route['api/v1/auth/email/verification']['post'] = 'api/v1/authentication/send_email_verification';
$route['api/v1/auth/email/verify_code']['post'] = 'api/v1/authentication/verify_code';
$route['api/v1/auth/phone/send_request']['post'] = 'api/v1/authentication/send_sms_request';
$route['api/v1/auth/phone/cancel_request']['get'] = 'api/v1/authentication/cancel_sms_request';
$route['api/v1/auth/phone/check_request']['get'] = 'api/v1/authentication/check_sms_request';

//Account
$route['api/v1/account/(:num)']['get'] = 'api/v1/accountController/account/$1';
$route['api/v1/accounts/(:num)/items']['get'] = 'api/v1/itemController/account_latest_feed/$1';
$route['api/v1/accounts/(:num)/images']['get'] = 'api/v1/itemController/account_item_images/$1';
$route['api/v1/accounts/(:num)/items/type']['get'] = 'api/v1/accountController/type_counts/$1';
$route['api/v1/accounts/(:num)/items/status']['get'] = 'api/v1/accountController/status_counts/$1';

//Account Rating
$route['api/v1/accounts/rating/new']['post'] = 'api/v1/accountController/new_rating';
$route['api/v1/accounts/rating/avg/(:num)']['get'] = 'api/v1/accountController/average_rating/$1';

//Barangay
$route['api/v1/barangay']['get'] = 'api/v1/barangayController/all_barangay';
$route['api/v1/barangay/(:num)']['get'] = 'api/v1/barangayController/barangay/$1';
//Report Lost/Found
$route['api/v1/report/pt']['post'] = 'api/v1/reportController/report_item_pt';
$route['api/v1/report/pet']['post'] = 'api/v1/reportController/report_item_pet';
$route['api/v1/report/person']['post'] = 'api/v1/reportController/report_item_person';
//Items
$route['api/v1/items']['get'] = 'api/v1/itemController/latest_feed';
$route['api/v1/items/(:num)/images']['get'] = 'api/v1/itemController/item_images/$1';
$route['api/v1/items/(:num)']['get'] = 'api/v1/itemController/item_details/$1';
$route['api/v1/items/map']['get'] = 'api/v1/itemController/map_items';

//Chat
$route['api/v1/chats']['get'] = 'api/v1/chatController/chat_rooms';
$route['api/v1/chats/(:num)/messages']['get'] = 'api/v1/chatController/chat_room_messages/$1';
$route['api/v1/chats/(:num)/messages/add'] = 'api/v1/chatController/add_message/$1';
$route['api/v1/chats/create']['post'] = 'api/v1/chatController/create_chat_room';
$route['api/v1/chats/new']['post'] = 'api/v1/chatController/create_item_chat';

//Notifications
$route['api/v1/account/notifications']['get'] = 'api/v1/notificationController/load_notifications';
$route['api/v1/account/notification/total/(:num)']['get'] = 'api/v1/notificationController/total_notifications/$1';
$route['api/v1/account/notification/unviewed/(:num)']['get'] = 'api/v1/notificationController/unread_notification_count/$1';
$route['api/v1/account/notification/mark/viewed/(:num)']['put'] = 'api/v1/notificationController/mark_notification_as_viewed/$1';
$route['api/v1/account/notification/mark/unviewed/(:num)']['put'] = 'api/v1/notificationController/mark_notification_as_unviewed/$1';
$route['api/v1/account/notification/delete/(:num)']['put'] = 'api/v1/notificationController/delete_notification/$1';

//Search
$route['api/v1/items/search']['get'] = 'api/v1/searchController/search_items';

//Transaction
$route['api/v1/transactions/confirm']['post'] = 'api/v1/transactionController/item_transaction_confirm';
$route['api/v1/transactions/confirmation/status/(:num)']['get'] = 'api/v1/transactionController/transaction_confirmation_status/$1';
$route['api/v1/transactions/meetup/new']['post'] = 'api/v1/transactionController/setup_meetup';
$route['api/v1/transactions/confirmation/check']['get'] = 'api/v1/transactionController/check_transaction_status';
$route['api/v1/transactions/meet/(:num)/details']['get'] = 'api/v1/transactionController/meetup_details/$1';
$route['api/v1/transactions/meet/confirmation']['put'] = 'api/v1/transactionController/meetup_confirmation';
$route['api/v1/transactions/item/return']['post'] = 'api/v1/transactionController/return_item_transaction';
$route['api/v1/transaction/pending/(:num)/(:num)']['get'] = 'api/v1/transactionController/check_pending_trans/$1/$2';
$route['api/v1/transaction/item/(:num)/return/status']['get'] = 'api/v1/transactionController/check_item_return_status/$1';
$route['api/v1/transaction/item/confirmed']['put'] = 'api/v1/transactionController/confirm_item_returned';
$route['api/v1/transaction/item/denied']['put'] = 'api/v1/transactionController/denied_item_returned';
/* -----------  END OF API Version 1   -----------*/




/* --------------------End Of API Routes--------------------------------- */

//Auth Controller Routes
$route['auth/verify_email']['get'] = 'auth_controller/email_verification';

//Barangay Interface Routes
//Barangay Interface Routes
$route['b_logout'] = 'login/b_logout'; //logout route for barangay
$route['barangay'] = "barangay/barangay_home/home";
$route['b_reports'] = 'barangay/barangay_reports/index';

$route['b_report_item'] = 'barangay/barangay_posts';

//admin interface routes
$route['dashboard'] = "dashboard_controller/home";
$route['logout'] = 'login/logout';
$route['brgy_details'] = 'Barangays/brgy_details';