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
</script>
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
<tr>  
<td>Programs</td>
<td><div class="styled-select">
<select name='program_id' id='program_id' class="form-control input-sh" onchange="showbatch(this.value)">
<option>select</option>
</select>
</div>
</td>
</tr>
<tr>
  <td>Batch</td><td colspan="3" ><div class="styled-select">
<select name='batch_id' id='batch_id' class="form-control input-sh" >
<option>select</option>
</select>
 </div></td>
 </tr>

<!--<input type="hidden" name="dept_id" value="<?php //echo $_POST['batch_id']; ?>"/>
<input type="hidden" name="program_id" value="<?php //echo $_POST['batch_id']; ?>"/>
<input type="hidden" name="batch_id" value="<?php //echo $_POST['batch_id']; ?>"/>-->
<tr><td colspan="2">
 <button type="submit" class="btn btn-success" name="submit" >Submit</button>
<!--<button type="submit" class="btn btn-success" name="view" >Submit</button>-->
</td>
</tr>
</table>
