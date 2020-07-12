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
function xoops_module_pre_install_xobile($module){
    $done = true;
    if(version_compare(PHP_VERSION,"5.0.0","<")){
        $module->setErrors("PHP check: not compatible (PHP ".PHP_VERSION.")");
        $done = false;
    }
    if(version_compare(XOOPS_VERSION,"XOOPS 2.4.0","<")){
        $module->setErrors("XOOPS check: not compatible (".XOOPS_VERSION.")");
        $done = false;
    }
    return $done;
}
?>