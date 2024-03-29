<?php

define('INT_SECOND', 1);
define('INT_MINUTE', 60);
define('INT_HOUR',   3600);
define('INT_6HOUR',  21600);
define('INT_DAY',    86400);
define('INT_WEEK',   604800);

include 'includes/pos_val.php';
/**
 * POSMGMT
 *
 * @package POS-Tracker2
 * @author     Stephen Gulickk <stephenmg12@gmail.com>
 * @author     DeTox MinRohim <eve@onewayweb.com>
 * @copyright 2008-2009
 * @version SVN: $Id: class.pos.php 238 2012-03-26 05:40:38Z frozenice2525 $
 * @access public
 */
class POSMGMT
{
    /**
     * POSMGMT::get_formatted_timediff()
     *
     * @param mixed $then
     * @param bool $now
     * @return return $str
     */
    function get_formatted_timediff($then, $now = false)
    {
        $now      = (!$now) ? time() : $now;
        $timediff = ($now - $then);
        $weeks    = (int) intval($timediff / INT_WEEK);
        $timediff = (int) intval($timediff - (INT_WEEK * $weeks));
        $days     = (int) intval($timediff / INT_DAY);
        $timediff = (int) intval($timediff - (INT_DAY * $days));
        $hours    = (int) intval($timediff / INT_HOUR);
        $timediff = (int) intval($timediff - (INT_HOUR * $hours));
        $mins     = (int) intval($timediff / INT_MINUTE);
        $timediff = (int) intval($timediff - (INT_MINUTE * $mins));
        $sec      = (int) intval($timediff / INT_SECOND);
        $timediff = (int) intval($timediff - ($sec * INT_SECOND));

        $str = '';
        if ( $weeks ) {
            $str .= intval($weeks);
            $str .= ($weeks > 1) ? ' weeks' : ' week';
        }
        if ( $days ) {
            $str .= ($str) ? ', ' : '';
            $str .= intval($days);
            $str .= ($days > 1) ? ' days' : ' day';
        }
        if ( $hours ) {
            $str .= ($str) ? ', ' : '';
            $str .= intval($hours);
            $str .= ($hours > 1) ? ' hours' : ' hour';
        }
        if ( $mins ) {
            $str .= ($str) ? ', ' : '';
            $str .= intval($mins);
            $str .= ($mins > 1) ? ' minutes' : ' minute';
        }
        if ( $sec ) {
            $str .= ($str) ? ', ' : '';
            $str .= intval($sec);
            $str .= ($sec > 1) ? ' seconds' : ' second';
        }
        if ( !$weeks && !$days && !$hours && !$mins && !$sec ) {
            $str .= '0 seconds ago';
        } else {
            $str .= ' ago';
        }

        return $str;
    }

    /**
     * POSMGMT::GetLastSystemUpdate()
     *
     * @return $row['updateTime']
     */
    function GetLastSystemUpdate()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."system_status
                WHERE  SolarSystemID = '30023410'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row['updateTime'];

    }

    /**
     * POSMGMT::GetLastAllianceUpdate()
     *
     * @return $row['updateTime']
     */
    function GetLastAllianceUpdate()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."alliance_info
                WHERE  AllianceID = '0'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row['updateTime'];

    }

	function GetLastJobUpdate($characterID)
    {

        $dbconn =& DBGetConn(true);
		if ($characterID == 5) {
		$sql = "SELECT * FROM  ".TBL_PREFIX."update_log WHERE action = 'EVEAPI XML JOBS API UPDATE' ORDER BY id DESC LIMIT 1";
		} else {
		$sql = "SELECT * FROM  ".TBL_PREFIX."update_log WHERE action = 'EVEAPI XML JOBS API UPDATE' and type_id = '".Eve::VarPrepForStore($characterID)."' ORDER BY id DESC LIMIT 1";
		}

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row['datetime'];

    }
    /**
     * POSMGMT::GetAllianceByName()
     *
     * @param mixed $allname
     * @return
     */
    function GetAllianceByName($allname)
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."alliance_info
                WHERE  name = '".Eve::VarPrepForStore($allname)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row;

    }

    /**
     * POSMGMT::GetLastAPITimer()
     *
     * @return
     */
    function GetLastAPITimer()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT    *
                FROM      ".TBL_PREFIX."eveapi
                ORDER BY  apitimer DESC LIMIT 1";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row['apitimer'];

    }

    /**
     * POSMGMT::GetLastPosUpdate()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetLastPosUpdate($pos_id)
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."update_log
                WHERE    type_id = '" . $pos_id . "'
                AND      type    = '1'
                ORDER BY id DESC LIMIT 1";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row;

    }

    /**
     * POSMGMT::GetAllUsers()
     *
     * @return
     */
    function GetAllUsers()
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT    *
                FROM      ".TBL_PREFIX."user
                ORDER BY  name";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $users[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $users;

    }

    /**
     * POSMGMT::GetAllUsersArray()
     *
     * @return
     */
    function GetAllUsersArray()
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT    name, eve_id
                FROM      ".TBL_PREFIX."user
                ORDER BY  name";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $users[] = $result->GetRowAssoc(2);
        }

        foreach($users as  $user) {
            $user_array[$user['eve_id']]=$user['name'];
        }

        $result->Close();

        return $user_array;

    }
    /**
     * POSMGMT::GetAllUsersWithAccess()
     *
     * @param mixed $access
     * @return
     */
    function GetAllUsersWithAccess($access)
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."user
                WHERE  access = '".Eve::VarPrepForStore($access)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $users[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $users;

    }

    /**
     * POSMGMT::GetUserInfofromID()
     *
     * @param mixed $characterID
     * @return
     */
    function GetUserInfofromID($characterID)
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."user
                WHERE  eve_id = '".Eve::VarPrepForStore($characterID)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

       return $row;

    }

    /**
     * POSMGMT::LogUser()
     *
     * @param mixed $args
     * @return
     */
    function LogUser($args)
    {

        if (!isset($args['name']) or empty($args['name'])) {
            return false;
        }
        if (!isset($args['pass']) or empty($args['pass'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM  ".TBL_PREFIX."user
                WHERE name = '" . Eve::VarPrepForStore($args['name']) . "'";
                //AND   pass = (PASSWORD('" . Eve::VarPrepForStore($args['pass']) . "'))";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $userinfo = $result->GetRowAssoc(2);
        $result->Close();

        $compare  = false;
        $password = $args['pass'];
        $hash     = $userinfo['pass'];

        $compare = $this->comparePassword($password, $hash); //New Password Hashing method

        if ($compare) {
            Eve::SessionSetVar('name',           $userinfo['name']);
            Eve::SessionSetVar('eve_id',         $userinfo['eve_id']);
            Eve::SessionSetVar('access',         $userinfo['access']);
            Eve::SessionSetVar('corp',           $userinfo['corp']);
            Eve::SessionSetVar('id',             $userinfo['id']);
            Eve::SessionSetVar('email',          $userinfo['email']);
            Eve::SessionSetVar('away',           $userinfo['away']);
            Eve::SessionSetVar('highly_trusted', $userinfo['highly_trusted']);
            Eve::SessionSetVar('delsid',         $userinfo['delsid']);
            Eve::SessionSetVar('allianceID',     $userinfo['alliance_id']);
			Eve::SessionSetVar('theme_id',       $userinfo['theme_id']);
			Eve::SessionSetVar('user_track',       $userinfo['user_track']);
            Eve::SessionSetVar('userlogged',     true);

            return $userinfo;
        } else {

            return false;

        }
    }

    /**
     * POSMGMT::getPasswordSalt()
     *
     * @return
     */
    function getPasswordSalt()
    {
        return substr( str_pad( dechex( mt_rand() ), 8, '0', STR_PAD_LEFT ), -8 );
    }

    // calculate the hash from a salt and a password
    /**
     * POSMGMT::getPasswordHash()
     *
     * @param mixed $salt
     * @param mixed $password
     * @return
     */
    function getPasswordHash($salt, $password )
    {
        //hash requires php version 5.1.2 to work. It also must be enabled, check with your hosting provider on how to enable/install extentions
        return (hash('md5', $salt.$password ) );
        //return (md5($salt.$password)); //If you have dificulty with hash, you can uncomment this line and comment line 12
    }

    // compare a password to a hash
    /**
     * POSMGMT::comparePassword()
     *
     * @param mixed $password
     * @param mixed $dbhash
     * @return
     */
    function comparePassword($password, $dbhash)
    {
        $password = Eve::VarCleanFromInput('pass');//$_POST['pass'];
        $salt     = substr($dbhash, 0, 8);
        $hash     = $this->getPasswordHash($salt, $password);
        $shash    = $salt.$hash;
        if($shash == $dbhash) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * POSMGMT::newpasswordhash()
     *
     * @param mixed $password
     * @return
     */
    function newpasswordhash($password)
    {
        $salt   = $this->getPasswordSalt();
        $hash   = $this->getPasswordHash($salt, $password);
        $dbhash = $salt.$hash;
        return $dbhash;
    }

    /**
     * POSMGMT::GetUserInfo()
     *
     * @return
     */
    function GetUserInfo()
    {

        $userlogged = Eve::SessionGetVar('userlogged');

        if (!$userlogged) {
            return false;
        } else {
            $userinfo = array('name'           => Eve::SessionGetVar('name'),
                              'access'         => Eve::SessionGetVar('access'),
                              'corp'           => Eve::SessionGetVar('corp'),
                              'id'             => Eve::SessionGetVar('id'),
                              'eve_id'         => Eve::SessionGetVar('eve_id'),
                              'email'          => Eve::SessionGetVar('email'),
                              'away'           => Eve::SessionGetVar('away'),
                              'highly_trusted' => Eve::SessionGetVar('highly_trusted'),
                              'delsid'         => Eve::SessionGetVar('delsid'),
							  'theme_id'       => Eve::SessionGetVar('theme_id'),
							  'user_track'       => Eve::SessionGetVar('user_track'),
                              'allianceID'     => Eve::SessionGetVar('allianceID'));

        }
        return $userinfo;
    }

    /**
     * POSMGMT::LogOutUser()
     *
     * @return
     */
    function LogOutUser()
    {

        $userlogged = Eve::SessionGetVar('userlogged');

        if (!$userlogged) {
            return true;
        } else {
            Eve::SessionDelVar('name');
            Eve::SessionDelVar('access');
            Eve::SessionDelVar('corp');
            Eve::SessionDelVar('id');
            Eve::SessionDelVar('eve_id');
            Eve::SessionDelVar('email');
            Eve::SessionDelVar('away');
            Eve::SessionDelVar('highly_trusted');
            Eve::SessionDelVar('delsid');
            Eve::SessionDelVar('allianceID');
			Eve::SessionDelVar('theme_id');
            Eve::SessionDelVar('userlogged');
			Eve::SessionDelVar('user_track');
        }
        return true;

    }

	/**
     * POSMGMT::UpdateUserSettings()
     *
     * @param mixed $args
     * @return
     */
    function UpdateUserSettings($args)
    {
        if (!isset($args['id'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }
		
        if (!isset($args['newaway']) || !isset($args['newtheme']) || !isset($args['new_user_track'])) {
            Eve::SessionSetVar('errormsg', 'User Setting Missing!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."user
				SET  away          = '".Eve::VarPrepForStore($args['newaway'])."',
				theme_id          = '".Eve::VarPrepForStore($args['newtheme'])."',
				user_track          = '".Eve::VarPrepForStore($args['new_user_track'])."'
                WHERE  id            = '".Eve::VarPrepForStore($args['id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        Eve::SessionSetVar('away', $args['newaway']);
		Eve::SessionSetVar('theme_id', $args['newtheme']);
		Eve::SessionSetVar('user_track', $args['new_user_track']);
		
        return true;
    }
	
	
    /**
     * POSMGMT::UpdateUserMail()
     *
     * @param mixed $args
     * @return
     */
    function UpdateUserMail($args)
    {
        if (!isset($args['id'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }
        if (!isset($args['newmail'])) {
            Eve::SessionSetVar('errormsg', 'No Mail!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."user
                SET    email         = '".Eve::VarPrepForStore($args['newmail'])."'
                WHERE  id            = '".Eve::VarPrepForStore($args['id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        Eve::SessionSetVar('email', $args['newmail']);

        return true;
    }

    /**
     * POSMGMT::UpdateUserPass()
     *
     * @param mixed $args
     * @return
     */
    function UpdateUserPass($args)
    {
        if (!isset($args['id'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }
        if (!isset($args['newpass'])) {
            Eve::SessionSetVar('errormsg', 'No Password Set!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."user
                SET    pass = '".Eve::VarPrepForStore($this->newpasswordhash($args['newpass']))."'
                WHERE  id   = '".Eve::VarPrepForStore($args['id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::UpdateUserInfo()
     *
     * @param mixed $args
     * @return
     */
    function UpdateUserInfo($args)
    {
        if (!isset($args['id'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $alliance = $this->GetAllianceByName($args['useralliance']);

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."user
                SET    corp        = '".Eve::VarPrepForStore($args['usercorp'])."',
                       alliance_id = '".Eve::VarPrepForStore($alliance['allianceID'])."',
                       datetime    = '".Eve::VarPrepForStore(time())."'
                WHERE  id   = '".Eve::VarPrepForStore($args['id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        Eve::SessionSetVar('corp',       $args['usercorp']);
        Eve::SessionSetVar('allianceID', $alliance['allianceID']);

        return true;
    }

    /**
     * POSMGMT::UpdateUserAccess()
     *
     * @param mixed $args
     * @return
     */
    function UpdateUserAccess($args)
    {

        if (!isset($args['id'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."user
                SET    access         = '".Eve::VarPrepForStore($args['access'])."'
                WHERE  id             = '".Eve::VarPrepForStore($args['id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::DeleteUser()
     *
     * @param mixed $id
     * @return
     */
    function DeleteUser($id)
    {

        if (!$id) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "DELETE FROM ".TBL_PREFIX."user
                WHERE       id = '".Eve::VarPrepForStore($id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

	/**
     * POSMGMT::UpdatePrices()
     *
     * @param mixed $args
     * @return
     */
    function UpdatePrices($args)
    {

        if (!isset($args['name'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."prices
                SET    Value         = '".Eve::VarPrepForStore($args['value'])."'
                WHERE  Name             = '".Eve::VarPrepForStore($args['name'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }
	
	/**
     * POSMGMT::UpdateSettings()
     *
     * @param mixed $args
     * @return
     */
    function UpdateSettings($args)
    {

        if (!isset($args['name'])) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."settings
                SET    gsetting         = '".Eve::VarPrepForStore($args['value'])."'
                WHERE  name             = '".Eve::VarPrepForStore($args['name'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }
	
    /**
     * POSMGMT::DeletePOS()
     *
     * @param mixed $pos_id
     * @return
     */
    function DeletePOS($pos_id)
    {

        if (!$pos_id) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "DELETE FROM ".TBL_PREFIX."tower_info
                WHERE       pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $sql = "DELETE FROM ".TBL_PREFIX."pos_hanger
                WHERE       pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $sql = "DELETE FROM ".TBL_PREFIX."pos_structures
                WHERE       pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $sql = "DELETE FROM ".TBL_PREFIX."reactor_info
                WHERE       pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $sql = "DELETE FROM ".TBL_PREFIX."silo_info
                WHERE       pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $time = time();
        $sql = "INSERT INTO ".TBL_PREFIX."update_log (
                                        eve_id,
                                        type_id,
                                        type,
                                        action,
                                        datetime)
                VALUES                 ('0',
                                        '" . Eve::VarPrepForStore($pos_id) . "',
                                        '1',
                                        'Delete POS',
                                        '" . Eve::VarPrepForStore($time) . "')";
        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::GetAllPos2()
     *
     * @param mixed $args
     * @return
     */
    function GetAllPos2($args)
    {

        $userinfo = $this->GetUserInfo();

        if (!$userinfo) {
            Eve::SessionSetVar('errormsg', 'User Not Logged!');
            return false;
        }

        if (isset($args['limit']) && is_numeric($args['limit'])) {
            $limit    = $args['limit'];
            $startnum = ((isset($args['startnum'])) ? $args['startnum'] : 0);
            $page     = ((isset($args['page']))     ? $args['page']     : 1);
            $startnum = ($page * $limit) - $limit;
        }

		$access = explode('.',$userinfo['access']);
		
		if (in_array('1', $access)) { //(1.!20.!21) Normal User, doesn't have access to see all towers 
		
			if ((in_array('20', $access) || in_array('21', $access) || in_array('22', $access)) && !in_array('50', $access) && !in_array('51', $access) && !in_array('52', $access)) { //(20.21.22.!50.!51.!52) Access to see all his corp towers but can't see other corp towers
			
				if (in_array('22', $access)) { //(22) See his corps secret towers
		
					$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.corp = '".$userinfo['corp']."'";
				
				}
				else { //(!22) See all his corp towers except secretive

					$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR (".TBL_PREFIX."tower_info.corp = '".$userinfo['corp']."' AND ".TBL_PREFIX."tower_info.secret_pos = 0)";
				
				} 

			}
			elseif ((in_array('20', $access) || in_array('21', $access) ||  in_array('22', $access)) && (in_array('50', $access) || in_array('51', $access) ||  in_array('52', $access))) { //(20.21.22.50.51.52) Access to see all towers including other corps

				if (in_array('22', $access) && !in_array('52', $access)) { //(22.!52) See his corps secret towers but not other corps

					$where = "WHERE  ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.corp = '".$userinfo['corp']."' OR (".TBL_PREFIX."tower_info.corp != '".$userinfo['corp']."' AND ".TBL_PREFIX."tower_info.secret_pos = 0)";
				
				}
				elseif (in_array('22', $access) && in_array('52', $access)) { // (22.52) See everything. Just like an admin. All secretives shown
	
					$where = "WHERE 1=1";
					
				}
				elseif (!in_array('22', $access) && in_array('52', $access)) { // (!22.52) See all but his own corps secret towers. Can see other corps secret towers. Unsure why someone would do this but just incase.

					$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR (".TBL_PREFIX."tower_info.corp = '".$userinfo['corp']."' AND ".TBL_PREFIX."tower_info.secret_pos = 0) OR ".TBL_PREFIX."tower_info.corp != '".$userinfo['corp']."'";
				
				}
				else { //(!22.!52) See all towers except secretive

					$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secret_pos = 0";
				
				}
		
			}
			elseif (!in_array('20', $access) && !in_array('21', $access) && !in_array('50', $access) && !in_array('51', $access) && !in_array('52', $access)) { //(!20.!21.!50.!51.!52)

				$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']; //Show Towers where they are a fuel tech. Doesn't matter if tower is secretive.
			
			}
			elseif (!in_array('20', $access) && !in_array('21', $access) && (in_array('50', $access) || in_array('51', $access))) { //(!20.!21.50.51)
				
				$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR (".TBL_PREFIX."tower_info.corp != '".$userinfo['corp']."' AND ".TBL_PREFIX."tower_info.secret_pos = 0)";

			}
			elseif (in_array('52', $access)) { //(52) For some reason someone selected show other corps secret towers and nothing to their own which makes no sense so this should rarely be accessed.
			
				$where = "WHERE ".TBL_PREFIX."tower_info.owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.secondary_owner_id = ".$userinfo['eve_id']." OR ".TBL_PREFIX."tower_info.corp != '".$userinfo['corp']."'";

			}
			
			
		}
		elseif (in_array('5', $access) || in_array('6', $access)) { //(5) Admin user

			$where = "WHERE 1=1";
		}
		else {

			$where = "WHERE 1=0";
		}

        $dbconn =& DBGetConn(true);

        $sql = "SELECT    ".TBL_PREFIX."tower_info.*,
                          u1.name,
                          u1.corp as ucorp,
                          u2.name AS 'backup',
                          ".TBL_PREFIX."evemoons.moonName AS 'MoonName',
                          mr.regionName AS 'region',
                          ms.solarSystemName AS 'system'
                FROM      ".TBL_PREFIX."tower_info
                LEFT JOIN ".TBL_PREFIX."user u1 ON ".TBL_PREFIX."tower_info.owner_id = u1.eve_id
                LEFT JOIN ".TBL_PREFIX."user u2 ON ".TBL_PREFIX."tower_info.secondary_owner_id = u2.eve_id
                LEFT JOIN ".TBL_PREFIX."evemoons ON ".TBL_PREFIX."tower_info.moonID = ".TBL_PREFIX."evemoons.moonID
                LEFT JOIN ".TBL_PREFIX."mapregions mr ON ".TBL_PREFIX."evemoons.regionID = mr.regionID
                LEFT JOIN ".TBL_PREFIX."mapsolarsystems ms ON ".TBL_PREFIX."tower_info.systemID = ms.solarSystemID
                ".$where;
            //$result = $dbconn->SelectLimit($sql, $limit, $startnum);

            $result = $dbconn->Execute($sql);
			
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();
		
		$posrace = array(1  => 'Amarr CT',
                       2  => 'Caldari CT',
                       3  => 'Gallente CT',
                       4  => 'Minmatar CT',
                       5  => 'Angel CT',
                       6  => 'Blood CT',
                       7  => 'Dark Blood CT',
                       8  => 'Domination CT',
                       9  => 'Dread Guristas CT',
                       10 => 'Guristas CT',
                       11 => 'Sansha CT',
                       12 => 'Serpentis CT',
                       13 => 'Shadow CT',
                       14 => 'True Sansha CT');

		
		
		$orderby = "";
		$orderby2 = "";
		switch($args['sb']) {
					case 1:
					case 13:
						$orderby="result_online"; //Done
					break;
					case 2:
					case 14:
						$orderby="MoonName"; //Done
					break;
					case 3:
					case 15:
						$orderby="region"; //Done
					break;
					case 4:
					case 16:
						$orderby="towerName"; //Done
					break;
					case 5:
					case 17:
						$orderby="typeID"; //Done. Though not sure what's the point of this one.
					break;
					case 6:
					case 18:
						$orderby="name"; //Done
					break;
					case 7:
					case 19:
						$orderby="backup"; //Done
					break;
					case 8:
					case 20:
						$orderby="MoonName"; //Won't be used. Used to be outpost_id.
					break;
					case 9:
					case 21:
						$orderby="pos_size"; //Done
						$orderby2="typeID";
					break;
					case 10:
					case 22:
						$orderby="pos_race"; //Done
						$orderby2="pos_size";
					break;
					case 11:
					case 23:
						$orderby="corp"; //Done
					break;
					case 12:
					case 24:
						$orderby="status"; //Done
					break;
					default:
						$orderby="MoonName"; //Done
					break;
				}
		
        foreach($rows as $key => $row) {

            $row2 = $this->GetLastPosUpdate($row['pos_id']);

            $row['result_uptimecalc'] = $this->uptimecalc($row['pos_id']);
            $row['result_online']     = $this->online($row['result_uptimecalc']);
            $row['last_update']       = gmdate("Y-m-d H:i:s", $row2['datetime']);
            $row['online']            = $this->daycalc($row['result_online']);
            //$row['region']            = $this->getRegionNameFromMoonID($row['MoonName']);
            //$row['system']            = $this->getSystemName($row['systemID']);
			if ($args['pr'] != 2) {
					$row['pos_race'] = $posrace[$row['pos_race']];
			}
            $rows[$key] = $row;
        }

		foreach ($rows as $key => $row) { 
			$sortland[$key] = $row[$orderby];
			$sortland2[$key] = $row[$orderby2];
		}
		$array_lowercase = array_map('strtolower', $sortland);
			
		if ($args['sb'] >=13 && $args['sb'] <=24) {
		array_multisort($array_lowercase, SORT_DESC, $sortland2, SORT_DESC, $rows); 
		} else {
		array_multisort($array_lowercase, SORT_ASC, $sortland2, SORT_ASC, $rows); 
		}
		
        if($limit) {
            $rows=array_slice($rows, $startnum, $limit);
        }

        return $rows;

    }

    /**
     * POSMGMT::posoptimaluptime()
     *
     * @param mixed $tower
     * @return
     */
    function posoptimaluptime($tower)
    {
        //Setup
        $required_fuelblock                  = $tower['required_fuelblock'];
        $required_charters                   = $tower['required_charters'];
		$required_strontium                  = $tower['required_strontium'];
        $strontium_capacity                  = $tower['strontium_capacity'];
        $pos_capacity                        = $tower['fuel_hangar'];
        $tower['pos_capacity']               = $pos_capacity;
		
        //Calculate Optimal cycles
        $volume_per_cycle  = 0;
        $volume_per_cycle += ($required_fuelblock * $GLOBALS["pos_Fbl"]);
        $volume_per_cycle += ($required_charters * $GLOBALS["pos_Cha"]);
        $optimum_cycles    = floor(($pos_capacity)/$volume_per_cycle);

        //calculate optimal (done!, do not touch)
        $optimal['optimum_cycles']=$optimum_cycles;
        $optimal['optimal_strontium_cycles'] = $optimal_strontium_cycles = floor($strontium_capacity/($required_strontium*3));
        $optimal['optimum_fuelblock']          = $required_fuelblock * $optimum_cycles;
        $optimal['optimum_charters']         = $optimum_cycles;
        $optimal['optimum_strontium']        = $required_strontium * $optimal_strontium_cycles;
        return $optimal;
    }

    /**
     * POSMGMT::getOptimalDifference()
     * @param array $optimal
     * @param array $tower
     * @return array $diff
     */
     function getOptimalDifference($optimal, $tower)
     {
        //Diff clear
        $diff=array();
        //Calculate the difference between whats in the tower and optimal
        $diff['fuelblock']=$optimal['optimum_fuelblock']-$tower['fuelblock'];
		
		if ($tower['charters_needed'] == 1) {
        $diff['charters']=$optimal['optimum_charters']-$tower['charters'];
		} else {
		$diff['charters']=0;
		}
        $diff['strontium']=$optimal['optimum_strontium']-$tower['strontium'];

        //calculate optimal difference in m3
        $diff['fuelblock_m3']=$diff['fuelblock']*$GLOBALS["pos_Fbl"];
        $diff['charters_m3']=$diff['charters']*$GLOBALS["pos_Cha"];
        $diff['strontium_m3']=$diff['strontium']*$GLOBALS["pos_Str"];
		
		if ($diff['fuelblock_m3']>= 1)
		{
			$diff['totalDiff']=$diff['totalDiff']+$diff['fuelblock_m3'];
		}
		if ($diff['charters_m3']>= 0.1)
		{
			$diff['totalDiff']=$diff['totalDiff']+$diff['charters_m3'];
		}
        return $diff;
     }

    /**
     * POSMGMT::getConstellationNameFromMoonID()
     *
     * @param mixed $moon
     * @return
     */
    function getConstellationNameFromMoonID($moon)
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT ".TBL_PREFIX."mapconstellations.constellationName,
                       moonName
                FROM   ".TBL_PREFIX."mapconstellations,
                       ".TBL_PREFIX."mapsolarsystems,
                       ".TBL_PREFIX."evemoons
                WHERE  ".TBL_PREFIX."evemoons.moonName = '".Eve::VarPrepForStore($moon)."'
                AND    ".TBL_PREFIX."evemoons.systemID = ".TBL_PREFIX."mapsolarsystems.SolarSystemID
                AND    ".TBL_PREFIX."mapsolarsystems.constellationID = ".TBL_PREFIX."mapconstellations.constellationID";

        $result = $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Could not select from getConstellationNameFromMoonID ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);
        $result->Close();
        //echo '<pre>';print_r($rows);echo '</pre>';exit;
        return $row['constellationName'];
    }


    /**
     * POSMGMT::getRegionNameFromMoonID()
     *
     * @param mixed $moon
     * @return
     */
    function getRegionNameFromMoonID($moon)
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT ".TBL_PREFIX."mapregions.regionName,
                       moonName
                FROM   ".TBL_PREFIX."mapregions,
                       ".TBL_PREFIX."evemoons
                WHERE  ".TBL_PREFIX."evemoons.moonName = '".Eve::VarPrepForStore($moon)."'
                AND    ".TBL_PREFIX."evemoons.regionID = ".TBL_PREFIX."mapregions.regionID";

        $result = $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Could not select from getRegionNameFromMoonID ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);
        $result->Close();
        //echo '<pre>';print_r($rows);echo '</pre>';exit;
        return $row['regionName'];
    }

    /**
     * POSMGMT::getMoonNameFromMoonID()
     *
     * @param mixed $moonID
     * @return
     */
    function getMoonNameFromMoonID($moonID)
    {
        $dbconn =& DBGetConn(true);
        $sql = "SELECT `moonName` FROM `".TBL_PREFIX."evemoons` WHERE `moonID`=".Eve::VarPrepForStore($moonID)." LIMIT 0, 30 ";

        $result = $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Could not select from getMoonNameFromMoonID ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);
        $result->Close();
        //echo '<pre>';print_r($rows);echo '</pre>';exit;
        return $row['moonName'];
    }

    /**
     * POSMGMT::GetAllTowers()
     *
     * @param mixed $args
     * @return
     */
    function GetAllTowers($args)
    {

        $dbconn =& DBGetConn(true);

        $where = "";
        $where2 = "";
        if (isset($args['ownerID'])) {
            $where2 = " AND (".TBL_PREFIX."tower_info.owner_id = '".$args['ownerID']."' OR ".TBL_PREFIX."tower_info.secondary_owner_id = '".$args['ownerID']."') ";
        }

        if (isset($args['pos_ids'])) {
            $where = "WHERE  ".TBL_PREFIX."tower_info.pos_id IN ('".implode('\',\'', $args['pos_ids'])."') ";
            $sql = "SELECT * FROM `".TBL_PREFIX."tower_info` ".$where . $where2;
        } elseif (isset($args['systemID'])) {
            $where = "WHERE  ".TBL_PREFIX."tower_info.systemID = '".$args['systemID']."' ";
            $sql = "SELECT * FROM `".TBL_PREFIX."tower_info` ".$where . $where2;
        } elseif (isset($args['constellationID'])) {
            $sql = "SELECT pos_id,
                           typeID,
                           evetowerID,
                           outpost_id,
                           corp,
                           allianceid,
                           pos_size,
                           pos_race,
                           fuelblock,
                           charters,
                           strontium,
                           towerName,
                           systemID,
                           charters_needed,
                           status,
                           owner_id,
                           secondary_owner_id,
                           pos_status,
                           pos_comment,
                           secret_pos,
                           moonID,
                           ".TBL_PREFIX."mapconstellations.constellationID as constellationID,
                           ".TBL_PREFIX."mapconstellations.constellationName as constellationName
                    FROM   ".TBL_PREFIX."tower_info,
                           ".TBL_PREFIX."mapsolarsystems,
                           ".TBL_PREFIX."mapconstellations
                    WHERE  ".TBL_PREFIX."tower_info.systemID = ".TBL_PREFIX."mapsolarsystems.solarSystemID
                    AND    ".TBL_PREFIX."mapsolarsystems.constellationID = ".TBL_PREFIX."mapconstellations.constellationID
                    AND    ".TBL_PREFIX."mapsolarsystems.constellationID = '".$args['constellationID']."'" . $where2;
        } elseif (isset($args['regionID'])) {
            $sql = "SELECT pos_id,
                           typeID,
                           evetowerID,
                           outpost_id,
                           corp,
                           allianceid,
                           pos_size,
                           pos_race,
                           fuelblock,
                           charters,
                           strontium,
                           towerName,
                           systemID,
                           charters_needed,
                           status,
                           owner_id,
                           secondary_owner_id,
                           pos_status,
                           pos_comment,
                           secret_pos,
                           moonID,
                           ".TBL_PREFIX."mapregions.regionID as regionID,
                           ".TBL_PREFIX."mapregions.regionName as regionName
                    FROM   ".TBL_PREFIX."tower_info,
                           ".TBL_PREFIX."mapsolarsystems,
                           ".TBL_PREFIX."mapregions
                    WHERE  ".TBL_PREFIX."tower_info.systemID = ".TBL_PREFIX."mapsolarsystems.solarSystemID
                    AND    ".TBL_PREFIX."mapsolarsystems.regionID = ".TBL_PREFIX."mapregions.regionID
                    AND    ".TBL_PREFIX."mapsolarsystems.regionID = '".$args['regionID']."'" . $where2;
        } elseif (isset($args['ownerID'])) {
            $sql = "SELECT * FROM `".TBL_PREFIX."tower_info` WHERE 1=1" . $where2;
        } else {
            $sql = "SELECT * FROM `".TBL_PREFIX."tower_info`";
        }

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $rows = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;
    }

    /**
     * POSMGMT::GetTowerTypeID()
     *
     * @param mixed $args
     * @return
     */
    function GetTowerTypeID($args)
    {

        if (!isset($args['pos_race']) || !isset($args['pos_size'])) {
            Eve::SessionSetVar('errormsg', 'Missing Information');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."tower_static
                WHERE  pos_race = '".Eve::VarPrepForStore($args['pos_race'])."'
                AND    pos_size = '".Eve::VarPrepForStore($args['pos_size'])."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Failed to get Static Tower Info: '.$dbconn->ErrorMsg());
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row;
    }

    /**
     * POSMGMT::GetTowerType()
     *
     * @param mixed $typeID
     * @return
     */
    function GetTowerType($typeID)
    {

        if (!isset($typeID) && is_numeric($typeID)) {
            Eve::SessionSetVar('errormsg', 'Missing Information');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."tower_static
                WHERE  typeID = '".Eve::VarPrepForStore($typeID)."';";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Failed to get Static Tower Info: '.$dbconn->ErrorMsg());
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row;
    }

    /**
     * POSMGMT::AddNewPOS()
     *
     * @param mixed $args
     * @return
     */
    function AddNewPOS($args = array())
    {

        if (!$args) {
            return false;
        }

        $pos_size         = Eve::VarPrepForStore($args['pos_size']);
        $corp             = Eve::VarPrepForStore($args['corp']);
        $allianceid       = Eve::VarPrepForStore($args['allianceid']);
        $typeID           = Eve::VarPrepForStore($args['typeID']);
        $pos_race         = Eve::VarPrepForStore($args['pos_race']);
        $pos_size         = Eve::VarPrepForStore($args['pos_size']);
        $system           = Eve::VarPrepForStore($args['system']);
        //$sovereignity     = Eve::VarPrepForStore($args['sovereignity']);
        $fuelblock          = Eve::VarPrepForStore($args['fuelblock']);
        $charters           = Eve::VarPrepForStore($args['charters']);
        $strontium        = Eve::VarPrepForStore($args['strontium']);
        $struct_amount    = Eve::VarPrepForStore($args['struct_amount']);
        $owner_id         = Eve::VarPrepForStore($args['owner_id']);
        $pos_status       = Eve::VarPrepForStore($args['pos_status']);
        $systemID         = Eve::VarPrepForStore($args['systemID']);
        $moonID           = Eve::VarPrepForStore($args['moonID']);
        $towerName        = Eve::VarPrepForStore($args['towerName']);

        $security=$this->getSystemSecurity($systemID);
        if($security>=0.45)
        {
            $charters_needed=1;
        }
        else
        {
            $charters_needed=0;
        }
        $dbconn =& DBGetConn(true);

        //$nextId = $dbconn->GenId(TBL_PREFIX.'tower_info');

        $sql = "INSERT INTO ".TBL_PREFIX."tower_info (typeID,
                                             evetowerID,
                                             corp,
                                             allianceid,
                                             pos_size,
                                             pos_race,
                                             fuelblock,
                                             charters,
                                             strontium,
                                             towerName,
                                             systemID,
                                             charters_needed,
                                             status,
                                             owner_id,
                                             secondary_owner_id,
                                             pos_status,
                                             pos_comment,
                                             secret_pos,
                                             moonID,
                                             onlineSince)
                VALUES                      ('" . $typeID           . "',
                                             '0',
                                             '" . $corp             . "',
                                             '" . $allianceid       . "',
                                             '" . $pos_size         . "',
                                             '" . $pos_race         . "',
                                             '" . $fuelblock          . "',
                                             '" . $charters          . "',
                                             '" . $strontium        . "',
                                             '" . $towerName        . "',
                                             '" . $systemID         . "',
                                             '" . $charters_needed  . "',
                                             '0',
                                             '0',
                                             '0',
                                             '".  $pos_status       ."',
                                             '',
                                             '0',
                                             '".  $moonID           ."',
                                             NOW())";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Add POS: ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $pos_id = $dbconn->PO_Insert_ID(TBL_PREFIX.'tower_info', 'pos_id');

        $time = time();
        $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '', '" . $pos_id . "', '1', 'Add POS', '" . $time . "')";
        $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Add POS: ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return $pos_id;
    }

    /**
     * POSMGMT::GetAllStaticStructures()
     *
     * @return
     */
    function GetAllStaticStructures()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM structure_static order by name";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $rows = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;
    }

    /**
     * POSMGMT::GetAllStaticStructures()
     *
     * @return
     */
    function getStructureName($typeID)
    {
        if(is_numeric($typeID)) {

            $dbconn =& DBGetConn(true);

            $sql = "SELECT `name` FROM `".TBL_PREFIX."structure_static` WHERE `id`=".$typeID." LIMIT 1";

            $result = $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }

            $rows = $result->GetRowAssoc(2);

            $result->Close();
            (string) $typeName=$rows['name'];

            return $typeName;
        } else {
            return "unknown";
        }
    }

    //v2
    /**
     * POSMGMT::GetAllStaticStructures2()
     *
     * @return
     */
    function GetAllStaticStructures2()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM ".TBL_PREFIX."structure_static order by name";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $rows = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;
    }

    /**
     * POSMGMT::AddNewStructures()
     *
     * @param mixed $args
     * @return
     */
    function AddNewStructures($args)
    {
        if (!isset($args['pos_id'])) {
            Eve::SessionSetVar('errormsg', 'No POS ID!');
            return false;
        }

        $pos_id     = $args['pos_id'];
        $structures = $args['structures'];

        $dbconn =& DBGetConn(true);

        foreach ($structures as $sid => $scount) {

            //$nextId = $dbconn->GenId('pos_structures');

            $sql = "INSERT INTO pos_structures (pos_id,
                                                type_id,
                                                online)
                    VALUES                     ('".Eve::VarPrepForStore($pos_id)."',
                                                '".Eve::VarPrepForStore($sid)."',
                                                '1')";
            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }

        return true;
    }

    /**
     * POSMGMT::AddNewStructuresOld()
     *
     * @param mixed $args
     * @return
     */
    function AddNewStructuresOld($args)
    {
        if (!isset($args['pos_id'])) {
            Eve::SessionSetVar('errormsg', 'No POS ID!');
            return false;
        }

        $pos_id     = $args['pos_id'];
        $structures = $args['structures'];

        $dbconn =& DBGetConn(true);

        foreach ($structures as $sid => $scount) {

            //$nextId = $dbconn->GenId('pos_structures');

            $sql = "INSERT INTO pos_structures (pos_id,
                                                type_id,
                                                online)
                    VALUES                     ('".Eve::VarPrepForStore($pos_id)."',
                                                '".Eve::VarPrepForStore($sid)."',
                                                '1')";
            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }

        return true;
    }

    /**
     * POSMGMT::UpdatePosStatus()
     *
     * @param mixed $id
     * @param mixed $result_online
     * @return
     */
    function UpdatePosStatus($id, $result_online)
    {

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE pos_info SET status = '".Eve::VarPrepForStore($result_online)."' WHERE pos_id = '".Eve::VarPrepForStore($id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::GetInstalledRegions()
     *
     * @return
     */
    function GetInstalledRegions()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM ".TBL_PREFIX."moonsinstalled WHERE installed = '1' ORDER BY regionName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext())   {
            $region = $result->GetRowAssoc(2);
            $regions[$region['regionID']] = array('regionName' => $region['regionName']);
        }

        $result->Close();

        return $regions;

    }

    /**
     * POSMGMT::GetConstellationInfo()
     *
     * @param integer $regionID
     * @return
     */
    function GetConstellationInfo($regionID = 0)
    {

        if (!$regionID) {
            Eve::SessionSetVar('errormsg', 'No Region ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."mapconstellations
                WHERE    regionID = '" . Eve::VarPrepForStore($regionID) . "'
                ORDER BY constellationName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext())   {
            $const = $result->GetRowAssoc(2);
            $consts[$const['constellationID']] = array('constellationName' => $const['constellationName'], 'regionID' => $regionID);
        }

        $result->Close();

        return $consts;

    }

    /**
     * POSMGMT::GetSystemFromConst()
     *
     * @param integer $constellationID
     * @return
     */
    function GetSystemFromConst($constellationID = 0)
    {

        if (!$constellationID) {
            Eve::SessionSetVar('errormsg', 'No constellationID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT    *
                FROM      ".TBL_PREFIX."mapsolarsystems
                WHERE     constellationID = '" . Eve::VarPrepForStore($constellationID) . "'
                ORDER BY  solarSystemName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext())   {
            $system = $result->GetRowAssoc(2);
            $systems[$system['solarSystemID']] = $system;
        }

        $result->Close();

        return $systems;

    }

    /**
     * POSMGMT::GetMoonsFromSystem()
     *
     * @param integer $systemID
     * @return
     */
    function GetMoonsFromSystem($systemID = 0)
    {

        if (!$systemID) {
            Eve::SessionSetVar('errormsg', 'No constellationID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT    *
                FROM      ".TBL_PREFIX."evemoons
                WHERE     systemID = '" . Eve::VarPrepForStore($systemID) . "'
                ORDER BY  moonName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext())   {
            $moon = $result->GetRowAssoc(2);
            $moons[$moon['moonID']] = $moon;
        }

        $result->Close();

        return $moons;

    }

    /**
     * POSMGMT::GetAllRegions()
     *
     * @return
     */
    function GetAllRegions()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM ".TBL_PREFIX."moonsinstalled ORDER BY regionName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext())   {
            $region = $result->GetRowAssoc(2);
            $regions[$region['regionID']] = $region;//array('regionName' => $region['regionName']);
            /*
            $regions[$region['regionID']] = array('regionName' => $region['regionName'],
                                                  'regionID'   => $region['regionID'],
                                                  'file_name'  => $region['file_name'],
                                                  'mooncount'  => $region['mooncount'],
                                                  'installed'  => $region['installed']);
            */
        }

        $result->Close();

        return $regions;

    }

    /**
     * POSMGMT::getSystemName()
     *
     * @param mixed $systemID
     * @return
     */
    function getSystemName($systemID)
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."system_status
                WHERE  solarSystemID = '" . Eve::VarPrepForStore($systemID) . "' LIMIT 1 ";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $system = $result->GetRowAssoc(2);

        $result->Close();

        return $system['solarSystemName'];
    }

    /**
     * POSMGMT::getSystemSecurity()
     *
     * @param mixed $systemID
     * @return
     */
    function getSystemSecurity($systemID)
    {

        $dbconn =& DBGetConn(true);
        $sql = "SELECT *
                FROM `".TBL_PREFIX."mapsolarsystems`
                WHERE `solarSystemID`='" . Eve::VarPrepForStore($systemID) . "' LIMIT 1;";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $system = $result->GetRowAssoc(2);

        $result->Close();

        return $system['security'];
    }

    /**
     * POSMGMT::GetConstellationsWithPos()
     *
     * @return
     */
    function GetConstellationsWithPos()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT DISTINCT ".TBL_PREFIX."mapconstellations.constellationID,
                                ".TBL_PREFIX."mapconstellations.constellationName
                FROM  ".TBL_PREFIX."mapconstellations,
                      ".TBL_PREFIX."mapsolarsystems,
                      ".TBL_PREFIX."tower_info
                WHERE ".TBL_PREFIX."mapsolarsystems.solarSystemID = ".TBL_PREFIX."tower_info.systemID
                AND   ".TBL_PREFIX."mapsolarsystems.constellationID = ".TBL_PREFIX."mapconstellations.constellationID
                ORDER BY constellationName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $constellations[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $constellations;

    }

    /**
     * POSMGMT::GetSystemsWithPos()
     *
     * @return
     */
    function GetSystemsWithPos()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT DISTINCT solarSystemID,
                                solarSystemName
                FROM  ".TBL_PREFIX."mapsolarsystems,
                      ".TBL_PREFIX."tower_info
                WHERE ".TBL_PREFIX."mapsolarsystems.solarSystemID = ".TBL_PREFIX."tower_info.systemID
                ORDER BY solarSystemName";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $systems[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $systems;

    }

	/**
     * POSMGMT::GetAllIndustrialJobs()
     *
     * @return
     */
    function GetAllIndustrialJobs($completed,$ignore)
    {
		if ($ignore == 1) {
		$notlike = '110,1013'; //Titans & SuperCarriers
		} elseif ($ignore == 2) {
		$notlike = '110,1013,643,537,945,944,525'; //All Capitals
		} elseif ($ignore == 3) {
		$notlike = '110,1013,643,537,945,944,525,489,107,106,487,105,503,108,996,477,111,954,955,956,957,958,973'; //All Ships
		} else {
		$notlike = '0';
		} 
        $dbconn =& DBGetConn(true);

        $sql = "SELECT t1.jobID,t1.runs,t1.completed,t1.activityID,t1.installedItemMaterialLevel,t1.installedItemProductivityLevel,t1.installedItemCopy,t1.installTime,t1.endProductionTime,t1.licensedProductionRuns,
		t2i.typeName as installedItemTypeID,t2o.typeName AS outputTypeID,t2c.typeName AS containerTypeID,t3n.name AS installerID, t2g.groupID FROM ".TBL_PREFIX."jobs t1
		LEFT JOIN ".TBL_PREFIX."invTypes t2i ON t1.installedItemTypeID = t2i.typeID
		LEFT JOIN ".TBL_PREFIX."invTypes t2o ON t1.outputTypeID =  t2o.typeID  
		LEFT JOIN ".TBL_PREFIX."invTypes t2c ON t1.containerTypeID =  t2c.typeID
		LEFT JOIN ".TBL_PREFIX."user t3n ON t1.installerID =  t3n.eve_id
		INNER JOIN ".TBL_PREFIX."invTypes t2g ON t2g.typeID = t1.installedItemTypeID
                WHERE t2g.groupID NOT IN (" . Eve::VarPrepForStore($notlike) . ")
				AND completed='" . Eve::VarPrepForStore($completed) . "'
                ORDER BY jobID";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $jobs[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $jobs;

    }
	
		/**
     * POSMGMT::GetAllJobUsers()
     *
     * @return
     */
    function GetAllJobUsers()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT eve_id, name FROM ".TBL_PREFIX."user ORDER BY eve_id";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

		$userList = $result->GetAssoc();
        $result->Close();

        return $userList;

    }
	
	/**
     * POSMGMT::GetAllStaticItems()
     *
     * @return
     */
    function GetAllStaticItems()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT DISTINCT typeID, typeName FROM ".TBL_PREFIX."invTypes WHERE typeName LIKE '%Blueprint%' OR marketGroupID IS NOT NULL ORDER BY typeID";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $itemDB = $result->GetAssoc();
        $result->Close();

        return $itemDB;
		
    }
	
    /**
     * POSMGMT::separate()
     *
     * @param mixed $number
     * @return
     */
    function separate($number)
    {
        $result =  number_format($number, 0, '.', ',');
        return $result;
    }

    /**
     * POSMGMT::my_escape()
     *
     * @param mixed $string
     * @return
     */
    function my_escape($string)
    {
        return mysql_real_escape_string($string);
    }

    /**
     * POSMGMT::getSovStatus()
     *
     * @param mixed $systemID
     * @return
     */
    function getSovStatus($systemID)
    {
        $dbconn =& DBGetConn(true);

        //This function gets the the sovereignty status of a system from database
        $sql = "SELECT * FROM `".TBL_PREFIX."system_status` WHERE `solarSystemID` = '" . Eve::VarPrepForStore($systemID) . "' LIMIT 1";

        $result = $dbconn->Execute($sql);

        $row = $result->GetRowAssoc(2);

        $result->Close();

        //if($row['constellationSovereignty'] > 0) {
//            return 5;
//        } else {
            if($row['sovereigntyLevel'] > 0) {
                return $row['sovereigntyLevel'];
            } else {
                return 0;
            }
       // }
    }

    /**
     * POSMGMT::getSovereignty()
     *
     * @param mixed $systemID
     * @return
     */
    function getSovereignty($systemID)
    {
        $dbconn =& DBGetConn(true);

        //fetch solarsystem information from database
            $sql = "SELECT * FROM `".TBL_PREFIX."system_status` WHERE solarSystemID ='".Eve::VarPrepForStore($systemID)."' LIMIT 1";
            $result = $dbconn->Execute($sql);

            $row = $result->GetRowAssoc(2);

            $result->Close();

            //See if alliance/corporation are set and return true
            if($row['allianceID']!=0 || $row['corporationID']!=0) {
                return true;
            } else {
                return false;
            }
    }

    function getSovereigntyStatus($systemID=0, $allianceID=0)
    {
    //open database connection
        $dbconn =& DBGetConn(true);

        //check to see if we are even dealing with an alliance
        if($allianceID!=0) {
            //fetch solarsystem information from database
            $sql = "SELECT * FROM `".TBL_PREFIX."system_status` WHERE solarSystemID ='".Eve::VarPrepForStore($systemID)."' LIMIT 1";
            $result = $dbconn->Execute($sql);

            $row = $result->GetRowAssoc(2);

            $result->Close();
            //check if alliance matches database
            if ($row['allianceID'] == $allianceID)  {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        return false;
    }

    /**
     * POSMGMT::getSovereigntyLevel()
     *
     * @param mixed $systemID
     * @return
     * @deprecated Domination Obsolete
     */
    function getSovereigntyLevel($systemID)
    {
        $dbconn =& DBGetConn(true);

        //This function gets the the sovereignty status of a system from database
        $sql = "SELECT * FROM `".TBL_PREFIX."system_status` WHERE `solarSystemID` = '" . Eve::VarPrepForStore($systemID) . "' LIMIT 1";

        $result = $dbconn->Execute($sql);

        $row = $result->GetRowAssoc(2);

        $result->Close();

       // if($row['constellationSovereignty'] > 0) {
            //return array('sovereigntyLevel' => 5, 'allianceID' => $row['allianceID']);
            //return 5;
        //} else {
            return array('sovereigntyLevel' => (($row['sovereigntyLevel'] > 0) ? $row['sovereigntyLevel'] : 0), 'allianceID' => $row['allianceID']);
            //if($row['sovereigntyLevel'] > 0) {
            //    return $row['sovereigntyLevel'];
            //} else {
            //    return 0;
            //}
       // }
    }

    /**
     * POSMGMT::selectstaticdb()
     *
     * @param mixed $sovereignty
     * @param mixed $systemID
     * @param integer $allianceID
     * @return
     */
    function selectstaticdb($systemID, $allianceID=0)
    {
        //open database connection
        $dbconn =& DBGetConn(true);

        //check to see if we are even dealing with an alliance
        if($allianceID!=0) {
            //fetch solarsystem information from database
            $sql = "SELECT * FROM `".TBL_PREFIX."system_status` WHERE solarSystemID ='".Eve::VarPrepForStore($systemID)."' LIMIT 1";
            $result = $dbconn->Execute($sql);

            $row = $result->GetRowAssoc(2);

            $result->Close();
            //check if alliance matches database
            if ($row['allianceID'] == $allianceID)  {
                return $db = TBL_PREFIX.'sovereignty_static';
            } else {
                return $db = TBL_PREFIX.'tower_static';
            }
        } else {
            return $db = TBL_PREFIX.'tower_static';
        }
        return $db;
    }

    /**
     * POSMGMT::uptimecalc()
     *
     * @param mixed $pos_id
     * @return
     */
    function uptimecalc($pos_id)
    {

        if (!$pos_id || !is_numeric($pos_id)) {
            Eve::SessionSetVar('errormsg', 'Error UptimeCalc');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."tower_info
                WHERE  pos_id = '" . Eve::VarPrepForStore($pos_id) . "'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            Eve::SessionSetVar('errormsg', 'Error retrieving from tower_info in function uptimecalc;');
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        if ($row) {

			$current_fuelblock         = $row['fuelblock'];
            $current_strontium       = $row['strontium'];
            $current_charters        = $row['charters'];
            $pos_size                = $row['pos_size'];
            $pos_race                = $row['pos_race'];
            $charters_needed         = $row['charters_needed'];
            $systemID                = $row['systemID'];
            $allianceID              = $row['allianceid'];
            $tower_cpu               = $row['cpu'];
            $tower_pg                = $row['powergrid'];

			$sovfriendly = $this->getSovereigntyStatus($systemID, $allianceID);
			if ($sovfriendly == 1) {
				$hasSov = .75;
			} else {
				$hasSov = 1;
			}

        }
		$row2 = $this->GetStaticFBTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size));
		
        if ($row2) {
			$required_fuelblock          = ceil($row2['fuelblock'] * $hasSov);
            $required_strontium         = ceil($row2['strontium'] * $hasSov);;
            $required_charters          = $charters_needed?1:0;
            $race_isotope               = $row2['race_isotope'];
            $total_pg                   = $row2['pg'];
            $total_cpu                  = $row2['cpu'];
        }

        $sql = "SELECT * FROM ".TBL_PREFIX."pos_structures ps JOIN ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id WHERE ps.pos_id = '" . Eve::VarPrepForStore($pos_id) . "' AND ps.online=1";

        $result = $dbconn->Execute($sql);

        if (!$result->EOF) {
            $current_pg   = 0;
            $current_cpu  = 0;
            for(; !$result->EOF; $result->MoveNext()) {
                $row3 = $result->GetRowAssoc(2);
                $current_pg  = $current_pg + $row3['pg'];
                $current_cpu = $current_cpu + $row3['cpu'];
            }
        } else {
            $current_pg = 0;
            $current_cpu = 0;
        }
        if($current_cpu<=0 && $tower_cpu>0) {
            $current_cpu=$tower_cpu;
        }
        if($current_pg<=0 && $tower_pg>0) {
            $current_pg=$tower_pg;
        }

        $hoursago = $this->hoursago($pos_id, '1');
		
		$calc_fuelblock = (round($current_fuelblock / $required_fuelblock)) - $hoursago;

        if ($required_charters) {
            $calc_charters = (round($current_charters / $required_charters)) - $hoursago;
        } else {
            $calc_charters = 0;
        }

        $calc_strontium = floor($current_strontium / $required_strontium);
		$calc_fuelblock        = (($calc_fuelblock           <= 0) ? 0 : $calc_fuelblock);
        $calc_charters         = (($calc_charters          <= 0) ? 0 : $calc_charters);

		$uptimecalc['strontium'] = $calc_strontium;
		$uptimecalc['fuelblock'] = $calc_fuelblock;
        if ($charters_needed) {
            $uptimecalc['charters'] = $calc_charters;
        } else {
            $uptimecalc['charters'] = false;
        }

        return $uptimecalc;
    }


    /**
     * POSMGMT::daycalc()
     *
     * @param mixed $hours
     * @return
     */
    function daycalc($hours)
    {
        if ($hours >= "24") {
            $d = floor($hours / 24);
            $h = ($hours - ($d * 24));
            $daycalc = $d . "d " . $h . "h";
            } else {
            $h = $hours;
            $daycalc = $h . "h";
        }
        return $daycalc;
    }

    /**
     * POSMGMT::online()
     *
     * @param mixed $fuel
     * @return
     */
    function online($fuel)
    {
        if (count($fuel) != 0) {
			$fuelblock          = $fuel['fuelblock'];
            $charters         = $fuel['charters'];
            $strontium        = $fuel['strontium'];

            $fuel_array = array($fuelblock);

            if ($charters !== false) {
                $fuel_array[] = $charters;
            }
            array_multisort($fuel_array);
            $online = $fuel_array[0];

            return $online;
        }
    }

    /**
     * POSMGMT::last_fuel_update()
     *
     * @param mixed $pos_id
     * @return
     */
    function last_fuel_update($pos_id)
    {
        $sql = "SELECT * FROM update_log WHERE pos_id = '" . $pos_id . "' AND action = 'Update Fuel' ORDER BY id DESC LIMIT 1";
        $result = mysql_query($sql)
          or die('Could not select from update_log; ' . mysql_error());
        $row = mysql_fetch_array($result);
        $updated = $row['datetime'];
        return $updated;
    }

    /**
     * POSMGMT::hoursago()
     *
     * @param mixed $id
     * @param mixed $type
     * @return
     */
    function hoursago($id, $type)
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."update_log
                WHERE    type_id = '" . Eve::VarPrepForStore($id)   . "'
                AND      type    = '" . Eve::VarPrepForStore($type) . "'
                ORDER BY id DESC LIMIT 1";

        $result = $dbconn->Execute($sql); //$result = mysql_query($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);//$row = mysql_fetch_array($result);
        $last_update = $row['datetime'] / 3600;
        $current_time = time() / 3600;
        $hoursago = $current_time - $last_update;
        $hoursago = floor($hoursago);
        return $hoursago;
    }

    // Works out time left on a silo assigned to mining/producing
    /**
     * POSMGMT::prod_producing()
     *
     * @param mixed $timestamp
     * @param mixed $amount
     * @param mixed $produced
     * @param mixed $m3
     * @param mixed $struc_id
     * @param mixed $pos_race
     * @return
     */
    function prod_producing($timestamp, $amount, $produced, $m3, $struc_id, $pos_race)
    {
        // Assign Constants
        if($pos_race == "3") {
            $silo_capacity = 40000;
        } else {
            $silo_capacity = 20000;
        }
        $update         = $timestamp;
        $amount_entered = $amount;
        $production_hr  = $produced;
        $m3             = $m3; //????
        $structure_id   = $struc_id;

        // Get hours difference
        $update_hours = $update / 3600;
        $current_time = time() / 3600;
        $hoursago = floor($current_time - $update_hours);
        // Calculate silo amounts
        $in_silo = $amount_entered;
        // Add amount as time passed
        $in_silo = $in_silo + ($hoursago * $produced);
        // Calc Silo M3 amount
        $in_silo_m3 = $in_silo * $m3;
        // Calc Remaining M3 amount
        $rem_silo = $silo_capacity - $in_silo_m3;
        // Hours till full
        $rem_hours = $rem_silo / ($produced * $m3);

        $sql = "UPDATE pos_structures SET status=\"" . $rem_hours ."\" WHERE id='" .$structure_id . "'" ;
        $result = mysql_query($sql) or die('Could not insert values into pos_info; ' . mysql_error());
    }

    // Works out time left on a silo assigned to using
    /**
     * POSMGMT::prod_using()
     *
     * @param mixed $timestamp
     * @param mixed $amount
     * @param mixed $used
     * @param mixed $m3
     * @param mixed $struc_id
     * @param mixed $pos_race
     * @return
     */
    function prod_using($timestamp, $amount, $used, $m3, $struc_id, $pos_race)
    {
        // Assign Constants
        if($pos_race == "3") {
            $silo_capacity = 40000;
        } else {
            $silo_capacity = 20000;
        }
        $update = $timestamp;
        $amount_entered = $amount;
        $used_hr = $used;
        $m3 = $m3;
        $structure_id = $struc_id;

        // Get hours difference
        $update_hours = $update / 3600;
        $current_time = time() / 3600;
        $hoursago = floor($current_time - $update_hours);
        // Calculate silo amounts
        $in_silo = $amount_entered;
        // Add amount as time passed
        $in_silo2 = $in_silo - ($hoursago * $used_hr);
        // Hours till empty
        $rem_hours = $in_silo2 / ($used_hr);

        $sql = "UPDATE pos_structures SET status=\"" . $rem_hours ."\" WHERE id='" .$structure_id . "'" ;
        $result = mysql_query($sql) or die('Could not insert values into pos_info; ' . mysql_error());
    }

    /**
     * POSMGMT::GetTowerInfo()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetTowerInfo($pos_id)
    {

        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *,
                      (SELECT ".TBL_PREFIX."evemoons.moonName
                       FROM   ".TBL_PREFIX."evemoons
                       WHERE  ".TBL_PREFIX."tower_info.moonID = ".TBL_PREFIX."evemoons.moonID) AS 'moonName'
                FROM   ".TBL_PREFIX."tower_info
                WHERE  pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $towerinfo = $result->GetRowAssoc(2);

        $result->Close();

        return $towerinfo;

    }

    /**
     * POSMGMT::ChangeTowerInfo()
     *
     * @param mixed $args
     * @return
     */
    function ChangeTowerInfo($args)
    {

        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }
        $pos_id     = Eve::VarPrepForStore($args['pos_id']);
        $pos_status = Eve::VarPrepForStore($args['newstatus']);
        $towerName  = Eve::VarPrepForStore($args['new_tower_name']);
        $outpost    = Eve::varPrepForStore($args['new_outpost']);
        $new_pg     = Eve::varPrepForStore($args['new_pg']);
        $new_cpu    = Eve::varPrepForStore($args['new_cpu']);
        /*
        $tower      = $this->GetTowerInfo($pos_id);
        $lastupdate = $this->GetLastPosUpdate($pos_id);
        */
        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."tower_info
                SET    pos_status   = '".$pos_status."',
                       towerName    = '".$towerName."',
                       outpost_id = '".$outpost."',
                       cpu='".$new_cpu."',
                       powergrid='".$new_pg."'
                WHERE  pos_id       = '".$pos_id."'";
        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }
	
	/**
     * POSMGMT::ChangeTowerCPUPG()
     *
     * @param mixed $args
     * @return
     */
    function ChangeTowerCPUPG($args)
    {

        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }
        $pos_id     = Eve::VarPrepForStore($args['pos_id']);
        $new_pg     = Eve::varPrepForStore($args['new_pg']);
        $new_cpu    = Eve::varPrepForStore($args['new_cpu']);
        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."tower_info
                SET  cpu='".$new_cpu."',
                       powergrid='".$new_pg."'
                WHERE  pos_id       = '".$pos_id."'";
        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }
	
	/**
     * POSMGMT::ChangeTowerSecret()
     *
     * @param mixed $args
     * @return
     */
	function ChangeTowerSecret($args)
    {

        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }
        $pos_id     = Eve::VarPrepForStore($args['pos_id']);
        $new_secret = Eve::VarPrepForStore($args['new_secret']);
     
        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."tower_info
                SET    secret_pos   = '".$new_secret."'
				WHERE  pos_id       = '".$pos_id."'";
        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }
	
    /**
     * POSMGMT::updateOwner()
     *
     * @param mixed $args
     * @param bool $backup
     * @return
     */
    function updateOwner($args, $backup=false)
    {
        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }
        if (!$args['newowner_id'] || !is_numeric($args['newowner_id'])) {
            return false;
        }
        $dbconn =& DBGetConn(true);
        if($backup) {
            $sql = "UPDATE `".TBL_PREFIX."tower_info` SET `secondary_owner_id` = '".$args['newowner_id']."' WHERE `pos_id` = ".$args['pos_id']."    LIMIT 1;";
        } else {
            $sql = "UPDATE `".TBL_PREFIX."tower_info` SET `owner_id` = '".$args['newowner_id']."' WHERE `pos_id` = ".$args['pos_id']."    LIMIT 1;";
        }
        $dbconn->Execute($sql);
    }

    /**
     * POSMGMT::UpdatePosFuel()
     *
     * @param mixed $args
     * @return
     */
    function UpdatePosFuel($args)
    {

        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }

        $fuel = array();

        foreach($args as $key => $value) {
            $fuel[$key] = Eve::VarPrepForStore($value);
        }

        /*
        $tower      = $this->GetTowerInfo($pos_id);
        $lastupdate = $this->GetLastPosUpdate($pos_id);
        */
        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."tower_info
                SET  fuelblock          = '".$fuel['fuelblock']."',
                       charters         = '".$fuel['charters']."',
                       strontium        = '".$fuel['strontium']."',
					   status        = '".$fuel['status']."'
                WHERE  pos_id           = '".$fuel['pos_id']."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $time = time();
        $sql = "INSERT INTO ".TBL_PREFIX."update_log (
                                        eve_id,
                                        type_id,
                                        type,
                                        action,
                                        datetime)
                VALUES                 (0,
                                        '" . $fuel['pos_id'] . "',
                                        '1',
                                        'Update Fuel',
                                        '" . Eve::VarPrepForStore($time) . "')";
        $dbconn->Execute($sql);
        //$this->UpdatePOSLog($pos_id);
        //$this->GetLastPosUpdate($fuel['pos_id']);

        return true;

    }

    /**
     * POSMGMT::UpdatePosModState()
     *
     * @param mixed $args
     * @return
     */
    function UpdatePosModState($args)
    {
//echo '<pre>';print_r($args);echo '</pre>';exit;
        if (!isset($args['mod_id']) || !is_numeric($args['mod_id'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        if (!isset($args['mod_id']) || !is_numeric($args['mod_id'])) {
            return false;
        }

        $sql = "UPDATE ".TBL_PREFIX."pos_structures
                SET    online  = '".Eve::VarPrepForStore($args['state'])."'
                WHERE  id      = '".Eve::VarPrepForStore($args['mod_id'])."'
                AND    pos_id  = '".Eve::VarPrepForStore($args['pos_id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }

    /**
     * POSMGMT::GetModInfoFromPos()
     *
     * @param mixed $args
     * @return
     */
    function GetModInfoFromPos($args)
    {
        if (!isset($args['pos_id']) || !is_numeric($args['pos_id'])) {
            return false;
        }
        if (!isset($args['mod_id']) || !is_numeric($args['mod_id'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."pos_structures ps
                JOIN   ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id
                WHERE  ps.pos_id = '".Eve::VarPrepForStore($args['pos_id'])."'
                AND    ps.id     = '".Eve::VarPrepForStore($args['mod_id'])."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $structure = $result->GetRowAssoc(2);

//echo '<pre>';print_r($structure);echo '</pre>';exit;
        $result->Close();

        return $structure;

    }

    /**
     * POSMGMT::DeleteModule()
     *
     * @param mixed $args
     * @return
     */
    function DeleteModule($args)
    {

        if (!isset($args['pos_id']) || !is_numeric($args['pos_id'])) {
            return false;
        }
        if (!isset($args['mod_id']) || !is_numeric($args['mod_id'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $module = $this->GetModInfoFromPos($args);
		
        if (!$module) {
            Eve::SessionSetVar('errormsg', 'Unknown Module');
            return false;
        }

        $sql = "DELETE FROM ".TBL_PREFIX."pos_structures
                WHERE       id     = '".Eve::VarPrepForStore($args['mod_id'])."'
                AND         pos_id = '".Eve::VarPrepForStore($args['pos_id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($module['type_id'] == 16221 || $module['type_id'] == 16869 || $module['type_id'] == 20175 || $module['type_id'] == 22634 || $module['type_id'] == 24684) {
            // Reactor
            $sql = "DELETE FROM ".TBL_PREFIX."reactor_info
                    WHERE       structure_id = '".Eve::VarPrepForStore($args['mod_id'])."'
                    AND         pos_id       = '".Eve::VarPrepForStore($args['pos_id'])."'";
            $dbconn->Execute($sql);
        } elseif ($module['type_id'] == 14343 || $module['type_id'] == 25270 || $module['type_id'] == 25271 || $module['type_id'] == 25280) {
            // Silo
            $sql = "DELETE FROM ".TBL_PREFIX."silo_info
                    WHERE       silo_id = '".Eve::VarPrepForStore($args['mod_id'])."'
                    AND         pos_id  = '".Eve::VarPrepForStore($args['pos_id'])."'";
            $dbconn->Execute($sql);
        } elseif ($module['type_id'] == 17621) {
            // Hangar
            $sql = "DELETE FROM ".TBL_PREFIX."pos_hanger
                    WHERE       hanger_id = '".Eve::VarPrepForStore($args['mod_id'])."'
                    AND         pos_id    = '".Eve::VarPrepForStore($args['pos_id'])."'";
            $dbconn->Execute($sql);
        }

        return true;

    }

    /**
     * POSMGMT::UpdateAllPosModsState()
     *
     * @param mixed $args
     * @return
     */
    function UpdateAllPosModsState($args)
    {
		$userinfo = $this->GetUserInfo();
		
        if (!$args['pos_id'] || !is_numeric($args['pos_id'])) {
            return false;
        }

        foreach($args['mods'] as $mod_id => $state) {
            if ($state == 100) {
                if (!$this->DeleteModule(array('pos_id' => $args['pos_id'], 'mod_id' => $mod_id))) {
                    return false;
                }
            } else {
                if (!$this->UpdatePosModState(array('pos_id' => $args['pos_id'], 'mod_id' => $mod_id, 'state' => $state))) {
                    return false;
                }
            }
        }
		
		$time = time();
        $dbconn =& DBGetConn(true);
		$sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '" . $userinfo['eve_id'] . "','" . $args['pos_id'] . "', '1', 'Modify Structures', '" . Eve::VarPrepForStore($time) . "')";
		
        $dbconn->Execute($sql);

			$mods = $this->GetAllPosMods($args['pos_id']);
			$mods_pg  = 0;
			$mods_cpu = 0;
			if ($mods) {
				foreach($mods as $row) {
					if ($row['online']) {
						$mods_pg  = $mods_pg  + $row['pg'];
						$mods_cpu = $mods_cpu + $row['cpu'];
					}
				}
			}
			$this->ChangeTowerCPUPG(array('pos_id' => $args['pos_id'], 'new_pg' => $mods_pg, 'new_cpu' => $mods_cpu));
		
        return true;

    }

    /**
     * POSMGMT::GetPosHangars()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetPosHangars($pos_id)
    {
        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT     ".TBL_PREFIX."pos_hanger.*,
                           ".TBL_PREFIX."pos_structures.online
                FROM       ".TBL_PREFIX."pos_hanger
                INNER JOIN ".TBL_PREFIX."pos_structures ON (".TBL_PREFIX."pos_hanger.hanger_id = ".TBL_PREFIX."pos_structures.id)
                WHERE      ".TBL_PREFIX."pos_structures.pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $hangars[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $hangars;

    }

    /**
     * POSMGMT::GetPosStructures()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetPosStructures($pos_id)
    {
        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM     ".TBL_PREFIX."pos_structures ps
                JOIN     ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id
                WHERE    ps.pos_id = '".Eve::VarPrepForStore($pos_id)."'
                AND      ps.online = '1'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $structures = array();
        for(; !$result->EOF; $result->MoveNext()) {
            $structures[] = $result->GetRowAssoc(2);
        }
//echo '<pre>';print_r($structures);echo '</pre>';exit;
        $result->Close();

        return $structures;

    }

    /**
     * POSMGMT::GetAllPosMods()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetAllPosMods($pos_id)
    {
        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *,
                         ps.id as mod_id,
                         ss.name
                FROM     ".TBL_PREFIX."pos_structures ps
                JOIN     ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id
                WHERE    ps.pos_id = '".Eve::VarPrepForStore($pos_id)."'
                ORDER BY ss.name ASC";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $structures = array();
        for(; !$result->EOF; $result->MoveNext()) {
            $structures[] = $result->GetRowAssoc(2);
        }
//echo '<pre>';print_r($structures);echo '</pre>';exit;
        $result->Close();

        return $structures;

    }

    /**
     * POSMGMT::GetConnectionLine()
     *
     * @param mixed $args
     * @return
     */
    function GetConnectionLine($args)
    {

        if ((!isset($args['id']) || empty($args['id'])) || (!isset($args['pos_id']) || empty($args['pos_id']))) {
            Eve::SessionSetVar('errormsg', 'No id!');
            return false;
        }

        if (!isset($args['type']) || empty($args['type'])) {
            $args['type'] = 1;
        }
//echo '<pre>';print_r($args);echo '</pre>';exit;
        $dbconn =& DBGetConn(true);

        if ($args['type'] == 1) {
            $sql = "SELECT *
                    FROM   ".TBL_PREFIX."harvestors
                    WHERE  h_id   = '".Eve::VarPrepForStore($args['id'])."'
                    AND    pos_id = '".Eve::VarPrepForStore($args['pos_id'])."'";
        } elseif ($args['type'] == 2) {
            $sql = "SELECT *
                    FROM   ".TBL_PREFIX."silos
                    WHERE  silo_id = '".Eve::VarPrepForStore($args['id'])."'
                    AND    pos_id  = '".Eve::VarPrepForStore($args['pos_id'])."'";
        } else {
            $sql = "SELECT *
                    FROM   ".TBL_PREFIX."reactors
                    WHERE  r_id   = '".Eve::VarPrepForStore($args['id'])."'
                    AND    pos_id = '".Eve::VarPrepForStore($args['pos_id'])."'";
        }

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $info = $result->GetRowAssoc(2);

        $result->Close();

        return $info;

    }

    /**
     * POSMGMT::addstructure()
     *
     * @param mixed $s_id
     * @param mixed $pos_id
     * @param mixed $online
     * @return
     */
    function addstructure($s_id, $pos_id, $online)
    {
        $userinfo = $this->GetUserInfo();
        $dbconn =& DBGetConn(true);
        $time=time();

        //$nextId = $dbconn->GenId(TBL_PREFIX.'pos_structures');



        $sql = "INSERT INTO ".TBL_PREFIX."pos_structures (pos_id,
                                            type_id,
                                            online)
                VALUES                     ('".Eve::VarPrepForStore($pos_id)."',
                                            '".Eve::VarPrepForStore($s_id)."',
                                            '1')";
        $dbconn->Execute($sql);

        $newId = $dbconn->PO_Insert_ID(TBL_PREFIX.'pos_structures', 'id');

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }
        if ($s_id == 17621) {
            $hangar_id =$newId;
            $sql = "INSERT INTO ".TBL_PREFIX."pos_hanger VALUES ('".Eve::VarPrepForStore($hangar_id)."','" . $pos_id . "','0','0','0','0','0','0','0','0','0','0')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
            $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '" .Eve::VarPrepForStore($userinfo['id']). "', '" . Eve::VarPrepForStore($hangar_id) . "', '3', 'Add Hanger', '" . $time . "')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }
        if ($s_id == 14343) {
            $silo_id =$newId;
            $sql = "INSERT INTO ".TBL_PREFIX."silo_info VALUES ('{$silo_id}','" . Eve::VarPrepForStore($pos_id) . "','14343','0','0','0','0','0','0')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
            $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '" . Eve::VarPrepForStore($userinfo['id']) . "', '" . Eve::VarPrepForStore($silo_id) . "', '2', 'Add Silo', '" . $time . "')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }
        if ($s_id == 16221 || $s_id==17170 || $s_id==20175 || $s_id==16869) {
            $structure_id =$newId;
            $sql = "INSERT INTO ".TBL_PREFIX."reactor_info VALUES ('{$structure_id}','" . Eve::VarPrepForStore($pos_id) . "','".$s_id."','0')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
            $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '" . Eve::VarPrepForStore($userinfo['id']) . "', '" . Eve::VarPrepForStore($silo_id) . "', '2', 'Add Harvester/Reactor', '" . $time . "')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }
        return true;
    }

    /**
     * POSMGMT::GetSiloInfo()
     *
     * @param mixed $silo_id
     * @return
     */
    function GetSiloInfo($silo_id)
    {

        if (!$silo_id || !is_numeric($silo_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."silo_info
                WHERE silo_id = '".Eve::VarPrepForStore($silo_id)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $silo = $result->GetRowAssoc(2);

        $result->Close();

        return $silo;

    }

    /**
     * POSMGMT::GetPosSilos()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetPosSilos($pos_id)
    {

        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."silo_info
                WHERE    pos_id = '".Eve::VarPrepForStore($pos_id)."'
                ORDER BY silo_id";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $silos[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $silos;

    }

    /**
     * POSMGMT::GetPosMiners()
     *
     * @param mixed $pos_id
     * @return
     */
    function GetPosMiners($pos_id)
    {

        if (!$pos_id || !is_numeric($pos_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."reactor_info
                WHERE pos_id = '".Eve::VarPrepForStore($pos_id)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $miners[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $miners;

    }

    /**
     * POSMGMT::GetSiloToLink()
     *
     * @param mixed $args
     * @return
     */
    function GetSiloToLink($args)
    {

        if (!isset($args['pos_id']) || !is_numeric($args['pos_id'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM  ".TBL_PREFIX."silo_info
                WHERE pos_id   = '".Eve::VarPrepForStore($args['pos_id'])."'
                AND   status   = '".Eve::VarPrepForStore($args['status'])."'
                AND   silo_id <> '".Eve::VarPrepForStore($args['current_silo_id'])."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $silos[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $silos;

    }

    /**
     * POSMGMT::UpdateAllPosSilos()
     *
     * @param mixed $args
     * @return
     */
    function UpdateAllPosSilos($args)
    {

        if (!isset($args['silos'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $time = time();

        foreach($args['silos'] as $silo) {
            $sql = "UPDATE ".TBL_PREFIX."silo_info
                    SET    material_id      = '" . Eve::VarPrepForStore($silo['material_id'])       ."',
                           material_ammount = '" . Eve::VarPrepForStore($silo['material_ammount'])  ."',
                           status           = '" . Eve::VarPrepForStore($silo['status'])            ."',
                           connection_id    = '" . Eve::VarPrepForStore($silo['connection_id'])     ."',
                           silo_link        = '" . Eve::VarPrepForStore($silo['silo_link'])         ."'
                    WHERE  silo_id          = '" . Eve::VarPrepForStore($silo['structure_id'])      ."'";

            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }

            $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '0', '" . Eve::VarPrepForStore($silo['structure_id']) . "', '2', 'Update Silo', '" . $time . "')";
            $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
                return false;
            }
        }
    }

    /**
     * POSMGMT::ChangeMinerMat()
     *
     * @param mixed $args
     * @return
     */
    function ChangeMinerMat($args)
    {
        if (!isset($args['structure_id']) || !is_numeric($args['structure_id'])) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."reactor_info
                SET    material_id  = '" . Eve::VarPrepForStore($args['material_id']) ."'
                WHERE  structure_id = '" . Eve::VarPrepForStore($args['structure_id'])."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }

    /**
     * POSMGMT::GetConnectedReator()
     *
     * @param mixed $silo_connection
     * @return
     */
    function GetConnectedReator($silo_connection)
    {

        if (!$silo_connection || !is_numeric($silo_connection)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."reactor_info
                WHERE structure_id = '".Eve::VarPrepForStore($silo_connection)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $reactor = $result->GetRowAssoc(2);

        $result->Close();

        return $reactor;

    }

    /**
     * POSMGMT::GetStaticTowerInfo()
     *
     * @param mixed $args
     * @return
     */
    function GetStaticTowerInfo($args)
    {

        if (!$args['db'] || !$args['pos_race'] || !$args['pos_size']) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   " . Eve::VarPrepForStore($args['db']) . "
                WHERE  pos_race = '" . Eve::VarPrepForStore($args['pos_race']) . "'
                AND    pos_size = '" . Eve::VarPrepForStore($args['pos_size']) . "'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $info = $result->GetRowAssoc(2);

        $result->Close();
//echo '<pre>';print_r($info);echo '</pre>';exit;
        return $info;

    }

	/**
     * POSMGMT::GetStaticFBTowerInfo()
     *
     * @param mixed $args
     * @return
     */
    function GetStaticFBTowerInfo($args)
    {

        if (!$args['pos_race'] || !$args['pos_size']) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."tower_fbstatic
                WHERE  pos_race = '" . Eve::VarPrepForStore($args['pos_race']) . "'
                AND    pos_size = '" . Eve::VarPrepForStore($args['pos_size']) . "'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $info = $result->GetRowAssoc(2);

        $result->Close();
        return $info;

    }
	
	
    /**
     * POSMGMT::GetStaticModInfo()
     *
     * @param mixed $structure_type
     * @return
     */
    function GetStaticModInfo($structure_type)
    {

        if (!$structure_type || !is_numeric($structure_type)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."structure_static
                WHERE id = '".Eve::VarPrepForStore($structure_type)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $info = $result->GetRowAssoc(2);

        $result->Close();

        return $info;

    }

    /**
     * POSMGMT::GetStaticMatInfo()
     *
     * @param mixed $material_id
     * @return
     */
    function GetStaticMatInfo($material_id)
    {

        if (!$material_id || !is_numeric($material_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM ".TBL_PREFIX."material_static
                WHERE material_id = '".Eve::VarPrepForStore($material_id)."'";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $info = $result->GetRowAssoc(2);

        $result->Close();

        return $info;

    }

    /**
     * POSMGMT::GetStaticMaterials()
     *
     * @return
     */
    function GetStaticMaterials()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."material_static
                ORDER BY material_name";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        for(; !$result->EOF; $result->MoveNext()) {
            $info[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $info;

    }


/**
     * POSMGMT::GetPrices()
     *
     * @return
     */
    function GetPrices()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT Name, value FROM ".TBL_PREFIX."prices ORDER BY Name ASC";
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }
		
		
       for(; !$result->EOF; $result->MoveNext()) {
            $prices = $result->GetAssoc();
        }
		
        $result->Close();
        return $prices;

    }
	
/**
     * POSMGMT::GetSettings()
     *
     * @return
     */
    function GetSettings()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM ".TBL_PREFIX."settings ORDER BY id";
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . '<br />' . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }
		
		
       for(; !$result->EOF; $result->MoveNext()) {
            $settings[] = $result->GetRowAssoc(2);
        }
		
        $result->Close();
        return $settings;

    }
	
    /**
     * POSMGMT::GetStaticReactionInfo()
     *
     * @param mixed $material_id
     * @param integer $limit
     * @return
     */
    function GetStaticReactionInfo($material_id, $limit = 0)
    {

        if (!$material_id || !is_numeric($material_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sqllimit = (($limit > 0) ? "  LIMIT $limit" : "");

        $sql = "SELECT *
                FROM ".TBL_PREFIX."reaction_static
                WHERE material_id = '".Eve::VarPrepForStore($material_id)."' $sqllimit";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $info = $result->GetRowAssoc(2);
//echo '<pre>';print_r($info);echo '</pre>';exit;
        $result->Close();

        return $info;

    }

    /**
     * POSMGMT::GetFuelBill()
     *
     * @param mixed $args
     * @return
     */
    function GetFuelBill($args = array())
    {
        //global $eve, $posmgmt;

        //database connection
        $dbconn =& DBGetConn(true);

      if (isset($args['use_current_levels'])) {
            $use_current_levels = $args['use_current_levels'];
        } else {
            $use_current_levels = 1;
        }
		
		if (isset($args['display_optimal'])) {
            $display_optimal = $args['display_optimal'];
        } else {
            $display_optimal = 1;
        }
		
		if (isset($args['calc_fuel'])) {
            $calc_fuel = $args['calc_fuel'];
        } else {
            $calc_fuel = 0;
        }

        //$days_to_refuel = $eve->VarCleanFromInput('days'); if (empty($days_to_refuel)) { $days_to_refuel = 20; }
        $days_to_refuel = 30; //$eve->VarCleanFromInput('days'); if (empty($days_to_refuel)) { $days_to_refuel = 20; }
        if (isset($args['days_to_refuel'])) {
            $days_to_refuel = $args['days_to_refuel'];
        }
        $hours_to_refuel = 0;
        $checkstront = false;

        $alltowers = $this->GetAllTowers($args);

        foreach($alltowers as $tower) {
            $current_fuelblock = $current_strontium = $current_charters = 0;

			$hoursago = $this->hoursago($tower['pos_id'], '1');
            $result_online = $this->online($result_uptimecalc);
            $online = $this->daycalc($result_online);

            $pos_to_refuel            = $tower['pos_id'];
			$current_fuelblock         = $tower['fuelblock'];
            $current_strontium        = $tower['strontium'];
            $current_charters         = $tower['charters'];
            $charters_needed          = $tower['charters_needed'];
            $pos_size                 = $tower['pos_size'];
            $pos_race                 = $tower['pos_race'];
            $tower_cpu                = $tower['cpu'];
            $tower_pg                 = $tower['powergrid'];
            // added new varibles to bring it update with our new additions
            $systemID                 = $tower['systemID'];
            $locationName             = $this->getSystemName($systemID);
            $sovereignty              = $this->getSovereignty($systemID);
            $system                   = $locationName;//$tower['system'];
            $corp                     = $tower['corp'];
            $towerName                = $tower['towerName'];
            $outpost_id               = $tower['outpost_id'];
            $pos_id                   = $tower['pos_id'];
			$secret_pos               = $tower['secret_pos'];
            $bill[$pos_to_refuel]['owner_id'] = $tower['owner_id'];
			$bill[$pos_to_refuel]['secondary_owner_id'] = $tower['secondary_owner_id'];
            $bill[$pos_to_refuel]['pos_status'] = $tower['pos_status'];
            $bill[$pos_to_refuel]['result_online'] = $result_online;
            $bill[$pos_to_refuel]['online'] = $online;
            $allianceid               = $tower['allianceid'];
            //$use_npc_levels   = (boolean) $_POST['use_npc_levels']; //Disable NPC hanger
			$bill[$pos_to_refuel]['sovfriendly'] = $this->getSovereigntyStatus($systemID, $allianceid);

            if ($tower['moonID']) {
                $sql = "SELECT ".TBL_PREFIX."evemoons.moonName FROM `".TBL_PREFIX."evemoons` WHERE ".TBL_PREFIX."evemoons.moonID='".$tower['moonID']."'";
                $result = mysql_query($sql) or die('Could not get access to the user/pos database; ' . mysql_error());
                $moonrow = mysql_fetch_array($result);
                $locationName = $moonrow['moonName'];
            } else {
                $locationName = $this->getSystemName($systemID);
            }

            $bill[$pos_to_refuel]['systemID']     = $systemID;
            $bill[$pos_to_refuel]['pos_size']     = $pos_size;
            $bill[$pos_to_refuel]['pos_race']     = $pos_race;
            $bill[$pos_to_refuel]['systemID']     = $systemID;
            $bill[$pos_to_refuel]['locationName'] = $locationName;
            $bill[$pos_to_refuel]['sovereignty']  = $sovereignty;
            $bill[$pos_to_refuel]['system']       = $system;
            $bill[$pos_to_refuel]['corp']         = $corp;
            $bill[$pos_to_refuel]['towerName']    = $towerName;
            $bill[$pos_to_refuel]['outpost_id'] = $outpost_id;
            $bill[$pos_to_refuel]['pos_id']       = $pos_id;
            $bill[$pos_to_refuel]['allianceid']   = $allianceid;
			$bill[$pos_to_refuel]['secret_pos']         = $secret_pos;
			
			$row = $this->GetStaticFBTowerInfo(array('pos_race' => $pos_race, 'pos_size' => $pos_size));
				if ($bill[$pos_to_refuel]['sovfriendly'] == 1) {
					$hasSov = .75;
				} else {
					$hasSov = 1;
				}
            if ($row) {
			    $required_fuelblock   = ceil($row['fuelblock'] * $hasSov);
                $required_strontium         = ceil($row['strontium'] * $hasSov);;
                $required_charters          = $charters_needed?1:0;
                $pos_capacity               = $row['fuel_hangar'];
                $strontium_capacity         = $row['strontium_hangar'];
            }
         /*#-----------------
            $hanger_fuelblock = $hanger_strontium = $hanger_charters = 0;
       
            $sql = "SELECT ".TBL_PREFIX."pos_hanger.*, ".TBL_PREFIX."pos_structures.online FROM ".TBL_PREFIX."pos_hanger INNER JOIN ".TBL_PREFIX."pos_structures ON (pos2_pos_hanger.hanger_id = ".TBL_PREFIX."pos_structures.id) WHERE ".TBL_PREFIX."pos_structures.pos_id='" . $eve->VarPrepForStore($pos_to_refuel) . "'";
            $result = mysql_query($sql) or die('Error retrieving from tower_info in function uptimecalc;' . mysql_error()) ;

            if ($row = mysql_fetch_array($result)) {
                $hanger_isotope       = $row['isotope'];
                $hanger_oxygen        = $row['oxygen'];
                $hanger_mechanical_parts  = $row['mechanical_parts'];
                $hanger_coolant       = $row['coolant'];
                $hanger_robotics      = $row['robotics'];
                $hanger_uranium       = $row['uranium'];
                $hanger_ozone       = $row['ozone'];
                $hanger_heavy_water     = $row['heavy_water'];
                $hanger_strontium     = $row['strontium'];
                $hanger_charters      = $row['charters'];
            }
        */ 

            $bill[$pos_to_refuel]['required_fuelblock']           = $required_fuelblock;
            $bill[$pos_to_refuel]['required_strontium']         = $required_strontium;
            $bill[$pos_to_refuel]['required_charters']          = $required_charters;

            switch ($pos_size) {
                case 1:
                    $bill[$pos_to_refuel]['pos_size_name'] = "Small ";
                    break;
                case 2:
                    $bill[$pos_to_refuel]['pos_size_name'] = "Medium ";
                    break;
                case 3:
                    $bill[$pos_to_refuel]['pos_size_name'] = "Large ";
                    break;
            }

            switch ($pos_race) {
                case 1:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Amarr Control Tower";
                    break;
                case 2:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Caldari Control Tower";
                    break;
                case 3:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Gallente Control Tower";
                    break;
                case 4:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Minmatar Control Tower";
                    break;
                case 5:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Angel Control Tower";
                    break;
                case 6:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Blood Control Tower";
                    break;
                case 7:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Dark Blood Control Tower";
                    break;
                case 8:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Domination Control Tower";
                    break;
                case 9:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Dread Guristas Control Tower";
                    break;
                case 10:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Guristas Control Tower";
                    break;
                case 11:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Sansha Control Tower";
                    break;
                case 12:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Serpentis Control Tower";
                    break;
                case 13:
                    $bill[$pos_to_refuel]['pos_race_name'] = "Shadow Control Tower";
                    break;
                case 14:
                    $bill[$pos_to_refuel]['pos_race_name'] = "True Sansha' Control Tower";
                    break;
            }

            $bill[$pos_to_refuel]['outpost_id'] = $outpost_id;
            $bill[$pos_to_refuel]['locationName'] = $locationName;
            $bill[$pos_to_refuel]['towerName']    = $towerName;
            $bill[$pos_to_refuel]['sovereignty']  = $sovereignty;

		if ($display_optimal) {
			$volume_per_cycle  = 0;
			$volume_per_cycle += ($required_fuelblock * $GLOBALS["pos_Fbl"]);
			$volume_per_cycle += ($required_charters * $GLOBALS["pos_Cha"]);
			$optimum_cycles    = floor(($pos_capacity)/$volume_per_cycle);
			
			$optimal['optimum_cycles']=$optimum_cycles;
			$optimal['optimal_strontium_cycles'] = $optimal_strontium_cycles = floor($strontium_capacity/($required_strontium*3));
			$optimal['optimum_fuelblock']          = $required_fuelblock * $optimum_cycles;
			$optimal['optimum_charters']         = $optimum_cycles;
			$optimal['optimum_strontium']        = $required_strontium * $optimal_strontium_cycles;
			if ($calc_fuel) { //override numbers, user is using the Fuel Calc
				$needed_hours               = (integer) (abs($days_to_refuel*24) + abs($hours_to_refuel)) ;
				$needed_fuelblock          = $required_fuelblock * $needed_hours;
				$needed_charters         = $required_charters * $needed_hours;	
				}
			if (!$required_charters) {
				$optimal['optimum_charters'] = 0;
			}
		} else {
			$needed_hours               = (integer) (abs($days_to_refuel*24) + abs($hours_to_refuel)) ;
            $total_fuelblock          = $required_fuelblock * $needed_hours;
            $total_charters             = $required_charters * $needed_hours;
		
            $needed_fuelblock      = $required_fuelblock * $needed_hours;
            $needed_charters         = $required_charters * $needed_hours;
            if ($checkstront) {
                $needed_stront       = $strontium_capacity - $current_strontium;
            }
		
		}

		$avail_fuelblock          = ($current_fuelblock - ($required_fuelblock * $hoursago));
        $avail_strontium        =  $current_strontium;
        $avail_charters         = ($current_charters - ($required_charters * $hoursago));
		
            if ($use_current_levels) {
			
                $fuelbill_fuelblock = $needed_fuelblock - $current_fuelblock;
                $fuelbill_charters = $needed_charters - $current_charters;
				
				
				if ($display_optimal) {
					$fuelbill_fuelblock = $optimal['optimum_fuelblock'] - $avail_fuelblock;
					$fuelbill_charters = $optimal['optimum_charters'] - $avail_charters;		
					if ($fuelbill_fuelblock > $optimal['optimum_fuelblock']) {
						$fuelbill_fuelblock = $optimal['optimum_fuelblock'];
					}
					if ($fuelbill_charters > $optimal['optimum_charters']) {
						$fuelbill_charters = $optimal['optimum_charters'];
					}		
				}
            } else {
				if ($display_optimal) {
					$fuelbill_fuelblock = $optimal['optimum_fuelblock'];
					$fuelbill_charters = $optimal['optimum_charters'];		
				} else {
					$fuelbill_fuelblock = $needed_fuelblock;
					$fuelbill_charters = $needed_charters;
				}
			}
            //echo $use_hanger_levels;
			/*
            if ($use_hanger_levels) {
                $needed_fuelblock = $needed_fuelblock  - $hanger_fuelblock;
                $needed_charters = $needed_charters - $hanger_charters;
            } */
			
		    if ($fuelbill_fuelblock < 0 ) {
                $fuelbill_fuelblock = 0;
            }
			switch($pos_race) {
				case 1:
				case 6:
				case 7:
				case 11:
				case 14:
					$bill[$pos_to_refuel]['fuel_A_fuelblock'] = $fuelbill_fuelblock;break;
				case 4:  
				case 5: 
				case 8:
					$bill[$pos_to_refuel]['fuel_M_fuelblock'] = $fuelbill_fuelblock; break;
				case 2:  
				case 9: 
				case 10: 
					$bill[$pos_to_refuel]['fuel_C_fuelblock'] = $fuelbill_fuelblock; break;
				case 3:
				case 12:
				case 13:
					$bill[$pos_to_refuel]['fuel_G_fuelblock'] = $fuelbill_fuelblock; break;
			}
			
			if ($fuelbill_charters < 0) {
                $fuelbill_charters = 0;
            }
			$bill[$pos_to_refuel]['fuel_charters'] = $fuelbill_charters;
            //Disable NPC hanger
            /*if ($use_npc_levels) {
              $needed_fuelblock          = $needed_fuelblock - $npc_fuelblock;
              $needed_charters         = $needed_charters - $npc_charters;
            }*/
			
			if ($use_current_levels) {
			$needed_fuelblock = $needed_fuelblock - $avail_fuelblock;
			$needed_charters = $needed_charters - $avail_charters;
			}
			
            if ($needed_fuelblock < 0) {
                $needed_fuelblock = 0;
            }
            if ($needed_charters < 0) {
                $needed_charters = 0;
            }
            if ($checkstront) {
                if ($needed_stront < 0 ) {
                    $needed_stront = 0;
                }
            }
            $bill[$pos_to_refuel]['needed_fuelblock'] = $needed_fuelblock;
            $bill[$pos_to_refuel]['needed_charters'] = $needed_charters;
            if ($checkstront) {
                $bill[$pos_to_refuel]['needed_stront']       = $needed_stront;
            }

            if ($checkstront) {
                $bill[$pos_to_refuel]['needed_stront_size']       = $needed_stront * $GLOBALS["pos_Str"];
            }
			
			$bill[$pos_to_refuel]['needed_fuelblock_size']          = $needed_fuelblock * $GLOBALS["pos_Fbl"];
            $bill[$pos_to_refuel]['needed_charter_size']          = $needed_charters * $GLOBALS["pos_Cha"];
            $bill[$pos_to_refuel]['total_volume'] = $bill[$pos_to_refuel]['needed_fuelblock_size'] + $bill[$pos_to_refuel]['needed_charter_size'];
            $bill[$pos_to_refuel]['total_volume_stront'] = $total_volume + $needed_stront_size;
			
			$bill[$pos_to_refuel]['fb_fuelblock_size']          = $fuelbill_fuelblock * $GLOBALS["pos_Fbl"];
            $bill[$pos_to_refuel]['fb_charter_size']          = $fuelbill_charters * $GLOBALS["pos_Cha"];
            $bill[$pos_to_refuel]['fb_total_volume'] = $bill[$pos_to_refuel]['fb_fuelblock_size'] + $bill[$pos_to_refuel]['fb_charter_size'];
			//echo '<pre>';print_r($hoursago); echo '</pre>';
        }
        return $bill;
    }

    /************ API STUFF ************/
    // Connection to API, returns the xml object.
	/**
     * POSMGMT::API_Connect()
     *
     * @param mixed $url
     * @param string $userid
     * @param string $apikey
     * @param string $conntype
     * @return
     */
    function API_Connect($url, $userid = '', $apikey = '', $conntype = 'POST')
    {

        if (!$url) {
            Eve::SessionSetVar('errormsg', 'NO URL');
            return false;
        }

        $data = array();
        if (!empty($userid) && !empty($apikey)) {
            $data = array('keyID'  => $userid,
                          'vCode'  => $apikey,
                          'version' => 2);
        }
		$apiURL = $this->API_ProxySelect();
        $extensions = get_loaded_extensions();
        $curl = in_array('curl', $extensions);
		
        if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL.$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
        }

        //Create XML Parser
        try {
            $xml = new SimpleXMLElement($content);
        } catch (Exception $e) {
            // handle the error
            Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
            return false;
            //echo 'Not a valid xml string';
        }

        foreach ($xml->xpath('//error') as $error) {
            Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error);
            return false; //$fail = 1;
        }

        return $xml;

    }

	
	
    /**
     * POSMGMT::API_UpdateAlliances()
     *
     * @return
     */
    function API_UpdateAlliances()
    {

        //$url = "http://api.eve-online.com/eve/AllianceList.xml.aspx";
        $url = "/eve/AllianceList.xml.aspx";

        $xml = $this->API_Connect($url);

        if (!$xml) { return false; }

        $fail = 0;
        $time = time();

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE `".TBL_PREFIX."alliance_info`
                SET    `updateTime` = '" . Eve::VarPrepForStore($time) . "'
                WHERE  `allianceID` = '0'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Could not update time, contact your admin ; ' . $dbconn->ErrorMsg());
            return false;
        }

        $alladded     = array();
        $counttotal   = 0;
        $updatestotal = 0;
        foreach ($xml->xpath('/eveapi/result/rowset/row') as $row) {

            $name=$row['name'];
            $counttotal = $counttotal + 1;

            $sql = "SELECT *
                    FROM   `".TBL_PREFIX."alliance_info`
                    WHERE  `allianceID` = '".Eve::VarPrepForStore($row['allianceID'])."' LIMIT 1";

            $result = $dbconn->Execute($sql);
            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', 'Could not get alliance info, contact your admin ; ' . $dbconn->ErrorMsg());
                return false;
            }
            if ($result->EOF) {
                $sql = "INSERT INTO ".TBL_PREFIX."alliance_info (`allianceID`,
                                                        `name`,
                                                        `shortName`,
                                                        `updateTime`)
                        VALUES                         ('".Eve::VarPrepForStore($row['allianceID']) ."',
                                                        '".Eve::VarPrepForStore($row['name'])       ."',
                                                        '".Eve::VarPrepForStore($row['shortName'])  ."',
                                                        '".Eve::VarPrepForStore($time)."')";
                $dbconn->Execute($sql);

                if ($dbconn->ErrorNo() != 0) {
                    Eve::SessionSetVar('errormsg', 'Could not insert alliance info, contact your admin ; ' . $dbconn->ErrorMsg());
                    return false;
                }

                $alladded[]   = array('allianceID' => $row['allianceID'],
                                      'name'       => $row['name'],
                                      'shortName'  => $row['shortName']);

                $updatestotal = $updatestotal + 1;
            } else {
                $sql = "UPDATE ".TBL_PREFIX."alliance_info
                        SET    name         = '".Eve::VarPrepForStore($row['name'])."',
                               shortName    = '".Eve::VarPrepForStore($row['shortName'])."',
                               updateTime   = '".Eve::VarPrepForStore($time)."'
                        WHERE  allianceID   = '".Eve::VarPrepForStore($row['allianceID'])."'";
                $dbconn->Execute($sql);

                if ($dbconn->ErrorNo() != 0) {
                    Eve::SessionSetVar('errormsg', 'Could not insert alliance info, contact your admin ; ' . $dbconn->ErrorMsg());
                    return false;
                }
                //$result->Close();
            }

        }

        return array('counttotal'   => $counttotal,
                     'updatestotal' => $updatestotal,
                     'alladded'     => $alladded);

    }

    /**
     * POSMGMT::API_UpdateSovereignty()
     *
     * @return
     */
    function API_UpdateSovereignty()
    {

        //$url = "http://api.eve-online.com/map/Sovereignty.xml.aspx";
        $url = "/map/Sovereignty.xml.aspx";

        $xml = $this->API_Connect($url);

        if (!$xml) { return false; }

        $fail = 0;
        $time = time();
        $dbconn =& DBGetConn(true);

        $count = 0;
        foreach ($xml->xpath('//row') as $row) {
            //if ($row['corporationID'] != '0') { $row['sovereigntyLevel'] = 1; }
            $sql = "UPDATE ".TBL_PREFIX."system_status
                    SET    allianceID               = '".Eve::VarPrepForStore($row['allianceID'])."',
                           corporationID            = '".Eve::VarPrepForStore($row['corporationID'])."',
                           updateTime               = '".Eve::VarPrepForStore($time)."'
                    WHERE  solarSystemID            = '".Eve::VarPrepForStore($row['solarSystemID'])."'
                    AND    CONVERT(".TBL_PREFIX."system_status.solarSystemName USING utf8) = '".Eve::VarPrepForStore($row['solarSystemName'])."'";

            $dbconn->Execute($sql);

            if ($dbconn->ErrorNo() != 0) {
                Eve::SessionSetVar('errormsg', 'Could not update sov ; ' . $dbconn->ErrorMsg());
                return false;
            }

            $count = $count + 1;

        }

        return $count;

    }

    /**
     * POSMGMT::API_GetCharacters()
     *
     * @param mixed $userid
     * @param mixed $apikey
     * @return
     */
    function API_GetCharacters($userid, $apikey)
    {

        //$url = "http://api.eve-online.com/account/Characters.xml.aspx";
        $url = "/account/Characters.xml.aspx";

        $xml = $this->API_Connect($url, $userid, $apikey, 'GET');

        if (!$xml) { return false; }

        $characters = array();

        foreach ($xml->xpath('//row') as $character) {
            if (!$character) { continue; }
            $name            = strval($character['name']);
            $characterID     = strval($character['characterID']);
            $corporationID   = strval($character['corporationID']);
            $corporationName = strval($character['corporationName']);

            $characters[] = array('name'            => $name,
                                  'characterID'     => $characterID,
                                  'corporationID'   => $corporationID,
                                  'corporationName' => $corporationName);
          /*
            $characters[] = array('name'            => $character['name'],
                                  'corporationName' => $character['corporationName'],
                                  'characterID'     => $character['characterID'],
                                  'corporationID'   => $character['corporationID']);
          */
        }
        //echo '<pre>';print_r($characters);echo '</pre>';exit;
        return $characters;

    }

    /**
     * POSMGMT::API_GetCorpInfo()
     *
     * @param mixed $corporationID
     * @return
     */
    function API_GetCorpInfo($corporationID)
    {

        //$url     = "http://api.eve-online.com/corp/CorporationSheet.xml.aspx";
        $url     = "/corp/CorporationSheet.xml.aspx";
        $version = 2;
        $data = array('corporationID' => $corporationID,
                      'version'       => $version);

        //Begins connecting to eve api
		$apiURL = $this->API_ProxySelect();
        $extensions = get_loaded_extensions();
        $curl = in_array('curl', $extensions);

        if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL.$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
        }

        try {
            $xml = new SimpleXMLElement($content);
        } catch (Exception $e) {
            // handle the error
            Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
            return false;
        }

        foreach ($xml->xpath('//error') as $error) {

            if ($error['code'] == 214) {
                $alliance['allianceID']   = 0;
                $alliance['allianceName'] = NULL;
                return $alliance;
            } elseif ($error['code']) {
                Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error);
                return false; //$fail = 1;
            }
        }

        foreach ($xml->xpath('//allianceID') as $allianceID) {
            $alliance['allianceID'] = strval($allianceID);
        }
        foreach ($xml->xpath('//allianceName') as $allianceName) {
            $alliance['allianceName'] = strval($allianceName);
        }

        return $alliance;

    }

    /**
     * POSMGMT::API_GetKeyInfo()
     *
     * @return
     */
    function API_GetKeyInfo()
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."eveapi";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            //Eve::SessionSetVar('errormsg', 'Could not get any key from the DB ; ' . $dbconn->ErrorMsg());
            return false;
        }

        $keys = array();

        for(; !$result->EOF; $result->MoveNext()) {
            $keys[] = $result->GetRowAssoc(2);
        }

        return $keys;
    }

    /**
     * POSMGMT::DeleteKey()
     *
     * @param mixed $id
     * @return
     */
    function DeleteKey($id)
    {

        if (!$id) {
            Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }
        if(is_numeric(!$id))
        {
        Eve::SessionSetVar('errormsg', 'No ID!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "DELETE FROM ".TBL_PREFIX."eveapi
                WHERE       id = '".Eve::VarPrepForStore($id)."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::API_UPDATEAllPOSES()
     *
     * @return
     */
    function API_UPDATEAllPOSES()
    {

        date_default_timezone_set(GMT);
        $keys = $this->API_GetKeyInfo();

        if (!$keys) {
            Eve::SessionSetVar('errormsg', 'Could not get any key from the DB!');
            return false;
        }

        //$url = 'http://api.eve-online.com/corp/StarbaseList.xml.aspx';
		$apiURL = $this->API_ProxySelect();
        $url = '/corp/StarbaseList.xml.aspx';

        $time=time();
        foreach ($keys as $key) {
            if ($key['apitimer'] < ($time-3600)) { //21600 = 6 HOURS, The real time the API Caches the POS details information

                $userid         = $key['userID'];
                $apikey         = $key['apikey'];
                $characterID    = $key['characterID'];
                $corp           = $key['corp'];
                $allianceID     = $key['allianceID'];
                $fail           = 0;
                $count_added    = 0;
                $count_updated  = 0;
                $count_towers   = 0;
                $data = array('keyID'      => $userid,
                              'vCode'      => $apikey,
                              'version'     => $version,
                              'characterID' => $characterID);

                $extensions = get_loaded_extensions();
                $curl = in_array('curl', $extensions);

            if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL.$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
            }

                try {
                    $xml = new SimpleXMLElement($content);
                } catch (Exception $e) {
                    Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
                    return false;
                }

                foreach ($xml->xpath('//error') as $error) {
                    Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error.'. User ID: '.$userID.' Character ID: '.$characterID.' Corp: '.$corp);
                    return false; //$fail = 1;
                }
                foreach ($xml->xpath('//cachedUntil') as $cachedUntil) {
                  $updateTime=(strtotime($cachedUntil)-3600);
                }
                $dbconn =& DBGetConn(true);

                if(defined('POS_CACHE_XML')) {
                //hash for cache
                    $unique=md5($userID.$characterID);
                //Cache XML
                    $cacheName='StarbaseList'.$unique;
                    $this->API_cacheXML($xml->asXML(), $cacheName);
                }
                foreach ($xml->xpath('//row') as $pos) {
                    (integer) $evetowerID       = strval($pos['itemID']);
                    (integer) $typeID           = strval($pos['typeID']);
                    (integer) $systemID         = strval($pos['locationID']);
                              $onlineSince      = strval($pos['onlineTimestamp']);
                              $pos_status       = strval($pos['state']);
                              $fuel             = $this->posdetail($evetowerID, $userid, $apikey, $characterID);
                    (string)  $outpost_id     = "None";
                    (string)  $towerName        = "EVE API - NEW";
                    (integer) $charters         = $fuel['charters'];
					(integer) $fuelblock         = $fuel['fuelblock'];
                    (integer) $strontium        = $fuel['strontium'];
                    (integer) $systemID         = strval($pos['locationID']);
                    (integer) $owner_id         = 0;
                    (integer) $moonID           = strval($pos['moonID']);
					(string)  $current_status = date("Y-m-d H:i:s")." by API";
                    #define varibles for the row count function
                    $add = false;
                    $sql = "SELECT * FROM ".TBL_PREFIX."tower_info WHERE evetowerID = '".Eve::VarPrepForStore($evetowerID)."'";
                    $result = $dbconn->Execute($sql);
                    if ($dbconn->ErrorNo() != 0) {
                        Eve::SessionSetVar('errormsg', 'ERROR getting pos Info ; ' . $dbconn->ErrorMsg());
                        return false;
                    }
                    if (!$result->EOF) {
                        $posinfo = $result->GetRowAssoc(2);
                        $pos_id  = $posinfo['pos_id'];
                        $sql = "UPDATE ".TBL_PREFIX."tower_info
                                SET strontium        = '" . Eve::VarPrepForStore($strontium)        . "',
                                       charters         = '" . Eve::VarPrepForStore($charters)         ."',
									   fuelblock         = '" . Eve::VarPrepForStore($fuelblock)         ."',
                                       onlineSince      = '" . Eve::VarPrepForStore($onlineSince)      ."',
									   status      = '" . Eve::VarPrepForStore($current_status)      ."',
                                       pos_status       = '" . Eve::VarPrepForStore($pos_status)       ."',
									   allianceid      = '" . Eve::VarPrepForStore($allianceID)      ."'
                                WHERE  evetowerID       = '" . Eve::VarPrepForStore($evetowerID)       . "'";
                        $dbconn->Execute($sql);
                        if ($dbconn->ErrorNo() != 0) {
                            Eve::SessionSetVar('errormsg', 'ERROR Failed to update tower info ; ' . $dbconn->ErrorMsg());
                            return false;
                        }
                        $posupdate[$evetowerID] = 'Updated';
                        $count_updated++;
                        $count_towers++;
                        $result->Close();
                    } else {
                        // If Count
                        //Add to POS to database if not already in
                        /****************************************/
                        // But checking first if there is one already on the moon.
                        $sql = "SELECT * FROM ".TBL_PREFIX."tower_info WHERE moonID = '".Eve::VarPrepForStore($moonID)."'";
                        $result = $dbconn->Execute($sql);
                        if ($dbconn->ErrorNo() != 0) {
                            Eve::SessionSetVar('errormsg', 'ERROR getting pos Info ; ' . $dbconn->ErrorMsg());
                            return false;
                        }
                        if (!$result->EOF) {
                            $posinfo = $result->GetRowAssoc(2);
                            $pos_id  = $posinfo['pos_id'];
                            $sql = "UPDATE ".TBL_PREFIX."tower_info
                                    SET    evetowerID       = '" . Eve::VarPrepForStore($evetowerID)       . "',
                                           strontium        = '" . Eve::VarPrepForStore($strontium)        . "',
                                           charters         = '" . Eve::VarPrepForStore($charters)         ."',
										   fuelblock         = '" . Eve::VarPrepForStore($fuelblock)         ."',
                                           onlineSince      = '" . Eve::VarPrepForStore($onlineSince)      ."',
										   status      = '" . Eve::VarPrepForStore($current_status)      ."',
                                           pos_status       = '" . Eve::VarPrepForStore($pos_status)       ."',
										   allianceid      = '" . Eve::VarPrepForStore($allianceID)      ."'
                                    WHERE  moonID           = '" . Eve::VarPrepForStore($moonID)           . "'";
                            $dbconn->Execute($sql);
                            if ($dbconn->ErrorNo() != 0) {
                                Eve::SessionSetVar('errormsg', 'ERROR Failed to update tower info ; ' . $dbconn->ErrorMsg());
                                return false;
                            }
                            $posupdate[$evetowerID] = 'Updated';
                            $count_updated++;
                            $count_towers++;
                            $result->Close();
                        } else {
                            $sql = "SELECT * FROM ".TBL_PREFIX."tower_static WHERE typeID = '".Eve::VarPrepForStore($typeID)."'";
                            $result = $dbconn->Execute($sql);
                            $towerinfo = $result->GetRowAssoc(2);
                            (integer) $pos_size = $towerinfo['pos_size'];
                            (integer) $pos_race = $towerinfo['pos_race'];

                            $security=$this->getSystemSecurity($systemID);
                            if($security>0.45)
                            {
                                (integer) $charters_needed=1;
                            }
                            else
                            {
                                (integer) $charters_needed=0;
                            }
                            //$nextId = $dbconn->GenId(TBL_PREFIX.'tower_info');
                            $sql = "INSERT INTO ".TBL_PREFIX."tower_info (typeID,
                                             evetowerID,
                                             outpost_id,
                                             corp,
                                             allianceid,
                                             pos_size,
                                             pos_race,
                                             fuelblock,
                                             charters,
                                             strontium,
                                             towerName,
                                             systemID,
                                             charters_needed,
                                             status,
                                             owner_id,
                                             secondary_owner_id,
                                             pos_status,
                                             pos_comment,
                                             secret_pos,
                                             moonID,
                                             onlineSince)
                                    VALUES     ('" . Eve::VarPrepForStore($typeID)           . "',
                                                '" . Eve::VarPrepForStore($evetowerID)       . "',
                                                0,
                                                '" . Eve::VarPrepForStore($corp)             . "',
                                                '" . Eve::VarPrepForStore($allianceID)       . "',
                                                '" . Eve::VarPrepForStore($pos_size)         . "',
                                                '" . Eve::VarPrepForStore($pos_race)         . "',
                                                '" . Eve::VarPrepForStore($fuelblock)          . "',
                                                '" . Eve::VarPrepForStore($charters)         . "',
                                                '" . Eve::VarPrepForStore($strontium)        . "',
                                                '" . Eve::VarPrepForStore($towerName)        . "',
                                                '" . Eve::VarPrepForStore($systemID)         . "',
                                                '" . Eve::VarPrepForStore($charters_needed)  . "',
                                                '" . Eve::VarPrepForStore($current_status)  . "',
                                                '". Eve::VarPrepForStore($owner_id)          . "' ,
                                                NULL,
                                                '".Eve::VarPrepForStore($pos_status)         . "',
                                                NULL,
                                                '0',
                                                '" . Eve::VarPrepForStore($moonID)           . "',
                                                '" . Eve::VarPrepForStore($onlineSince)      ."')";
                            $dbconn->Execute($sql);
                            if ($dbconn->ErrorNo() != 0) {
                                Eve::SessionSetVar('errormsg', 'ERROR Failed to Add tower info ; ' . $dbconn->ErrorMsg());
                                return false;
                            }

                            $pos_id = $dbconn->PO_Insert_ID(TBL_PREFIX.'tower_info', 'pos_id');
                            $posupdate[$evetowerID] = 'Added';
                            $count_added++;
                            $count_towers++;
                        }

                    } //Else Count
                    $time = time();
                    $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL,
                                                                '0',
                                                                '" . Eve::VarPrepForStore($pos_id) . "',
                                                                '1',
                                                                'EVEAPI XML STARBASE API UPDATE',
                                                                '" . Eve::VarPrepForStore($time) . "')"; //$updateTime
                    $dbconn->Execute($sql);
                    if ($dbconn->ErrorNo() != 0) {
                        Eve::SessionSetVar('errormsg', 'ERROR Failed to update log info ; ' . $dbconn->ErrorMsg());
                        return false;
                    }

                }

				
                $sql = "UPDATE ".TBL_PREFIX."eveapi SET apitimer = '".Eve::VarPrepForStore($time)."' WHERE characterID = '" . Eve::VarPrepForStore($characterID) . "'";
                $dbconn->Execute($sql);
                if ($dbconn->ErrorNo() != 0) {
                    Eve::SessionSetVar('errormsg', 'ERROR Failed to update log info ; ' . $dbconn->ErrorMsg());
                    return false;
                }

            } else {
                Eve::SessionSetVar('errormsg', 'ERROR API Cache timer too short ; ');
                return false;
            }
        }

        return array('posupdate'     => $posupdate,
                     'count_added'   => $count_added,
                     'count_updated' => $count_updated,
                     'count_towers'  => $count_towers);

    }

	/**
     * POSMGMT::API_UpdateIndustryJobs()
     *
     *
     *
     *
     */
	function API_UpdateIndustryJobs()
    {
		date_default_timezone_set(GMT);
		
		$keys = $this->API_GetKeyInfo();
        if (!$keys) {
            Eve::SessionSetVar('errormsg', 'Could not get any key from the DB!');
            return false;
        }
		$apiURL = $this->API_ProxySelect();
        $url = "/corp/IndustryJobs.xml.aspx";
		$time=time();
        foreach ($keys as $key) {
			$JobCheck = $this->GetLastJobUpdate($key['characterID']);
            if ($JobCheck < ($time-21600)) { //21600 = 6 HOURS, The real time the API Caches the POS details information
                $userid         = $key['userID'];
                $apikey         = $key['apikey'];
                $characterID    = $key['characterID'];
                $corp           = $key['corp'];
                $allianceID     = $key['allianceID'];
                $fail           = 0;
                $data = array('keyID'      => $userid,
                              'vCode'      => $apikey,
                              'version'     => $version,
                              'characterID' => $characterID);

                $extensions = get_loaded_extensions();
                $curl = in_array('curl', $extensions);

            if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL.$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
               }

                try {
                    $xml = new SimpleXMLElement($content);
                } catch (Exception $e) {
                    Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
                    return false;
                }

                foreach ($xml->xpath('//error') as $error) {
                    Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error.'. User ID: '.$userID.' Character ID: '.$characterID.' Corp: '.$corp);
                    return false; //$fail = 1;
                }
                foreach ($xml->xpath('//cachedUntil') as $cachedUntil) {
                  $updateTime=(strtotime($cachedUntil)-21600);
                }
                $dbconn =& DBGetConn(true);

                if(defined('POS_CACHE_XML')) {
                //hash for cache
                    $unique=md5($userID.$characterID);
                //Cache XML
                    $cacheName='IndustrialJobs'.$unique;
                    $this->API_cacheXML($xml->asXML(), $cacheName);
                }
					
        foreach ($xml->xpath('//row') as $row) {
					
					(integer) $jobID			       						= strval($row['jobID']);
			        (integer) $assemblyLineID       						= strval($row['assemblyLineID']);
                    (integer) $containerID       						    = strval($row['containerID']);
                    (integer) $installedItemID        						= strval($row['installedItemID']);
					(integer) $installedItemLocationID       				= strval($row['installedItemLocationID']);
                    (integer) $installedItemProductivityLevel						  = $row['installedItemProductivityLevel'];
					(integer) $installedItemMaterialLevel								  = $row['installedItemMaterialLevel'];
                    (integer) $installedItemLicensedProductionRunsRemaining = $row['installedItemLicensedProductionRunsRemaining'];
					(integer) $outputLocationID           					= strval($row['outputLocationID']);
					(integer) $installerID         											  				 = strval($row['installerID']);
					(integer) $runs           								= strval($row['runs']);
                    (integer) $licensedProductionRuns         				= strval($row['licensedProductionRuns']);
					(integer) $installedInSolarSystemID           			= strval($row['installedInSolarSystemID']);
                    (integer) $containerLocationID         					= strval($row['containerLocationID']);
					(integer) $materialMultiplier           				= strval($row['materialMultiplier']);
                    (integer) $charMaterialMultiplier         				= strval($row['charMaterialMultiplier']);
					(integer) $installedItemTypeID           				              				= strval($row['installedItemTypeID']);
                    (integer) $outputTypeID         										  				= strval($row['outputTypeID']);
					(integer) $containerTypeID           					              				= strval($row['containerTypeID']);
                    (integer) $installedItemCopy         					= strval($row['installedItemCopy']);
					(integer) $completed           							= strval($row['completed']);
                    (integer) $completedSuccessfully         				= strval($row['completedSuccessfully']);
					(integer) $installedItemFlag           					= strval($row['installedItemFlag']);
                    (integer) $outputFlag         							= strval($row['outputFlag']);
					(integer) $activityID           						= strval($row['activityID']);
                    (integer) $completedStatus         						= strval($row['completedStatus']);
					(integer) $installTime         							= strval($row['installTime']);
					(integer) $beginProductionTime         					= strval($row['beginProductionTime']);
					(integer) $endProductionTime         					= strval($row['endProductionTime']);
					(integer) $pauseProductionTime         					= strval($row['pauseProductionTime']);

						$sql = "SELECT * FROM ".TBL_PREFIX."jobs WHERE jobID = '".Eve::VarPrepForStore($jobID)."'";
                        $result = $dbconn->Execute($sql);
                        if ($dbconn->ErrorNo() != 0) {
                            Eve::SessionSetVar('errormsg', 'ERROR getting Job Info ; ' . $dbconn->ErrorMsg());
                            return false;
                        }
                        if (!$result->EOF) {
                            $posinfo = $result->GetRowAssoc(2);
                            $sql = "UPDATE ".TBL_PREFIX."jobs
                                    SET    assemblyLineID       						= '" . Eve::VarPrepForStore($assemblyLineID) . "',
                                           containerID          						= '" . Eve::VarPrepForStore($containerID) . "',
                                           installedItemID           					= '" . Eve::VarPrepForStore($installedItemID) . "',
                                           installedItemLocationID 						= '" . Eve::VarPrepForStore($installedItemLocationID) . "',
                                           installedItemQuantity          				= '" . Eve::VarPrepForStore($installedItemQuantity) . "',
                                           installedItemProductivityLevel         		= '" . Eve::VarPrepForStore($installedItemProductivityLevel) . "',
                                           installedItemMaterialLevel          			= '" . Eve::VarPrepForStore($installedItemMaterialLevel) . "',
                                           installedItemLicensedProductionRunsRemaining = '" . Eve::VarPrepForStore($installedItemLicensedProductionRunsRemaining) . "',
                                           outputLocationID      						= '" . Eve::VarPrepForStore($outputLocationID) . "',
                                           installerID        							= '" . Eve::VarPrepForStore($installerID) . "',
                                           runs         								= '" . Eve::VarPrepForStore($runs) ."',
                                           licensedProductionRuns      					= '" . Eve::VarPrepForStore($licensedProductionRuns) ."',
										   installedInSolarSystemID      				= '" . Eve::VarPrepForStore($installedInSolarSystemID) ."',
										   containerLocationID      					= '" . Eve::VarPrepForStore($containerLocationID) ."',
										   materialMultiplier      						= '" . Eve::VarPrepForStore($materialMultiplier) ."',
										   charMaterialMultiplier      					= '" . Eve::VarPrepForStore($charMaterialMultiplier) ."',
										   timeMultiplier      							= '" . Eve::VarPrepForStore($timeMultiplier) ."',
										   charTimeMultiplier      						= '" . Eve::VarPrepForStore($charTimeMultiplier) ."',
										   installedItemTypeID      					= '" . Eve::VarPrepForStore($installedItemTypeID) ."',
										   outputTypeID      							= '" . Eve::VarPrepForStore($outputTypeID) ."',
										   containerTypeID      						= '" . Eve::VarPrepForStore($containerTypeID) ."',
										   installedItemCopy     						= '" . Eve::VarPrepForStore($installedItemCopy) ."',
										   completed      								= '" . Eve::VarPrepForStore($completed) ."',
										   completedSuccessfully      					= '" . Eve::VarPrepForStore($completedSuccessfully) ."',
										   installedItemFlag      						= '" . Eve::VarPrepForStore($installedItemFlag) ."',
										   outputFlag      								= '" . Eve::VarPrepForStore($outputFlag) ."',
										   activityID      								= '" . Eve::VarPrepForStore($activityID) ."',
										   completedStatus      						= '" . Eve::VarPrepForStore($completedStatus) ."',
										   installTime      							= '" . Eve::VarPrepForStore($installTime) ."',
										   beginProductionTime      					= '" . Eve::VarPrepForStore($beginProductionTime) ."',
										   endProductionTime      						= '" . Eve::VarPrepForStore($endProductionTime) ."',
                                           pauseProductionTime       					= '" . Eve::VarPrepForStore($pauseProductionTime) ."'
                                    WHERE  jobID           								= '" . Eve::VarPrepForStore($jobID) . "'";
                            $dbconn->Execute($sql);
                            if ($dbconn->ErrorNo() != 0) {
                                Eve::SessionSetVar('errormsg', 'ERROR Failed to update Job info ; ' . $dbconn->ErrorMsg());
                                return false;
                            }
                            $result->Close();
							
						} else {
						
						$sql = "INSERT INTO ".TBL_PREFIX."jobs (jobID,
                                             assemblyLineID,
                                             containerID,
                                             installedItemID,
                                             installedItemLocationID,
                                             installedItemQuantity,
                                             installedItemProductivityLevel,
                                             installedItemMaterialLevel,
                                             installedItemLicensedProductionRunsRemaining,
                                             outputLocationID,
                                             installerID,
                                             runs,
                                             licensedProductionRuns,
                                             installedInSolarSystemID,
                                             containerLocationID,
                                             materialMultiplier,
                                             charMaterialMultiplier,
                                             timeMultiplier,
                                             charTimeMultiplier,
                                             installedItemTypeID,
                                             outputTypeID,
                                             containerTypeID,
                                             installedItemCopy,
                                             completed,
                                             completedSuccessfully,
                                             installedItemFlag,
                                             outputFlag,
											 activityID,
											 completedStatus,
											 installTime,
											 beginProductionTime,
											 endProductionTime,
                                             pauseProductionTime)
                                    VALUES     ('" . Eve::VarPrepForStore($jobID) . "',
                                                '" . Eve::VarPrepForStore($assemblyLineID) . "',
                                                '" . Eve::VarPrepForStore($containerID) . "',
                                                '" . Eve::VarPrepForStore($installedItemID) . "',
                                                '" . Eve::VarPrepForStore($installedItemLocationID) . "',
                                                '" . Eve::VarPrepForStore($installedItemQuantity) . "',
                                                '" . Eve::VarPrepForStore($installedItemProductivityLevel) . "',
                                                '" . Eve::VarPrepForStore($installedItemMaterialLevel) . "',
                                                '" . Eve::VarPrepForStore($installedItemLicensedProductionRunsRemaining) . "',
                                                '" . Eve::VarPrepForStore($outputLocationID) . "',
												'" . Eve::VarPrepForStore($installerID) . "',
                                                '" . Eve::VarPrepForStore($runs) . "',
                                                '" . Eve::VarPrepForStore($licensedProductionRuns) . "',
                                                '" . Eve::VarPrepForStore($installedInSolarSystemID) . "',
                                                '" . Eve::VarPrepForStore($containerLocationID) . "',
                                                '" . Eve::VarPrepForStore($materialMultiplier) . "',
                                                '" . Eve::VarPrepForStore($charMaterialMultiplier) . "',
                                                '" . Eve::VarPrepForStore($timeMultiplier) . "',
                                                '" . Eve::VarPrepForStore($charTimeMultiplier) . "',
                                                '" . Eve::VarPrepForStore($installedItemTypeID) . "',
                                                '" . Eve::VarPrepForStore($outputTypeID) . "' ,
                                                '" . Eve::VarPrepForStore($containerTypeID) . "',
                                                '" . Eve::VarPrepForStore($installedItemCopy) . "',
												'" . Eve::VarPrepForStore($completed) . "' ,
                                                '" . Eve::VarPrepForStore($completedSuccessfully) . "',
                                                '" . Eve::VarPrepForStore($installedItemFlag) . "',
												'" . Eve::VarPrepForStore($outputFlag) . "' ,
                                                '" . Eve::VarPrepForStore($activityID) . "',
                                                '" . Eve::VarPrepForStore($completedStatus) . "',
												'" . Eve::VarPrepForStore($installTime) . "' ,
                                                '" . Eve::VarPrepForStore($beginProductionTime) . "',
                                                '" . Eve::VarPrepForStore($endProductionTime) . "',
                                                '" . Eve::VarPrepForStore($pauseProductionTime) ."')";
                            $dbconn->Execute($sql);
                            if ($dbconn->ErrorNo() != 0) {
                                Eve::SessionSetVar('errormsg', 'ERROR Failed to Add Job info ; ' . $dbconn->ErrorMsg());
                                return false;
                            }
                            $result->Close();
						}
				}
				$time = time();
                    $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '0', '" . Eve::VarPrepForStore($characterID) . "', '55555', 'EVEAPI XML JOBS API UPDATE', '" . Eve::VarPrepForStore($time) . "')"; //$updateTime
                    $dbconn->Execute($sql);
                    if ($dbconn->ErrorNo() != 0) {
                        Eve::SessionSetVar('errormsg', 'ERROR Failed to update log info ; ' . $dbconn->ErrorMsg());
                        return false;
                    }
			} else {
                Eve::SessionSetVar('errormsg', 'ERROR - Need to wait to pull in API data again. Industrial Jobs should only be pulled every 6 hours.');
                return false;
				} 
		}
		return 1;
	}
    /**
     * POSMGMT::posdetail()
     *
     * @param mixed $itemID
     * @param mixed $userid
     * @param mixed $apikey
     * @param mixed $characterID
     * @return
     */
    function posdetail($itemID, $userid, $apikey, $characterID)
    {

        //$url = 'http://api.eve-online.com/corp/StarbaseDetail.xml.aspx';
		$apiURL = $this->API_ProxySelect();
        $url = '/corp/StarbaseDetail.xml.aspx';

        $version='2';
        $data = array('keyID'      => $userid,
                      'vCode'      => $apikey,
                      'version'     => $version,
                      'itemID'      => $itemID,
                      'characterID' => $characterID);

        //Begins connecting to eve api
        $extensions = get_loaded_extensions();
        $curl = in_array('curl', $extensions);

        if ($curl) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiURL.$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
            $content = curl_exec($ch);
            curl_close($ch);
        }

        try {
            $xml = new SimpleXMLElement($content);
        } catch (Exception $e) {
            Eve::SessionSetVar('errormsg', 'Error: '.$e->getMessage());
            return false;
        }

        foreach ($xml->xpath('//error') as $error) {
            Eve::SessionSetVar('errormsg', 'Error Code: '.$error['code'].'::'.$error.'. User ID: '.$userID.' Character ID: '.$characterID.' Corp: '.$corp);
            return false; //$fail = 1;
        }

        if(defined('POS_CACHE_XML')) {
          //hash for cache
          $unique=md5($userid.$characterID.$itemID);
          //Cache XML
          $cacheName='StarbaseDetail'.$unique;
          $this->API_cacheXML($xml->asXML(), $cacheName);
        }

        foreach ($xml->xpath('//row') as $row) {
            switch ($row['typeID']) {
                case '44':
                    $uranium = strval($row['quantity']);
                    break;
                case '3683':
                    $oxygen = strval($row['quantity']);
                    break;
                case '3689':
                    $mechanical_parts = strval($row['quantity']);
                    break;
				case '4051':
				case '4246':
				case '4247':
				case '4312':
					$fuelblock = strval($row['quantity']);
					break;
                case '9832':
                    $coolant = strval($row['quantity']);
                    break;
                case '9848':
                    $robotics = strval($row['quantity']);
                    break;
                case '16272':
                    $heavy_water = strval($row['quantity']);
                    break;
                case '16273':
                    $ozone = strval($row['quantity']);
                    break;
                case '16274':
                case '17887':
                case '17888':
                case '17889':
                    $isotope = strval($row['quantity']);
                    break;
                case '16275':
                    $strontium = strval($row['quantity']);
                    break;
                case '24592':
                case '24593':
                case '24594':
                case '24595':
                case '24596':
                case '24597':
                    $charters = strval($row['quantity']);
                    break;
            }
        }
        $fuel['isotope']          = ((is_null($isotope))          ? 0 : $isotope);
        $fuel['oxygen']           = ((is_null($oxygen))           ? 0 : $oxygen);
        $fuel['mechanical_parts'] = ((is_null($mechanical_parts)) ? 0 : $mechanical_parts);
        $fuel['coolant']          = ((is_null($coolant))          ? 0 : $coolant);
        $fuel['robotics']         = ((is_null($robotics))         ? 0 : $robotics);
        $fuel['heavy_water']      = ((is_null($heavy_water))      ? 0 : $heavy_water);
        $fuel['uranium']          = ((is_null($uranium))          ? 0 : $uranium);
        $fuel['strontium']        = ((is_null($strontium))        ? 0 : $strontium);
        $fuel['ozone']            = ((is_null($ozone))            ? 0 : $ozone);
        $fuel["charters"]         = ((is_null($charters))         ? 0 : $charters);
		$fuel["fuelblock"]         = ((is_null($fuelblock))         ? 0 : $fuelblock);
        return $fuel;

    }
	
	
	 /**
     * POSMGMT::API_ProxySelect()
     *
     * @param mixed $key
     * @return
     */
	function API_ProxySelect()
	{
		include 'eveconfig/config.php';
		$dbconn =& DBGetConn(true);

        $sql = "SELECT gsetting FROM ".TBL_PREFIX."settings WHERE id = 4";
	
		$result = $dbconn->Execute($sql);
		
		if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

		$apiURL = $result->GetRowAssoc(2);
		if ($apiURL['gsetting'] == 0) {
			$apiURL = "https://api.eveonline.com";
		} else {
			$apiproxy = explode(',',$apiproxy[$apiURL['gsetting']]);
			$apiURL = $apiproxy[1];
		}
		return $apiURL;
	}
	
    /**
     * POSMGMT::API_KeyExists()
     *
     * @param mixed $key
     * @return
     */
    function API_KeyExists($key)
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT *
                FROM   ".TBL_PREFIX."eveapi
                WHERE  apikey = '".Eve::VarPrepForStore($key)."'";

        $result = $dbconn->Execute($sql);

        if (!$result->EOF) {
            $result->Close();
            return true;
        }

        return false;

    }

    /**
     * POSMGMT::API_SaveKey()
     *
     * @param mixed $args
     * @return
     */
    function API_SaveKey($args = array())
    {

        if (!$args) {
            Eve::SessionSetVar('errormsg', 'Error: Empty parameters');
            return false;
        }

        if ($this->API_KeyExists($args['apikey'])) {
            Eve::SessionSetVar('errormsg', 'This key already exists');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "INSERT INTO ".TBL_PREFIX."eveapi
                VALUES     (NULL,
                            '".Eve::VarPrepForStore($args['userID'])."',
                            '".Eve::VarPrepForStore($args['characterID'])."',
                            '".Eve::VarPrepForStore($args['apikey'])."',
                            '".Eve::VarPrepForStore($args['corporationName'])."',
                            '".Eve::VarPrepForStore($args['corporationID'])."',
                            '".Eve::VarPrepForStore($args['allianceName'])."',
                            '".Eve::VarPrepForStore($args['allianceID'])."',
                            '".Eve::VarPrepForStore(time()-21600)."')";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Could not Save Key ; ' . $dbconn->ErrorMsg());
            return false;
        }

        return true;

    }

    function API_cacheXML($xml, $cacheName) {
        if(defined('POS_CACHE_XML') && defined('POS_CACHE_DIR')) {
            // Build cache file path
            $cachePath = realpath(POS_CACHE_DIR .'api');
            $cachePath .= DIRECTORY_SEPARATOR;
            if (!is_dir($cachePath)) {
                $mess = 'XML cache ' . $cachePath . ' is not a directory or does not exist';
                trigger_error($mess, E_USER_WARNING);
                $result = FALSE;
            };
            if (!is_writable($cachePath)) {
                echo $cahcePath.PHP_EOL;
                $mess = 'XML cache directory ' . $cachePath . ' is not writable';
                trigger_error($mess, E_USER_WARNING);
            };
                $cacheFile = $cachePath . $cacheName.'.xml';
            if (is_dir($cachePath) && is_writeable($cachePath)) {
                file_put_contents($cacheFile, $xml);
                return TRUE;
             };
        }

    }

    //Outpost Functions
    /**
     * POSMGMT::GetAllOutpost()
     *
     * @return
     */
    function GetAllOutpost()
    {

        $userinfo = $this->GetUserInfo();

        if (!$userinfo) {
            Eve::SessionSetVar('errormsg', 'User Not Logged!');
            return false;
        }

        $dbconn =& DBGetConn(true);

		$access = explode('.',$userinfo['access']);

        if ( in_array('5', $access) || in_array('6', $access) ) {
            $sql = "SELECT ".TBL_PREFIX."outpost_info.*, ".TBL_PREFIX."user.name, ".TBL_PREFIX."user.corp FROM ".TBL_PREFIX."outpost_info LEFT JOIN ".TBL_PREFIX."user ON ".TBL_PREFIX."outpost_info.owner_id=".TBL_PREFIX."user.eve_id ORDER BY ".TBL_PREFIX."outpost_info.systemID";
        } else {
            $sql = "SELECT ".TBL_PREFIX."outpost_info.*, ".TBL_PREFIX."user.name, ".TBL_PREFIX."user.corp FROM ".TBL_PREFIX."outpost_info LEFT JOIN ".TBL_PREFIX."user ON ".TBL_PREFIX."outpost_info.owner_id=".TBL_PREFIX."user.eve_id WHERE ".TBL_PREFIX."outpost_info.corp = '" . $this->my_escape($_SESSION['corp']) . "' ORDER BY ".TBL_PREFIX."outpost_info.systemID";
        }
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();
//echo '<pre>';print_r($sql); print_r($rows); echo '</pre>';exit;
        return $rows;

    }

    /**
     * POSMGMT::GetAllPosOutpost()
     *
     * @param mixed $outpostID
     * @return
     */
    function GetAllPosOutpost($outpostID)
    {

        $userinfo = $this->GetUserInfo();

        if (!$userinfo) {
            Eve::SessionSetVar('errormsg', 'User Not Logged!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT ".TBL_PREFIX."tower_info.* FROM ".TBL_PREFIX."tower_info WHERE outpost_id = '" . $outpostID . "' ORDER BY outpost_id";
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();
//echo '<pre>';print_r($rows); echo '</pre>';exit;
        return $rows;

    }

    /**
     * POSMGMT::outpostUptimeCalc()
     *
     * @param mixed $outpostID
     * @return
     */
    function outpostUptimeCalc($outpostID)
    {

        $userinfo = $this->GetUserInfo();

        if (!$userinfo) {
            Eve::SessionSetVar('errormsg', 'User Not Logged!');
            return false;
        }

        $dbconn =& DBGetConn(true);

        //Initialize needed veribles
        (int) $total_req_helium_iso      = 0;
        (int) $total_req_hydrogen_iso      = 0;
        (int) $total_req_oyxgen_iso      = 0;
        (int) $total_req_helium_iso         = 0;
        (int) $total_req_oxygen          = 0;
        (int) $total_req_mechanical_parts= 0;
        (int) $total_req_coolant         = 0;
        (int) $total_req_robotics        = 0;
        (int) $total_req_uranium         = 0;
        (int) $total_req_ozone           = 0;
        (int) $total_req_heavy_water     = 0;
        (int) $total_req_strontium       = 0;
        (int) $total_req_charters        = 0;
        (int) $charters_needed       = 0;

        // Get info about the outpost, may move this to independent function
        $sql = "SELECT ".TBL_PREFIX."outpost_info.* FROM ".TBL_PREFIX."outpost_info WHERE outpost_id = '".$outpostID."';";
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);

        (int)$current_heilum_iso = $row['heisotope'];
        (int)$current_hydrogen_iso = $row['hyisotope'];
        (int)$current_oxygen_iso = $row['oxisotope'];
        (int)$current_nitrogen_iso = $row['niisotope'];
        (int) $current_oxygen = $row['oxygen'];
        (int) $current_mechanical_parts = $row['mechanical_parts'];
        (int) $current_coolant = $row['coolant'];
        (int) $current_robotics = $row['robotics'];
        (int) $current_uranium = $row['uranium'];
        (int) $current_ozone = $row['ozone'];
        (int) $current_heavy_water = $row['heavy_water'];
        (int) $current_strontium = $row['strontium'];
        (int) $current_charters = $row['charters'];
        (string) $outpost_name = $row['outpost_name'];
        (int)$systemID=$row['systemID'];

        //End of Outpost information

        $rows = $this->getAllPosOutpost($outpostID);

        foreach($rows as $pos) {
            $pos_id      = $pos['pos_id'];
            $pos_size    = $pos['pos_size'];
            $pos_race    = $pos['pos_race'];
            $pos_typeID  = $pos['typeID'];
            $systemID    = $pos['systemID'];
            $allianceID  = $pos['allianceid'];
            $sovereignty = $this->getSovereignty($systemID);

            $required_isotope         =0;
            $required_oxygen          =0;
            $required_mechanical_parts=0;
            $required_coolant         =0;
            $required_robotics        =0;
            $required_uranium         =0;
            $required_ozone           =0;
            $required_heavy_water     =0;
            $required_strontium       =0;
            $required_charters        =0;
            $race_isotope             =0;
            $total_pg                 =0;
            $total_cpu                =0;


            //Begin Sovereignty Code
            $database = $this->selectstaticdb($sovereignty, $systemID, $allianceID);
            //End New Sovereignty Code

            // Database Selection SQL
            $sql = "SELECT * FROM " . $database . " WHERE typeID = '" . $pos_typeID . "'";

            $result = $dbconn->Execute($sql);

            $row2 = $result->GetRowAssoc(2);

            $result->Close();


            if ($row2) {
                $required_isotope           = $row2['isotopes'];
                $required_oxygen            = $row2['oxygen'];
                $required_mechanical_parts  = $row2['mechanical_parts'];
                $required_coolant           = $row2['coolant'];
                $required_robotics          = $row2['robotics'];
                $required_uranium           = $row2['uranium'];
                $required_ozone             = $row2['ozone'];
                $required_heavy_water       = $row2['heavy_water'];
                $required_strontium         = $row2['strontium'];
                $required_charters          = $charters_needed?1:0;
                $race_isotope               = $row2['race_isotope'];
                $total_pg                   = $row2['pg'];
                $total_cpu                  = $row2['cpu'];

                if($race_isotope=='Helium') {
                   $total_req_helium_iso=$total_req_helium_iso+$required_isotope;
                }
                if($race_isotope=='Hydrogen') {
                    $total_req_hydrogen_iso=$total_req_hydrogen_iso+$required_isotope;
                }
                if($race_isotope=='Oxygen') {
                    $total_req_oyxgen_iso      = $total_req_oyxgen_iso+$required_isotope;
                }
                if($race_isotope=='Nitrogen') {
                    $total_req_nitrogen_iso         =$total_req_nitrogen_iso+$required_isotope;
                }

                $total_req_oxygen          = $total_req_oxygen+$required_oxygen;
                $total_req_mechanical_parts= $total_req_mechanical_parts+$required_mechanical_parts;
                $total_req_coolant         = $total_req_coolant+$required_coolant;
                $total_req_robotics        = $total_req_robotics+$required_robotics;
                $total_req_uranium        = $total_req_uranium+$required_uranium;
                $total_req_ozone           = $total_req_ozone+$required_ozone;
                $total_req_heavy_water     = $total_req_heavy_water+$required_heavy_water;
                $total_req_strontium       = $total_req_strontium+$required_strontium;
                $total_req_charters        = $total_req_charters+$required_charters;
                $total_overall_pg          = $total_pg+$total_overall_pg;
                $total_overall_cpu         = $total_cpu+$total_overall_cpu;

                $sql = "SELECT * FROM ".TBL_PREFIX."pos_structures ps JOIN ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id WHERE ps.pos_id = '" . Eve::VarPrepForStore($pos_id) . "' AND ps.online=1";

                $result = $dbconn->Execute($sql);

                if (!$result->EOF) {
                    $current_pg   = 0;
                    $current_cpu  = 0;
                    for(; !$result->EOF; $result->MoveNext()) {
                        $row3 = $result->GetRowAssoc(2);
                        $current_pg  = $current_pg + $row3['pg'];
                        $current_cpu = $current_cpu + $row3['cpu'];
                    }
                } else {
                    $current_pg = 0;
                    $current_cpu = 0;
                }
                $total_current_pg=$total_current_pg+$current_pg;
                $total_current_cpu=$current_cpu+$total_current_cpu;
            } //IF $row2
        } //foreach $rows as $pos

        $hoursago = $this->hoursago($outpostID, '4');


        $calc_helium_iso        = (round($current_heilum_iso       / $total_req_helium_iso));
        $calc_hydrogen_iso      = (round($current_hydrogen_iso     / $total_req_hydrogen_iso));
        $calc_oyxgen_iso        = (round($current_oyxgen_iso       / $total_req_oyxgen_iso));
        $calc_nitrogen_iso      = (round($current_nitrogen_iso     / $total_req_nitrogen_iso));
        $calc_oxygen            = (round($current_oxygen           / $total_req_oxygen));
        $calc_mechanical_parts  = (round($current_mechanical_parts / $total_req_mechanical_parts));
        $calc_coolant           = (round($current_coolant          / $total_req_coolant));
        $calc_robotics          = (round($current_robotics         / $total_req_robotics));
        $calc_uranium           = (round($current_uranium          / $total_req_uranium));
        $calc_strontium         = (round($current_strontium        / $total_req_strontium));
        $calc_charters          = (($required_charters) ? (floor($current_charters / $total_req_charters)) : 0);


        if (($total_current_pg > 0 && $current_ozone > 0)) {
            $calc_ozone = (floor($current_ozone / (ceil(($total_current_pg / $total_overall_pg) * $total_req_ozone))));
            $total_needed_ozone=ceil((($total_current_pg/$total_overall_pg)*$total_req_ozone));
        } else {
            $calc_ozone = 0;
			$total_needed_ozone = 0;
        }


        if (($total_current_cpu > 0 && $current_heavy_water > 0)) {
            $calc_heavy_water = (floor($current_heavy_water / (ceil(($total_current_cpu / $total_overall_cpu) * $total_req_heavy_water))));
            $total_needed_heavy_water=ceil(($total_current_cpu/$total_overall_cpu)*$total_req_heavy_water);
        } else {
            $calc_heavy_water = 0;
			$total_needed_heavy_water = 0;
        }


        $calc_isotope          = (($calc_isotope           <= 0) ? 0 : $calc_isotope);
        $calc_oxygen           = (($calc_oxygen            <= 0) ? 0 : $calc_oxygen);
        $calc_mechanical_parts = (($calc_mechanical_parts  <= 0) ? 0 : $calc_mechanical_parts);
        $calc_coolant          = (($calc_coolant           <= 0) ? 0 : $calc_coolant);
        $calc_robotics         = (($calc_robotics          <= 0) ? 0 : $calc_robotics);
        $calc_uranium          = (($calc_uranium           <= 0) ? 0 : $calc_uranium);
        $calc_ozone            = (($calc_ozone             <= 0) ? 0 : $calc_ozone);
        $calc_heavy_water      = (($calc_heavy_water       <= 0) ? 0 : $calc_heavy_water);
        $calc_charters         = (($calc_charters          <= 0) ? 0 : $calc_charters);

        $uptimecalc['required_ozone']       = $total_req_ozone;
        $uptimecalc['required_heavy_water'] = $total_req_heavy_water;
        $uptimecalc['total_needed_heavy_water']=$total_needed_heavy_water;
        $uptimecalc['total_needed_ozone']=$total_needed_ozone;
        $uptimecalc['req_heium_iso']=$total_req_helium_iso;
        $uptimecalc['req_hydrogen_iso']=$total_req_hydrogen_iso;
        $uptimecalc['req_oxygen_iso']=$total_req_oxygen_iso;
        $uptimecalc['req_nitrogen_iso']=$total_req_nitrogen_iso;

        if($total_req_helium_iso > 0) {
            $uptimecalc['heisotope']=$calc_helium_iso;
        }
        if($total_req_hydrogen_iso > 0) {
            $uptimecalc['hyisotope']=$calc_hydrogen_iso;
        }
        if($total_req_oyxgen_iso>0) {
            $uptimecalc['oxisotope']=$calc_oxygen_iso;
        }
        if($total_req_nitrogen_iso>0) {
            $uptimecalc['niisotope']=$calc_nitrogen_iso;
        }
        $uptimecalc['oxygen']               = $calc_oxygen;
        $uptimecalc['mechanical_parts']     = $calc_mechanical_parts;
        $uptimecalc['coolant']              = $calc_coolant;
        $uptimecalc['robotics']             = $calc_robotics;
        $uptimecalc['uranium']              = $calc_uranium;
        $uptimecalc['strontium']            = $calc_strontium;
        $uptimecalc['ozone']                = $calc_ozone;
        $uptimecalc['heavy_water']          = $calc_heavy_water;
        $uptimecalc['charters']             = (($charters_needed) ? $calc_charters : false);

        return $uptimecalc;

    }

    /**
     * POSMGMT::outpost_online()
     *
     * @param mixed $fuel
     * @return
     */
    function outpost_online($fuel)
    {
        if (count($fuel) != 0) {
            $heisotope        = $fuel['heisotope'];
            $hyisotope        = $fuel['hyisotope'];
            $oxisotope        = $fuel['oxisotope'];
            $niisotope        = $fuel['niisotope'];
            $oxygen           = $fuel['oxygen'];
            $mechanical_parts = $fuel['mechanical_parts'];
            $coolant          = $fuel['coolant'];
            $robotics         = $fuel['robotics'];
            $uranium          = $fuel['uranium'];
            $ozone            = $fuel['ozone'];
            $heavy_water      = $fuel['heavy_water'];
            $charters         = $fuel['charters'];
            $strontium        = $fuel['strontium'];
            $fuel_array       = array($oxygen, $mechanical_parts, $coolant, $robotics, $uranium);
            if($fuel['req_heilium_iso']>0) {
                $fuel_array[] = $heisotope;
            }
            if($fuel['req_hydrogen_iso']>0) {
                $fuel_array[] = $hyisotope;
            }
            if($fuel['req_oxygen_iso']>0) {
                $fuel_array[] = $oxisotope;
            }
            if($fuel['req_nitrogen_iso']>0) {
                $fuel_array[] = $niisotope;
            }
            //CHECKS TO SEE IF ANY CPU IS USED
            if($fuel['required_heavy water']>0) {
                $fuel_array[] = $heavy_water;
            }
            //CHECKS TO SEE IF ANYPG IS USED
            if($fuel['required_ozone']>0) {
                $fuel_array[] = $ozone;
            }
            //if ($charters !== false) {
              //  $fuel_array[] = $charters;
            //}
            array_multisort($fuel_array);
            $online = $fuel_array[0];
            return $online;
        }
    }

    /**
     * POSMGMT::GetOutpostInfo()
     *
     * @param mixed $outpost_id
     * @return
     */
    function GetOutpostInfo($outpost_id)
    {

        if (!$outpost_id || !is_numeric($outpost_id)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT * FROM `".TBL_PREFIX."outpost_info` WHERE `outpost_id`=".Eve::VarPrepForStore($outpost_id)." LIMIT 1 ";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) {
            return false;
        }

        $outpostinfo = $result->GetRowAssoc(2);

        $result->Close();

        return $outpostinfo;

    }

    /**
     * POSMGMT::UpdateOutpostFuel()
     *
     * @param mixed $args
     * @return
     */
    function UpdateOutpostFuel($args)
    {

        if (!$args['outpost_id'] || !is_numeric($args['outpost_id'])) {
            return false;
        }

        $fuel = array();

        foreach($args as $key => $value) {
            $fuel[$key] = Eve::VarPrepForStore($value);
        }

        /*
        $tower      = $this->GetTowerInfo($pos_id);
        $lastupdate = $this->GetLastPosUpdate($pos_id);
        */
        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."outpost_info
                SET    heisotope        = '".$fuel['heisotope']."',
                       hyisotope        = '".$fuel['hyisotope']."',
                       oxisotope        = '".$fuel['oxisotope']."',
                       niisotope        = '".$fuel['niisotope']."',
                       oxygen           = '".$fuel['oxygen']."',
                       mechanical_parts = '".$fuel['mechanical_parts']."',
                       coolant          = '".$fuel['coolant']."',
                       robotics         = '".$fuel['robotics']."',
                       uranium          = '".$fuel['uranium']."',
                       ozone            = '".$fuel['ozone']."',
                       heavy_water      = '".$fuel['heavy_water']."',
                       charters         = '".$fuel['charters']."',
                       strontium        = '".$fuel['strontium']."'
                WHERE  outpost_id       = '".$fuel['outpost_id']."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $time = time();
        $sql = "INSERT INTO ".TBL_PREFIX."update_log (id,
                                        eve_id,
                                        type_id,
                                        type,
                                        action,
                                        datetime)
                VALUES                 (NULL,
                                        0,
                                        '" . $fuel['outpost_id'] . "',
                                        '4',
                                        'Update Outpost Fuel',
                                        '" . Eve::VarPrepForStore($time) . "')";
        $dbconn->Execute($sql);

        return true;

    }

    /**
     * POSMGMT::GetLastOutpostUpdate()
     *
     * @param mixed $outpost_id
     * @return
     */
    function GetLastOutpostUpdate($outpost_id)
    {

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."update_log
                WHERE    type_id = '" . $outpost_id . "'
                AND      type    = '4'
                ORDER BY id DESC LIMIT 1";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $row = $result->GetRowAssoc(2);

        $result->Close();

        return $row;

    }

    /**
     * POSMGMT::outpostRequired()
     *
     * @param mixed $outpostID
     * @return
     */
    function outpostRequired($outpostID)
    {
        $dbconn =& DBGetConn(true);

        //Initialize needed veribles
        (int) $total_req_helium_iso      = 0;
        (int) $total_req_hydrogen_iso    = 0;
        (int) $total_req_oyxgen_iso      = 0;
        (int) $total_req_nitrogen_iso      = 0;
        (int) $total_req_oxygen          = 0;
        (int) $total_req_mechanical_parts= 0;
        (int) $total_req_coolant         = 0;
        (int) $total_req_robotics        = 0;
        (int) $total_req_uranium         = 0;
        (int) $total_req_ozone           = 0;
        (int) $total_req_heavy_water     = 0;
        (int) $total_req_strontium       = 0;
        (int) $total_req_charters        = 0;
        (int) $charters_needed           = 0;

        // Get info about the outpost, may move this to independent function
        $sql = "SELECT ".TBL_PREFIX."outpost_info.* FROM ".TBL_PREFIX."outpost_info WHERE outpost_id = '".$outpostID."';";
        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }
        $row = $result->GetRowAssoc(2);

        (int)$current_heilum_iso = $row['heisotope'];
        (int)$current_hydrogen_iso = $row['hyisotope'];
        (int)$current_oxygen_iso = $row['oxisotope'];
        (int)$current_nitrogen_iso = $row['niisotope'];
        (int) $current_oxygen = $row['oxygen'];
        (int) $current_mechanical_parts = $row['mechanical_parts'];
        (int) $current_coolant = $row['coolant'];
        (int) $current_robotics = $row['robotics'];
        (int) $current_uranium = $row['uranium'];
        (int) $current_ozone = $row['ozone'];
        (int) $current_heavy_water = $row['heavy_water'];
        (int) $current_strontium = $row['strontium'];
        (int) $current_charters = $row['charters'];
        (string) $outpost_name = $row['outpost_name'];
        (int)$systemID=$row['systemID'];

        //End of Outpost information
        $rows = $this->getAllPosOutpost($outpostID);

        foreach($rows as $pos) {
            $pos_id      = $pos['pos_id'];
            $pos_size    = $pos['pos_size'];
            $pos_race    = $pos['pos_race'];
            $pos_typeID  = $pos['typeID'];
            $systemID    = $pos['systemID'];
            $allianceID  = $pos['allianceid'];
            $sovereignty = $this->getSovereignty($systemID);

            $required_isotope         = 0;
            $required_oxygen          = 0;
            $required_mechanical_parts= 0;
            $required_coolant         = 0;
            $required_robotics        = 0;
            $required_uranium         = 0;
            $required_ozone           = 0;
            $required_heavy_water     = 0;
            $required_strontium       = 0;
            $required_charters        = 0;
            $race_isotope             = 0;
            $total_pg                 = 0;
            $total_cpu                = 0;


            //Begin Sovereignty Code
            $database = $this->selectstaticdb($sovereignty, $systemID, $allianceID);
            //End New Sovereignty Code

            // Database Selection SQL
            $sql = "SELECT * FROM " . $database . " WHERE typeID = '" . $pos_typeID . "'";

            $result = $dbconn->Execute($sql);

            $row2 = $result->GetRowAssoc(2);

            $result->Close();


            if ($row2) {
                $required_isotope           = $row2['isotopes'];
                $required_oxygen            = $row2['oxygen'];
                $required_mechanical_parts  = $row2['mechanical_parts'];
                $required_coolant           = $row2['coolant'];
                $required_robotics          = $row2['robotics'];
                $required_uranium           = $row2['uranium'];
                $required_ozone             = $row2['ozone'];
                $required_heavy_water       = $row2['heavy_water'];
                $required_strontium         = $row2['strontium'];
                $required_charters          = $charters_needed?1:0;
                $race_isotope               = $row2['race_isotope'];
                $total_pg                   = $row2['pg'];
                $total_cpu                  = $row2['cpu'];

                if($race_isotope=='Helium') {
                    $total_req_helium_iso   = $total_req_helium_iso+$required_isotope;
                }
                if($race_isotope=='Hydrogen') {
                    $total_req_hydrogen_iso = $total_req_hydrogen_iso+$required_isotope;
                }
                if($race_isotope=='Oxygen') {
                    $total_req_oyxgen_iso   = $total_req_oyxgen_iso+$required_isotope;
                }
                if($race_isotope=='Nitrogen') {
                    $total_req_nitrogen_iso = $total_req_nitrogen_iso+$required_isotope;
                }

                $total_req_oxygen           = $total_req_oxygen+$required_oxygen;
                $total_req_mechanical_parts = $total_req_mechanical_parts+$required_mechanical_parts;
                $total_req_coolant          = $total_req_coolant+$required_coolant;
                $total_req_robotics         = $total_req_robotics+$required_robotics;
                $total_req_uranium          = $total_req_uranium+$required_uranium;
                $total_req_ozone            = $total_req_ozone+$required_ozone;
                $total_req_heavy_water      = $total_req_heavy_water+$required_heavy_water;
                $total_req_strontium        = $total_req_strontium+$required_strontium;
                $total_req_charters         = $total_req_charters+$required_charters;
                //$charters_needed       = 0;

                $sql = "SELECT * FROM ".TBL_PREFIX."pos_structures ps JOIN ".TBL_PREFIX."structure_static ss ON ps.type_id = ss.id WHERE ps.pos_id = '" . Eve::VarPrepForStore($pos_id) . "' AND ps.online=1";

                $result = $dbconn->Execute($sql);

                if (!$result->EOF) {
                    $current_pg   = 0;
                    $current_cpu  = 0;
                    for(; !$result->EOF; $result->MoveNext()) {
                        $row3 = $result->GetRowAssoc(2);
                        $current_pg  = $current_pg + $row3['pg'];
                        $current_cpu = $current_cpu + $row3['cpu'];

                    }
                } else {
                    $current_pg = 0;
                    $current_cpu = 0;
                }
                $total_current_pg=$total_current_pg+$current_pg;
                $total_current_cpu=$current_cpu+$total_current_cpu;
            }

        }

        $outpost['required_ozone']       = $total_current_pg;
        $outpost['required_heavy_water'] = $total_current_cpu;
        $outpost['heisotope']            = $total_req_helium_iso;
        $outpost['hyisotope']            = $total_req_hydrogen_iso;
        $outpost['oxisotope']            = $total_req_oyxgen_iso;
        $outpost['niisotope']            = $total_req_nitrogen_iso;
        $outpost['oxygen']               = $total_req_oxygen;
        $outpost['mechanical_parts']     = $total_req_mechanical_parts;
        $outpost['coolant']              = $total_req_coolant;
        $outpost['robotics']             = $total_req_robotics;
        $outpost['uranium']              = $total_req_uranium;
        $outpost['strontium']            = $total_req_strontium;
        $outpost['charters']             = $total_req_charters;
        return $outpost;
    }

    /**
     * POSMGMT::AddNewOutpost()
     *
     * @param mixed $args
     * @return
     */
    function AddNewOutpost($args = array())
    {

        if (!$args) {
            return false;
        }
        $outpost_name    = Eve::VarPrepForStore($args['outpost_name']);
        $corp            = Eve::VarPrepForStore($args['corp']);
        $system          = Eve::VarPrepForStore($args['system']);
        $uranium         = Eve::VarPrepForStore($args['uranium']);
        $oxygen          = Eve::VarPrepForStore($args['oxygen']);
        $mechanical_parts= Eve::VarPrepForStore($args['mechanical_parts']);
        $coolant         = Eve::VarPrepForStore($args['coolant']);
        $robotics        = Eve::VarPrepForStore($args['robotics']);
        $heisotope       = Eve::VarPrepForStore($args['heisotope']);
        $hyisotope       = Eve::VarPrepForStore($args['hyisotope']);
        $oxisotope       = Eve::VarPrepForStore($args['oxisotope']);
        $niisotope       = Eve::VarPrepForStore($args['niisotope']);
        $ozone           = Eve::VarPrepForStore($args['ozone']);
        $heavy_water     = Eve::VarPrepForStore($args['heavy_water']);
        $strontium       = Eve::VarPrepForStore($args['strontium']);
        $struct_amount   = Eve::VarPrepForStore($args['struct_amount']);
        $charters        = Eve::VarPrepForStore($args['charters']);
        $owner_id        = NULL;
        $systemName      = Eve::VarPrepForStore($args['systemID']);

        $dbconn =& DBGetConn(true);
        //echo"<pre>";print_r($args);echo"</pre>";exit;
        $sql = "INSERT INTO `".TBL_PREFIX."outpost_info` (`outpost_name`,
                                                          `corp`,
                                                          `heisotope`,
                                                          `hyisotope`,
                                                          `oxisotope`,
                                                          `niisotope`,
                                                          `oxygen`,
                                                          `mechanical_parts`,
                                                          `coolant`,
                                                          `robotics`,
                                                          `uranium`,
                                                          `ozone`,
                                                          `heavy_water`,
                                                          `charters`,
                                                          `strontium`,
                                                          `systemID`,
                                                          `owner_id`,
                                                          `outpost_status`)
                                                  VALUES ('".$outpost_name."',
                                                          '".$corp."',
                                                          '".$heisotope."',
                                                          '".$hyisotope."',
                                                          '".$oxisotope."',
                                                          '".$niisotope."',
                                                          '".$oxygen."',
                                                          '".$mechanical_parts."',
                                                          '".$coolant."',
                                                          '".$robotics."',
                                                          '".$uranium."',
                                                          '".$ozone."',
                                                          '".$heavy_water."',
                                                          '".$charters."',
                                                          '".$strontium."',
                                                          '".$systemName."',
                                                          '".$owner_id."',
                                                          '1');";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Add Outpost: ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $outpost_id = $dbconn->PO_Insert_ID(TBL_PREFIX.'outpost_info', 'outpost_id');

        $time = time();
        $sql = "INSERT INTO ".TBL_PREFIX."update_log VALUES (NULL, '', '" . $outpost_id . "', '4', 'Outpost POS', '" . $time . "')";
        $dbconn->Execute($sql);
        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', 'Outpost POS: ' . $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return $outpost_id;
    }

    //Outpost Functions ends

    // Modules stuff
    /**
     * POSMGMT::GetModList()
     *
     * @return
     */
    function GetModList()
    {

        $actives = $this->GetActiveMods();
        foreach ($actives as $mod) {
            $mods_active[$mod['modname']] = $mod;
        }

        $mods = array();

        $handle = opendir('mods');
        while ($file = readdir($handle)) {
            if ($file != '.' && $file != '..' && is_dir('mods/'.$file) && $file != '.svn') {

                $moduleinfo = $this->GetModuleInfo(array('modname' => $file));

                if (!$moduleinfo) {


                    $module = array('modname'  => $file,
                                    'modstate' => ((in_array($file, $mods_active) ? 1 : 0)),
                                    'install'  => ((file_exists('mods/'.$file.'/install.php')) ? 1 : 0),
                                    'admin'    => ((file_exists('mods/'.$file.'/admin.php'))   ? 1 : 0),
                                    'user'     => ((file_exists('mods/'.$file.'/user.php'))    ? 1 : 0),
                                    'state'    => ((isset($mods_active[$file]['modstate'])) ? $mods_active[$file]['modstate'] : 0));

                    $this->AddModule($module);

                    $mods[] = $module;

                } else {
                    $mods[] = $moduleinfo;
                }
            }
        }
        closedir($handle);
        asort($mods);

        //echo '<pre>';print_r($mods);echo '</pre>';exit;
        return $mods;

    }

    /**
     * POSMGMT::AddModule()
     *
     * @param mixed $args
     * @return
     */
    function AddModule($args = array())
    {

        if (!$args['modname']) {
            Eve::SessionSetVar('errormsg', 'No name for this module');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "INSERT INTO ".TBL_PREFIX."modules (modid,
                                                   modname,
                                                   moddisplayname,
                                                   modadmin_capable,
                                                   moduser_capable,
                                                   modstate)
                VALUES                            (NULL,
                                                   '" . Eve::VarPrepForStore($args['modname']) . "',
                                                   '" . Eve::VarPrepForStore($args['modname']) . "',
                                                   '" . Eve::VarPrepForStore($args['admin']) . "',
                                                   '" . Eve::VarPrepForStore($args['user']) . "',
                                                   '0')";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }

    /**
     * POSMGMT::GetModuleInfo()
     *
     * @param mixed $args
     * @return
     */
    function GetModuleInfo($args)
    {
        if (!isset($args['modname']) && !isset($args['modid'])) {
            Eve::SessionSetVar('errormsg', 'Missing argument');
            return false;
        }

        if ($args['modname']) {
            $where = "WHERE modname = '".Eve::VarPrepForStore($args['modname'])."'";
        } else {
            $where = "WHERE modid = '".Eve::VarPrepForStore($args['modid'])."'";
        }

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."modules
                $where";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        if ($result->EOF) { return false; }

        $module = $result->GetRowAssoc(2);

        $result->Close();

        $module['install'] = ((file_exists('mods/'.$module['modname'].'/install.php')) ? 1 : 0);

        return $module;
    }

    /**
     * POSMGMT::ChangeModState()
     *
     * @param mixed $args
     * @return
     */
    function ChangeModState($args = array())
    {

        if (!isset($args['modname'])) {
            Eve::SessionSetVar('errormsg', 'Missing Argument');
            return false;
        }

        $module = $this->GetModuleInfo($args);

        if (!$module) {
            Eve::SessionSetVar('errormsg', 'Module not in table');
            return false;
        }

        $dbconn =& DBGetConn(true);

        $sql = "UPDATE ".TBL_PREFIX."modules
                SET    modstate = '".$args['modstate']."'
                WHERE  modname  = '".$args['modname']."'";

        $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;

    }

    /**
     * POSMGMT::GetActiveMods()
     *
     * @return
     */
    function GetActiveMods()
    {
        $dbconn =& DBGetConn(true);

        $sql = "SELECT   *
                FROM     ".TBL_PREFIX."modules
                WHERE    modstate = '2'
                ORDER BY modname  ASC";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $rows = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $rows[] = $result->GetRowAssoc(2);
        }

        $result->Close();

        return $rows;
    }

    /**
     * POSMGMT::ModuleGetVar()
     *
     * @param string $modname
     * @param string $name
     * @param mixed $default
     * @return
     */
    function ModuleGetVar($modname = '', $name = '', $default = null)
    {

        if (empty($name)) {
            return null;
        }

        //static $kbconfig;

        if (isset($GLOBALS['modconfig'][$modname][$name])) {
            $var = $GLOBALS['modconfig'][$modname][$name];
        } else {
            $vars = $this->ModuleLoadVars($this->modconfig_);
            if (isset($vars[$modname][$name])) {
                $var = $vars[$modname][$name];
                $GLOBALS['modconfig'][$modname][$name] = ((is_array(unserialize($var))) ? unserialize($var) : $var);
            }
        }

        if ($var) {
            return $var;
        }

        return $default;

    }

    /**
     * POSMGMT::ModuleSetVar()
     *
     * @param string $modname
     * @param string $name
     * @param string $value
     * @return
     */
    function ModuleSetVar($modname = '', $name = '', $value='')
    {

        $modname = isset($modname) ? (string)$modname : '';
        $name    = isset($name)    ? (string)$name    : '';

        // The database parameter are not allowed to change
        if (empty($name) || empty($modname)) {
            return false;
        }

        $dbconn =& DBGetConn(true);

        if (!isset($GLOBALS['modconfig'][$modname][$name])) {
            $sql = "INSERT INTO ".TBL_PREFIX."module_vars
                               (modname,
                                name,
                                value)
                    VALUES     ('".Eve::VarPrepForStore($modname)."',
                                '".Eve::VarPrepForStore($name)."',
                                '".Eve::VarPrepForStore(((is_array($value)) ? serialize($value) : $value))."')";
        } else {
            $sql = "UPDATE ".TBL_PREFIX."module_vars
                    SET    value   = '".Eve::VarPrepForStore(((is_array($value)) ? serialize($value) : $value))."'
                    WHERE  name    = '".Eve::VarPrepForStore($name)."'
                    AND    modname = '".Eve::VarPrepForStore($modname)."'";
        }

        $dbconn->Execute($sql);
        if ($dbconn->ErrorNo()!=0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        $GLOBALS['modconfig'][$modname][$name] = $value;

        return true;

    }

    /**
     * POSMGMT::ModuleDelVar()
     *
     * @param string $modname
     * @param string $name
     * @return
     */
    function ModuleDelVar($modname = '', $name = '')
    {
        $modname = isset($modname) ? (string)$modname : '';
        $name    = isset($name)    ? (string)$name    : '';

        if (empty($name) || empty($modname)) {
            return false;
        }
        $dbconn =& DBGetConn(true);

        if (isset($GLOBALS['modconfig'][$modname][$name])) {
            unset($GLOBALS['modconfig'][$modname][$name]);
        }

        $sql = "DELETE FROM ".TBL_PREFIX."module_vars
                WHERE  name    = '".Eve::VarPrepForStore($name)."'
                AND    modname = '".Eve::VarPrepForStore($modname)."'";

        $dbconn->Execute($sql);
        if ($dbconn->ErrorNo()!=0) {
            Eve::SessionSetVar('errormsg', $dbconn->ErrorMsg() . $sql);
            return false;
        }

        return true;
    }

    /**
     * POSMGMT::ModuleLoadVars()
     *
     * @return
     */
    function ModuleLoadVars()
    {

        unset($GLOBALS['modconfig']);

        $dbconn =& DBGetConn(true);

        $sql = "SELECT   modname,
                         name,
                         value
                FROM     ".TBL_PREFIX."module_vars";

        $result = $dbconn->Execute($sql);

        if ($dbconn->ErrorNo() != 0) {
            echo $dbconn->ErrorMsg() . (($this->debug) ? '<br />' . $sql : '');
            return false;
        }

        //$values = array();
        $GLOBALS['modconfig'] = array();

        for (; !$result->EOF; $result->MoveNext()) {

            list($modname, $key, $value) = $result->fields;

            $GLOBALS['modconfig'][$modname][$key] = ((is_array(unserialize($value))) ? unserialize($value) : $value);

        }

        $result->Close();

        return $GLOBALS['modconfig'];
    }

    /**
     * POSMGMT::ModuleVarsToTpl()
     *
     * @param string $name
     * @return
     */
    function ModuleVarsToTpl($name='')
    {

        $vars = array();
        /*
        $exclusion = array('dbtype', 'dbhost', 'dbuname', 'dbpass', 'dbname',
                           'system', 'prefix', 'encoded', 'post_password', 'admin_pass', 'superadmin_pass');
        */
        $this->ModuleLoadVars();
        foreach($GLOBALS['modconfig'] as $modname => $var)
        {
            $vars[$modname][$name] = $var[$name];
        }

        return $vars;
    }

	
}

/**
 * fixmeplease()
 *
 * @param mixed $text
 * @return
 */
function fixmeplease($text)
{
    $pos = strpos($text, "#");
    if ($pos === false) {
        return $text;
    } else {
        $fix = explode("#", $text);
        return $fix[count($fix)-1];
    }
}
?>