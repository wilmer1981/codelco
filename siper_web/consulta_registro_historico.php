<?php
include('conectar_ori.php');
include('funciones/siper_funciones.php');

if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
if(!isset($FHasta))
	$FHasta=date('Y-m-d');
	
$SelTarea=$NivelOrg;
?>
<html>
<head>
<title>Consulta Histórica</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
	var teclaCodigo = event.keyCode;
	
	
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39) &&(teclaCodigo != 190 ))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
					event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 188 )&&(teclaCodigo != 190 ))
			{
				event.keyCode=46;
			}	
		}
	
} 
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
				f.action='mantenedor_agente.php?VisibleDivProceso=S&Buscar=S';
				f.submit();		
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckRut','M'))
			{
				Datos=Recuperar(f.name,'CheckRut');
				DivProceso.style.visibility='visible';
				f.Proc.value='M';
				f.Datos.value=Datos;
				f.action='mantenedor_agente.php?VisibleDivProceso=S&Buscar=S';
				f.submit();				
			}	
		break;
		case "G":
			if(f.TxtNombre.value!='')
			{
				if(f.CmbUnidad.value!='S')
				{
					if(f.TxtQLPP.value!='')
					{
						if(f.rdvigente[0].checked==true)
							f.Vigente.value='1';
						else
							f.Vigente.value='0';
						DivProceso.style.visibility='hidden';
						f.action='mantenedor_agente01.php?Proceso='+f.Proc.value;
						f.submit();
					}
					else
					{
					alert('Debe Ingresar QLPP ')
					f.TxtQLPP.focus();
					}	
				}	
				else
				{
				
					alert('Debe Seleccionar Unidad ')
					f.CmbUnidad.focus();
				}				
			}
			else
			{alert('Debe Ingresar Descripción')
			f.TxtNombre.focus();
			}
		break;
		case "R":
				if(f.FDesde.value=='')
				{
					alert('Debe Ingresar Fecha Desde');
					f.FDesde.focus();
					return;
				}	
				if(f.FHasta.value=='')
				{
					alert('Debe Ingresar Fecha Hasta');
					f.FHasta.focus();
					return;
				}	
				if (compare_dates(f.FDesde.value,f.FHasta.value))
				{
			    	alert("Fecha Desde no puede ser mayor que Fecha Hasta");  
					return;
				}	
				if(f.SelTarea.value!='')
				{					
					f.action='consulta_registro_historico.php?Pro=R&NivelOrg='+f.SelTarea.value;
					f.submit();		
				}
				else
				{
					f.action='consulta_registro_historico.php?Pro=R';
					f.submit();		
				}	
		break;
		case "C":
				if(f.SelTarea.value!='')
				{					
					f.action='consulta_registro_historico.php?Pro=R&Buscar=S&NivelOrg='+f.SelTarea.value;
					f.submit();		
				}
				else
				{					
					f.action='consulta_registro_historico.php?Pro=R&Buscar=S';
					f.submit();		
				}
		break;
		case "E":
				if(f.EX.value=='N')
				{
					alert('Debe Haber Consultado Antes de Importar a Excel');
					return;
				}	
				URL='consulta_registro_historico_excel.php?FDesde='+f.FDesde.value+'&FHasta='+f.FHasta.value+'&CmbFuncionario='+f.CmbFuncionario.value+'&CmbTipoProceso='+f.CmbTipoProceso.value+'&SelTarea='+f.SelTarea.value;
				window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "ARB":
				URL='consulta_registro_historico_arbol.php';
				window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "CARB":
					f.action='consulta_registro_historico.php?Pro=R';
					f.submit();		
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29";
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
function compare_dates(fecha, fecha2)  
{  
	var xMonth=fecha.substring(5, 7);  
	var xDay=fecha.substring(8, 10);  
	var xYear=fecha.substring(0,4);  
	var yMonth=fecha2.substring(5, 7);  
	var yDay=fecha2.substring(8, 10);  
	var yYear=fecha2.substring(0,4); 
	//alert(xYear) 
	//alert(xMonth) 
	//alert(xDay) 
	if (xYear> yYear)  
   {  
	   return(true)  
   }  
  else  
   {  
	 if (xYear == yYear)  
	 {   
	   if (xMonth> yMonth)  
	   {  
		   return(true)  
	   }  
	   else  
	   {   
		 if (xMonth == yMonth)  
		 {  
		   if (xDay> yDay)  
			 return(true);  
		   else  
			 return(false);  
		 }  
		 else  
		   return(false);  
	   }  
	 }  
	 else  
	   return(false);  
  }  
}  

</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input name="Datos" type="hidden" value="<?php echo $Datos;?>">
<input name="Proc" type="hidden" value="<?php echo $Proc;?>">
<input type="hidden" value="<?php echo $Nivel;?>" name="Nivel">
<input type="hidden" value="<?php echo $Navega;?>" name="Navega">
<input type="hidden" value="<?php echo $Estado;?>" name="Estado">
<input type="hidden" size='100' value="<?php echo $SelTarea;?>" name="SelTarea">

<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
   <td align="center"><table width="96%" border="0" cellpadding="0"  cellspacing="0">
     <tr>
	 <td align="center" colspan="5" class="TituloCabecera2">Consulta Hist&oacute;rica </td>
	 </tr>
	 <tr>       
	   <td width="168" height="35" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td align="right" class="formulario" colspan="5">
	   <div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;<a href="javascript:Proceso('E')"><img src="imagenes/btn_excel.png" width="28" height="28" border="0" alt="Excel"></a>&nbsp; <a href="javascript:window.print()"><img src="imagenes/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>       </div></td>
	 </tr>
     <tr>
       <td colspan="3" class="formulario">Periodo &nbsp;&nbsp;&nbsp;</td>
	   <td width="333" class="formulario"> Desde
		<input type="text" size="9" readonly="" maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<?php echo $FDesde?>' />
		&nbsp;<img src="imagenes/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false" /> &nbsp;&nbsp;&nbsp;Hasta
		<input type="text" size="9" readonly="" maxlength="10" name="FHasta" id="FHasta"  class="InputDer" value='<?php echo $FHasta?>'/>
		&nbsp;<img src="imagenes/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FHasta,FHasta,popCal);return false"/>&nbsp; </span><a href="JavaScript:Proceso('R')"><img src="imagenes/btn_activo.png" alt="Busca Funcionarios dentro de Fecha" border="0" width="19" height="19"></a></td>
       <td width="456" class="formulario">&nbsp;</td>
       </tr>
	 <?php
	 if($Pro=='R')
	 {
		$FDesde=$FDesde." 00:00:00";
		$FHasta=$FHasta." 23:59:59";
	 ?>
     <tr>
       <td colspan="3" class="formulario">Buscar en Org&aacute;nica </td>	<?php OrigenOrg($SelTarea,&$Ruta);?>
	     <td colspan="2" class="formulario">
		 <?php
		 	if($SelTarea=='')
			{
		 ?>
			 <a href="JavaScript:Proceso('ARB')"><img src="imagenes/arbol.gif" alt="Orgánica" border="0" width="30" height="30"></a>
		 <?php
		    }
			else
			{
		 ?>
			 <a href="JavaScript:Proceso('CARB')"><img src="imagenes/arbol_limpia.gif" alt="Limpia Orgánica" border="0" width="30" height="30"></a>
			 &nbsp;&nbsp;<?php echo $Ruta;?>
		 <?php
		 	}
		 ?>
		 </td>		 
     </tr>
     <tr>
       <td colspan="3" class="formulario">Funcionario</td>	
	     <td class="formulario" colspan="3"><select name="CmbFuncionario" onChange="Proceso('R')">
           <option value="T" selected>Todos</option>
           <?php
			$Consulta="select * from sgrs_registro_historico t1 inner join proyecto_modernizacion.funcionarios t2 on t1.rut_funcionario=t2.rut ";
			$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='29000' and t3.valor_subclase2='S' and t1.tipo_proceso=t3.cod_subclase ";
			$Consulta.=" where t1.fecha_registro between '".$FDesde."' and '".$FHasta."' group by t1.rut_funcionario order by t2.apellido_paterno,t2.apellido_materno,t2.nombres";
			//echo $Consulta;
			$Resultado=mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Nombre=$Fila[apellido_paterno]." ".$Fila[apellido_materno]." ".$Fila[nombres];
				if($CmbFuncionario==$Fila[rut_funcionario])
					echo "<option value='".$Fila[rut_funcionario]."' selected>".$Fila[rut_funcionario]." - ".$Nombre."</option>";
				else
					echo "<option value='".$Fila[rut_funcionario]."'>".$Fila[rut_funcionario]." - ".$Nombre."</option>";				
			}
		   ?>
         </select>
	       <?php //echo $Consulta;?></td>
         </tr>
     <tr>
       <td colspan="3" class="formulario">Tipo Proceso  &nbsp;&nbsp;</td>
       <td class="formulario" colspan="3"><select name="CmbTipoProceso" style="width:200">
         <option value="T" selected>Todos</option>
         <?php
			$Consulta="select * from proyecto_modernizacion.sub_clase t1 inner join sgrs_registro_historico t2 on t1.cod_subclase=t2.tipo_proceso where cod_clase='29000' and valor_subclase2='S' and t2.fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and t2.rut_funcionario='".$CmbFuncionario."'";
			$Consulta.="group by t2.tipo_proceso";	
			//echo $Consulta;
			$Resultado=mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				if($CmbTipoProceso==$Fila[cod_subclase])
					echo "<option value='".$Fila[cod_subclase]."' selected>".$Fila[nombre_subclase]."</option>";
				else
					echo "<option value='".$Fila[cod_subclase]."'>".$Fila[nombre_subclase]."</option>";				
			}
		   ?>
       </select></td>
       </tr>
	 <?php
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
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
<?php
	$EX='N';
	if($Buscar=='S')
	{
		$EX='S';
?> 
  <tr>
    <td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
	  <tr>
	    <td width="20%" align="center" class="TituloCabecera">Funcionario</td>
          <td width="15%" align="center" class="TituloCabecera">Fecha</td>
		  <td width="15%" align="center" class="TituloCabecera">Tipo Proceso</td>
		 <td width="20%" align="center" class="TituloCabecera">Observación</td>
		 <td width="20%" align="center" class="TituloCabecera">Observación (Solo Modificación)</td>
		 <td width="20%" align="center" class="TituloCabecera">Observación (Eliminación)</td>
		 <td width="20%" align="center" class="TituloCabecera">Observación (Sustitución)</td>
        </tr>
      <?php
			$Consulta = "select * from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and t2.valor_subclase2='S' and t1.tipo_proceso=t2.cod_subclase";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!=''||isset($SelTarea))
				$Consulta.=" and parent like '%".$SelTarea."%'";	
			$Consulta.=" order by fecha_registro";
			//echo 	$Consulta."<br>";
			$Resp = mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resp))
			{
				$Consulta1="select * from proyecto_modernizacion.funcionarios where rut='".$Fila[rut_funcionario]."'";
				//echo $Consulta;
				$Resultado=mysqli_query($link,$Consulta1);
				if($Fila1=mysqli_fetch_array($Resultado))
					$Nombre=$Fila1[apellido_paterno]." ".$Fila1[apellido_materno]." ".$Fila1[nombres];
					
				if($Fila[observacion2]=='')
					$Obs2='';
				else
					$Obs2="<textarea cols='50' rows='4' readonly='readonly'>".$Fila[observacion2]."</textarea>";						
				if($Fila[obs_elimina]=='')
				{
					$Obs3="<td align='center' >&nbsp;</td>
						   <td align='center' >&nbsp;</td>";		
				}
				else
				{
					if($Fila[Tipo_Eli_Sust]!='')
					{
						if($Fila[Tipo_Eli_Sust]==1)//ELIMINACIÓN
						{
							$Obs3="<td align='center' ><textarea cols='30' rows='4' readonly='readonly'>".$Fila[obs_elimina]."</textarea></td>
								   <td align='center' >&nbsp;</td>";		
						}	
						if($Fila[Tipo_Eli_Sust]==2)//SUSTITUCION
						{
							$Obs3="<td align='center' >&nbsp;</td>
								   <td align='center' ><textarea cols='30' rows='4' readonly='readonly'>".$Fila[obs_elimina]."</textarea></td>";
						}	
					}	
				}	
		?>
			 	<tr>
				<td ><?php echo $Fila[rut_funcionario]." ".$Nombre; ?></td>
				<td align="center" ><?php echo $Fila[fecha_registro]; ?>&nbsp;</td>
				<td align="center" ><?php echo $Fila[nombre_subclase]; ?>&nbsp;</td>
				<td align="center" ><textarea cols='50' rows='4' readonly="readonly"><?php echo $Fila[observacion];?></textarea>&nbsp;</td>
				<td align="center" ><?php echo $Obs2;?>&nbsp;</td>
				<?php echo $Obs3;?>
			  </tr>
			  <?php		
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
<?php
}
?>  
  <input type="hidden" name="EX" value="<?php echo $EX;?>">
</table><br>
<?php 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
?>
<!--<div id="DivOCu" style="visibility:<?php echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto;  POSITION: absolute; moz-opacity: .75; opacity: .75;left: 672px; top: 33px; width:150px; height:80px;" align="center">
<table width="100%">
  <tr>
    <td >&nbsp;</td>
  </tr>
    <tr>
    <td >&nbsp;</td>
  </tr>
  </table>
</div>-->
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

