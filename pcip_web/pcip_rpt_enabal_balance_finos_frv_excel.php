<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

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
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <tr class="TituloTablaVerde">
      <td width="20%" rowspan="2" align="center"><span class="Estilo9">Productos</span></td>
      <td width="8%" rowspan="2" align="center"><span class="Estilo9">Peso Seco </span></td>
      <td width="24%" colspan="3" align="center"><span class="Estilo9">Finos</span></td>
    </tr>
    <tr class="TituloTablaVerde">
      <td width="8%" align="center"><span class="Estilo9">Cobre</span></td>
      <td width="8%" align="center"><span class="Estilo9">Plata</span></td>
      <td width="8%" align="center"><span class="Estilo9">Oro</span></td>
    </tr>
    <?
			$Buscar='S';
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
						$ConsultaSQL = "Select * from pcip_ena_concom where ano ='".$Ano."' and mes='".$Mes."' and NumTotal='".FormateaNro($I,2,"0")."'";
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
  </table>
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