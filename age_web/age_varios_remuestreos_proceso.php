<?php 	
	include("../principal/conectar_principal.php");


	$LoteOri  = isset($_REQUEST["LoteOri"])?$_REQUEST["LoteOri"]:"";
	$LoteEnc  = isset($_REQUEST["LoteEnc"])?$_REQUEST["LoteEnc"]:"";
	$LoteBusc = isset($_REQUEST["LoteBusc"])?$_REQUEST["LoteBusc"]:"";

	$LoteEnc = BuscarRemuestreos($LoteOri,$LoteEnc,$link);
	$TxtRemuestreo1=$LoteEnc;
	$LoteEnc = BuscarRemuestreos($LoteEnc,$LoteEnc,$link);
	$TxtRemuestreo2=$LoteEnc;
	$LoteEnc = BuscarRemuestreos($LoteEnc,$LoteEnc,$link);
	$TxtRemuestreo3=$LoteEnc;
	$LoteEnc = BuscarRemuestreos($LoteEnc,$LoteEnc,$link);
	$TxtRemuestreo4=$LoteEnc;
	
function BuscarRemuestreos($LoteBusc,$LoteEnc,$link)
{
	//$LoteEnc='';
	if($LoteBusc!='')
	{
		$Consulta = "select lote from age_web.lotes t1 where t1.num_lote_remuestreo='".$LoteBusc."'";
		//$Consulta.= " and t1.remuestreo ='N' and t1.estado_lote=6";
		//echo $Consulta;
		$RespLoteB = mysqli_query($link, $Consulta);
		if($FilaLoteB=mysqli_fetch_array($RespLoteB))
		{
			$LoteEnc=$FilaLoteB["lote"];
		}
	}
	return $LoteEnc;	
}
?>
<html>
<head>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Remuestreo(Opc,Num)
{
	var Frm=document.FrmProceso;
	switch(Num)
	{
		case '2':
			if(Frm.TxtRemuestreo2.value=='')
			{
				alert('No existe Remuestreo');
				return;
			}			
			if(Opc=='A'&&Frm.TxtRemuestreo1.value=='')
			{
				alert('Debe Agregar Antes El Remuestreo N° 1');
				return;
			}	
			if(Opc=='Q'&&Frm.TxtRemuestreo3.value!='')
			{
				alert('Debe Quitar Antes El Remuestreo N° 3');
				return;
			}
			Frm.action='age_varios_remuestreos01.php?Proceso='+Opc+'&Num=2&LoteRemuestreo='+Frm.TxtRemuestreo2.value+"&ExLote="+Frm.TxtRemuestreo1.value;
			Frm.submit();	
			break;
		case '3':
			if(Frm.TxtRemuestreo3.value=='')
			{
				alert('No existe Remuestreo');
				return;
			}
			if(Opc=='A'&&Frm.TxtRemuestreo2.value=='')
			{
				alert('Debe Agregar Antes El Remuestreo N° 2');
				return;
			}	
			if(Opc=='Q'&&Frm.TxtRemuestreo4.value!='')
			{
				alert('Debe Quitar Antes El Remuestreo N° 4');
				return;
			}
			Frm.action='age_varios_remuestreos01.php?Proceso='+Opc+'&Num=3&LoteRemuestreo='+Frm.TxtRemuestreo3.value+"&ExLote="+Frm.TxtRemuestreo2.value;
			Frm.submit();	
			break;	
		case '4':
			if(Frm.TxtRemuestreo4.value=='')
			{
				alert('No existe Remuestreo');
				return;
			}			
			if(Opc=='A'&&Frm.TxtRemuestreo3.value=='')
			{
				alert('Debe Agregar Antes El Remuestreo N° 3');
				return;
			}	
			Frm.action='age_varios_remuestreos01.php?Proceso='+Opc+'&Num=4&LoteRemuestreo='+Frm.TxtRemuestreo4.value+"&ExLote="+Frm.TxtRemuestreo3.value;
			Frm.submit();	
			break;			
	}
	
}
function Imprimir()
{
	var Frm=document.FrmProceso;
	
	Frm.BtnImprimir.style.visibility='hidden';
	Frm.BtnSalir.style.visibility='hidden';
	window.print();
	Frm.BtnImprimir.style.visibility='';
	Frm.BtnSalir.style.visibility='';
}

function Salir()
{
	window.close();
}
</script>
<title>Ingreso de Remuestreos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body onload='' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>
<form name="FrmProceso" method="post" action="">
  <table width="516" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="554" align="center" valign="top"><table width="400" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="right"><div align="center"><strong>VARIOS REMUESTREOS </strong></div></td> 
            <td width="150" align="right">
              <div align="center">
                <input type="button" name="BtnImprimir" value="Imprimir" style="width:60" onClick="Imprimir();">
			    <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			  </div></td>
          </tr>
        </table>
        <br>
        <table width="400" border="1" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="101"  align="center" class="ColorTabla02">Lote Original </td>
			<td colspan="3"  align="left"><strong><?php echo $LoteOri;?></strong>&nbsp;</td>
		  </tr>
          <tr>
            <td  align="center" class="ColorTabla02">1 Remuestreo </td>
            <td colspan="3"  align="left"><input name="TxtRemuestreo1" type="text" id="TxtRemuestreo1" readonly="true" value="<?php echo $TxtRemuestreo1;?>" size="10"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">2 Remuestreo </td>
            <td width="61"  align="left"><label>
              <input name="TxtRemuestreo2" type="text" id="TxtRemuestreo2" value="<?php echo $TxtRemuestreo2;?>" size="10" maxlength="8">
            </label></td>
            <td width="141"  align="center"><input type="button" name="BtnImprimir3" value="Agregar" style="width:60" onClick="Remuestreo('A','2');"></td>
            <td width="101"  align="center"><input type="button" name="BtnImprimir7" value="Quitar" style="width:60" onClick="Remuestreo('Q','2');"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">3 Remuestreo </td>
            <td  align="left"><input name="TxtRemuestreo3" type="text" id="TxtRemuestreo3" value="<?php echo $TxtRemuestreo3;?>" size="10" maxlength="8"></td>
            <td  align="center"><input type="button" name="BtnImprimir32" value="Agregar" style="width:60" onClick="Remuestreo('A','3');"></td>
            <td  align="center"><input type="button" name="BtnImprimir72" value="Quitar" style="width:60" onClick="Remuestreo('Q','3');"></td>
          </tr>
          <tr>
            <td  align="center" class="ColorTabla02">4 Remuestreo </td>
            <td  align="left"><input name="TxtRemuestreo4" type="text" id="TxtRemuestreo4" value="<?php echo $TxtRemuestreo4;?>" size="10" maxlength="8"></td>
            <td  align="center"><input type="button" name="BtnImprimir33" value="Agregar" style="width:60" onClick="Remuestreo('A','4');"></td>
            <td  align="center"><input type="button" name="BtnImprimir73" value="Quitar" style="width:60" onClick="Remuestreo('Q','4');"></td>
          </tr>
        </table></td>
  </tr>
</table>
</form>
</body>
</html>