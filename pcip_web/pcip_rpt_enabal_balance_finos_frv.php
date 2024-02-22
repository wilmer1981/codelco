<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
		
?>
<html>
<head>
<title>Reporte Enabal Balance Finos Frv Ventanas</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCAR
			f.action = "pcip_rpt_enabal_balance_finos_frv.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_enabal_balance_finos_frv_excel.php?Ano='+f.Ano.value+'&Mes='+f.Mes.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_enabal_balance_finos_frv.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=15";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\enabal.png" width="240" height="16"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">	  
  <tr>

    <td width="16%" height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>
  </tr>
  <tr>
    <td height="25" class='formulario2'>Mes</td>
    <td class='formulario2'><select name="Mes" id="Mes">
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
    </select>  
  </tr>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="20%" rowspan="2" align="center"><span class="Estilo9">Productos</span></td>
            <td width="8%" rowspan="2" align="center"><span class="Estilo9">Peso Seco  </span></td>
            <td width="24%" colspan="3" align="center"><span class="Estilo9">Finos</span></td>
            </tr>
          <tr class="TituloTablaVerde">
            <td width="8%" align="center"><span class="Estilo9">Cobre</span></td>
            <td width="8%" align="center"><span class="Estilo9">Plata</span></td>
            <td width="8%" align="center"><span class="Estilo9">Oro</span></td>
            </tr>
			<?
			if($Buscar=='S')
			{
				$Arreglo0=array();
				$Arreglo1=array();
				$ArrDif=array();
				$ContLineas = 1;
				$ClaveAux = "0109000";
				$Peso=0;$Cu=0;$Ag=0;$Au=0;
				$ConsultaAUX.="Select * from pcip_ena_concom,pcip_ena_titulocom where pcip_ena_concom.ano ='".$Ano."' and pcip_ena_concom.mes='".$Mes."' and pcip_ena_titulocom.ano ='".$Ano."' and pcip_ena_titulocom.mes='".$Mes."' and ";
				$ConsultaAUX.="pcip_ena_concom.Clave='".$ClaveAux."' and ";
				$ConsultaAUX.="pcip_ena_titulocom.Clave='".$ClaveAux."'";
				//echo $ConsultaAUX;
				$Resp=mysql_query($ConsultaAUX);
				if($Fila=mysql_fetch_array($Resp))
				{
					$SubTitulo = $Fila("Nombre");
					TitulaConven();
					SubtitulaConven();
					$ConsultaAUX = "Select * from pcip_ena_punteroxconcom where Clave='0109000' ano ='".$Ano."' and mes='".$Mes."' order by NumPuntero";
					$Resp=mysql_query($ConsultaAUX);
					while($Fila=mysql_fetch_array($Resp))
					{
						$Clave = "01".substr($Fila("Puntero"), 0, 5);
						$Signo = substr($Fila("Puntero"), 5, 1);
						$Consulta = "Select * from pcip_ena_concom where Clave='".$Clave."' ano ='".$Ano."' and mes='".$Mes."'";
						$Resp2=mysql_query($Consulta);
						if($Fila2=mysql_fetch_array($Resp2))
						{
							if(trim($Fila2("Nombre")) != "")
							{
								echo "<tr>";
								echo "<td>".$Fila2["Nombre"]."</td>";
								echo "<td>".$Fila2["Seco"]."</td>";
								echo "<td>".$Fila2["Cu"]."</td>";
								echo "<td>".$Fila2["Ag"]."</td>";
								echo "<td>".$Fila2["Au"]."</td>";
								echo "</tr>";
								if($Signo = "+")
								{
									$Peso = $Peso + $Fila2["Seco"];
									$Cu = $Cu + $Fila2["Cu"];
									$Ag = $Ag + $Fila2["Ag"];
									$Au = $Au + $Fila2["Au"];
								}
								else
								{
									$Peso = $Peso -  $Fila2["Seco"];
									$Cu = $Cu -  $Fila2["Cu"];
									$Ag = $Ag -  $Fila2["Ag"];
									$Au = $Au -  $Fila2["Au"];
								}
							}
						}
					}
					echo "<tr>";
					echo "<td>TOTAL ENTRADAS</td>";
					echo "<td>".$Peso."</td>";
					echo "<td>".$Cu."</td>";
					echo "<td>".$Ag."</td>";
					echo "<td>".$Au."</td>";
					echo "</tr>";
				}
				$ContLineas = 60;
				for($I=2;$I<=99;$I++)
				{
					$ClaveSQL = FormateaNro($I,2,"0")."09000";
					$ConsultaSQL = "Select * from pcip_ena_concom,pcip_ena_titulocom where pcip_ena_concom.ano ='".$Ano."' and pcip_ena_concom.mes='".$Mes."' and  pcip_ena_titulocom.ano ='".$Ano."' and pcip_ena_titulocom.mes='".$Mes."' and";
					$ConsultaSQL.=" pcip_ena_concom.Clave='".$ClaveSQL."' and ";
					$ConsultaSQL.= "pcip_ena_titulocom.Clave='".$ClaveSQL."'";
					//if($I==2)
					//	echo $ConsultaSQL."<br>";
					$Resp = mysql_query($ConsultaSQL);
					if($Fila=mysql_fetch_array($Resp))
					{
						//dato encontrado
						$Titulo1 = $Fila["Titulo1"];
						$Titulo2 = $Fila["Titulo2"];
						echo "<tr>";
						echo "<td align='center' colspan='5'><h5>".$Fila["Nombre"]."</h5></td>";
						echo "</tr>";
						$SubTitulo = $Fila["Nombre"];
						$ConsultaSQL = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and NumTotal='".FormateaNro($I,2,"0")."' order by Clave";
						//if($I==2)
						//	echo $ConsultaSQL;
						$Resp2 = mysql_query($ConsultaSQL);
						$ContDif = 0;
						while($Fila2=mysql_fetch_array($Resp2))
						{
							$pos = strpos ($Fila2["Nombre"], "DIFERENC");
							if($pos === false)
								$Nada='';
							else
							{
								$ContDif = $ContDif + 1;
								$ArrDif[$ContDif] = $Fila2["Clave"];
							}
						}
						for($Z=1;$Z<=$ContDif;$Z++)
						{
							$Clave2 = $ArrDif[$Z];
							$Consulta2 = "Select * from pcip_ena_punteroxconcom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave2."' order by NumPuntero";
							$Resp2 = mysql_query($Consulta2);
							$Consulta22 = "Select * from pcip_ena_titulocom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave2."'";
							$Resp22 = mysql_query($Consulta22);
							if($Fila22=mysql_fetch_array($Resp22))
							{
								if(substr($Fila22("Titulo1"), 0, 10) !="          ")
								{
									//echo $Fila22["Titulo1"]."<br>";
									//echo $Fila22["Titulo2"]."<br>";
									$ContLineas = $ContLineas + 3;
								}
							}
							//echo $Consulta2."<br>";
							while($Fila2=mysql_fetch_array($Resp2))
							{
								if(substr($Fila2["Puntero"],0,2)=="01")
								{
									//escribe datos nivel 01
									$ClaveAux = FormateaNro($I,2,"0").substr($Fila2["Puntero"],0,5);
									$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$ClaveAux."'";
									$RespAux=mysql_query($ConsultaAUX);
									if($Fila=mysql_fetch_array($RespAux))
									{
										echo "<tr>";
										echo "<td align='left'>".$Fila["Nombre"]."</td>";
										echo "<td align='right'>".number_format($Fila["Seco"],0,',','.')."</td>";
										echo "<td align='right'>".number_format($Fila["Cu"],0,',','.')."</td>";
										echo "<td align='right'>".number_format($Fila["Ag"],0,',','.')."</td>";
										echo "<td align='right'>".number_format($Fila["Au"],0,',','.')."</td>";
										echo "</tr>";
										$ContLineas = $ContLineas + 1;
									}
								}	
								else
								{
									$Clave4 = FormateaNro($I,2,"0").substr($Fila2["Puntero"],0,5);
									$Consulta4 = "Select * from pcip_ena_punteroxconcom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave4."' order by NumPuntero";
									$Resp4 = mysql_query($Consulta4);
									$Consulta42 = "Select * from pcip_ena_titulocom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave4."'";
									$Resp42 = mysql_query($Consulta42);
									if($Fila42=mysql_fetch_array($Resp42))
									{
										if(substr($Fila42["Titulo1"],0,10)!="          ")
										{
											//echo $Fila22["Titulo1"]."<br>";
											//echo $Fila22["Titulo2"]."<br>";
											$ContLineas = $ContLineas + 3;
										}
									}
									//echo $Consulta4."<br>";
									while($Fila4=mysql_fetch_array($Resp4))
									{
										if(substr($Fila4["Puntero"],0,2) == "01")
										{
											//escribe datos nivel 01
											$ClaveAux = FormateaNro($I,2,"0").substr($Fila4["Puntero"],0,5);
											$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$ClaveAux."'";
											$Resp=mysql_query($ConsultaAUX);
											if($Fila=mysql_fetch_array($Resp))
											{
												echo "<tr>";
												echo "<td align='left'>".$Fila["Nombre"]."</td>";
												echo "<td align='right'>".number_format($Fila["Seco"],0,',','.')."</td>";
												echo "<td align='right'>".number_format($Fila["Cu"],0,',','.')."</td>";
												echo "<td align='right'>".number_format($Fila["Ag"],0,',','.')."</td>";
												echo "<td align='right'>".number_format($Fila["Au"],0,',','.')."</td>";
												echo "</tr>";
												$ContLineas = $ContLineas + 1;
											}
										}	
										else
										{
											$Clave6 = FormateaNro($I,2,"0").substr($Fila4["Puntero"],0,5);
											$Consulta6 = "Select * from pcip_ena_punteroxconcom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave6."' order by NumPuntero";
											$Resp6 = mysql_query($Consulta6);
											$Consulta62 = "Select * from pcip_ena_titulocom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave6."'";
											$Resp62 = mysql_query($Consulta62);
											if($Fila62=mysql_fetch_array($Resp62))
											{
												if(substr($Fila62["Titulo1"],0,10) != "          ")
												{
													//echo $Fila62["Titulo1"]."<br>";
													//echo $Fila62["Titulo2"]."<br>";
													$ContLineas = $ContLineas + 3;
												}
											}
											while($Fila6=mysql_fetch_array($Resp6))
											{
												if(substr($Fila6["Puntero"],0,2)== "01")
												{
													//escribe datos nivel 01
													$ClaveAux = FormateaNro($I,2,"0").substr($Fila6["Puntero"],0,5);
													$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$ClaveAux."' ";
													$Resp=mysql_query($ConsultaAUX);
													if($Fila=mysql_fetch_array($Resp))
													{
														echo "<tr>";
														echo "<td align='left'>".$Fila["Nombre"]."</td>";
														echo "<td align='right'>".number_format($Fila["Seco"],0,',','.')."</td>";
														echo "<td align='right'>".number_format($Fila["Cu"],0,',','.')."</td>";
														echo "<td align='right'>".number_format($Fila["Ag"],0,',','.')."</td>";
														echo "<td align='right'>".number_format($Fila["Au"],0,',','.')."</td>";
														echo "</tr>";
														$ContLineas = $ContLineas + 1;
													}
												}
												else
												{
													$Clave8 = FormateaNro($I,2,"0").substr($Fila6["Puntero"],0,5);
													$Consulta8 = "Select * from pcip_ena_punteroxconcom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave8."'";
													$Resp8 =mysql_query($Consulta8);
													$Consulta82 = "Select * from pcip_ena_titulocom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave8."'";
													$Resp82 =mysql_query($Consulta82);
													if($Fila82=mysql_fetch_array($Resp82))
													{
														if(substr($Fila82["Titulo1"],0,10)!= "          ")
														{
															//echo $Fila82["Titulo1"]."<br>";
															//echo $Fila82["Titulo2"]."<br>";
															$ContLineas = $ContLineas + 3;
														}
													}
													while($Fila8=mysql_fetch_array($Resp8))
													{
														if(substr($Fila8["Puntero"],0,2)== "01")
														{
															//escribe datos nivel 01
															$ClaveAux = FormateaNro($I,2,"0").substr($Fila8["Puntero"],0,5);
															$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$ClaveAux."'";
															$Resp = mysql_query($ConsultaAUX);
															if($Fila=mysql_fetch_array($Resp))
															{
																echo "<tr>";
																echo "<td align='left'>".$Fila["Nombre"]."</td>";
																echo "<td align='right'>".number_format($Fila["Seco"],0,',','.')."</td>";
																echo "<td align='right'>".number_format($Fila["Cu"],0,',','.')."</td>";
																echo "<td align='right'>".number_format($Fila["Ag"],0,',','.')."</td>";
																echo "<td align='right'>".number_format($Fila["Au"],0,',','.')."</td>";
																echo "</tr>";
																$ContLineas = $ContLineas + 1;
															}
														}
													}
													$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave8."'";
													$Resp = mysql_query($ConsultaAUX);
													if($Fila=mysql_fetch_array($Resp))
													{
														if(substr($Fila["Nombre"],0, 20)!="                    ")
														{
															echo "<tr>";
															echo "<td align='left' class='Formulario2'>".$Fila["Nombre"]."</td>";
															echo "<td align='right' class='Formulario2'>".number_format($Fila["Seco"],0,',','.')."</td>";
															echo "<td align='right' class='Formulario2'>".number_format($Fila["Cu"],0,',','.')."</td>";
															echo "<td align='right' class='Formulario2'>".number_format($Fila["Ag"],0,',','.')."</td>";
															echo "<td align='right' class='Formulario2'>".number_format($Fila["Au"],0,',','.')."</td>";
															echo "</tr>";
															$ContLineas = $ContLineas + 3;
														}
													}
												}
											}
											$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave6."'";
											$Resp = mysql_query($ConsultaAUX);
											if($Fila=mysql_fetch_array($Resp))
											{
												if(substr($Fila["Nombre"],0, 20)!="                    ")
												{
													echo "<tr  class='FilaAbeja'>";
													echo "<td align='left' class='Formulario2'>".$Fila["Nombre"]."</td>";
													echo "<td align='right'  class='Formulario2'>".number_format($Fila["Seco"],0,',','.')."</td>";
													echo "<td align='right'  class='Formulario2'>".number_format($Fila["Cu"],0,',','.')."</td>";
													echo "<td align='right'  class='Formulario2'>".number_format($Fila["Ag"],0,',','.')."</td>";
													echo "<td align='right'  class='Formulario2'>".number_format($Fila["Au"],0,',','.')."</td>";
													echo "</tr>";
													$ContLineas = $ContLineas + 3;
												}
											}
										}
									}
									$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave4."'";
									$Resp = mysql_query($ConsultaAUX);
									if($Fila=mysql_fetch_array($Resp))
									{
										if(substr($Fila["Nombre"],0, 20)!="                    ")
										{
											echo "<tr>";
											echo "<td align='left' class='pie_tabla_bold2'>".$Fila["Nombre"]."</td>";
											echo "<td align='right' class='pie_tabla_bold2'>".number_format($Fila["Seco"],0,',','.')."</td>";
											echo "<td align='right' class='pie_tabla_bold2'>".number_format($Fila["Cu"],0,',','.')."</td>";
											echo "<td align='right' class='pie_tabla_bold2'>".number_format($Fila["Ag"],0,',','.')."</td>";
											echo "<td align='right' class='pie_tabla_bold2'>".number_format($Fila["Au"],0,',','.')."</td>";
											echo "</tr>";
											$ContLineas = $ContLineas + 3;
										}
									}
								}
							}
							$ConsultaAUX = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and Clave='".$Clave2."'";
							$Resp = mysql_query($ConsultaAUX);
							if($Fila=mysql_fetch_array($Resp))
							{
								if(substr($Fila["Nombre"],0, 20)!="                    ")
								{
									echo "<tr>";
									echo "<td align='left' class='TituloTablaVerdeActiva'>".$Fila["Nombre"]."</td>";
									echo "<td align='right' class='TituloTablaVerdeActiva'>".number_format($Fila["Seco"],0,',','.')."</td>";
									echo "<td align='right' class='TituloTablaVerdeActiva'>".number_format($Fila["Cu"],0,',','.')."</td>";
									echo "<td align='right' class='TituloTablaVerdeActiva'>".number_format($Fila["Ag"],0,',','.')."</td>";
									echo "<td align='right' class='TituloTablaVerdeActiva'>".number_format($Fila["Au"],0,',','.')."</td>";
									echo "</tr>";
									$ContLineas = $ContLineas + 3;
								}
							}
						}
					}
				}
			}
			?>
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>
</form>
</body>
</html>
<?
function FormateaNro($Numero,$Largo,$Caracter)
{

if($Numero=="")
    $Numero="0";

if(abs(intval($Numero)) >=0)
{
 $K=1;
 $senal = 1;
   while($K<strlen($Numero)&&$senal=1)
   { 	
	   if(substr($Numero,$K,1)== "-")
	   {
			$senal=-1;
			$Numero = str_replace("-", "0",$Numero);
	   }
	   else
	   {
	    	$K=$K+1;
	   }
    }
 $Numero = trim(intval($Numero));
 $numero1 = intval($Numero) * $senal;
 $Numero = str_replace(",",".",$numero1);
}
if($senal==1)
{
    while (strlen($Numero) < $Largo)
    {
	    $Numero = $Caracter.$Numero;
    }
	if($senal==-1)
	{
		$Numero = str_replace("0","",$Numero);
		while (strlen($Numero) < $Largo)
		{
			$Numero = $Caracter.$Numero;
		}
	}
}
return($Numero);
}



?>