<?php
include("../principal/conectar_principal.php");
set_time_limit(10000);
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion)
{
	var Frm=document.FrmProceso;
	
	switch (Opcion)
	{
		case "C":
			Frm.action="cal_elimina_EFI_PTF.php?Procesar=S";
			Frm.submit();
			break;
		case "S":
			Frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
			Frm.submit();
			break;
	}
}	
function Salir()
{
	window.close();
}
</script>
<title>PROCESO ELIMINACION MUESTRAS EFI - PTR</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<?php
	if($Procesar=='S')
	{
		//PROCESO ELIMINACION DE LAS EFI
		$consulta1="select t1.nro_solicitud as Nro_Soli";
		$consulta1.=" from cal_web.solicitud_analisis t1";
		$consulta1.=" where t1.nro_solicitud is not null and t1.estado_actual !='16' and t1.id_muestra='EFI' ";
		$consulta1.=" order by t1.nro_solicitud, t1.recargo ";
		//echo $consulta1;
		$Resp1=mysqli_query($link, $consulta1);$Cuenta='1';$CantEliEfi=0;
		while($Row=mysqli_fetch_array($Resp1))
		{
			$EliminaSolicitud_analisis="delete from cal_web.solicitud_analisis where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Solicitud analisis (TABLA):     ".$EliminaSolicitud_analisis."<br>";
			mysqli_query($link, $EliminaSolicitud_analisis);
	
			$EliminaLeyes_por_solicitud="delete from cal_web.leyes_por_solicitud where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Leyes Solicitud (TABLA):     ".$EliminaLeyes_por_solicitud."<br>";
			mysqli_query($link, $EliminaLeyes_por_solicitud);
	
			$EliminaEstados_solicitud="delete from cal_web.estados_por_solicitud where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Estados por Solicitud (TABLA):     ".$EliminaEstados_solicitud."<br>";
			mysqli_query($link, $EliminaEstados_solicitud);
	
			$EliminaRegistro_leyes="delete from cal_web.registro_leyes where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Registro Leyes (TABLA):     ".$EliminaRegistro_leyes."<br>";
			mysqli_query($link, $EliminaRegistro_leyes);
			$CantEliEfi++;
		}
	
		//echo "PROCESO DE ELIMINACIÓN EFI TERMINADO<br>";
	
		//PROCESO ELIMINACION DE LAS PTR
		$consulta1="select t1.nro_solicitud as Nro_Soli";
		$consulta1.=" from cal_web.solicitud_analisis t1";
		$consulta1.=" where t1.nro_solicitud is not null and t1.estado_actual !='16' and t1.id_muestra='PTR' ";
		$consulta1.=" order by t1.nro_solicitud, t1.recargo ";
		//echo $consulta1;
		$Resp1=mysqli_query($link, $consulta1);$Cuenta='1';$CantEliPtr=0;
		while($Row=mysqli_fetch_array($Resp1))
		{
			$EliminaSolicitud_analisis="delete from cal_web.solicitud_analisis where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Solicitud analisis (TABLA):     ".$EliminaSolicitud_analisis."<br>";
			mysqli_query($link, $EliminaSolicitud_analisis);
	
			$EliminaLeyes_por_solicitud="delete from cal_web.leyes_por_solicitud where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Leyes Solicitud (TABLA):     ".$EliminaLeyes_por_solicitud."<br>";
			mysqli_query($link, $EliminaLeyes_por_solicitud);
	
			$EliminaEstados_solicitud="delete from cal_web.estados_por_solicitud where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Estados por Solicitud (TABLA):     ".$EliminaEstados_solicitud."<br>";
			mysqli_query($link, $EliminaEstados_solicitud);
	
			$EliminaRegistro_leyes="delete from cal_web.registro_leyes where nro_solicitud='".$Row[Nro_Soli]."'";
			//echo "Elimina en Registro Leyes (TABLA):     ".$EliminaRegistro_leyes."<br>";
			mysqli_query($link, $EliminaRegistro_leyes);
			$CantEliPtr++;
		}
		
		
		//PROCESO ELIMINACION DE LAS PTR CON SOLICITUD ANALISIS NULA
		$EliminaSolicitud_analisis="delete from cal_web.solicitud_analisis where id_muestra='PTR' and nro_solicitud is null ";
		//echo "Elimina en Solicitud analisis (TABLA):     ".$EliminaSolicitud_analisis."<br>";
		mysqli_query($link, $EliminaSolicitud_analisis);
	
	
		//PROCESO ELIMINACION DE LAS EFI CON SOLICITUD ANALISIS NULA
		$EliminaSolicitud_analisis="delete from cal_web.solicitud_analisis where id_muestra='EFI' and nro_solicitud is null ";
		//echo "Elimina en Solicitud analisis (TABLA):     ".$EliminaSolicitud_analisis."<br>";
		mysqli_query($link, $EliminaSolicitud_analisis);
	}	
?>
<table width="377" height="121" border="1" cellpadding="1" cellspacing="1">
<tr>
<td align="left" class="InputColor">MUESTRAS EFI ELIMINADAS</td>
<td width="136" class="SinBorde"><?php echo number_format($CantEliEfi,0,'','.');?></td>
</tr>
<tr>
  <td align="left" class="InputColor">MUESTRAS PTR ELIMINADAS</td>
  <td class="SinBorde"><?php echo number_format($CantEliPtr,0,'','.');?></td>
</tr>
<tr>
<td colspan="2" align="center" class="Detalle03">
<input type="button" name="Procesar" value="Procesar" style="width:65" onclick="Proceso('C');" />
<input type="button" name="Procesar2" value="Salir" style="width:65" onclick="Proceso('S');" /></td>
</tr>
</table>
<?php
	if($Procesar=='S')
	{
		echo "<script lenguaje='javascript'>";
		echo "alert('PROCESO DE ELIMINACIÓN TERMINADO');";
		echo "</script>";
	}
?>
</form>
</body>
</html>