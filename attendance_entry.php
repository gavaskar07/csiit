
<?php 
include('config.php');
include('header.php');
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Attendance Entry</li>
        </ol>
        
    <?php
	//include('common.php');
	?>
    <form name="f1" method="post" action="">
    <script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
    <script>
function getSelectedOptions(sel) {
    var opts = [], opt;
    
    // loop through options in select list
    for (var i=0, len=sel.options.length; i<len; i++) {
        opt = sel.options[i];
        
        // check if selected
        if ( opt.selected ) {
            // add to array of option elements to return from this function
            opts.push(opt);
           
        }
    }
    
    // return array containing references to selected option elements
    return opts;
}
function showstudent(str) 
{
	//document.getElementById("fdate").value;
	var string = document.getElementById("fdate").value;
var str_arr = string.split("-");
 var GivenDate = str_arr[2] + "-" +  str_arr[1] + "-" + str_arr[0];
var CurrentDate = new Date();
GivenDate = new Date(GivenDate);
var n = GivenDate.getDay();
var f_date = document.getElementById("f_date").value;
var fr_date=new Date(f_date);
var t_date = document.getElementById("t_date").value;
var to_date=new Date(t_date);
//if(GivenDate > CurrentDate){
//    alert('Given date is greater than the current date.');
///	document.getElementById("studentdetail").innerHTML="";
//} 
//else if(n=="0")
//{
//	alert('Choosed Date is a Sunday');
//	document.getElementById("studentdetail").innerHTML="";
//}
if(GivenDate<fr_date)
{
	alert('Choosed correct date');
	document.getElementById("studentdetail").innerHTML="";
}
else if(GivenDate>to_date)
{
	alert('Choosed correct date');
	document.getElementById("studentdetail").innerHTML="";
}
else{
    //alert('Given date is not greater than the current date.');

  var selLanguage = document.getElementById("hours");
  var hour = "";
  for (i = 0; i < selLanguage.length; i++){
   currentOption = selLanguage[i];
   if (currentOption.selected == true){
	   
		  hour += "-" + currentOption.value ; 
   } 
  } 
  if(hour=="")
  {
	 alert('Please choose the hour'); 
  }
  else
  {
	//document.writeln(hour);
	var date=document.getElementById("fdate").value;
	var batch_id=document.getElementById("batch_id").value;
	var course_id=document.getElementById("course_id").value;
	//document.writeln(batch_id);
	var semester_setting_id=document.getElementById("semester_setting_id").value;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//document.writeln("dsd");
 document.getElementById("studentdetail").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","details/get_studentdetail.php?b="+batch_id + "&s=" + semester_setting_id + "&d="+ date + "&h=" + hour + "&c=" + course_id,true);
  xmlhttp.send();
  }
  }
}
</script>
<?php
if(isset($_POST['submited']))
{
	echo "submitted";
	$fhour;
	$hours= $_POST['hours'];
	echo $_POST['fdate'];
	$adate= date('Y-m-d', strtotime($_POST['fdate']));
	$day ="1";
	$day = date('N', strtotime($adate));
	echo $day;
if( is_array($hours)){
while (list ($key, $val) = each ($hours)) {
$fhour=$val;
$staff_id=$_SESSION['userid'];
$course_id=$_POST["course_id_".$fhour];
$unit=$_POST["u_course_id_".$fhour];
$period=$_POST["notes".$fhour];
echo $_POST["course_id_".$fhour];
///for new insert
//echo "select ae.adate  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'";
$query = mysql_query("SELECT * FROM stud_course_reg where course_id='$course_id'");
$count_course=mysql_num_rows($query);
if($count_course==0)
{
$num_rows = mysql_num_rows(mysql_query("select ae.adate from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'"));
}
else
{
$num_rows = mysql_num_rows(mysql_query("select ae.adate from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.id='$course_id'"));	
}
 		$val=$num_rows>0?'1':'0';
		if($val==0)
		{
		$sql = "INSERT INTO attendance_entry( `adate` ,  `hour`,`day`,`staff_id`,`course_setting_id`,`period`,unit ) VALUES('$adate','$fhour','$day','$staff_id','$course_id','$period','$unit') "; 
mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array ( mysql_query("SELECT max(id) as val FROM attendance_entry")); 
$max_id=stripslashes($row['val']);
$query = mysql_query("SELECT * FROM stud_course_reg where course_id='$course_id'");
$count=mysql_num_rows($query);
if($count==0)
{
$result = mysql_query("select * from student where (status IS NULL or status<>'In active') and batch_id='$_POST[batch_id]'") or trigger_error(mysql_error());
}
else
{
	$result = mysql_query("select * from student where  (status IS NULL or status<>'In active') and batch_id='$_POST[batch_id]' and id in (select student_id from stud_course_reg where course_id='$course_id') ORDER BY CAST(rollno as unsigned) asc") or trigger_error(mysql_error());

}
$i=0;
while($row = mysql_fetch_array($result))
{ 
$mpath="mset".$row['id'];
	$mpath1="h".$row['id'];
	if(isset($_POST[$mpath]))
	{
		$sql = "INSERT INTO attendance_entry_detail( `attendance_entry_id` ,`student_id` ) VALUES('$max_id','$_POST[$mpath1]') "; 
        mysql_query($sql) or die(mysql_error());
	}
}	
		}
else
{
echo "to update";
$query = mysql_query("SELECT * FROM stud_course_reg where course_id='$course_id'");
$count_course=mysql_num_rows($query);
if($count_course==0)
{
	//echo "</br>"."select ae.id from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'";
$row = mysql_fetch_array ( mysql_query("select ae.id from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'")); 
}
else
{
$row = mysql_fetch_array ( mysql_query("select ae.id from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.id='$course_id'")); 	
}
$ae_id=stripslashes($row['id']);
$sql = "update attendance_entry set staff_id='$staff_id',course_setting_id='$course_id',period='$period',unit='$unit' where id='$ae_id' "; 
echo $sql;
mysql_query($sql) or die(mysql_error());
$sql = "delete from  attendance_entry_detail where attendance_entry_id='$ae_id' "; 
mysql_query($sql) or die(mysql_error());
$query = mysql_query("SELECT * FROM stud_course_reg where course_id='$course_id'");
$count=mysql_num_rows($query);
if($count==0)
{
$result = mysql_query("select * from student where (status IS NULL or status<>'In active') and batch_id='$_POST[batch_id]'") or trigger_error(mysql_error());
}
else
{
$result = mysql_query("select * from student where (status IS NULL or status<>'In active') and batch_id='$_POST[batch_id]' and id in (select student_id from stud_course_reg where course_id='$course_id') ORDER BY CAST(rollno as unsigned) asc") or trigger_error(mysql_error());	
}
$i=0;
while($row = mysql_fetch_array($result))
{ 
$mpath="mset".$row['id'];
	$mpath1="h".$row['id'];
	if(isset($_POST[$mpath]))
	{
		$sql = "INSERT INTO attendance_entry_detail( `attendance_entry_id` ,`student_id` ) VALUES('$ae_id','$_POST[$mpath1]') "; 
		//echo $sql;
        mysql_query($sql) or die(mysql_error());
	}
}	
}


}
}
echo"<script>alert('Attendance Detail Entered Sucessfully')</script>";
		echo"<script>window.close();</script>";	
 ?>
<?php	
}
else
{
	
}
if (!isset($_POST['submit']) and !isset($_POST['submited']) ) {
	//include('common.php');
	
$staff_id=encryptor('decrypt',$_GET['staff_id']);
$course_id=encryptor('decrypt',$_GET['course_id']);
//$staff_id="0";
$sql = "SELECT d.id as dept_id,ss.year,cs.sub_name from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id where csm.staff_id='$staff_id' and cs.id='$course_id'";
//echo $sql;
$row = mysql_fetch_array ( mysql_query($sql)); 
$dept_id=stripslashes($row['dept_id']);
$year=stripslashes($row['year']);
$sub_name=stripslashes($row['sub_name']);
if($dept_id=="")
{
	echo"<script>alert('invalid entry')</script>";
		echo"<script>window.close();</script>";
}
?>
<table class='table table-striped table-bordered'>
<tr>
  <td>Department:<?php
$result = mysql_query("SELECT * FROM department where id='$dept_id'") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
echo nl2br( $row['dept_name']);  
} 
?></td><td>
Subject:<?php echo $sub_name; ?>
<input type="hidden" name="dept_id" value="<?php echo $dept_id; ?>"/>
<input type="hidden" name="f_date" id="f_date" value="<?php echo $_GET['fdate']; ?>"/>
<input type="hidden" name="t_date" id="t_date" value="<?php echo $_GET['tdate']; ?>"/>
</td>
  <td>Academic Year</td>
  <td><?php
//$row1 = mysql_fetch_array ( mysql_query("SELECT * FROM current_ayear")); 
echo $_SESSION['ayear'];
?></td>
<input type="hidden" name="academicyear" value="<?php echo $_SESSION['ayear'];//$row1['ayear']; ?>"/>
<td>Semester</td>
  <td><?php
//echo $row1['semester'];
echo $_SESSION['sem'];
?>
<input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id; ?>"/>
<input type="hidden" name="semester" id="semester" value="<?php echo $_SESSION['sem'];//$row1['semester']; ?>"/>
</td>
</tr>
<tr>
<?php
$sql="SELECT s.id,s.noofhours,b.id as batch FROM  semester_setting s  inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join  course_setting cs on cs.semester_setting_id=s.id  where s.academicyear='$_SESSION[ayear]' and s.semester= '$_SESSION[sem]' and d.id='$dept_id' and s.year='$year' and cs.id='$course_id' ";
//echo $sql;
$row = mysql_fetch_array ( mysql_query($sql)); 
$semester_setting_id=stripslashes($row['id']);
?>
<input type="hidden" id="batch_id" name="batch_id" value="<?php echo stripslashes($row['batch']); ?> "/>
<input type="hidden" id="semester_setting_id" name="semester_setting_id" value="<?php echo $semester_setting_id; ?> "/>
<td align="right">Hours:
<select name='hours[]' id='hours' multiple onchange="showstudent(this.value)">
<?php
$noofhours=stripslashes($row['noofhours']);
echo "Hour".$noofhours;
for($i=1;$i<=$noofhours;$i++)
{
	
?>
<option value='<?php echo $i; ?>'> <?php echo "Hour-".$i;?></option>   
<?php
}
?>
</select>
</td>

<td align="right">Date:</td>
<td colspan="2"><input type='text' name='fdate' value="<?php echo date("d-m-Y") ?>" id='fdate' onchange="showstudent(this.value)" /> <a href="javascript:NewCssCal('fdate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a></td>
<td></td>
</tr>
<tr>
<td colspan="6">
<div id="studentdetail">
</div>
</td>
</tr>
</table>
</form>
<?php
}
else if (isset($_POST['submit']))
{
	?>
	
<?php
}
else
{
	//echo "hai";
}
    include('footer.php');
?>  