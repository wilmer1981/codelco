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

	$EstAsig='';
	$TxtAsig="";
	$CmbRutPrv="";
	$TxtEntrada="";
	$TxtSalida="";
	$EstOptSi="";
	$EstOptNo="";

	if($Proceso=='M')
	{
		$EstAsig='readonly';
		$Datos2=explode('~',$Valores);
		$CmbRutPrv=$Datos2[0];
		$TxtAsig=$Datos2[1];
		
		$Consulta="SELECT * from interfaces_codelco.asignaciones where rut_proveedor='".$CmbRutPrv."'";
		$Consulta.=" and asignacion ='".$TxtAsig."' ";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta;
		if($Fila=mysqli_fetch_array($Resp))
		{
			$TxtEntrada=$Fila["entrada"];
			$TxtSalida=$Fila["salida"];
			$Agrup=$Fila["agrupados"];
			if($Agrup=='S')
			{
				$EstOptSi="checked";
				$EstOptNo="";
			}
			else
			{
				$EstOptSi="";
				$EstOptNo="checked";
			}
		}
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
			if(f.CmbRutPrv.value == 'S')
			{
				alert("Debe Seleccionar Proveedor");
				f.CmbRutPrv.focus();
				return;
			}
			if(f.TxtAsig.value == '')
			{
				alert("Debe Ingresar Codigo Asignacion");
				f.TxtAsig.focus();
				return;
			}
			if(f.radiobutton[0].checked)
				Agrupados='S';
			f.action='inter_asignaciones01.php?Proceso=N&Agrupados='+Agrupados;
			f.submit();
			break;
		case 'M'://MODIFICAR
			if(f.radiobutton[0].checked)
				Agrupados='S';
			f.action='inter_asignaciones01.php?Proceso=M&Valores='+f.Valores.value+'&Agrupados='+Agrupados;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
		case 'R'://RECARGA
			f.action='inter_asignaciones_proceso.php';
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
            <td width="89" align="right">Rut Proveedor:</td>
			<td width="357"><div align="left">
			<?php
			if($Proceso=='N')
			{
			?>
			  <select name="CmbRutPrv" style="width:300">
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "select * from sipa_web.proveedores  ";
				$Consulta.= " order by nombre_prv ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRutPrv == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".$Fila["nombre_prv"]."</option>\n";
				}
			?>
              </select>
			  <?php
			  }
			  else
			  {
			  ?>
			  <input name="CmbRutPrv" type="text" value="<?php echo $CmbRutPrv;?>" size="15" readonly="true">
			  <?php
			  }
			  ?>
			</div></td> 
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Asignacion: </td>
            <td align="left"><input name="TxtAsig" type="text" value="<?php echo $TxtAsig;?>" size="15" maxlength="10" <?php echo $EstAsig;?> ></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Entrada :</td>
            <td align="left"><input name="TxtEntrada" type="text" value="<?php echo $TxtEntrada;?>" size="10" maxlength="10">
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td><div align="right">Salida:</div></td>
            <td><div align="left">
              <input name="TxtSalida" type="text" value="<?php echo $TxtSalida;?>" size="10" maxlength="10">
</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td><div align="right">Agrupado: </div></td>
            <td><div align="left">
 Si              
 <input name="radiobutton" type="radio" value="S" <?php echo $EstOptSi;?>>
 No              
 <input name="radiobutton" type="radio" value="N" <?php echo $EstOptNo;?>>
            </div></td>
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