<?php 

function get_connect_db(){
	$link = new meMySQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_CHARSET);
	return $link;
}

function get_link_data($id){
	if(!is_numeric($id)) return;
	$medb = get_connect_db();
	$id = $medb->set_security($id);
	$row = $medb->select("SELECT * FROM links WHERE id = '{$id}' LIMIT 1", true);
	$medb->disconnect();
	if(empty($row)){
		return array();
	}
	$data = json_decode($row['data'], true);
	if(empty($data)) $data = array();
	$row['data'] = $data;
	return $row;
}

function get_options(){
	$medb = get_connect_db();
	$row = $medb->select("SELECT * FROM options WHERE option_key = 'general' LIMIT 1", true);
	$medb->disconnect();
	if(empty($row)){
		return array();
	}
	$data = json_decode($row['option_value'], true);
	if(empty($data)) return array();
	return $data;
}

