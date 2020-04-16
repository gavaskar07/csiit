
<?php 
include('config.php');
include('header.php');
?>
<script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
<?php
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
          <li class="breadcrumb-item active">FeedBack Report</li>
        </ol>
        <!-- Page Content -->
        <h1>FeedBack Report</h1>
        <hr>
        <p>
                    <?php
          if(!isset($_POST['submitted']))
          {
          ?>
          <form name="myform" action="cf_feedbackreport.php" method="post">
       <table class="table table-striped table-bordered table-hover">
       <tr>  
  <td align="right"><b>Feedback Name</b></td>
<td><select name="role_id"  id="role_id" class="form-control" >
 <?php
$result = mysql_query("SELECT * FROM cf_fb_setting") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['fname']) . "</option>";  
} 
?>
                              </select></td>
  </tr>
   <tr>  
  <td align="right"><b>Course Name</b></td>
<td><select name="role_id"  id="role_id" class="form-control" >
 <?php
$result = mysql_query("SELECT * FROM cf_fb_entry") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['course_id']) . "</option>";  
} 
?>
                              </select></td>
  </tr>
           <tr>
  <td colspan="8" align="center">
  

  <button type="submit"  class="btn btn-success" name="edit"  >View</button>
  <input type="hidden" value="1" name="submitted"/>
           
  </td>
  </tr>
  </table>
  </form>
<?php
}
else
{
?>
<form name="myform" action="cf_feedbackreport.php" method="post">
        <table class="table table-striped table-bordered table-hover">
         <tr>  
  <td align="right"><b>Feedback Name</b></td>
<td><select name="role_id"  id="role_id" class="form-control" >
 <?php
$result = mysql_query("SELECT * FROM cf_fb_setting") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['fname']) . "</option>";  
} 
?>
                              </select></td>
  </tr>
   <tr>  
  <td align="right"><b>Course Name</b></td>
<td><select name="role_id"  id="role_id" class="form-control" >
 <?php
$result = mysql_query("SELECT * FROM cf_fb_entry") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['course_id']) . "</option>";  
} 
?>
                              </select></td>
  </tr>
            <tr>
  <td colspan="2" align="center">

  <button type="submit"  class="btn btn-success" name="edit"  >View</button>
  <input type="hidden" value="1" name="submitted"/>
            </td>
  </td>
  </tr>
  </table>
  </form>
        <table class="table table-striped table-bordered table-hover">
  <tr>
    <td><b>Sl.No</b></td>
    <td><b>Feedback Question</b></td>
    <td><b>Rating</b></td>

   <?php 
		$query  = "select ce.id,ce.question,d.rating from cf_fb_question ce inner join cf_fb_rating d on d.id=ce.question ";
	$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			$sno=$sno+1;
			?>
			  <tr>
              <td><?php echo $sno; ?></td>
			  <td><?php echo $data["question"]; ?></td>
              <td><?php echo $data['rating']; ?></td>
			<td>
  </tr>
  <?php 
	}
  ?>
</table>
<?php
}
?>

        </p>
<?php
    include('footer.php');
?>  