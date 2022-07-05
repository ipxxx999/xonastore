<?php 

class auth {
	public static function loginUser($username = null, $password = null){
		if(empty($username) or empty($password)){
			throw new Exception('ERROR: username empty or password empty.');
		}
		
		$medb = get_connect_db();
		$username = $medb->set_security($username);

		$row = $medb->select("SELECT * FROM users WHERE username = '{$username}' LIMIT 1", true);
		
		$medb->disconnect();
		
		if(empty($row)){
			throw new Exception('The username do not match');
		}
		
		if(!password_verify($password, $row['password'])){
			throw new Exception('The password do not match');
		}
		
		session_start();
		$_SESSION['uid'] = $row['id'];
		
		return true;
	}
	
	public static function sessionLoad(){
		session_start([
			'read_and_close'  => true,
		]);
		
		if(!isset($_SESSION['uid']) or empty($_SESSION['uid'])) return;
		
		$medb = get_connect_db();
		$uid = $medb->set_security($_SESSION['uid']);
		$row = $medb->select("SELECT * FROM users WHERE id = '{$uid}' LIMIT 1", true);
		$medb->disconnect();
		if(empty($row)){
			return;
		}
		user::setData($row);
	}
	
	public static function logout(){
		session_start();
		session_destroy();
	}
}