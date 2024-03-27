<? 
	include("../principal/conectar_sget_web.php");
	session_start();
	
	$TxtFecha=date("Y-m-d");
	$HoraActual = date("H");
	$MinutoActual = date("i");	
?>
<html>
<head>
<title>Atachar Documento</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "G":
			if(f.CmbTipoDoc.value=='S')
			{
				alert('Debe Seleccionar Tipo Documento')
				f.CmbTipoDoc.focus();
				return;
			}
			if(f.Archivo.value=='')
			{
				alert('Debe Seleccionar Documento')
				f.Archivo.focus();
				return;
			}
			f.action='sget_atach01.php?Opt='+Opcion;
			f.submit();
			break;
		case "S":
			if (f.Pagina.value=="sget_hoja_ruta.php")
			{
				window.opener.document.FrmProceso.action="sget_hoja_ruta.php?TxtHoja="+f.ID.value+"&Opt=M";
				window.opener.document.FrmProceso.submit();						
				window.close();
			}
			
			break;
	}
}
</script>
</head>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form action="" method="post" enctype="multipart/form-data" name="FrmPopupProceso">
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="ID" value="<? echo $ID;?>">
<input type="hidden" name="Formulario" value="<? echo $Formulario;?>">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="TipoVolver" value="<? echo $TipoVolver;?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
      <td width="1058" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
      <td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="74%" align="left"><img src="archivos/sub_tit_atach.png"></td>
            <td align="right"><a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0" align="absmiddle"></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="archivos/close.png" border="0" align="absmiddle"></a></td>
          </tr>
        </table>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
            <tr>
              <td colspan="3"align="center" class="TituloTablaVerde"></td>
            </tr>
            <tr>
              <td width="1%" align="center" class="TituloTablaVerde"></td>
              <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="BordeTabla">
                <tr>
                  <td width="107" align="right" class="formulario2">N&ordm; Hoja Ruta </td>
                  <td class="formulariosimple">:</td>
                  <td colspan="4" class="formulariosimple"><?
	  
	   		echo $ID;
	  	
	   ?></td>
                </tr>
                <!-- <tr>
      <td align="right" class="texto_bold">Etapa
	 
	  </td>
      <td class="BordeBajo">:</td>
      <td class="BordeBajo">
	  <? 
	  if($Proceso=='L'||$Proceso=='C'){//SI ES LICITACION
	  	$Consulta="SELECT * from sgc_estados where tipo_proceso='L' ";
		$Consulta.=" and cod_estado='".$CodEstO."' ";
		$RespEst=mysqli_query($link, $Consulta);
		$FilaEst=mysql_fetch_array($RespEst);
		$DescripEst=$FilaEst[descrip_estado];
	  }
	  	if(($Formulario=='FrmPrograma')|| ($Formulario=='FrmDoc'))//Si se Adjunta documentos desde Registro de Hitos
			$DescripEst='Reg.Hitos';
		echo $DescripEst;
	  ?>
	  </td>
      <td class="BordeBajo">Hito</td>
      <td class="BordeBajo">:</td>
      <td class="BordeBajo"><?
	   if(($Formulario=='FrmPrograma')|| ($Formulario=='FrmDoc'))//Si se Adjunta documentos desde Registro de Hitos
		{
			$Consulta="SELECT * from sgc_hitos where  ";
			$Consulta.="  cod_hito='".$RegHito."' ";
			$RespHito=mysqli_query($link, $Consulta);
			$FilaHito=mysql_fetch_array($RespHito);
			$DescripHito=$FilaHito[descrip_hito];
		  }
	   echo $DescripHito; 
	   ?>&nbsp;</td>
    </tr>-->
                <tr>
                  <td align="right" class="formulario2">Fecha</td>
                  <td class="formulariosimple">:</td>
                  <td width="134" class="formulariosimple"><input name="TxtFecha" type="text" readonly  style="width:100" value="<? echo $TxtFecha; ?>" >
                      <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"> </td>
                  <td width="22" class="formulariosimple">Hora: </td>
                  <td width="3" class="formulariosimple">:</td>
                  <td width="134" class="formulariosimple"><SELECT name="HoraI" id="SELECT7">
                      <?
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($HoraI))
					{	
						if ($HoraI == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                    </SELECT>
                      <strong>:</strong>
                      <SELECT name="MinutosI">
                        <?
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($MinutosI))
					{	
						if ($MinutosI == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                    </SELECT></td>
                </tr>
                <tr>
                  <td align="right" class="formulario2">Tipo de Documento</td>
                  <td class="formulariosimple">:</td>
                  <td colspan="4" class="formulariosimple"><SELECT name="CmbTipoDoc" style="width:150" >
                      <option value="S">Seleccionar </option>
                      <?
	  	$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30005'   ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_subclase"]==$CmbTipoDoc)
				echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".$Fila["nombre_subclase"]."</option>";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
		}
	  
	  ?>
                    </SELECT>
                      <span class="titulo_rojo_tabla">(*)</span> </td>
                </tr>
                <tr>
                  <td align="right" class="formulario2">Documento</td>
                  <td class="formulariosimple">:</td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td colspan="4" class="formulariosimple"><input type="file" name="Archivo" id="Archivo">
                  </td>
                </tr>
                <tr>
                  <td align="right" class="formulario2">Observaci&oacute;n</td>
                  <td width="3" class="formulariosimple">:</td>
                  <td colspan="4" class="formulariosimple"><textarea name="TxtObservacion" cols="50" rows="3" wrap="VIRTUAL" id="textarea" style="width:200"><? echo $TxtObservacion; ?></textarea></td>
                </tr>
                <tr>
                  <td colspan="6" valign="top" class="formulariosimple"><span class="titulo_rojo_tabla">(*) Datos Obligatorios</span></td>
                </tr>
              </table></td>
              <td width="0%" align="center" class="TituloTablaVerde"></td>
            </tr>
            <tr>
              <td colspan="3"align="center" class="TituloTablaVerde"></td>
            </tr>
          </table>
        <br></td>
      <td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
      <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="20" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <br>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!="")
		echo "alert('".$Mensaje."');";
	if($ID=='')
	{
		echo "alert('No Existe Nro. ID (Solp/Lic/Ctto)');";	
		echo "window.close();"; 
	}	
	if($Acento==true)
	{
		echo "alert('Renombre el Archivo sin Acentos');";	
	}
	
	
	echo "</script>";
?>