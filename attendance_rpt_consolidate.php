<style type="text/css">h6{page-break-before:always}</style>


<?php
//include('config.php');
include('attendance_rpt_dwise_detail.php');
if(isset($_POST['submit']))
{
}
else
{
include('header.php');
?>
<ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Assesment Report Consolidated</li>
        </ol>
       
<?php
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
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <form name="f1" method="post" action="">
<script>
function showsubjects() 
{
 //document.writeln("dsd");
 var dept_id=document.getElementById("dept_id").value;
 var academicyear=document.getElementById("academicyear").value;
 var semester=document.getElementById("semester").value;
 var year=document.getElementById("year").value;
 var str="dept_id="+ dept_id + "&academicyear=" + academicyear + "&semester=" + semester + "&year=" + year;
 //document.writeln(str);
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
 document.getElementById("subject").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","details/get_subject.php?"+str,true);
  xmlhttp.send();
}
function myFunction() {
    window.print();
}
function myword() {
     var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+document.getElementById("source-html").innerHTML+footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'Exam_mark.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
}
</script>
<?php
if (!isset($_POST['submit'])) {

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
<select name='dept_id' id='dept_id' class="form-control input-sh" onchange="showprogram(this.value)">
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
<input type="hidden" name="dept_id" id='dept_id' value="<?php echo $_SESSION['department'];  ?>"/>
<?php
}
?>
</td>
  <td align="right">Academic Year</td>
<td>
<select name="academicyear" id="academicyear" class="form-control input-sh" >
<option>select</option>
<?php echo getacademicyear(); ?>                     
</select>
</td>
</tr>
<tr>
<td align="right">Semester</td>
<td><select name="semester" id="semester" class="form-control" >
                              <option>ODD</option>
                              <option>EVEN</option>
                            </select></td>
                            
<td align="right">Year</td>
<td>
<select name="year" id="year" class="form-control input-sh" onchange="showsubjects()">
<option>select</option>
<?php echo getyear(); ?>                     
</select>
</td>
</tr>
<tr>
<td align="right">
Period:
</td>
<td>
<select name='period' id='period' class="form-control input-sh">
<option>select</option>
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
<td align="right">Format</td>
<td>
<select name="format" class="form-control input-sh" id="format">
                              <option value="1">Web Portal Entry</option>
                              <option value="2">Notice Board Printout</option>
                            </select>
</td>
</tr>

<tr>
<td>Subject to Display</td>
<td>
<select name='subject[]' id='subject' multiple>

</select>
</td>
<td></td>
<td></td>
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
else if(isset($_POST['get_attendance']))
  {?>
<?php  
	  
  }
else
{
	?> 
    <center>
             <button class="btn btn-primary hidden-print" onclick="myFunction()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
             <button class="btn btn-primary hidden-print" onclick="myword()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> To MSWord</button>
	    </center>
    <div class="container" id="box">
	<div class="row well">
    <div class="source-html-outer">
    <div id="source-html">
    
<?php
//$row = mysql_fetch_array ( mysql_query());
$sql="SELECT distinct d.dept_name,ss.id,p.id as pid,b.id as bid,b.batchname,ss.semesterno from course_setting cs inner join semester_setting ss on cs.semester_setting_id=ss.id inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' and ss.year='$_POST[year]'";
$result_get = mysql_query($sql) or trigger_error(mysql_error());

		while($row_get = mysql_fetch_array($result_get)){
$semester_setting_id=stripslashes($row_get['id']);
$dept_name=$row_get['dept_name'];
$batch_id=$row_get['bid'];
$semno=$row_get['semesterno'];
if($_POST['year']=="1")
{
	$bname=$row_get['batchname'];
}
else
{
$bname="";
$pos = strpos($row_get['batchname'], "A");
if ($pos == true)
{
$bname="A";	
}
else
{
	$pos = strpos($row_get['batchname'], "B");
if ($pos == true)
{
	$bname="B";
}
}
}
?>
<input type="hidden" name="dept_id" value="<?php echo $_POST[dept_id];  ?>"/>
<input type="hidden" name="program_id" value="<?php echo stripslashes($row['pid']);  ?>"/>
<input type="hidden" name="batch_id" value="<?php echo stripslashes($row['bid']);  ?>"/>
<input type="hidden" name="academicyear" value="<?php echo $_POST['academicyear'];  ?>"/>
<input type="hidden" name="semester" value="<?php echo $_POST['semester'];  ?>"/>
<input type="hidden" name="semester_setting_id" value="<?php echo $semester_setting_id;  ?>"/>

<table align="center" border="1" id="empTable">
        <tr>
        <td colspan="2" align="center"><h3>CSI Institute of Technology,Thovalai</h3></td>
        </tr>
        <tr>
        <td colspan="2" align="center"><b>Department of <?php 
		$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id=' $_POST[dept_id]'")); 
if($bname=="")
{
echo $dept_name ;	
}
else
{
	echo $dept_name . " - ".$bname;
}
 

?></b></td>
        </tr>
        <tr>
        <td align="left"><b>Academic Year:<?php echo $_POST['academicyear'] ?></b></td>
        <td align="right"><b>Semester:<?php echo numberToRoman($semno); ?></b></td>
        </tr>
    <tr>
    <?php
	$query = mysql_query("SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]' and bid='$batch_id'");
$period_count=mysql_num_rows($query);
	if($period_count>0)
	{
	$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]' and bid='$batch_id'";
	}
	else
	{
		$query="SELECT * FROM report_period where academicyear='$_POST[academicyear]' and semester='$_POST[semester]' and period='$_POST[period]'  and bid IS NULL";
	}
	//echo $query;
	$row = mysql_fetch_array ( mysql_query($query)); 
	$fdate=date('Y-m-d', strtotime($row['fdate']));
			$tdate=date('Y-m-d', strtotime($row['tdate']));
			if($_POST['format']=="1")
{
	?>
        <td colspan="2" align="center"><b>Consolidated Report- <?php 
		echo numberToRoman($_POST['period']) . " ";
		$row = mysql_fetch_array ( mysql_query($query)); 
echo date('d-m-Y', strtotime($row['fdate'])) . " - " . date('d-m-Y', strtotime($row['tdate']));  ?></b></td>
<?php
}
else
{
	?>
<td colspan="2" align="center"><b>Internal Assessment- <?php 
$period=$_POST['period']-1;
		echo numberToRoman($period) . " Consolidated Report ";?>
		</b></td>
<?php
}
?>
        </tr>
        <tr>
        <td colspan="2">
        <table border="1">
       <tr>
       <td><b>Sl.No</b></td>
        <td><b>Reg No</b></td>
         <td><b>NAME OF THE STUDENT</b></td>
        <?php
		$subject= $_POST['subject'];
		$sub;
		$cnt=0;
		while (list ($key, $val1) = each ($subject)) {
			$cnt=$cnt+1;
			if($cnt==1)
			{
			$sub=$val1;	
			}
			else
			{
	$sub=$sub .",".$val1;
			}
	
	}
	//echo "SELECT * FROM course_setting where semester_setting_id='$semester_setting_id' and subtype='Theory' and id in($sub) order by order1";
$result = mysql_query("SELECT * FROM course_setting where semester_setting_id='$semester_setting_id' and subtype='Theory' and id in($sub) order by order1") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
if($_POST['format']=="1")
{ 
if($_POST['period']==1)
{
	?>
    <td colspan="2"><?php echo   $row['sub_code'];?> </td>

<?php
}
else
{
?>
<td colspan="3"><?php echo   $row['sub_code'];?> </td>
<?php
}
}
else
{
?>
<td colspan="2"><?php echo   $row['sub_code'];?> </td>
<?php
}
} 
?>
        </tr>
        <tr>
        <td colspan="3"></td>
          <?php
$result = mysql_query("SELECT * FROM course_setting where semester_setting_id='$semester_setting_id' and subtype='Theory' and id in($sub) order by order1") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
if($_POST['format']=="1")
{
?>
<td>Total Hours</td>
<td>Total Hours Present</td>
<?php
}
else
{
	?>
 <td>Attendance %</td> 
    <?php
}
?>
<?php
if($_POST['period']>=2)
{
	
?>
<td>Mark</td>
<?php
}
} 
?>
        
        </tr>
        <?php
		$result_1 = mysql_query("select * from student where  (status IS NULL or status<>'In active') and batch_id='$batch_id' ORDER BY CAST(univ_regno as unsigned) asc") or trigger_error(mysql_error()); 
$sno=0;
while($row_1 = mysql_fetch_array($result_1))
{ 
$sno=$sno+1;
?>
<tr>
<td><?php echo $sno; ?></td>
<td><?php echo $row_1['univ_regno']  ?></td>
<td><?php echo $row_1['name']  ?></td>


<?php  
$result = mysql_query("SELECT * FROM course_setting where semester_setting_id='$semester_setting_id' and subtype='Theory' and id in($sub) order by order1") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
$attper=attendance($row_1['id'],$row['id'],$fdate,$tdate,$semester_setting_id,$_POST['format']);
if($_POST['period']>=2)
{
	//echo "<td>".$attper. "</td>";
	echo period2($row_1['id'], $row['id'],$attper,$_POST['period'],'c');
}
			?>
          
            <?php
		}
		 ?>


<?php
//} 
?>

</tr>
<?php
}
?>
<tr>
<td colspan="3" align="center"><b>Signature of the Staff</b></td>
<?php
$result = mysql_query("SELECT * FROM course_setting where semester_setting_id='$semester_setting_id' and subtype='Theory' and id in($sub) order by order1") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
  
?>
<td colspan="3"></br></br></td>

<?php
} 
?>
</tr>
</table>
        
        </td>       
        </tr>
        
        <tr>
        <td colspan="2"></br></br></br></td>
        </tr>
        <tr>
        <td><b>Signature of HOD</b></td>
        <td align="right"><b>Signature of Principal</b></td>
        </tr>
        </table>
       <h6></h6>
    <?php
}
}
?>
</form>
</div>
</div>
<?php
if(isset($_POST['submit']))
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
