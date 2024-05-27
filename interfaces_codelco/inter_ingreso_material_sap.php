<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Existe  = isset($_REQUEST["Existe"])?$_REQUEST["Existe"]:false;
	$CmbProducto    = isset($_REQUEST["CmbProducto"])?$_REQUEST["CmbProducto"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbEmpaque     = isset($_REQUEST["CmbEmpaque"])?$_REQUEST["CmbEmpaque"]:"";

	$TxtMaterialSap="";
	$TxtMedidaSap="";
	$TxtMedida="";
	$TxtCentro="";	

	if($Proceso=='M')
	{
	//echo "VVVVVVVVVVVVV".$Valores;
		$Datos2=explode('~',$Valores);
		//$CmbAsignacion=$Datos2[0];
		$CmbProducto    = $Datos2[0];
		$CmbSubProducto = $Datos2[1];
		$CmbEmpaque     = $Datos2[2];
		
			
		$Consulta="select * from interfaces_codelco.homologacion where ";
		$Consulta.=" cod_producto='".$CmbProducto."' ";
	//	$Consulta.=" and cod_subproducto='".$CmbSubProducto."' and ucase(codigo_op)='".strtoupper($TxtOP)."' ";
		$Consulta.=" and cod_subproducto='".$CmbSubProducto."'";// and materiales_sap='".$TxtMaterialSap."' ";
		$Consulta.=" and cod_empaque='".$CmbEmpaque."'";// and materiales_sap='".$TxtMaterialSap."' ";

//echo "EERRRRR".$Consulta;
		$Resp=mysqli_query($link, $Consulta);
		
		if($Fila=mysqli_fetch_array($Resp))
		{
			$TxtMaterialSap=$Fila["materiales_sap"];
			$TxtMedida=$Fila["unidad_medida"];
			$TxtMedidaSap=$Fila["unidad_medida_sap"];
			$TxtCentro=$Fila["centro"];
			$CmbEmpaque=$Fila["cod_empaque"];
		}
	}
	
?>
<html>
<head>
<title>Ingreso Material SAP</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	switch(TipoProceso)
	{
		case 'N'://GRABAR
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
			if(f.TxtMaterialSap.value == "")
			{
				alert("Debe Ingresar Material SAP");
				f.TxtMaterialSap.focus();
				return;
			}
			if(f.TxtMedida.value == 'S')
			{
				alert("Debe Ingresar Unidad Medida");
				f.TxtMedida.focus();
				return;
			}
			if(f.TxtMedidaSap.value == 'S')
			{
				alert("Debe Ingresar Unidad Medida Sap");
				f.TxtMedidaSap.focus();
				return;
			}
			if(f.TxtCentro.value == 'S')
			{
				alert("Debe Ingresra Centro");
				f.TxtCentro.focus();
				return;
			}
			if(f.CmbEmpaque.value == 'S')
			{
				alert("Debe Seleccionar Tipo Empaque");
				f.CmbEmpaque.focus();
				return;
			}
			
			f.action='inter_ingreso_material01.php?Proceso=N';
			f.submit();
			break;
		case 'M'://MODIFICAR
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
			if(f.TxtMaterialSap.value == "")
			{
				alert("Debe Ingresar Material Sap");
				f.TxtMaterialSap.focus();
				return;
			}
			if(f.TxtMedida.value == 'S')
			{
				alert("Debe Ingresar Unidad Medida Ventanas");
				f.TxtMedida.focus();
				return;
			}
			if(f.TxtMedidaSap.value == 'S')
			{
				alert("Debe Ingresra  Unidad Medida Sap");
				f.TxtMedidaSap.focus();
				return;
			}
			if(f.TxtCentro.value == 'S')
			{
				alert("Debe Ingresar Centro");
				f.TxtCentro.focus();
				return;
			}
			if(f.CmbEmpaque.value == 'S')
			{
				alert("Debe Seleccionar Tipo Empaque");
				f.CmbEmpaque.focus();
				return;
			}
			f.action='inter_ingreso_material01.php?Proceso=M&Valores='+f.Valores.value;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
		case 'R'://RECARGA
			//f.action='inter_ingreso_material_sap.php';
			f.action='inter_ingreso_material_sap.php?Proceso='+f.Proceso.value;
			f.submit();
			break;
	}
	
}
function Recarga(Tipo)
{
	var f = document.frmPrincipal;
	//alert ("hola");
/*	switch(Tipo)
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
	}*/
	f.submit();		
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

        <br>
	    <table width="420" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="9">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td width="100" height="28" align="right">Producto:</td>
            <td width="334"><div align="left"> 
                <select name="CmbProducto" id="CmbProducto" style="width:250" onChange="Procesos('R');">
                  <option class="NoSelec" value="S">Seleccionar</option>
                  <?php
				$Consulta = "select distinct t1.cod_producto,t2.descripcion  from interfaces_codelco.homologacion t1   ";
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
            <td align="right">SubProducto: </td>
            <td><div align="left"> 
                <select name="CmbSubProducto" style="width:250" <?php echo $Habilitar;?>>
                  <option class="NoSelec" value="S">Seleccionar</option>
                  <?php
				$VV = $Proceso;
				if ($Proceso == 'M' || $Proceso == 'E')
				{
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
				}
				if ($Proceso == 'N')
				{
					$Consulta = "select t1.cod_subproducto, descripcion ";
					$Consulta.= " from proyecto_modernizacion.subproducto t1 ";
					$Consulta.= " where t1.cod_producto='".$CmbProducto."' ";
					$Consulta.= " order by t1.cod_subproducto ";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
							echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					}
				}
					
			  ?>
                </select>
                <?php
				// echo $Consulta;?>  </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            
      <td align="right">Material Sap: </td>
            
      <td align="left"><input name="TxtMaterialSap"  type="text" id="TxtMaterialSap2" value="<?php echo $TxtMaterialSap;?>" size="30" maxlength="10"></td>
          </tr>
          
    <tr align="center" bgcolor="#FFFFFF"> 
      <td align="center">Unidad Medida Ven:</td>
            
      <td align="left"><input name="TxtMedida" type="text" id="TxtMedida" value="<?php echo $TxtMedida;?>" size="30" maxlength="10">
      </td>
     </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            
      <td>Unidad Medida Sap: </td>
            <td><div align="left">
          <input name="TxtMedidaSap" type="text" id="TxtMedidaSap" value="<?php echo $TxtMedidaSap;?>" size="30" maxlength="10">
        </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td><div align="right">Centro:</div></td>
            <td><div align="left"> 
          <input name="TxtCentro" type="text" value="<?php echo $TxtCentro ;?>" size="30" maxlength="10">
        </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td><div align="right">Tipo Empaque: </div></td>
            <td><div align="left">
          		<select name="CmbEmpaque" style="width:250" >
            	<option class="NoSelec" value="S">Seleccionar</option>
            		<?php
					$Consulta = "select distinct cod_empaque,descripcion  ";
					$Consulta.= " from interfaces_codelco.empaque  ";
					$Consulta.= " order by descripcion ";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($CmbEmpaque == $Fila["cod_empaque"])
							echo "<option selected value='".$Fila["cod_empaque"]."'>".str_pad($Fila["cod_empaque"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_empaque"]."'>".str_pad($Fila["cod_empaque"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					}
			  		?>
          		</select>
  
        </div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
		  <?php
		//  echo "PPPP".$Proceso;
		  ?>
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