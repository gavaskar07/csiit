<?php
include('config.php');
if(isset($_POST['get_attendance']))
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
 </br>
   </br> </br>
   </br> </br>
  
  <form name="f1" method="post" action="">
<script>
function myFunction() {
    window.print();
}
</script>

<?php
if (!isset($_POST['submit']) and !isset($_POST['get_attendance'])) {
	//include('common.php');
	?>
   
    <table class='table table-striped table-bordered'>
<tr>
  <td>Department</td>
  
  <td>
  <?php
  if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" )
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
else if(isset($_POST['submit']))
  {
	  
	  
	?>

        <?php
		$sql="SELECT distinct d.dept_name,ss.id,p.id as pid,b.id as bid,b.batchname,ss.semesterno from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' and ss.year='$_POST[year]'";
$result_get = mysql_query($sql) or trigger_error(mysql_error());

		while($row_get = mysql_fetch_array($result_get)){
			
	
		?>
    <table align="center" border="1">
        <tr>
        <td colspan="2" align="center"><h3>CSI Institute of Technology,Thovalai</h3></td>
        </tr>
        
        <?php
		//$row = mysql_fetch_array ( mysql_query("SELECT distinct ss.id,p.id as pid,b.id as bid from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' and ss.year='$_POST[year]'")); 		
$semester_setting_id=stripslashes($row_get['id']);
$batch_id=stripslashes($row_get['bid']);
		$sql = "SELECT d.id as did,cs.sub_code,cs.sub_name,cs.noofcredits,cs.subtype,s.staff_name,d.s_name,ss.year,ss.semesterno from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff s on s.id=csm.staff_id  where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and ss.id='$semester_setting_id'";
		$faculty="";
		$subject="";
		$sem="";
		$dept="";
        $result_2 = mysql_query($sql) or trigger_error(mysql_error()); 
while($row_2 = mysql_fetch_array($result_2)){
	
	$sem=$row_2['s_name'] . "/" . numberToRoman($row_2['year']) . "/" . numberToRoman($row_2['semesterno']) ;
	$dept=$row_2['did'];
}

?>
<tr>
        <td colspan="2" align="center"><b>Department of <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$dept'")); 
echo stripslashes($row['dept_name']); ?></b></td>
        </tr>
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
	$sno=0;
		while($data = mysql_fetch_array($rs))
		{
			if($data['Period']=="1")
					 {?>
                     <td colspan="4"><b>Report <?php echo numberToRoman($data['Period']) . "  ". date('d-m-Y', strtotime($data['fdate'])) . " - " . date('d-m-Y', strtotime($data['tdate']));   ?></b></td>
<?php
					 }
					 else
					 {
			?>
            <td colspan="5"><b>Report <?php echo numberToRoman($data['Period']) . "  ". date('d-m-Y', strtotime($data['fdate'])) . " - " . date('d-m-Y', strtotime($data['tdate']));   ?></b></td>
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
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
            <td>No of OD Hrs</td>
            <td>Attendance %</td>
            
                         <?php
					 }
					 else
		{
			?>
            <td>No of hrs handled</td>
            <td>No of hrs attd</td>
            <td>No of OD Hrs</td>
            <td>Attendance %</td>
            <td>Test Mark-<?php echo $data['Period']-1;  ?></td>
            <?php
		}
		}
		 ?>
       <td></td>
       </tr>
       <?php
		$result_1 = mysql_query("select * from student where batch_id='$batch_id' ORDER BY CAST(univ_regno as unsigned) asc") or trigger_error(mysql_error()); 
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
//echo $query;
	$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			$fdate=date('Y-m-d', strtotime($data['fdate']));
			$tdate=date('Y-m-d', strtotime($data['tdate']));
			$sql="select count(*) as count from attendance_entry ae where ae.course_setting_id in (select id from course_setting where semester_setting_id='$semester_setting_id') and ae.adate>='$fdate' and ae.adate<='$tdate'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$th= $row1['count'];
if ($th==0)
{
	$th="";
}
echo "<td>" . $th ."</td>";
$sql="select count(*) as count from attendance_entry ae inner join attendance_entry_detail aed on aed.attendance_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.course_setting_id in (select id from course_setting where semester_setting_id='$semester_setting_id') and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row_1[id]'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$ta= $row1['count'];
$sql="select count(*) as count from od_entry ae inner join od_entry_detail aed on aed.od_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.semester_setting_id='". $semester_setting_id ."' and ae.adate>='$fdate' and ae.adate<='$tdate' and aed.student_id='$row_1[id]'";
$row1 = mysql_fetch_array ( mysql_query($sql));
$to= $row1['count'];
$value= "<td>" . $to ."</td>";
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
echo $value;
$ap=round(($tp/$th)*100);
if($ap==0)
{
	echo "<td>" . "0" ."</td>";
}
else
{
echo "<td>" . $ap  ."</td>";
}
			if($data['Period']<>"1")
					 {
						 echo "<td></td>";
					 }
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
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
		 $query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]'";
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
        
        <?php
			}
		?>
      </div>
</div>
<?php  
	  
  }
else
{
	?>
   
    
    <?php
}
?>
</form>
</table>

<?php
if(isset($_POST['get_attendance']))
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