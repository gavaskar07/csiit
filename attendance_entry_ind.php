<?php 
include('config.php');
include('header.php');
?>
<ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Attendance Entry</li>
        </ol>
        <script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
        <form action="" method="post">
 <?php
 if (!isset($_POST['submit']) and !isset($_POST['submited']) and !isset($_POST['a_submit']) ) 
 {	
?>
<table class='table table-striped table-bordered'>
<tr>
  <td>Date</td>
  <td>
  <input type='text' name='adate' id='adate' /> <a href="javascript:NewCssCal('adate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
  <td>
  <button type="submit" class="btn btn-success" name="submit" >Submit</button>
  </td>
  </tr>
<?php
 }
 else if(isset($_POST['submit']))
 {
	 $atdate = $_POST['fdate'];
 $adate= date('Y-m-d', strtotime($atdate));
 $dayOfWeek = date("l", strtotime($adate));
$day=$dayOfWeek;
$day_of_week = date('N', strtotime($day));
$day=$day_of_week;
$sql = "SELECT cs.id,cs.sub_code,cs.sub_name,t.period,ss.id as sid,b.id as bid from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id inner join timetable t on t.course_staffmapping_id=csm.id   where csm.staff_id='$_SESSION[userid]' and cs.subtype='Theory' and t.day='$day'";
$result_0 = mysql_query($sql) or trigger_error(mysql_error());
	?>
  <table class='table table-striped table-bordered'>
<tr>
<td>Subject/Hour:</td>
<td>
<select name='hours[]' onchange="showstudent(this.value)" id='hours' multiple >
<?php
while($row_0 = mysql_fetch_array($result_0)){ 
?>
<option value='<?php echo $row_0['period']; ?>'> <?php echo "Hour-".$row_0['period'] . "-" . $row_0['sub_name'] ;?></option> 
<?php
}
?>
</select>
</td>
<td>Attendance Date:</td>
<td>
<?php echo $_POST['adate']; ?>
<input type="hidden" value="<?php echo $_POST['adate']; ?>" name="adate"/>
</td>
</tr>
<tr>
<td colspan="4">
<button type="submit" class="btn btn-success" name="a_submit" >Submit</button>
</td>
</tr>
</table>
</form>  
    <?php 
 }
 else if(isset($_POST['a_submit']))
 {
	$day= $_POST['hours'];
if( is_array($day)){
while (list ($key, $val) = each ($day)) {
//echo "Day:".$val ."<br>";
$sday=$sday . "-" . $val;
}
}
echo $sday;
$hr_p="";
$ind_hr = explode("-", $sday);
for($i = 0; $i < count($ind_hr); $i++){
	//echo "Piece $i = $ind_hr[$i] <br />";
	if($i==0)
	{
		$hr_p=$hr_p . $ind_hr[$i];
	}
	else if($i==(count($ind_hr)-1))
	{
		$hr_p=$hr_p . $ind_hr[$i];
	}
	else
	{
	$hr_p=$hr_p . $ind_hr[$i].  ",";
	}
}
echo $hr_p;
$atdate = $_POST['adate'];
 $adate= date('Y-m-d', strtotime($atdate));
 $dayOfWeek = date("l", strtotime($adate));
$day=$dayOfWeek;
$day_of_week = date('N', strtotime($day));
$day=$day_of_week;
$sql = "SELECT distinct ss.id as sid,b.id as bid,cs.sub_code,cs.sub_name from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id inner join timetable t on t.course_staffmapping_id=csm.id   where csm.staff_id='$_SESSION[userid]' and cs.subtype='Theory' and t.day='$day' and t.period in($hr_p)";
echo $sql;
$result = mysql_query($sql) or trigger_error(mysql_error());
$cno=0;
$batch = "";
 $semester = "";
 $subcode = "";
 $subject = "";
while($row = mysql_fetch_array($result)){ 
$cno=$cno+1;
$batch = $row['bid'];
 $semester = $row['sid'] ;
 $subcode = $row['sub_code'];
 $subject = $row['sub_name'];
}
if($cno>1)
{
	echo "select same class";
}
else
{
?>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" id="sampletable">
 <thead>
<tr>
    <td>Date</td>
    <td><?php echo $_POST['adate']; ?></td>
    <td>Subject</td>
   <td><?php echo $subcode."/".$subject; ?></td>
   <td>Hours</td>
   <td><?php echo $hr_p; ?></td>
  </tr>
   </thead>	
   </table>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover" id="sampletable">
 <thead>
<tr>
    <th>Sl.No</th>
    <th>Roll No</th>
    <th>Registration No</th>
   <th>Name</th>
   <th>Status</th>
  </tr>
   </thead>	
	<?php
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM semester_setting where id='$semester'")); 
$startdate=stripslashes($row['sem_start_date']);
$enddate=stripslashes($row['sem_end_date']);
//echo $startdate;
//echo $enddate;
//echo $adate;
$sd = new DateTime($startdate);
$ed = new DateTime($enddate);
$ad = new DateTime($adate);
$check=0;
 if($ad<$sd)
 {
	$check=1; 
 }
 if($ad>$ed)
 {
	$check=1; 
 }
 if($check==0)
 {
$result = mysql_query("select * from student where status<>'In Active' and batch_id='$batch' order by rollno") or trigger_error(mysql_error()); 
$i=0;
while($row = mysql_fetch_array($result))
{ 
$i++;
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
//echo "select ae.hour from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id where aed.student_id='".$row['id']."' and ed.adate='$adate' and ae.hour in ($hr_p) ";
$num_rows = mysql_num_rows(mysql_query("select ae.hour from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id where aed.student_id='".$row['id']."' and ae.adate='$adate' and ae.hour in ($hr_p) "));
 $val=$num_rows>0?'checked':'';
echo "<tr><td>" . $i . "</td><td>". nl2br( $row['rollno']) ."</td><td>". nl2br( $row['univ_regno']) ."</td><td>".nl2br( $row['name']) . "</td><td><input name='mset".$row['id']."' type='checkbox' ".$val." value='".nl2br( $row['id'])."' ></td></tr>";  
echo "<input name=". "'h" .  $row['id'] . "'" . "type='hidden' value='" . $row['id']. "'/>";
} 
 }
 else
 {
	 echo "invalid date";
 }
?>
<?php
$ind_hr = explode(",", $hr_p);
$fh="";
for($i = 0; $i < count($ind_hr); $i++){
	//echo "Piece $i = $ind_hr[$i] <br />";
	//$hr_p=$hr_p . $ind_hr[$i].  ",";

?>
<tr>
<td>Hour-<?php echo $ind_hr[$i]; ?> </td>
<td colspan="2"><select name='course_id_<?php echo $ind_hr[$i]; ?>' id='course_id'>
<option>select</option>
<?php
$result = mysql_query("SELECT * FROM course_setting where semester_setting_id=' $semester' order by order1") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['sub_code']) . "-" . nl2br( $row['sub_name']) . "</option>";  
} 
?>
</select></td>
<td>Topic</td>
<td colspan="2"><textarea name="notes<?php echo $ind_hr[$i]; ?>" rows="3" cols="40"></textarea></td>
</tr>

<?php
}
?>
<tr>
<td colspan="6" align="center">
<button type="submit" class="btn btn-success" name="submited" >Submit</button>
</td>
</tr>
</table>
</div>
<?php	
}

 }
?>