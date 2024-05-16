<?php 	
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function RecuperarValores()
{
	var Frm=document.FrmProceso;
	var Valores2="";
	var i=0;
		
	try
	{
		Frm.TxtValores[0].value;
		for (i=1;i<Frm.TxtValores.length;i++)
		{
			if (Frm.TxtValores[i].value!='')
			{
				Valores2=Valores2+Frm.TxtValores[i].value+'~'+Frm.TxtValor[i].value+'//';
			}	
		}
		Valores2=Valores2.substr(0,Valores2.length-2);
		return(Valores2);
	}
	catch (e)
	{
	}
	
}
function Grabar()
{
	var Frm=document.FrmProceso;
	var ValoresAux="";
	
	ValoresAux=RecuperarValores();
	Frm.action="age_leyes_virtuales01.php?Proceso=G&Valoresx="+ValoresAux;
	Frm.submit();
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
    <td width="554"><table width="535" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="right">
			<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('G')">
            <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			</td>
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
		//echo $Valores;
		$Datos1=explode('//',$Valores);
		while(list($Clave,$Valor)=each($Datos1))
		{
			$Datos2=explode('~~',$Valor);
			$SA=$Datos2[0];
			$Recargo=$Datos2[1];
			$FechaIni=$Datos2[2];
			$FechaFin=$Datos2[3];
			$Producto=$Datos2[4];
			$SubProducto=$Datos2[5];
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
			echo "<input type='hidden' name='TxtValores'><input type='hidden' name='TxtValor'>";
			//echo $Consulta;
			$Respuesta=mysqli_query($link, $Consulta);	
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				if($Fila["valor"]==''||$Fila["virt"]=='S')
					$Datos=$SA."~".$Recargo."~".$Fila["cod_leyes"];
				else
					$Datos='';	
				//echo "<input type='hidden' name='TxtValores' value='".$Datos."'>";
				if (($Recargo=='')||(is_null($Recargo)))
					echo "<td class='Detalle01' align='center'>".$SA."</td>";
				else
					echo "<td class='Detalle01' align='center'>".$SA."-".$Recargo."</td>";	
				echo "<td class='Detalle02'align='center'>".$Fila["id_muestra"]."</td>";
				echo "<td align='center'>".$Fila["nomley"]."</td>";
				if($Fila["valor"]==''||$Fila["virt"]=='S')
					echo "<td align='center'><input type='textbox' name='TxtValor' size='15' class='InputCen' value='".number_format($Fila["valor"],$ArrParamLeyes[$Fila["cod_leyes"]][2],',','')."'><input type='hidden' name='TxtValores' value='".$Datos."'></td>";
				else
					echo "<td align='center'><input type='textbox' name='TxtValor' size='15' class='InputCen' value='".number_format($Fila["valor"],$ArrParamLeyes[$Fila["cod_leyes"]][2],',','')."' readonly><input type='hidden' name='TxtValores' value='".$Datos."'></td>";
				echo "<td align='center'>".$Fila["abreviatura"]."</td>";
				echo "<td align='center'>".$Fila["virt"]."</td>";
				echo "</tr>";
			}
		}  
		?>
        </table>
   </td>
  </tr>
</table>
  </form>
</body>
</html>