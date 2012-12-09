<?php

/* ======================================================================*\
  || #################################################################### ||
  || # vBulletin 4.2.0 Patch Level 3 - Licence Number VBFBED0615
  || # ---------------------------------------------------------------- # ||
  || # Copyright �2000-2012 vBulletin Solutions Inc. All Rights Reserved. ||
  || # This file may not be redistributed in whole or significant part. # ||
  || # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
  || # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
  || #################################################################### ||
  \*====================================================================== */

abstract class vB_ActivityStream_View_Perm_Forum_Base extends vB_ActivityStream_View_Perm_Base
{
	protected function fetchCanViewPost($postid)
	{
		if (!($postrecord = $this->content['post'][$postid]))
		{
			return false;
		}
		$threadid = $postrecord['threadid'];
		$threadrecord = $this->content['thread'][$threadid];
		$forumid = $threadrecord['forumid'];
		$postviewable = ($postrecord['visible'] == 1 OR can_moderate($forumid));

		if (!$postviewable OR !$this->fetchCanViewThread($threadid))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	protected function fetchCanViewThread($threadid)
	{
		if (!($threadrecord = $this->content['thread'][$threadid]))
		{
			return false;
		}
		$forumid = $threadrecord['forumid'];

		$canviewothers = vB::$vbulletin->userinfo['forumpermissions']["$forumid"] & vB::$vbulletin->bf_ugp_forumpermissions['canviewothers'];
		$canviewthreads = vB::$vbulletin->userinfo['forumpermissions']["$forumid"] & vB::$vbulletin->bf_ugp_forumpermissions['canviewthreads'];
		$threadviewable = (($threadrecord['visible'] == 1 OR can_moderate($forumid)) AND $canviewthreads);
		if (!$threadviewable OR !$this->fetchCanViewForum($forumid) OR (!$canviewothers AND $threadrecord['postuserid'] != vB::$vbulletin->userinfo['userid']))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	protected function fetchCanViewForum($forumid)
	{
		return (vB::$vbulletin->userinfo['forumpermissions']["$forumid"] & vB::$vbulletin->bf_ugp_forumpermissions['canview'] AND verify_forum_password($forumid, vB::$vbulletin->forumcache["$forumid"]['password'], false));
	}
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 16:29, Sun Dec 9th 2012
|| # CVS: $RCSfile$ - $Revision: 57655 $
|| ####################################################################
\*======================================================================*/