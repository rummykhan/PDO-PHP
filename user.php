<?php

class User{
	$id = 0;
	$username = null;
	$password = null;

	function get($id){
		try {
			$db = new DB();
			$db->prepare('SELECT * FROM `Users` WHERE `id` = ?');
			$db->execute_with_data(array($id));

			if($db->row_count() > 0){
				$row = $db->fetch_row();
				
				$user = new User();
				$user->id = $row['id'];
				$user->username = $row['username'];
				$user->password = $row['password'];

				return $user;
			}
			return null;
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
	}

	function add($user = null){
		try {

			$db = new DB();
			$db->prepare('INSERT INTO `Users`(`username`, `password`) VALUES(?, ?)');
			
			if($user == null){
				$user = $this;
			}

			return $db->execute_with_data(array($user->username, $user->password));

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
			
		}
	}

	function update($user = null){
		try {

			$db = new DB();
			$db->prepare('UPDATE `Users` SET `username` = ?, `password` = ? WHERE `id` = ?');

			if($user == null){
				$user = $this;
			}

			return $db->execute_with_data(array($user->username, $user->password, $user->id));

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
			
		}
	}

	function add_by_name($user){
		try {

			$db = new DB();
			$db->prepare('INSERT INTO `Users`(`username`, `password`) VALUES(:username, :password)');
			
			if($user == null){
				$user = $this;
			}

			$db->bind_param(':username', $user->username);
			$db->bind_param(':password', $user->password);

			return $db->execute_with_data(array($user->username, $user->password));

		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
			
		}
	}

	function get_by_limit($limit){
		try {
			$db = new DB();
			$db->prepare('SELECT * FROM `Users` limit :lim, 1');
			$db->bind_param(':lim', $limit);
			$db->execute();

			if($db->row_count() > 0){
				$row = $db->fetch_row();
				
				$user = new User();
				$user->id = $row['id'];
				$user->username = $row['username'];
				$user->password = $row['password'];

				return $user;
			}
			return null;
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
	}

	static function all(){
		try {
			$db = new DB();
			$db->prepare('SELECT * FROM `Users`');
			$db->execute();

			$users = [];
			while ($row = $db->fetch_row()) {

				$user = new User();
				$user->id = $row['id'];
				$user->username = $row['username'];
				$user->password = $row['password'];

				$users[] = $user;
			}
			return $users;
		} catch (Exception $e) {
			throw new Exception($e->getMessage(), 1);
		}
	}
}