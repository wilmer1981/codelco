<?php 
	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni =  0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin =  50;
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT =  date("m");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes =  date("m");
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}

/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;*/

	$CodigoDeSistema = 1;
	$CodigoDePantalla = 53;
	include("../principal/conectar_principal.php");
	$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase=1006 and cod_subclase=1";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$DiasConsulta=$Fila["valor_subclase1"];
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opcion)
{
	var Frm=document.FrmConsultaSAPendientes;

	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	
	/*CantDiasI=365*parseInt(Frm.CmbAno.value);
	TotalDiasI=parseInt(CantDiasI)+(31*parseInt(Frm.CmbMes.value))+parseInt(Frm.CmbDias.value);
	CantDiasT=365*parseInt(Frm.CmbAnoT.value);
	TotalDiasT=CantDiasT+(31*parseInt(Frm.CmbMesT.value))+parseInt(Frm.CmbDiasT.value);
	DifDias=TotalDiasT-TotalDiasI;
	if (TotalDiasI>TotalDiasT)
	{
		alert("Fecha Inicio Debe ser menor o igual a Fecha Termino")
		return;	
	}
	if (DifDias > 31)
	{
		alert("Rango de busqueda debe entre 1 y 31 dias")
		return;
	}
	if (Frm.CmbAnoT.value==Frm.CmbAno.value)
	{
		if ((Frm.CmbMesT.value-Frm.CmbMes.value)>1)
		{
			alert("El rango de fecha debe ser menor o igual a 2 meses");
		}
	}*/
	switch (Opcion)
	{
		case "R"://RECARGA
			Frm.action= "cal_con_sa_pendientes.php?Buscar=S";
			Frm.submit();
			break;
		case "E"://EXCEL
			Frm.action= "cal_xls_sa_pendientes.php?Buscar=S&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT+"&CmbDiasT="+Frm.CmbDiasT;
			Frm.submit();
			break;
	}			
}
function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function Imprimir()
{
	window.print();
}
function Recarga(LimitIni,CmbAno,CmbMes,CmbDias)
{
	var frm=document.FrmConsultaSAPendientes;
	frm.action="cal_con_sa_pendientes.php?Buscar=S&LimitIni="+LimitIni+"&CmbAnoT="+CmbAno+"&CmbMesT="+CmbMes+"&CmbDiasT="+CmbDias;
	frm.submit(); 
}
function Salir()
{ 
	var Frm=document.FrmConsultaSAPendientes;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}

</script>
<title>Consulta Solicitudes Pendientes</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaSAPendientes" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="761" align="center" valign="middle"> <br>
	  <table width="755" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> 
              <?php
					echo "<strong>Fecha Consulta</strong>&nbsp;";
					echo "<select name='CmbDiasT'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDiasT))
						{
							if ($i==$CmbDiasT)
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}
						else
						{
							if ($i==date("j"))
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}	
					}
				  echo "</select>";
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
				   echo "</select>";
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
				  echo "</select>";
				?>&nbsp;&nbsp;&nbsp;
				<input name="BtnConsulta" type="button" value="Consultar" style="width:90" onClick="Proceso('R');">
              <!--&nbsp; <input name="BtnExcel" type="button" value="Excel" style="width:90" onClick="Proceso('E');">-->
              <input name="BtnImprimir" type="button" value="Imprimir" style="width:90" onClick="Imprimir();">
              <input name="BtnSalir" type="button" value="Salir" style="width:90" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
		<?php
			if ($Buscar=='S')
			{
				if (($CmbAnoT=="") || ($CmbMesT=="")|| ($CmbDiasT==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					if (strlen($CmbMesT)==1)
					{
						$CmbMesT="0".$CmbMesT;
					}
					if (strlen($CmbDiasT)==1)
					{
						$CmbDiasT="0".$CmbDiasT;
					}
					$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}
				$FechaTope=date( "Y-m-d", mktime(0,0,0,substr($FechaT,5,2),substr($FechaT,8,2)-$DiasConsulta,substr($FechaT,0,4)));
				$FechaTope=$FechaTope." 23:59:59";
				$FechaInicio=date( "Y-m-d", mktime(0,0,0,substr($FechaT,5,2),substr($FechaT,8,2)-60,substr($FechaT,0,4)));
				$FechaInicio=$FechaInicio." 00:00:00";
				$Consulta = "select distinct t3.cod_leyes,t4.abreviatura  from cal_web.solicitud_analisis t1 ";
				$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
				$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo  inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
				$Consulta = $Consulta." where not isnull(t1.nro_solicitud) and t1.fecha_hora between '".$FechaInicio."' and '".$FechaTope."' and t1.estado_actual<>'6' and t1.estado_actual <> '7' and t1.estado_actual<>'16' and t1.estado_actual<>'32' order by t3.cod_leyes";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Arreglo=array();
				$AnchoTabla=0;
				while($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Arreglo[$Fila1["cod_leyes"]][0]=$Fila1["abreviatura"];
					$Arreglo[$Fila1["cod_leyes"]][1]=$Fila1["cod_leyes"];
					$Arreglo[$Fila1["cod_leyes"]][2]=$Fila1["cod_leyes"];
					$AnchoTabla=$AnchoTabla	+ 50;		
				}
				$AnchoTabla=$AnchoTabla	+ 1000;
				echo "<table width=$AnchoTabla' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>";
				echo "<tr class='ColorTabla01'>";
				if (count($Arreglo)>0)
				{
					echo "<td width='90' align='center'>S.A</td>";
					echo "<td width='80' align='center'>Id.Muestra</td>";
					echo "<td width='120' align='center'>Fecha Creacion</td>";
					//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
					reset($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach($Arreglo as $Clave => $Valor)
					{
						echo "<td width='50'>";
						echo $Valor[0];
						echo "</td>";
					}
					echo "<td width='60' align='center'>Agrup.</td>";
					echo "<td width='130' align='center'>Fecha Muestra</td>";
					echo "<td width='60' align='center'>Producto</td>";
					echo "<td width='60' align='center'>SubProducto</td>";
					echo"</tr>";
					$Consulta = " select distinct t1.nro_solicitud,t1.recargo from cal_web.solicitud_analisis t1 ";
					$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
					$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo  inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
					$Consulta = $Consulta." where not isnull(t1.nro_solicitud) and t1.fecha_hora between '".$FechaInicio."' and '".$FechaTope."' and t1.estado_actual<>'6' and t1.estado_actual <> '7' and t1.estado_actual<>'16' and t1.estado_actual<>'32' order by t1.nro_solicitud LIMIT ".$LimitIni.", ".$LimitFin;
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>";
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
						{
							$Recargo='N';
							echo "<td width='110' align='rigth'><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Recargo."')\">".$Fila["nro_solicitud"]."</a></td>";
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"];
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td width='80' align='left'>".$FilaDatos["id_muestra"]."</td>";
							echo "<td width='120' align='left'>".substr($FilaDatos["fecha_hora"],0,10)."</td>";							
						}
						else
						{
							echo "<td width='110' align='rigth'><a href=\"javascript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."')\">".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</a></td>";								
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							echo "<td width='60' align='left'>".$FilaDatos["id_muestra"]."</td>";
							echo "<td width='120' align='left'>".substr($FilaDatos["fecha_hora"],0,10)."</td>";																							
						}
						reset($Arreglo);
						//while(list($Clave,$Valor)=each($Arreglo))
						foreach($Arreglo as $Clave => $Valor)
						{
							$Consulta="select * from cal_web.leyes_por_solicitud t1"; 
							$Consulta.=" inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
							$Consulta.=" where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.cod_leyes='".$Valor[2]."'	";
							if (!is_null($Fila["recargo"]) || ($Fila["recargo"] != "")|| ($Fila["recargo"] != " "))
							{
								$Consulta.= " and t1.recargo = '".$Fila["recargo"]."'";
							}
							$Respuesta1=mysqli_query($link, $Consulta);
							if ($FilaDatos2 = mysqli_fetch_array($Respuesta1))
							{
								if ($FilaDatos2["candado"]=='1')
								{
									echo "<td width='70'><font color='green'>".number_format($FilaDatos2["valor"],2).$FilaDatos2["abreviatura"]."</font></td>\n";
								}
								else
								{
									echo "<td width='70'>".number_format($FilaDatos2["valor"],2).$FilaDatos2["abreviatura"]."</td>\n";
								}	
							}
							else
							{
								echo "<td width='70' align='center'><img src='../principal/imagenes/ico_x.gif'></td>\n";
							
							}
						}
						echo "<td width='60' align='left'>".$FilaDatos["nombre_subclase"]."</td>";							
						echo "<td width='130' align='center'>".$FilaDatos["fecha_muestra"]."</td>";
						echo "<td width='60' align='left'>".$FilaDatos["producto"]."</td>";
						echo "<td width='60' align='left'>".$FilaDatos["subproducto"]."</td>";
						echo "</tr>";
					}
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "</tr>";
				}
				echo "</table>";
			}	
			?>
        <table width="755" border="0" cellpadding="3" cellspacing="0"><!-- class="TablaInterior">-->
          <tr>
            <td align="center">
			<?php
				if ($Buscar=='S')
				{
					$Consulta="select count(distinct t1.nro_solicitud,t1.recargo) as total_registros from cal_web.solicitud_analisis t1";
					$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
					$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo  inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
					$Consulta = $Consulta." where not isnull(t1.nro_solicitud) and t1.fecha_hora between '".$FechaInicio."' and '".$FechaTope."' and t1.estado_actual<>'6' and t1.estado_actual <> '7' and t1.estado_actual<>'16' and t1.estado_actual<>'32'";
					$Respuesta = mysqli_query($link, $Consulta);
					$Row = mysqli_fetch_array($Respuesta);
					$Coincidencias = $Row["total_registros"];
					$NumPaginas = ($Coincidencias / $LimitFin);
					$LimitFinAnt = $LimitIni;
					$StrPaginas = "";
					for ($i = 0; $i <= $NumPaginas; $i++)
					{
						$LimitIni = ($i * $LimitFin);
						if ($LimitIni == $LimitFinAnt)
						{
							$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
						}
						else
						{
							$LimiteInicial=$i * $LimitFin;
							$Param="$LimiteInicial,'$CmbAnoT','$CmbMesT','$CmbDiasT'";
							$Param=str_replace(" ","%20",$Param);
							$StrPaginas.=  "<a href=JavaScript:Recarga($Param);>";
							$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
						}
					}
					echo substr($StrPaginas,0,-15);
				}	
			?>	
		   </td>
		  </tr>
        </table><br>
			
		<br>
        <br>
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
