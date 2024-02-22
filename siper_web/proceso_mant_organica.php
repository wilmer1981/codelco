<?
include('conectar_ori.php');
	 
	$Cont=1;$CodNiveles=0;$CodNivelesAux=0;
	$Codigos=explode(',',$CodSelTarea);
	while(list($c,$v)=each($Codigos))
	{
		if($v!=''&&$v!='0')
		{
			$Consulta="SELECT CTAREA from sgrs_areaorg where CAREA='".$v."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$CodNivelesAux=$CodNiveles;
			if($CodNiveles<$Fila[CTAREA])
				$CodNiveles=$Fila[CTAREA];
			$Consulta="SELECT min(CTAREA) as tarea_menor from sgrs_areaorg where CPARENT like '".$CodSelTarea."%' and CAREA<>'".$v."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
			$NivelInferior=$Fila[tarea_menor];
			$NivelSuperior=$CodNivelesAux;			
		}	
	}
	//echo "NIVEL SUPERIOR: ".$NivelSuperior."<BR>";
	//echo "NIVEL SELECCIO: ".$CodNiveles."<BR>";
	//echo "NIVEL INFERIOR: ".$NivelInferior."<BR>";
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
	}
	//$CheckedRut="checked";
	$Parent=$CodOrganicaAux;
	$Consulta="SELECT t1.NAREA,t1.CTAREA,t2.NORGANICA,t2.CORGANICA,t3.MRUTINARIA,t1.MVIGENTE from sgrs_areaorg t1 inner join sgrs_organica t2 on t1.ctarea=t2.corganica left join sgrs_siperoperaciones t3 on t1.CAREA=t3.CAREA where t1.CAREA ='".$Parent."' ";
	$Resp=mysql_query($Consulta);
	$Fila=mysql_fetch_array($Resp);	
	$TxtDescrip=$Fila[NAREA];$CheckedRut='checked';$LabelRut='hidden';$CheckedVig="checked";
	if($MostrarCmb=='S')
	{
		$NombreTipo=$Fila[NORGANICA];
		$CodTipo=$Fila[CORGANICA];
		if($Fila[CTAREA]==8)
		{
			$LabelRut='visible';
			if($Fila[MRUTINARIA]=='1')
				$CheckedRut="checked";
			else
				$CheckedRut="";
			if($Fila[MVIGENTE]=='1')
				$CheckedVig="checked";
			else
				$CheckedVig="";
		}
	}
	else
		$NombreTipo='';
?>
<script language="javascript">
function AgregarItem(Proceso,Opcion)
{
	Mantenedor.TxtDescrip.value='';
	Mantenedor.CmbTipo.style.visibility = 'visible';
	Mantenedor.CmbTipo.value='S';
	Mantenedor.CmbTipo2.style.visibility = 'hidden';
	Mantenedor.CmbTipo2.value='';
		
	BtnAgregar.style.visibility = 'visible';
	BtnGeneral.style.visibility = 'hidden';
	DescripTipo.style.visibility = 'hidden';
	LblNombreTipo.style.visibility = 'hidden';
}
function MoverItem(Proceso,Opcion)
{
	window.open("proceso_mant_organica_mover.php","","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes");
}
function Volver()
{
	Mantenedor.TxtDescrip.value='';
	Mantenedor.CmbTipo.value='S';
	BtnAgregar.style.visibility = 'hidden';
	BtnGeneral.style.visibility = 'visible';
	Mantenedor.CmbTipo.style.visibility = 'hidden';
	DescripTipo.style.visibility = 'visible';
	LblNombreTipo.style.visibility = 'visible';
	LblRutinarios.style.visibility = 'hidden';
	Mantenedor.CheckRutinaria.style.visibility = 'hidden';
	top.frames['Procesos'].location='procesos_mantenedor.php?MostrarCmb=S&TipoPestana=1&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
}
function ModificarItem(Proceso,Opcion)
{
	var f=document.Mantenedor;

	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Nivel del Item a Agregar');
		return;
	}
	if(top.frames['Procesos'].document.Mantenedor.TxtDescrip.value=='')
	{
		alert('Debe Ingresar Descripcion del Item');
		top.frames['Procesos'].document.Mantenedor.TxtDescrip.focus();
		return;		
	}
	Rutinario=0;
	if(Mantenedor.CheckRutinaria.checked==true)
		Rutinario=1;		
	Vigente=0;
	if(Mantenedor.CheckVigente.checked==true)
		Vigente=1;		
	var mensaje=confirm('�Desea Cambiar Nombre de Nivel?')
	if(mensaje==true)
	{
		//Cod='Rutinario='+Rutinario+'&Descrip='+top.frames['Procesos'].document.Mantenedor.TxtDescrip.value+'&Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
		//top.frames['Procesos'].location='procesos.php?'+Cod;
		Cod='Rutinario='+Rutinario+'&Vigente='+Vigente+'&Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&Tipo='+top.frames['Procesos'].document.Mantenedor.CmbTipo2.value;
		f.action='procesos.php?'+Cod;
		f.submit();
	}		
}
function Grabar(Proceso,CodParent)
{
	var f=document.Mantenedor;
	var Cod='';
	
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Nivel del Item a Agregar');
		return;
	}
	if(top.frames['Procesos'].document.Mantenedor.TxtDescrip.value=='')
	{
		alert('Debe Ingresar Descripcion del Item');
		top.frames['Procesos'].document.Mantenedor.TxtDescrip.focus();
		return;		
	}	
	if(top.frames['Procesos'].document.Mantenedor.CmbTipo.value=='S')
	{
		alert('Debe Seleccionar Tipo Nivel');
		top.frames['Procesos'].document.Mantenedor.CmbTipo.focus();
		return;		
	}
	Rutinario=0;
	if(Mantenedor.CheckRutinaria.checked==true)
		Rutinario=1;
	Vigente=0;
	if(Mantenedor.CheckVigente.checked==true)
		Vigente=1;		

	//Cod='Rutinario='+Rutinario+'&MostrarCmb=N&Descrip='+top.frames['Procesos'].document.Mantenedor.TxtDescrip.value+'&Parent='+CodParent+'&Proceso='+Proceso+'&Tipo='+top.frames['Procesos'].document.Mantenedor.CmbTipo.value+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//top.frames['Procesos'].location='procesos.php?'+Cod;
	Cod='Rutinario='+Rutinario+'&Vigente='+Vigente+'&MostrarCmb=N&Parent='+CodParent+'&Proceso='+Proceso+'&Tipo='+top.frames['Procesos'].document.Mantenedor.CmbTipo.value+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	f.action='procesos.php?'+Cod;
	f.submit();	
}
function EliminarItem(Proceso,CodParent)//PARA MOSTRAR EL DIV EN PANTALLA
{
	var f=document.Mantenedor;
	var Cod='';
	
	if(confirm('Esta Seguro de Eliminar El Item Seleccionado'))
	{		
		ObsElimina.style.visibility = 'visible';
		Transparente.style.visibility = 'visible';
		
		/*Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
		URL='proceso_elimina_dato.php?'+Cod+'&Dato=EMO';//ELIMINA MANTENEDOR ORGANICA
		window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");		
		//top.frames['Procesos'].location='procesos.php?'+Cod;*/
	}
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	Transparente.style.visibility = 'hidden';
}

function ConfirmaEliminar()
{
	var f=document.Mantenedor;
	if(f.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		f.ObsEli.focus();
		return;
	}
	Cod='Proceso=EI&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&ObsEli='+f.ObsEli.value+'&Tipo='+top.frames['Procesos'].document.Mantenedor.TipoMod.value;
	top.frames['Procesos'].location='procesos.php?'+Cod;	
}
function Activa()
{
	if(Mantenedor.CmbTipo.value==8)
	{
		Mantenedor.CheckRutinaria.style.visibility = 'visible';
		LblRutinarios.style.visibility = 'visible';
	}
	else
	{
		Mantenedor.CheckRutinaria.style.visibility = 'hidden';
		LblRutinarios.style.visibility = 'hidden';
	}	
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
	<td width="74%" align="right">
	<div id="BtnAgregar"  style="visibility:hidden; position:inherit;">
	<a href="javascript:Grabar('GI','<? echo $CodSelTarea;?>')"><img src="imagenes/btn_guardar.png" alt='Grabar Item' border="0" align="absmiddle"></a>
	<a href="javascript:Volver()"><img src="imagenes/btn_volver.png" alt='Volver' border="0" width="25" align="absmiddle"></a></div></td>
	<td width="14%" align="right"><div id="BtnGeneral" style="visibility:visible; position:inherit;" >
	<a href="javascript:AgregarItem('AI','<? echo $CodSelTarea;?>')"><img src="imagenes/btn_agregar.png" alt='Agregar Item' border="0" align="absmiddle"></a>
	<a href="javascript:ModificarItem('MI')"><img src="imagenes/btn_modificar.png" alt='Modificar Item' border="0" width="25" align="absmiddle"></a>
	<a href="javascript:MoverItem('MN')"><img src="imagenes/btn_mover_arbol.png" alt='Mover Niveles' border="0" width="25" align="absmiddle"></a>
	<a href="javascript:EliminarItem('EI','<? echo $CodSelTarea;?>')"><img src="imagenes/btn_eliminar2.png" alt='Eliminar Item' border="0" align="absmiddle"></a></div>
	</td>
	</tr>
	 <tr>
	   <td width="12%" class="formulario" align="left">&nbsp;Descripci�n</td>
	   <td colspan="2" align="left"><input name="TxtDescrip" type="text" class="InputIzq" value="<? echo $TxtDescrip; ?>" size="70" maxlength="70" /> </tr>
	  <div id="DescripTipo"  style="visibility:visible; position:relative; position:relative">
	 <tr>
	   <td width="12%" class="formulario" align="left">&nbsp;Tipo</td>
	   <td colspan="2" align="left" class="formulario"><input type="hidden" name="TipoMod" value="<? echo $CodTipo;?>" /><label id="LblNombreTipo" style="visibility:visible; width:auto"><? echo trim($NombreTipo)." ".$Rutinaria;?></label>
	   <SELECT name="CmbTipo" style="visibility:hidden" onChange="Activa()">
	   <option value="S">Seleccionar</option>
	   <? 
			if(intval($CodNiveles)=='5')//UNIDAD
				$Consulta="SELECT * from sgrs_organica where CORGANICA<>0 and CORGANICA IN ('4','5','6','7','8')  order by orden";
			else
				$Consulta="SELECT * from sgrs_organica where CORGANICA<>0 and CORGANICA > ".intval($CodNiveles)." order by orden";
			$RespTipo=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($RespTipo))
			{
				if($CmbTipo==$Fila[CORGANICA])
					echo "<option value='".$Fila[CORGANICA]."' SELECTed>".$Fila[NORGANICA]."</option>";
				else
					echo "<option value='".$Fila[CORGANICA]."'>".$Fila[NORGANICA]."</option>";	
			}
	   ?>
	   </SELECT>
	   <? //echo "1:   ".$Consulta;?>
	   <SELECT name="CmbTipo2" style="visibility:" onChange="Activa()">
	   <option value="S">Seleccionar</option>
	   <? 
			$Consulta="SELECT * from sgrs_organica where CORGANICA not in (0,'".$CodNiveles."') and (CORGANICA > ".intval($NivelSuperior)." and CORGANICA <  ".intval($NivelInferior).") order by orden";
			$RespTipo=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($RespTipo))
			{
				if($CmbTipo2==$Fila[CORGANICA])
					echo "<option value='".$Fila[CORGANICA]."' SELECTed>".$Fila[NORGANICA]."</option>";
				else
					echo "<option value='".$Fila[CORGANICA]."'>".$Fila[NORGANICA]."</option>";	
			}
	   ?>
	   </SELECT>
	   <? //echo "2:   ".$Consulta;?>

	   <label id="LblRutinarios" style="visibility:<? echo $LabelRut;?>">
	   <input type="checkbox" name="CheckRutinaria" value="checkbox" class="SinBorde" <? echo $CheckedRut;?>>
	   Rutinario&nbsp;&nbsp;&nbsp;
	   <input type="checkbox" name="CheckVigente" value="checkbox" class="SinBorde" <? echo $CheckedVig;?>>
	   Vigente
	   </label></td>
		</div>
	 <tr>
	<td></td>
	<td colspan="2"></td>
	</tr></table></div>
</td>
<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
<?
include('div_obs_elimina.php');
?>