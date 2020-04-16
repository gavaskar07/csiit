<?php
 include('config.php');
include('header.php'); 
if (isset($_POST['submited'])) { 
$result = mysql_query("select * from staff where department_id='$_POST[dept_id]'") or trigger_error(mysql_error()); 
$i=0;
//echo "------------select * from staff where department_id='$_POST[dept_id]'";
while($row = mysql_fetch_array($result))
{ 
$i++;
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
$mpath="mset".$i;
//echo "-------" . $_POST[$mpath] . "---------";
if(isset($_POST[$mpath]))
	{
		//echo "select * from login where f_dept_id !='' and userid='$row[id]'";//
		$num_rows = mysql_num_rows(mysql_query("select * from login where f_dept_id ='$_POST[a_dept_id]' and userid='$row[id]'"));
		$val=$num_rows>0?'1':'0';
			$sql = "delete from  `login`  where `uname` = '$_POST[username]' "; 
mysql_query($sql) or die(mysql_error());
		$sql = "INSERT INTO `login` ( `userid`,`uname` ,`password` ,`rolesetting_id` ,`status`,f_dept_id) VALUES( '$row[id]', '{$_POST['username']}' , '{$_POST['password']}' , '{$_POST['roleid']}' , '{$_POST['usertype']}','{$_POST['a_dept_id']}'  ) "; 
//echo $sql;
mysql_query($sql) or die(mysql_error());
echo"<script>alert('Admin User Details added Sucessfully')</script>";
		echo "<script>window.location='admin_user_setting.php'</script>";
	}
} 
}
?>
<h3>Add User</h3>
<script type="text/javascript">
function showfaculty(str) 
{
	var dept_id=document.getElementById("dept_id").value;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//document.writeln("dsd");
 document.getElementById("staffdetail").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","details/admin_staff_detail.php?d=" + dept_id,true);
  xmlhttp.send();
}

  function checkForm(form)
  {
    if(myform.username.value == "") {
       document.getElementById("nameerror").innerHTML="Please enter your user Name";
      myform.name.focus();
      return false;
    }
 if(myform.password.value == "") {
       document.getElementById("passerror").innerHTML="Please enter your password";
      myform.name.focus();
      return false;
    }
    return true;
  }

</script>
<form action='' id='myform' method='POST' onsubmit="return checkForm(this);"> 

<fieldset>
<legend>Admin User Entry</legend>
<table class="table table-striped table-bordered table-hover">
<tr>
<td align="right">User Name:</td>
<td> 
<select name="username" id="username">
    <option>racsiit</option>
     <option>ramca</option>
      <option>ramech</option>
       <option>raeee</option>
       <option>racse</option>
       <option>rait</option>
       <option>ramba</option>
       <option>racivil</option>
       <option>rash</option>
    </select>

</td>
</tr>
<tr>
  <td align="right">Password</td>
  <td><label for="password"></label>
    <input type="password" name="password" id="password" /></td>
</tr>
<tr>
  <td align="right">Role</td>
  <td><div class="styled-select">
<select name='roleid' id="roleid">
<option>select...</option>
<?php
$result = mysql_query("SELECT * FROM rolesetting") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['rolename']) . "</option>";  

} 
?>
</select></div>&nbsp;</td>
</tr>
<tr>
  <td align="right">Faculty Type</td>
  <td><label for="usertype"></label>
    <select name="usertype" id="usertype">
    <option>Administrator</option>
     <option>HOD</option>
      <option>Faculty</option>
       <option>Principal</option>
       <option>Student</option>
    </select></td>
</tr>
<tr>
 <td align="right">Admin for  Department</td>
<td>
<select name='a_dept_id' id='a_dept_id'>
<option value="0">All Department</option>
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";  
} 
?>
</select></td>
</tr>
<tr>
<td align="right">Staff Department</td>
<td>
<select name='dept_id' id='dept_id' onchange="showfaculty(this.value)">
<option>select</option>
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";  
} 
?>
</select></td>
</tr>
<tr>
<td colspan="2">
<div id="staffdetail">

</div>
</td>
</tr>

</table>

</fieldset>
</form> 

<?php
include('footer.php');
?>