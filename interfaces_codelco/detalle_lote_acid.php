 <?php
	include("../principal/conectar_pac_web.php");

	$CmbAno     = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$CmbMes     = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$RutCliente = isset($_REQUEST["RutCliente"])?$_REQUEST["RutCliente"]:"";

	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var Frm = document.FrmConsultaGuias;
	switch (opt)
	{
		case "I":
			window.print();			
	}
}
function  Salir()
{
	window.close();
}
function Historial(NG)
{
	var Frm=document.FrmGuia;
	var Valores="";
	window.open("../pac_web/pac_guia_despacho02.php?Valores="+NG,"","top=110,left=10,width=700,height=335,scrollbars=no,resizable = yes");
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmConsultaGuias" action="" method="post">
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center"> 
      <td width="720" colspan="5">	    <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I');"> 
          <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Salir();">      </td></tr>
  </table>
  <br>
  <table width='700' border='1' align="center" cellpadding='3' cellspacing='0' class='TablaDetalle'>
    <tr class='ColorTabla01'> 
      <td width='125' align="center">Fecha</td>
      <td width='60'  align='center'>Guia</td>
      <td width='60'  align='center'>Patente</td>
      <td width='125'  align='left'>Cliente</td>
      <td width='50'  align='center'>Toneladas</td>
	  <td width='50'  align='center'>V.Unitario</td>
      <td width='50'  align='left'>Tipo</td>
      <td width='110' align='left'>Operador</td>
    </tr>
    <?php
			/*if ($CmbGuias=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and t1.tipo_guia='".$CmbGuias."'";
			}*/
			$FechaInicio  = $CmbAno."-".$CmbMes."-01 00:00:01";
			$FechaTermino = $CmbAno."-".$CmbMes."-31 23:59:59";
			$Consulta="select t1.fecha_hora,t1.num_guia,t1.nro_patente,t1.toneladas,t2.nombre,t1.tipo_guia,t3.valor_subclase1 as operador,t1.valor_unitario ";
			$Consulta.=" from pac_web.guia_despacho t1 left join pac_web.clientes t2 on t1.rut_cliente = t2.rut_cliente";
			$Consulta.=" left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9002 and t1.rut_funcionario =t3.nombre_subclase ";
			$Consulta.=" where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";//.$Filtro;
			$Consulta.=" and t1.rut_cliente='".$RutCliente."' and t1.estado != 'N' ";
			//echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td align='center'>".$Fila["fecha_hora"]."</td>";
				echo "<td align='center'><a href=\"JavaScript:Historial('".$Fila["num_guia"]."')\">".$Fila["num_guia"]."</td>";
				if ($Fila["nro_patente"]=="")
					echo "<td align='center'>&nbsp;</td>";
				else
					echo "<td align='center'>".$Fila["nro_patente"]."</td>";
				echo "<td align='left'>".$Fila["nombre"]."</td>";
				echo "<td align='right'>".$Fila["toneladas"]."</td>";
				echo "<td align='right'>".$Fila["valor_unitario"]."</td>";
				if ($Fila["tipo_guia"]=='C')
				{
					echo "<td align='center'>Camion</td>";
				}
				else
				{
					echo "<td align='center'>Buque</td>";
				}
				if ($Fila["operador"]=="")
					echo "<td align='left'>&nbsp;</td>";
				else
					echo "<td align='left'>".$Fila["operador"]."</td>";
				echo "</tr>";
				$Total=$Total+$Fila["toneladas"];
			}
			echo "<tr class='Detalle01'>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>Total</td>";
			echo "<td align='right'>".number_format($Total,'2',',','.')."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
	?>
  </table>		
</form>		
</body>
</html>
