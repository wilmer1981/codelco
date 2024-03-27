<? 
include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");



if ($Opc=='M')
{
    $DatosConsulta=explode("~",$Datos);
	$Consulta="select * from scop_carry_cost_proceso where corr='".$DatosConsulta[0]."' and parcializacion='".$DatosConsulta[1]."' and cod_tipo_titulo='1' and cod_ley='".$CPO."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$CmbInventario=$Fila["cod_ley"];
		if($Check=='1')
			$ValorRedondeo=$Fila["valor"];
		else
			$ValorParcializar=$Fila["valor"];	
	}
}	
?>
<html>
<head>
<title>Modificar Parcializaci�n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/scop_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			if(f.TxtContrato.value=='')
			{
				alert("Debe Ingresar Contrato");
				f.TxtContrato.focus();
				return;
			}
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "M":
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}	
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
				f.action = "pcip_mantenedor_contratos_compra_facturas_proceso01.php?Opcion="+Opcion;
				f.submit();
				break;
		case "R":	
				f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv.php";
				f.submit();
		break;
				
	}
}
function Modificar(Datos,Checked,TipoEst,Acu,CPO)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=M&Datos="+Datos+"&TipoEst="+TipoEst+"&Check="+Checked+"&Acu="+Acu+"&Acu="+Acu+"&CPO="+CPO;
	f.submit();
}
function Eliminar(Datos,Checked,TipoEst,Acu,CPO)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion=E&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
	f.submit();
}
function Recarga(Opc,Datos,TipoEst,Acu,CPO)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc="+Opc+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Check="+Checked+"&Acu="+Acu+"&CPO="+CPO;
	f.submit();
}
function ProcesaChecked(Opc,Datos,TipoEst,Acu,CPO)
{
	var f= document.FrmPopupProceso;
	var Valor='';
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="Dato" && f.elements[i].checked==true)
		{
			Valor = Valor+f.elements[i].value;
		}	
	}
	f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc="+Opc+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Check="+Valor+"&Acu="+Acu+"&CPO="+CPO;
	f.submit();
}
function ProcesoParcializacion(Opc,Checked,Datos,TipoEst,Acu,CPO)
{
	var f= document.FrmPopupProceso;
	if(Checked=='1')
	{
		if(f.CmbInventario.value=='-1')
		{
			alert("Debe Seleccionar Inventario");
			f.CmbInventario.focus();
			return;
		}
		if(f.ValorRedondeo.value==''||f.ValorRedondeo.value=='0')
		{
			alert("Debe ingresar el Valor Redondeo");
			f.ValorRedondeo.focus();
			return;
		}
		if(f.ValorRedondeo.value > f.ValorProcesado.value)
		{
			alert("El Numero Redondeado no Puede ser mayor que el Original");	
		}
		else
		{
			if(Opc=='N')
			{
				f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion=RE&Check="+Checked+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
				f.submit();
			}
			else
			{
				f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion="+Opc+"&Check="+Checked+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
				f.submit();
			}	
		}
	}
	else
	{
		if(f.CmbInventario.value=='-1')
		{
			alert("Debe Seleccionar Inventario");
			f.CmbInventario.focus();
			return;
		}
		if(f.ValorParcializar.value==''||f.ValorParcializar.value=='0')
		{
			alert("Debe ingresar el Valor Parcializado");
			f.ValorParcializar.focus();
			return;
		}
		var ValorProcesado = ReemplazarComasPorPuntos(f.ValorProcesado.value.toString())
		if(f.ValorParcializar.value > ValorProcesado)
		{
			alert("El Valor Parcializado no Puede ser mayor que el Original");	
		}
		else
		{
			if(Opc=='N')
			{
				f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion=PA&Check="+Checked+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
				f.submit();
			}
			else
			{
				f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion="+Opc+"&Check="+Checked+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
				f.submit();
			}	
		}
	}
}
function ReemplazarComasPorPuntos(Str)
{
	Str=Str.replace( /\./g,'');
	return(Str.replace(',','.'));
}
function VValorOriginal(Codigox,TipoEstx,Acu,CPO)
{
    var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_desglozar_inv01.php?Opcion=VVO&Valores="+Codigox+"&TipoEst="+TipoEstx+"&Acu="+Acu+"&CPO="+CPO;
	f.submit();
}
function Salir(TipoEst)
{
   var f= document.FrmPrincipal;
   window.opener.document.FrmPrincipal.action='scop_proceso_cobertura_carry_cost.php?&Buscar=S&TipoEst='+TipoEst;
   window.opener.document.FrmPrincipal.submit();
   window.close();
}
</script>
</head>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<form name="FrmPopupProceso" method="post" action="">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../scop_web/archivos/subtitulos/sub_tit_mod_inventario.png"></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"></a> <a href="JavaScript:Salir('<? echo $TipoEst;?>')"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="120" class="formulario2">A&ntilde;o</td>
           <td class="formulario2" colspan="5">
		   <?   //ACA VIENE CORRELATIVO  PARCIALIZACION A�O MES 
				$Datos1=explode("~",$Datos);
 				echo $Datos1[2];?></td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="120" class="formulario2">Mes</td>
           <td class="formulario2" colspan="6"><? echo $Meses[$Datos1[3]-1];?></td>
         </tr>		 		 
          <tr>
            <td class="formulario2">Inventario</td>
            <td width="168" class="formulario2">
			<?
			 if($Opc!='M')
			 {
						if($CPO=='1')
							$v='Cu';
						if($CPO=='2')
							$v='Ag';
						if($CPO=='3')
							$v='Au';
			 		echo $v;
					echo "<input type='hidden' size='10' name='CmbInventario' value='".$CPO."'>";
			  }
			  else
			  {
			  	if($CPO=='1')
					$CmbInventario1='Cu';
			  	if($CPO=='2')
					$CmbInventario1='Ag';
			  	if($CPO=='3')
					$CmbInventario1='Au';
			  	echo $CmbInventario1;
				echo "<input type='hidden' name='CmbInventario' value='".$CPO."'>";
			  }		
			 ?>				</td>
			<?
				$Consulta="select * from scop_carry_cost where corr='".$Datos1[0]."' and parcializacion='".$Datos1[1]."' and ano='".$Datos1[2]."' and mes='".$Datos1[3]."'";
				$Resp = mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Consulta1="select * from scop_carry_cost_por_contratos where corr='".$Fila["corr"]."'";
					$Resp1 = mysql_query($Consulta1);
					while($Fila1=mysql_fetch_array($Resp1))
					{	
						$Contratos=$Contratos.$Fila1[cod_contratos]."~";
						$ConsultaFlujos="select * from scop_contratos_flujos t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.cod_contrato='".$Fila1[cod_contratos]."' and t1.cod_contrato<>'' and t1.tipo_inventario='4'";
						$RespFlujos = mysql_query($ConsultaFlujos);
						while($FilaFlujos=mysql_fetch_array($RespFlujos))
						{
							if($FilaFlujos[tipo_inventario]=='1'||$FilaFlujos[tipo_inventario]=='4')
								$TipoMovimiento=3;
							else
								$TipoMovimiento=2;		
							$Signo=$FilaFlujos["signo"];
							$ConsultaEnabal="select cobre,plata,oro";
							$ConsultaEnabal.=" from scop_datos_enabal where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."' and origen='".$FilaFlujos[tipo_flujo]."' and cod_flujo='".$FilaFlujos["flujo"]."' and tipo_mov='".$TipoMovimiento."'";		
							$RespEnabal=mysql_query($ConsultaEnabal);
							while($FilaEnabal=mysql_fetch_array($RespEnabal))
							{
								if($Acu!='P')
								{
									if($FilaFlujos[acuerdo_cu]==$Acu)
									{
										if($Signo=='1')
											$ValorCobre=$ValorCobre+$FilaEnabal[cobre];
										else
											$ValorCobre=$ValorCobre-$FilaEnabal[cobre];
									}												
									else
										$ValorCobre=$ValorCobre+0;	
									if($FilaFlujos[acuerdo_ag]==$Acu)
									{
										if($Signo=='1')
											$ValorPLata=$ValorPLata+$FilaEnabal[plata];
										else
											$ValorPLata=$ValorPLata-$FilaEnabal[plata];
									}
									else
										$ValorPLata=$ValorPLata+0;		
									if($FilaFlujos[acuerdo_au]==$Acu)
									{
										if($Signo=='1')
											$ValorOro=$ValorOro+$FilaEnabal[oro];
										else
											$ValorOro=$ValorOro-$FilaEnabal[oro];
									}
									else
										$ValorOro=$ValorOro+0;												
								}
								else
								{
									if($Signo=='1')
									{
										$ValorCobre=$ValorCobre+$FilaEnabal[cobre];
										$ValorPLata=$ValorPLata+$FilaEnabal[plata];
										$ValorOro=$ValorOro+$FilaEnabal[oro];
									}
									else
									{
										$ValorCobre=$ValorCobre-$FilaEnabal[cobre];
										$ValorPLata=$ValorPLata-$FilaEnabal[plata];
										$ValorOro=$ValorOro-$FilaEnabal[oro];
									}	
								}
							}
						}												
					}
					if($Contratos!='')
						$Contratos=substr($Contratos,0,strlen($Contratos)-1);
					echo "<input type='hidden' name='Contratos' value=".$Contratos.">";	
					if($CPO==1)
							$ValorOri=round(Convertir2($ValorCobre,'Cobre'),3);
					if($CPO==2)					
							$ValorOri=Convertir2($ValorPLata,'Plata');	
					if($CPO==3)
							$ValorOri=Convertir2($ValorOro,'Oro');	
				}
//				if($Opc!='M')
//					$TipoEst=$TipoEst."~";					
			?>
            <td width="302" class="formulario2">Valor Original &nbsp;<? echo number_format($ValorOri,3,',','.'); echo "<input type='hidden' name='ValorOriginal' value='".number_format($ValorOri,3,',','.')."'";?> </td>
            <td width="450" align="right" class="formulario2">
			Redondear:
			  <input class="SinBorde" type="radio" name="Dato" value="1" onClick="JavaScript:ProcesaChecked('<? echo $Opc;?>','<? echo $Datos;?>','<? echo $TipoEst;?>','<? echo $Acu;?>','<? echo $CPO;?>')" <? if($Check==1)	echo "Checked";?>>
			&nbsp;&nbsp;Parcializar: <input type="radio" class="SinBorde" name="Dato" value="2" onClick="JavaScript:ProcesaChecked('<? echo $Opc;?>','<? echo $Datos;?>','<? echo $TipoEst;?>','<? echo $Acu;?>','<? echo $CPO;?>')" <? if($Check==2)	echo "Checked";?>></td>
			<? 
				if($Check==1)//VALOR DEDONDEADO
				{
				  echo "<td width='139' align='right' class='formulario2'>Valor a Redondear</td>";
					echo "<td width='224' class='formulario2'><span class='TituloCabecera'><span class='formulariosimple'>";
				    echo "<input name='ValorRedondeo' maxlength='12' onKeyDown='SoloNumerosyNegativo(true,this)' size='13' type='text' id='ValorRedondeo' value=".number_format($ValorRedondeo,0,',','.').">";
				  echo "&nbsp;&nbsp;<a href=JavaScript:ProcesoParcializacion('".$Opc."','".$Check."','".$Datos."','".$TipoEst."','".$Acu."','".$CPO."')><img src='archivos/grabar.png' alt='Guardar'  border='0' align='absmiddle' /></a></span></span></td>";
				}
				if($Check==2)//VALOR PARCIALIZADO
				{ 
				  echo "<td width='139' align='right' class='formulario2'>Valor a Parcializar</td>";
					echo "<td width='224' class='formulario2'><span class='TituloCabecera'><span class='formulariosimple'>";
				    echo "<input name='ValorParcializar' maxlength='12' onKeyDown='SoloNumerosyNegativo(true,this)' size='13' type='text' id='ValorParcializar' value=".$ValorParcializar.">";
				  echo "&nbsp;&nbsp;<a href=JavaScript:ProcesoParcializacion('".$Opc."','".$Check."','".$Datos."','".$TipoEst."','".$Acu."','".$CPO."')><img src='archivos/agregar.png' alt='Guardar'  border='0' align='absmiddle' /></a></span></span></td>";
				}
				if($Check!=2&&$Check!=1)
				{				
				  echo "<td width='139' align='right' class='formulario2'>&nbsp;</td>";
				  echo "<td width='224' class='formulario2'><span class='TituloCabecera'><span class='formulariosimple'>";
				}
			?>
            </tr>
          <tr>
           <td colspan="6" align="left" class="formulario2"><table width="60%" border="1" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
             <tr align="center">
               <td width="20%" class="TituloTablaVerde">Elim/Mod</td>
               <td width="20%" class="TituloTablaVerde">Inventario</td>
               <td width="25%" class="TituloTablaVerde">N&ordm; Parcializaci&oacute;n </td>
               <td width="35%" class="TituloTablaVerde">Valor Parcializado </td>
               </tr>
			   <?
				 $Consulta="select distinct(corr) from scop_carry_cost t1";
				 $Consulta.=" where t1.corr='".$Datos1[0]."' and t1.ano='".$Datos1[2]."' and t1.mes='".$Datos1[3]."' order by corr";
				 $Resp = mysqli_query($link, $Consulta);
				 while($Fila=mysql_fetch_array($Resp))
				 {
				 	$ConsultaProceso="select distinct(corr),cod_ley,parcializacion,valor,cod_tipo_titulo from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and cod_ley='".$CPO."' and cod_tipo_titulo='1'  order by corr,cod_ley";
					//echo $ConsultaProceso."<br>";
					$RespProceso = mysql_query($ConsultaProceso);
					while($FilaProceso=mysql_fetch_array($RespProceso))
				    {
						if($FilaProceso["cod_ley"]==1)
							$Inv='Cu';
						if($FilaProceso["cod_ley"]==2)
							$Inv='Ag';
						if($FilaProceso["cod_ley"]==3)
							$Inv='Au';
						 echo "<tr>";
							if($FilaProceso[parcializacion]!='1')
							{
								$Cod=$Fila["corr"]."~".$FilaProceso[parcializacion]."~".$Datos1[2]."~".$Datos1[3]."~".$CPO;
								if($FilaProceso["cod_ley"]==$CPO)
								{
									echo "<td align='center'><a href=JavaScript:Eliminar('".$Cod."','".$Check."','".$TipoEst."','".$Acu."','".$CPO."')><img src='archivos/eliminar2.png'  border='0' alt='Nuevo' align='absmiddle'></a>
									<a href=JavaScript:Modificar('".$Cod."','".$Check."','".$TipoEst."','".$Acu."','".$CPO."')><img src='archivos/modificar2.png'  border='0'  alt='Nuevo' align='absmiddle'></a></td>";
								}
								else
									echo "<td align='center'>&nbsp;</td>"; 
							}
							else
							{
								$ConsultaVolver="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion > 1 and cod_tipo_titulo='1' and cod_ley='".$FilaProceso["cod_ley"]."'";
								$RespVolver = mysql_query($ConsultaVolver);
								if(!$FilaVolver=mysql_fetch_array($RespVolver))
								{	
									$Cod=$Fila["corr"]."~".$FilaProceso[parcializacion]."~".$Datos1[2]."~".$Datos1[3];
									$ValorParc1=$FilaProceso["valor"];
									//echo "valor parcializado".$ValorParc1."&nbsp;valor original:  ".round($ValorOri,3);
									if($ValorParc1!=round($ValorOri,3))
										echo "<td align='center'><a href=JavaScript:VValorOriginal('".$Cod."','".$TipoEst."','".$Acu."','".$CPO."')><img src='archivos/rewind.png'  border='0' alt='Volver al Valor Original' align='absmiddle'></a><input type='hidden' name='VVOriginal' value='".$ValorOri."'></td>";
									else
										echo "<td align='center'>&nbsp;</td>";	
								}
								else
									echo "<td align='center'>&nbsp;</td>";
						   	}
						   echo "<td align='center'>".$Inv."</td>";
						   echo "<td align='center'>N�&nbsp;".$FilaProceso[parcializacion]."<input type='hidden' size='2' name='Parcializa' value='".$Fila[parcializacion]."'></td>";
						   echo "<td align='center'>".number_format($FilaProceso["valor"],3,',','.')."</td>";
						   if($FilaProceso[parcializacion]==1)
						   {
						   		if($FilaProceso["cod_ley"]==$CPO)
						   			echo "<input type='hidden' name='ValorProcesado' value='".$FilaProceso["valor"]."'";
						   }
						 echo "</tr>";
					}
				 }
			   ?>
           </table>
		   <p>&nbsp;</p></td>
          </tr>

       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
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
	if ($Mensaje=='R')
		echo "alert('Proceso Redondeo Exitoso');";
	if ($Mensaje=='P')
		echo "alert('Proceso Parcializaci�n Exitoso');";
	if ($Mensaje=='VVO')
		echo "alert('Valor Redondeado a Valor Original');";
	if ($Mensaje=='NE')
		echo "alert('No se puede Eliminar, Existe Parcializaci�n Mayor');";
	if ($Mensaje=='EE')
		echo "alert('Parcializaci�n Eliminada Con Exito');";
	echo "</script>";
?>
<?
function Convertir2($Valor,$Dato)
{
	switch($Dato)
	{
		case "Cobre"://DE KG A lb
				$ValorSalida=$Valor*2.2;
		break;
		case "Plata"://de grs a OZ
		case "Oro"://de grs a OZ
				$ValorSalida=$Valor*0.032150746568628;
		break;
	}
	return($ValorSalida);
}
?>