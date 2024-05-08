<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Actualizar Funcionarios</title>
<script language="JavaScript">	
<!--
function Enviar()
{
	document.FrmPrincipal.action = "proceso_actualiza_fun.php";
	document.FrmPrincipal.submit();
}
//-->
</script>
</head>

<body>
<font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="2" color="Red">
<? if ($OK == "S")
	{
		echo "Actualizacion Terminada";
	}
?>
</font><br><br>
<form action="" method="post" name="FrmPrincipal" id="FrmPrincipal">
<div align="center">

 <A href="../index.php"> VOLVER MENU </A>

<!--<font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="1" color="Black">
Actualizar Funcionario :</font>
<input type="button" name="BtnActualiza" value="Actualizar" onclick="JavaScript:Enviar();">
</div>  -->
</form>
</body>
</html>
