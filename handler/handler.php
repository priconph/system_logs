<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				case "send_email" 			: send_email(); break;
				case "enable_account" 		: enable_account(); break;
				
				
				case "load_records" 		: load_records(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "add_new_record" 		: add_new_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_fetch_record" 	: update_fetch_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "update_record" 		: update_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				case "delete_record" 		: delete_record(); break; //switch case, in using ajax an action must be set in order to choose the specific function to use
				
			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	function enable_account(){
		require_once('../class/oop.php'); //OOP Path
		$date_time_today = date('Y-m-d H:i:s'); 
		$return 		 = $_POST; 
		$table        	 = "tbl_useraccounts";
		$array_fields 	 = array('isEnable','lastupdate', 'un');
		$array_values 	 = array(0,$date_time_today, $return['iss']);
		$pkid 			 = $return['id'];
		$activity_logs 	 = 'ENABLE USER LOG-IN';
		$remarks 		 = '';
		$username 		 = $return['username'];
		$result 		 = LOGS::getInstance()->update_query($table,$array_fields,$array_values,$pkid, $activity_logs, $username, $remarks);
		$ip_address 	 = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
		send_email_enabled_account($username, $ip_address, $date_time_today, $return['iss']);
		$return["msg"] = $result;
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here

	}

	function send_email_enabled_account($username, $ipaddress, $date_time, $iss) {
		require_once('../class/send_email.php');
		$subject = 'Enabled Rapid account of '.$username;
		$body 	 = 'This is to inform you that your Rapid account has been enabled by '.return_empname_by_username($iss).'. <br><br><i>Details:</i>';
		$body 	.= '<br>Username: '.$username;
		$body 	.= '<br>Date/Time: '.date('M d, Y h:i:s a', strtotime($date_time));
		$to 	= return_email_add($username);
		$php_mailer = new email();
		// $msg = $php_mailer->send_email($to, 'kiosk@pricon.ph', 'naayes@pricon.ph', $subject, $body,'');
		$msg = $php_mailer->send_email($to, 'kiosk@pricon.ph', 'group-iss@pricon.ph', $subject, $body,'');
	}
	
	function return_email_add($username){
		$array_fields = array('email_add');
		$table 	   	= 'tbl_useraccounts';
		$joins 	   	= '';
		$sql_where 	= 'where username= "' . $username . '"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$activity_logs = 'DATA FETCH';
		$remarks = '';
		$result = LOGS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit, $activity_logs, $username, $remarks);
		if($row = mysqli_fetch_array($result)){
			return $row['email_add'];
		} else {
			return '';
		}
    }
	
	function return_empname_by_username($username){		
		$array_fields = array('name');
		$table 	   	= 'tbl_useraccounts';
		$joins 	   	= '';
		$sql_where 	= 'where username= "' . $username . '"';
		$sql_order 	= '';
		$sql_limit 	= '';
		$activity_logs = 'DATA FETCH';
		$remarks = '';
		$result = LOGS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit, $activity_logs, $username, $remarks);
		if($row = mysqli_fetch_array($result)){
			return $row['name'];
		} else {
			return '';
		}
    }
	
	//-
	/* function for displaying record */
	function load_records(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST;
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= '';
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = LOGS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr']	  = $ctr;
		$return['result'] = json_encode($result);
		echo json_encode($return);
	}
	
	/* function for adding record */
	function add_new_record(){
		require_once('../class/oop.php'); //OOP Path
		$date_time_today = date('Y-m-d H:i:s'); 
		$return 		= $_POST; 
		$result 		= "";
		$table   		= "tbl_records"; //table name
		$array_fields 	= array('name','lastname','address','remarks','lastupdate', 'username'); //table fields
		$array_values 	= array($return['txt_name'],$return['txt_lastname'],$return['txt_address'],$return['txt_remarks'],$date_time_today, $return['username']); //values to be saved
		$result 		= LOGS::getInstance()->insert_query($table,$array_fields,$array_values);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for fetching record */
	function update_fetch_record(){
		require_once('../class/oop.php'); //OOP Path
		$return = $_POST; 
		$result = "";
		$array_fields = array('*');
		$table 	   	= 'tbl_records';
		$joins 	   	= '';
		$sql_where 	= 'WHERE `pkid` ='.$return['pkid'];
		$sql_order 	= 'ORDER BY pkid';
		$sql_limit 	= '';
		$result = LOGS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr = 0;
		while($row = mysqli_fetch_array($result)){
			$return['pkid2'][$ctr] 		= $row['pkid'];
			$return['name'][$ctr] 		= $row['name'];
			$return['lastname'][$ctr] 	= $row['lastname'];
			$return['address'][$ctr] 	= $row['address'];
			$return['remarks'][$ctr] 	= $row['remarks'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return);//json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for updating record */
	function update_record(){
		require_once('../class/oop.php'); //OOP Path
		$date_time_today = date('Y-m-d H:i:s'); 
		$return = $_POST; 
		$result = "";
		$table        = "tbl_records";
		$array_fields = array('name','lastname','address','remarks','lastupdate', 'username');
		$array_values = array($return['txt_name_update'],$return['txt_lastname_update'],$return['txt_address_update'],$return['txt_remarks_update'],$date_time_today, $return['username']);
		$pkid = $return['txt_pkid'];
		$result = LOGS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	
	/* function for deleting a record */
	function delete_record(){
		require_once('../class/oop.php'); //OOP Path
		$return 	= $_POST; 
		$result 	= "";
		$pkid 		= $return['pkid'];
		$table        = "tbl_records";
		$array_fields = array('logdel','lastupdate', 'username');
		$array_values = array(1,$date_time_today, $return['username']);
		$result = LOGS::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return["result"] = json_encode($result); //return the the serialize values
		echo json_encode($return); //json encode since I used a dataType json before passing the serialized values here
	}
	//-
?>