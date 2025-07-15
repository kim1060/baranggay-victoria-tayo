<?php
require_once(LIB_PATH . DS . 'database.php');
class UserAccount
{
	protected static  $tblname = "user_account";

	function dbfields()
	{
		global $mydb;
		return $mydb->getfieldsononetable(self::$tblname);
	}
	function listofstudents()
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname);
		//	return $cur;
	}
	function find_Users($id = "", $name = "")
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname . " 
			WHERE UserID = {$id} OR Fullname = '{$name}'");
		$cur = $mydb->executeQuery();
		$row_count = $mydb->num_rows($cur);
		return $row_count;
	}

	function find_all_Users($name = "")
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname . " 
			WHERE Fullname = '{$name}'");
		$cur = $mydb->executeQuery();
		$row_count = $mydb->num_rows($cur);
		return $row_count;
	}
	static function UserAuthentication($email, $h_pass)
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM `user_account` WHERE 1=1 and `username` = '" . $email . "' and `Password` = '" . $h_pass . "'");
		$cur = $mydb->executeQuery();
		if ($cur == false) {
			//die(mysql_error());
		}
		$row_count = $mydb->num_rows($cur); //get the number of count
		if ($row_count == 1) {
			$user_found = $mydb->loadSingleResult();
			$_SESSION['UserID']   	= $user_found->UserID;
			$_SESSION['Firstname']      	= $user_found->Firstname;
			$_SESSION['Middlename']      	= $user_found->Middlename;
			$_SESSION['Lastname']      	= $user_found->Lastname;

			$_SESSION['Address']      	= $user_found->Address;
			$_SESSION['Age']      	= $user_found->Age;
			$_SESSION['Status']      	= $user_found->Status;
			$_SESSION['Citizenship']      	= $user_found->Citizenship;
			$_SESSION['Email']      	= $user_found->Email;
			$_SESSION['Contact']      	= $user_found->Contact;

			$_SESSION['Username'] 		= $user_found->Username; 
			$_SESSION['Password'] 		= $user_found->Password;
			$_SESSION['UserType'] 		= $user_found->UserType; 
			$_SESSION['IsVerified'] 		= $user_found->IsVerified; 

			/*
			$bday = new DateTime($_SESSION['Birthdate']);
			$today = new Datetime(date('m/d/y'));
			$diff = $today->diff($bday);
			$age = $diff->y;
			$_SESSION['Age'] 		= $age;
*/

			return true;
		} else {
			return false;
		}
	}
	function find_pass($id = "", $pass = "")
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname . " 
			WHERE UserID = {$id} and password = '{$pass}'");
		$cur = $mydb->executeQuery();
		$row_count = $mydb->num_rows($cur);
		return $row_count;
	}

/*
	function single_Users($id = "")
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname . " 
				Where UserID= '{$id}' LIMIT 1");
		$cur = $mydb->loadSingleResult();
		return $cur;
	}
	*/
	function single_data($id = 0)
	{
		global $mydb;
		$mydb->setQuery("SELECT * FROM " . self::$tblname . " 
			Where UserID= '{$id}' LIMIT 1");
		$cur = $mydb->loadSingleResult();
		return $cur;
	}
	/*---Instantiation of Object dynamically---*/
	static function instantiate($record)
	{
		$object = new self;

		foreach ($record as $attribute => $value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}


	/*--Cleaning the raw data before submitting to Database--*/
	private function has_attribute($attribute)
	{
		// We don't care about the value, we just want to know if the key exists
		// Will return true or false
		return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes()
	{
		// return an array of attribute names and their values
		global $mydb;
		$attributes = array();
		foreach ($this->dbfields() as $field) {
			if (property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}

	protected function sanitized_attributes()
	{
		global $mydb;
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach ($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $mydb->escape_value($value);
		}
		return $clean_attributes;
	}


	/*--Create,Update and Delete methods--*/
	public function save()
	{
		// A new record won't have an id yet.
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create()
	{
		global $mydb;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO " . self::$tblname . " (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		echo $mydb->setQuery($sql);

		if ($mydb->executeQuery()) {
			$this->id = $mydb->insert_id();
			return true;
		} else {
			return false;
		}
	}
	public function createprofile()
	{
		global $mydb;

		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO `user_images` (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		echo $mydb->setQuery($sql);

		if ($mydb->executeQuery()) {
			$this->id = $mydb->insert_id();
			return true;
		} else {
			return false;
		}
	}

	public function update($id = 0)
	{
		global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE " . self::$tblname . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE UserID=" . $id;
		$mydb->setQuery($sql);
		if (!$mydb->executeQuery()) return false;
	}

	static function forgotpass($Question,$Answer,$NewPassword)
	{
		global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE " . self::$tblname . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE Question='$Question' ";
		$sql .= " WHERE Answer='$Answer' ";
		$sql .= " WHERE Password='$NewPassword' ";
		$mydb->setQuery($sql);
		if (!$mydb->executeQuery()) return false;
	}

	public function delete($id = 0)
	{
		global $mydb;
		$sql = "DELETE FROM " . self::$tblname;
		$sql .= " WHERE UserID=" . $id;
		$sql .= " LIMIT 1 ";
		$mydb->setQuery($sql);

		if (!$mydb->executeQuery()) return false;
	}
}