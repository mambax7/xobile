<?php
###############################################################################
##   Copyright (C) 2009  Dylian Melgert                                      ##
##                                                                           ##
##      This program is free software: you can redistribute it and/or modify ##
##      it under the terms of the GNU General Public License as published by ##
##      the Free Software Foundation, either version 3 of the License, or    ##
##      (at your option) any later version.                                  ##
##                                                                           ##
##      This program is distributed in the hope that it will be useful,      ##
##      but WITHOUT ANY WARRANTY; without even the implied warranty of       ##
##      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        ##
##      GNU General Public License for more details.                         ##
##                                                                           ##
##      You should have received a copy of the GNU General Public License    ##
##      along with this program.  If not, see <http://www.gnu.org/licenses/>.##
###############################################################################

// Basic
$modversion['name'] = "xoBile";
$modversion['version'] = 1.2;
$modversion['description'] = "Displays an mobile version of your website. (With selected plugins)";
$modversion['credits'] = "XD Soft (http://www.dylian.eu)";
$modversion['license'] = "GPL, see license.txt";
$modversion['official'] = 0;
$modversion['image'] = "logo.gif";
$modversion['dirname'] = "xobile";
$modversion['author'] = 'Dylian Melgert';

// Install/Update/Uninstall
$modversion['onInstall'] = "include/install.inc.php";
$modversion['onUpdate'] = "include/update.inc.php";
//$modversion['onUninstall'] = "include/uninstall.inc.php"; // Not needed yet

// Menu
$modversion['hasMain'] = 1;

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/admin.php";
$modversion['adminmenu'] = "admin/menu.php";

// SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "xoBile_plugins";

// $xoopsModuleConfig['atredir']  
$modversion['config'][0]['name'] = 'atredir';  
$modversion['config'][0]['title'] = '_MI_xobile_ATREDIR';  
$modversion['config'][0]['description'] = '_MI_xobile_ATREDIRDSC';  
$modversion['config'][0]['formtype'] = 'yesno';  
$modversion['config'][0]['valuetype'] = 'int';  
$modversion['config'][0]['default'] = 1;

// $xoopsModuleConfig['wurflredir'] 
$modversion['config'][1]['name'] = 'wurflredir';  
$modversion['config'][1]['title'] = '_MI_xobile_WURFLREDIR';  
$modversion['config'][1]['description'] = '_MI_xobile_WURFLREDIRDSC';  
$modversion['config'][1]['formtype'] = 'yesno';  
$modversion['config'][1]['valuetype'] = 'int';  
$modversion['config'][1]['default'] = 0;

// $xoopsModuleConfig['hawhaw_template']  
$modversion['config'][2]['name'] = 'hawhaw_template';
$modversion['config'][2]['title'] = "_MI_xobile_HAWTEMPLATE";
$modversion['config'][2]['description'] = '_MI_xobile_HAWTEMPLATEDSC';
$modversion['config'][2]['formtype'] = 'select';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = 'Iphone';
xoops_load('XoopsLists');
$template_dir = XOOPS_ROOT_PATH."/modules/xobile/templates";
$modversion['config'][2]['options'] = array_flip(XoopsLists::getDirListAsArray($template_dir));
?>
