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

$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("wfdownloads_downloads")." ORDER BY lid DESC limit 0,5";
$result = $GLOBALS['xoopsDB']->queryF($sql);

while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
    $title = strtr(strip_tags($row["title"]), $replacements);
    $title = ucfirst ($title);
    $xoBile_text = new HAW_text($title, HAW_TEXTFORMAT_SMALL);
    $xoBile_text->set_br(2);
    $xoBile_page->add_text($xoBile_text);
}
?>
