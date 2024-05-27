<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$CmbAsignacion  = isset($_REQUEST["CmbAsignacion"])?$_REQUEST["CmbAsignacion"]:"";
	$CmbProducto    = isset($_REQUEST["CmbProducto"])?$_REQUEST["CmbProducto"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbMateriales  = isset($_REQUEST["CmbMateriales"])?$_REQUEST["CmbMateriales"]:"";
	$CmbDivision    = isset($_REQUEST["CmbDivision"])?$_REQUEST["CmbDivision"]:"";
	$CmbUnidad      = isset($_REQUEST["CmbUnidad"])?$_REQUEST["CmbUnidad"]:"";
	$Existe         = isset($_REQUEST["Existe"])?$_REQUEST["Existe"]:"";
	
	$TxtClase  = "";
	$TxtOP     = "";
	$Habilitar = TRUE;

	if($Proceso=='M')
	{
		$Datos2=explode('~',$Valores);
		$CmbAsignacion = $Datos2[0];
		$CmbProducto   = $Datos2[1];
		$CmbSubProducto= $Datos2[2];
		$TxtOP         = $Datos2[3];		
			
		$Consulta="SELECT * from interfaces_codelco.ordenes_produccion where ";
		if($CmbAsignacion == "")
			$Consulta.="  isnull(asignacion) ";
		else
			$Consulta.="  asignacion ='".$CmbAsignacion."' ";
		$Consulta.=" and cod_producto='".$CmbProducto."' ";
		$Consulta.=" and cod_subproducto='".$CmbSubProducto."' and ucase(codigo_op)='".strtoupper($TxtOP)."' ";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta;
		if($Fila=mysqli_fetch_array($Resp))
		{
			$CmbMateriales=$Fila["cod_material_sap"];
			$CmbUnidad=$Fila["unidad_medida"];
			$CmbDivision=$Fila["centro"];
			$TxtClase=$Fila["clase_valorizacion"];
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
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			if(f.CmbAsignacion.value == 'S')
			{
				alert("Debe Seleccionar Asignaci�n");
				f.CmbAsignacion.focus();
				return;
			}
			if(f.CmbProducto.value == 'S')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}
			if(f.CmbSubProducto.value == 'S')
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if(f.TxtOP.value == "")
			{
				alert("Debe Ingresar Codigo OP");
				f.TxtOP.focus();
				return;
			}
			if(f.CmbMateriales.value == 'S')
			{
				alert("Debe Seleccionar Materiales");
				f.CmbMateriales.focus();
				return;
			}
			if(f.CmbUnidad.value == 'S')
			{
				alert("Debe Seleccionar Unidad");
				f.CmbUnidad.focus();
				return;
			}
			if(f.CmbDivision.value == 'S')
			{
				alert("Debe Seleccionar Division");
				f.CmbDivision.focus();
				return;
			}
			if(f.TxtClase.value == "")
			{
				alert("Debe Ingresar Clase Valorizacion");
				f.TxtClase.focus();
				return;
			}
			f.action='inter_orden_produccion01.php?Proceso=N';
			f.submit();
			break;
		case 'M'://MODIFICAR
			if(f.CmbAsignacion.value == 'S')
			{
				alert("Debe Seleccionar Asignación");
				f.CmbAsignacion.focus();
				return;
			}
			if(f.CmbProducto.value == 'S')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProducto.focus();
				return;
			}
			if(f.CmbSubProducto.value == 'S')
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if(f.TxtOP.value == "")
			{
				alert("Debe Ingresar Codigo OP");
				f.TxtOP.focus();
				return;
			}
			if(f.CmbMateriales.value == 'S')
			{
				alert("Debe Seleccionar Materiales");
				f.CmbMateriales.focus();
				return;
			}
			if(f.CmbUnidad.value == 'S')
			{
				alert("Debe Seleccionar Unidad");
				f.CmbUnidad.focus();
				return;
			}
			if(f.CmbDivision.value == 'S')
			{
				alert("Debe Seleccionar Division");
				f.CmbDivision.focus();
				return;
			}
			if(f.TxtClase.value == "")
			{
				alert("Debe Ingresar Clase Valorizacion");
				f.TxtClase.focus();
				return;
			}
			f.action='inter_orden_produccion01.php?Proceso=M&Valores='+f.Valores.value;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
		case 'R'://RECARGA
			//f.action='inter_orden_produccion_proceso.php';
			f.action='inter_orden_produccion_proceso.php?Proceso='+f.Proceso.value;
			f.submit();
			break;
	}
	
}
function Recarga(Tipo)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case '1'://BUSCAR POR PATENTE
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '2'://BUSCAR POR PROVEEDOR
			f.action='rec_ingreso_conjuntos_proceso.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '3'://BUSCAR POR PRODUCTO
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '5'://BUSCAR TODOS
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
	}
	f.submit();		
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valores" value="<?php echo $Valores;?>">
	    <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td width="89" align="right">Asignacion:</td>
			<td width="357"><div align="left">
			  <select name="CmbAsignacion" style="width:300">
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "select distinct asignacion from interfaces_codelco.asignaciones  ";
				$Consulta.= " order by asignacion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbAsignacion == $Fila["asignacion"])
						echo "<option selected value='".$Fila["asignacion"]."'>".$Fila["asignacion"]."</option>\n";
					else
						echo "<option value='".$Fila["asignacion"]."'>".$Fila["asignacion"]."</option>\n";
				}
			?>
              </select>
			</div></td> 
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td height="28" align="right">Producto:</td>
			<td><div align="left">
			 <!-- <select name="CmbProducto" id="CmbProducto" style="width:300" onChange="Procesos('R');">-->
			  <select name="CmbProducto" id="CmbProducto" style="width:300" onChange="Recarga('R');">
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT distinct t1.cod_producto,t2.descripcion  from interfaces_codelco.homologacion t1   ";
				$Consulta.= "  inner join  proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto ";
				$Consulta.= " order by t2.descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProducto == $Fila["cod_producto"])
						echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
					else
						echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
				}
			?>
              </select>
			  
			</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">SubProducto:
			</td>
            <td><div align="left">
              <select name="CmbSubProducto" style="width:300" <?php echo $Habilitar;?>>
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "select t1.cod_subproducto, descripcion ";
				$Consulta.= " from proyecto_modernizacion.subproducto t1 ";
				$Consulta.= " inner join interfaces_codelco.homologacion t2 on t1.cod_producto = t2.cod_producto ";
				$Consulta.= " and  t1.cod_subproducto = t2.cod_subproducto ";
				$Consulta.= " where t1.cod_producto='".$CmbProducto."' ";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
              </select>
			  <?php //echo $Consulta;?>
            </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Codigo OP: </td>
            <td align="left"><input name="TxtOP" type="text" id="TxtOP" value="<?php echo $TxtOP;?>" size="30" maxlength="10"></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Material Sap :</td>
            <td align="left">
			<select name="CmbMateriales" style="width:300" <?php echo $Habilitar;?> >
              <option class="NoSelec" value="S">Seleccionar</option>
              <?php
				$Consulta = "select distinct materiales_sap, (materiales_sap*1) as orden  ";
				$Consulta.= " from interfaces_codelco.homologacion  ";
				$Consulta.= " order by orden asc ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbMateriales == $Fila["materiales_sap"])
						echo "<option selected value='".$Fila["materiales_sap"]."'>".$Fila["materiales_sap"]."</option>\n";
					else
						echo "<option value='".$Fila["materiales_sap"]."'>".$Fila["materiales_sap"]."</option>\n";
				}
			  ?>
            </select>
			</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td>Unidad Medida: </td>
            <td><div align="left">
              <select name="CmbUnidad" style="width:300" >
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "select distinct unidad_medida  ";
				$Consulta.= " from interfaces_codelco.homologacion  ";
				$Consulta.= " order by unidad_medida ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbUnidad == $Fila["unidad_medida"])
						echo "<option selected value='".$Fila["unidad_medida"]."'>".$Fila["unidad_medida"]."</option>\n";
					else
						echo "<option value='".$Fila["unidad_medida"]."'>".$Fila["unidad_medida"]."</option>\n";
				}
			  ?>
              </select>
            </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td><div align="right">Division:</div></td>
            <td><div align="left">
              <select name="CmbDivision" style="width:300" >
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT distinct centro  ";
				$Consulta.= " from interfaces_codelco.ordenes_produccion  ";
				$Consulta.= " order by centro ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbDivision == $Fila["centro"])
						echo "<option selected value='".$Fila["centro"]."'>".$Fila["centro"]."</option>\n";
					else
						echo "<option value='".$Fila["centro"]."'>".$Fila["centro"]."</option>\n";
				}
			  ?>
              </select>
</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td><div align="right">Clase Valor: </div></td>
            <td><div align="left">
              <input name="TxtClase" type="text" value="<?php echo $TxtClase ;?>" size="30" maxlength="10">
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