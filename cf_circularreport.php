
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
	<script language="javascript" type="text/javascript" src="js/datetimepicker_css.js"></script>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Circular Report</li>
        </ol>
        <!-- Page Content -->
        <h1>Circular Report</h1>
        <hr>
        <p>
            <?php
          if(!isset($_POST['submitted']))
          {
          ?>
          <form name="myform" action="cf_circularreport.php" method="post">
       <table class="table table-striped table-bordered table-hover">
        <tr>
          <td align="right"><label>From Date</td>
        <td colspan="2"><input type='text' id='fdate' name='fdate' /> <a href="javascript:NewCssCal('fdate','ddmmyyyy')"><img src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>

          <td  align="right"><label>To Date</label></td>
          <td colspan="2"><input type='text' name='tdate' id='tdate'  /> <a href="javascript:NewCssCal('tdate','ddmmyyyy')"><img src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>

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
<form name="myform" action="cf_circular.php" method="post">
        <table class="table table-striped table-bordered table-hover">
        <tr>
          <td align="right"><label>From Date</td>
        <td colspan="2"><input type='text' id='fdate' name='fdate' /> <a href="javascript:NewCssCal('fdate','ddmmyyyy')"><img src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>

          <td  align="right"><label>To Date</label></td>
          <td colspan="2"><input type='text' name='tdate' id='tdate'  /> <a href="javascript:NewCssCal('tdate','ddmmyyyy')"><img src="images/cal.gif"
                height="16"
                border="0"
                width="16"></a>
  </td>
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
    <td><b>Circular Date</b></td>
    <td><b>Circular subject</b></td>
    <td><b>Circular Discription</b></td>
    <td><b>TO department</b></td>

   <?php 
		$query  = "select ce.id,ce.cdate,ce.csubject,ce.cdesc,d.dept_name,r.rolename,s.staff_name as tstaff,st.staff_name as fstaff from cf_circular ce inner join department d on d.id=ce.t_dept inner join rolesetting r on r.id=ce.role_id inner join staff s on s.id=ce.to_staffid inner join staff st on st.id=ce.f_staff_id";
	$rs = mysql_query($query) or die("failed ".mysql_error());
		while($data = mysql_fetch_array($rs))
		{
			$sno=$sno+1;
			?>
			  <tr>
              <td><?php echo $sno; ?></td>
              <td><?php echo date('d-m-Y', strtotime($data["cdate"])); ?></td>
			  <td><?php echo $data["csubject"]; ?></td>
              <td><?php echo $data['cdesc']; ?></td>
			<td><?php echo $data['dept_name']; ?></td>
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