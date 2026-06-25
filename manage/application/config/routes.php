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

$route['default_controller'] = 'users';
$route['default_controller'] = 'users/welcome';
$route['signatures'] = 'users/signatures';
$route['manual_signatures'] = 'users/manual_signatures';
$route['archived_signatures'] = 'users/archived_signatures';

$route['staff'] = 'users/staff';
$route['certificates'] = 'users/certificates';
$route['custom-certificates'] = 'users/manage_custom_certificates';
$route['service-logs'] = 'users/manage_service_logs';

$route['influenza_forms'] = 'users/influenza_forms';

$route['regenerate_certificate'] = 'users/regenerate_certificate';
$route['delete_certificates'] = 'users/delete_certificate';
$route['delete_custom_certificates'] = 'users/delete_custom_certificate';

$route['welcome'] = 'users/welcome';

$route['employee_certificates/(:any)'] = 'users/employee_certificates/$1';

$route['u_login/check_user'] = 'users/check_user';

$route['check_user'] = 'users/check_user';
$route['login'] = 'users/login';
$route['view/(:any)'] = 'users/view_job_details/$1';
$route['check_username'] = 'users/check_username';
$route['check_user'] = 'users/check_user';
$route['mail_logs'] = 'users/mail_logs';
$route['form1'] = 'users/form1';

$route['manage_profile'] = 'users/manage_profile';

$route['add'] = 'users/add';
$route['remove'] = 'users/remove';
$route['archive'] = 'users/archive';
$route['reactivate'] = 'users/reactivate';

$route['update'] = 'users/update_record';
$route['b_logout'] = 'users/logout';

$route['logout'] = 'users/logout';
$route['form_sheets'] = 'users/form_sheets';
$route['form_sheets/add'] = 'users/group_sheet_form';
$route['views/(:any)'] = 'users/doc_views/$1';
$route['send_agreement_form/(:any)'] = 'users/send_agreement_form/$1';
$route['send_orientation_form/(:any)'] = 'users/send_orientation_form/$1';

$route['settings'] = 'users/settings';
$route['settings_db'] = 'users/settings_db';



$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;

