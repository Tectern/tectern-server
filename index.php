<?php
include_once 'lib/Epi.php';
Epi::setPath('base', 'lib');
Epi::init('api','route','database');
EpiDatabase::employ('mysql','epiTest','localhost','root','developer');

getApi()->get('/version.json', array('Api','version'), EpiApi::external);
getApi()->post('/authenticate.json', array('Api','authenticate'), EpiApi::external);
getApi()->post('/user.json', array('Api','user'), EpiApi::external);
getApi()->post('/lectern_pref.json', array('Api','lectern_pref'), EpiApi::external);
getApi()->post('/lectern_pref_by_user.json', array('Api','lectern_pref_by_user'), EpiApi::external);

getRoute()->get('/', array('Site','index'));
getRoute()->get('/dbTest', array('Site','dbTest'));
getRoute()->run(); 

class Site
{
	public static function index()
	{
		echo '<h1>tectern-server is up.</h1>';
		echo '<a href="dbTest">Test DB Connection</a>';
	}

	public static function dbTest()
	{
		$users = getDatabase()->all('SELECT users.*,lectern_prefs.height FROM users JOIN lectern_prefs ON users.id=lectern_prefs.user_id');
		echo "<h2>All users and height preferences:</h2><ol>";
		foreach($users as $key => $user)
		{
			echo "<li>User {$user['id']} - {$user['last']}, {$user['first']} - {$user['cuid']} - height: {$user['height']}</li>";
		}
		echo "</ol>";
	}
}

class Api
{
	/* 
	 * GET -- responds with JSON versioning info
	 * params: none
	 * return: JSON versioning info
	 */
	public static function version()
	{
		return json_encode("1.0");
	}

	/* 
	 * POST -- responds with true/false auth 
	 * params: username, password
	 * return: JSON true/false auth value
	 */
	public static function authenticate()
	{
		//stubbed
		return json_encode($_POST);
	}

	/* 
	 * POST -- responds with user info 
	 * params: id
	 * return: JSON user object
	 */
	public static function user()
	{
		$user = getDatabase()->one('SELECT * FROM users WHERE id=:id',array(':id'=>$_POST['id']));
		return json_encode($user);
	}

	/* 
	 * POST -- responds with lectern_prefs info 
	 * params: id
	 * return: JSON lectern_pref object
	 */
	public static function lectern_pref()
	{
		$pref = getDatabase()->one('SELECT * FROM lectern_prefs WHERE id=:id',array(':id'=>$_POST['id']));
		return json_encode($pref);
	}

	/* 
	 * POST -- responds with lectern_prefs info queried by user id
	 * params: id
	 * return: JSON lectern_pref object
	 */
	public static function lectern_pref_by_user()
	{
		$pref = getDatabase()->one('SELECT * FROM lectern_prefs WHERE user_id=:id',array(':id'=>$_POST['id']));
		return json_encode($pref);
	}
}
