<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");
	$EstCod='';


	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["TxtPatente"])){
		$TxtPatente = $_REQUEST["TxtPatente"];
	}else{
		$TxtPatente = "";
	}
	if(isset($_REQUEST["TxtTarjeta"])){
		$TxtTarjeta = $_REQUEST["TxtTarjeta"];
	}else{
		$TxtTarjeta = "";
	}
	if(isset($_REQUEST["CmbCodMop"])){
		$CmbCodMop = $_REQUEST["CmbCodMop"];
	}else{
		$CmbCodMop = "";
	}
	

	if(isset($_REQUEST["Existe"])){
		$Existe = $_REQUEST["Existe"];
	}else{
		$Existe = "";
	}
	
	/************************************************* */

	switch ($Proceso)
	{
		case "M":
			$EstCod='readonly';
			$Datos2=explode('~',$Valores);
			$TxtPatente=$Datos2[0];
			$Consulta="SELECT * from sipa_web.tarjetas_permanentes where patente='$TxtPatente'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$TxtTarjeta=$Fila["tarjeta"];
				$CmbCodMop=$Fila["cod_mop"];
			}	
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
			if(f.TxtTarjeta.value == '')
			{
				alert("Debe Ingresar Numero de Tarjeta");
				f.TxtTarjeta.focus();
				return;
			}
			f.action='rec_tarjetas_permanentes01.php?Proceso=N';
			f.submit();
			break;
		case 'M'://MODIFICAR
			f.action='rec_tarjetas_permanentes01.php?Proceso=M&Valores='+f.Valores.value;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
		case 'R'://RECARGA
			f.action='rec_tarjetas_permanentes_proceso.php';
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
            <td align="right">Patente:</td>
            <td width="357" align="left"><input name="TxtPatente" type="text" value="<?php echo $TxtPatente;?>" size="10" maxlength="10" <?php echo $EstCod;?>></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Tarjeta:</td>
            <td align="left"><input name="TxtTarjeta" type="text" value="<?php echo $TxtTarjeta;?>" size="5" maxlength="5">
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Cod.Mop:</td>
            <td align="left"><span class="ColorTabla02">
              <SELECT name="CmbCodMop" style="width:85" onkeypress=buscar_op(this,BtnGrabar,0) >
                <option value='S' SELECTed>Seleccionar</option>
                <?php
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='8004' order by nombre_subclase";
			$RespMOP=mysqli_query($link, $Consulta);
			while($FilaMop=mysqli_fetch_array($RespMOP))
			{
				if(intval($FilaMop["valor_subclase1"])==intval($CmbCodMop))
					echo "<option value='".$FilaMop["valor_subclase1"]."' SELECTed>".$FilaMop["nombre_subclase"]."</option>";
				else
					echo "<option value='".$FilaMop["valor_subclase1"]."'>".$FilaMop["nombre_subclase"]."</option>";
			}
		?>
              </SELECT>
            </span></td>
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