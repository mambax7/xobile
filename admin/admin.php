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

require_once "header.php";
xoops_loadLanguage('admin', $xoopsModule->getVar('dirname'));

if(!empty($_GET['op']) && !empty($_GET['plugin'])){
    $action = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['op']);
    $plgdir = preg_replace("/[^a-z0-9_\-]/i", "", $_GET['plugin']);
	switch ($action) {
        case 'install':
            include('install.php');
            break;
        case 'aswitch':
            include('aswitch.php');
            break;
        case 'config':
            include('config.php');
            break;
        case 'delete':
            include('delete.php');
            break;
        case 'reorder':
            include('reorder.php');
            break;
    }
}
// INST Table header:
xoops_cp_header();
loadModuleAdminMenu(1, "");
echo('
<h3>'._AM_xobile_INSTALLED_PLG.'</h3>
<table class="outer" border="0" cellpadding="4"cellspacing="1" width="100%">
  <tbody>
    <tr align="center">
      <th width="35%">'._AM_xobile_TITLE_PLGN.'</th>
      <th width="20%">'._AM_xobile_TITLE_PLGO.'</th>
      <th width="15%">'._AM_xobile_TITLE_PLGV.'</th>
      <th width="10%">'._AM_xobile_TITLE_PLGA.'</th>
      <th width="20%">'._AM_xobile_TITLE_PLGC.'</th>
    </tr>
');

// INST Table content
$sql = "SELECT * FROM ".$xoopsDB->prefix("xoBile_plugins")." WHERE isvisible = 1 ORDER BY weight ASC";
$result = $xoopsDB->queryF($sql);
$class = "odd";
$i = 0;
$inst_plgns = array();
while ($row = $xoopsDB->fetchArray($result)) {
 if($class == "odd"){
   $class = "even";
 }else{
   $class = "odd";
 }
 if(@include(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/plugins/'.$row['plugdir'].'/plugin_version.php')){
  echo('
    <tr class="'.$class.'" align="center" valign="middle">
        <td align="center" valign="middle">
            '.$row['name'].'
        </td>
        <td align="center" valign="middle">
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=reorder&plugin='.$row['plugdir'].'&move=up"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/up.png" height="32px" width="32px" /></a>
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=reorder&plugin='.$row['plugdir'].'&move=down"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/down.png" height="32px" width="32px" /></a>
        </td>
        <td align="center" valign="middle">
            '.$row['version'] / 100 .'
        </td>
        <td align="center" valign="middle">
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=aswitch&plugin='.$row['plugdir'].'&active='.$row['isactive'].'"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/active'.$row['isactive'].'.png" alt="'._AM_xobile_ACTION_ACTIVATE.'" height="32px" width="32px" /></a>
        </td>
        <td align="center" valign="middle">
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=config&plugin='.$row['plugdir'].'"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/settings.png" alt="'._AM_xobile_ACTION_CONFIG.'" height="32px" width="32px" /></a>
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=delete&plugin='.$row['plugdir'].'"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/deinstall.png" alt="'._AM_xobile_ACTION_DEINSTALL.'" height="32px" width="32px" /></a>
        </td>
    </tr>
  ');
  $inst_plgns[$i] = $row['plugdir'];
  $i++;
 }else{
    echo('<tr><td colspan="3">'._AM_xobile_ERROR_PLGINF.'</td></tr>');
 }
}

// INST Table footer
echo('
  </tbody>
</table>
');

// AVAIL Table header:
echo('
<h3>'._AM_xobile_AVAILABLE_PLG.'</h3>
<table class="outer" border="0" cellpadding="4"cellspacing="1" width="100%">
  <tbody>
    <tr align="center">
      <th width="34%">'._AM_xobile_TITLE_PLGN.'</th>
      <th width="33%">'._AM_xobile_TITLE_PLGV.'</th>
      <th width="33%">'._AM_xobile_TITLE_PLGC.'</th>
    </tr>
');

// AVAIL Table content
require_once XOOPS_ROOT_PATH."/class/xoopslists.php";
$plugin_dir = XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/plugins";
$dirlist    = XoopsLists::getDirListAsArray($plugin_dir);
$class      = "odd";
foreach($dirlist as $dir){
 if (!in_array($dir, $inst_plgns) && $dir != "index") {
  if($class == "odd"){
    $class = "even";
  }else{
    $class = "odd";
  }
  if(@include(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar('dirname').'/plugins/'.$dir.'/plugin_version.php')){
   echo('
    <tr class="'.$class.'" align="center" valign="middle">
        <td align="center" valign="middle">
            '.$plugin['title'].'
        </td>
        <td align="center" valign="middle">
            '.$plugin['version'] / 100 .'
        </td>
        <td align="center" valign="middle"> 
            <a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/admin.php?op=install&plugin='.$dir.'"><img src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/images/install.png" alt="'._AM_xobile_ACTION_INSTALL.'" height="32px" width="32px" /></a>
        </td>
    </tr>
   ');
  }else{
    echo('<tr><td colspan="3">'._AM_xobile_ERROR_PLGINF.'</td></tr>');
  }
 }
}

// AVAIL Table footer
echo('
  </tbody>
</table>
');

xoops_cp_footer();
?>