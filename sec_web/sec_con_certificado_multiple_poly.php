<?php 
	$CodSistema = 1;	
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function VerGenerados()
{	
	var URL = "sec_con_certificado05.php";
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
				
}

function Informacion()
{
	var Frm=document.FrmProceso;
	var URL = "";
	for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name=="ChkCodLote") && (Frm.elements[i].checked == true))
		{
		//alert (Frm.CmbAno.value);
			var URL = "sec_con_certificado04.php?Corr=" + Frm.elements[i+4].value + "&Mes=" + Frm.elements[i].value + "&Lote=" + Frm.elements[i+1].value + "&CmbAno="+Frm.CmbAno.value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
		}
	}			
}

function VistaPrevia()
{
	var Frm=document.FrmProceso;
	var URL = "";
	for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name=="ChkCodLote") && (Frm.elements[i].checked == true) && (Frm.elements[i+2].value == "NO"))
		{
			var URL = "sec_con_certificado.php?Proceso=P&Corr=" + Frm.elements[i+4].value + "&Mes=" + Frm.elements[i].value + "&Lote=" + Frm.elements[i+1].value + "&Idioma=" + Frm.elements[i+3].value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
		}
	}
}

function Detalle(num,idioma)
{
	var f = document.frmPrincipal;	
	var URL = "sec_con_certificado_creado.php?NumCertificado=" + num + "&Idioma=" + idioma;
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
}
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1";
	Frm.submit();
}
function Consultar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_con_certificado_multiple.php?Mostrar=S";
	Frm.submit();
}
function Actualizar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_con_certificado_multiple.php?Mostrar=S";
	Frm.submit();
}

function Excel()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_xls_certificado_multiple.php?CmbMes="+Frm.CmbMes.value+"&CmbAno="+Frm.CmbAno.value;
	Frm.submit();
}

function Imprimir()
{
	var Frm=document.FrmProceso;
	window.print();
}

function Generar()
{
	var Frm=document.FrmProceso;
	var URL = "";
	for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name=="ChkCodLote") && (Frm.elements[i].checked == true) && (Frm.elements[i+2].value == "NO"))
		{
			URL = "sec_con_certificado.php?Corr=" + Frm.elements[i+4].value + "&Mes=" + Frm.elements[i].value + "&Lote=" + Frm.elements[i+1].value + "&Idioma=" + Frm.elements[i+3].value;
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");					
		}
	}
}

function Anular()
{
	var Frm=document.FrmProceso;
	var URL = "";
	for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name=="ChkCodLote") && (Frm.elements[i].checked == true))
		{
			Frm.action = "sec_con_certificado03.php?Proceso=A&Corr=" + Frm.elements[i+4].value + "&Mes=" + Frm.elements[i].value + "&Lote=" + Frm.elements[i+1].value + "&Estado=" + Frm.CmbEstado.value;
			Frm.submit();
		}
	}
}

function Habilitar()
{
	var Frm=document.FrmProceso;
	var URL = "";
	for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name=="ChkCodLote") && (Frm.elements[i].checked == true))
		{
			Frm.action = "sec_con_certificado03.php?Proceso=H&Corr=" + Frm.elements[i+4].value + "&Mes=" + Frm.elements[i].value + "&Lote=" + Frm.elements[i+1].value + "&Estado=" + Frm.CmbEstado.value;
			Frm.submit();
		}
	}
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
    
          
    <table width="750" border="0" class="TablaInterior">
      <tr> 
        <td colspan="2"  align="center"><div align="left"></div></td>
        <td  align="center" width="174"><strong>EMISION DE CERTIFICADOS</strong> 
        </td>
        <td  align="center" width="423"><div align="left"> </div></td>
        <td  align="center" width="32"> <div align="left"> </div></td>
      </tr>
      <tr> 
        <td width="28"  align="center"><div align="right"></div></td>
        <td width="68"  align="center"><div align="left">Fecha</div></td>
        <td  align="center"> <div align="left"> 
            <?php
			echo"<SELECT name='CmbMes'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</SELECT>";
			echo "<SELECT name='CmbAno'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option SELECTed value ='$i'>$i</option>";
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
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			echo "</SELECT>";
	?>
          </div></td>
        <td colspan="2"  align="center"> 
          <input name="BtnVistaPrevia" type="button" id="BtnVistaPrevia2" style="width:80px" onClick="VistaPrevia();" value="Vista Previa"> 
          <input name="BtnImprimir22" type="button" id="BtnImprimir222" value="Imprimir" style="width:70px;" onClick="Imprimir();">
      <input type="button" name="BtnSalir2" value="Salir" style="width:70" onClick="Salir();">
      </td>
      </tr>
      <tr> 
        <td  align="center"><div align="right"></div></td>
        <td  align="center"><div align="left">Tipo</div></td>
        <td  align="center"><div align="left"> 
            <SELECT name="CmbEstado">
              <?php
				  	if (isset($CmbEstado))
					{
						switch ($CmbEstado)
						{	
							case "T":
					  			echo "<option value='T' SELECTed>TODOS</option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A'>ANULADOS</option>";
								break;
							case "P":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='P' SELECTed>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A'>ANULADOS</option>";
								break;
							case "E":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E' SELECTed>EMITIDOS</option>";
								echo "<option value='A'>ANULADOS</option>";
								break;
							case "A":
					  			echo "<option value='T'>TODOS</option>";
								echo "<option value='P'>PENDIENTES</option>";
								echo "<option value='E'>EMITIDOS</option>";
								echo "<option value='A' SELECTed>ANULADOS</option>";
								break;
						}
						
					}
					else
					{
						echo "<option value='T' SELECTed>TODOS</option>";
						echo "<option value='P'>PENDIENTES</option>";
						echo "<option value='E'>EMITIDOS</option>";
						echo "<option value='A'>ANULADOS</option>";
					}
				  ?>
            </SELECT>
          </div></td>
        <td colspan="2"  align="center">&nbsp; 
</td>
      </tr>
    </table>
		<br>
        
    	  
    <div style="position:absolute; left: 1px; top: 90px; width: 755px; height: 26px; OVERFLOW: auto;" id="div2"> 
      
    <table width="750" height="20" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <tr class="ColorTabla01"> 
        <td width="48"> <div align="left">&nbsp;</div></td>
        <td width="65" align="left"> <div align="left">LOTE</div></td>
        <td width="133" align="left">PRODUCTO</td>
        <td width="62" align="left"> <div align="left">IDIOMA</div></td>
        <td width="65">F. SOL.</td>
        <td width="82">SOLICIT.</td>
        <td width="75">F. EMISION</td>
        <td width="73">EMISOR</td>
        <td width="72">NRO. CERT.</td>
      </tr>
    </table>
    </div>
	  
    <div style="position:absolute; left: 1px; top: 114px; width: 770px; height: 290px; OVERFLOW: auto;border:solid 1px #000000" id="div2"> 
      <table width="750" height="20" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <?php
			if ($Mostrar=='S')
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$Fecha_Envio=$CmbAno."-".$CmbMes;								
				$Consulta = "SELECT * from sec_web.solicitud_certificado t1 ";
				$Consulta.= " left join sec_web.embarque_ventana t2 on t1.corr_enm=t2.corr_enm 		";
				$Consulta.= " inner join sec_web.marca_catodos t3 on t2.cod_marca=t3.cod_marca 		";
				$Consulta.= " where  substring(t1.fecha_hora,1,7) ='".$Fecha_Envio."'	";
				$Consulta.= " order by t1.fecha_hora ";	
				//echo $Consulta;							
				$Respuesta=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Consulta2 = "SELECT * from sec_web.certificacion_catodos where corr_enm = '".$Fila["corr_enm"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta2);
					$ConCertificado = "";
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Emitido = "E";
						$ConCertificado = "S";
					}
					else
					{
						$Emitido = "P";
					}
					if ($Fila["estado_certificado"] == "A")
						$Emitido = "A";
					if (($CmbEstado == "T") || ($CmbEstado == "E" && $Emitido == "E") || ($CmbEstado == "P" && $Emitido == "P") || 
					    ($CmbEstado == "A" && $Emitido == "A"))
					{
						echo "<tr>"; 
						$Emisor = "";
						$FechaEmision = "";
						$Consulta2 = "SELECT * from sec_web.certificacion_catodos where corr_enm = '".$Fila["corr_enm"]."'";
						$Respuesta2 = mysqli_query($link, $Consulta2);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Emisor = $Fila2["rut"];
							$FechaEmision = $Fila2["fecha"];
							$NumCertificado = $Fila2["num_certificado"];
							echo "<td width='48' align='center'>";
							if ($Fila["estado_certificado"] == "A")
								echo "<img src='../Principal/imagenes/ico_x.gif'>";
							else
								echo "<img src='../Principal/imagenes/ico_ok.gif'>";
							echo "<input name='ChkCodLote' type='radio'  value='".$Fila["cod_bulto"]."'>\n";
							echo "<input name='ChkNumLote' type='hidden'  value='".$Fila["num_bulto"]."'>\n";							
							echo "<input name='ChkOK' type='hidden'  value='NO'>\n";
							echo "</td>\n";
						}
						else
						{
							echo "<td width='48' align='center'>";
							if ($Fila["estado_certificado"] == "A")
								echo "<img src='../Principal/imagenes/ico_x.gif'>";							
							echo "<input name='ChkCodLote' type='radio'  value='".$Fila["cod_bulto"]."'>\n";
							echo "<input name='ChkNumLote' type='hidden'  value='".$Fila["num_bulto"]."'>\n";							
							echo "<input name='ChkOK' type='hidden'  value='NO'>\n";							
						}
						//IDIOMA						
						if ($Fila["estado"] == "N")
						{
							$Idioma = "I";							
							echo "<input name='ChkIdioma' type='hidden'  value='I'><input name='ChkCorrEnm' type='hidden'  value='".$Fila["corr_enm"]."'></td>\n";
						}
						else
						{
							$Idioma = "E";
							echo "<input name='ChkIdioma' type='hidden'  value='E'><input name='ChkCorrEnm' type='hidden'  value='".$Fila["corr_enm"]."'></td>\n";
						}
						$Cont2++;
						echo "<td width='65' align='center'>";
						echo "<a href=\"sec_con_certificado_det_pqtes.php?Mes=".$Fila["cod_bulto"]."&Lote=".$Fila["num_bulto"]."&Grupo=T\">";
						echo $Fila["cod_bulto"]."-".str_pad($Fila["num_bulto"], 6, "0", STR_PAD_LEFT)."</a></td>\n";
						//--------------------SUBPRODUCTO--------------
						$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
						$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							echo "<td width='133' align='left'>".strtoupper($Fila2["descripcion"])."</td>\n";
						}
						else
						{
							echo "<td width='133' align='left'>&nbsp;</td>\n";	
						}						
						//---------------------------------------------
						if ($Idioma == "E")
							echo "<td width='62' align='center'>Terres.</td>\n";
						else
							echo "<td width='62' align='center'>Export.</td>\n";
						$Respuesta2=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cliente=$Fila2["nombre_nave"];
						}
						else
						{
							$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$Fila["cod_cliente"]."'";
							$Respuesta2=mysqli_query($link, $Consulta);
							if($Fila2=mysqli_fetch_array($Respuesta2))
							{
								$Cliente=$Fila2["sigla_cliente"];
							}
						}
						//FECHA SOLICITUD
						echo "<td width='65' align='center'>".substr($Fila["fecha_hora"],8,2).".".substr($Fila["fecha_hora"],5,2).".".substr($Fila["fecha_hora"],0,4)." ".substr($Fila["fecha_hora"],11)."</td>\n";
						//RUT SOLICITA
						$Consulta2 = "SELECT * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut"]."'";
						$Respuesta2 = mysqli_query($link, $Consulta2);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Nombre = substr(strtoupper($Fila2["nombres"]),0,1).". ".ucwords(strtolower($Fila2["apellido_paterno"]));
							echo "<td width='82' align='center'>".$Nombre."</td>\n";
						}
						else
						{
							echo "<td width='82' align='center'>&nbsp;</td>\n";	
						}
						//FECHA EMISION
						if ($FechaEmision != "")
							echo "<td width='75' align='center'>".substr($FechaEmision,8,2).".".substr($FechaEmision,5,2).".".substr($FechaEmision,0,4)." ".substr($FechaEmision,11)."</td>\n";
						else
							echo "<td width='75' align='center'>&nbsp;</td>\n";
						// EMISOR
						if ($Emisor != "")
						{
							$Consulta2 = "SELECT * from proyecto_modernizacion.funcionarios where rut = '".$Emisor."'";
							$Respuesta2 = mysqli_query($link, $Consulta2);
							if ($Fila2 = mysqli_fetch_array($Respuesta2))
							{
								$Nombre = substr(strtoupper($Fila2["nombres"]),0,1).". ".ucwords(strtolower($Fila2["apellido_paterno"]));
								echo "<td width='73' align='center'>".$Nombre."</td>\n";
							}
							else
							{
								echo "<td width='73' align='center'>&nbsp;</td>\n";	
							}
						}
						else
						{
							echo "<td width='73' align='center'>&nbsp;</td>\n";
						}
						if ($ConCertificado == "S")
						{
							echo "<td width='72' align='center'><a href=\"JavaScript:Detalle('".$NumCertificado."','".$Idioma."')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'>\n";
							echo str_pad($NumCertificado, 6, "0", STR_PAD_LEFT)."</a></td>\n";
						}
						else
						{
							echo "<td width='72' align='center'>&nbsp;</td>\n";
						}
						echo "</tr>";
					}
				}
			}
		?>
    </table></div>
  </form>
</body>
</html>
