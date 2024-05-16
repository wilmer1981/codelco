<?php 	
	include("../principal/conectar_principal.php");

	$Valores  =  isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Imprimir()
{
	var Frm=document.FrmProceso;
	
	Frm.BtnImprimir.style.visibility='hidden';
	Frm.BtnSalir.style.visibility='hidden';
	window.print();
	Frm.BtnImprimir.style.visibility='';
	Frm.BtnSalir.style.visibility='';
}

function Salir()
{
	window.close();
}
</script>
<title>Ingreso de Leyes</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body onload='' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>
<form name="FrmProceso" method="post" action="">
  <table width="546" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554" align="center" valign="top"><table width="500" border="0" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="150" align="right">&nbsp;</td> 
            <td width="179" align="right"><div align="center"><strong>LEYES PROVISIONALES</strong></div></td>
            <td width="150" align="right">
              <div align="center">
                <input type="button" name="BtnImprimir" value="Imprimir" style="width:60" onClick="Imprimir();">
			    <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			  </div></td>
          </tr>
        </table>
        <br>
        <table width="500" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td  align="center" width="100">S.A</td>
			<td  align="center" width="100">Lote</td>
			<td  align="center" width="100">Ley</td>
			<td  align="center" width="100">Valor</td>
			<td  align="center" width="50">Unidad</td>
			<td  align="center" width="50">Virtual</td>
          </tr>
		<?php
		$Datos1=explode('//',$Valores);
		foreach($Datos1 as $Clave=>$Valor)
		{
			$Datos2=explode('~~',$Valor);
			$SA         =isset($Datos2[0])?$Datos2[0]:"";
			$Recargo    =isset($Datos2[1])?$Datos2[1]:"";
			$FechaIni   =isset($Datos2[2])?$Datos2[2]:"";
			$FechaFin   =isset($Datos2[3])?$Datos2[3]:"";
			$Producto   =isset($Datos2[4])?$Datos2[4]:"";
			$SubProducto=isset($Datos2[5])?$Datos2[5]:"";
			//CONSULTA LEYES DE LA SOLICITUD
			$Consulta = "select DISTINCT t2.cod_leyes,t4.abreviatura as nomley,t2.valor, t2.cod_unidad, t3.abreviatura, t2.virtual as virt,t2.id_muestra ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";	
			$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t4 on t2.cod_leyes = t4.cod_leyes ";
			$Consulta.= " where t1.estado_actual<>'7'";
			$Consulta.= " and t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' ";
			$Consulta.= " and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' ";
			$Consulta.= " and t1.nro_solicitud = '".$SA."'";
			$Consulta.= " and t1.recargo = '".$Recargo."'";
			$Consulta.= " order by t2.cod_leyes"; 
			$Respuesta=mysqli_query($link, $Consulta);	
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				if($Fila["valor"]==''||$Fila["virt"]=='S')
					$Datos=$SA."~".$Recargo."~".$Fila["cod_leyes"];
				else
					$Datos='';	
				if (($Recargo=='')||(is_null($Recargo)))
					echo "<td class='Detalle01' align='center'>".$SA."</td>";
				else
					echo "<td class='Detalle01' align='center'>".$SA."-".$Recargo."</td>";	
				echo "<td class='Detalle02'align='center'>".$Fila["id_muestra"]."</td>";
				echo "<td align='center'>".$Fila["nomley"]."</td>";
				if($Fila["valor"]==''||$Fila["virt"]=='S')
					echo "<td align='center' class='Detalle01'>".number_format($Fila["valor"],$ArrParamLeyes[$Fila["cod_leyes"]][2],',','')."</td>";
				else
					echo "<td align='center' class='Detalle01'>".number_format($Fila["valor"],$ArrParamLeyes[$Fila["cod_leyes"]][2],',','')."</td>";
				echo "<td align='center'>".$Fila["abreviatura"]."</td>";
				echo "<td align='center'>".$Fila["virt"]."</td>";
				echo "</tr>";
			}
		}  
		?>
        </table></td>
  </tr>
</table>
  </form>
</body>
</html>