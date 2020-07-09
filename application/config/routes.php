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
$route['default_controller'] = 'welcome';
$route['404_override'] = 'welcome/notfound';
$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = 'welcome/notfound';
$route['translate_uri_dashes'] = FALSE;
$route["berita"]='welcome/berita';
$route["portofolio"] = 'welcome/portofolio';
$route["pengumuman"] = 'welcome/pengumuman';
$route["login"] = 'login';
$route['archive/(:num)/(:num)'] = function ($tahun, $bln) {
	return 'welcome/archive/' . $tahun . "/" . $bln;
};
$route['(:num)/(:num)/(:num)/([a-zA-Z0-9-.]+)'] = function ($tgl,$bln,$thn,$link)
{
	return 'welcome/berita/' .$thn."-".$bln."-".$tgl ."/" . strtolower($link) ;
};
$route['([a-zA-Z0-9-.]+)'] = function ($link) {
	return 'welcome/detail/' . strtolower($link);
};
$route['halaman/([a-zA-Z0-9-.]+)']=function ($link)
{
	return 'welcome/page/'. strtolower($link) ;
};
$route['form/([a-zA-Z0-9-.]+)'] = function ($link) {
	return 'welcome/form/' . strtolower($link);
};
$route["home"]='welcome/home';
$route["layanan"]='welcome/layanan';

$route["layanan/(:num)"]=function($id){
	return 'welcome/detail_layanan/' .$id;
};

$route["lacak"]='welcome/lacak';
$route["faq"]='welcome/faq';
$route["berita"]='welcome/berita';
$route['visi-misi'] ='welcome/page/visi-dan-misi';
$route['sejarah-ptsp']='welcome/page/sejarah-ptsp';
$route['struktur-organisasi']='welcome/page/struktur-organisasi';
$route['tentang-kami'] ='welcome/page/tentang-kami';
$route['download'] ='welcome/download';
$route['ppid'] ='welcome/ppid';
$route['galery'] ='welcome/galery';
$route['category/([a-zA-Z0-9-.]+)']=function ($link)
{
	return 'welcome/category/'. strtolower($link) ;
};