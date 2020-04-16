<?php
function numberToRoman($num)  
{ 
    // Be sure to convert the given parameter into an integer
    $n = intval($num);
    $result = ''; 
 
    // Declare a lookup array that we will use to traverse the number: 
    $lookup = array(
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
    ); 
 
    foreach ($lookup as $roman => $value)  
    {
        // Look for number of matches
        $matches = intval($n / $value); 
 
        // Concatenate characters
        $result .= str_repeat($roman, $matches); 
 
        // Substract that from the number 
        $n = $n % $value; 
    } 

    return $result; 
} 
if(!isset($_POST['submit']))
{
include('config.php');
include('header.php');
}
else
{
	include('config.php');
	session_start();
	
}
?>
<?php
		  if(!isset($_POST['submit']))
{?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Day wise Attendance Report
 
          </li>
        </ol>
     <?php
 
	//echo "on " . $_POST['adate'];
}
		  ?>
    <?php
	//include('common.php');
	?>
    <form name="f1" method="post" action="">
    
    <script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
    <script>
	function showprogram(str) 
{
	
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		//document.writeln("dsd");
 document.getElementById("program_id").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","details/get_programs.php?q="+str,true);
  xmlhttp.send();
}

function showbatch(str) 
{
 //document.writeln("dsd");
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
 document.getElementById("batch_id").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","details/get_batch.php?q="+str,true);
  xmlhttp.send();
}
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
  var selLanguage = document.getElementById("hours");
  var hour = "";
  for (i = 0; i < selLanguage.length; i++){
   currentOption = selLanguage[i];
   if (currentOption.selected == true){
	   
		  hour += "-" + currentOption.value ; 
   } 
  } 
	//document.writeln(hour);
	var batch_id=document.getElementById("batch_id").value;
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
  xmlhttp.open("GET","details/get_studentdetail.php?b="+batch_id + "&s=" + semester_setting_id + "&d="+ str + "&h=" + hour ,true);
  xmlhttp.send();
}
</script>
<?php
if(isset($_POST['submited']))
{
	//echo "submitted";
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
$period=$_POST["notes".$fhour];
///for new insert
//echo "select ae.adate  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'";
$num_rows = mysql_num_rows(mysql_query("select ae.adate from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'"));
 		$val=$num_rows>0?'1':'0';
		if($val==0)
		{
		$sql = "INSERT INTO attendance_entry( `adate` ,  `hour`,`day`,`staff_id`,`course_setting_id`,`period` ) VALUES('$adate','$fhour','$day','$staff_id','$course_id','$period') "; 
mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array ( mysql_query("SELECT max(id) as val FROM attendance_entry")); 
$max_id=stripslashes($row['val']);
$result = mysql_query("select * from student where  batch_id='$_POST[batch_id]'") or trigger_error(mysql_error()); 
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
$row = mysql_fetch_array ( mysql_query("select ae.id from  attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where adate='$adate' and hour='$fhour' and cs.semester_setting_id='$_POST[semester_setting_id]'")); 
$ae_id=stripslashes($row['id']);
$sql = "update attendance_entry set staff_id='$staff_id',course_setting_id='$course_id',period='$period' where id='$ae_id' "; 
echo $sql;
mysql_query($sql) or die(mysql_error());
$sql = "delete from  attendance_entry_detail where attendance_entry_id='$ae_id' "; 
mysql_query($sql) or die(mysql_error());
$result = mysql_query("select * from student where batch_id='$_POST[batch_id]'") or trigger_error(mysql_error()); 
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
	
 ?>
<?php	
}
else
{
	
}
if (!isset($_POST['submit']) and !isset($_POST['submited']) ) {
	//include('common.php');
	?>
    
    <table class='table table-striped table-bordered'>
<tr>
  <td>Department</td><td><div class="styled-select">
<select name='dept_id' class="form-control input-sh" onchange="showprogram(this.value)">
<option>select</option>
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";  
} 
?>
</select>
</div></td>
  <td colspan="2">Academic Year</td>
<td>
<select name="academicyear" class="form-control input-sh" id="academicyear">
<option>select</option>
<?php echo getacademicyear(); ?>                     
</select>
</td>
</tr>
<tr>
<td>Semester</td>
<td colspan="2"><select name="semester" class="form-control input-sh" id="semester">
                              <option>ODD</option>
                              <option>EVEN</option>
                            </select></td>
                            
<td>Date:</td>
<td colspan="2"><input type='text' name='adate' id='adate' value="<?php echo date("d-m-Y") ?>"  /> <a href="javascript:NewCssCal('adate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a></td>
</tr>
<tr>
<td colspan="6" align="center">
                            <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                            </td>
</tr>
</table>
<?php
}
else if (isset($_POST['submit']))
{
?>

<center>
<font face = "Times New Roman" size = "5"><b>CSI INSTITUTE OF TECHNOLOGY, THOVALAI</b></font></br>
<font face = "Times New Roman" size = "5"><b>DEPARTMENT OF <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_POST[dept_id]'")); 
echo strtoupper(stripslashes($row['dept_name'])); ?> </b></font></br>
<font face = "Times New Roman" size = "3"><b>Absent Register</b></font></br>
<table border="1" style="border-collapse: collapse" align="center">
<tr>
<td colspan="5" align="left"><b>Date:<?php echo $_POST['adate']; ?></b></td>
</tr>

<?php
$frow="";
$adate= date('Y-m-d', strtotime($_POST['adate']));
$sql = "SELECT ss.sem_start_date,ss.id,ss.batch_id,ss.year,ss.noofhours,d.dept_name from semester_setting ss inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' order by ss.year";
//echo $sql;
$result = mysql_query($sql) or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){
?>
<tr>
<td colspan="5" align="center"><b>Year:<?php echo numberToRoman($row['year']); ?></b></td>
</tr>
<tr>
<td><b>Roll NO</b></td>
<td><b>Student Name</b></td>
<td><b>Attendance Percentage</b></td>
<td><b>Feedback</b></td>
<td><b>Mentor sign</b></td>
</tr>
<?php
$num_rows1 = mysql_num_rows(mysql_query("select ae.hour from attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where cs.semester_setting_id='".$row['id']."' and ae.adate='$adate' and ae.hour='1'"));
if($num_rows1>0)
{
	$f_entered="";
}
else
{
$f_entered="<u>";
}
$f_n_absent=0;
$f_n_present=0;
$f_n_total=0;
$f_below_75=0;

$num_rows1 = mysql_num_rows(mysql_query("select ae.hour from attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where cs.semester_setting_id='".$row['id']."' and ae.adate='$adate' and ae.hour='5'"));
if($num_rows1>0)
{
	$v_entered="";
}
else
{
$v_entered="<u>";
}
$v_n_absent=0;
$v_n_present=0;
$v_n_total=0;
$v_below_75=0;

$result1 = mysql_query("select * from student where batch_id='$row[batch_id]'") or trigger_error(mysql_error()); 
$sno=0;
while($row1 = mysql_fetch_array($result1))
{ 
$f_n_total=$f_n_total+1;
$v_n_total=$v_n_total+1;
$total_hours=$row['noofhours'];
$total_entered=0;
$total_present=0;
$total_absent=0;
$hr_not_enter=0;
for($i=1;$i<=$row['noofhours'];$i++)
{

$num_rows1 = mysql_num_rows(mysql_query("select ae.hour from attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id where cs.semester_setting_id='".$row['id']."' and ae.adate='$adate' and ae.hour=$i"));
if($num_rows1>0)
{
	$total_entered=$total_entered+1;
$num_rows = mysql_num_rows(mysql_query("select ae.hour from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id where aed.student_id='".$row1['id']."' and ae.adate='$adate' and ae.hour=$i"));
 $val=$num_rows>0?'A':'P';
 
// echo "<td>" . $val . "</td>";
 if($val=="P")
 {
	  $total_present=$total_present +  1;
	  if($i==1)
	  {
		 $f_n_present=$f_n_present+1; 
	  }
	   if($i==5)
	  {
		 $v_n_present=$v_n_present+1; 
	  }
 }
 else
 {
	 if($i==1)
	  {
		 $f_n_absent=$f_n_absent+1; 
	  }
	  if($i==5)
	  {
		 $v_n_absent=$v_n_absent+1; 
	  }
	 $total_absent=$total_absent +  1;
 }
}
else
{
//$hr_not_enter=$hr_not_enter+1;
//echo "<td>" . "-" . "</td>";	
}
}
if($total_absent>0)
{

$fdate=date('Y-m-d', strtotime($row['sem_start_date']));
$tdate=date('Y-m-d', strtotime($_POST['adate'])); 
$th=0;
$tp=0;
$to=0;
$ta=0;
$result_4 = mysql_query("SELECT * FROM course_setting where semester_setting_id='$row[id]' order by order1") or trigger_error(mysql_error()); 
while($row_4 = mysql_fetch_array($result_4)){ 

$query = mysql_query("select * from stud_course_reg where course_id='$row_4[id]'");
$count=mysql_num_rows($query); 
?>
<?php
$sql="select count(*) as count from attendance_entry ae where ae.course_setting_id='". $row_4['id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate'";
$row1_1 = mysql_fetch_array ( mysql_query($sql));
$th= $th+ $row1_1['count'];
if ($th==0)
{
	$th=$th+0;
}

$count1=0;
if($count>0)
{
	$query = mysql_query("select * from stud_course_reg where course_id='$row_4[id]' and student_id='$row1[id]'");
$count1=mysql_num_rows($query); 
if($count1==0)
{
	$th=$th+0;
}
}
//echo "<td>" . $th ."</td>";
$sql="select count(*) as count from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.course_setting_id='". $row_4['id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row1[id]'";
$row1_1 = mysql_fetch_array ( mysql_query($sql));
$ta= $ta + $row1_1['count'];
$sql="select count(*) as count from od_entry ae inner join od_entry_detail aed on aed.od_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.semester_setting_id='". $row['id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row1[id]'";
$row1_1 = mysql_fetch_array ( mysql_query($sql));
$to= $to + $row1_1['count'];

if($count>0)
{
	$query = mysql_query("select * from stud_course_reg where course_id='$row_4[id]' and student_id='$row1[id]'");
$count1=mysql_num_rows($query); 
if($count1=="")
{
	$tp=$tp+0;
}
}
if($tp==0)
{
	$tp=$tp+0;
}

//echo "<td>" . $tp ."</td>";
			
			?>
          
            <?php
		}
		$tp=$th-$ta;
$tp=$tp+$to;
if($tp>$th)
{
$tp=$th;	
}
$attper=($tp/$th)*100;
if($attper<75)
{
	$f_below_75=$f_below_75+1;
	$v_below_75=$v_below_75+1;
}
echo "<tr>";
echo "<td>" . $row1["univ_regno"] .  "</td>";
echo "<td>" . $row1["name"] .  "</td>";
echo "<td align='center'>" .  round($attper,2) .  "</td>";
echo "<td>" . "" .  "</td>";
echo "<td>" . "" .  "</td>";
echo "</tr>";
}

}

if($f_below_75==0)
{
$f_below_75="Nill";	
}
if($f_n_absent==0)
{
$f_below_75="Nill";	
}

if($v_below_75==0)
{
$v_below_75="Nill";	
}
if($v_n_absent==0)
{
$v_below_75="Nill";	
}

$p_p=($f_n_present/$f_n_total)*100;
$frow=$frow . "<tr><td>" ."<b>". numberToRoman($row['year']) . " YEAR</b></td>";
$frow=$frow . "<td><b>". numberToRoman($row['year']) . " YEAR</b></td></tr>";
$frow=$frow . "<tr><td>" .  $f_entered . "No of Absentees = " . $f_n_absent  . "</br>" . "No. of Students Present =". $f_n_present . "/" . $f_n_total . " ie " . round($p_p,2) ."</br>" . "No of absentees who has attendance below 75 % = ". $f_below_75 .  "</td>";
$p_p=($v_n_present/$f_n_total)*100;
$frow=$frow . "<td>" .  $v_entered . "No of Absentees = " . $v_n_absent  . "</br>" . "No. of Students Present =".  $v_n_present . "/" . $v_n_total . " ie " . round($p_p,2) ."</br>" . "No of absentees who has attendance below 75 % = ". $v_below_75 .  "</td></tr>";
}
?>

</table>
</br>
<table border="1" style="border-collapse: collapse" align="center">
<tr>
<td><b>First hour Report</b></br>
<b><?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_POST[dept_id]'")); 
echo strtoupper(stripslashes($row['s_name'])); ?> Department</b></br>
<?php echo $_POST['adate']; ?> Morning  Attendance detail
</td>
<td><b>Fifth hour Report</b></br>
<b><?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_POST[dept_id]'")); 
echo strtoupper(stripslashes($row['s_name'])); ?> Department</b></br>
<?php echo $_POST['adate']; ?> Afternoon  Attendance detail
</td>
</tr>
<?php
echo $frow;
?>
</table>


<?php
}
else
{
	echo "hai";
}
    //include('footer.php');
?>  