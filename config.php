<?php
$sDbHost = 'localhost';
 $sDbName = 'gmsoftw1_cms';
// $sDbUser = 'gmsof_cms';
// $sDbPwd  = 'asdf@123';
$sDbUser = 'root';
$sDbPwd  = 'welcome';
 date_default_timezone_set('Asia/Kolkata');
$date=date("m/d/Y h:i:s a", time());
$udetail=$date;
global $dbConn;
$dbConn = mysql_connect ($sDbHost, $sDbUser, $sDbPwd) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db($sDbName,$dbConn) or die('Cannot select database. ' . mysql_error());
////end of database configuration////
///selecting college name///
function getcollegename() {
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM college")); 
$college_name=stripslashes($row['college_name']);
    echo $college_name;
}

function getacademicyear() {
	$row1 = mysql_fetch_array ( mysql_query("SELECT * FROM current_ayear")); 
$ayear=stripslashes($row1['ayear']);
	for ($i=2018;$i<= date("Y") ;$i++)
	{ 
	$val=$i . "--" . ($i+1);
	if($val==$ayear)
	{
		echo "<option selected='selected'>" . $i . "--" . ($i+1) . "</option>";
	}
	else
	{
		echo "<option>" . $i . "--" . ($i+1) . "</option>";
	}
	}
}

function getexam() {
	//for ($i=1;$i<=3 ;$i++)
	//{ 
	$sql = "select * from term_exam";
$result_1 = mysql_query($sql) or trigger_error(mysql_error());
while($row_1 = mysql_fetch_array($result_1)){
	//$exam=str_replace(' ', '', $row_1['exam']). $row['id'];
	echo "<option value='$row_1[exam]'>" . $row_1['exam']."</option>";
}
	//}
}
function getyear() {
		echo "<option value='1'>" . "First Year"."</option>";
		echo "<option value='2'>" . "Second Year"."</option>";
		echo "<option value='3'>" . "Third Year"."</option>";
		echo "<option value='4'>" . "Fourth Year"."</option>";
		
}
function getyear_sel($i) {
	if($i==1)
	{
		echo "<option value='1' selected>" . "First Year"."</option>";
		echo "<option value='2'>" . "Second Year"."</option>";
		echo "<option value='3'>" . "Third Year"."</option>";
		echo "<option value='4'>" . "Fourth Year"."</option>";
	}
	else if($i==2)
	{
		echo "<option value='1'>" . "First Year"."</option>";
		echo "<option value='2' selected>" . "Second Year"."</option>";
		echo "<option value='3'>" . "Third Year"."</option>";
		echo "<option value='4'>" . "Fourth Year"."</option>";
	}
	else if($i==3)
	{
		echo "<option value='1'>" . "First Year"."</option>";
		echo "<option value='2'>" . "Second Year"."</option>";
		echo "<option value='3' selected>" . "Third Year"."</option>";
		echo "<option value='4'>" . "Fourth Year"."</option>";
	}
	else
	{
		echo "<option value='1'>" . "First Year"."</option>";
		echo "<option value='2'>" . "Second Year"."</option>";
		echo "<option value='3'>" . "Third Year"."</option>";
		echo "<option value='4' selected>" . "Fourth Year"."</option>";
	}	
		
}
function getsemester() {
		echo "<option value='1'>" . "First Semester"."</option>";
		echo "<option value='2'>" . "Second Semester"."</option>";
		echo "<option value='3'>" . "Third Semester"."</option>";
		echo "<option value='4'>" . "Fourth Semester"."</option>";
		echo "<option value='5'>" . "Fifth Semester"."</option>";
		echo "<option value='6'>" . "Sixth Semester"."</option>";
		echo "<option value='7'>" . "Seventh Semester"."</option>";
		echo "<option value='8'>" . "Eight Semester"."</option>";
		
}
///end of selecting college name///


?>
<?php // sms
$user = "YOUR-USERNAME";
$pass = "YOUR-PASSWORD";
$mob  = "919762681119,919762681118"; // Can come from a database
$msg  = "Hello";
//$url  = "http://bulksms.megawebsource.com/sendsms.jsp?user=$user&password=$pass&mobiles=$mob&sms=$msg&senderid=NOTICE";
//$xml  = file_get_contents($url);
// Process XML if you need to
function encryptor($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
    	//decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

//encryptor(‘encrypt’, 5);

//and for decryption

//encryptor(‘decrypt’, ‘cjhwYlZ6RFdmU0dBbFdLSlBzZXZtUT09’).
function getday_order($fdate,$tdate) {
$date1=date_create($fdate);
$date2=date_create($tdate);
$date_count=date_diff($date1,$date2);
///excluding sundays
$dt1 = "2009-02-26";
$dt2 = "2009-03-26";

$tm1 = strtotime($date1);
$tm2 = strtotime($date2);

$dt = Array ();
for($i=$tm1; $i<=$tm2;$i=$i+86400) {
if(date("w",$i) == 7) {
	$dt[] = date("l Y-m-d ", $i);
}
}
//echo "Found ".count($dt). " Saturdays...<br>";
$number_sunday=0;
for($i=0;$i<count($dt);$i++) {
//echo $dt[$i]."<br>";
$number_sunday=$number_sunday+1;
}
//excludinh sundays
//getting holidays and hours 

//getting holidays and hours



}


?>