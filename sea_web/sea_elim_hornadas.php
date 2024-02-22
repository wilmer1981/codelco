<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 60;

	if(isset($_REQUEST["Msj"])) {
		$Msj = $_REQUEST["Msj"];
	}else{
		$Msj =  "";
	}
	if(isset($_REQUEST["recargapag"])) {
		$recargapag = $_REQUEST["recargapag"];
	}else{
		$recargapag =  "";
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano = "";
	}
	if(isset($_REQUEST["activar"])) {
		$activar = $_REQUEST["activar"];
	}else{
		$activar =  "";
	}
	if(isset($_REQUEST["mostrar"])) {
		$mostrar = $_REQUEST["mostrar"];
	}else{
		$mostrar =  "";
	}

	if(isset($_REQUEST["txthornada"])) {
		$txthornada = $_REQUEST["txthornada"];
	}else{
		$txthornada = "";
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = date("Y-m-d");
	}
	


?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga(f)
{
	/* vector = f.cmbproducto.value.split("-"); */
	chequeado = "S";
	mostrar = "S";

	f.action = "sea_elim_hornadas.php?recargapag=S&ano=" + f.ano.value + "&activar=" + chequeado + "&mostrar=" + mostrar;		
	f.submit();	
}

/**************/
function Elimina()
{
	var f=document.frm1;
	var Valores="";
	//alert (f.cmbproducto.value);
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="OptSelec" && f.elements[i].checked==true)
		{	
			Valores=Valores+f.elements[i+1].value+"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substring(0,(Valores.length-2));
		if(confirm('Esta Seguro de Eliminar las hornadas seleccionadas'))
		{			
			//alert (Valores);
			f.action="sea_elim_hornadas01.php?Proceso=EM&Valores="+Valores;
			f.submit();	
		}	
	}
	else
		alert('Debe Seleccionar Hornada a Eliminar');	
		
}
/**************/
function Salir()
{
	//document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1"
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
</script>
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 		 <tr>
 		   <td align="center" bgcolor="#FFFFFF">ELIMINACI&Oacute;N HORNADAS Y SUS MOVIMIENTOS</td></tr>

    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="118">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>A&ntilde;o</td>
            <td><select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
              <?php
	if($mostrar=='S' || $Proceso == 'V')
	{
	    for ($i=date("Y")-5;$i<=date("Y")+0;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-5;$i<=date("Y")+0;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
            </select></td>
          </tr>
          <tr>
            <td>N&deg; Hornada</td>
            <td><input name="txthornada" type="text" size="14" value="<?php echo $txthornada ?>"></td>
          </tr>
          <tr><td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		<?php
			//$CmbAno=date("Y");
			//$Prod = explode("-", $cmbproducto); 
			?>
          <tr> 
          <tr align="center"> 
            <td colspan="2">
              <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="JavaScript:Recarga(this.form)">
              <input name="BtnElimina" type="button" onClick="JavaScritp:Elimina(this.form)" value="Elimina" style="width:70px">
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="80%" border="1" cellspacing="0" cellpadding="3">
          <tr align="center" class="ColorTabla01">
            <td width="30">Selec</td>
            <td width="54">Producto</td>
            <td width="54">SubProducto</td>
			<td width="54">Hornada</td>
            <td width="70">Unidades</td>
            <td width="80">Peso(Kg)</td>
          </tr>
        
		<?php
			//if($recargapag=='S')
			//{
				//$FechaConsulta = substr($TxtFechaFin,0,8)."31";
				//$FechaInicio = substr($TxtFechaFin,0,8)."01";
				$Horna = $ano . $txthornada;
				$TotalUnidad = 0;
				$TotalPeso = 0;			
				if ($recargapag == "S")
				{
						$consulta = "SELECT cod_producto, cod_subproducto, hornada_ventana,  unidades, peso_unidades FROM sea_web.hornadas";
						$consulta.= " where hornada_ventana='".$Horna."'";
						$consulta.= " order by  hornada_ventana";
						$resp = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($resp))
						{
							
							$TotalUnidad = $TotalUnidad + $row["unidades"];
							$TotalPeso = $TotalPeso + $row["peso_unidades"];
						    $datos = $row["hornada_ventana"]."~".$row["cod_producto"]."~".$row["cod_subproducto"]."~".
						    $row["unidades"]."~".$row["peso_unidades"]."~".$ano."~".$txthornada."~".$mostrar."~"."S";
							echo '<tr>';
							echo '<td><input type="checkbox" name="OptSelec" value="datos" ><input type="hidden" value='.$datos.'></td>';

							$Consulta = "Select descripcion from proyecto_modernizacion.productos where cod_producto='" .$row["cod_producto"]."'";
							//echo $Consulta;
							$Resultado = mysqli_query($link, $Consulta);
							if ($Row = mysqli_fetch_array($Resultado))
							{
								$descripcioncodprod = ucwords(strtolower($Row["descripcion"]));
							}

							$Consulta = "Select descripcion from proyecto_modernizacion.subproducto where cod_producto='".$row["cod_producto"]."' and cod_subproducto='".$row["cod_subproducto"]."'";
								//echo $Consulta;
							$Resultado = mysqli_query($link, $Consulta);
							if ($Row = mysqli_fetch_array($Resultado))
							{
								$descripcioncodsubprod = ucwords(strtolower($Row["descripcion"]));
							}
											
							echo '<td align="center">'.$descripcioncodprod.'</td>';
							echo '<td align="center">'.$descripcioncodsubprod.'</td>';
							echo '<td align="center">'.$row["hornada_ventana"].'</td>';
							echo '<td align="right"><font color="blue">'.$row["unidades"].'</font></td>';
							echo '<td align="right"><font color="blue">'.$row["peso_unidades"].'</font></td>';					
							echo '</tr>';
						}	
				}								
			//}
		
		?>
		<tr>
		<td colspan="4">TOTAL</td>
		<td align="right"><font color="blue"><?php echo $TotalUnidad; ?></font></td>
		<td align="right"><font color="blue"><?php echo $TotalPeso; ?></font></td>
		</tr>
		</table>
		<br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>

<script language="javascript">
<?php
switch($Msj)
{
	case '1':
    ?>alert("Error: No se pudo Eliminar la Hornada en la base de datos, tabla: sea_web.stock");<?php
	break;
	
	case '2':
	?>alert("Hornada Eliminada Correctamente");<?php
	break;
	
	case '3':
    ?>alert("Error: No se pudo Eliminar la Hornada en la base de datos, tabla: sea_web.hornadas");<?php	
	break;
	
	case '4':
    ?>alert("Error: No se pudo Eliminar la Hornada en la base de datos, tabla: sea_web.movimientos");<?php	
	break;
	
	case '5':
    ?>alert("Error: No se pudo Eliminar la Hornada en la base de datos, tabla: sea_web.relaciones");<?php	
	break;
	
	case '6':
    ?>alert("Error: No se pudo Eliminar la Hornada en la base de datos, tabla: sea_web.leyes_por_hornadas");<?php	
	break;
	
    case '10':
    ?>alert("Error: No se pudo grabar datos Auditoria");<?php	
	break;
	
}

 ?>
</script>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
