<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else {
		$Valores = "";
	}
	if(isset($_REQUEST["Existe"])){
		$Existe = $_REQUEST["Existe"];
	}else {
		$Existe = "";
	}

	$EstCod='';
	$TxtDescrip="";
	
	switch ($Proceso)
	{
		case "M":
			$EstCod='readonly';
			$Datos2=explode('~',$Valores);
			$TxtCodigo=$Datos2[0];
			$Consulta="select * from interfaces_codelco.empaque where cod_empaque='$TxtCodigo'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
				$TxtDescrip=$Fila["descripcion"];
		break;
		case "N":
			$Consulta="select ifnull(max(ceiling(cod_empaque))+1,1) as codigo from interfaces_codelco.empaque where cod_empaque<90";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
				$TxtCodigo=$Fila["codigo"];
		break;
	}
	
	
?>
<html>
<head>
<title>Proceso</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			if(f.TxtDescrip.value == '')
			{
				alert("Debe Ingresar Descripcion");
				f.TxtDescrip.focus();
				return;
			}
			f.action='inter_empaques01.php?Proceso=N';
			f.submit();
			break;
		case 'M'://MODIFICAR
			f.action='inter_empaques01.php?Proceso=M&Valores='+f.Valores.value;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
		case 'R'://RECARGA
			f.action='inter_empaques_proceso.php';
			f.submit();
			break;
	}
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

body {
	background-image: url(../principal/imagenes/fondo3.gif);
}

</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valores" value="<?php echo $Valores;?>">
	    <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td width="89" align="right">Codigo: </td>
            <td width="357" align="left"><input name="TxtCodigo" type="text" value="<?php echo $TxtCodigo;?>" size="6" maxlength="2" <?php echo $EstCod;?>></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Descripcion:</td>
            <td align="left"><input name="TxtDescrip" type="text" value="<?php echo $TxtDescrip;?>" size="30" maxlength="50">
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2"><input name="BtnAceptar" type="button" id="BtnAceptar" style="width:70px;" onClick="Procesos('<?php echo $Proceso;?>')" value="Aceptar">
              <input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Procesos('S')"></td>
          </tr>
		 </table>
	    <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Existe==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>	