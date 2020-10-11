<?php 
 if(!isset($_SESSION)) { 
	session_start(); 
}  
   
class PratikDbClass{
	function __construct(){
		$this->con = mysqli_connect("hostname","mysqlUser","mysqlPassword","DBname") or die(mysql_error());
	}

	function insertion($tbl,$data){
		// Insert data into any table
		$col="";
		foreach($data as $value){
			$col=$col . "'" . $value . "'" . ",";
		}
		$tmp = substr($col,0,strlen($col)-1);
		// print_r($data);

		$qry="insert into " . $tbl . " values(null," . $tmp . ")";
		mysqli_query($this->con,$qry);

	}
	
	function grid($tbl,$f){
		// Provide gridview's header with column name of your table
		$sql = "SHOW COLUMNS FROM ". $tbl;
		$result = mysqli_query($this->con,$sql);
		$cnt=mysqli_num_rows($result);
		
		$i = $j = 0;
		echo "  <table id='example1'  class='table table-striped table-hovered' cellspacing='0' width='100%' >
			
				<thead> 
				<tr>";
		while($i<$cnt){

			while($row = mysqli_fetch_array($result)){
				echo " <th>" . $f[$j] ." </th>";
				$j++;
			}
			$i++;
		}
		echo "<th > Edit </th>
				<th> Delete </th>
				</thead>
				</tr>";

		$sql="Select * from ". $tbl;
		$res=mysqli_query($this->con,$sql);
		return $res;

	}
	function select_up($tbl,$whr,$id){
		// it return one record of which condition is passed in the form of array.
		$qry="select * from " . $tbl . " where " . $whr . " = " . $id;
		$res=mysqli_query($this->con,$qry);
		$row=mysqli_fetch_array($res);
		return $row;
	}
	function updatation($tbl,$data,$whrname,$whrid){
		// for update data in table
		$col="";
		foreach($data as $key => $value){
			$col=$col . $key . "=" . "'" . $value . "'" . ",";
		}
		$tmp = substr($col,0,strlen($col)-1);
		$qry="update ". $tbl ." set " . $tmp . " where ". $whrname . " = " .$whrid;
		mysqli_query($this->con,$qry);
		
	}	
	function deletion($tbl,$whrid,$whrval){
		// for delete record of id which is passed.
	 	$qry = "delete from ".$tbl ." where ".$whrid ." = ".$whrval;
		mysqli_query($this->con,$qry);
	}
	function data_dd($tbl){
		// it returns all the record of table in mysql reult form
		$qry="select * from " . $tbl;
		$res=mysqli_query($this->con,$qry);
		return $res;
	}
	function img_upload($data,$imgpath,$name){
		// it moves selected image into given path and returns a random name of image
		$type = $data['type'];
  		$tmp = substr($type,6,strlen($type));
  		$random = rand(1000,9999);
  		$img = $name . $random . "." . $tmp;
  		$path = $imgpath . $img;

  		if($type != "image/jpg" && $type != "image/png" && $type != "image/jpeg" && $type != "image/gif") {
    		return "Sorry, only JPG, JPEG & PNGs files are allowed.";
  		}
  		else {
    		if(move_uploaded_file($data['tmp_name'],$path)){
      			return $img;
    		}
    	}
    }
    function img_upload2($data,$name,$imgpath){
		// it moves selected image into given path and returns a random name of image
		$type = $data['type'];
  		$tmp = substr($type,6,strlen($type));
  		$name = $name.".".$tmp;
  		$img = str_replace(' ', '', $name);
  		$path = $imgpath . $img;
  		if($type != "image/jpg" && $type != "image/png" && $type != "image/jpeg") {
    		$err_img = "";
    		// $err_img = "Sorry, only JPG, JPEG & PNGs files are allowed.";
    		return "0";
  		}
  		else {
    		if(move_uploaded_file($data['tmp_name'],$path)){
      			return $img;
    		}
    	}
    }
    function randString($length) {
    	// it return a random string of length which is given as an argument
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
	function log_in($uemail,$pass){
		// Provide Login with email and pass MD5 hash is used,  with session store, Email will be stored in session
		 $qry = "select * from sp_users where u_email = '" . $uemail ."' and u_password = '" . $pass ."'" ;
		$res = mysqli_query($this->con,$qry);
		$cnt = mysqli_num_rows($res);
		if ($cnt == 1) {
			$_SESSION["useremail"] = $uemail;
			// // Program to display URL of current page. 
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
			    $link = "https"; 
			}
			else{
			    $link = "http"; 
			}
			$link .= "://"; 
			$link .= $_SERVER['HTTP_HOST']; 
			$link .= $_SERVER['REQUEST_URI']; 
			header("location: " . $link);
		}else {
			// $err = "Wrong Combination of Username and Password";
			header("location:index.php?notLoggedIn");
		}
	}
	function log_in2($uemail,$pass){
		// Provide Login with email and pass MD5 hash is used,  with no session 
		$qry = "select * from sp_users where u_email = '" . $uemail ."' and u_password = '" . $pass ."'" ;
		$res = mysqli_query($this->con,$qry);
		echo $cnt = mysqli_num_rows($res);
		if ($cnt == 1) {
			return 1;
		}
		else {
			// $err = "Wrong Combination of Username and Password";
			return 0;
		}

	}
	function select_records($tbl,$whrid,$whrval) {
		// select all record where $whrid = $whrval 
		$qry="select * from " . $tbl . " where " . $whrid . " = '" . $whrval ."'";
        	return mysqli_query($this->con,$qry);
	}
	function insert_selection($tbl,$fields,$data){
		// Insert data into any table within some perticular fields 
		$col="";
		foreach($data as $value){
			$col=$col . "'" . $value . "'" . ",";
		}
		$tmp = substr($col,0,strlen($col)-1);
		$qry="insert into " . $tbl ."($fields)". " values(" . $tmp . ")";	
		mysqli_query($this->con,$qry);
	}
	function custom_query($qry){
		// To execute custom queries
        	return mysqli_query($this->con,$qry);
	}
}	
?>
