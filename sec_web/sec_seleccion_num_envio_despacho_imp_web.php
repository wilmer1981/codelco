<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 17;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if (!isset($Envio))
	{
		$Envio='N';
	}
	if (!isset($CmbDias))
	{
		$CmbDias=date('d');
	}
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
?>
<html>
<head>
<script language="JavaScript">
function Recarga()
{
	var Frm=document.FrmConfEnvio;
	var Envio="";
	
	if (Frm.OpcEnvio[0].checked)
	{
		Envio="N";
	}
	if (Frm.OpcEnvio[1].checked)
	{
		Envio="S";
	}
	Frm.action="sec_seleccion_num_envio_despacho_imp_web.php?Envio="+Envio;
	Frm.submit();
	
}

function Imprimir(opt)
{
	var f=document.FrmConfEnvio;
	f.BtnImprimir.style.visibility = "hidden";
	f.BtnSalir.style.visibility = "hidden";
	window.print();
	f.BtnImprimir.style.visibility = "visible";
	f.BtnSalir.style.visibility = "visible";
}
</script>
<title>Confirmacion - ENAMI</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}
-->
</style><body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConfEnvio" method="post" action="" target="_parent">  
<table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td align="center"><strong> SELECCION DE NUMERO DE ENVIO PARA DESPACHO
              ENAMI</strong></td>
        </tr>
      </table><br>
	  <table width="650" border="0" align="center">
	  <tr>
	  <?php
			switch ($Envio)
			{
				case "N":
					echo "<td>Sin Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()' checked>&nbsp;";
					echo "<select name='CmbDias' onchange='Recarga()'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDias))
						{
							if ($i==$CmbDias)
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
					echo"</select>";
					echo"<select name='CmbMes' onchange='Recarga()'>";
					for($i=1;$i<13;$i++)
					{
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
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
					echo "<select name='CmbAno' onchange='Recarga()'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
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
					echo "</select></td>";
					echo "<td>Con Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()'><td>";								
					break;
				case "S":
					echo "<td>Sin Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()'></td>";		
					echo "<td>Con Envio<input type='radio' name='OpcEnvio' value='' onclick='Recarga()' checked>&nbsp;&nbsp;";	
					echo"<select name='CmbMes' onchange='Recarga()'>";
					for($i=1;$i<13;$i++)
					{
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
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
					echo "<select name='CmbAno' onchange='Recarga()'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
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
					echo "</select>&nbsp;";
					//echo "<input type='button' name='BtnFax' value='Generar Fax' style='width:90' onClick='GenerarFax();'></td>";			
					break;
			}
	  ?>
	  </tr>
	  </table>	  
	  <br>
	  <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
		  <?php
			switch ($Envio)
			{
				case "N":
					echo "<td width='120' align='center'>Fecha Programa</td>";
					echo "<td width='70' align='center'>Cod.Nave</td>";
					echo "<td width='200' align='center'>Nave/Cliente</td>";
					echo "<td width='70' align='center'>Cod.Puerto</td>";
					echo "<td width='200' align='center'>Puerto</td>";
					break;
				case "S":
					echo "<td width='30' align='center'>Envio</td>";
					echo "<td width='80' align='center'>SubProducto</td>";
					echo "<td width='80' align='center'>Fecha Prog</td>";
					echo "<td width='30' align='center'>Cod.Nave</td>";
					echo "<td width='200' align='center'>Nave/Cliente</td>";
					echo "<td width='30' align='center'>Cod.Puerto</td>";
					echo "<td width='200' align='center'>Puerto</td>";
					break;
			}		
		  ?>	
          </tr>
		<?php			
			switch ($Envio)
			{
				case "N":
					if (strlen($CmbDias)==1)
					{
						$CmbDias="0".$CmbDias;
					}
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					$Fecha_Envio=$CmbAno."-".$CmbMes."-".$CmbDias;
					$Consulta="select t1.cod_servicio,t1.cod_prestador_servicio as ag_aduanero,t1.cod_prestador_servicio2 as ag_estiva,t1.eta_programada,t1.cod_nave,t1.cod_puerto,t4.nom_aero_puerto as pto_puerto,t5.nombre_nave,t1.fecha_disponible";
					$Consulta=$Consulta." from sec_web.programa_enami t1";
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_nave=t5.cod_nave ";
					$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2='T' and t1.estado1='R' and t1.eta_programada ='$Fecha_Envio' group by t1.eta_programada,t1.cod_nave order by t1.eta_programada";
					$Respuesta=mysqli_query($link, $Consulta);
					break;
				case "S":
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					$Fecha_Envio=$CmbAno."-".$CmbMes;
					$Consulta="select t3.abreviatura as subproducto,t1.cod_servicio,t1.cod_prestador_servicio as ag_aduanero,t1.cod_prestador_servicio2 as ag_estiva,t1.eta_programada,t1.cod_nave,t1.cod_puerto,t4.nom_aero_puerto as pto_puerto,t5.nombre_nave,t1.fecha_disponible,t2.num_envio,t2.fecha_envio";
					$Consulta=$Consulta." from sec_web.programa_enami t1 inner join sec_web.embarque_ventana t2 on t1.corr_enm=t2.corr_enm";
					$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";					
					$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto ";
					$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_nave=t5.cod_nave ";
					$Consulta=$Consulta." where t1.tipo <> 'V' and t1.estado2='C' and t1.estado1='R'  and substring(t2.fecha_envio,1,7) ='$Fecha_Envio'  group by t2.num_envio,t1.eta_programada,t1.cod_nave order by t2.num_envio desc";
					$Respuesta=mysqli_query($link, $Consulta);
					break;
			}		
			echo "<input type='hidden' name='OptSeleccionar'>";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				switch ($Envio)
				{
					case "N":						
						echo "<td align='center'>".substr($Fila["eta_programada"],8,2)."/".substr($Fila["eta_programada"],5,2)."/".substr($Fila["eta_programada"],0,4)."&nbsp;</td>";
						echo "<td align='center'>".$Fila["cod_nave"]."&nbsp;</td>";
						echo "<td align='left'>".$Fila["nombre_nave"]."&nbsp;</td>";
						echo "<td align='center'>".$Fila["cod_puerto"]."&nbsp;</td>";
						echo "<td align='left'>".$Fila[pto_puerto]."&nbsp;</td>";
						break;
					case "S":
						$TipoEmb='';
						$IE='';
						$Consulta="select cod_bulto,num_bulto,corr_enm,tipo_embarque from sec_web.embarque_ventana where num_envio=".$Fila["num_envio"]." and fecha_envio='".$Fila[fecha_envio]."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						while ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Consulta="select sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
							$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
							$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
							$Consulta=$Consulta." where t1.corr_enm=".$Fila2["corr_enm"]." group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
							$Respuesta3=mysqli_query($link, $Consulta);
							$Fila3=mysqli_fetch_array($Respuesta3);						
							$IE=$IE.$Fila2["corr_enm"]."(".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"].") Peso:".$Fila3["peso_preparado"]." - ";
							$TipoEmb=$Fila2["tipo_embarque"];
						}
						$IE=substr($IE,0,strlen($IE)-3);
						$Cont2++;
						switch ($TipoEmb)
						{
							case "T":
								$TipoEmb="Terrestre";
								break;
							case "A":
								$TipoEmb="Acopio";
								break;
							case "E":
								$TipoEmb="Estiba";
								break;						
							default:
								$TipoEmb="Ninguno";
						}						
						echo "<td align='center'>".$Fila["num_envio"]."&nbsp;</td>";
						echo "<td align='left'>".$Fila["subproducto"]."&nbsp;</td>";
						echo "<td align='center'>".substr($Fila["eta_programada"],8,2)."/".substr($Fila["eta_programada"],5,2)."/".substr($Fila["eta_programada"],0,4)."&nbsp;</td>";
						echo "<td align='center'>".$Fila["cod_nave"]."&nbsp;</td>";
						echo "<td align='left'>".$Fila["nombre_nave"]."&nbsp;</td>";
						echo "<td align='center'>".$Fila["cod_puerto"]."&nbsp;</td>";
						echo "<td align='left'>".$Fila[pto_puerto]."&nbsp;</td>";
						break;
				}
				echo "</tr>";
			}
			echo "</table>";	
		?>		
        <br>		<br>
          <table width="650" border="0" align="center">
          <tr>
              <td align="center"> 
				<input name="BtnImprimir" type="button" style="width:90" onClick="Imprimir('W');" value="Imprimir">
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="JavaScript:window.close()">
</td>
          </tr>
  </table>
</form>
</body>
</html>