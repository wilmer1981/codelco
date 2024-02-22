<?
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
<title>Consulta peligros por usuarios</title>

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
					f.action='consulta_registro_historico_peligros.php?Pro=R&NivelOrg='+f.SelTarea.value;
					f.submit();		
				}
				else
				{
					f.action='consulta_registro_historico_peligros.php?Pro=R';
					f.submit();		
				}	
		break;
		case "C":
				if(f.SelTarea.value!='')
				{					
					f.action='consulta_registro_historico_peligros.php?Pro=R&Buscar=S&NivelOrg='+f.SelTarea.value;
					f.submit();		
				}
				else
				{					
					f.action='consulta_registro_historico_peligros.php?Pro=R&Buscar=S';
					f.submit();		
				}
		break;
		case "E":
				if(f.EX.value=='N')
				{
					alert('Debe Haber Consultado Antes de Importar a Excel');
					return;
				}	
				URL='consulta_registro_historico_excel_peligros.php?FDesde='+f.FDesde.value+'&FHasta='+f.FHasta.value+'&CmbFuncionario='+f.CmbFuncionario.value+'&CmbTipoProceso='+f.CmbTipoProceso.value+'&SelTarea='+f.SelTarea.value+'&CmbVer='+f.CmbVer.value;
				window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "ARB":
				URL='consulta_registro_historico_arbol_peligros.php';
				window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "CARB":
					f.action='consulta_registro_historico_peligros.php?Pro=R';
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
<input name="Datos" type="hidden" value="<? echo $Datos;?>">
<input name="Proc" type="hidden" value="<? echo $Proc;?>">
<input type="hidden" value="<? echo $Nivel;?>" name="Nivel">
<input type="hidden" value="<? echo $Navega;?>" name="Navega">
<input type="hidden" value="<? echo $Estado;?>" name="Estado">
<input type="hidden" size='100' value="<? echo $SelTarea;?>" name="SelTarea">

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
	 <td align="center" colspan="5" class="TituloCabecera2">Consulta peligros por usuarios</td>
	 </tr>
	 <tr>       
	   <td width="168" height="35" align="left" class="formulario"   ><img src="imagenes/LblCriterios.png" /> </td>
       <td align="right" class="formulario" colspan="5">
	   <div id="DivOCu" style="visibility:<? echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('C')"><img src="imagenes/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;<a href="javascript:Proceso('E')"><img src="imagenes/btn_excel.png" width="28" height="28" border="0" alt="Excel"></a>&nbsp; <a href="javascript:window.print()"><img src="imagenes/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="imagenes/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a>       </div></td>
	 </tr>
     <tr>
       <td colspan="3" class="formulario">Periodo &nbsp;&nbsp;&nbsp;</td>
	   <td width="333" class="formulario"> Desde
		<input type="text" size="9" readonly="" maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<? echo $FDesde?>' />
		&nbsp;<img src="imagenes/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false" /> &nbsp;&nbsp;&nbsp;Hasta
		<input type="text" size="9" readonly="" maxlength="10" name="FHasta" id="FHasta"  class="InputDer" value='<? echo $FHasta?>'/>
		&nbsp;<img src="imagenes/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FHasta,FHasta,popCal);return false"/>&nbsp; </span><a href="JavaScript:Proceso('R')"><img src="imagenes/btn_activo.png" alt="Busca Funcionarios dentro de Fecha" border="0" width="19" height="19"></a></td>
       <td width="456" class="formulario">&nbsp;</td>
       </tr>
	 <?
	 if($Pro=='R')
	 {
		$FDesde=$FDesde." 00:00:00";
		$FHasta=$FHasta." 23:59:59";
	 ?>
     <tr>
       <td colspan="3" class="formulario">Buscar en Org&aacute;nica </td>	<? OrigenOrg($SelTarea,&$Ruta);?>
	     <td colspan="2" class="formulario">
		 <?
		 	if($SelTarea=='')
			{
		 ?>
			 <a href="JavaScript:Proceso('ARB')"><img src="imagenes/arbol.gif" alt="Org�nica" border="0" width="30" height="30"></a>
		 <?
		    }
			else
			{
		 ?>
			 <a href="JavaScript:Proceso('CARB')"><img src="imagenes/arbol_limpia.gif" alt="Limpia Org�nica" border="0" width="30" height="30"></a>
			 &nbsp;&nbsp;<? echo $Ruta;?>
		 <?
		 	}
		 ?>		 </td>		 
     </tr>
     <tr>
       <td colspan="3" class="formulario">Funcionario</td>	
	     <td class="formulario" colspan="3"><SELECT name="CmbFuncionario" onChange="Proceso('R')">
           <option value="T" SELECTed>Todos</option>
           <?
			$Consulta="SELECT * from sgrs_registro_historico t1 inner join proyecto_modernizacion.funcionarios t2 on t1.rut_funcionario=t2.rut ";
			$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='29000' and t3.valor_subclase3='S' and t1.tipo_proceso=t3.cod_subclase ";
			$Consulta.=" where t1.rut_funcionario <> '' and t1.fecha_registro between '".$FDesde."' and '".$FHasta."' group by t1.rut_funcionario order by t2.apellido_paterno,t2.apellido_materno,t2.nombres";
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resultado))
			{
				$Nombre=$Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"];
				if($CmbFuncionario==$Fila["rut_funcionario"])
					echo "<option value='".$Fila["rut_funcionario"]."' SELECTed>".$Fila["rut_funcionario"]." - ".$Nombre."</option>";
				else
					echo "<option value='".$Fila["rut_funcionario"]."'>".$Fila["rut_funcionario"]." - ".$Nombre."</option>";				
			}
		   ?>
         </SELECT>
	       <? //echo $Consulta;?></td>
         </tr>
     <tr>
       <td colspan="3" class="formulario">Tipo Proceso  &nbsp;&nbsp;</td>
       <td class="formulario" colspan="3"><SELECT name="CmbTipoProceso" style="width:200">
         <option value="T" SELECTed>Todos</option>
         <?
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase t1 inner join sgrs_registro_historico t2 on t1.cod_subclase=t2.tipo_proceso where cod_clase='29000' and valor_subclase3='S' and t2.fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and t2.rut_funcionario='".$CmbFuncionario."'";
			$Consulta.="group by t2.tipo_proceso";	
			//echo $Consulta;
			$Resultado=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resultado))
			{
				if($CmbTipoProceso==$Fila["cod_subclase"])
					echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".$Fila["nombre_subclase"]."</option>";
				else
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";				
			}
		   ?>
       </SELECT></td>
       </tr>
     <tr>
       <td colspan="3" class="formulario">Ver Por </td>
       <td class="formulario" colspan="3"><SELECT name="CmbVer" style="width:200">
         <option value="S" SELECTed>Seleccionar</option>
         <?
			switch($CmbVer)
			{
				case "R"://RESUMEN
					echo "<option value='D'>Detalle</option>";
					echo "<option value='R' SELECTed>Resumen</option>";
				break;
				case "D"://DETALLE
					echo "<option value='D' SELECTed>Detalle</option>";
					echo "<option value='R'>Resumen</option>";
				break;
				default:
					echo "<option value='D' SELECTed>Detalle</option>";
					echo "<option value='R'>Resumen</option>";
			}
			
		 ?>
       </SELECT></td>
     </tr>
	 <?
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
<?
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
	  <?
	  if($CmbVer=='D')
	  {
	  ?>
	  <tr>
	    <td width="20%" align="center" class="TituloCabecera">Funcionario</td>
          <td width="15%" align="center" class="TituloCabecera">Fecha</td>
		  <td width="15%" align="center" class="TituloCabecera">Tipo Proceso</td>
		 <td width="50%" align="center" class="TituloCabecera">Arbol Organizacional</td>

        </tr>
      <?
			$Consulta = "SELECT * from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and t1.tipo_proceso=t2.cod_subclase and t2.valor_subclase3='S'";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!=''||isset($SelTarea))
				$Consulta.=" and parent like '%".$SelTarea."%'";	
			$Consulta.=" order by fecha_registro";
			//echo 	$Consulta."<br>";
			$Resp = mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				$Consulta1="SELECT * from proyecto_modernizacion.funcionarios where rut='".$Fila["rut_funcionario"]."'";
				//echo $Consulta;
				$Resultado=mysql_query($Consulta1);
				if($Fila1=mysql_fetch_array($Resultado))
					$Nombre=$Fila1["apellido_paterno"]." ".$Fila1["apellido_materno"]." ".$Fila1["nombres"];
		?>
			 	<tr>
				<td ><? echo $Fila["rut_funcionario"]." ".$Nombre; ?></td>
				<td align="center" ><? echo $Fila[fecha_registro]; ?>&nbsp;</td>
				<td align="center" ><? echo $Fila["nombre_subclase"]; ?>&nbsp;</td>
				<td align="center" ><textarea cols='120' rows='4' readonly="readonly"><? echo $Fila["observacion"];?></textarea>&nbsp;</td>
			  </tr>
			  <?		
			}
		}
		else
		{
		?>		
	    <tr>
	    <td width="18%" align="center" class="TituloCabecera">Gerencia</td>
		<td width="18%" align="center" class="TituloCabecera">SuperIntendencia</td>
		<td width="18%" align="center" class="TituloCabecera">Area</td>
		<td width="18%" align="center" class="TituloCabecera">Proceso</td>
		<td width="18%" align="center" class="TituloCabecera">Nombre Tarea</td>
		<td width="10%" align="center" class="TituloCabecera">N� Consultas</td>
        </tr>
		<?
			$Consulta = "SELECT parent as cod,count(*) as cant_reg from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and t1.tipo_proceso=t2.cod_subclase and t2.valor_subclase3='S'";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!=''||isset($SelTarea))
				$Consulta.=" and parent like '%".$SelTarea."%'";	
			$Consulta.=" group by parent order by fecha_registro";
			//echo 	$Consulta."<br>";
			$Resp = mysql_query($Consulta);$CantReg=0;
			while ($Fila=mysql_fetch_array($Resp))
			{
				$CantReg=$CantReg+$Fila["cant_reg"];
				$Organica=explode(',',$Fila[cod]);
				echo "<tr>";$NomOrganica1='&nbsp;';$NomOrganica2='&nbsp;';$NomOrganica3='&nbsp;';$NomOrganica4='&nbsp;';$NomOrganica8='&nbsp;';
				while(list($c,$v)=each($Organica))
				{
					$Nivel=ObtenerNivel($v);
					$NomOrganica=DescripOrganica3($v);
					switch($Nivel)
					{
						case "1":
							$NomOrganica1=$NomOrganica;	
						break;
						case "2":
							$NomOrganica2=$NomOrganica;	
						break;
						case "3":
							$NomOrganica3=$NomOrganica;		
						break;
						case "4":
							$NomOrganica4=$NomOrganica;	
						break;
						case "8":
							$NomOrganica8=$NomOrganica;		
						break;
					}
				}
				echo "<td align='left'>".$NomOrganica1."</td>";
				echo "<td align='left'>".$NomOrganica2."</td>";
				echo "<td align='left'>".$NomOrganica3."</td>";
				echo "<td align='left'>".$NomOrganica4."</td>";
				echo "<td align='left'>".$NomOrganica8."</td>";
				echo "<td align='right'>".$Fila["cant_reg"]."&nbsp;</td>";
				echo "</tr>";
			}
			?>
			 	<tr>
				<td align="right" class="TituloCabecera" colspan="5">Total&nbsp;&nbsp;</td>
				<td align="right" class="TituloCabecera"><? echo number_format($CantReg,0,'','.'); ?>&nbsp;</td>
			    </tr>
			<?	
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
<?
}
?>  
  <input type="hidden" name="EX" value="<? echo $EX;?>">
</table><br>
<? 
if (!isset($VisibleDivProceso))
	$VisibleDivProceso='hidden';
?>
<!--<div id="DivOCu" style="visibility:<? echo $VisibleDivProceso;?>;FILTER: alpha(opacity=100);overflow:auto;  POSITION: absolute; moz-opacity: .75; opacity: .75;left: 672px; top: 33px; width:150px; height:80px;" align="center">
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
<?
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

