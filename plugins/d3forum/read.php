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
    "[img align=left]" => "[IMG]",
    "[img align=right]" => "[IMG]",
    "[/img]" => "[IMG]",
		"&nbsp;" => " ",
	);
$post_id = intval($_GET['id']);

$sql = "SELECT * FROM ".$GLOBALS['xoopsDB']->prefix("forum_posts")." WHERE post_id = $post_id";
$result = $GLOBALS['xoopsDB']->queryF($sql);
$row = $GLOBALS['xoopsDB']->fetchArray($result);

$subject = strtr(strip_tags($row["subject"]), $replacements);
$content = strtr(strip_tags($row["post_text"]), $replacements);

$space = new HAW_text("\n");

$xoBile_text = new HAW_text("$subject:", HAW_TEXTFORMAT_BOLD);
$xoBile_text->set_br(1);
$xoBile_page->add_text($xoBile_text);
$xoBile_page->renderXoCode($content);

$xoBile_page->backURL = "index.php?mod=d3forum";
?>
