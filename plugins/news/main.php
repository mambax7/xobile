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
$replacements = array(
		"à" => "a'",
		"á" => "a'",
		"è" => "e'",
		"é" => "e'",
		"ì" => "i'",
		"ò" => "o'",
		"ù" => "u'",
		"ú" => "u'",
		"&nbsp;" => " ",
	);
    
$sql = "SELECT title ,storyid FROM ".$GLOBALS['xoopsDB']->prefix("stories")." ORDER BY storyid DESC limit 0,5";
$result = $GLOBALS['xoopsDB']->queryF($sql);
$xoBile_lnks = new HAW_linkset();
while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $xoBile_link = strtr(strip_tags($row["title"]), $replacements);
    $xoBile_link = ucfirst ($xoBile_link);
    $xoBile_link = new HAW_link($xoBile_link,"index.php?mod=news&page=read&id=".$row['storyid']);
    $xoBile_link->set_br(1);
    $xoBile_lnks->add_link($xoBile_link);
}
$xoBile_page->add_linkset($xoBile_lnks);
?>