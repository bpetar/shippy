<?php
if ( !defined( "_DB_LAYER" ) ){
	define("_DB_LAYER", 1 );

	class db {
		var $cid;
		var $connect_id;
		var $type;
		
		function db($database_type="oracle") {
			$this->type = $database_type;
		}
		
		//oracle DB
		/*
		function open($user, $password, $service) {
			$this->connect_id = OCILogOn($user, $password, $service);
			return $this->connect_id;
		}
		
		function close() {
			$result = OCILogoff($this->connect_id);
			return $result;
		}*/
		
		function open($database, $host, $user, $password) {
			$this->connect_id=mysql_connect($host, $user, $password);
			if ($this->cid=$this->connect_id) {
				$result=@mysql_select_db($database);
				if (!$result) {
					@mysql_close($this->connect_id);
					$this->connect_id=$result;
				}
				return $this->connect_id;
			}else{
				return 0;
			}
		}
		
		function close() {
			// Closes the database connection and frees any query results left.
			$result=@mysql_close($this->connect_id);
			return $result;
		}
	};
	
	/************************************** QUERY ***************************/
	
	class query {

  var $result;
  var $row;

  function query(&$db, $query="") {
  // Constructor of the query object.
  // executes the query

    if($query!=""){
			if (strtolower(substr($query,0,3))=="sel"){
			      $this->result=@mysql_query($query, $db->connect_id);
			      return $this->result;
			} else{
			      $re=@mysql_query($query, $db->connect_id);
			      return $re;
			}
    }
  }

  function getrow() {
    $this->row=@mysql_fetch_array($this->result);
    return $this->row;
  }

  function numrows() {
  // Gets the number of rows returned in the query

    $nr=@mysql_num_rows($this->result);
    return $nr;
  }

  function error() {
  // Gets the last error message reported for this query

    $err=@mysql_error();
    return $err;
  }
  
  

  function field($field, $row="-1") {
  // get the value of the field with name $field
  // in the current row or in row $row if supplied

    if($row!=-1){
      $result=@mysql_result($this->result, $row, $field);
    }
    else{
      $result=$this->row[$field];
    }

    if(isset($result)){
      return $result;
    }
    else{
      return '0';
    }
  }

  function firstrow() {
  // return the current row pointer to the first row

    $result=@mysql_data_seek($this->result,0);
    if($result){
      $result=$this->getrow();
      return $this->row;
    }
    else{
      return 0;
    }
  }

	function last_id(){
	// returns last inserted id
		return @mysql_insert_id();
	}

  function free() {
  // free the mysql result tables

    return @mysql_free_result($this->result);
  }
}; // End class

	
	$DB=new db();
	global $db_name;
	global $db_host;
	global $db_user;
	global $db_pwd;
	
	$DB->open($db_name, $host, $db_user, $db_pwd);
	if (!$DB) echo("Nije uspelo povezivanje na bazu podataka!");
} // end define
?>