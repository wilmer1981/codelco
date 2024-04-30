<html>
<script language=JavaScript type=text/javascript>
function poptysiteWindow()
{
	
	//poptyWindow = window.open('Inicio_jt.php','poptysite',' fullscreen=yes','toolbar=no','directories=no','location=yes','status=no','menubar=no','scrollbars=no','resizable=no');
	
	poptyWindow = window.open('Inicio_jt_poly.php','poptysite',' fullscreen=yes','toolbar=no','directories=no','location=yes','status=no','menubar=no','scrollbars=no','resizable=no');

	poptyWindow.focus();
}
function sistema()
{
 var f=document.frmPrincipal;
 f.action="../principal/sistemas_usuario.php?CodSistema=10";
 f.submit();

}
</script>
<?php 
	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
if ($opcion=="") 
   { 
		echo '<body bgcolor="#FFFFFF" text="#0000002"  onLoad="poptysiteWindow()">';
   } 
 else { 
 	    
		echo '<body bgcolor="#FFFFFF" text="#000000"  onLoad="sistema()">';
		 
 
 	}?>
<form name="frmPrincipal" method="post" action="">


</form>
</body>
</html>
