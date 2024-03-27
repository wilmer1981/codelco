
<?
include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");
$KoolControlsFolder="KoolPHPSuite/KoolControls";
require $KoolControlsFolder."/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

if($koolajax->isCallback)
{
	sleep(0); //Slow down 1s to see loading effect
}

echo $koolajax->Render();
?>
<html>
<head>
<title>Imputaci�n de Inventario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/scop_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion,CoPlOr)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
				var Valores2='';
				var SumaDeValores=0;var NDivision=''; var Valor=0;
				if(f.ValorImputar.value<0)
				{
					for (i=1;i<f.elements.length;i++)
					{
						var Nom= f.elements[i].name					    
						if (Nom.substring(0,2)=='VI' && f.elements[i].value!='')
						{
							Valores2 = Valores2+f.elements[i].name+"~"+f.elements[i].value+"//";
							Str=ReemplazarPuntos(f.elements[i].value);
							if(Str>0)
								alert('no se puede ingresar valor positivo')
							else							
								SumaDeValores=(SumaDeValores+parseFloat(ReemplazarComasPorPuntos(Str)))	
						}	
					}
					if(Valores2=='')
					{
						alert('Debe Ingresar un Valor de Imputaci�n')				
					}
					else
					{
						Valores2=Valores2.substr(0,Valores2.length-2);
						if(SumaDeValores<f.ValorImputar.value)
						{
							alert("La Suma de los valores no puede ser mayor que el Total a Imputar");
						}
						else
						{			
							f.action="scop_proceso_cobertura_imputacion_cc01.php?Opcion=VIM&Valores2="+Valores2+"&CoPlOr="+CoPlOr;
							f.submit();
						}
					}
				}	
				else
				{
					for (i=1;i<f.elements.length;i++)
					{
						var Nom= f.elements[i].name					    
						if (Nom.substring(0,2)=='VI' && f.elements[i].value!='')
						{
							Valores2 = Valores2+f.elements[i].name+"~"+f.elements[i].value+"//";
							Str=ReemplazarPuntos(f.elements[i].value);
							if(Str<0)
							{
								alert('No se puede ingresar valor 0 � Negativo')
								return;
							}	
							else							
								SumaDeValores=(SumaDeValores+parseFloat(ReemplazarComasPorPuntos(Str)))	
						}	
					}
					if(Valores2=='')
					{
						alert('Debe Ingresar un Valor de Imputaci�n')				
					}
					else
					{
						Valores2=Valores2.substr(0,Valores2.length-2);
						if(SumaDeValores>f.ValorImputar.value)
						{
							alert("La Suma de los valores no puede ser mayor que el Total a Imputar");
						}
						else
						{			
							f.action="scop_proceso_cobertura_imputacion_cc01.php?Opcion=VIM&Valores2="+Valores2+"&CoPlOr="+CoPlOr;
							f.submit();
						}
					}
				}
        break;
		case "M":
				var Valores2='';
				var SumaDeValores=0;var NDivision='';
				if(f.ValorImputar.value<0)
				{
					for (i=1;i<f.elements.length;i++)
					{
						var Nom= f.elements[i].name					    
						if (Nom.substring(0,2)=='VI' && f.elements[i].value!='')
						{
							Valores2 = Valores2+f.elements[i].name+"~"+f.elements[i].value+"//";
							Str=ReemplazarPuntos(f.elements[i].value);
							if(Str>=0)
							{
								alert('No se puede ingresar valor 0 � Positivo')
								return;
							}	
							else							
								SumaDeValores=(SumaDeValores+parseFloat(ReemplazarComasPorPuntos(Str)))	
						}	
					}
					if(Valores2=='')
					{
						alert('Debe Ingresar un Valor de Imputaci�n')				
					}
					else
					{
						Valores2=Valores2.substr(0,Valores2.length-2);
						if(SumaDeValores<f.ValorImputar.value)
						{
							alert("La Suma de los valores no puede ser mayor que el Total a Imputar");
						}
						else
						{			
							f.action="scop_proceso_cobertura_imputacion_cc01.php?Opcion=VIM&Valores2="+Valores2+"&CoPlOr="+CoPlOr;
							f.submit();
						}
					}
				}	
				else
				{
					for (i=1;i<f.elements.length;i++)
					{
						var Nom= f.elements[i].name					    
						if (Nom.substring(0,2)=='VI' && f.elements[i].value!='')
						{
							Valores2 = Valores2+f.elements[i].name+"~"+f.elements[i].value+"//";
							Str=ReemplazarPuntos(f.elements[i].value);
							if(Str<=0)
							{
								alert('No se puede ingresar valor 0 � Negativo')
								return;
							}	
							else							
								SumaDeValores=(SumaDeValores+parseFloat(ReemplazarComasPorPuntos(Str)))	
						}	
					}
					if(Valores2=='')
					{
						alert('Debe Ingresar un Valor de Imputaci�n')				
					}
					else
					{
						Valores2=Valores2.substr(0,Valores2.length-2);
						if(SumaDeValores>f.ValorImputar.value)
						{
							alert("La Suma de los valores no puede ser mayor que el Total a Imputar");
						}
						else
						{			
							f.action="scop_proceso_cobertura_imputacion_cc01.php?Opcion=VIM&Valores2="+Valores2+"&CoPlOr="+CoPlOr;
							f.submit();
						}
					}
				}
		break;		
		case "NI":
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
		break;
				
	}
}
function ReemplazarPuntos(Str)
{
	return(Str.replace('.',''));
}
function ReemplazarComasPorPuntos(Str)
{
	Str=Str.replace( /\./g,'');
	return(Str.replace(',','.'));
}
function Recarga(Opc,Valores,TipoEst,Acuerdo,CoPlOr)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_imputacion_valores.php?Opcion="+Opc+"&Valores="+Valores+"&TipoEst="+TipoEst+"&Acuerdo="+Acuerdo+"&CoPlOr="+CoPlOr;
	f.submit();
}
function Eliminar(Opc,Valores,CoPlOr)
{
	var f= document.FrmPopupProceso;
	mensaje=confirm("�Esta seguro de eliminar el valor Seleccionado?");
	if(mensaje==true)
	{
		f.action="scop_proceso_cobertura_imputacion_cc01.php?Opcion="+Opc+"&Valores="+Valores+"&CoPlOr="+CoPlOr;
		f.submit();
	}
}
function Salir(TipoEst,Acuerdo)
{
   window.opener.document.FrmPrincipal.action='scop_proceso_cobertura_imputacion_cc.php?Buscar=S';
   window.opener.document.FrmPrincipal.submit();
   window.close();
}

</script>
<script type="text/javascript">
	function ValorImputar()
	{
		var _Parci = document.getElementById("Parcializacion").value;
		var _Ano = document.getElementById("Ano").value;
		var _Mes = document.getElementById("Mes").value;
		var _ValorImputar=_Ano+"~"+_Mes+"~"+_Parci;
		if(_ValorImputar!="")
		{
			order_UPDATEpanel.attachData("Valor",_ValorImputar);
			order_UPDATEpanel.UPDATE();
		}
	}
</script>	
<link href="estilos/css_scop_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../scop_web/archivos/subtitulos/sub_tit_imputacion.png"></td>
       <td align="right">	  
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>','<? echo $CoPlOr;?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a> 
	   <a href="JavaScript:Salir('')"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
	     <tr>
           <td width="19%" class="formulario2"><? echo "Inventario Imputar";?></td>
           <td width="214" colspan="6" class="formulario2">
		    <? 	
				if($CoPlOr==1)$NomTipo='COBRE';if($CoPlOr==2)$NomTipo='PLATA';if($CoPlOr==3)$NomTipo='ORO';
				echo $NomTipo;	
				echo "<input type='hidden' name='TipoCodLey' id='Ano' value='".$CoPlOr."'>"; 
			?></td>
         </tr>
	     <tr>
           <td width="19%" class="formulario2"><? echo "A&ntilde;o";?></td>
           <td width="214" colspan="6" class="formulario2">
		    <? 		 
			 echo 	$Ano;	
			 echo "<input type='hidden' name='Ano' id='Ano' value='".$Ano."'>";	
			?></td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="19%" class="formulario2"><? echo "Mes";?></td>
           <td class="formulario2" colspan="6"><? echo $Meses[$Mes-1];
		   echo "<input type='hidden' name='Mes' id='Mes' value='".$Mes."'>";?></td>
         </tr>		 		 
          <tr>
            <td class="formulario2"><? echo "Total Imputar"; ?></td>
            <td class="formulario2">	
				<? $ValorImputar2=Valores($Ano,$Mes,$CoPlOr); echo number_format($ValorImputar2,0,',','.');
				 echo "<input type='hidden' name='ValorImputar' id='ValorImputar' value='".round($ValorImputar2,0)."'>";?>				</td>
            <td class="formulario2">&nbsp;</td>
            <td width="163" class="formulario2">&nbsp;</td>
            <td width="163" class="formulario2">&nbsp;</td>
            <td width="154" class="formulario2">&nbsp;</td>
          </tr>
          <tr>
           <td colspan="6" align="left" class="formulario2">
		   <table width="55%" border="1" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
             <tr>
               <td colspan="2" align="left" class="TituloTablaNaranja">Divisiones</td>
               <td align="left" class="TituloTablaNaranja">Elim.</td>
               </tr>	
			   <?
			     $CONSULTADIVISION="select * from proyecto_modernizacion.sub_clase where cod_clase='33006' order by cod_subclase asc";
				 $RESP=mysql_query($CONSULTADIVISION);
				 while($FILA=mysql_fetch_array($RESP))
				 {
				 	
				    echo "<tr>";
					 echo "<td width='71%' align='right' class='TituloCabecera'>".$FILA["nombre_subclase"]."</td>";
					 $Datos=explode("~",$Valores);
					 $CONSULTA="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and cod_division='".$FILA["cod_subclase"]."' and cod_ley='".$CoPlOr."'";
					 $RESP2=mysql_query($CONSULTA);
					 if($FILA2=mysql_fetch_array($RESP2))
					 {
					 	 $Eliminar=$FILA["cod_subclase"]."~".$Ano."~".$Mes;
	 					 echo "<td width='29%' align='left' class='TituloCabecera' align='left'>";
							 echo "<input name='VI~".$FILA["cod_subclase"]."' class='InputDer' maxlength='18' readonly onKeyDown='SoloNumerosyNegativo(true,this)' size='20' type='text' value='".number_format($FILA2[valor_imputado],0,',','.')."'>";						 
						 echo "</td>";	
	 					 echo "<td align='center' class='TituloCabecera' align='left'>";
							 echo "<a href=JavaScript:Eliminar('ED','".$Eliminar."','".$CoPlOr."')><img src='archivos/eliminar2.png'  alt='Eliminar Valor Divisi�n ".$FILA["nombre_subclase"]."' width='16' height='16'  border='0' align='absmiddle'></a>";
						 echo "</td>";
						 $ValorTotal=$ValorTotal+$FILA2[valor_imputado];
					 }
					 else
					 {
	 					 echo "<td width='29%' align='left' class='TituloCabecera' align='left'>";
							 echo "<input name='VI~".$FILA["cod_subclase"]."' class='InputDer' maxlength='18' onKeyDown='SoloNumerosyNegativo(true,this)' size='20' type='text'>";
						 echo "</td>";	
	 					 echo "<td align='left' class='TituloCabecera' align='left'>";
							 echo "&nbsp;</a>";
						 echo "</td>";
					 }	
					echo "</tr>";
				 }	
				 	//if($ValorImputar2>=0)
					//{
						$Diferencia=round($ValorImputar2,0)-$ValorTotal;
						$Valor=number_format($Diferencia,0,',','.');
					//}
					//else
					//{
						$Diferencia=round($ValorImputar2,0)-$ValorTotal;
						$Valor=number_format($Diferencia,0,',','.');
					//}	
			   ?>
					<tr>
					 <td align='right' class='TituloTablaNaranja'>Total Divisiones</td>
					 <td class="formulario" align="right"><? echo number_format($ValorTotal,0,',','.');?></td>
					 <td class="formulario" align="right">&nbsp;</td>
					</tr>
					<tr>
					  <td align='right' class='TituloTablaNaranja'>Diferencia a Imputar</td>
					  <td class="formulario" align="right"><? echo $Valor;?></td>
					   <td class="formulario" align="right">&nbsp;</td>
					  </tr>
           </table></td>
          </tr>

       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde" ></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="16" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../scop_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	if ($Mensaje1==true)
		echo "alert('Contrato Ingresado Exitosamente');";
	if ($VI==true)
		echo "alert('Valor Division(es) Ingresado(s) Exitosamente');";
	if ($MEli=='E')
		echo "alert('Valor de la Division fue Eliminado');";
	if ($VIM=='S')
		echo "alert('Valor de Division(es) Actualizados');";
	echo "</script>";
?>
<?
function Valores($Ano,$Mes,$CoPlOr)
{
   $ArrInventario=array();$ArrCarry=array();$ArrPrecios=array();$ArrPrecios2=array();
   for($i=1;$i<=3;$i++)
   {
		$ArrInventario[$i][Cu]='';$ArrInventario[$i][Au]='';$ArrInventario[$i][Ag]='';
		$ArrCarry[$i][Cu]='';$ArrCarry[$i][Au]='';$ArrCarry[$i][Ag]='';
		$ArrPrecios[$i][Cu]='';$ArrPrecios[$i][Au]='';$ArrPrecios[$i][Ag]='';
   }						   					 
	$Consulta="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.estado,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
	$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.estado in ('5') and t3.vigente='1' group by corr,parcializacion,ano,mes";					
	$Resp = mysqli_query($link, $Consulta);$ED=0;
	while($Fila=mysql_fetch_assoc($Resp))
	{	
		ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Fila[parcializacion],$CmbAcuerdo,$TipoEst,&$ArrInventario);
		ValoresCarryCost($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
		ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
		ValorPreciosOperacionesAcuerdo($Fila["corr"],$Fila[parcializacion],$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
		if('1'==$CoPlOr)
		{
			if($ArrPrecios[1][Cu]!='0')
			{
				reset($ArrPrecios);	reset($ArrInventario);reset($ArrCarry);	reset($ArrPrecios2);
				$ImputarCu=$Fila["ano"]."~".$Fila["mes"];
				$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
				$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
				$ResultadoCu=($ArrInventario[1][Cu]*($ResultadoPrecioCVCobre)/100)+$CarryCostTotalCu;
				$SumaCu=$SumaCu+$ResultadoCu;
			}	
			else
				$SumaCu=0;
		}
		if('2'==$CoPlOr)
		{
			if($ArrPrecios[2][Ag]!='0')
			{
				reset($ArrPrecios);	reset($ArrInventario);reset($ArrCarry);	reset($ArrPrecios2);
				$ImputarAg=$Fila["ano"]."~".$Fila["mes"];
				$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
				$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
				$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
				$SumaAg=$SumaAg+$ResultadoAg;
			}	
			else
				$SumaAg=0;
		}
		if('3'==$CoPlOr)
		{
			if($ArrPrecios[3][Au]!='0')
			{
				reset($ArrPrecios);	reset($ArrInventario);reset($ArrCarry);	reset($ArrPrecios2);
				$ImputarAu=$Fila["ano"]."~".$Fila["mes"];
				$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
				$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];					
				$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
				$SumaAu=$SumaAu+$ResultadoAu;			
			}
			else
				$SumaAu=0;
		}
	}
	if($CoPlOr=='1')
		return($SumaCu);
	if($CoPlOr=='2')
		return($SumaAg);
	if($CoPlOr=='3')
		return($SumaAu);
}	
function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp = mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1'";
		$Resp = mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_ley"]==1)
				$ValorCobre=$ValorCobre+$Fila["valor"];
			if($Fila["cod_ley"]==2)
				$ValorPLata=$ValorPLata+$Fila["valor"];
			if($Fila["cod_ley"]==3)
				$ValorOro=$ValorOro+$Fila["valor"];
		}
	}
	$ArrInventario[1][Cu]=$ValorCobre;
	$ArrInventario[2][Ag]=$ValorPLata;
	$ArrInventario[3][Au]=$ValorOro;
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	$ArrCarry[1][Cu]=0;$ArrCarry[2][Ag]=0;$ArrCarry[3][Au]=0;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{				
		if($Fila["estado"]=='5')
			$Clase="class='BordeFecha'";
		else	
			$Clase="bgcolor='#FFFFFF'";
		$NomTxt="Cu_".$Fila["corr"]."_".$Fila[parcializacion];
		$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2'";
		$RespPro=mysql_query($ConsultaPro);
		while($FilaPro=mysql_fetch_array($RespPro))
		{
			if($FilaPro["cod_ley"]==1)
				$ValorCobre=$ValorCobre+$FilaPro["valor"];
			if($FilaPro["cod_ley"]==2)
				$ValorPLata=$ValorPLata+$FilaPro["valor"];
			if($FilaPro["cod_ley"]==3)
				$ValorOro=$ValorOro+$FilaPro["valor"];
		}
			$ArrCarry[1][Cu]=$ValorCobre;
			$ArrCarry[2][Ag]=$ValorPLata;
			$ArrCarry[3][Au]=$ValorOro;
	}
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Corr=$Fila["corr"];
		if($Fila[acuerdo_contractual]=='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$Consulta="select t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_cu='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadCu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
				$ValorCobre=$CantidadCu;
				
				$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_ag='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadAg=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAg=$CantidadAg+$Fila[acuerdo_ag];
				$ValorPLata=$CantidadAg;
				
				$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_au='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadAu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAu=$CantidadAu+$Fila[acuerdo_au];
				$ValorOro=$CantidadAu;

			$ArrPrecios2[1][Cu]=$ValorCobre;
			$ArrPrecios2[2][Ag]=$ValorPLata;
			$ArrPrecios2[3][Au]=$ValorOro;
			}
		}
		if($Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//CAMBIO QP
			{
				$MesSuma=$Fila[acuerdo_contractual]+$Mes;		
				if($MesSuma>12)
				{	
					$MesDeEntregaValor=$MesSuma-12;
					$AnoAux=$Ano+1;
				}
				if($MesSuma<=0)
				{
					$MesDeEntregaValor=12-$MesSuma;
					$AnoAux=$Ano-1;
				}
				if($MesSuma<12&&$MesSuma>0)
				{
					$MesDeEntregaValor=$Fila[acuerdo_contractual]+$Mes;		
					$AnoAux=$Ano; 
				}
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."'";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["cod_ley"]==1)
						$ValorCobre=$Fila["valor"];
					if($Fila["cod_ley"]==2)
						$ValorPLata=$Fila["valor"];
					if($Fila["cod_ley"]==3)
						$ValorOro=$Fila["valor"];
				}
				
			$ArrPrecios2[1][Cu]=$ValorCobre;
			$ArrPrecios2[2][Ag]=$ValorPLata;
			$ArrPrecios2[3][Au]=$ValorOro;
			}	
		}
	}	
}
function ValorPreciosOperacionesAcuerdoQp($Corr,$Parci,$Ano,$Mes,$TipoEst,$ArrPrecios)
{
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$MesSumaCu=$Fila[acuerdo_contractual_qp_cu]+$Mes;
		if($MesSumaCu>12)
		{	
			$MesDeEntregaValorCu=$MesSumaCu-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaCu<=0)
		{
			$MesDeEntregaValorCu=12-$MesSumaCu;
			$AnoAux=$Ano-1;
		}
		if($MesSumaCu<12&&$MesSumaCu>0)
		{
			$MesDeEntregaValorCu=$Fila[acuerdo_contractual_qp_cu]+$Mes;		
			$AnoAux=$Ano;
		}		
		
		$MesSumaAg=$Fila[acuerdo_contractual_qp_ag]+$Mes;
		if($MesSumaAg>12)
		{	
			$MesDeEntregaValorAg=$MesSumaAg-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaAg<=0)
		{
			$MesDeEntregaValorAg=12-$MesSumaAg;
			$AnoAux=$Ano-1;
		}
		if($MesSumaAg<12&&$MesSumaAg>0)
		{
			$MesDeEntregaValorAg=$Fila[acuerdo_contractual_qp_ag]+$Mes;		
			$AnoAux=$Ano;
		}		
		
		$MesSumaAu=$Fila[acuerdo_contractual_qp_au]+$Mes;
		if($MesSumaAu>12)
		{	
			$MesDeEntregaValorAu=$MesSumaAu-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaAu<=0)
		{
			$MesDeEntregaValorAu=12-$MesSumaAu;
			$AnoAux=$Ano-1;
		}
		if($MesSumaAu<12&&$MesSumaAu>0)
		{
			$MesDeEntregaValorAu=$Fila[acuerdo_contractual_qp_au]+$Mes;		
			$AnoAux=$Ano;
		}		
		if($Fila[acuerdo_contractual]=='P'||$Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1)//CAMBIO QP
			{		
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorCu."' and cod_ley='1'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorCobre=$ValorCobre+$Fila["valor"];
				else
					$ValorCobre=$ValorCobre+0;
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAg."' and cod_ley='2'";
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorPLata=$ValorPLata+$Fila["valor"];
				else
					$ValorPLata=$ValorPLata+0;	
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAu."' and cod_ley='3'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorOro=$ValorOro+$Fila["valor"];
				else
					$ValorOro=$ValorOro+0;	
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$ValorCobre=$ValorCobre+$Fila[precio_fijo_cu];
				$ValorPLata=$ValorPLata+$Fila[precio_fijo_ag];
				$ValorOro=$ValorOro+$Fila[precio_fijo_au];
			}
		}
	}	
	$ArrPrecios[1][Cu]=$ValorCobre;
	$ArrPrecios[2][Ag]=$ValorPLata;
	$ArrPrecios[3][Au]=$ValorOro;
}
function ValorEstados($Corr,$Parci,$Ano,$Mes,$TipoEst)
{
	$Consulta="select ano,mes,acuerdo_contractual_qp from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{	
			$Acuerdo_contractual_qp=$Fila[acuerdo_contractual_qp];	
			$MesDeEntregaValor=$Mes+$Acuerdo_contractual_qp;
			$Consulta="select * from scop_precios_metales where ano='".$Fila["ano"]."' and mes='".$MesDeEntregaValor."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);$Existe='';
			if($Fila=mysql_fetch_array($Resp))
					$Existe=1;
	}
	return($Existe);
}
?>