<?php 
include('config.php');
include('header.php');
// action varible for using insert update and delete opretion which retrive from query string
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
          <li class="breadcrumb-item active">Class Advisor Report</li>
        </ol>
      <script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>  
          <?php
//for insert opretion
//session_start();
if(isset($_REQUEST['save'])){
	$ftest = $_POST['ftest'];
	$t_schedule  = $_POST['t_schedule'];
	$no_s_late  = $_POST['no_s_late'];
	$no_s_absent = $_POST['no_s_absent'];
	$sms_sent  = $_POST['sms_sent'];
	$pcommunication  = $_POST['pcommunication'];
	$aclass  = $_POST['aclass'];
	$preport = $_POST['preport'];
	$scomment  = $_POST['scomment'];
	$oinfirmation  = $_POST['oinformation'];
	$staff_id  = $_POST['staff_id'];
	$semester_setting_id  = $_POST['semester_setting_id'];
	$preason=$_POST['preason'];
	//$hours   = $_REQUEST['hours'];
	//insert query  and exicution of query
	$rdate=date('Y-m-d', strtotime($_POST['rdate']));
	$row1 = mysql_fetch_array ( mysql_query("select * from current_ayear")); 
//$semester_setting_id=stripslashes($row['id']);
	$sql="SELECT s.id FROM  semester_setting s  inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id where s.academicyear='$row1[ayear]' and s.semester= '$row1[semester]' and d.id='$_POST[dept_id]' and s.year='$_POST[year]'";
	echo $sql;
	$row = mysql_fetch_array ( mysql_query($sql)); 
$semester_setting_id=stripslashes($row['id']);

	$query ="INSERT INTO `class_advisor_rpt` (`ftest`, `t_schedule`, `no_s_late`, `no_s_absent`, `sms_sent`, `pcommunication`, `aclass`, `preport`, `scomment`, `oinfirmation`, `staff_id`, `semester_setting_id`,rdate,preason) VALUES ('$ftest', '$t_schedule', '$no_s_late', '$no_s_absent', '$sms_sent', '$pcommunication', '$aclass', '$preport', '$scomment', '$oinfirmation', '$staff_id', '$semester_setting_id','$rdate','$preason');";
	echo $query;
if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='class_advisor_rpt.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$ftest = $_POST['ftest'];
	$t_schedule  = $_POST['t_schedule'];
	$no_s_late  = $_POST['no_s_late '];
	$no_s_absent = $_POST['no_s_absent'];
	$sms_sent  = $_POST['sms_sent'];
	$pcommunication  = $_POST['pcommunication'];
	$aclass  = $_POST['aclass'];
	$preport = $_POST['preport'];
	$scomment  = $_POST['scomment'];
	$oinfirmation  = $_POST['oinformation'];
	$staff_id  = $_POST['staff_id'];
	$semester_setting_id  = $_POST['semester_setting_id'];
	$rdate=date('Y-m-d', strtotime($_POST['rdate']));
	//update query  and execcution of query
	$query = "UPDATE `class_advisor_rpt` SET `ftest`='$ftest', `t_schedule`='$t_schedule', `no_s_late`='$no_s_late', `no_s_absent`='$no_s_absent', `sms_sent`='$sms_sent', `pcommunication`='$pcommunication', `aclass`='$aclass ', `preport`='$preport', `scomment`='$scomment', `oinfirmation`='$oinfirmation', `staff_id`='$staff_id', `semester_setting_id`='$semester_setting_id',`rdate`='$rdate' where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='class_advisor_rpt.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from class_advisor_rpt where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='class_advisor_rpt.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action == 'edit' or $action == 'add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from class_advisor_rpt where id='$id'";
		  $query="select c.rdate,
    c.`ftest`,
    c.`t_schedule`,
    c.`no_s_late`,
    c.`no_s_absent`,
    c.`sms_sent`,
    c.`pcommunication`,
    c.`aclass`,
    c.`preport`,
    c.`scomment`,
    c.`oinfirmation`,
    c.`staff_id`,
    c.`semester_setting_id`,d.id as did,s.year from class_advisor_rpt c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id where c.id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
 
  <table class="table table-bordered table-hover">
 
   <input type="hidden" name="staff_id" value="<?php if($action=="edit"){ echo $data['staff_id'];}else {echo $_SESSION['userid'];} ?>" >
 
  <?php
 // $row1 = mysql_fetch_array ( mysql_query("SELECT * FROM current_ayear")); 
//echo $row1['ayear'];
  ?>
   <input type="hidden" name="semester_setting_id"  value="<?php if($action=="edit"){ echo $data['semester_setting_id'];}else {echo "";} ?>" />

<tr>
<td align="right" ><b>Department</b></td>
<td>
<?php
  if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" )
  {

  ?>
<select name='dept_id' input-sh" onchange="showprogram(this.value)">
<option>Select</option>
<?php
$result = mysql_query("SELECT * FROM department") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }
if($ $row['id']==$data['did'])
{
echo "<option selected value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";
}
else
{
	echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['dept_name']) . "</option>";
}
} ?>
</select>
<?php
}
else
{
	//echo $_SESSION['department'];
$row = mysql_fetch_array ( mysql_query("SELECT * FROM department where id='$_SESSION[department]'")); 
$dname=stripslashes($row['dept_name']);
echo $dname;
?>
<input type="hidden" name="dept_id"  value="<?php if($action=="edit"){ echo $data['did'];}else {echo $_SESSION['department'];} ?>" />
<?php
}
?>

</td>
</tr>
<tr>
<td align="right"><b>Year</b></td>
<td>
<select name="year">
<?php 
if($action=="edit")
{
	getyear_sel($data['year']);
}
else
{
getyear();
}
?>
</select>
</td>
</tr>
<tr>
<td align="right"><b>Date</b></td>
<td>
<input type='text' name='rdate' id='rdate' value="<?php if($action=="edit"){ echo date('d-m-Y', strtotime($data['rdate']));}else {echo "";} ?>" /> <a href="javascript:NewCssCal('rdate','ddmmyyyy')"><img
                src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
</td>
</tr>
  <tr>
  <td align="right"><b>First hour Class Test Status</b></td>
  <td> <select name="ftest"   value="<?php if($action=="edit"){ echo $data['ftest'];}else {echo "";} ?>"  required="required" autofocus="autofocus">
                          <?php
                              $val= $row['ftest'];
                              if($val=="conducted")
                              {
                            ?>
                                 <option value="conducted" selected="true">Conducted</option>
                                 <option value="notconducted" >Not Conducted</option>

                                <?php
                              }
                              else
                              {
                                ?> 
                                <option value="conducted" selected="true">Conducted</option>
                                 <option value="notconducted" >Not Conducted</option>
                                  

                                <?php
                              }
                          ?>
                       
                    </select>
                    </td>
  </tr>
   <tr>
  <td align="right"><b>Time table followed as per schedule</b></td>
  <td> <select name="t_schedule"   value="<?php if($action=="edit"){ echo $data['t_schedule'];}else {echo "";} ?>"  required="required" autofocus="autofocus">
                          <?php
                              $val= $row['t_schedule'];
                              if($val=="Yes")
                              {
                            ?>
                                 <option value="yes" selected="true">Yes</option>
                                 <option value="no" >No</option>

                                <?php
                              }
                              else
                              {
                                ?> 
                                <option value="no" selected="true">No</option>
                                 <option value="yes" >Yes</option>
                                  

                                <?php
                              }
                          ?>
                       
                    </select>
                    </td>
  </tr>
   <tr>
  <td align="right"><b>No of students Late</b></td>
  <td>
   <input type="text" name="no_s_late"  value="<?php if($action=="edit"){ echo $data['no_s_late'];}else {echo "";} ?>"  required="required" autofocus="autofocus">
  </td>
  </tr>
   <tr>
  <td align="right"><b>No of students Absent</b></td>
  <td>
   <input type="text" name="no_s_absent" value="<?php if($action=="edit"){ echo $data['no_s_absent'];}else {echo "";} ?>"  required="required" autofocus="autofocus">
  </td>
  </tr>
  <tr>
  <td align="right"><b>SMS Send</b></td>
  <td> <select name="sms_sent"   value="<?php if($action=="edit"){ echo $data['sms_sent'];}else {echo "";} ?>" placeholder="SMS Send"  autofocus="autofocus">
                          <?php
                              $val= $row['sms_sent'];
                              if($val=="Yes")
                              {
                            ?>
                                 <option value="Yes" selected="true">Yes</option>
                                 <option value="No" >No</option>

                                <?php
                              }
                              else
                              {
                                ?> 
                                <option value="No" selected="true">No</option>
                                 <option value="Yes" >Yes</option>
                                  

                                <?php
                              }
                          ?>
                       
                    </select>
                    </td>
  </tr>
   <tr>
  <td align="right"><b>Parent communication over phone:No of calls made</b></td>
  <td>
   <input type="text" name="pcommunication"  value="<?php if($action=="edit"){ echo $data['pcommunication'];}else {echo "";} ?>" 7
    required="required" autofocus="autofocus">
  </td>
  </tr>
   <tr>
  <td align="right"><b>Alternative Classes</b></td>
  <td>
   <input type="text" name="aclass"  value="<?php if($action=="edit"){ echo $data['aclass'];}else {echo "";} ?>" 7
    required="required" autofocus="autofocus">
  </td>
  </tr>
   <tr>
  <td align="right"><b>Priviouse Report Pending</b></td>
  <td> <select name="preport"  value="<?php if($action=="edit"){ echo $data['preport'];}else {echo "";} ?>"  autofocus="autofocus">
                          <?php
                              $val= $row['preport'];
                              if($val=="Yes")
                              {
                            ?>
                                 <option value="Yes" selected="true">Yes</option>
                                 <option value="No" >No</option>

                                <?php
                              }
                              else
                              {
                                ?> 
                                <option value="No" selected="true">No</option>
                                 <option value="Yes" >Yes</option>
                                  

                                <?php
                              }
                          ?>
                       
                    </select>
                    </td>
  </tr>
  <tr>
   <td align="right"><b> If Yes,Give Reason<b></td>
  <td>
  <textarea name="preason" cols="50" rows="5"    required="required"><?php if($action=="edit"){ echo $data['preason'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
  <tr>
   <td align="right"><b> Student Comment/Feedback<b></td>
  <td>
  <textarea name="scomment" cols="50" rows="5"    required="required"><?php if($action=="edit"){ echo $data['scomment'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
   <tr>
   <td align="right"><b>Other Information/suggestion<b></td>
  <td>
  <textarea name="oinformation" cols="50" rows="5"    required="required"><?php if($action=="edit"){ echo $data['oinfirmation'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
 
  <td colspan="2" align="center">
  <?php
  if($action=="edit")
  {
  ?>
  <button type="submit" class="btn btn-success" name="edit" >Save</button>
  <?php
  }
  else
  {
	?>
    <button type="submit" class="btn btn-success" name="save" >Save</button>
    <?php  
  }
  ?>
  </td>
  </tr>
  </table>
  </form>
  
		
  <?php }else{
	  if($_SESSION['user_type']<>"Principal")
  {
	  ?>
		  <center><a href="class_advisor_rpt.php?action=add&id=0" class="btn btn-primary">Add class advisor Report</a></center>
		  <br /> 
          <?php
  }
		  ?>
		 <div class="table-responsive">
		  <table  id="example1" class="table table-bordered table-hover">
			<thead>
			  <tr>
              <th>Date</th>
			<th>Department</th>
			<th>Year</th>
            <th>Staff Name</th>
            <th>First hour class Test Status</th>
            <th>Time table followed as per shedule</th>
            <th>No of students late</th>
            <th>No of students Absent</th>
            <th>SMS send</th>
            <th>Parent communication:no of calls made</th>
            <th>Alternative classes</th>
            <th>Previous Report Pending</th>
            <th>If yes Give Reason</th>
            <th>Student comment/feedback</th>
            <th>Other Information/suggestion</th>
            <?php
if($_SESSION['user_type']<>"Principal")
{
		?>
			<th>action</th>
            <?php
}
		?>
			  </tr>
			</thead>
			<tbody>
			<?php 
			if($_SESSION['user_type']=="Principal" or $_SESSION['user_type']=="Administrator" )
  {
		//$query  = "select * from class_advisor_rpt where id='$id'";
		  $query="select c.rdate,c.id,
    c.`ftest`,
    c.`t_schedule`,
    c.`no_s_late`,
    c.`no_s_absent`,
    c.`sms_sent`,
    c.`pcommunication`,
    c.`aclass`,
    c.`preport`,
	c.`preason`,
    c.`scomment`,
    c.`oinfirmation`,
    f.`staff_name`,
    c.`semester_setting_id`,d.id as did,s.year,d.dept_name from class_advisor_rpt c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join staff f on c.staff_id=f.id";
  }
  else if($_SESSION['user_type']=="HOD")
  {
	   $query="select c.rdate,c.id,
    c.`ftest`,
    c.`t_schedule`,
    c.`no_s_late`,
    c.`no_s_absent`,
    c.`sms_sent`,
    c.`pcommunication`,
    c.`aclass`,
    c.`preport`,
	c.`preason`,
    c.`scomment`,
    c.`oinfirmation`,
    f.`staff_name`,
    c.`semester_setting_id`,d.dept_name,s.year from class_advisor_rpt c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join staff f on c.staff_id=f.id where d.id='$_SESSION[department]'";
  }
  else if($_SESSION['user_type']=="Faculty")
  {
	$query="select c.rdate,c.id,
    c.`ftest`,
    c.`t_schedule`,
    c.`no_s_late`,
    c.`no_s_absent`,
    c.`sms_sent`,
    c.`pcommunication`,
    c.`aclass`,
    c.`preport`,
	c.`preason`,
    c.`scomment`,
    c.`oinfirmation`,
    f.`staff_name`,
    c.`semester_setting_id`,d.dept_name,s.year from class_advisor_rpt c inner join semester_setting s on s.id=c.semester_setting_id inner join batch b on b.id=s.batch_id inner join programs p on p.id=b.program_id inner join department d on d.id=p.dept_id inner join staff f on c.staff_id=f.id where f.id='$_SESSION[userid]'";  
  }
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
               <td><?php echo date('d-m-Y', strtotime($data["rdate"])); ?></td>
                <td><?php echo $data['dept_name']; ?></td>
              <td><?php echo $data['year']; ?></td>
              <td><?php echo $data["staff_name"]; ?></td>
			<td><?php echo $data['ftest']; ?></td>
            <td><?php echo $data['t_schedule']; ?></td>
            <td><?php echo $data['no_s_late']; ?></td>
            <td><?php echo $data['no_s_absent']; ?></td>
            <td><?php echo $data['sms_sent']; ?></td>
            <td><?php echo $data['pcommunication']; ?></td>
            <td><?php echo $data['aclass']; ?></td>
            <td><?php echo $data['preport']; ?></td>
            <td><?php echo $data['preason']; ?></td>
            <td><?php echo $data['scomment']; ?></td>
            <td><?php echo $data['oinfirmation']; ?></td>
            <?php
if($_SESSION['user_type']<>"Principal")
{
		?>
			<td>

			<a href="class_advisor_rpt.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="class_advisor_rpt.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           
			
			
			</td>
            <?php
}
			?>
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
         
  <?php } ?>
  </div>
</div>
</div>	
      
<?php
    include('footer.php');
?>  