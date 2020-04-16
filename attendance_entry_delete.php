<?php 
include('config.php');
include('header.php');
$action = "";
if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
}
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Day wise Attendance Report
          <?php
		  if(isset($_POST['submit']))
{
	echo "on " . $_POST['adate'];
}
		  ?>
          </li>
        </ol>
     
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
if (!isset($_POST['submit']) and !isset($_POST['submited']) ) {
	//include('common.php');
	
	if($action == 'delete'){
	//querystring varible 
	
	$id   = $_REQUEST['id'];
	$id=encryptor("decrypt",$id);
	$sql = "delete from  attendance_entry_detail where attendance_entry_id='$id' "; 
              mysql_query($sql) or die(mysql_error());
			  $sql = "delete from  attendance_entry where id='$id' "; 
               mysql_query($sql) or die(mysql_error());  
		      echo"<script>alert('data successfully Deleted ')</script>";
		     // echo"<script>window.location='attendance_entry_delete.php'</script>";
	
}
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


<?php	
//echo "sumbit";
$adate= date('Y-m-d', strtotime($_POST['adate']));
$sql = "SELECT ss.id,ss.batch_id,ss.year,ss.noofhours,d.dept_name from semester_setting ss inner join batch b on b.id=ss.batch_id inner join programs p on p.id=b.program_id inner join department d on p.dept_id=d.id where ss.academicyear='$_POST[academicyear]' and ss.semester='$_POST[semester]' and d.id='$_POST[dept_id]' order by ss.year";
//echo $sql;
$result = mysql_query($sql) or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){
	echo "<table class='table table-striped table-bordered'>";
  echo "<tr>";
  echo "<td>Department</td>";
  echo "<td>" . $row['dept_name'] . "</td>";
  echo "<td align='right'>Year</td>";
  echo "<td>" . $row['year'] . "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td>Hour</td>";
echo "<td>Subject Name</td>";
echo "<td>Entered By</td>";
echo "<td>Action</td>";
  echo "</tr>";
for($i=1;$i<=$row['noofhours'];$i++)
{
echo "<tr>";
echo "<td>". $i . "</td>";
//$sql="select s.name,s.univ_regno from attendance_entry ae left join attendance_entry_detail aed on aed.attendance_entry_id=ae.id inner join student s on s.id=aed.student_id where ae.course_setting_id='". $course_id ."' and ae.adate='$data[adate]' and ae.hour='$data[hour]' and staff_id='$_SESSION[userid]'";
			  //echo $sql;
			//  $result = mysql_query($sql) or trigger_error(mysql_error());
			 // $val="";
			//  $sno=0;
		//while($row = mysql_fetch_array($result)){
			$val="";
$sql1="select ae.id, ae.hour,cs.sub_code,cs.sub_name,st.staff_name from attendance_entry ae inner join course_setting cs on cs.id=ae.course_setting_id inner join course_staffmapping csm on csm.course_id=cs.id inner join staff st on csm.staff_id=st.id where cs.semester_setting_id='".$row['id']."' and ae.adate='$adate' and ae.hour=$i";
 $result1 = mysql_query($sql1) or trigger_error(mysql_error());
			  $val="";
			  $sno=0;
			  $id="";
		while($row1 = mysql_fetch_array($result1)){
			
			//$val=$row['hour'];
			$val= "<td>". $row1['sub_name'] .   "</td>" . "<td>". $row1['staff_name']  ."</td>" . "<td>" ;
			//"<button type='submit' class='btn btn-success' name='d_". $row1['id'] . ">Delete</button>".
			$id=$row1['id'];
			
		}
		if($val=="")
		{
			echo "<td>". "-" .   "</td>" . "<td>". "-"  ."</td>". "<td>". "Not Entered"  ."</td>";
		}
		else
		{
			echo $val;
			$id=encryptor("encrypt", $id);
			?>
            <a href="attendance_entry_delete.php?action=delete&id=<?php echo $id; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>

            <?php
			echo "</td>";
		}
		
		echo "</tr>";
} 

	?>
	</table>
<?php
//}
}
}
    include('footer.php');
?>  