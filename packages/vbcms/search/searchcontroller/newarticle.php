<?php if (!defined('VB_ENTRY')) die('Access denied.');

class vBCms_Search_SearchController_NewArticle extends vBCms_Search_SearchController_NewContentNode
{

	/** standard constructor **/
	public function __construct()
	{
		$self->contenttypeid = vB_Types::instance()->getContentTypeID('vBCms_NewArticle');
	}

}
/*======================================================================*\
|| ####################################################################
|| # Downloaded: 16:29, Sun Dec 9th 2012
|| # SVN: $Revision: 34955 $
|| ####################################################################
\*======================================================================*/