<?php
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
	echo $koolajax->Render();
?>
<form is="form1" method="post">
	Select customer to view order details:
	<select id="cbbCustomer" onchange="select_customer()">
		<option value="">--</option>
		<?php
			$result = mysql_query("select customerNumber,customerName from customers limit 0,10");
			while($row= mysql_fetch_assoc($result))
			{
				echo "<option value='".$row["customerNumber"]."'>".$row["customerName"]."</option>";
			}	
		?>
	</select>
	<div id="orderSummary" style="padding-top:10px;width:300px;"></div>
	<script type="text/javascript">
		function select_customer()
		{
			var request = new Request({
				method:"post",		
				url:"Process.php",				
				onDone:function(result){
					//Show orders of customers
					document.getElementById("orderSummary").innerHTML = result;
				}			
			});
			var _customerNumner = document.getElementById("cbbCustomer").value;
			if(_customerNumner!="")
			{
				request.addArg("customerNumber",_customerNumner);
				koolajax.sendRequest(request);				
			}
		}
	</script>	
</form>	