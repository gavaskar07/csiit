
<?php 
include('config.php');
include('header.php');
?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Bulk User Settinf</li>
        </ol>
        <!-- Page Content -->
        <h1>Bulk User Setting</h1>
        <hr>
        <p>
         <div class="form-group">
                  
                    <div class="col-sm-12">
                      <?php 
$result = mysql_query("select * from staff where id not in(select userid from  login)") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result))
{ 
$row_1 = mysql_fetch_array ( mysql_query("SELECT * FROM login where uname='". $row['email'] . "'")); 
$id=stripslashes($row_1['id']);
if($id=="")
{
$sql = "INSERT INTO `login` ( `userid`,`uname` ,`password` ,`rolesetting_id` ,`status`) VALUES( '$row[id]', '$row[email]' , 'csi@123' , '6' , 'Faculty'  ) "; 
//echo $sql . "</br>";
mysql_query($sql) or die(mysql_error()); 
}
}
$result = mysql_query("SELECT l.uname,l.password,l.status,d.dept_name,s.staff_name FROM login l inner join staff s on s.id=l.userid inner join department d on d.id=s.department_id where s.id<>'1' order by d.id ") or trigger_error(mysql_error()); 
echo "<table class='table table-striped table-bordered table-hover'>
"; 
echo "<tr>"; 
echo "<td><b>Name</b></td>";
echo "<td><b>Department</b></td>";
echo "<td><b>User Name</b></td>";
echo "<td><b>Password</b></td>"; 
echo "</tr>"; 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['staff_name']) . "</td>";
echo "<td valign='top'>" . nl2br( $row['dept_name']) . "</td>";
echo "<td valign='top'>" . nl2br( $row['uname']) . "</td>";
echo "<td valign='top'>" . nl2br( $row['password']) . "</td>";   
echo "</tr>"; 
} 
echo "</table>";
					  ?>
                    </div>
                  </div>
        </p>
<?php
    include('footer.php');
?>  