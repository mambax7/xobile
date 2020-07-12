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

if(!empty($_GET['plgname'])){
    $name   = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['plgname']);
    $module = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['plgmod']);
    $sql    = "UPDATE  `".$xoopsDB->prefix("xoBile_plugins")."` SET `name` =  '".$name."', `moddir` =  '".$module."' WHERE `plugdir` = '".$plgdir."' LIMIT 1;";
    if($xoopsDB->queryF($sql)){
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_SUCCES_CONFIG, false);
        exit();
    }else{
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_CONFIG, false);
        exit();
    }
}else{
    $sql = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE `plugdir` = '".$plgdir."' LIMIT 1;";
    if($result = $xoopsDB->queryF($sql)){
        $plugin = $xoopsDB->fetchArray($result);
         xoops_cp_header();
         loadModuleAdminMenu(1, "");
         echo('<form method><table class="outer" border="0" cellpadding="4"cellspacing="1" width="100%">
                <tbody>
                    <tr align="center">
                        <th colspan="2" align="center">'._AM_xobile_TITLE_CFG.' :: '.$plugin['name'].'</th>
                    </tr>
                    <tr>
                        <td class="odd" width="50%">'._AM_xobile_DESC_CFG_NAME.'</td>
                        <td class="even" width="50%"><input type="text" size="50" name="plgname" value="'.$plugin['name'].'" /></td>
                    </tr>
                    <tr>
                        <td class="odd" width="50%">'._AM_xobile_DESC_CFG_MODU.'</td>
                        <td class="even" width="50%"><input type="text" size="50" name="plgmod" value="'.$plugin['moddir'].'" /></td>
                    </tr>
                    <tr class="footer">
                        <td colspan="2" align="center" valign="middle">
                            <input type="hidden" name="op" value="config"></input>
                            <input type="hidden" name="plugin" value="'.$plgdir.'"></input>
                            <img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/save.png" alt="'._SUBMIT.'" height="18px" width="18px" valign="middle" />&nbsp;
                            <input type="submit" value="'._SUBMIT.'" />&nbsp;
                            <img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/save.png" alt="'._SUBMIT.'" height="18px" width="18px" valign="middle" />
                        </td>
                    </tr>
                </tbody>
            </table></form>
        ');
        xoops_cp_footer();
        exit();
    }else{
        redirect_header(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php', 3, _AM_xobile_ERROR_LOADCFG, false);
        exit();
    }
}
?>