<?php
	include("../principal/conectar_rec_web.php");
?>
<html>
<head>
<script language="JavaScript">
function RecuperarSeleccion(ValorProducto,ValorSubProducto,FechaHora,NombrePlantillaSA)
{
	var Frm=document.FrmPlantillaSA;
	var Fecha = "";
	for (i=0;i<=Frm.elements.length;i++)
	{
		if (Frm.elements[i].checked == true)
		{
			Fecha=Frm.elements[i].value;
			break;
		}
	}
	Frm.action = "cal_solicitud_rutinaria01.php?proceso=N&FechaHora="+FechaHora+"&FechaTraspaso="+Fecha+"&CmbProductos="+ValorProducto+"&CmbSubProducto="+ValorSubProducto+"&NombrePlantillaSA="+NombrePlantillaSA;
	Frm.submit();	
}
</script>
<title>Plantillas Solicitudes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPlantillaSA" method="post" action="">
  <table width="700" border="0">
    <tr>
      <td>
		<?php
			echo "<table width='700' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>";
			echo "<td width='30'>&nbsp;</td>";
			echo "<td width='250'>Plantilla";
			echo "</td>";
			echo "<td width='170'>Periodo";
			echo "</td>";
			echo "<td width='250'>ID. Muestra";
			echo "</td>";
			echo "</tr>";
			$Consulta="select fecha_hora,cod_periodo,descripcion from cal_web.plantilla_solicitud_analisis ";
			$Consulta=$Consulta." where not isnull(descripcion) and not isnull(cod_periodo) and cod_producto=".$CmbProductos." and cod_subproducto=".$CmbSubProducto." group by fecha_hora";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Consulta="select id_muestra from cal_web.plantilla_solicitud_analisis ";
				$Consulta=$Consulta." where cod_producto=".$CmbProductos." and cod_subproducto=".$CmbSubProducto." and fecha_hora='".$Fila["fecha_hora"]."'";
				$Resultado2=mysqli_query($link, $Consulta);
				while ($Fila2=mysqli_fetch_array($Resultado2))
				{
					$Muestras=$Muestras.$Fila2["id_muestra"]."/";				
				}
				$Consulta="select nombre_subclase as periodo from proyecto_modernizacion.sub_clase";
				$Consulta=$Consulta." where cod_clase=2 and cod_subclase =".$Fila[cod_periodo];
				$Resultado3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Resultado3);
				echo "<tr>";
				echo "<td width='30'><input type='radio' name='OptPlantilla' value='".$Fila["fecha_hora"]."' onClick=\"RecuperarSeleccion('$CmbProductos','$CmbSubProducto','$FechaHora','$Fila["descripcion"]');\"></td>";
				echo "<td width='250'>".$Fila["descripcion"]."</td>";
				echo "<td width='170'>".$Fila3[periodo]."</td>";
				echo "<td width='250'>".$Muestras."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>	  
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
