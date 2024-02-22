<?
	if(isset($CMBR))
	{
		$Actualiza="UPDATE sgrs_siperoperaciones set MRUTINARIA='".$Ruti."' where CAREA='".$CMBR."'";
		mysql_query($Actualiza);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function AgregarPeligro(Proceso,Opcion)
{
	//Mantenedor.TxtDescrip.value='';
	//Mantenedor.CmbTipo.style.visibility = 'visible';
	//Mantenedor.CmbTipo.value='S';
	
	//BloqueaIzq.style.visibility = 'visible';
	//BloqueaDer.style.visibility = 'visible';
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Tarea');
		return;
	}	
	AgregarPeligros.style.width = '90%';
	AgregarPeligros.style.visibility = 'visible';
	
}
function Cerrar()
{
	//BloqueaIzq.style.visibility = 'hidden';
	//BloqueaDer.style.visibility = 'hidden';
	AgregarPeligros.style.visibility = 'hidden';
	
}
function Grabar(Proceso)
{
	var PelCheck='';
	
	for (i=1;i<Mantenedor.elements.length;i++)
	{
		//alert(Mantenedor.elements[i].name);
		if (Mantenedor.elements[i].name=="CheckPel"&&Mantenedor.elements[i].checked)
		{	
			//alert(Mantenedor.elements[i].value);
			PelCheck = PelCheck + Mantenedor.elements[i].value +"~"+ Mantenedor.elements[i+1].value +"~"+ Mantenedor.elements[i+2].value+"//";
		}	
	}
	if(PelCheck=='')
	{
		alert('Debe Seleccionar Peligro');
		return;
	}	
	PelCheck = PelCheck.substring(0,(PelCheck.length-2));
	Mantenedor.DatosObsPel.value=PelCheck;
	Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+Mantenedor.DatosObsPel.value;
	top.frames['Procesos'].location='procesos.php?'+Cod;
}
function ModObs(Proceso)
{
	var f=document.Mantenedor;
	var Obs='';
	var Espe='';
	var Veri='';
	
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Tarea');
		return;
	}	
	for (i=1;i<Mantenedor.elements.length;i++)
	{
		//alert(Mantenedor.elements[i].name);
		if (Mantenedor.elements[i].name=="CodPel"&&Mantenedor.elements[i].value!='')
		{	
			Obs = Obs + Mantenedor.elements[i].value + "~@~" + Mantenedor.elements[i + 1].value + "//";
		}	
	}
	Obs = Obs.substring(0,(Obs.length-2));
	Mantenedor.DatosObsPel.value=Obs;
	Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosObsPel="+Mantenedor.DatosObsPel.value;
	top.frames['Procesos'].location='procesos.php?'+Cod;
	//Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//alert(Mantenedor.DatosObsPel.value);
	//f.action='procesos.php?'+Cod;
	//f.submit();

}
function ActivarPeligro(CodPel)
{
	if(confirm('Esta Seguro de Activar Peligro Seleccionado'))
	{
		Cod='Proceso=ACP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+Mantenedor.DatosObsPel.value+'&CodPel='+CodPel;
		top.frames['Procesos'].location='procesos.php?'+Cod;
	}	
}

function Contacto(CodPel,CodC)
{


}
function EliPeligro(CodPel)
{
	if(confirm('Esta Seguro de Eliminar Peligro Seleccionado'))
	{
		ObsElimina.style.visibility = 'hidden';
		var f=document.Mantenedor;
		f.CodPelGu.value=CodPel;
		//Transparente.style.visibility = 'visible';
/*		Cod='Proceso=EP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+Mantenedor.DatosObsPel.value+'&CodPel='+CodPel;
		URL='proceso_elimina_dato.php?'+Cod+'&Dato=EIP';//ELIMINA identidad de peligro
		window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
*/		//top.frames['Procesos'].location='procesos.php?'+Cod;

		//PROVISORIO ELIMINACION DIN ELECCION DE SUSTITUCION.
		Cod='Proceso=EP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+Mantenedor.DatosObsPel.value+'&CodPel='+CodPel+'&ObsEli='+top.frames['Procesos'].document.Mantenedor.ObsEli.value+'&TipoES=1';
		top.frames['Procesos'].location='procesos.php?'+Cod;
	}	
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	//Transparente.style.visibility = 'hidden';
}

function ConfirmaEliminar(CodPel)
{
	if(top.frames['Procesos'].document.Mantenedor.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		//document.Mantenedor.ObsEli.value.focus();
		return;
	}
	for (i=1;i<Mantenedor.elements.length;i++)
	{
		//alert(Mantenedor.elements[i].name);
		if (Mantenedor.elements[i].name=="Eliminacion"&&Mantenedor.elements[i].checked)
		{	
			var TipoES= Mantenedor.elements[i].value;
		}	
	}
	//alert(TipoES);
	//alert(document.Mantenedor.ObsEli.value);
	Cod='Proceso=EP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+Mantenedor.DatosObsPel.value+'&CodPel='+top.frames['Procesos'].document.Mantenedor.CodPelGu.value+'&ObsEli='+top.frames['Procesos'].document.Mantenedor.ObsEli.value+'&TipoES='+TipoES;
	top.frames['Procesos'].location='procesos.php?'+Cod;	
}
function ModPC(Cod,Val)
{	
	if(Val=='1')
	{
		alert('Peligro Validado, no se puede Modificar Probabilidad (P) o Consecuencia (C)');
		return;
	}
	URL='div_modifica_PC_ident_peligro.php?CodPeligro='+Cod+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	window.open(URL,"","top=200,left=500,width=400,height=200,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}
function ObsPeligros()
{
	var f=document.Mantenedor;
	URL='proceso_ident_peligros_obs.php?Peligros='+f.CodPelAgre.value;
	window.open(URL,"","top=300,left=500,width=630,height=500,status=no,menubar=no,resizable=yes,scrollbars=yes");
}
function CambiaRuti(CodSelTarea,Carea,Tipo)
{
	var f=document.Mantenedor;
	if(Tipo=='1')
		top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&MostrarCmb=S&Ruti=1&CMBR='+Carea+'&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	else
		top.frames['Procesos'].location='procesos_organica.php?TipoPestana=1&MostrarCmb=S&Ruti=0&CMBR='+Carea+'&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
}
</script>
<style>
.trans{
  background-color:#CCCCCC;
  color:#CC0000;
  position:absolute;
  text-align:center;
  top:0px;
  left:0px;
  padding:65px;
  font-size:25px;
  font-weight:bold;
  width:300px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="MantenedorPel" method="post">
  <input type="hidden" name="DatosObsPel" size="200" />
 
  <table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif" ></td>
	<td align="center">
		<table width="92%" border="0" cellpadding="0" cellspacing="4">
		<tr>
			<td align="left"><? echo DescripOrganica2($CodSelTarea);?></td>
			<td align="left"><label class="formulario"></label></td>
		    <td align="right">
			<?
			$CODAREA=ObtenerCodParent($CodSelTarea);	
			$Consulta1="SELECT MVALIDADO,MRUTINARIA from sgrs_siperoperaciones where CAREA='".$CODAREA."'";
			//echo $Consulta1."<br>";
			$Resultado1=mysql_query($Consulta1);
			$Fila1=mysql_fetch_array($Resultado1);
			$AREAVALID=$Fila1[MVALIDADO];
			$MRUTI=$Fila1[MRUTINARIA];
			if($AREAVALID=='0')
			{
				if($MRUTI=='1')
					echo "<span class='formulario'>Tarea Rutinaria&nbsp;</span><input type='checkbox' name='Ruti' class='SinBorde' checked='checked' onclick=javascript:CambiaRuti('".$CodSelTarea."','".$CODAREA."','0')>";
				else
					echo "<span class='formulario'>Tarea Rutinaria&nbsp;</span><input type='checkbox' name='Ruti' class='SinBorde' onclick=javascript:CambiaRuti('".$CodSelTarea."','".$CODAREA."','1')>";
					//"<a href=javascript:CambiaRuti('".$CodSelTarea."','".$CODAREA."','1')><img src='imagenes/cerrar1.png' alt='NO' border='0' width='19' align='absmiddle'></a>";	
			?>
				<a href="javascript:AgregarPeligro('AP','<? echo $CodSelTarea;?>')"><img src="imagenes/btn_agregar.png" alt='Agregar Peligros' border="0" align="absmiddle"></a>
				<a href="javascript:ModObs('MP')"><img src='imagenes/btn_guardar.png' alt='Guarda Descripci�n de Peligros' border='0' width='25' align='absmiddle'></a></td>
			<?
			}
			?>
		</tr>
		</table>
		<!--<table width="90%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="2%" class="TituloCabecera" >Elim.</td>
			<td width="45%" class="TituloCabecera" >Peligro</td>
			<td width="49%" class="TituloCabecera" >Observaciones / Comentarios</td>
		 </tr>
		 </table>-->
		  <div id='Resumen'  style='overflow:auto;WIDTH: 90%; height:360px;left:15px;top:65px;'>
		  <table width="100%" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="8%" align="center" class="TituloCabecera" >Elim.</td>
			<td width="9%" align="center" class="TituloCabecera" >Modi. MRi</td>
			<td width="25%" align="center" class="TituloCabecera" >Peligro</td>
			<td width="11%" align="center" class="TituloCabecera" >P</td>
			<td width="11%" align="center" class="TituloCabecera" >C</td>
			<td width="36%" align="center" class="TituloCabecera" >Descripci�n</td>
		  </tr>

		 <? 
			$CodOrganica=substr($CodSelTarea,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr=$LarArr)
					$CodOrganicaAux=$v;
				$ContArr++;	
			}
			$Cod=$CodOrganicaAux;$CodPelAgre="('-','";		
			$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO,t1.QPROBHIST,t1.QCONSECHIST,t1.MVALIDADO from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE<>'0' and t1.CAREA ='".$Cod."' order by NCONTACTO";
			//echo $Consulta."<br>";
			$Resultado=mysql_query($Consulta);
			echo "<input type='hidden' name='CodPel'><input type='hidden' name='ObsPel'>";
			while ($Fila=mysql_fetch_array($Resultado))
			{
				//echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">";
				echo "<tr>";
				echo "<td align='center' width='4%'><a href=javascript:EliPeligro('".$Fila[CPELIGRO]."')><img src='imagenes/btn_eliminar2.png' alt='Eliminar Peligro' border='0' width='20' align='absmiddle'></a></td>";
				echo "<td align='center' width='4%'>";
				if($Fila[MVALIDADO]==0)//ES CERO CUANDO NO ESTA VALIDADO
					echo "<a href=javascript:ModPC('".$Fila[CPELIGRO]."')><img src='imagenes/btn_modificar.png' alt='Modifica Prob. y Consec. Inicial.' border='0' width='20' align='absmiddle'></a>";
				else
					echo "<a href=javascript:ModPC('".$Fila[CPELIGRO]."','1')><img src='imagenes/btn_modificar.png' alt='Modifica Prob. y Consec. Inicial.' border='0' width='20' align='absmiddle'></a>";
				echo "</td>";
				echo "<td align='left' width='45%'>".$Fila[NCONTACTO]."</td>";
				echo "<td align='center'>".$Fila[QPROBHIST]."</td>";
				echo "<td align='center'>".$Fila[QCONSECHIST]."</td>";
				echo "<td align='center'><input type='hidden' name='CodPel' value='".$Fila[CPELIGRO]."~@~".$Fila[CCONTACTO]."'><textarea name='ObsPel' cols='60'>".trim($Fila[TOBSERVACION])."</textarea></td>";
				echo "</tr>";
				$CodPelAgre=$CodPelAgre.$Fila[CCONTACTO]."','";
			}
			$CodPelAgre=$CodPelAgre."')";
		 ?>
	    </table><br>
		 <?
			$CodOrganica=substr($CodSelTarea,1);
			$CodOrganica=substr($CodOrganica,0,strlen($CodOrganica)-1);
			$CodOrganica=explode(',',$CodOrganica);
			$LarArr=count($CodOrganica);$ContArr=1;$CodOrganicaAux=',';
			while(list($c,$v)=each($CodOrganica))
			{
				if($ContArr=$LarArr)
					$CodOrganicaAux=$v;
				$ContArr++;	
			}
			$Cod=$CodOrganicaAux;
			$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE='0' and t1.CAREA ='".$Cod."' group by t1.CCONTACTO order by NCONTACTO";
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);
			echo "<input type='hidden' name='CodPel'><input type='hidden' name='ObservacionPel'>";

			if($Fila=mysql_fetch_array($Resultado))
			{
		 		echo "<table width='97%' border='1' cellpadding='0' cellspacing='0'>";
				echo "<tr>";
				echo "<td width='2%' align='center' class='TituloCabecera'>Vig.</td>";
				echo "<td width='2%' align='center' class='TituloCabecera'>Eli.</td>";
				echo "<td width='45%' align='center' class='TituloCabecera'>Peligro No Vigentes</td>";
				echo "<td width='49%' align='center' class='TituloCabecera'>Observaciones / Comentarios</td>";
		  		echo "</tr>";
				$Consulta="SELECT t2.NCONTACTO,t1.TOBSERVACION,t1.CPELIGRO,t1.CCONTACTO from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where t1.MVIGENTE='0' and t1.CAREA ='".$Cod."' group by t1.CCONTACTO order by NCONTACTO";
				//echo $Consulta;
				$Resultado=mysql_query($Consulta);
				echo "<input type='hidden' name='CodPel'><input type='hidden' name='ObsPel'>";
				while ($Fila=mysql_fetch_array($Resultado))
				{
					echo "<tr>";
					echo "<td align='center' width='4%'><a href=javascript:ActivarPeligro('".$Fila[CPELIGRO]."')><img src='imagenes/acepta.png' alt='Activar Peligro' border='0' width='20' align='absmiddle'></a></td>";
					echo "<td align='center' width='4%'><a href=javascript:EliPeligro('".$Fila[CPELIGRO]."')><img src='imagenes/btn_eliminar2.png' alt='Eliminar Peligro' border='0' width='20' align='absmiddle'></a></td>";
					echo "<td align='left' width='45%'>".$Fila[NCONTACTO]."</td>";
					echo "<td align='center' width='49%'><input type='hidden' name='CodPel' value='".$Fila[CPELIGRO]."~@~".$Fila[CCONTACTO]."'><textarea name='ObservacionPel' cols='100' readonly>".trim($Fila[TOBSERVACION])."</textarea></td>";
					echo "</tr>";
				}
		   		echo "</table>";
			}
			?>			
		</div>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
  <div id='AgregarPeligros'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY:hidden; WIDTH: 1%; height:470px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 50px; top: 2px;'>
  <table width="100%" height="85%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="1%" height="1%"><img src="imagenes/interior/esq1.gif" ></td>
	<td width="97%" height="1%" background="imagenes/interior/form_arriba.gif"><img src="imagenes/interior/transparent.gif" ></td>
	<td width="1%" height="1%"><img src="imagenes/interior/esq2.gif"></td>
  </tr>
  <tr>
   <td width="1%" height="99%" background="imagenes/interior/form_izq.gif"></td>
   <td width="97%" height="99%" valign="top" align="center">
		<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		  <td align="left" width="30%"><label class="InputAzul">Tarea&nbsp;<img src="imagenes/vineta.gif" border="0">&nbsp;<? echo DescripOrganica($CodSelTarea,'T');?></label></td>
          <td align="center" width="40%"><span class="titulo_azul"><img src="imagenes/vineta.gif" border="0">Agregar Peligros</span></td>
		  <td align="right" width="30%">
		  	  <a href="JavaScript:Grabar('GP')"><img src="imagenes/btn_guardar.png" height="20" alt="Guardar" width="20" border="0" align="absmiddle" /></a> 
			  <a href="JavaScript:Cerrar()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle"></a> 
		  </td>
		</tr>   
		<tr>
		<td colspan="3" align='center' >
		</td>
		</tr>
	   </table>
		 <div id='Peligros'  style='overflow:auto;WIDTH: 90%; height:90%;left: 25px; top: 65px;'>
		 <table width="97%" border="1" cellpadding="0" cellspacing="0">
			<tr>
				<td width="4%" class="TituloCabecera" align="center" >Sel.</td>
				<td width="86%" class="TituloCabecera" align="center" >Codigos de Contactos (Peligros)&nbsp;&nbsp;<a href=JavaScript:ObsPeligros('')><img src='imagenes/obs.png' alt="Descripci�n de los Peligros" border=0 width='17' height='17'></a></td>
				<td width="86%" class="TituloCabecera" align="center" >P&nbsp;&nbsp;<a href='documento/Guia para calculo de la Magnitud de Riesgo Inicial.pdf' target="_blank"><img src='imagenes/obs.png' alt="Guia para calculo de la Magnitud de Riesgo Inicial" border=0 width='17' height='17'></a></td>
				<td width="86%" class="TituloCabecera" align="center" >C&nbsp;&nbsp;<a href='documento/Guia para calculo de la Magnitud de Riesgo Inicial.pdf' target="_blank"><img src='imagenes/obs.png' alt="Guia para calculo de la Magnitud de Riesgo Inicial" border=0 width='17' height='17'></a></td>
			 </tr>
			 <input type="hidden" name="CodPelAgre" size="100" value="<? echo $CodPelAgre;?>" />
		 <? //and CCONTACTO NOT IN ".$CodPelAgre."
			$Consulta="SELECT *,ceiling(CCONTACTO) as order_codigo from sgrs_codcontactos where MVIGENTE ='1' and MOPCIONAL='1' and NCONTACTO <> '' order by NCONTACTO";
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);echo "<input type='hidden' name='CheckPel'>";
			while ($Fila=mysql_fetch_array($Resultado))
			{
				$CmbProbH=$Fila[QPROBHIST];
				$CmbConsH=$Fila[QCONSECHIST];
				echo "<tr>";
					echo "<td align='center' width='4%'><input type='checkbox' name='CheckPel' value='".$Fila[CCONTACTO]."' class='SinBorde'></td>";
					echo "<td align='left' width='86%'>".$Fila[NCONTACTO]."</td>";
					echo "<td>";
					?>	
	                <SELECT name='CmbProbH'>
					<?
						switch($CmbProbH)
						{
							case "1":
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "2":
								echo "<option value='1'>1</option>";
								echo "<option value='2' SELECTed>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "4":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4' SELECTed>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "8":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8' SELECTed>8</option>";
							break;
							default:
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							
						}
				  
				    ?>
				    </SELECT>
				    <?
					echo "</td>";
			  		echo "<td>";
			  		?><SELECT name='CmbConsH'><?
			  		switch($CmbConsH)
					{
							case "1":
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "2":
								echo "<option value='1'>1</option>";
								echo "<option value='2' SELECTed>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "4":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4' SELECTed>4</option>";
								echo "<option value='8'>8</option>";
							break;
							case "8":
								echo "<option value='1'>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8' SELECTed>8</option>";
							break;
							default:
								echo "<option value='1' SELECTed>1</option>";
								echo "<option value='2'>2</option>";
								echo "<option value='4'>4</option>";
								echo "<option value='8'>8</option>";
							break;
						
					}
				    ?>
				    </SELECT>
				    <?					
					echo "</td>";
				echo "</tr>";
			}
		 ?>
		 </table></div>
	 </td>
	 <td width="1%" height="99%" background="imagenes/interior/form_der.gif"></td>
  </tr>
    <tr>
	<td width="1%" height="1%"><img src="imagenes/interior/esq3.gif" ></td>
	<td width="1%" height="1%" background="imagenes/interior/form_abajo.gif"><img src="imagenes/interior/transparent.gif" ></td>
	<td width="1%" height="1%"><img src="imagenes/interior/esq4.gif" ></td>
  </tr>
  </table>
  </div>
<?
include('div_obs_elimina3.php');
?>    
</form>
</body>
</html>