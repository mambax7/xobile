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
xoops_loadLanguage('user');

if(is_object($GLOBALS['xoopsUser'])){
	if(isset($_GET['logout'])){
		$_SESSION = array();
		session_destroy();
		setcookie($xoopsConfig['usercookie'], 0, - 1, '/', XOOPS_COOKIE_DOMAIN, 0);
		setcookie($xoopsConfig['usercookie'], 0, - 1, '/');
		if (is_object($GLOBALS['xoopsUser'])) {
			$online_handler =& xoops_gethandler('online');
			$online_handler->destroy($GLOBALS['xoopsUser']->getVar('uid'));
		}
		$xoBile_text = new HAW_text(_US_LOGGEDOUT);
		$xoBile_page->add_text($xoBile_text);
		$xoBile_text = new HAW_text(_US_THANKYOUFORVISIT);
		$xoBile_page->add_text($xoBile_text);
	}else{
		if($GLOBALS['xoopsUser']->getVar('name')){
			$uname = $GLOBALS['xoopsUser']->getVar('name');
		}else{
			$uname = $GLOBALS['xoopsUser']->getVar('uname');
		}
        $xoBile_text = strtr($lang['welcome'], array("{{user}}" => $uname));
		$xoBile_text = new HAW_text($xoBile_text);
		$xoBile_text->set_br(0);
		$xoBile_page->add_text($xoBile_text);
		$xoBile_link = new HAW_link(_US_LOGOUT.$lang['qmark'],"index.php?page=user&logout");
		$xoBile_page->add_link($xoBile_link);
	}
}elseif(isset($_POST['submit'])){
	$xoBile_page->backURL = "?page=user";
	$uname = !isset($_POST['id']) ? '' : trim($_POST['id']);
	$pass = !isset($_POST['pw']) ? '' : trim($_POST['pw']);
	if ($uname == '' || $pass == '') {
		$xoBile_page->error(_US_INCORRECTLOGIN);
		$xoBile_page->loadfooter();
		exit();
	}
	$uid = 0;
	$sql = "SELECT uid FROM ".$GLOBALS['xoopsDB']->prefix("users")." WHERE uname='".$uname."' AND pass='".md5($pass)."' AND actkey = ''";
	if($result = $GLOBALS['xoopsDB']->queryF($sql)){
		$row  = $GLOBALS['xoopsDB']->fetchArray($result);
		$uid  = $row['uid'];
	}
	if($uid == 0){
		$xoBile_page->error(_US_INCORRECTLOGIN);
		$xoBile_page->loadfooter();
		exit();
	}
	$user = $xoBileConfig['member']->getUser($uid);
	
	$user->setVar('last_login', time());
    if (!$member_handler->insertUser($user)) {
    }
    // Regenrate a new session id and destroy old session
    $GLOBALS["sess_handler"]->regenerate_id(true);
    $_SESSION = array();
    $_SESSION['xoopsUserId'] = $user->getVar('uid');
    $_SESSION['xoopsUserGroups'] = $user->getGroups();
    $user_theme = $user->getVar('theme');
    if (in_array($user_theme, $xoopsConfig['theme_set_allowed'])) {
        $_SESSION['xoopsUserTheme'] = $user_theme;
    }

    // Set cookie for rememberme
    if (!empty($xoopsConfig['usercookie'])) {
        if (!empty($_POST["rm"])) {
            setcookie($xoopsConfig['usercookie'], $_SESSION['xoopsUserId'] . '-' . md5($user->getVar('pass') . XOOPS_DB_NAME . XOOPS_DB_PASS . XOOPS_DB_PREFIX), time() + 31536000, '/', XOOPS_COOKIE_DOMAIN, 0);
        } else {
            setcookie($xoopsConfig['usercookie'], 0, -1, '/', XOOPS_COOKIE_DOMAIN, 0);
        }
    }
	if($user->getVar('name')){
		$value = $user->getVar('name');
	}else{
		$value = $user->getVar('uname');
	}	
	$xoBile_text = new HAW_text(sprintf(_US_LOGGINGU, $value));
	$xoBile_page->add_text($xoBile_text);
	$xoBile_page->backURL = "index.php";
}else{
	$xoBile_form = new HAW_form($_SERVER['PHP_SELF']."?page=user&style=".$GLOBALS['style'], HAW_METHOD_POST);
	$xoBile_input = new HAW_input("id", "", _US_NICKNAME,  "*N");
	$xoBile_input->set_size(10);
	$xoBile_input->set_maxlength(30);
	$xoBile_form->add_input($xoBile_input);
	$xoBile_input = new HAW_input("pw", "", _US_PASSWORD, "*N");
	$xoBile_input->set_size(10);
	$xoBile_input->set_maxlength(30);
	$xoBile_input->set_type(HAW_INPUT_PASSWORD);
	$xoBile_form->add_input($xoBile_input);
	$xoBile_checkbox = new HAW_checkbox("rm", "On", _US_REMEMBERME, HAW_CHECKED);
	$xoBile_form->add_checkbox($xoBile_checkbox);
	$xoBile_submit = new HAW_submit(_SUBMIT, "submit");
	$xoBile_form->add_submit($xoBile_submit);
	$xoBile_page->add_form($xoBile_form);
}
?>
