<?php 
include("../principal/conectar_ref_web.php");


$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$grupo  = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");


?>
<html>
<head>
<title>Rechazo Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function ValidaSeleccion(Nombre)
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var valor = "";
	var rs;
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i].value;		
		//	rs = f.elements[i].value;			
		}
	}
//	alert(rs);
	return valor;
}
//*********************//
function Eliminar_Datos(f)
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var valores;
	
//	alert(valor);
	if(valor != '')
	{
		valores = "&Fecha=" + f.ano.value + "-" + f.mes.value + "-" + f.dia.value + "&turno=" + f.turno.value + "&grupo=" + f.grupo.value  + "&cuba_aux=" + valor;
	    f.action="cal_rechazo_catodos02.php?Proceso=E"+valores;
		f.submit();
    }
	else
	{
		alert('No hay Seleccionado');
		return
    }
}

function Modificar_Datos(f)
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var valores;
	
	if(valor != '')
	{
		valores = "&Fecha=" + f.ano.value + "-" + f.mes.value + "-" + f.dia.value + "&turno=" + f.turno.value + "&grupo=" + f.grupo.value  + "&cuba_aux=" + valor;
		window.opener.document.formulario.action = "cal_rechazo_catodos.php?Proceso=M"+valores;
		window.opener.document.formulario.submit();
		self.close()
	}
	else
	{
		alert('No hay Seleccionado');
		return
    }
}
function Excel()
{
    var  f=document.frmPoPup;
    var fecha=f.fecha.value;
	var grupo=f.grupo.value;
	
	
   /* alert(f.fecha.value);
	alert(f.grupo.value);
	alert(f.turno.value);*/
	document.location = "../ref_web/Detalle_carga_anodos_xls.php?fecha="+ fecha+"&grupo="+grupo;
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <table width="670" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td colspan="5" align="center">Datos Ingresados</td>
    </tr>
    <tr> 
      <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr class="ColorTabla02"> 
      <td width="46"><strong>Fecha: &nbsp;</strong></td>
      <td width="129"> 
        <?php
	  if(strlen($dia) == 1)
		 $dia="0".$dia;
	  if(strlen($mes) == 1)
		 $mes="0".$mes;
			
	   echo $fecha;
	   echo '<input type="hidden" name="ano" value="'.$ano.'">';
	   echo '<input type="hidden" name="mes" value="'.$mes.'">';
	   echo '<input type="hidden" name="dia" value="'.$dia.'">';
	   echo '<input type="hidden" name="fecha" value="'.$fecha.'">';
	   ?>
      </td>
      <td width="65"><strong>Grupo: &nbsp;</strong></td>
      <td width="55"> 
        <?php 
	  		echo $grupo;
			echo '<input type="hidden" name="grupo" value="'.$grupo.'">';
	  ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5" align="center">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="687" height="16" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr > 
      <td width="23%" align="center">Hornada</td>
      <td width="37%" align="center">Tipo</td>
      <td width="25%" align="center">Unidades</td>
      <td width="15%" align="center">Peso Unidades</td>
	  <td width="8%" align="center"><p><strong>As</strong></p>
      <p><strong>&lt;1500</strong></p></td>
      <td width="10%" align="center"><p><strong>Sb</strong></p>
      <p><strong>&lt;500</strong></p></td>
      <td width="10%" align="center"><p><strong>Bi</strong></p>
      <p><strong>&lt;15</strong></p></td>
      <td width="7%" align="center"><p><strong>Te</strong></p>
      <p><strong>&lt;50</strong></p></td>
      <td width="8%" align="center"><p><strong>O</strong></p>
      <p><strong>&lt;2000</strong></p></td>
      <td width="9%" align="center"><p><strong>Se</strong></p>
      <p><strong>&lt;300</strong></p></td>
      <td width="5%" align="center"><p><strong>Fe</strong></p>
      <p><strong>&lt;30</strong></p></td>
      <td width="6%" align="center"><p><strong>Ni</strong></p>
      <p><strong>&lt;150</strong></p></td>
    </tr>
    <?php
	$leyes=array('08','09','27','44','48','40','31','36');
	$limites=array(1500,500,15,50,2000,300,30,150);
	$Consulta = "SELECT * FROM sea_web.movimientos WHERE fecha_movimiento = '$fecha' AND campo2='".$grupo."' and cod_producto='17' ";
	$rs = mysqli_query($link, $Consulta);
	$unidades_t=0;
	$peso_t=0;
	while($row = mysqli_fetch_array($rs))
	{
		echo'<tr>'; 
		 	echo '<td align="center">'.$row["hornada"].'</td>';
			$consulta_tipo="select descripcion from proyecto_modernizacion.subproducto descripcion where cod_producto='17' and cod_subproducto='".$row["cod_subproducto"]."'";     
			$rs_tipo = mysqli_query($link, $consulta_tipo);
	        $row_tipo = mysqli_fetch_array($rs_tipo);
			echo '<td align="center">'.$row_tipo["descripcion"].'</td>';		
			echo '<td align="center">'.$row["unidades"].'</td>';
			echo '<input type="hidden" name="unidades" value="'.$row["unidades"].'">';
			echo '<td align="center">'.$row["peso"].'</td>';
			echo '<input type="hidden" name="peso" value="'.$row["peso"].'">';
       		echo '<input type="hidden" name="recup_menor" value="'.$row_tipo["descripcion"].'">';
			$consulta="select sum(t1.peso) as peso_cargado from sea_web.movimientos as t1 ";
		   	$consulta=$consulta."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08')  ";
			$Respuesta = mysqli_query($link, $consulta);
			$Fila = mysqli_fetch_array($Respuesta);
			reset($leyes);
			$l=0;
			foreach($leyes as $c => $v)
			{
					$consulta2="select t1.peso as peso_cargado,t2.valor as ley,t1.cod_subproducto as subproducto from sea_web.movimientos as t1 ";
		   			$consulta2=$consulta2."inner join sea_web.leyes_por_hornada as t2 on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$consulta2=$consulta2."where t1.hornada= '".$row["hornada"]."' and t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') and t2.cod_leyes=$v group by t1.hornada ";
					$Respuesta2 = mysqli_query($link, $consulta2);
					$Fila2 = mysqli_fetch_array($Respuesta2);
					$Fila2[ley]=number_format($Fila2["ley"],2,",","");
					if ($Fila2[ley] > $limites[$l])
					     {echo "<td align='center'><font color='red'><strong> ".$Fila2[ley]."&nbsp</strong></fornt></td>\n";}
					else echo "<td align='center'> ".$Fila2["ley"]."&nbsp</td>\n";
					$l=$l+1;
			}
			$unidades_t = $unidades_t + $row["unidades"];	
			$peso_t = $peso_t + $row["peso"];	
	}		
    	echo'</tr>';			
				
				
			
	
		echo'<tr class="Detalle02">';
			echo'<td colspan="2">Totales</td>'; 
			echo'<td align="center">'.$unidades_t.'</td>'; 
			echo'<td align="center">'.$peso_t.'</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			echo'<td align="center">--&nbsp</td>'; 
			
		echo'</tr>';			

?>
  </table>
  <br>
  <table width="670" border="" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
	<tr>
		
      <td align="center">
	  <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" > 
        <input type="button" name="salir" value="Salir" style="width:70" Onclick="self.close()">
		</td>
	</tr>
  </table>			
</form>
</body>
</html>
