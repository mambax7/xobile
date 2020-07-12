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
define('xobile_ROOT', $GLOBALS['xoops']->path('modules/xobile'));
define('xobile_URL', $GLOBALS['xoops']->url('modules/xobile'));

$xoBileConfig = array();
// Members
$xoBileConfig['member']    =& xoops_gethandler('member');
$xoBileConfig['admin']     =& $xoBileConfig['member']->getUser(1);
// xoBile configuration
$xoBileConfig['version']   = "1.2 [RTT]";
$xoBileConfig['rooturl']   = xobile_URL;
$xoBileConfig['rootpath']  = xobile_ROOT;

$xoBileConfig['template']  = xobile_URL."/templates/".$xoopsModuleConfig['hawhaw_template']."/style.css";

?>
