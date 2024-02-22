<?php 	
	include("../principal/conectar_principal.php");
	$Datos=explode('//',$Valores);
	$IE=$Datos[0];
	$Consulta="SELECT * from sec_web.programa_loteo where num_prog_loteo=".$IE;	
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$A�o=substr($Fila["fecha_hora"],0,4);
	$Fecha=$Fila["fecha_hora"];		
?>
<html>
<head>
<script language="JavaScript">
function Imprimir(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	Frm.BtnImprimir.style.visibility='hidden'
	Frm.BtnSalir.style.visibility='hidden'
	window.print();	
	Frm.BtnImprimir.style.visibility=''
	Frm.BtnSalir.style.visibility=''
	
}
function Salir()
{
	window.close();
}
</script>
<title>Programas de Loteos Anteriores</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="620" height="10" border="0" cellpadding="5" cellspacing="0">	
  <tr><td></td></tr>
  </table>
  <table width="620" height="320" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
	<tr>
	<TD align="center"><h4><strong>PROGRAMA LOTEO CATODOS N�&nbsp;<?php echo $IE;?>&nbsp;/&nbsp;<?php echo $A�o;?></strong></h4></TD>
	</tr>
    <tr>
    <td>
		  <table width="620" border="0"  cellpadding="3" cellspacing="0" class='tablainterior'>
          <tr> 
            <td>A</td>
			<td>:JEFE PRODUCTOS FINALES</td>
		  </tr>
		  <tr>	
            <td>AT</td>
			<td>:ENCARGADO PREPARACION PRODUCTOS</td>
		  </tr>	
			<td>DE</td>
			<td>:EMBARQUE PRODUCTO</td>
		  <tr>	
			<td>FECHA</td>
			<td>:<?php echo $Fecha;?></td>
          </tr>
        </table>
			<br>          
		  <table width="620" border="0"  cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="ColorTabla01">
          <tr> 
            <td width="100" align="center">PRODUCTO</td>
            <td width="150" align="center">SUBPRODUCTO</td>
			<td width="40" align="center">&nbsp;</td>
			<td width="150" align="center">M/N Y DESTINO</td>
			<td width="80" align="center">E.T.A</td>
			<td width="50" align="center">PESO(T)</td>
			<td width="60" align="center">I.E</td>
          </tr>
        </table>
          <?php
			echo "<table width='620' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$CrearTmp ="create temporary table if not exists sec_web.tmpprograma "; 
			$CrearTmp =$CrearTmp."(corr_ie bigint(8),cliente_nave varchar(30),";
			$CrearTmp =$CrearTmp."cantidad_programada bigint(8),producto varchar(30),";
			$CrearTmp =$CrearTmp."subproducto varchar (30),cod_contrato varchar(10),fecha_disponible date)";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta="SELECT t1.fecha_disponible,t6.descripcion as producto,t2.descripcion as subproducto,";
			$Consulta=$Consulta."(case when not isnull(t6.nombre_nave) then t6.nombre_nave else t5.sigla_cliente end) as nombre_cliente,";
			$Consulta=$Consulta."t1.corr_enm,t1.cantidad_embarque from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t6 on t1.cod_nave=t6.cod_nave ";
			$Consulta=$Consulta." where t1.num_prog_loteo=".$IE;
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,producto,subproducto,cod_contrato,fecha_disponible) values(";
				$Insertar=$Insertar."$Fila["corr_enm"],'$Fila["nombre_cliente"]',$Fila[cantidad_embarque],'$Fila["producto"]','".$Fila["subproducto"]."','','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta="SELECT t1.fecha_disponible,t1.cod_contrato_maquila,(case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada";
			$Consulta=$Consulta." from sec_web.programa_codelco  t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta=$Consulta." left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			$Consulta=$Consulta." where t1.num_prog_loteo=".$IE;
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar="insert into sec_web.tmpprograma (corr_ie,cliente_nave,cantidad_programada,producto,subproducto,cod_contrato,fecha_disponible) values(";
				$Insertar=$Insertar."$Fila["corr_codelco"],'$Fila["nombre_cliente"]',$Fila["cantidad_programada"],'$Fila["producto"]','".$Fila["subproducto"]."','$Fila["cod_contrato_maquila"]','".$Fila["fecha_disponible"]."')";
				mysqli_query($link, $Insertar);   
			}
			$Consulta="SELECT * from sec_web.tmpprograma order by fecha_disponible";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='100' align='left'>".$Fila["producto"]."</td>";
				echo "<td width='150' align='left'>".$Fila["subproducto"]."</td>";
				echo "<td width='60' align='center'>".$Fila["cod_contrato"]."&nbsp;</td>";
				echo "<td width='150' align='left'>".$Fila["cliente_nave"]."</td>";
				echo "<td width='80' align='center'>".$Fila["fecha_disponible"]."</td>";
				echo "<td width='50' align='right'>".$Fila["cantidad_programada"]."</td>";
				echo "<td width='60' align='right'>".$Fila["corr_ie"]."</td>";
				echo "</tr>";
			}
			echo "</table>";	
		?>
        <br>
        <table width="620" border="1" cellpadding="1" cellspacing="0" class='tablainterior'>
          <tr> 
              <td align="center">
			  <input type="button" name="BtnImprimir" value="Imprimir" style="width:60" onClick="Imprimir();">
			  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </td>
          </tr>
        </table>
	</td>
  </tr>
  </table>
  </form>
</body>
</html>
