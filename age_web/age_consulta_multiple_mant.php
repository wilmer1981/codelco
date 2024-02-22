<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 72;
	include("../principal/conectar_principal.php");
	if(!isset($TipoBusq))
		$TipoBusq='0';
?>
<html>
<head>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga(TipoBusq)
{
	var Frm=document.FrmConsultaMultMant;
	switch(TipoBusq)
	{
		case "1"://TIPO DE OPCION
			Frm.action="age_consulta_multiple_mant.php?Recarga=S&TipoBusq="+Frm.CmbOpcion.value;
			break;
		case "2"://POR CODIGO
			Frm.TxtDescripcion.value='';	
			Frm.action="age_consulta_multiple_mant.php?Recarga=S&Mostrar=S&Opcion=C";//OPCION SI BUSCA POR CODIGO(CODIGO,RUT)
			break;
		case "3"://POR DESCRIPCION
			Frm.TxtCodigo.value='';	
			Frm.action="age_consulta_multiple_mant.php?Recarga=S&Mostrar=S&Opcion=D";//OPCION SI BUSCA POR DESCRIPCION(DESCRIP,NOMBRE)
			break;
		case "4"://POR TIPO RECEPCION
			Frm.TxtCodigo.value='';	
			Frm.TxtDescripcion.value='';
			Frm.action="age_consulta_multiple_mant.php?Recarga=S&Mostrar=S&Opcion=TR";//OPCION SI BUSCA POR TIPO DE RECEPCION(MAQUILA,REPRESENTACION,COMPRA DIRECTA)
			break;
		default:
			Frm.action="age_consulta_multiple_mant.php?Recarga=S&TipoBusq=0";		
	}
	Frm.submit();
}
function Salir()
{
	window.close();
}
function Imprimir()
{
	window.print();
}
function Excel(Opcion)
{
	var Frm=document.FrmConsultaMultMant;
	
	Frm.action="age_consulta_multiple_mant_excel.php?Mostrar=S&Opcion="+Opcion;		
	Frm.submit();
}

</script>
<title>Consulta Empadronamiento Minero</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style><body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">

<form name="FrmConsultaMultMant" method="post" action="">
 
	  <table width="730" border="1" align="center" cellpadding="3" cellspacing="0" class="tablainterior">
          <tr>
            <td width="139" class="Detalle02">Consulta Por </td>
            <td width="320" align="left">
			<select name="CmbOpcion" style="width:130" onChange="Recarga('1')">
              <option value="-1">Seleccionar</option>
			  <?php
			  switch($CmbOpcion)
			  {
			  	case "1":
					echo "<option value='2'>Proveedor</option>";
					echo "<option value='4'>Padron Minero</option>";
					$OpcionCodigo=" Cod.Faena";
					$OpcionDescripcion=" Descripcion";
					break;
			  	case "2":
					echo "<option value='2' selected>Proveedor</option>";
					echo "<option value='4'>Padron Minero</option>";
					$OpcionCodigo=" Rut Prv";
					$OpcionDescripcion=" Apellido";
					break;
			  	case "3":
					echo "<option value='2'>Proveedor</option>";
					echo "<option value='4'>Padron Minero</option>";
					$OpcionCodigo=" Rut Propiet";
					$OpcionDescripcion=" Nombre";
					break;
				case "4":
					echo "<option value='2'>Proveedor</option>";
					echo "<option value='4' selected>Padron Minero</option>";
					$OpcionCodigo=" Cod.Padron";
					$OpcionDescripcion=" Nombre Prv";
					break;	
				default:
					echo "<option value='2'>Proveedor</option>";
					echo "<option value='4'>Padron Minero</option>";
					break;	
			  }
			  ?>
            </select>
            </td>
            <td width="264" align="right">
			<input type="button" name="BtnImprimir" value="Imprimir" style="width:70" onClick="Imprimir();">
			<input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Excel('<?php echo $Opcion;?>');">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();"></td>
          </tr>
          <tr>
            <td class="Detalle02">Buscar Por<?php echo $OpcionCodigo;?> </td>
            <td><input name="TxtCodigo" type="text" class="InputDer" id="TxtCodigo" VALUE="<?php echo $TxtCodigo;?>"> </td>
            <td><input name="BtnOk" type="button" value="Ok" onClick="Recarga('2')"></td>
          </tr>
          <tr>
            <td class="Detalle02">Buscar Por<?php echo $OpcionDescripcion;?></td>
            <td><input name="TxtDescripcion" type="text" class="InputIzq" id="TxtDescripcion" size="60" value="<?php echo $TxtDescripcion;?>"></td>
            <td><input name="BtnOk2" type="button" value="Ok" onClick="Recarga('3')"></td>
          </tr>
  </table>
	  <div align="center"><br> 
  </div>
	  <table width="730" border="1" cellspacing="0" cellpadding="3" class="tablainterior" align="center">
          <tr class="ColorTabla01">
		  <?php
		  switch($CmbOpcion)
		  {
			case "2":
				echo "<td align='center' width='100'>Rut</td>";
				echo "<td align='center' width='650'>Apellidos,Nombres</td>";
				break;				  
			case "4":
				echo "<td align='center' width='60'>Cod.Mina</td>";
				echo "<td align='center' width='150'>Mina/Planta</td>";
				echo "<td align='center' width='150'>Proveedor</td>";
				echo "<td align='center'  width='70'>Sierra</td>";
				echo "<td align='center'  width='70'>Comuna</td>";
				echo "<td align='center'  width='70'>Fec.Padron</td>";
				break;					  
		  }	
		  ?>	  
		  </tr>
		  <?php
			if ($Mostrar=='S')	
			{
				switch($CmbOpcion)
				{
					case "2"://POR PROVEEDOR
						if ($Opcion=='C')
							$Consulta= "select * from sipa_web.proveedores where rut_prv = '".$TxtCodigo."'";
						else		
							$Consulta= "select * from sipa_web.proveedores where nombre_prv like '%".$TxtDescripcion."%'";	
						break;
					case "4"://POR EMPADRONAMIENTO MINERO
						switch($Opcion)
						{
							case "C"://POR CODIGO DE MINA
								$Consulta="select * from sipa_web.minaprv where cod_mina like '%".$TxtCodigo."%'";
								break;
							case "D"://POR DESCRIPCION
								$Consulta="select * from sipa_web.minaprv where nombre_mina like '%".$TxtDescripcion."%'";								
								break;
						}	
						break;
					default:
						break;	
				}
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckCod'>";
				while ($Fila = mysqli_fetch_array($Resp))
				{
				  switch($CmbOpcion)
				  {
					case "2"://PROVEEDOR
						echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
						echo "<td align='center'>".$Fila["rut_prv"]."</td>\n";
						echo "<td align='Left'>".$Fila["nombre_prv"]."</td>\n";
						echo "</tr>\n";
						break;
					case "4"://MINA
						echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
						echo "<td align='center'>".$Fila["cod_mina"]."</td>\n";
						echo "<td align='left'>".$Fila["nombre_mina"]."</td>\n";
						echo "<td align='center'>".$Fila["rut_prv"]." - ".$Fila["NOMPRV_A"]."</td>\n";
						echo "<td align='left'>".$Fila["sierra"]."</td>\n";
						echo "<td align='left'>".$Fila["comuna"]."</td>\n";
						echo "<td align='center'>".$Fila["fecha_padron"]."</td>\n";
						echo "</tr>\n";
						break;
					}	
				}
			}
		  ?>
  </table>
</form>
</body>
</html>