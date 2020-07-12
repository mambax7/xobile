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
$xoBile_page->loadPluginLanguage("about", _MA_xobile_ERROR_NPL);

$xoBile_text = new HAW_text($lang['website']." ".$GLOBALS['xoops']->url(''), HAW_TEXTFORMAT_SMALL);
$xoBile_text->set_br(2);
$xoBile_page->add_text($xoBile_text);

$xoBile_text = new HAW_text($lang['webmaster']." ".$GLOBALS['xoBileConfig']['admin']->getVar('name'), HAW_TEXTFORMAT_SMALL);
$xoBile_text->set_br(1);
$xoBile_page->add_text($xoBile_text);

$xoBile_text = new HAW_text($lang['email']." ".$GLOBALS['xoopsConfig']['adminmail'], HAW_TEXTFORMAT_SMALL);
$xoBile_text->set_br(2);
$xoBile_page->add_text($xoBile_text);

// YOU ARE NOT ALLOWED TO REMOVE THE TEXT BELOW!!!!
$xoBile_text = new HAW_text("xoBile ".$GLOBALS['xoBileConfig']['version']." by XD Soft (http://www.dylian.eu)", HAW_TEXTFORMAT_SMALL);
$xoBile_text->set_br(1);
$xoBile_page->add_text($xoBile_text);
// YOU ARE NOT ALLOWED TO REMOVE THE TEXT ABOVE!!!!
?>
