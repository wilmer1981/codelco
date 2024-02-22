<?php
  include("../principal/conectar_principal.php");
  $Fecha_Hora = date("d/m/Y");
  $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<script language="JavaScript">
function Recarga()
{
 	var Frm=document.FrmBuscarSolicitud;
     Frm.action= "cal_buscar_plantilla_solicitud.php";
	 Frm.submit();
}
function ValidaIngreso(Sol_Aut)
{
	var Frm=document.FrmBuscarSolicitud;
    
	if(Frm.CmbProductos.value=='-1')
	{
		alert('Debe Seleccionar Producto');
		Frm.CmbProductos.focus();
		return;
	}
	Frm.action= "cal_buscar_plantilla_solicitud.php?Buscar=S&Sol_Aut="+Sol_Aut;
	Frm.submit();

}		
function RecuperarSeleccion(ValorProducto,ValorSubProducto)
{
	var Frm=document.FrmBuscarSolicitud;
	var Fecha = "";
	for (i=4;i<=Frm.elements.length;i++)
	{
		if (Frm.elements[i].checked == true)
		{
			Fecha=Frm.elements[i].value;
			break;
		}
	}
	window.opener.document.FrmSolicitud.action="cal_generacion_plantillas_solicitudes.php?FechaBusqueda=" + Fecha + "&Productos=" + ValorProducto + "&SubProducto=" + ValorSubProducto +"&Modificar=S";
	window.opener.document.FrmSolicitud.submit();
	window.close();
	 
}
</script>
<title>Buscar Solicitudes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body background="../principal/imagenes/fondo3.gif">

<form action="" method="post" name="FrmBuscarSolicitud" id="FrmBuscarSolicitud">
  <table width="690" border="0" cellpadding="5" class="tablaprincipal">
    <tr> 
      <td>
		<table width="690" border="1" cellpadding="1"  cellspacing="0" class="TablaInterior" >
          <tr> 
            <td width="86" height="30">Producto</td>
            <td width="576">
			<select name='CmbProductos' style='width:250' onChange=Recarga();>
			<?php
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos==$Fila["cod_producto"])
						echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					else
						echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}
			?></select>
		  	</td>
		  </tr>
		  <tr>
            <td width="86" height="30">SubProducto</td>
            <td width="576">
			<select name='CmbSubProducto' style='width:250'>
			<?php
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta="select cod_subproducto,descripcion,flujos from subproducto where cod_producto = '".$CmbProductos."'"; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					else
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}
			?>
			</select>&nbsp;&nbsp;
			<input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar" onClick="ValidaIngreso('<?php echo $Sol_Aut;?>');">
			</td>
		  </tr>		
        </table><br>
        <table width="750" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="20">&nbsp;</td>
            <td width="149"><div align="center"><strong>Fecha-Hora</strong></div></td>
            <td width="142"><div align="center"><strong>Nom.Plantilla</strong></div></td>
			<td width="142"><div align="center"><strong>Producto</strong></div></td>
            <td width="142"><div align="center"><strong>SubProducto</strong></div></td>
            <td width="204"><div align="center"><strong>Id-Muestras</strong></div></td>
          </tr>
          <?php
		if (isset($Buscar))
		{
			include ("../Principal/conectar_cal_web.php");	   
			//$Fecha_I_Dia = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
			//$Fecha_T_Dia = $CmbAno."-".$CmbMes."-".$CmbDias.' 23:59';
			$Consulta = "select t1.fecha_hora,t1.cod_producto,t1.cod_subproducto,";
			$Consulta = $Consulta." t2.abreviatura as nombreproducto,t3.abreviatura as nombresubproducto,t1.descripcion  from plantilla_solicitud_analisis t1 inner join";
			$Consulta = $Consulta." proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto inner join ";
			$Consulta = $Consulta." proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto";
			//$Consulta = $Consulta." where (t1.fecha_hora between '".$Fecha_I_Dia."' and '".$Fecha_T_Dia."')  group by t1.fecha_hora,t1.cod_producto,t1.cod_subproducto ";
			$Consulta = $Consulta." where t1.cod_producto='".$CmbProductos."' ";	
			if(isset($CmbSubProducto)&&$CmbSubProducto!='-1')
				$Consulta = $Consulta." and  t1.cod_subproducto='".$CmbSubProducto."' ";	
			$Consulta = $Consulta." group by t1.fecha_hora,t1.cod_producto,t1.cod_subproducto ";
			//echo $Consulta."<br>";
			echo "<input type='hidden' name='OptSelect'>";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>\n";
				echo "<td><input type='radio' name='OptSelect' value='".$Fila["fecha_hora"]."' onClick=RecuperarSeleccion(".$Fila["cod_producto"].",".$Fila["cod_subproducto"].");></td>\n";
				echo "<td>".$Fila["fecha_hora"]."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["descripcion"]))."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["nombreproducto"]))."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["nombresubproducto"]))."&nbsp;</td>\n";
				$Consulta = "select id_muestra from plantilla_solicitud_analisis where  fecha_hora='".$Fila["fecha_hora"]."' and ";
				$Consulta = $Consulta." cod_producto ='".$Fila["cod_producto"]."' and cod_subproducto ='".$Fila["cod_subproducto"]."' "; 
				$Resultado=mysqli_query($link, $Consulta);
				$StrMuestras = "";
				while ($Fila2=mysqli_fetch_array($Resultado))
				{
					$StrMuestras= $StrMuestras.$Fila2["id_muestra"]." | ";
				}
				echo "<td>".substr($StrMuestras,0,strlen($StrMuestras)-2)."&nbsp;</td>";
				echo "</tr>";
			}		
		}		
	?>
        </table></td>
    </tr>
  </table>
</form>
<br>
<br>
<br>
</body>
</html>
