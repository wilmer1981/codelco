<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=32;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	//COLORES DE LIMITES
?>
<html>
<head>
<title>AGE-Adm. Leyes Lotes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Graba(SA,ID,Recargo)
{
	var f=document.frmPrincipal;
	if(f.VHumedad.value=='')
	{
		alert('Debe Ingresar Humedad')
		f.VHumedad.focus();
		return;
	}	
	if(f.VHumedad.value==0)
	{
		alert('Humedad debe ser mayor a 0')
		f.VHumedad.focus();
		return;
	}		
	var mensaje=confirm('¿Está seguro de ingresar Humedad a Recargo?')
	if(mensaje==true)
	{		
		f.action="age_adm_ing_humedad_popup01.php?SA="+SA+"&Lote="+ID+"&Recargo="+Recargo+"&VHumedad="+f.VHumedad.value
		f.submit();
	}
}
function SoloNumeros(PermiteDecimales,f) 
{ 
	var teclaCodigo = event.keyCode; 
	
	//alert(event.keyCode);
	if (PermiteDecimales==true)
	{
		if(teclaCodigo==110)
		{
			
		   event.keyCode=46;
		   f.value=f.value+",";
		}
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}
	else
	{
		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
	}	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-size: 10píxele;
}
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<?php
if($EsPopup=='S')
	$Fondo="background='../principal/imagenes/fondo3.gif'";
else
	$Fondo="";	
?>
<body <?php echo $Fondo;?>>
<form name="frmPrincipal" action="" method="post">
<?php
if($EsPopup!='S')
{
	//include("../principal/encabezado.php");
	echo "<table class='TablaPrincipal' width='530'>";
	echo "<tr>";
	echo "<td width='530' height='95' align='center' valign='top'>";
}	
?>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="6"><strong>INGRESO HUMEDAD PARA LOTES EXTERNOS CARGADOS DESDE EXCEL. </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="70" class="Colum01">Solicitud</td>
    <td width="138" class="Colum01">
    <?php
		echo $SA;
	?>
    <td width="32" align="left" class="Colum01">Lote</td>
    <td width="133" class="Colum01"><?php echo $IDMuestra;?></td>
    <td width="47" class="Colum01">Recargo</td>
    <td width="291" class="Colum01"><?php echo $Recargo;?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Humedad</td>
    <td colspan="5" class="Colum01"><label>
      <input name="VHumedad" type="text" size="10" maxlength="5" onKeyDown="SoloNumeros(true,this)">
    </label>&nbsp;%</td>
    </tr>
  <tr align="center" class="Detalle01">
  	  <td height="30" colspan="6" class="Colum01">
		<!--<input name="BtnCertLeyes" type="button" value="Certificado de Leyes" style="width:140px " onClick="Proceso('CL')">-->
	  <input name="BtnImprimir" type="button" value="Grabar" style="width:70px " onClick="Graba('<?php echo $SA?>','<?php echo $IDMuestra?>','<?php echo $Recargo?>')"></td>
    </tr>
  </table>
  <?php
	if($MuestraLote=='S')
	{
		echo "<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>";
		echo "<tr align='center'><td>";
        echo "<table width='730' border='1' align='center' cellpadding='2' cellspacing='0'>";
		echo "<tr align='center' class='ColorTabla02'>";
		echo "<td>F.Recep.</td>";
		echo "<td>Solicitud</td>";
		echo "<td>Estado</td>";
		echo "<td>Retalla</td>";
		echo "<td>Estado</td>";
		echo "<td>Paralela</td>";
		echo "<td>Estado</td>";
		echo "</tr>";
		//SOLICITUD DEL LOTE
		$Consulta = "select distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' and t2.estado_actual not in ('7','16')";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='') ";	
 		 //echo $consulta;
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA=$FilaAux["nro_solicitud"];
			$Recargo=$FilaAux["recargo"];
			$EstadoSA=$FilaAux["nombre_subclase"];
			$CodEstadoSA=$FilaAux["estado_actual"];
		}
		else
		{
			$SA="";
			$Recargo="";
			$EstadoSA="";
			$CodEstadoSA="";
		}
		//RETALLA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' ";			
		$Consulta.= " and t2.recargo='R' ";	
  		//echo $Consulta;
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Retalla=$FilaAux["nro_solicitud"];
			$EstadoRetalla=$FilaAux["nombre_subclase"];
			$CodEstadoRetalla=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Retalla="";
			$EstadoRetalla="";
			$CodEstadoRetalla="";
		}
		//MUESTRA PARALELA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.muestra_paralela=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$TxtLote."' ";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='' or isnull(t2.recargo)) ";
 		 //echo $Consulta;
		$Consulta.= " and year(t2.fecha_muestra)='".substr($FechaRecepcion,0,4)."'";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Paralela=$FilaAux["nro_solicitud"];
			$EstadoParalela=$FilaAux["nombre_subclase"];
			$CodEstadoParalela=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Paralela="";
			$EstadoParalela="";
			$CodEstadoParalela="";
		}
		echo "<tr align=\"center\">\n";
		echo "<td>".substr($FechaRecepcion,8,2)."/".substr($FechaRecepcion,5,2)."/".substr($FechaRecepcion,0,4)."</td>\n";
		if 	($SA=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($SA!="")
				echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$SA."</a></td>\n";
		}			
		if ($CodEstadoSA!=6 && $EstadoSA!="")
			echo "<td bgcolor='yellow'>".$EstadoSA."&nbsp;</td>\n";
		else
		{
			if ($EstadoSA!="")
				echo "<td bgcolor='#FFFFFF'>".$EstadoSA."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		if 	($SA_Retalla=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td><a href=\"JavaScript:Historial('".$SA_Retalla."','R')\" class=\"LinksAzul\">".$SA_Retalla."</a></td>\n";
		if ($CodEstadoRetalla!=6 && $EstadoRetalla!="")
			echo "<td bgcolor='yellow'>".$EstadoRetalla."&nbsp;</td>\n";
		else
			echo "<td>".$EstadoRetalla."&nbsp;</td>\n";
		if 	($SA_Paralela=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td><a href=\"JavaScript:Historial('".$SA_Paralela."','0')\" class=\"LinksAzul\">".$SA_Paralela."</a></td>\n";
		if ($CodEstadoParalela!=6 && $EstadoParalela!="")
			echo "<td bgcolor='yellow'>".$EstadoParalela."&nbsp;</td>\n";
		else
			echo "<td>".$EstadoParalela."&nbsp;</td>\n";
		echo "</tr>\n";
		echo "</table>";
		
		echo "</td></tr>";
		echo "</table>";
	}	
  ?>
  <br>
	<?php
	if($MuestraLote=='S')
	{
		if($Mostrar=='S')
		{
			echo "<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>";
			echo "<tr align='center'>";
			switch($Petalo)		  
			{
				case "H":
					echo "<td><a href=JavaScript:Proceso('P','R');>Recargos</a></td>";
					echo "<td><a href=JavaScript:Proceso('P','H');><strong>Leyes Humedad</strong></a></td>";
					echo "<td><a href=JavaScript:Proceso('P','L');>Leyes</a></td>";
					break;
				case "L":
					echo "<td><a href=JavaScript:Proceso('P','R');>Recargos</a></td>";
					echo "<td><a href=JavaScript:Proceso('P','H');>Leyes Humedad</a></td>";
	
					echo "<td><a href=JavaScript:Proceso('P','L');><strong>Leyes</strong></a></td>";
	
					break;
				default:
					echo "<td><a href=JavaScript:Proceso('P','R');><strong>Recargos</strong></a></td>";
					echo "<td><a href=JavaScript:Proceso('P','H');>Leyes Humedad</a></td>";
					echo "<td><a href=JavaScript:Proceso('P','L');>Leyes</a></td>";
					break;
			}		
			echo "</tr>";
			echo "<tr><td colspan='3'>";
			//echo "pppppppppppp".$Petalo;
			switch($Petalo)		  
			{
				case "H"://LEY HUMEDAD
					include("age_adm_ing_humedad_proceso.php");
					break;
				case "L"://LEYES
					include("age_adm_cierre_lote_leyes.php");
					break;
				default://RECARGOS
					include("age_adm_cierre_lote_recargos.php");
					break;
			}  
			echo "</td></tr>";
			echo "</table><br>";
		}	
	}
if($EsPopup!='S')
{ 
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	//include("../principal/pie_pagina.php"); 
}	
?>
</form>
</body>
</html>
