<!--
INSERT INTO `cf_fb_question`
(
`cf_fb_setting_id`,
`question`)
VALUES
(
<{cf_fb_setting_id: }>,
<{question: }>
);

UPDATE `cf_fb_question`
SET
`cf_fb_setting_id` = {cf_fb_setting_id: },
`question` = {question: }
WHERE `id` = {id: }

DELETE FROM `cf_fb_question`
WHERE `id` = {id: }

SELECT
`cf_fb_question`.`id`,
`cf_fb_question`.`cf_fb_setting_id`,
`cf_fb_question`.`question`
FROM `cf_fb_question`;

-->
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
          <li class="breadcrumb-item active">Feedback Question Setting</li>
        </ol>
        <!-- Page Content -->
        <h1>Feedback Question Setting</h1>
        <hr>
        <p>
        <?php
//for insert opretion
if(isset($_REQUEST['save'])){
	
	$cf_fb_setting_id = $_REQUEST['cf_fb_setting_id'];
	$question = $_REQUEST['question'];
	//insert query  and exicution of query
	$query ="INSERT INTO `cf_fb_question`
(
`cf_fb_setting_id`,
`question`) values('$cf_fb_setting_id','$question')";
	if(mysql_query($query))
	{
		echo "<script>alert('data saved successfully')</script>";
		echo "<script>window.location='cf_feedbackquestion.php'</script>";
	}else{
		echo "failed ".mysql_error();
	}
}


//for Update opretion
if(isset($_REQUEST['edit'])){
	//querystring varible 
	$id   = $_REQUEST['id'];
	//form data
	$cf_fb_setting_id = $_REQUEST['cf_fb_setting_id'];
	$question = $_REQUEST['question'];
	//update query  and execcution of query
	$query = "
UPDATE `cf_fb_question`
SET
cf_fb_setting_id = '$cf_fb_setting_id',
question = '$question' where id='$id'";
	if(mysql_query($query)){
		echo"<script>alert('data successfully Updated ')</script>";
		echo"<script>window.location='cf_feedbackquestion.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}


//for Delete opretion
if($action == 'delete'){
	//querystring varible 
	$id   = $_REQUEST['id'];
	
	//update query  and exicution of query
	$query = "delete from cf_fb_question where id='$id'";  
	if(mysql_query($query)){
		echo"<script>alert('data successfully Deleted ')</script>";
		echo"<script>window.location='cf_feedbackquestion.php'</script>";
	}else{
		echo"failed ".mysql_error();
	}
}

?>

<div class="container">
  
  <?php if($action =='edit' or $action =='add' ){ 
          $id = $_REQUEST['id'];
		  $query ="select * from cf_fb_question where id='$id'";
		  //$query  = "select * from student order by student_id desc";
		  $rs = mysql_query($query) or die("failed ".mysql_error());
		  $data = mysql_fetch_array($rs);
  ?>
  <form method="post" >
  <table class="table table-striped table-bordered table-hover">
  
    <tr>  
  <td align="right"><b>Feedback Name</b></td>
<td><select name="cf_fb_setting_id"  id="cf_fb_setting_id" class="form-control" >
 <?php
$result = mysql_query("SELECT * FROM cf_fb_setting") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
if($row['id']==$data['cf_fb_setting_id'])
{
	echo "<option selected='selected' value='". nl2br( $row['id']) ."'>" . nl2br( $row['fname']) . "</option>";
}
else
{
echo "<option value='". nl2br( $row['id']) ."'>" . nl2br( $row['fname']) . "</option>";
}
} 
?>
                              </select></td>
  </tr>
  <tr>
  <td align="right"><b> Question<b></td>
  <td>
  <textarea name="question" id="question" cols="50" rows="5" class="form-control"   required="required"><?php if($action=="edit"){ echo $data['question'];} else { echo "";} ?></textarea></br>
   </td>
  </tr>
  <tr>
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
  
		
  <?php }else{ ?>
		  <center><a href="cf_feedbackquestion.php?action=add&id=0" class="btn btn-primary">Add feedback question</a></center>
		  <br /> 
		 <div class="table-responsive">
		  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
			  <tr>
			<th>Feedback Name</th>
            <th>Question</th>
            <th>action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select ce.question,d.fname from cf_fb_question ce inner join cf_fb_setting d on d.id=ce.cf_fb_setting_id";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			  <tr>
              <td><?php echo $data["fname"]; ?></td>
              <td><?php echo $data["question"]; ?></td>
			<td>
			<a href="cf_feedbackquestion.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
			<a href="cf_feedbackquestion.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>
           </td>
			  </tr>
			  <?php 	
		}
			

		?>
			</tbody>
		  </table>
  <?php } ?>
  </div>
</div>	
        </p>
<?php
    include('footer.php');
?>  