<?php
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";	
?>
<div class="exampleContent" style="height:230px;width:650px;">
	<?php echo $koolajax->Render();?>
	<link rel="stylesheet" href="example.css" />	
	<table ><tr><td width="50%">
						
		<input type="button" id="btnOrder" class="btn" name="btnOrder" value="Submit Order" onclick="Order()" />
		<br/> <br/>
		<div id="result" class="result" ></div>
		<input type="hidden" name="Posted" value="" />					
				
	</td><td>
	<div class="blog" >
		<b>Client-side events:  </b>
		<hr />
		<div id="eventClient" />
	</div>
	</td></tr></table>
	<br style="clear:both">
	<script language="javascript">		
		var startTime ;		
		function Order()
		{
			var request = new Request({
			method:"post",		
			url:"Process.php",
			onOpen:function()
				{
					var currentTime = new Date();	
					startTime = currentTime.getTime() ;
					document.getElementById( "eventClient" ).innerHTML += "onOpen event : Start UPDATE Order... " + "<br/>";
					document.getElementById( "eventClient" ).scrollTop = 9999;
					document.getElementById('btnOrder').disabled=true;	
				},	
			onSent:function()
				{
					var currentTime = new Date();	
					var sentTime = currentTime.getTime() - startTime;
					document.getElementById( "eventClient" ).innerHTML += "onSent event : Sent order to server after " + sentTime + " ms<br/>";
					document.getElementById( "eventClient" ).scrollTop = 9999;
				},
			onDone:function(result){
					//Show order was processed
					document.getElementById('result').innerHTML =  result  ;	
					var currentTime = new Date();
					var afterTime = currentTime.getTime() - startTime;
					document.getElementById( "eventClient" ).innerHTML += "onDone event : Finish UPDATE Order after " + afterTime + " ms<br/>";
					document.getElementById( "eventClient" ).scrollTop = 9999;	
					document.getElementById('btnOrder').disabled=false;					
				}			
			});			
			//Send value to request, add value 'start order' to 'Posted'
			request.addArg("Posted",'start order');
			koolajax.sendRequest(request);					
		}		
	</script>
</div>
