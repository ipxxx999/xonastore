<?php

	class meMySQL {
		
		private $config = array();
		private $linkdb;
		
		function __construct ($dbhost, $dbuser, $dbpass, $dbbase, $dbcharset = 'utf8'){
			$this->config['dbhost'] = $dbhost;
			$this->config['dbuser'] = $dbuser;
			$this->config['dbpass'] = $dbpass;
			$this->config['dbbase'] = $dbbase;
			$this->config['dbcharset'] = $dbcharset;
		}
		
		public function connect(){
			if(empty($this->config)){
				throw new Exception('No data config MySQL.');
				return;
			}
			
			$this->linkdb =  mysqli_connect($this->config['dbhost'], $this->config['dbuser'], $this->config['dbpass']);
			if(empty($this->linkdb)){
				throw new Exception('Error connect MySQL.');
				return;
			}
			
			if(!mysqli_select_db($this->linkdb, $this->config['dbbase'])){
				throw new Exception('Error select db MySQL.');
				return;
			}
			
			mysqli_set_charset($this->linkdb, $this->config['dbcharset']);
			
			return true;
		}
		
		public function disconnect(){
			if(empty($this->linkdb)) return;
			mysqli_close($this->linkdb);
		}
		
		public function reconnect(){
			if(empty($this->linkdb) or !mysqli_ping($this->linkdb)) $this->connect();
		}
		
		public function set_security($var){
			$this->reconnect();
			return mysqli_real_escape_string($this->linkdb,$var);
		}
		
		public function query($sql){
			$this->reconnect();
			$query = mysqli_query($this->linkdb, $sql);
			if(!$query){
				throw new Exception(mysqli_error($this->linkdb));
				return $query;
			}
			return $query;
		}
		
		public function select($sql, $limit_one = false){
			$this->reconnect();
			$query = $this->query($sql);
			if($limit_one){
				$row = mysqli_fetch_assoc($query);
			} else {
				$row = array();
				 while ($d = mysqli_fetch_assoc($query)) {
					$row[] = $d; 
				 }
			}
			return $row;
		}
		
		public function insert_id(){
			return mysqli_insert_id($this->linkdb);
		}
		
	}