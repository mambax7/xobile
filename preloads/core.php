<?php
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class xoBileCorePreload extends XoopsPreloadItem
{
    function eventCoreIncludeCommonEnd($args)
    {
        $WURFL_active = xoBileCorePreload::isActiveWURFL();
        if (xoBileCorePreload::isActive()){
            include XOOPS_ROOT_PATH . '/modules/xobile/include/mobilecheck.inc.php';
        }
    }
    function isActive()
    {
        $module_handler =& xoops_getHandler('module');
        $module = $module_handler->getByDirname('xobile');
        return ($module && $module->getVar('isactive')) ? true : false;
    }
    function isActiveWURFL()
    {
		if(file_exists(XOOPS_URL."/modules/wurfl/xoops_version.php")){
			$module_handler =& xoops_getHandler('module');
			$module = $module_handler->getByDirname('wurfl');
			return ($module && $module->getVar('isactive')) ? true : false;
		}else{
			return false;
		}
    }
}
?>