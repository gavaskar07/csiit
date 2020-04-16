<?php
//include('config.php');
include('attendance_rpt_dwise_detail.php');
if(isset($_POST['get_attendance']))
{
	
}
else if(isset($_POST['period1']))
{
	
}
else
{
include('header.php');
}
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
?>
  <form name="f1" method="post" action="">
<script>
function myFunction() {
    window.print();
}
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
<?php
if (!isset($_POST['submit']) and !isset($_POST['get_attendance']) and !isset($_POST['period1'])) {
	//include('common.php');
	?>
   
    <table class='table table-striped table-bordered'>
<tr>
  <td>Department</td>
  
  <td>
  <?php
  if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" or $_SESSION['user_type']=="Faculty" )
  {

  ?>
  <div class="styled-select">
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
</div>
<?php
  }
  else
{
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_SESSION[department]'")); 
$dname=stripslashes($row['dept_name']);
echo $dname
?>
<input type="hidden" name="dept_id" value="<?php echo $_SESSION['department'];  ?>"/>
<?php
}
?>
</td>
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
                            
<td>Year</td>
<td>
<select name="year" class="form-control input-sh" id="year">
<option>select</option>
<?php echo getyear(); ?>                     
</select>
</td>
</tr>
<tr>
<td colspan="6" align="center">
<input type="hidden" name="option" value="<?php echo $_GET['option']; ?>"/>
                            <button type="submit" class="btn btn-success" name="submit" >Submit</button>
                            </td>
</tr>
</table>
<?php
}
else if(isset($_POST['period1']))
  {
	if($_POST['period']=="0" or $_POST['period']=="1")
	{
	?>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container" id="box">
	<div class="row well">
    <center>
             <button class="btn btn-primary hidden-print" onclick="myFunction()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
	    </center>
    <table align="center" border="1">
        <tr>
        <td colspan="2" align="center"><h3>CSI Institute of Technology,Thovalai</h3></td>
        </tr>
        
        <?php
		$sql = "SELECT b.id as bid,d.id as did,cs.sub_code,cs.sub_name,cs.noofcredits,cs.subtype,s.staff_name,d.s_name,ss.year,ss.semesterno from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id  where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and cs.id='$_POST[course_id]'";
		//echo $sql;
		$faculty="";
		$subject="";
		$sem="";
		$dept="";
		$batch_id="";
        $result_2 = mysql_query($sql) or trigger_error(mysql_error()); 
while($row_2 = mysql_fetch_array($result_2)){
	$faculty=$row_2['staff_name'];
	$subject=$row_2['sub_code'] . "/" . $row_2['sub_name'] . "";
	$sem=$row_2['s_name'] . "/" . numberToRoman($row_2['year']) . "/" . numberToRoman($row_2['semesterno']) ;
	$dept=$row_2['did'];
	$batch_id=$row_2['bid'];
}?>
<tr>
        <td colspan="2" align="center"><b>Department of <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$dept'")); 
echo stripslashes($row['dept_name']); ?></b></td>
        </tr>
       <tr>
       <td><b>Name of the Faculty</b></td>
       <td><?php  echo $faculty; ?></td>
       </tr>
       <tr>
       <td><b>Name of the Subject and Code</b></td>
       <td><?php  echo $subject; ?></td>
       </tr>
        <tr>
       <td><b>Branch/Year/Semester</b></td>
       <td><?php  echo $sem; ?></td>
       </tr>
       <tr>
       <td colspan="2">
       <table border="1">
       <tr>
       <td><b>Sl.No</b></td>
        <td><b>Reg No</b></td>
         <td><b>NAME OF THE STUDENT</b></td>
         <?php
		  $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and  bid IS NULL";
	}
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {?>
                     <td colspan="3"><b>Report <?php echo numberToRoman($data['Period']) . "  ". date('d-m-Y', strtotime($data['fdate'])) . " - " . date('d-m-Y', strtotime($data['tdate']));   ?></b></td>
<?php
					 }
					 else
					 {
			?>
            <td colspan="4"><b>Report <?php echo numberToRoman($data['Period']) . "  ". date('d-m-Y', strtotime($data['fdate'])) . " - " . date('d-m-Y', strtotime($data['tdate']));   ?></b></td>
            <?php
					 }
		}
		 ?>
         <td>Remark</td>        
       </tr>
       <tr>
       <td></td>
       <td></td>
       <td></td>
       <?php
	   $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'  and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {
						 ?>
                         <td>No of hrs handled</td>
            <td>No of hrs attd</td>
            <td>Attendance %</td>
            
                         <?php
					 }
					 else
		{
			?>
            <td>No of hrs handled</td>
            <td>No of hrs attd</td>
            <td>Attendance %</td>
            <td>Test Mark-<?php echo $data['Period']-1;  ?></td>
            <?php
		}
		}
		 ?>
       <td></td>
       </tr>
       <?php
		$result_1 = mysql_query("select * from student where  batch_id='$batch_id' ORDER BY CAST(univ_regno as unsigned) asc") or trigger_error(mysql_error()); 
$sno=0;
while($row_1 = mysql_fetch_array($result_1))
{ 
$sno=$sno+1;
?>
<tr>
<td><?php echo $sno;  ?></td>
<td><?php echo $row_1['univ_regno']  ?></td>
<td><?php echo $row_1['name']  ?></td>
 <?php
  $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'  and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			$fdate=date('Y-m-d', strtotime($data['fdate']));
			$tdate=date('Y-m-d', strtotime($data['tdate']));
			$sql="select count(*) as count from attendance_entry ae where ae.course_setting_id='". $_POST['course_id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$th= $row1['count'];
if ($th==0)
{
	$th="";
}
echo "<td>" . $th ."</td>";
$sql="select count(*) as count from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.course_setting_id='". $_POST['course_id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row_1[id]'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$ta= $row1['count'];
$sql="select count(*) as count from od_entry ae inner join od_entry_detail aed on aed.od_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.semester_setting_id='". $_POST['semester_setting_id'] ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row_1[id]'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$to= $row1['count'];
$tp=$th-$ta;
$tp=$tp+$to;
if($tp==0)
{
	$tp="";
}
if($tp>$th)
{
	$tp=$th;
}
echo "<td>" . $tp ."</td>";
$attper=($tp/$th)*100;
if($attper==0)
{
	echo "<td>" . "" ."</td>";
}
else
{
echo "<td>" . round($attper,0)  ."</td>";
}
//$attper=$ap/5;
$attper=($attper/100)*5;
		//	if($data['Period']<>"1")
			//		 {
						 //if($data['Period']=="2")
						 ?>
                         <?php


if($data['Period']>=2)
{
echo period2($row_1['id'], $_POST['course_id'],$attper,$data['Period'],'c');
}
//}


					 //}
					 
			?>
          
            <?php
		}
		
		 ?>
         <td></td>
</tr>
<?php
}
	   ?>
      <tr>
      <td colspan="3" align="center"><b>Signature of the faculty</b></td>
       <?php
	   $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {?>
                     <td colspan="3"></td>
<?php
					 }
					 else
					 {
			?>
            <td colspan="4"></td>
            <?php
					 }
		}
		 ?>
         <td></td>
      </tr> 
       <tr>
      <td align="center" colspan="3"><b>Signature of the HOD</b></td>
       <?php
	   $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {?>
                     <td colspan="3"></td>
<?php
					 }
					 else
					 {
			?>
            <td colspan="4"></td>
            <?php
					 }
		}
		 ?>
         <td></td>
      </tr> 
       <tr>
      <td colspan="3" align="center"><b>Signature of the Principal</b></td>
       <?php
	   $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {?>
                     <td colspan="3"></td>
<?php
					 }
					 else
					 {
			?>
            <td colspan="4"></td>
            <?php
					 }
		}
		 ?>
         <td></td>
      </tr> 
       </table>
       </td>
       </tr>
       
        
        
        </table>
      </div>
</div>
<?php  
	  
  }
 else
  {
	  ?>

        
        
        <?php
		$sql = "SELECT b.id as batch,ss.id as sid,d.id as did,cs.sub_code,cs.sub_name,cs.noofcredits,cs.subtype,s.staff_name,d.s_name,ss.year,ss.semesterno from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id  where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and cs.id='$_POST[course_id]'";
		$faculty="";
		$subject="";
		$sem="";
		$dept="";
        $result_2 = mysql_query($sql) or trigger_error(mysql_error()); 
while($row_2 = mysql_fetch_array($result_2)){
	$faculty=$row_2['staff_name'];
	$subject=$row_2['sub_code'] . "/" . $row_2['sub_name'] . "";
	$sem=$row_2['s_name'] . "/" . numberToRoman($row_2['year']) . "/" . numberToRoman($row_2['semesterno']) ;
	$dept=$row_2['did'];
	$batch=$row_2['batch'];
	$batch_id=$row_2['batch'];
	$semid=$row_2['sid'];
}?>

        <center>
<font face = "Times New Roman" size = "5"><b>CSI INSTITUTE OF TECHNOLOGY, THOVALAI</b></font></br>
<font face = "Times New Roman" size = "5"><b>DEPARTMENT OF <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$dept'")); 
echo strtoupper(stripslashes($row['dept_name'])); ?> </b></font></br>
<font face = "Times New Roman" size = "3"><b><?php echo $_POST['academicyear'] . " - " . $_POST['semester'];  ?></b></font></br>
<?php
$period=$_POST['period'];
$pv="";
if($period=="1")
{
	$pv="Period-I";
}
if($period=="2")
{
	$pv="Period-II";
}
if($period=="3")
{
	$pv="Period-III";
}
if($period=="4")
{
	$pv="Period-IV";
}
?>
<font face = "Times New Roman" size = "3"><b><?php echo $pv  ?> Assesment Mark Calculation</b></font></br>

        <table border="1" style="border-collapse: collapse" align="center">
       <tr>
       <td colspan="9" align="right"><b>Name of the Faculty</b></td>
       <td colspan="10"><?php  echo $faculty; ?></td>
       </tr>
       <tr>
       <td colspan="9" align="right"><b>Name of the Subject and Code</b></td>
       <td colspan="10"><?php  echo $subject; ?></td>
       </tr>
        <tr>
       <td colspan="9" align="right"><b>Branch/Year/Semester</b></td>
       <td colspan="10"><?php  echo $sem; ?></td>
       </tr>
       <?php
	   $p=$_POST['period'];
	   if($p=="2")
	{
	$iat_n="IAT-I";
	$iat_n_r="IAT Retest-I";
	$ct1_n="Class Test-I";
	$ct1_n_r="Class Test Retest-I";
	$ct2_n="Class Test-II";
	$ct2_n_r="Class Test Retest-II";
	$as_n="Assignment-I";
	}
	if($p=="3")
	{
	$iat_n="IAT-II";
	$iat_n_r="IAT Retest-II";
	$ct1_n="Class Test-III";
	$ct1_n_r="Class Test Retest-III";
	$ct2_n="Class Test-IV";
	$ct2_n_r="Class Test Retest-IV";
	$as_n="Assignment-II";
	}
	if($p=="4")
	{
	$iat_n="IAT-III";
	$iat_n_r="IAT Retest-III";
	$ct1_n="Class Test-V";
	$ct1_n_r="Class Test Retest-V";
	$ct2_n="Class Test-VI";
	$ct2_n_r="Class Test Retest-VI";
	$as_n="Assignment-III";
	}
	
	   ?>
<tr>
<td><b>Sl.No</b></td>
<td><b>Roll No</b></td>
<td><b>Name</b></td>
<td><b><?php echo $iat_n;  ?></b></td>
<td><b><?php echo $iat_n_r;  ?></b></td>
<td><b>IAT Max</b></td>

<td><b><?php echo $ct1_n;  ?></b></td>
<td><b><?php echo $ct1_n_r;  ?></b></td>
<td><b><?php echo $ct1_n;  ?> Max</b></td>
<td><b><?php echo $ct1_n;  ?>/5</b></td>

<td><b><?php echo $ct2_n;  ?></b></td>
<td><b><?php echo $ct2_n_r;  ?></b></td>
<td><b><?php echo $ct2_n;  ?> Max</b></td>
<td><b><?php echo $ct2_n;  ?>/5</b></td>

<td><b><?php echo $as_n;  ?></b></td>
<td><b><?php echo $as_n;  ?>/5</b></td>

<td><b>Attendance</b></td>
<td><b>Attendance/5</b></td>

<td><b>Mark</b></td>
</tr>


  <?php
		$result_1 = mysql_query("select * from student where  batch_id='$batch' ORDER BY CAST(univ_regno as unsigned) asc") or trigger_error(mysql_error()); 
$sno=0;
while($row_1 = mysql_fetch_array($result_1))
{ 
$sno=$sno+1;
?>
<tr>
<td><?php echo $sno;  ?></td>
<td><?php echo $row_1['univ_regno']  ?></td>
<td><?php echo $row_1['name']  ?></td>
 <?php
 $query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]' and bid='$batch_id'";
	}
	else
	{
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]' and bid IS NULL";
	}
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			$fdate=date('Y-m-d', strtotime($data['fdate']));
			$tdate=date('Y-m-d', strtotime($data['tdate']));
			
//$attper=($ap/100)*5;
$attper=attendance($row_1['id'],$_POST['course_id'],$fdate,$tdate,$semid,0);
//include('attendance_rpt_dwise_detail.php');
//echo "<td>".$_POST['period']. "</td>";
$p=$_POST['period'];
if($p>=2)
{
echo period2($row_1['id'],$_POST['course_id'],$attper,$p,'d');
}
			?>
          
            <?php
		}
		 ?>
        
</tr>
<?php
}
	   ?>
</table>
<?php
  }
  }
else
{
	?>
    <table class='table table-striped table-bordered'>
        <tr>
        <td>Department:<?php
		$row = mysql_fetch_array ( mysql_query("SELECT dept_name FROM department where id=$_POST[dept_id]")); 
$dept_name=stripslashes($row['dept_name']);
    echo "<td>" . $dept_name . "</td>";
		?></td>
         <td>Academic Year</td>
          <td><?php echo $_POST['academicyear'];?></td>
          <td>Semester</td>
          <td><?php echo $_POST['semester'];?></td>
          <td>Year:</td>
          <td><?php echo $_POST['year'];?></td>
        </tr> 
        </table>
     <table class='table table-striped table-bordered'>
    <tr>
<?php
$row = mysql_fetch_array ( mysql_query("SELECT distinct ss.id,p.id as pid,b.id as bid from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' and ss.year='$_POST[year]'")); 

$semester_setting_id=$row['id'];
?>
<input type="hidden" name="dept_id" value="<?php echo $_POST[dept_id];  ?>"/>
<input type="hidden" name="program_id" value="<?php echo stripslashes($row['pid']);  ?>"/>
<input type="hidden" name="batch_id" value="<?php echo stripslashes($row['bid']);  ?>"/>
<input type="hidden" name="academicyear" value="<?php echo $_POST['academicyear'];  ?>"/>
<input type="hidden" name="semester" value="<?php echo $_POST['semester'];  ?>"/>
<input type="hidden" name="semester_setting_id" value="<?php echo $semester_setting_id;  ?>"/>
<td>Course Name</td>
<td>
<select class="selectpicker" name='course_id' id='course_id' multiple data-max-options="1">
<option>select</option>
<?php
$sql="SELECT distinct ss.id,p.id as pid,b.id as bid,b.batchname from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' and ss.year='$_POST[year]'";
$result_get = mysql_query($sql) or trigger_error(mysql_error());
while($row_get = mysql_fetch_array($result_get)){
$semester_setting_id=stripslashes($row_get['id']);
if($_SESSION['user_type']=="Faculty")
  {
	$result = mysql_query("SELECT cs.id,cs.sub_code,cs.sub_name,s.staff_name FROM course_setting cs inner join course_staffmapping csm on cs.id=csm.course_id inner join staff s on s.id=csm.staff_id where cs.semester_setting_id='$semester_setting_id' and s.id=$_SESSION[userid] order by order1") or trigger_error(mysql_error());  
  }
  else
  {
$result = mysql_query("SELECT cs.id,cs.sub_code,cs.sub_name,s.staff_name FROM course_setting cs inner join course_staffmapping csm on cs.id=csm.course_id inner join staff s on s.id=csm.staff_id where cs.semester_setting_id='$semester_setting_id' order by order1") or trigger_error(mysql_error()); 
  }
$checkval=0;
?>
<optgroup label="<?php echo $row_get['batchname']; ?>">;
<?php
while($row = mysql_fetch_array($result)){ 
$checkval=1;
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['sub_code']) . "-" . nl2br( $row['sub_name']) . "-" . nl2br( $row['staff_name'])  . "-" . $row_get['batchname'] .  "</option>";  
} 
echo "</optgroup>";
}
?>
</select>
</td>
<td>
Select Period:
</td>
<td>
 <select name='period' class="form-control input-sh">
<option value="0">All Period Report</option>
<?php
$row1 = mysql_fetch_array ( mysql_query("SELECT * FROM current_ayear")); 
$ayear=stripslashes($row1['ayear']);
$sem=stripslashes($row1['semester']);
$result = mysql_query("SELECT distinct Period FROM report_period where academicyear='$ayear' and semester='$sem'") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br($row['Period']) ."'>" . "Period-".$row['Period'] . "</option>";  
} 
?>
</select>
</td>
<td>
</td>
</tr>
<tr>
<td colspan="4" align="center">
<!-- <button type="submit" class="btn btn-success" name="get_attendance" formtarget="_blank" >All Period Report</button>-->
  <button type="submit" class="btn btn-success" name="period1" formtarget="_blank" >View</button>
</td>
</tr>
    </table>
    
    <?php
}


?>
</form>

<?php
if(isset($_POST['get_attendance']))
  {
  }
 else if(isset($_POST['period1']))
  {
  }
  else
  {
include('footer.php');
  }
for ($x = 1; $x <= 2; $x++) {
		echo "<script>";
		echo "$('#datepicker".$x."').datepicker({";
      echo "autoclose: true";
       echo "}) </script>";
	}
?>