<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');

if(isset($Pantalla))
	acceso($CookieRut,$Pantalla);
?>
<html>
<head>
<title>SASSO - Restricci�n de acceso a Gerencias</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "N":
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='N';
				f.Datos.value=Datos;
				f.action='acceso_organica.php?VisibleDivProceso=S&Buscar=S';
				f.submit();		
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='M';
				f.Datos.value=Datos;
				f.action='acceso_organica.php?VisibleDivProceso=S&Buscar=S';
				f.submit();				
			}	
		break;
		case "G":
			//var Corr=f.correos.value.split(",");
			if(f.CmbJefe.value!='N')
			{
				if(f.correos.value=='')
				{
					alert('Debe Ingresar Mail de Usuario Seleccionado');
					f.correos.focus();
					return;
				}
			}
			/*else
			{
				alert('Debe Seleccionar Jefe Area')
				return;
			}*/
			if(f.CmbExperto.value!='N')
			{
				if(f.correos2.value=='')
				{
					alert('Debe Ingresar Mail de Usuario Seleccionado');
					f.correos2.focus();
					return;
				}
			}
			/*else
			{
				alert('Debe Seleccionar Experto')
				return;
			}*/
			if(f.correos.value!='')
			{				
				var Corr=f.correos.value.split(',');
				//alert(Corr.length)
				for(i=0;i<=Corr.length;i++)
				{
					if(Corr[i]!='')
					{
						if (typeof Corr[i] != "undefined")
						{
							var Corr2=validarEmail(Corr[i]);
							if(Corr2==false)
							{
								alert('Correo '+Corr[i]+' no es correcto');				
							}
						}
					}
				}	
				if(Corr2==false)
					return;		
			}
			/*if(f.correos2.value!='')
			{				
				var Corr=f.correos2.value.split(',');
				//alert(Corr.length)
				for(i=0;i<=Corr.length;i++)
				{
					if(Corr[i]!='')
					{
						if (typeof Corr[i] != "undefined")
						{
							var Corr2=validarEmail(Corr[i]);
							if(Corr2==false)
							{
								alert('Correo '+Corr[i]+' no es correcto');				
							}
						}
					}
				}	
				if(Corr2==false)
					return;		
			}*/
			if(SoloUnElemento(f.name,'CheckGer','N'))
			{
				DatosGer=Recuperar(f.name,'CheckGer');
				DivProceso.style.visibility='hidden';
				f.action='acceso_organica01.php?Proceso='+f.Proc.value+'&DatosGer='+DatosGer;
				f.submit();				
			}	
		break;
/*		case "E":
			if(SoloUnElemento(f.name,'CheckRut','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					DatosRut=Recuperar(f.name,'CheckRut');
					URL='proceso_elimina_dato.php?Proceso=E&Parent='+DatosRut+'&Dato=EAO';//ELIMINA ACCESO ORGANICA
					window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
					//f.action='acceso_organica01.php?Proceso=E&DatosRut='+DatosRut;
					//f.submit();
				}
			}	
		break;*/
		case "C":
				f.action='acceso_organica.php?Buscar=S';
				f.submit();		
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
		break;
	}	
}
function EliminarItem()//PARA MOSTRAR EL DIV EN PANTALLA
{
	var f=document.FrmPrincipal;
	var Cod='';
	
	if(SoloUnElemento(f.name,'CheckRut','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{
			DatosRut=Recuperar(f.name,'CheckRut');
			ObsElimina.style.visibility = 'visible';
			Transparente.style.visibility = 'visible';
//			URL='proceso_elimina_dato.php?Proceso=E&Parent='+DatosRut+'&Dato=EAO';//ELIMINA ACCESO ORGANICA
//			window.open(URL,"","top=30,left=30,width=500,height=300,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			//f.action='acceso_organica01.php?Proceso=E&DatosRut='+DatosRut;
			//f.submit();
		}
	}	
}
function CerrarDiv()
{
	ObsElimina.style.visibility = 'hidden';
	Transparente.style.visibility = 'hidden';
	DivProceso.style.visibility='hidden';
}
function ConfirmaEliminar()
{
	var f=document.FrmPrincipal;
	if(f.ObsEli.value=='')
	{
		alert('Debe Ingresar Observaci�n de Eliminaci�n');
		f.ObsEli.focus();
		return;
	}
	DatosRut=Recuperar(f.name,'CheckRut');
	f.action='acceso_organica01.php?Proceso=E&DatosRut='+DatosRut;
	f.submit();
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<? echo $Datos;?>">
<input name="Proc" type="hidden" value="<? echo $Proc;?>">
<table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
       <td height="35" colspan="4" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td colspan="2" align="right" class="formulario" ><a href="JavaScript:Proceso('C')"></a>&nbsp; <a href="JavaScript:Proceso('N')"><img src="imagenes/btn_agregar.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('M')"><img src="imagenes/btn_modificar.png" alt="Modificar" width="30" height="30" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:EliminarItem()"><img src="imagenes/btn_eliminar2.png"  alt="Eliminar" width="25" height="25" border="0" align="absmiddle"></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a> </td>
     </tr>
     <tr>
       <td width="3%" class="formulario">Rut</td>
       <td width="26%" class="formulario"><input name="TxtRut" type="text" id="TxtRut"  size="30" />
         <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="20" height="20"  border="0" align="absmiddle" /></a></td>
       <td class="formulario">Apellido Paterno </td>
       <td width="21%" class="formulario"><input name="TxtApePat" type="text" id="TxtApePat" value="<? //echo $TxtRegic; ?>" />
         <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="20" height="20"  border="0" align="absmiddle" /></a></td>
       <td width="16%" class="formulario">&nbsp;</td>
       <td width="16%" class="formulario">&nbsp;</td>
       <? 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		  
		  ?>
     </tr>
     <tr>
       <td class="formulario">&nbsp;</td>
       <td class="formulario">&nbsp;</td>
       <td width="18%" class="formulario">&nbsp;</td>
       <td colspan="3" class="formulario">&nbsp;</td>
     </tr>
   </table></td>
   <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
  </table><br>	
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td width="3%" class="TituloCabecera"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckRut','ChkTodos');"></td>
        <td width="10%" align="center" class="TituloCabecera">Rut</td>
        <td width="15%" align="center" class="TituloCabecera">Nombres</td>
        <td width="15%" align="center" class="TituloCabecera">Apellidos</td>
        <td width="10%" align="center" class="TituloCabecera">Perfil Sistema</td>
        <td width="20%" align="center" class="TituloCabecera">Usuario Jefe</td>
        <td width="10%" align="center" class="TituloCabecera">Correo<br>"Fin Iden. Pelig"<br>Jefe Area</td>
        <td width="25%" align="center" class="TituloCabecera">Usuario Experto</td>
		<td width="10%" align="center" class="TituloCabecera">Correo<br>"Fin Iden. Pelig"<br>Experto</td>
        <td width="27%" align="center" class="TituloCabecera">Gerencias Asignadas</td>
      </tr>
      <?
		if($Buscar=='S')
		{
			$Consulta = "SELECT t1.rut,t1.cod_gerencias,t1.AVISO_CORREO,t1.AVISO_CORREO2,t1.RUT_JEFE,t1.RUT_EXPERTO,t2.apellido_paterno,t2.apellido_materno,t2.nombres,t4.descripcion from sgrs_acceso_organica t1";
			$Consulta.= " inner join proyecto_modernizacion.funcionarios t2  on t1.rut=t2.rut";
			$Consulta.= " inner join proyecto_modernizacion.sistemas_por_usuario t3 on t2.rut=t3.rut";
			$Consulta.= " inner join proyecto_modernizacion.niveles_por_sistema t4 on t3.cod_sistema=t4.cod_sistema and t3.nivel=t4.nivel";
			$Consulta.=" where not isnull(t1.rut)  and t3.cod_sistema='29'";
			if($TxtRut!='')
				$Consulta.= " and t1.rut= '".$TxtRut."' ";
			if($TxtApePat!='')
				$Consulta.= " and t2.apellido_paterno like ('%".strtoupper($TxtApePat)."%') ";
			$Consulta.= " order by t2.apellido_paterno,t2.apellido_materno";	
			//echo 	$Consulta;
			$Resp = mysql_query($Consulta);
			echo "<input name='CheckRut' type='hidden'  value=''>";
			$cont=1;
			while ($Fila=mysql_fetch_array($Resp))
			{
				$ConsulNomJE="SELECT * FROM proyecto_modernizacion.sistemas_por_usuario t1 inner join proyecto_modernizacion.funcionarios t2 on t1.rut=t2.rut";
				$ConsulNomJE.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t1.cod_sistema=t3.cod_sistema";
				$ConsulNomJE.=" WHERE  t2.rut='".$Fila[RUT_JEFE]."' order by t2.apellido_paterno";
				$Resp2 = mysql_query($ConsulNomJE);
				if($Fila2=mysql_fetch_array($Resp2))
					$NombreJEFE=$Fila["RUT_JEFE"]." - ".$Fila2["apellido_paterno"]." ".$Fila2["apellido_materno"]." ".$Fila2["nombres"];
				else
					$NombreJEFE='';			
				$ConsulNomEX="SELECT * FROM proyecto_modernizacion.sistemas_por_usuario t1 inner join proyecto_modernizacion.funcionarios t2 on t1.rut=t2.rut";
				$ConsulNomEX.=" inner join proyecto_modernizacion.niveles_por_sistema t3 on t1.cod_sistema=t3.cod_sistema";
				$ConsulNomEX.=" WHERE  t2.rut='".$Fila[RUT_EXPERTO]."' order by t2.apellido_paterno";
				$Resp3 = mysql_query($ConsulNomEX);
				if($Fila3=mysql_fetch_array($Resp3))
					$NombreEXPERTO=$Fila["RUT_EXPERTO"]." - ".$Fila3["apellido_paterno"]." ".$Fila3["apellido_materno"]." ".$Fila3["nombres"];
				else
					$NombreEXPERTO='';
		?>
			  <tr>
				<td ><? echo "<input name='CheckRut' class='SinBorde' type='checkbox'  value='".$Fila["rut"]."~".$Fila["cod_gerencias"]."'>" ?></td>
				<td ><? echo $Fila["rut"]."&nbsp;"; ?></td>
				<td ><? echo strtoupper($Fila["nombres"])."&nbsp;"; ?></td>
				<td ><? echo strtoupper($Fila["apellido_paterno"])."&nbsp;".strtoupper($Fila["apellido_materno"]); ?></td>
				<td ><? echo strtoupper($Fila["descripcion"]); ?></td>
				<td ><? echo $NombreJEFE;?>&nbsp;</td>
				<td ><? echo $Fila["AVISO_CORREO"];?>&nbsp;</td>
				<td ><? echo $NombreEXPERTO;?>&nbsp;</td>
				<td ><? echo $Fila["AVISO_CORREO2"];?>&nbsp;</td>
				<td ><textarea cols="50" rows="2" readonly="readonly"><? echo DescripOrganica($Fila["cod_gerencias"],'G'); ?></textarea></td>
			  </tr>
			  <?		$cont++;
			}
		}
?>
    </table></td>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table><br>
<? 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
?>
<div id="DivProceso" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto; POSITION: absolute; moz-opacity: .75; opacity: .75;left: 350px; top: 5px; width:600px; height:450px;" align="center">
<table width="55%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td align="center"><table width="403" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><a href="JavaScript:Proceso('G')"><img src="imagenes/btn_guardar.png"  border="0"  alt="Grabar" align="absmiddle" /></a><a href="JavaScript:CerrarDiv(DivProceso)"><img src="imagenes/btn_salir.png"  border="0"  alt="Cerra" align="absmiddle" /></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
  
	  <tr>
        <td class="formulario">Rut:&nbsp;
		<?
			switch($Proc)
			{
				case "N":
					echo "<SELECT name='CmbUsuarios'>";
					echo "<option value='S'>Seleccionar</option>";
					$Consulta="SELECT * FROM proyecto_modernizacion.sistemas_por_usuario t1 inner join proyecto_modernizacion.funcionarios t3 on t1.rut=t3.rut left join sgrv.sgrs_acceso_organica t2 on t1.rut=t2.rut WHERE `cod_sistema` = '29' and t2.rut is null group by t1.rut order by t3.apellido_paterno ";
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						//ObtieneUsuario($Fila["rut"],&$NombreUser);
						echo "<option value='".$Fila["rut"]."'>".$Fila["rut"]."  -  ".strtoupper($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"])."</option>";
					}
					echo "</SELECT>";
					
					break;
				case "M":
					$DatosSel=explode('~',$Datos);
					$Rut=$DatosSel[0];
					ObtieneUsuario($Rut,&$NombreUser);
					echo strtoupper($Rut)." ".$NombreUser;	
					break;	
			}
		?>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>    	  
      <tr>
        <td>
		<table border="1" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td width="5%" class="TituloCabecera"><input type="checkbox" name="ChkTodos2" class="SinBorde" onClick="CheckearTodo(this.form,'CheckGer','ChkTodos2');"></td>
		<td width="95%"class="TituloCabecera" align='center'>Acceso Gerencias</td>
		</tr> 
		<?
			$DatosSel=explode('~',$Datos);
			$Rut=$DatosSel[0];
			$CodGer=$DatosSel[1];
			$Checked='';
			//echo strpos($CodGer,'49');
			$Consulta="SELECT * from sgrs_areaorg where CTAREA <> '0' and CPARENT=',0,1,' order by NAREA";
			$Resp=mysql_query($Consulta);echo "<input name='CheckGer' type='hidden'>";
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<tr>";
				if($Proc=='M')
				{
					$pos = strpos ($CodGer, $Fila[CAREA]);
					if ($pos === false)
						$Checked='hidden';
					else
						$Checked='checked';	
				}	
				echo "<td><input name='CheckGer' type='checkbox' value='".$Fila[CAREA]."' ".$Checked." class='SinBorde'></td>";
				echo "<td>&nbsp;".$Fila[NAREA]."</td>";
				echo "</tr>";
			}
		
		?>
		</table>
		</td>
      </tr>
	  <tr><td>&nbsp;</td></tr>
	  <table border="1" cellpadding="0" cellspacing="0" width="100%">
	  <tr><td colspan="2" class="TituloCabecera" align="center">Aviso Correo "Aceptar Fin Identificaci�n Peligro"</td></tr>
	  <tr><td align="center" class="TituloCabecera">Jefe �rea</td><td align="center" class="TituloCabecera">Experto</td></tr>
	  <tr>
	  <td align="center">	    
		<?
		switch($Proc)
		{
			case "N":			
				echo "<SELECT name='CmbJefe'>";
				echo "<option value='N' SELECTed>Ninguno</option>";
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios t1 
				inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut
				inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema
				where t2.cod_sistema='29' and (t3.nivel='1' or t3.nivel='4' or t3.nivel='8') group by t1.rut order by t1.apellido_paterno";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					ObtieneUsuario($Fila["rut"],&$NombreUser);
					echo "<option value='".$Fila["rut"]."'>".$Fila["rut"]."  -  ".$NombreUser."</option>";
				}
				echo "</SELECT>";echo "<br>";
				echo "<input type='text' name='correos' value='' size='47'><br>";
			break;
			case "M":			
				$Consulta="SELECT * FROM sgrs_acceso_organica  WHERE  rut='".$Rut."'";
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				$CmbJefe=$Fila[RUT_JEFE];
				//echo "RUT JEFE:".$CmbJefe."<br>";
				echo "<SELECT name='CmbJefe'>";
				echo "<option value='N' SELECTed>Ninguno</option>";
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios t1 
				inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut
				inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema
				where t2.cod_sistema='29' and (t3.nivel='1' or t3.nivel='4' or t3.nivel='8') group by t1.rut order by t1.apellido_paterno";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					ObtieneUsuario($Fila["rut"],&$NombreUser);
					if ($CmbJefe == $Fila["rut"])
						echo "<option value='".$Fila["rut"]."' SELECTed>".$Fila["rut"]."  -  ".$NombreUser."</option>";
					else
						echo "<option value='".$Fila["rut"]."'>".$Fila["rut"]."  -  ".$NombreUser."</option>";
				}
				echo "</SELECT>";echo "<br>";
				$Consulta="SELECT AVISO_CORREO from sgrs_acceso_organica where RUT='".$Rut."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					echo "<input type='text' name='correos' value='".$Fila[AVISO_CORREO]."' size='47'><br>";
					//echo "<input name='correos' type='text' size='93' value='".$Fila[AVISO_CORREO]."'>";
				}	
				else
					echo "<input type='text' name='correos' value='' size='47'><br>";
			break;
		}	
		?>	
	  </td>
	  <td align="center">	    
		<?
		switch($Proc)
		{
			case "N":			
				echo "<SELECT name='CmbExperto'>";
				echo "<option value='N' SELECTed>Ninguno</option>";
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios t1 
				inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut
				inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema
				where t2.cod_sistema='29' and (t3.nivel='1' or t3.nivel='4' or t3.nivel='8') group by t1.rut order by t1.apellido_paterno";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					ObtieneUsuario($Fila["rut"],&$NombreUser);
					if ($CmbExperto == $Fila["rut"])
						echo "<option value='".$Fila["rut"]."' SELECTed>".$Fila["rut"]."  -  ".$NombreUser."</option>";
					else
						echo "<option value='".$Fila["rut"]."'>".$Fila["rut"]."  -  ".$NombreUser."</option>";	
				}
				echo "</SELECT>";echo "<br>";
				echo "<input type='text' name='correos2' value='' size='47'><br>";
			break;
			case "M":			
				$Consulta="SELECT * FROM sgrs_acceso_organica  WHERE  rut='".$Rut."'";
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				$CmbExperto=$Fila[RUT_EXPERTO];

				echo "<SELECT name='CmbExperto'>";
				echo "<option value='N' SELECTed>Ninguno</option>";
				$Consulta="SELECT * FROM proyecto_modernizacion.funcionarios t1 
				inner join proyecto_modernizacion.sistemas_por_usuario t2 on t1.rut=t2.rut
				inner join proyecto_modernizacion.niveles_por_sistema t3 on t2.cod_sistema=t3.cod_sistema
				where t2.cod_sistema='29' and (t3.nivel='1' or t3.nivel='4' or t3.nivel='8') group by t1.rut order by t1.apellido_paterno";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					ObtieneUsuario($Fila["rut"],&$NombreUser);
					if ($CmbExperto == $Fila["rut"])
						echo "<option value='".$Fila["rut"]."' SELECTed>".$Fila["rut"]."  -  ".$NombreUser."</option>";
					else
						echo "<option value='".$Fila["rut"]."'>".$Fila["rut"]."  -  ".$NombreUser."</option>";
				}
				echo "</SELECT>";echo "<br>";
				$Consulta="SELECT AVISO_CORREO2 from sgrs_acceso_organica where RUT='".$Rut."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					echo "<input type='text' name='correos2' value='".$Fila[AVISO_CORREO2]."' size='47'><br>";
					//echo "<input name='correos' type='text' size='93' value='".$Fila[AVISO_CORREO]."'>";
				}	
				else
					echo "<input type='text' name='correos2' value='' size='47'><br>";
			break;
		}	
		?>	
	  </td>
	  </tr>
    </table>
    <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>
</div>
<?
include('div_obs_elimina_mantenedor.php');
?>
</form>
<script language="javascript">
/*alert("No se pueden Eliminar")*/
</script>
</body>
</html>
