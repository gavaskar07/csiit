
<?php 
if (!isset($_POST['submit']))
{
include('config.php');
include('header.php');
}
else
{
	include('config.php');
	?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
 <meta name="author" content="">
<title>CSIIT</title>
<script src="fullwidth/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="account/fullwidth/js/bootstrap.min.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="account/fullwidth/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="account/fullwidth/css/modern-business.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="account/fullwidth/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    <script language="javascript" type="text/javascript" src="scripts/datetimepicker_css.js"> 
</script>
<script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
</head>
<body>   
    <?php
   //include('header_print.php');
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
        <!-- Breadcrumbs-->
        
        <p>
         
       <?php
	   if (!isset($_POST['submit']))
{
	?>
    <form name="f" action="" method="post">
<table class='table table-striped table-bordered'>
<tr>
  <td>Department</td>
  <?php
  if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" )
  {

  ?>
  <td><div class="styled-select">
<select name='dept_id' class="form-control input-sh" onchange="showprogram(this.value)">
<option>All</option>
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";  
} ?>
</select>
<?php
}
else
{
	$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_SESSION[department]'")); 
$dname=stripslashes($row['dept_name']);
?>
<input type="hidden" name="dept_id" value="<?php echo $_SESSION['department'];  ?>"/>
<?php

?>
<td>

<?php
echo $dname;
}
?>

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
<?php
$row1 = mysql_fetch_array ( mysql_query("SELECT * FROM current_ayear")); 
$sem=stripslashes($row1['semester']);
?>
<td colspan="2"><select name="semester" class="form-control input-sh" id="semester">
<?php
if($sem=="ODD")
{
?>
 <option selected="selected">ODD</option>
 <option>EVEN</option>
  <?php
}
else
{
	?>
    <option>ODD</option>
<option  selected="selected">EVEN</option>
    <?php
}
?>
</select>
                         
</td>
<td>Exam</td>
  
  <td>
  <select name='exam' id='exam' onchange="showstudent(this.value)">
<option>select</option>
<?php
getexam();
?>
</select>
  </td> 
  </tr>
  <td>                         
<td colspan="4">  <button type="submit" class="btn btn-success" name="submit" >Submit</button></td>

</tr>

</table>
<?php
}
else
{
?>
        
       <?php 
	   $sql = "SELECT ss.semester,ss.semesterno,ss.id as sid,ss.year,b.id as bid,YEAR(sem_start_date) as syear,MONTHNAME(sem_start_date) as smonth,YEAR(sem_end_date) as eyear,MONTHNAME(sem_end_date) as emonth from semester_setting  ss inner join  batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' order by ss.year";
echo "<tr>";
$result_1 = mysql_query($sql) or trigger_error(mysql_error());
$cnt=0;
while($row_1 = mysql_fetch_array($result_1)){
	$cnt=$cnt+1;
	$year="";
	if($row_1['year']=="1")
	{
		$year="I";
	}
	if($row_1['year']=="2")
	{
		$year="II";
	}
	if($row_1['year']=="3")
	{
		$year="III";
	}
	if($row_1['year']=="4")
	{
		$year="IV";
	}
?>
<table border="1" align="center">
<?php
if($cnt==1)
{
?>
<tr align="center">
        <td colspan="10" >
       <h4>CSI Institute of Technology</h4>
       <h4>Department of <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_POST[dept_id]'")); 
echo stripslashes($row['dept_name']); ?></h4>
        </td>
        </tr>
        
 <tr align="center">
        <td colspan="10" >
        <b><?php echo $_POST['semester'] . " Semester" . " : ". $row_1['smonth'] . " ". $row_1['syear'] . " - ". $row_1['emonth'] . " ". $row_1['eyear']; ?></b>
        </td>
        </tr>
        <tr align="center">
        <td colspan="10">
        <b><?php echo $_POST['exam'] . " Class Performance";?></b>
        </td>
        </tr>
        <tr>
        <?php
}
		?>
        <?php
		$sql="SELECT count(*) as count FROM student where batch_id='$row_1[bid]'";
		 $row = mysql_fetch_array ( mysql_query($sql));
		 $total_count=$row['count'];
		?>
        <td colspan="3" align="right" ><b>Class: Year/ Sem & Strength:</b></td>
        <td colspan="3"><b><?php echo $year . "/".  numberToRoman($row_1['semesterno']) . "/" . $total_count ;?> </b></td>
         <td>
         <?php
		 $pass=0;
		 $tsubject=0;
		 $total_count=0;
		 $sql="SELECT count(*) as count FROM student where batch_id='$row_1[bid]'";
		 $row = mysql_fetch_array ( mysql_query($sql));
		 $total_count=$row['count'];
		 //echo "total-".$total_count;
		  $sql="SELECT count(*) as count FROM course_setting where semester_setting_id='$row_1[sid]' and subtype='Theory' and id in(select course_id from examentry where exam='$_POST[exam]')";
		 $row = mysql_fetch_array ( mysql_query($sql));
		 $tsubject=$row['count'];
		 
		 $sql="SELECT count(*) as count,em.student_id  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id in (SELECT id FROM course_setting where semester_setting_id='$row_1[sid]' and subtype='Theory') and em.mark>'50' and ee.exam='$_POST[exam]'   group by em.student_id HAVING count(*)='$tsubject'";
		 //echo $sql;
		 //$row = mysql_fetch_array ( mysql_query($sql)); 
		 $num_rows = mysql_num_rows(mysql_query($sql));
$pass=$num_rows;
//echo "pass-".$pass;
$percent=($pass/$total_count)*100;
		 ?>
         <b>All Pass:</b></td>
         <td colspan="3"><b><?php echo round($percent,2). "% ". "(". $pass . ")"; ?> </b></td>
        </tr>
        <tr>
        <td rowspan="2"><b>Sl.No</b></td>
        <td rowspan="2"><b>Subject code</b></td>
        <td rowspan="2"><b>Subject Name</b></td>
        <td rowspan="2"><b>Faculty Name</b></td>
         <td rowspan="2"><b>No.of Stu Passed</b></td>
        <td colspan="5" align="center"><b>Marks in % & No. of Students</b></td>
        </tr>
        <tr>
       <!-- <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
          <td><b></b></td>-->
        <td><b>0-25%</b></td>
        <td><b>26-49%</b></td>
        <td><b>50 -70%</b></td>
         <td><b>71-100%</b></td>
          <td><b>Pass %</b></td>
        </tr>
        <?php
		$sno=0;
	$result_2 = mysql_query("SELECT * FROM course_setting where semester_setting_id='$row_1[sid]' and subtype='Theory' order by order1   ") or trigger_error(mysql_error()); 
while($row_2 = mysql_fetch_array($result_2)){
	$sno=$sno+1;
	?>
    <tr>
    <td align="center"><?php echo $sno; ?></td>
        <td><?php echo $row_2['sub_code']; ?></td>
        <td><?php echo $row_2['sub_name']; ?></td>
        <td><?php //echo $row_2['staff_name'];
		$result_sub = mysql_query("SELECT s.staff_name as name from staff s inner join course_staffmapping cm on cm.staff_id=s.id where cm.course_id='$row_2[id]'") or trigger_error(mysql_error());
		$name="";
		$cnt=0;
while($row_sub = mysql_fetch_array($result_sub)){
	$cnt=$cnt+1;
	if($cnt==1)
	{
		$name=$row_sub['name'];
	}
	else
	{
	$name=$name .",</br>" . $row_sub['name'];
	}
}
echo $name;
		?></td>
        <td align="center">
        <?php
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>='50' and ee.exam='$_POST[exam]'";
		//echo $sql;
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
echo $row_3['count'];
$total=0;
		?>
        </td>
        <td align="center">
        <?php
		
		/*$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark='' and ee.exam='$_POST[exam]'";
		echo $sql;
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
//echo $row_3['count'];
$total=$total+$row_3['count'];
		
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark<'0' and ee.exam='$_POST[exam]'";
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
//echo $row_3['count'];
$total=$total+$row_3['count'];*/
		
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>=0 and em.mark<=25  and ee.exam='$_POST[exam]'";
		//echo $sql;
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
echo $row_3['count'];
$total=$total+$row_3['count'];
		?>
        </td>
        
        <td align="center">
        <?php
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>='26' and em.mark<='49' and ee.exam='$_POST[exam]'";
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
echo $row_3['count'];
$total=$total+$row_3['count'];
		?>
        </td>
        
        <td align="center">
        <?php
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>='50' and em.mark<='70' and ee.exam='$_POST[exam]'";
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
echo $row_3['count'];
$total=$total+$row_3['count'];
		?>
        </td>
        
        <td align="center">
        <?php
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>='71' and em.mark<='100' and ee.exam='$_POST[exam]'";
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
echo $row_3['count'];
$total=$total+$row_3['count'];
		?>
        </td>
        
        <td align="center"> <?php
		$sql="SELECT count(*) as count  FROM exammark em inner join examentry ee on ee.id=em.examentry_id where ee.course_id='$row_2[id]' and em.mark>='50' and ee.exam='$_POST[exam]'";
		//echo $sql;
 $row_3 = mysql_fetch_array ( mysql_query($sql)); 
 $val=($row_3['count']/$total_count) *100;
echo round($val,2);

//$total=$total+$row_3['count'];
		?></td>
       <!-- <td><?php 
		//echo $total;
		//$total=0;
		?></td>-->
        </tr>
<?php	
}
	?>
   
        </table>
        
<?php
}
?>
</br></br>
<center>
<table>
         <tr>
    <td colspan="5" align="left">
    <b>II/III/ IV Yr Class in charge</b>
    </td>
    <td colspan="5" align="right">
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HOD

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRINCIPAL    
    
    </b>
    </td>
    </tr>
        </table>
        </center>
<?php
}
?>
        </p>
<?php
if (!isset($_POST['submit']))
{
    include('footer.php');
}
?>  