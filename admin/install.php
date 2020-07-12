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

if(@include(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/plugins/'.$plgdir.'/plugin_version.php')){
    $sql = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE isvisible = 1 ORDER BY weight DESC LIMIT 1;";
    if($result = $xoopsDB->queryF($sql)){
        $tmp    = $xoopsDB->fetchArray($result);
        $weight = $tmp['weight'];
        $weight++;
    }else{
        $weight = 0;
    }
    $sql = "INSERT INTO `".$xoopsDB->prefix("xoBile_plugins")."` (`id`, `name`, `version`, `weight`, `isactive`, `isvisible`, `plugdir`, `moddir`, `hasadmin`) VALUES(0, '".$plugin['title']."', ".$plugin['version'].", ".$weight.", 1, 1, '".$plgdir."', '".$plugin['moddir']."', 0);";
    if($xoopsDB->queryF($sql)){
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_SUCCES_INSTALL, false);
        exit();
    }else{
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_INSTALL, false);
        exit();
    }
}else{
    redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_PLGINF, false);
    exit();
}
?>