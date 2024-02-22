<?php 
include("../principal/conectar_ram_web.php");

if($Proceso == "E")
{
	$Eliminar = "DELETE FROM ram_web.movimiento_conjunto WHERE fecha_movimiento = '".$radio."' AND cod_existencia = ".$cod_existencia;
	mysqli_query($link, $Eliminar); 
	$fecha = substr($radio,0,10);
	$movimiento = $cod_existencia;
}
?>
<html>
<head>
<title>Movimiento de Conjuntos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function ValidaSeleccion2(Nombre)
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var valor = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = "Proceso=M&fecha=" + f.elements[i].value;
			valor = valor + "&cmbmovimiento_aux=" + f.elements[i+1].value;
			valor = valor + "&num_conjunto_aux=" + f.elements[i+2].value; 
			valor = valor + "&cmbtipo_aux=" + f.elements[i+3].value;

			valor = valor + "&nombre_conjunto_aux=" + f.elements[i+4].value;
			valor = valor + "&stock_aux=" + f.elements[i+5].value;
			valor = valor + "&cod_lugar_aux=" + f.elements[i+6].value;
			valor = valor + "&num_lugar_aux=" + f.elements[i+7].value;
			valor = valor + "&lugar_origen_aux=" + f.elements[i+8].value;
			
			valor = valor + "&num_conjunto_d_aux="  + f.elements[i+9].value;
			valor = valor + "&cmbtipo_d_aux=" + f.elements[i+10].value;
			valor = valor + "&nombre_conjunto_d_aux=" + f.elements[i+11].value;
			valor = valor + "&cod_lugar_d_aux=" + f.elements[i+12].value;
			valor = valor + "&num_lugar_d_aux=" + f.elements[i+13].value;
			valor = valor + "&lugar_destino_aux=" + f.elements[i+14].value;

			valor = valor + "&peso_humedo_aux=" + f.elements[i+15].value; 
			valor = valor + "&estado_val_aux=" + f.elements[i+16].value; 
		}
	}
	return valor;
}

function ValidaSeleccion(Nombre)
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var valor = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i+1].value;
		}
	}
	return valor;
}
//*********************//
function Eliminar(f)
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
	    f.action="ram_ing_movimientos02.php?Proceso=E&cod_existencia="+valor;
		f.submit();
    }
	else
	{
		alert('No hay Movimiento Seleccionado');
		return
    }
}

function Modificar()
{
	var valor = ValidaSeleccion2('radio');
	
	window.opener.document.formulario.action = "ram_ing_movimientos.php?" + valor;
	window.opener.document.formulario.submit();
	window.close();
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    <table width="750" cellpadding="3" cellspacing="0" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="8"><div align="center">Movimiento de Conjuntos</div></td>
      </tr>
    </table>
  </div>		
  <div align="left" style="position:absolute; overflow:auto; top: 32px; height: 445px;"> 
    <table width="750" cellpadding="3" cellspacing="0" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla01"> 
        <td width="91" height="20" align="center">T. Mov.</td>
        <td width="150" align="center">Fecha</td>
        <td width="53" align="center">Cjto.Origen</td>
        <td width="200" align="center">Descripci�n</td>
        <td width="59" align="center">Cjto.Destino</td>
        <td width="152" align="center">Descripci�n</td>
        <td width="65" align="center">P. Humedo</td>
        <td width="65" align="center">Valid.</td>
      </tr>
<?php 
	include("../principal/conectar_ram_web.php");
	if(strlen($mes) == 1)
		$mes = "0".$mes;   

	if(strlen($dia) == 1)
		$dia = "0".$dia;   

	if($fecha == '')
	 $fecha = $ano.'-'.$mes.'-'.$dia;
	
	$consulta = "SELECT * FROM ram_web.movimiento_conjunto where left(fecha_movimiento,10) = '".$fecha."' and cod_existencia = ".$movimiento." order by fecha_movimiento"; 
	$rs = mysqli_query($link, $consulta);

	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr><td>';
		
		$consulta = "SELECT nombre_existencia FROM ram_web.atributo_existencia WHERE cod_existencia = ".$row[cod_existencia];
		$rs3 = mysqli_query($link, $consulta);
		if($row3 = mysqli_fetch_array($rs3))
		{
			$existencia = $row3[nombre_existencia];
		}
		echo '<input type="radio" name="radio" value="'.$row[fecha_movimiento].'">'.$existencia.'</td>';//0
		echo '<input type="hidden" name="cod_existencia" size="3" value="'.$row[cod_existencia].'">';//1

		echo '<td align="center">'.$row[fecha_movimiento].'</td>';					 
	
		echo '<td align="left">'.$row[cod_conjunto].'-'.$row[num_conjunto].'</td>';					 
		echo '<input type="hidden" name="num_conjunto" size="3" value="'.$row[num_conjunto].'">';//2

		$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = $row[num_conjunto] and estado != 'f' and cod_conjunto = $row[cod_conjunto]";
		$rs3 = mysqli_query($link, $consulta);

		if($row3 = mysqli_fetch_array($rs3))
		{
				echo '<td>'.$row3["descripcion"].'</td>';
				echo '<input type="hidden" name="cod_conjunto" size="3" value="'.$row3[cod_conjunto].'">';//3
				echo '<input type="hidden" name="nombre_conjunto" size="3" value="'.$row3["descripcion"].'">';//4

				if($row3[peso_conjunto] != '' AND $row3[peso_conjunto] > 0)
					echo '<input type="hidden" name="stock" size="3" value="'.$row3[peso_conjunto].'">';//5
				else
					echo '<input type="hidden" name="stock" size="3" value="0">';//5

				echo '<input type="hidden" name="cod_lugar" size="3" value="'.$row[cod_lugar_origen].'">';//6
				echo '<input type="hidden" name="num_lugar" size="3" value="'.$row[lugar_origen].'">';//7
				
				$Consulta = "SELECT * FROM ram_web.lugar_conjunto WHERE cod_tipo_lugar = $row[cod_lugar_origen] AND num_lugar = $row[lugar_origen]";
				$rs5 = mysqli_query($link, $Consulta);

				if($row5 = mysqli_fetch_array($rs5))
				{  				
					echo '<input type="hidden" name="lugar_origen" size="3" value="'.$row5[descripcion_lugar].'">';//8
				}
		}
		echo '<td align="left">'.$row[cod_conjunto_destino].'-'.$row[conjunto_destino].'</td>';					 
		echo '<input type="hidden" name="conjunto_destino" size="3" value="'.$row[conjunto_destino].'">';//9

		$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = $row[conjunto_destino] and estado != 'f' and cod_conjunto = $row[cod_conjunto_destino]";
		$rs3 = mysqli_query($link, $consulta);

		if($row3 = mysqli_fetch_array($rs3))
		{
				echo '<td>'.$row3["descripcion"].'</td>';
				echo '<input type="hidden" name="cod_conjunto_destino" size="3" value="'.$row3[cod_conjunto].'">';//10
				echo '<input type="hidden" name="nombre_conjunto_d" size="3" value="'.$row3["descripcion"].'">';//11

				echo '<input type="hidden" name="cod_lugar_d" size="3" value="'.$row[cod_lugar_destino].'">';//12
				echo '<input type="hidden" name="num_lugar_d" size="3" value="'.$row[lugar_destino].'">';//13
				
				$Consulta = "SELECT * FROM ram_web.lugar_conjunto WHERE cod_tipo_lugar = $row[cod_lugar_destino] AND num_lugar = $row[lugar_destino]";
				$rs5 = mysqli_query($link, $Consulta);

				if($row5 = mysqli_fetch_array($rs5))
				{  				
					echo '<input type="hidden" name="lugar_destino" size="3" value="'.$row5[descripcion_lugar].'">';//14					
				}
				
		}
		echo '<td align="center">'.number_format($row[peso_humedo_movido]/1000,3,",","").'</td>';
		echo '<input type="hidden" name="peso_humedo" size="3" value="'.$row[peso_humedo_movido].'">';//15
		if($row[estado_validacion] != 0)
		{
			echo '<input type="hidden" name="estado_val" size="3" value="1">';//16
		    echo '<td align="center">'.number_format($row[estado_validacion]/1000,3,",","").'</td></tr>';
		}
		else
		{
			echo '<input type="hidden" name="estado_val" size="3" value="0">';//16
		    echo '<td align="center">'.number_format($row[estado_validacion]/1000,3,",","").'</td></tr>';
		}
	}

?>	
  </table>
  </div>
  
  <div align="left" style="position:absolute; top: 475px; left: 81px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
		<?php 
			$dia_a = date("j");
			$mes_a = date("n");
			$ano_a = date("Y");
			$fecha_actual = $ano_a.'-'.$mes_a.'-'.$dia_a;
			
			$Consulta = "SELECT PERIOD_DIFF($fecha,$fecha_actual) AS dif";
			$rs4 = mysqli_query($link, $Consulta);
			if($row_d = mysqli_fetch_array($rs4))
			{
				$dif = $row_d[dif];
			}
	
			$Consulta = "SELECT * FROM proyecto_modernizacion.sistemas_por_usuario WHERE rut = '$CookieRut' AND cod_sistema = 7";
			include("../principal/conectar_principal.php"); 
			$rs = mysqli_query($link, $Consulta); 
			
			if($row = mysqli_fetch_array($rs))
			{
				if($row[nivel] != 1 && $row[nivel] != 3 && $row[nivel] != 2 && $dif > 2)
				{
					$Acceso = 'N';
				}
			}			

		    if($Acceso != 'N')
		    {	
	           echo '<input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="JavaScript:Eliminar(this.form)">&nbsp;';
    	       echo '<input name="btnmodificar" type="button" style="width:70" value="Modificar" onClick="JavaScript:Modificar()">';
            } 	
		?>
		  <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
