
<?php 
include('config.php');
include('header.php');
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Batch Setting</li>
        </ol>
        <!-- Page Content -->
        <h5>Batch Setting</h5>
        <hr>

<form name="f1" method="post" action="">
    
<?php

if (!isset($_POST['submit']) and !isset($_POST['submited'])) {
	include('common-batch.php');

}
else if (isset($_POST['submit']))
{
{
?>
	<table class='table table-striped table-bordered'>
<tr>
  <td><b>Department</b></td><td><div class="styled-select">
<?php
$result = mysql_query("SELECT * FROM department where id='$_POST[dept_id]'") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
echo nl2br( $row['dept_name']);  
} 
?>
  </td>
  <td><b>Programs</b></td>
  <td><?php
$result = mysql_query("SELECT * FROM programs where id='$_POST[program_id]'") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
echo nl2br( $row['programname']);  
} 
?></td>
</tr>
</table>
	
<?php
}
?>

<table class='table table-striped table-bordered'>
			<thead>
            	<tr>
            <td colspan="4" align="center">
		<a href="batchsetting1.php?action=add&Program_id=<?php echo $_POST['program_id']; ?>" class="btn btn-success">Add New Batch</a>
</td>
			</tr>
			  <tr>
            <th>Batch</th>
			<th>From Year</th>
			<th>To Year</th>
			<th>Action</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
		$query  = "select * from batch where Program_id='$_POST[program_id]' order by batchname";
		$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			?>
			<tr>
            <td><?php echo $data["batchname"]; ?></td>
			<td><?php echo $data["fromyear"]; ?></td>
			<td><?php echo $data["toyear"]; ?></td>
   			<td><a href="batchsetting1.php?action=edit&id=<?php echo $data["id"]; ?>" class="btn btn-success">Edit</a>
            <a href="batchsetting1.php?action=delete&id=<?php echo $data["id"]; ?>" class="btn btn-danger" onClick="return confirm('are you soure want to delete this')" >Delete</a>

			</td>
			  </tr>
			  <?php 	
		}
		?>
           
			</tbody>
           
		  </table>
<?php
		}
?>

</form>


<?
    include('footer.php');
?>  