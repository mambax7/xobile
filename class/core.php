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

/**
This class is a extension of the HAW_deck class. It simplifies usage from within XOOPS.
@see HAW_deck
*/

class xoBile_core extends HAW_deck {
    var $sitename;
	var $template;
	var $backlink;
    var $backURL;
	/**
    Constructor
    @param backlinkV The text used in the "<< Back" link
	*/
    function __construct($backlinkV){
        $this->HAW_deck($GLOBALS['xoopsConfig']['sitename'], HAW_ALIGN_LEFT);
		$this->sitename = $GLOBALS['xoopsConfig']['sitename'];
		$this->template = $GLOBALS['xoBileConfig']['template'];
		$this->backlink = $backlinkV;
		$this->backURL  = "index.php";   
    }
    /**
    Loads the xoBile header.
    */
	function loadheader() {
		$this->use_simulator($this->template);
        $this->set_css($this->template);
        $this->use_link_brackets(false); 
        if($GLOBALS['plugin']['plugdir'] == "system"){
            $xoBile_text = new HAW_text($this->sitename);
        }else{
            $xoBile_text = new HAW_text($GLOBALS['plugin']['name']);
        }
        $xoBile_text->set_css_class("toolbar");
        $this->add_text($xoBile_text);
	}
	/**
    Displays a error.
	@param errormsg The error text to be displayed.
	@param d An array with the replacement variables.
    */
	function error($errormsg, $d = array("plugin" => "", "page" => "", "language" => "")) {
		$errormsg = stripslashes($errormsg);
        $replacements = array(
            "{{plugin}}" => $d["plugin"],
            "{{page}}" => $d["page"], 
            "{{language}}" => $d["language"]
        );
        $errormsg = strtr($errormsg, $replacements);
		$mobText  = new HAW_text($errormsg, HAW_TEXTFORMAT_BOLD);
		$this->add_text($mobText);
	}
	
    /**
    Loads the xoBile footer.
    */
	function loadfooter() {
        if($this->backURL){
            $br = new HAW_text("");
            $br->set_br(1);
            $this->add_text($br);
            $xoBile_link = new HAW_link($this->backlink, $this->backURL);
            $xoBile_link->set_css_class("backButton");
            $this->add_link($xoBile_link);
        }
		$this->create_page();
	}
	/**
    Checks if the current user has permission to do a specified action.
	@param type Permission type
	@param module The dirname of the module you want to check
	@param extra Extra parameters
	See the XOOPS documentation on XoopsGroupPermHandler::checkRight for more info.
	*/
	function permission($type, $module, $extra = false) {
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname($module);
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$perm_handler =& xoops_gethandler('groupperm');
		if($extra != false){
			if (is_object($xoopsModule) && $perm_handler->checkRight($type, $extra, $xoopsModule->getVar('mid'), $groups)){
				return true;
			}else{
				return false;
			}
		}else{
			if (is_object($xoopsModule) && $perm_handler->checkRight($type, $xoopsModule->getVar('mid'), $groups)){
				return true;
			}else{
				return false;
			}
		}
	}
	/**
    Loads the language file for a specified plugin.
	<p><b>Usage:</b><p>
	To load the language file of the system plugin you can use:
		$xoBile_page->loadPluginLanguage("system", _MA_xobile_ERROR_NPL);
	@param plugin Plugin dirname
	@param errortxt The text to display when a error occurs
	@param checkvalid (optional) Set to false when you don't want to check if a language is loaded correctly
	*/
	function loadPluginLanguage($plugin, $errortxt, $checkvalid = true) {
		$error = false;
		$local_file = $GLOBALS['xoBileConfig']['rootpath']."/plugins/".$plugin."/language/".$GLOBALS['xoopsConfig']['language'].".inc.php";
		$english_file  = $GLOBALS['xoBileConfig']['rootpath']."/plugins/".$plugin."/language/english.inc.php";
		if(file_exists($local_file)){
			include($local_file);
		}elseif(file_exists($english_file)){
			include($english_file);
		}else{
			$error = true;
		}
		if($checkvalid == true && !isset($lang) && !is_array($lang)){
			$error = true;
		}
		if($error == true){
			$this->error($errortxt);
			$this->loadfooter();
			exit;
		}
		$GLOBALS['lang'] = $lang;
	}
	/**
    Removes xoops code and html code from a chunk of text and add's it tho the HAW_deck
	@param text The text chunk to clean up
	@param br (optional) The number of new lines you want after the text chunk
	@param style (optional)<br>
      HAW_TEXTFORMAT_NORMAL (default)<br>
      HAW_TEXTFORMAT_BOLD<br>
      HAW_TEXTFORMAT_UNDERLINE<br>
      HAW_TEXTFORMAT_ITALIC<br>
      HAW_TEXTFORMAT_BIG<br>
      HAW_TEXTFORMAT_SMALL<br>
      HAW_TEXTFORMAT_BOXED (text in a colored box for headings etc.)
	*/
    function renderXoCode($text, $br = 0, $style = HAW_TEXTFORMAT_NORMAL) {
    //TODO: Render tags instead of replacing them.
        // Style tags
        $text = preg_replace('#\[b\](.*?)\[/b\]#si', '\1', $text);
        $text = preg_replace('#\[i\](.*?)\[/i\]#si', '\1', $text);
        $text = preg_replace('#\[u\](.*?)\[/u\]#si', '\1', $text);
        $text = preg_replace('#\[d\](.*?)\[/d\]#si', '\1', $text);
        $text = preg_replace('#\[left\](.*?)\[/left\]#si', '\1', $text);
        $text = preg_replace('#\[center\](.*?)\[/center\]#si', '\1', $text);
        $text = preg_replace('#\[right\](.*?)\[/right\]#si', '\1', $text);
  
        // Code tags (Not finished)
        $text = preg_replace('#\[url=(.*?)\](.*?)\[/url\]#si', '\2 (\1)', $text);
        $text = preg_replace('#\[quote\](.*?)\[/quote\]#si', 'Quote: \1)', $text);
        $text = preg_replace('#\[quote=(.*?)\](.*?)\[/quote\]#si', 'Qoute (\1): \2', $text);
        $text = preg_replace('#\[code\](.*?)\[/code\]#si', 'Code: \1)', $text);
        
        // Decoding
        $text = htmlspecialchars_decode($text);
        $text = urldecode($text);
        $text = html_entity_decode($text);
        
        // Output
        $text = new HAW_text($text, $style);
        $text->set_br($br);
        $this->add_text($text);
    }
	// Redefined HAWHAW functions
	
	/**
    Adds a HAW_link object to HAW_deck
    @param link Some HAW_link object.
    @see HAW_link
    */
	function add_link(&$link) {
		if(!is_object($link)){
			die("xoBile || invalid argument in add_link()");
		}
		if (strpos($link->url, '?') !== false && $GLOBALS['style'] == 2){
			$link->url .= "&style=2";
		}elseif($GLOBALS['style'] == 2){
			$link->url .= "?style=2";
		}
		parent::add_link(&$link);
	}
	/**
    Adds a HAW_linkset object to HAW_deck.
    @param linkset Some HAW_linkset object.
    @see HAW_linkset
    */
	function add_linkset(&$linkset) {
		if(!is_object($linkset)){
			die("xoBile || invalid argument in add_linkset()");
		}
		if($GLOBALS['style'] == 2){
			$i = 0;
			$running = 1;
			while($running == 1){
				if(isset($linkset->element[$i]) && is_object($linkset->element[$i])){
					if (strpos($linkset->element[$i]->url, '?')){
						$linkset->element[$i]->url .= "&style=2";
					}else{
						$linkset->element[$i]->url .= "?style=2";
					}
					$i++;
				}else{
					$running = 0;
				}
			}
		}
		parent::add_linkset(&$linkset);
	}
}
?>