<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// $route['default_controller'] = "carrier/authorization/login";
//$route['default_controller'] = "welcome";
$route['404_override'] = '';


/** Rest API's routing **/

$route['auth/rolecheck'] = "api/auth/rolecheck";
$route['auth/signup'] = "api/registration/signup";
$route['auth/login'] = "api/registration/login";
$route['auth/logout'] = "api/auth/logout";
$route['auth/forgotpassword'] = "api/registration/forgotpassword";
$route['auth/resetpassword'] = "api/registration/resetpassword";
$route['auth/landingPageDetails'] = "api/registration/landingPageDetails";


$route['admin/certificates/(:any)'] = "api/admin/certificates/$1";

$route['admin/employee/(:any)'] ="api/admin/employee/$1";

$route['admin/department/(:any)']="api/admin/department/$1";
$route['fetchdept/department/(:any)']="api/departmentget/department/$1";

$route['employee/certificatebystatus/(:any)'] = "api/employee/certificatebystatus/$1";
$route['employee/changecertificatestatus'] = "api/employee/changecertificatestatus";
$route['employee/uploadprofileimage/(:any)'] = "api/employee/uploadprofileimage/$1";
$route['employee/userdetails'] = "api/employee/userdetails";
$route['employee/empcertificates'] = "api/employee/empcertificates";
$route['employee/changepassword'] = "api/employee/changepassword";



