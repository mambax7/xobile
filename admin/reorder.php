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

$sql = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE isvisible = 1 ORDER BY weight ASC LIMIT 1;";
if($result = $xoopsDB->queryF($sql)){
    $tmp = $xoopsDB->fetchArray($result);
    $lweight = $tmp['weight'];
}else{
    $error++;
}
$sql = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE isvisible = 1 ORDER BY weight DESC LIMIT 1;";
if($result = $xoopsDB->queryF($sql)){
    $tmp = $xoopsDB->fetchArray($result);
    $hweight = $tmp['weight'];
}else{
    $error++;
}
$error = 0;
$move = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['move']);
$sql   = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE `plugdir` = '".$plgdir."' LIMIT 1;";
if($result = $xoopsDB->queryF($sql)){
    $tmp    = $xoopsDB->fetchArray($result);
    $weight = $tmp['weight'];
    if($move == "up"){
        $weight--;
    }elseif($move == "down"){
        $weight++;
    }else{
        $error++;
    }
    if($weight < $lweight || $weight > $hweight){
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_CONFIG, false);
        exit();
    }
}else{
    $error++;
}
$sql   = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE `weight` = '".$weight."' LIMIT 1;";
if($result = $xoopsDB->queryF($sql)){
    $tmp    = $xoopsDB->fetchArray($result);
    $plugin = $tmp['plugdir'];
}else{
    $error++;
}
$sql = "UPDATE  `".$xoopsDB->prefix("xoBile_plugins")."` SET `weight` =  '".$weight."' WHERE `plugdir` = '".$plgdir."' LIMIT 1;";
if(!$result = $xoopsDB->queryF($sql)){
    $error++;
}
if($move == "up"){
    $weight++;
}elseif($move == "down"){
    $weight--;
}else{
    $error++;
}
$sql = "UPDATE  `".$xoopsDB->prefix("xoBile_plugins")."` SET `weight` =  '".$weight."' WHERE `plugdir` = '".$plugin."' LIMIT 1;";
if(!$result = $xoopsDB->queryF($sql)){
    $error++;
}
if($error == 0){
    redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_SUCCES_CONFIG, false);
    exit();
}else{
    redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_CONFIG." e".$error, false);
    exit();
}
?>