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
|	http://codeigniter.com/user_guide/general/routing.html
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
// Framework routes
$route['default_controller'] = 'main';
$route['404_override'] = 'notify/error_404';
$route['translate_uri_dashes'] = TRUE;

// Shop routes
$route['shop'] = 'main';
$route['shop/search'] = 'shop/search';
$route['shop/products'] = 'shop/products';
$route['product/(:any)'] = 'shop/product/$1';
$route['category/(:any)'] = 'shop/products/$1';
$route['brand/(:any)'] = 'shop/products/0/0/$1';
$route['category/(:any)/(:any)'] = 'shop/products/$1/$2';

// Page route
$route['page/(:any)'] = 'shop/page/$1';

// Cart routes
$route['cart'] = 'cart_ajax';
$route['cart/(:any)'] = 'cart_ajax/$1';
$route['cart/(:any)/(:any)'] = 'cart_ajax/$1/$2';

// Misc routes
$route['shop/(:any)'] = 'shop/$1';
$route['shop/(:any)/(:any)'] = 'shop/$1/$2';
$route['shop/(:any)/(:any)/(:any)'] = '                            shop/$1/$2/$3';

// Auth routes
$route['login'] = 'main/login';
$route['logout'] = 'main/logout';
$route['profile'] = 'main/profile';
$route['register'] = 'main/register';
$route['login/(:any)'] = 'main/login/$1';
$route['logout/(:any)'] = 'main/logout/$1';
$route['profile/(:any)'] = 'main/profile/$1';
$route['forgot_password'] = 'main/forgot_password';
$route['activate/(:any)/(:any)'] = 'main/activate/$1/$2';
$route['reset_password/(:any)'] = 'main/reset_password/$1';

// Admin area routes
$route['admin'] = 'welcome';
$route['admin/users'] = 'auth/users';
$route['admin/users/create_user'] = 'auth/create_user';
$route['admin/users/profile/(:num)'] = 'auth/profile/$1';
$route['admin/login'] = 'auth/login';
$route['admin/login/(:any)'] = 'auth/login/$1';
$route['admin/logout'] = 'auth/logout';
$route['admin/logout/(:any)'] = 'auth/logout/$1';
// $route['admin/register'] = 'admin/auth/register';
$route['admin/forgot_password'] = 'auth/forgot_password';
$route['admin/sales/(:num)'] = 'sales/index/$1';
$route['admin/products/(:num)'] = 'products/index/$1';
$route['admin/purchases/(:num)'] = 'purchases/index/$1';
$route['admin/quotes/(:num)'] = 'quotes/index/$1';
$route['tables'] = 'restaurant/tables';
$route['admin/sales'] = 'sales/index';
$route['admin/sales/(:num)'] = 'sales/index/$1';
$route['sales/(:num)'] = 'sales/index/$1';
$route['products/(:num)'] = 'products/index/$1';
$route['purchases/(:num)'] = 'purchases/index/$1';
$route['admin/quotes'] = 'quotes/index';
$route['admin/customers'] = 'customers/index';
$route['quotes/(:num)'] = 'quotes/index/$1';
$route['users'] = 'auth/users';
$route['users/create_user'] = 'auth/create_user';