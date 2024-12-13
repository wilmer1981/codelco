<?php 
	include("../principal/conectar_sea_web.php");

	$Buscar     = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$Lote       = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$Guia       = isset($_REQUEST["Guia"])?$_REQUEST["Guia"]:"";
	$LoteOrigen = isset($_REQUEST["LoteOrigen"])?$_REQUEST["LoteOrigen"]:"";
	/*
	if(isset($_REQUEST["FechaRec"])) {
		$TxtFecha = $_REQUEST["FechaRec"];
	}else{
		$TxtFecha = '';
	}
*/
	$Hora      = isset($_REQUEST["Hora"])?$_REQUEST["Hora"]:date("H");
	$Minutos   = isset($_REQUEST["Minutos"])?$_REQUEST["Minutos"]:date("i");
	$TxtFecha  = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:date('Y-m-d');

	$HoraAux=date('G');
	$MinAux=date('i');
	if(!isset($Hora))
	{
		if(intval($HoraAux)>=0 && intval($HoraAux)<8)
		{
			$Hora="07";
			$Minutos="59";
		}
		if(intval($HoraAux)>=8 && intval($HoraAux)<16)
		{
			$Hora="15";
			$Minutos="59";
		}
		if(intval($HoraAux)>=16 && intval($HoraAux)<=23)
		{
			$Hora="23";
			$Minutos="59";
		}
	}	
	
	//$LoteO=substr($LoteOrigen,0,1).substr($LoteOrigen,2);
	$LoteO    = $LoteOrigen;
	$Consulta = "SELECT * FROM sea_web.recepcion_externa WHERE guia='".$Guia."' AND lote_origen='".$LoteO."' AND lote_ventana='".str_pad($Lote,8,'0',STR_PAD_LEFT)."'";
	//$Consulta="select * from sea_web.recepcion_externa where guia='".$Guia."' and lote_ventana='".str_pad($Lote,8,'0',STR_PAD_LEFT)."'";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	//echo "Resultado:<br>";
	//var_dump($Fila);

	$TxtPesoR=$Fila["peso_recep"];
	$TxtUnidR=$Fila["piezas_recep"];
	$TxtPesoO=$Fila["peso"];
	$TxtUnidO=$Fila["piezas"];
	$TxtLoteO=$Fila["lote_origen"];

?>

<html>
<head>
<title>Modificacion Guias de Despachos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Datos_Excel()
{
var f = frmPoPup;
var dia,mes,ano;
var valores;
 
 	valores = "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&cmbproductos=" + f.cmbproductos.value;    

    window.open("sea_ing_recep_ext04xls.php?Proceso=B"+valores);
}

function BuscarGuia()
{
var f = frmPoPup;

   if(f.TxtFecha.value!='')
   {
		f.action="sea_ing_recep_ext_guias.php?Buscar=S";
		f.submit();
   }
   else
   {
   		alert('Debe Ingresar Fecha');
   }		
}

function Imprimir()
{
	window.print();
}
function CalculaPeso(Obj,UnidIng,PesoUnid,Pos)
{

	var f = frmPoPup;
	var Dif=0;
	
	Dif=parseInt(f.TxtUnidR.value)-parseInt(UnidIng)+parseInt(Obj.value);
	if(Dif>parseInt(f.TxtUnidO.value))
	{	
		alert('Unidades Ingresadas no pueden ser Mayor a Unidades de Origen');
		//f.elements[NumElemt].value='';
		Obj.value=UnidIng;
		Obj.focus();
		return;
	}
	HabilitarOpt(Obj,true,Pos);
	/*alert(Valor);
	alert(Valor*parseInt(u.value)+parseInt(PesoRecep));
	alert(parseInt(PesoTot));*/
	/*if(u.value!=''&&u.value!='0')
		if(Valor*parseInt(u.value)+parseInt(PesoRecep)>parseInt(PesoTot))
			f.elements[NumElemt].value=parseInt(PesoTot)-parseInt(PesoRecep);
		else
			f.elements[NumElemt].value=Valor*parseInt(u.value);
	else
	{
		f.elements[NumElemt].value='';
		u.value='';
	}*/

}
function HabilitarOpt(Obj,Est,i)
{
	var f = frmPoPup;
	
	if(Est==false)
	{
		f.TxtUnid[i].disabled=false;
		f.TxtUnid[i].focus();
		//f.TxtUnid[i].disabled=false;
	}
	else
	{
		f.TxtUnid[i].disabled=true;	
		f.OptMod[i].checked=false;		
	}
	

}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
<table cellpadding="3" cellspacing="0" width="520" border="1" align="center">
		  <tr>
			<td>Fecha</td>
			<td>
			  <input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false">&nbsp;
              <font size="1"><font size="2">
              <select name="Hora">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}/*
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}*/
				}
				?>
              </select>
              <strong>:</strong>
              <select name="Minutos">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}/*
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}*/
				}
				?>
              </select>
              </font></font> </td>
		  </tr>
</table>
<br>
<?php
	echo "<table cellpadding='3' cellspacing='0' width='520' border='1' align='center'>";
	echo "<tr align='center' class='Detalle02'> hiiiii";
	//echo "<td colspan='2'>Lote_O&nbsp;<input type='text' name='TxtOrigen' size='6' value='".$LoteOrigen."' readonly></td>";
	echo "<td colspan='2'>Lote_O&nbsp;<input type='text' name='TxtOrigen' size='6' value='".$TxtLoteO."' readonly></td>";
	echo "<td colspan='2'>";
	echo "Peso_O&nbsp;<input type='text' name='TxtPesoO' size='8' value='".$TxtPesoO."' readonly>";
	echo "Peso_R&nbsp;<input type='text' name='TxtPesoR' size='8' value='".$TxtPesoR."' readonly>";
	echo "</td>";
	echo "<td colspan='2'>";
	echo "Unid_O&nbsp;<input type='text' name='TxtUnidO' size='4' value='".$TxtUnidO."' readonly>";
	echo "Unid_R&nbsp;<input type='text' name='TxtUnidR' size='4' value='".$TxtUnidR."' readonly>";
	echo "</table>";
	echo "<table cellpadding='3' cellspacing='0' width='520' border='1' align='center'>";
	echo "</td>";
	echo "</tr>";
	echo "<tr align='center' class='ColorTabla01'>";
	echo "<td>Fecha</td>";
	echo "<td>Guia</td>";
	echo "<td>Lote</td>";
	echo "<td>Recargo</td>";
	echo "<td>Peso</td>";
	echo "<td>Unid.</td>";
	echo "<td>Mod.</td>";
	echo "</tr>";
	$PesoPieza= round($TxtPesoO/$TxtUnidO);
	$TotPiezas=0;$TotPeso=0;
	$Consulta="select * from sipa_web.recepciones where lote='".str_pad($Lote,'8','0',STR_PAD_LEFT)."' and guia_despacho='".$Guia."' and peso_neto<>0 and tipo ='A'";
	//echo $Consulta."<br>";
	echo "<input type='hidden' name='TxtPesoNeto'>";
	echo "<input type='hidden' name='TxtUnid'>";
	echo "<input type='hidden' name='OptMod'>";
	$Pos=0;
	$Resp=mysqli_query($link, $Consulta);
	while($FilaDetalle=mysqli_fetch_array($Resp))
	{
		$Pos++;
		echo "<td>".$FilaDetalle["fecha"]."</td>";
		echo "<td>".$FilaDetalle["guia_despacho"]."&nbsp;</td>";
		echo "<td>".$FilaDetalle["lote"]."</td>";
		echo "<td>".$FilaDetalle["recargo"]."</td>";
		echo "<td align='center'><input type='text' name='TxtPesoNeto' size='10' value='".$FilaDetalle["peso_neto"]."' readonly></td>";
		echo "<td align='center'><input type='text' name='TxtUnid' size='4' value='".intval($FilaDetalle["observacion"])."' onblur=CalculaPeso(this,'".intval($FilaDetalle["observacion"])."','".$PesoPieza."','".$Pos."') disabled></td>";
		echo "<td><input name='OptMod' type='radio' onclick='HabilitarOpt(this,false,".$Pos.")'></td>";
		echo "</tr>";
		$TotPiezas=$TotPiezas+intval($FilaDetalle["observacion"]);
		$TotPeso=$TotPeso+intval($FilaDetalle["peso_neto"]);
	}
	echo "<tr class='Detalle01'>";
	echo "<td colspan='4'>&nbsp;</td>";
	echo "<td align='right'>".number_format($TotPeso,0,"",".")."</td>";
	echo "<td align='right'>".number_format($TotPiezas,0,"",".")."</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	echo "</table>";	
?>
<br>
<table cellpadding="3" cellspacing="0" width="520" border="1" align="center">
		  <tr>
			<td> <div align="center">
				<input name="btnmodificar" type="button" style="width:70;" value="Modificar" onClick="JavaScript:Modificar()" disabled> 
				<input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
				<input name="btnsalir" type="button" style="width:100" value="Cerra Ventana" onClick="self.close()">
			  </div></td>
		  </tr>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
