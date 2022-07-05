<?php 

class user {
	
	public static $id;
	public static $username;
	public static $rol;
	private static $password;
	
	public static function setData($data = array()){
		if(isset($data['id'])) user::$id = $data['id'];
		if(isset($data['username'])) user::$username = $data['username'];
		if(isset($data['rol'])) user::$rol = $data['rol'];
		if(isset($data['password'])) user::$password = $data['password'];
	}
	
	public static function isLoggedIn(){
		if(!empty(user::$id)) return true;
		return false;
	}
	
	public static function isAdmin(){
		if(user::$rol == 1) return true;
		return false;
	}
	
	public static function isEditor(){
		if(user::$rol == 2) return true;
		return false;
	}
	
	public static function isAuthor(){
		if(user::$rol == 3) return true;
		return false;
	}
	
	public static function isCollaborator(){
		if(user::$rol == 4) return true;
		return false;
	}
	
	public static function changePassword($oldpassword, $newpassword){
		if(empty(user::$id)){
			throw new Exception('ERROR: empty user');
		}
		
		if(!password_verify($oldpassword, user::$password)){
			throw new Exception('The old password do not match');
		}
		
		$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
		
		if(empty($newpassword)){
			throw new Exception('ERROR: hash password');
		}
		
		
		$medb = get_connect_db();
		$newpassword = $medb->set_security($newpassword);
		$userid = user::$id;
		$medb->query("UPDATE users SET password = '{$newpassword}' WHERE id = '{$userid}' LIMIT 1");
		$medb->disconnect();
	}
	
	public static function get_all_users(){
		$medb = get_connect_db();
		$sql = "SELECT * FROM users";
		$rows = $medb->select($sql);
		$medb->disconnect();
		return $rows;
	}
	
	public static function newUser($username, $password, $rol){
		
		if(!($rol == 1 or $rol == 2 or $rol == 3 or $rol == 4)){
			throw new Exception('ERROR: rol no exists');
		}
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		if(empty($password)){
			throw new Exception('ERROR: hash password');
		}
		
		if(!empty(user::getUserByName($username))){
			throw new Exception('ERROR: user exists');
		}
		
		$medb = get_connect_db();
		$username = $medb->set_security(strip_tags($username));
		$password = $medb->set_security($password);
		$rol = $medb->set_security($rol);
		$medb->query("INSERT INTO users (username, password, rol) VALUES ('{$username}','{$password}','{$rol}')");
		$medb->disconnect();
		
		return true;
	}
	
	public static function getUserByName($username){
		$medb = get_connect_db();
		$username = $medb->set_security($username);
		$row = $medb->select("SELECT * FROM users WHERE username = '{$username}' LIMIT 1", true);
		$medb->disconnect();
		if(empty($row)){
			return array();
		}
		return $row;
	}
	
	public static function editUser($userid, $password = null, $rol = 0){
		if(empty($userid)){
			throw new Exception('ERROR: userid empty');
		}
		if(!($rol == 1 or $rol == 2 or $rol == 3 or $rol == 4)){
			$rol = 0;
		}
		if(empty($password)){
			$password = null;
		}
		
		$medb = get_connect_db();
		$userid = $medb->set_security($userid);
		
		$editSQL = array();
		if(!empty($rol)){
			$rol = $medb->set_security($rol);
			$editSQL[] = "rol = '{$rol}'";
		}
		if(!empty($password)){
			$password = password_hash($password, PASSWORD_DEFAULT);
			$password = $medb->set_security($password);
			if(!empty($password)){
				$editSQL[] = "password = '{$password}'";
			}
		}
		if(!empty($editSQL)){
			$editSQLtxt = implode(',',$editSQL);
			$sql = "UPDATE users SET {$editSQLtxt}  WHERE id = '{$userid}' LIMIT 1";
			$medb->query($sql);
		}
		$medb->disconnect();
		
		return true;
		
	}
	
	public static function deleteUser($userid){
		$medb = get_connect_db();
		$userid = $medb->set_security($userid);
		$medb->query("DELETE FROM users WHERE id = '{$userid}' LIMIT 1");
		$medb->disconnect();
		return true;
	}
	
	public static function canEditPost($post_user_id){
		if(empty($post_user_id)) return false;
		if(user::isCollaborator()) return false;
		if(user::isEditor()) return true;
		if(user::isAdmin()) return true;
		if(user::isAuthor() and user::$id == $post_user_id){
			return true;
		}
		return false;
	}
	
}