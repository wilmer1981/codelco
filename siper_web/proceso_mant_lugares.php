<?
include('conectar_ori.php');
	 
	/*$Cont=1;$CodNiveles=0;
	$Codigos=explode(',',$CodSelTarea);
	while(list($c,$v)=each($Codigos))
	{
		if($v!=''&&$v!='0')
		{
			$Consulta="SELECT CTAREA from sgrs_areaorg where CAREA='".$v."'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			if($CodNiveles<$Fila[CTAREA])
				$CodNiveles=$Fila[CTAREA];
		}	
	}
	//echo "ITEM SELEC:".$CodSelTarea."<br>";
	$CodOrganica=substr($CodSelTarea,1);
	$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
	$CodOrganica=explode(',',$CodOrganica);
	$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
	while(list($c,$v)=each($CodOrganica))
	{
		if($ContArr=$LarArr)
			$CodOrganicaAux=$v;
		$ContArr++;	
	}*/
	if($VisibleDivProceso=='S')
		$VisibleDiv='hidden';
	
?>
<script language="javascript">
function AgregarLugar(Proceso)
{
	/*if(top.frames['Procesos'].document.Mantenedor.NivelSel.value!='5')
	{
		alert('Debe Seleccionar Unidad Operativa');
		return;
	}*/
	top.frames['Procesos'].document.Mantenedor.Proc.value=Proceso;
	DivProceso.style.visibility = 'visible';
	DivBtnProc.style.visibility = 'visible';
}
function Volver()
{
	top.frames['Procesos'].location='procesos_mantenedor.php?MostrarCmb=S&TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
}
function ModificarLugar(Proceso)
{
	var f=document.Mantenedor;
	var Datos='';
	top.frames['Procesos'].document.Mantenedor.Proc.value=Proceso;
	if(SoloUnElemento(f.name,'CheckLugar','M'))
	{
		DivBtnProc.style.visibility = 'visible';
		Datos=Recuperar(f.name,'CheckLugar');
		top.frames['Procesos'].document.Mantenedor.DatosLugar.value=Datos;
		Cod='Proc=MLUG&VisibleDivProceso=visible&DatosLugar='+Datos+'&CodSelTarea=='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
		//alert(DatosLugar);
		top.frames['Procesos'].location='procesos_lugares.php?'+Cod;
	}	
	
	//DivProceso.style.visibility = 'visible';
	//top.frames['Procesos'].location='procesos.php?'+Cod;		
}
function Grabar(Proceso,CodParent)
{
	var f=document.Mantenedor;
	var Cod='';
	var Vigente='';
	var Datos='';
	
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Nivel del Item a Agregar');
		return;
	}
	if(top.frames['Procesos'].document.Mantenedor.TxtNombre.value=='')
	{
		alert('Debe Ingresar Descripcion del Lugar');
		top.frames['Procesos'].document.Mantenedor.TxtNombre.focus();
		return;		
	}
	if(top.frames['Procesos'].document.Mantenedor.TxtCCORDX.value=='')
	{
		alert('Debe Ingresar Coordenada X');
		top.frames['Procesos'].document.Mantenedor.TxtCCORDX.focus();
		return;		
	}	
	if(top.frames['Procesos'].document.Mantenedor.TxtCCORDY.value=='')
	{
		alert('Debe Ingresar Coordenada Y');
		top.frames['Procesos'].document.Mantenedor.TxtCCORDY.focus();
		return;		
	}	
	if(top.frames['Procesos'].document.Mantenedor.TxtCCORDZ.value=='')
	{
		alert('Debe Ingresar Coordenada Z');
		top.frames['Procesos'].document.Mantenedor.TxtCCORDZ.focus();
		return;		
	}					
	if(top.frames['Procesos'].document.Mantenedor.rdvigente[0].checked==true)
		Vigente='1';
	else
		Vigente='0';
	if(top.frames['Procesos'].document.Mantenedor.Proc.value=='MLUG')
		Datos=Recuperar(f.name,'CheckLugar');
	Cod='Vigente='+Vigente+'&Proceso='+top.frames['Procesos'].document.Mantenedor.Proc.value+'&Descrip='+top.frames['Procesos'].document.Mantenedor.TxtNombre.value+'&CX='+top.frames['Procesos'].document.Mantenedor.TxtCCORDX.value+'&CY='+top.frames['Procesos'].document.Mantenedor.TxtCCORDY.value+'&CZ='+top.frames['Procesos'].document.Mantenedor.TxtCCORDZ.value+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&DatosLugar='+Datos;
	//alert(Cod);
	f.action='procesos.php?'+Cod;
	f.submit();	
}
function EliminarLugar(Proceso)
{
	var f=document.Mantenedor;
	var Cod='';
	
	if(SoloUnElemento(f.name,'CheckLugar','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{
			DatosLugar=Recuperar(f.name,'CheckLugar');
			Cod='Proceso=ELUG&DatosLugar='+DatosLugar;
			//alert(DatosLugar);
			top.frames['Procesos'].location='procesos.php?'+Cod;
		}
	}	
	
}
function CloseDiv()
{
	DivProceso.style.visibility='hidden';
	DivBtnProc.style.visibility = 'hidden';
}

</script>
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
<td width="5" background="imagenes/tab_separator.gif"></td>
<td valign="top">
	 <div id='Mant'  style='overflow:auto;WIDTH: 90%; left: 15px; top: 65px;'>
	<table width="100%" border="0" cellpadding="0" cellspacing="4">
	<tr>
	<td align="right">
	</td>
	<td width="74%" align="left"><? echo DescripOrganicaHi($CodSelTarea);?></td>
	<td width="14%" align="right" nowrap="nowrap"><div id="DivBtnProc" style="visibility:hidden; FILTER: alpha(opacity=100); position:absolute; width:auto; height:auto"><table border='0' width="80px" height="30px"><tr><td>&nbsp;</td></tr></table></div>
	<a href="javascript:AgregarLugar('ALUG')"><img src="imagenes/btn_agregar.png" alt='Agregar Lugar de Medici�n' border="0" align="absmiddle"></a>
	<a href="javascript:ModificarLugar('MLUG')"><img src="imagenes/btn_modificar.png" alt='Modificar Lugar de Medici�n' border="0" width="25" align="absmiddle"></a>
	<a href="javascript:EliminarLugar('ELUG')"><img src="imagenes/btn_eliminar2.png" alt='Eliminar Lugar de Medici�n' border="0" align="absmiddle"></a>
	</td>
	</tr>
	<tr>
	<td></td>
	<td colspan="2"></td>
	</tr></table></div>
			  <div id='Resumen'  style='overflow:auto;WIDTH: 90%; height:360px;left:15px;top:65px;'>
		  <table width="97%" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="2%" class="TituloCabecera" >Sel.</td>
			<td width="45%" class="TituloCabecera" >Descripci�n Lugar</td>
			<td width="15%" class="TituloCabecera" >COORD (X)</td>
			<td width="15%" class="TituloCabecera" >COORD (Y)</td>
			<td width="15%" class="TituloCabecera" >COORD (Z)</td>
		  </tr>

		 <? 
			$Consulta="SELECT * from sgrs_lugares where MVIGENTE='1' and CAREA ='".$CodSelTarea."' order by NLUGAR";
			//echo $Consulta;
			$Resultado=mysqli_query($link, $Consulta);echo "<input type='hidden' name='CheckLugar'>";
			echo "<input type='hidden' name='CodPel'>";
			while ($Fila=mysql_fetch_array($Resultado))
			{
				echo "<tr>";
				echo "<td align='center' width='4%'><input type='checkbox' name='CheckLugar' class='SinBorde' value='".$Fila[CLUGAR]."'></td>";
				echo "<td align='left' width='45%'>".$Fila[NLUGAR]."</td>";
				echo "<td align='center' width='15%'>".trim($Fila[CCORDX])."</td>";
				echo "<td align='center' width='15%'>".trim($Fila[CCORDY])."</td>";
				echo "<td align='center' width='15%'>".trim($Fila[CCORDZ])."</td>";
				echo "</tr>";
			}
		 ?>
	    </table></div>
<? 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
else
		
?>		
		<div id="DivProceso" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto; POSITION: absolute; moz-opacity: .75; opacity: .75;left: 210px; top:60px; width:650px; height:230px;" align="center">
<table width="55%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td ><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td ><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td align="center"><table width="403" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td  colspan="2"align="right"><a href="JavaScript:Grabar('ALUG')"><img src="imagenes/btn_guardar.png"  border="0"  alt="Grabar" align="absmiddle" /></a><a href="JavaScript:CloseDiv()"><img src="imagenes/cerrar1.png"  border="0"  alt="Cerrar" align="absmiddle" /></a></td>
      </tr>
	  <tr>
	  
	  <? 
	  	if($Proc=='MLUG')
		{
			
			$Consulta="Select * from sgrs_lugares where CLUGAR='".$DatosLugar."' ";
			//echo $Consulta;
			$Resp1 = mysqli_query($link, $Consulta);
			if ($Fila1=mysql_fetch_array($Resp1))
			{
			 $TxtNombre=$Fila1[NLUGAR];
			 $TxtCCORDX=$Fila1[CCORDX];
			 $TxtCCORDY=$Fila1[CCORDY];
			 $TxtCCORDZ=$Fila1[CCORDZ];
			 $Vigente=$Fila1[MVIGENTE];
			}
		}
		else
		{
		 	$TxtNombre='';
			$TxtCORDX='';
			$TxtCORDY='';
			$TxtCORDZ='';
			//$Vigente='';
		}
	  ?>
	  
	  
        <td class="formulario" align="left">Descripci�n:</td>
		<td align="left"> <input name="TxtNombre" type="text" id="TxtNombre" value="<? echo $TxtNombre; ?>" size="60"  maxlength="100"/>&nbsp;<span class="InputRojo">(*)</span></td>
      </tr>
	    <tr>
        <td class="formulario" align="left">COORD(X):</td>
		<td align="left"> <input name="TxtCCORDX" type="text" value="<? echo $TxtCCORDX; ?>" size="15"  maxlength="10" >&nbsp;<span class="InputRojo">(*)</span></td>
      </tr>
	   <tr>
        <td class="formulario" align="left">COORD(Y):</td>
		<td align="left"> <input name="TxtCCORDY" type="text" value="<? echo $TxtCCORDY; ?>" size="15"  maxlength="10" >&nbsp;<span class="InputRojo">(*)</span></td>
		</tr>
	   <tr>
        <td class="formulario" align="left">COORD(Z):</td>
		<td align="left"> <input name="TxtCCORDZ" type="text" value="<? echo $TxtCCORDZ; ?>" size="15"  maxlength="10" >&nbsp;<span class="InputRojo">(*)</span></td>
		</tr>

	   <tr>
        <td class="formulario" align="left">Vigente:</td>
		<td class="formulario" align="left">
		<? 
		if(!isset($Vigente))
			$Vigente='1';
		if($Vigente=='1')
		{?>Si<input name="rdvigente" type="radio" id="rdvigente" class="SinBorde" checked="checked" >&nbsp;&nbsp;No<input name="rdvigente" type="radio" id="rdvigente" class="SinBorde"  >
		<?
		}
		else
		{?>
			Si<input name="rdvigente" type="radio" id="rdvigente"  class="SinBorde" >&nbsp;&nbsp;No<input name="rdvigente" type="radio" id="rdvigente"  checked="checked"  class="SinBorde" >
		<? }	?>
		</td>
      </tr>
       </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>
</div>

</td>
<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>