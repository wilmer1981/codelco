<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =68;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Encontro=false;
	$Encontro1=false;

	$Buscar     = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TxtGuia1   = isset($_REQUEST["TxtGuia1"])?$_REQUEST["TxtGuia1"]:"";
	$TxtGuia2   = isset($_REQUEST["TxtGuia2"])?$_REQUEST["TxtGuia2"]:"";

	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";

	if($TxtGuia1 <> "")
	{
		$Consulta = "select * from sec_web.guia_despacho_emb where num_guia= '".$TxtGuia1."' order by fecha_guia desc ";
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Lote=$Fila["cod_bulto"]." ".$Fila["num_bulto"];
			$IE=$Fila["corr_enm"];
			$FechaGuia=$Fila["fecha_guia"];
			$Encontro=true;
		}
	}
	if($TxtGuia2 <> "")
	{
		$Consulta = "select * from sec_web.guia_despacho_emb where num_guia= '".$TxtGuia2."' order by fecha_guia desc ";
		$Respuesta2 =mysqli_query($link, $Consulta);
		if($Fila2 =mysqli_fetch_array($Respuesta2))
		{
			$Lote2=$Fila2["cod_bulto"]." ".$Fila2["num_bulto"];
			$IE2=$Fila2["corr_enm"];
			$FechaGuia2=$Fila["fecha_guia"];
			$Encontro1=true;
		}
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
	Frm.submit();

}
function Buscar()
{
	var Frm=document.FrmProceso;
		if(Frm.TxtGuia1.value == "")
	{ 
		alert("Ingrese Guia N� 1");
		Frm.TxtGuia1.focus();
		return;
		
	}
	if(Frm.TxtGuia2.value == "")
	{
		alert("Ingrese Guia N� 2");
		Frm.TxtGuia2.focus();
		return;
		
	}	
	if(Frm.TxtGuia1.value == Frm.TxtGuia2.value)
	{
		alert("Ingrese Numeros de Guias Diferentes");
		Frm.TxtGuia1.value="";
		Frm.TxtGuia2.value="";
		Frm.TxtGuia1.focus();
		return;
		
	}
	
	Frm.action="sec_modifica_numguia.php?Buscar=S&TxtGuia1="+Frm.TxtGuia1.value + "&TxtGuia2=" + Frm.TxtGuia2.value;
	Frm.submit();
	
}
function Actualiza()
{
    var Frm=document.FrmProceso;
	Frm.action="sec_modifica_numguia01.php?TxtGuia1=" + Frm.TxtGuia1.value + "&TxtGuia2=" + Frm.TxtGuia2.value;
	Frm.submit();
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="776" align="center" valign="top">
	<table width="490" border="0" class="TablaInterior">
          <tr> 
            <td width="49"><font size="2">&nbsp; </font></td>
            <td width="69"><font size="2">Num Guia 1 </font></td>
            <td width="111"><font size="1"><font size="2"> </font></font><font size="2">
              <input name="TxtGuia1" type="text"  value="<?php echo $TxtGuia1; ?>" size="13" maxlength="10">
              </font></td>
            <td width="71">N&deg; Guia 2 </td>
            <td width="165"><font size="2">
              <input name="TxtGuia2" type="text"  value="<?php echo $TxtGuia2; ?>" size="13" maxlength="10">
</font> </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><div align="center"><font size="2">
                <input name="btnBuscar" type="button" id="btnBuscar3" value="Buscar" onClick="Buscar();">
            <?php
			if($Encontro ==true && $TxtGuia2 <> "")

			{
				if($Mensaje <> 'S')
				{
			?>
			    <input name="BtnActualiza" type="button" id="BtnActualiza" value="Actualiza" onClick="Actualiza();">
             <?php
			 	}
			 }
			 ?>
			    <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
</font></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		<div  style='FILTER: alpha(opacity=100); overflow:auto;   WIDTH: 357px; height:204px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black; left: 25px; top: 142px'>
          <table width="338" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="45"><div align="center">NumGuia</div></td>
            <td width="60">Lote</td>
            <td width="79" align="center"><div align="center">#Paquete</div></td>
            </tr>
         
        
       <?php 

	   if($Encontro == true)
	   {
			$MostrarBtn='N';
			$Consulta = "select  distinct cod_paquete,num_paquete,t2.cod_bulto,t2.num_bulto,t2.corr_enm,t2.num_guia ";
			$Consulta.=" from sec_web.det_guia_despacho_emb t1";
			$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_guia";
			$Consulta.=" where t2.num_guia='".$TxtGuia1."' and t2.fecha_guia='".$FechaGuia."' ";
			$Consulta.=" order by cod_paquete,num_paquete ";
			$Respuesta = mysqli_query($link, $Consulta);

			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";

				echo "<td width='20'>".$Fila["num_guia"]."</td>";
				echo "<td width='60'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
				echo "<td width='79'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."&nbsp;</td>";
					
				echo "</tr>";
			}
		}
 
		?>
        <br>
		
		</table>
		</div>
		
		<div  style='FILTER: alpha(opacity=100); overflow:auto;   WIDTH: 357px; height:204px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black; left: 387px; top: 143px'>
          <table width="338" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 

            <td width="45"><div align="center">NumGuia</div></td>
            <td width="60">Lote</td>
            <td width="79" align="center"><div align="center">#Paquete</div></td>
            </tr>
         
        
       <?php 

	   if($Encontro1 == true)
	   {
			$MostrarBtn='N';
			$Consulta = "select  distinct cod_paquete,num_paquete,t2.cod_bulto,t2.num_bulto,t2.corr_enm,t2.num_guia ";
			$Consulta.=" from sec_web.det_guia_despacho_emb t1";
			$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_guia ";
			$Consulta.=" where t2.num_guia='".$TxtGuia2."' and t2.fecha_guia='".$FechaGuia2."' ";
			$Consulta.=" order by cod_paquete,num_paquete ";
			$Respuesta2 = mysqli_query($link, $Consulta);

			while ($Fila2=mysqli_fetch_array($Respuesta2))
			{
				echo "<tr>";
				echo "<td width='30'>".$Fila2["num_guia"]."</td>";
				echo "<td width='60'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</td>";
				echo "<td width='79'>".$Fila2["cod_paquete"]." ".$Fila2["num_paquete"]."&nbsp;</td>";
					
				echo "</tr>";
			}
		}
		//echo "</table>"; 
		// mysql_close($link);
		?>
        <br>
		
		</table>
		</div>
	  </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php");
 
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if($Mensaje == "S")
		{
				echo "alert('Registro Actualizados Correctamente');";
		}
		echo "</script>"
  ?>
</form>
</body>
</html>
