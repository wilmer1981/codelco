<? 
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	session_start();
	
	$TxtFecha=date("Y-m-d");
	$HoraActual = date("H");
	$MinutoActual = date("i");	
	if ($Elim=="S")
		{
			$Dir = 'doc';
			$Archivo=$ArchivoElim;
			$ArchivoElim = $Dir."/".$ArchivoElim;
			if (file_exists($ArchivoElim))
				unlink($ArchivoElim);
			$Eliminar="delete from sget_documentos where nombre_archivo='".$Archivo."'";
			mysql_query($Eliminar);	
		}	
	
?>
<html>
<head>
<title>Documentaci�n Normativa</title>
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
			f.action='sget_doc_normativa01.php?Opt='+Opcion;
			f.submit();
			break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
			break;
	}
}
function DelFile(arch)
{
	var f=document.FrmPopupProceso;
	var msg=confirm("�Desea Eliminar este Archivo?");
	if (msg==true)
	{
		f.action="sget_doc_normativa.php?Elim=S&ArchivoElim="+arch;
		f.submit();
	}
	else
	{
		return;
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
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'doc_normativa.png')
 ?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
       <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="3" align="right" class="formulario2"></td>
          <td align="right" class="formulario2">		  <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0" align="absmiddle" alt="Grabar" ></a>
		  <a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" border="0" align="absmiddle" alt="Salir"></a>&nbsp;&nbsp;</td>
        </tr>

        <tr>
          <td colspan="4" class="TituloTablaVerde">Atachar Documentos (Archivos) </td>
        </tr>

        <!-- <tr>
      <td align="right" class="formulario2">Etapa
	 
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
          <td width="155" align="right" class="formulario2">Fecha</td>
          <td width="524" class="formulario2"><input name="TxtFecha" type="text" readonly  style="width:100" value="<? echo $TxtFecha; ?>" >
              <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"> </td>
          <td width="87" align="right" class="formulario2">Hora: </td>
          <td width="390" class="formulario2"><SELECT name="HoraI" id="SELECT7">
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
          <td colspan="3" class="formulario2"><SELECT name="CmbTipoDoc" style="width:150" >
              <option value="S">Seleccionar </option>
              <?
	  	$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30009'   ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_subclase"]==$CmbTipoDoc)
				echo "<option value='$Fila["cod_subclase"]."' SELECTed>".$Fila["nombre_subclase"]."</option>";
			else
				echo "<option value='$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
		}
	  
	  ?>
            </SELECT>
              <span class="titulo_rojo_tabla">(*)</span> </td>
        </tr>
        <tr>
          <td align="right" class="formulario2">Documento</td>
          <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
          <td colspan="3" class="formulario2"><input type="file" name="Archivo" id="Archivo">
            <span class="titulo_rojo_tabla">(*)</span> </td>
        </tr>
        <tr>
          <td align="right" class="formulario2">Observaci&oacute;n</td>
          <td colspan="3" class="formulario2"><textarea name="TxtObservacion" cols="100" rows="3" wrap="VIRTUAL" id="textarea" style="width:200"><? echo $TxtObservacion; ?></textarea></td>
        </tr>
        <tr align="center">
          <td colspan="4" class="formulario2"></td>
        </tr>
        <tr>
          <td colspan="4" valign="top" class="formulario2"><span class="titulo_rojo_tabla">(*) Datos Obligatorios</td>
        </tr>
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>
  <br>
  
  <table width="99%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
	  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
	  <td width="1189" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
</tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="6" align="left" class="TituloTablaNaranja" >Documentos Existentes</td>
          </tr>
          <tr align="center">
            <td width="5%" class="TituloTablaVerde">Elim.</td>
            <td width="10%" class="TituloTablaVerde">Tipo</td>
		    <td width="30%" class="TituloTablaVerde">Archivo</td>
            <td width="10%" class="TituloTablaVerde">Fecha</td>
			<td width="30%" class="TituloTablaVerde">Obs</td>
            <td width="15%" class="TituloTablaVerde">Tama&ntilde;o(Kb)</td>
          </tr>
          <?
		  $Dir='doc';
		  $Consulta="SELECT * from sget_documentos where cod_referencia='N' order by fecha_hora";
		  $Resp=mysqli_query($link, $Consulta);
		  while($Fila=mysql_fetch_array($Resp))
		  {
				echo "<tr>\n";
				echo "<td align='center' ><a href=\"JavaScript:DelFile('".$Fila[nombre_archivo]."')\"><img src=\"archivos/elim_hito.png\" border='0' height='18' width='18'></a></td>\n";
				$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30009' and cod_subclase='".$Fila[cod_tipo_doc]."'";
				$Resp2=mysqli_query($link, $Consulta);
				$Fila2=mysql_fetch_array($Resp2);
				echo "<td>".$Fila2["nombre_subclase"]."</td>";
				echo "<td ><a href=\"".$Dir."/".$Fila[nombre_archivo]."\" target='_blank'>".substr($Fila[nombre_archivo],12)."</a></td>\n";
				echo "<td align='center' >".str_replace('-','/',$Fila["fecha_hora"])."</td>\n";
				echo "<td align='center' >".$Fila["observacion"]."&nbsp;</td>\n";
				$Peso=filesize($Dir."/".$Fila[nombre_archivo]);
				echo "<td align='right'>".number_format($Peso/1000,3,",",".")."</td>\n";
				echo "</tr>\n";
		  }	 
		?>
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
  <?
CierreEncabezado()
?>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!="")
		echo "alert('".$Mensaje."');";
	if($Acento==true)
	{
		echo "alert('Renombre el Archivo sin Acentos');";	
	}
	echo "</script>";
?>