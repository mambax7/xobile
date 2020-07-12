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

$xoBile_page->loadPluginLanguage("system", _MA_xobile_ERROR_NPL);

$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("xoBile_plugins")." WHERE isvisible = 1 AND isactive = 1 ORDER BY weight ASC";
$result = $GLOBALS['xoopsDB']->queryF($sql);
$xoBile_lnks = new HAW_linkset();
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
	if($xoBile_page->permission("module_read", $row['moddir'])){
		$xoBile_link = new HAW_link($row['name'],"index.php?mod=".$row['plugdir']);
		$xoBile_lnks->add_link($xoBile_link);
	}
}
// Temporary solution till profile plugin is ready
$xoBile_link = new HAW_link($lang['my_profile'],"index.php?page=user");
$xoBile_lnks->add_link($xoBile_link);

$xoBile_page->add_linkset($xoBile_lnks);
$xoBile_page->backURL = "";
?>
