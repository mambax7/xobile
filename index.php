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

require("../../mainfile.php");
require("include/config.inc.php");
require("class/hawhaw.php");
require("class/core.php");

xoops_loadLanguage('main', $GLOBALS['xoopsModule']->getVar('dirname'));

// Set and clean page variable's
if(!empty($_GET['mod'])){
	$mod = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['mod']);
}else{
	$mod = "system";
}
if(!empty($_GET['page'])){
	$page = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['page']);
}else{
	$page = "main";
}
if(!empty($_GET['style']) && $_GET['style'] == 2){
	$style = 2;
}else{
	$style = 1;
}

//Load header            
$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("xoBile_plugins")." WHERE plugdir = '".$mod."' LIMIT 1";
$result = $GLOBALS['xoopsDB']->queryF($sql);
$plugin = $GLOBALS['xoopsDB']->fetchArray($result);

// Load xoBile class
$xoBile_page = new xoBile_core(_MA_xobile_BACKLINK);

// Load xoBile header
$xoBile_page->loadheader();

// Data needed for error reporting
$erdata = array("plugin" => $mod, "page" => $page, "language" => $GLOBALS['xoopsConfig']['language']);

// Check permission
if(empty($plugin['moddir']) || !$xoBile_page->permission("module_read", $plugin['moddir'])){
	$xoBile_page->error(_NOPERM, $erdata);
    $xoBile_page->loadfooter();
    exit;
}

//Load page
$plugin_root = xobile_ROOT."/plugins/".$mod;
if($style != 2){
	$plugin_file = $plugin_root."/".$page.".php";
}else{
	$plugin_file = $plugin_root."/advanced/".$page.".php";
	if(!file_exists($plugin_file)){
		$plugin_file = $plugin_root."/".$page.".php";
	}
}
if(!file_exists($plugin_file)){
    $xoBile_page->error(_MA_xobile_ERROR_NPF, $erdata);
    $xoBile_page->loadfooter();
    exit;
}

include($plugin_file);

//Load footer
$xoBile_page->loadfooter();
?>