<? 
include("../principal/conectar_scop_web.php");
$KoolControlsFolder="KoolPHPSuite/KoolControls";
require $KoolControlsFolder."/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";


if($koolajax->isCallback)
{
	sleep(1); //Slow down 1s to see loading effect
}
echo $koolajax->Render();

if($Opc=='M')
{	
	$Datos=explode("~",$Valores);
	$Consulta = "select * from scop_carry_cost where corr='".$Corr."'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$Ano=$Fila["ano"];
		$CmbMes=$Fila["mes"];
		$CmbAcuerdo=$Fila["acuerdo_contractual"];
	}
}
else
{
	if(!isset($Ano))
		$Ano=date('Y');	
}
if($Opc=='NI')
{
	if(!isset($Ano))
		$Ano=date('Y');	
	$CmbAcuerdo='S';
	$CmbMes='-1';
}
?>
<html>
<head>
<?
	if ($Opc=='N'||$Opc=='NI')
		echo "<title>Inventario para Cobertura</title>";
	else	
		echo "<title>Inventario para Cobertura</title>";
?>
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
		case "C":
			if(f.Ano.value=='-1')
			{
				alert("Debe Seleccionar A�o");
				f.Ano.focus();
				return;
			}			
			if(f.CmbAcuerdo.value=='S')
			{
				alert("Debe Seleccionar Acuerdo Contractual");
				f.CmbAcuerdo.focus();
				return;
			}			
			else
			{
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="Acuerdo" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}
				if(Valores2=='')
				{
					alert('Debe Seleccionar un Tipo de Acuerdo')
					return;				
				}
				else
				{
					if(f.CmbMes.value=='-1')
					{
						alert("Debe Seleccionar Mes");
						f.CmbMes.focus();
						return;
					}
					else
					{	
						f.action="scop_proceso_cobertura_carry_cost_proceso.php?Opc=N&Buscar=S&TipoEst="+Valores2+"&CmbMes="+f.CmbMes.value;
						f.submit();
					}
				}
			}
		break;
		case "M":
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Descripci�n de Contrato");
				f.TxtDescripcion.focus();
				return;
			}
			if(f.CmbTipoContrato.value=='-1')
			{
				alert("Debe Seleccionar Tipo Contrato");
				f.CmbTipoContrato.focus();
				return;
			}			
			if(f.CmbVig.value=='-1')
			{
				alert("Debe Seleccionar Vigente");
				f.CmbVig.focus();
				return;
			}		
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion;
			f.submit();
			break;
		case "NI":
				f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Opc=NI";
				f.submit();
				break;
		case "R":	
				f.action = "scop_mantenedor_contratos_proceso.php?";
				f.submit();
		break;
				
	}
}
function Excel(Opc,TipoEst,TipoExcel,ContInvo)
{
	var f=document.FrmPopupProceso;
	var Contratos;
	if(TipoExcel==1)
	{
		URL='scop_proceso_cobertura_carry_cost_proceso_excel_resumen.php?&Ano='+f.Ano.value+'&CmbAcuerdo='+f.CmbAcuerdo.value+'&TipoEst='+TipoEst+'&CmbMes='+f.CmbMes.value;
		window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
	}
	else
	{
		if(ContInvo=='')
			Contratos=f.ConSelec.value;
		else
		{
			ContInvo=ContInvo.substr(0,ContInvo.length-1);
			Contratos=ContInvo;
		}		
		URL='scop_proceso_cobertura_carry_cost_proceso_excel_detalle.php?&Ano='+f.Ano.value+'&CmbAcuerdo='+f.CmbAcuerdo.value+'&TipoEst='+TipoEst+'&CmbMes='+f.CmbMes.value+'&Contratos='+Contratos;
		window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
	}
}
function GrabarProceso(Opcion,TipoEst,ConInvo)
{
	var f= document.FrmPopupProceso;
	var MDatos='';
	if(f.Grabar.value=='1')
	{
		if(f.Ano.value=='-1')
		{
			alert("Debe Seleccionar Ano");
			f.Ano.focus();
			return;
		}	
		if(Opcion=='N')
		{	
			if(f.CmbAcuerdo.value=='S')
			{
				alert("Debe Seleccionar Acuerdo Contractual");
				f.CmbAcuerdo.focus();
				return;
			}			
			else
			{
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="Acuerdo" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}
				if(Valores2=='')
				{
					alert('Debe Seleccionar un Tipo de Acuerdo')				
				}
			}
			if(f.CmbMes.value=='-1')
			{
				alert("Debe Seleccionar Mes");
				f.CmbMes.focus();
				return;
			}	
		}
		if(f.CmbTipoCobertura.value=='-1')
		{
			alert("Debe Seleccionar Tipo Cobertura");
			f.CmbTipoCobertura.focus();
			return;
		}	
		if(f.CmbTipoCobertura.value=='2')
		{		
			MDatos=TipoEst.split('~');
			for(i=0;i<=MDatos.length;i++)//SEPARO SI ES CU, AG AU
			{		
				if(MDatos[i]=='Cu')
				{
					if(f.ValorPrecioFijoCu.value=='')
					{
						alert("Debe Ingresar Precio Fijo Cobre");
						f.ValorPrecioFijoCu.focus();
						return;
					}
				}
				if(MDatos[i]=='Ag')
				{
					if(f.ValorPrecioFijoAg.value=='')
					{
						alert("Debe Ingresar Precio Fijo Plata");
						f.ValorPrecioFijoAg.focus();
						return;
					}
				}
				if(MDatos[i]=='Au')
				{
					if(f.ValorPrecioFijoAu.value=='')
					{
						alert("Debe Ingresar Precio Fijo Oro");
						f.ValorPrecioFijoAu.focus();
						return;
					}
				}
			}		
		}
		else
		{
			MDatos=TipoEst.split('~');
			for(i=0;i<=MDatos.length;i++)//SEPARO SI ES CU, AG AU
			{		
				if(MDatos[i]=='Cu')
				{
					if(f.CmbAcuerdoCarryCu.value=='N')
					{
						alert("Debe Seleccionar QP Cobre");
						f.CmbAcuerdoCarryCu.focus();
						return;
					}			
				}
				if(MDatos[i]=='Ag')
				{
					if(f.CmbAcuerdoCarryAg.value=='N')
					{
						alert("Debe Seleccionar QP Plata");
						f.CmbAcuerdoCarryAg.focus();
						return;
					}
				}
				if(MDatos[i]=='Au')
				{
					if(f.CmbAcuerdoCarryAu.value=='N')
					{
						alert("Debe Seleccionar QP Oro");
						f.CmbAcuerdoCarryAu.focus();
						return;
					}
				}
			}		
		}
		if(Opcion=='N')	
		{
			ConInvo=ConInvo.substr(0,ConInvo.length-1);
			f.action="scop_proceso_cobertura_carry_cost01.php?Opcion="+Opcion+"&TipoEst="+Valores2+"&ContInvo="+ConInvo;
			f.submit();
		}
		else
		{
			f.action="scop_proceso_cobertura_carry_cost01.php?Opcion="+Opcion+"&TipoEst="+TipoEst+"&ContInvo="+ConInvo;
			f.submit();
		}	
	}
	else
	{
		alert("Debe Seleccionar los Criterios de Busqueda y Luego Grabar");
		return;
	}
}
function ProcesoFlujo()
{
	var popup=0;
	var f= document.FrmPopupProceso;
	URL="scop_mantenedor_contratos_otros_flujos.php?Opc=NF";
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=750,height=450,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
function Recarga(Opc)
{
var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Opc="+Opc;
	f.submit();
}
function Salir()
{
	window.close();
}
function RecargaCombos(Opc,TipoEst,Mes)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Opc="+Opc+"&Buscar=S&TipoEst="+TipoEst+"&CmbMes="+Mes;
	f.submit();
}
function RecargaAcuerdo(Opc)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Opc=N";
	f.submit();
}
function RecargaAcuerdo2(Opc)
{
	var f= document.FrmPopupProceso;
	var Valores2='';
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="Acuerdo" && f.elements[i].checked==true)
		{
			Valores2 = Valores2+f.elements[i].value+"~";
		}	
	}
	if(Valores2=='')
	{
		alert('Debe Seleccionar un Tipo de Acuerdo')				
	}
	else
	{
		f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Opc="+Opc+"&TipoEst="+Valores2;
		f.submit();
	}
}
function RecargaContratos(Opc,TipoEst,Mes)
{
var f= document.FrmPopupProceso;
	var Valores3='';
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="ContInvo2" && f.elements[i].checked==true)
		{
			Valores3 = Valores3+f.elements[i].value+"~";
		}	
	}
	if(Valores3=='')
	{
		alert('Debe Seleccionar Contrato(s)')				
	}
	else
	{		
		f.action = "scop_proceso_cobertura_carry_cost_proceso.php?Buscar=S&Opc="+Opc+"&TipoEst="+TipoEst+"&CmbMes="+Mes+"&ContInvo="+Valores3;
		f.submit();
	}
}
function DetalleContrato(Datos,Contrato)
{
	var popup=0;
	var f= document.FrmPopupProceso;
	URL="scop_proceso_cobertura_carry_cost_proceso_detalle.php?Datos="+Datos+"&Contrato="+Contrato;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1200,height=300,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
</script>
<script type="text/javascript">
	function select_customer()
	{
		var _customerNumner = document.getElementById("CmbAcuerdo").value;			
		if(_customerNumner!="")
		{
			order_UPDATEpanel.attachData("customerNumber",_customerNumner);
			order_UPDATEpanel.UPDATE();
			SeleccionMes()
		}
	}
	function SeleccionMes()
	{
		var _Ano = document.getElementById("Ano").value;
		var _Acuerdo=document.getElementById("CmbAcuerdo").value;
		var _DatosCombbo=_Ano+"~"+_Acuerdo;
		if(_DatosCombbo!="")
		{
			order_UPDATEpanel2.attachData("DatosCombo",_DatosCombbo);
			order_UPDATEpanel2.UPDATE();
		}
	}
	function TipoCobertura()
	{
		var _TipoCo=document.getElementById("CmbTipoCobertura").value;
		var _CompraVenta=document.getElementById("CmbComVen").value;
		if(_TipoCo==2)
			var _Valores=_TipoCo+"~"+_CompraVenta;
		else
			var _Valores=_TipoCo;
		if(_Valores!="")
		{
			order_UPDATEpanel3.attachData("Datos",_Valores);
			order_UPDATEpanel3.UPDATE();
		}
	}
	function TipoCobertura2()
	{
		var _TipoCo=document.getElementById("CmbTipoCobertura").value;
		if(_TipoCo!="")
		{
			order_UPDATEpanel4.attachData("TipoCo",_TipoCo);
			order_UPDATEpanel4.UPDATE();
		}
	}
</script>	

</head>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post">
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../scop_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../scop_web/archivos/subtitulos/sub_tit_carry_cost_inv_cobertura.png"><? }else{?><img src="../scop_web/archivos/subtitulos/sub_tit_carry_cost_inv_cobertura.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('C')"><img src="archivos/buscar2.png"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a><a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <?
	   	if($CmbAcuerdo!='T')
		{
	   ?>
	   	<a href="JavaScript:GrabarProceso('<? echo $Opc;?>','<? echo $TipoEst?>','<? echo $ContInvo?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a> 
	   <?
	    }
	   ?>
	   <a href="JavaScript:Salir()"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center">
	    <table width="100%" border="0" cellpadding="3" cellspacing="0" >
		 <tr>
		  <td width="110" class="formulario2">A&ntilde;o</td>
           <td colspan="2" class='formulario2'>
		   <?
		   	if($Opc=='N'||$Opc=='NI')
			{
		   ?>
			   <select name="Ano" id="Ano">
			   <option value="-1" class="NoSelec">Seleccionar</option>
				 <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>			
			   </select>
			<?
			}
			else
			{
				echo $Ano;
				echo "<input type='hidden' name='Ano' value='".$Ano."'>";
			}
			?>			</td>		  	
		  	<td width="791" class='formulario2' >			</td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="110" class="formulario2">Acuerdo <span class="formulariosimple"> Contractual</span></td>           
		   <?
		    if($Opc=='N'||$Opc=='NI')
			{
		   ?>
		   <td class="formulariosimple">
		   <span class="formulario2">
             <select name="CmbAcuerdo" id="CmbAcuerdo" onChange="JavaScript:RecargaAcuerdo('<? echo $Opc;?>')">
               <option value="S" class="NoSelec">Seleccionar</option>
               <?
			   if("T"==$CmbAcuerdo)
			   {
		   		?>
               <option value="T" selected>Todos</option>
               <?
			   }
			   else
			   {
			   ?>
               <option value="T" >Todos</option>
               <?
			   }	
			   if("P"==$CmbAcuerdo)
			   {
		   		?>
               <option value="P" selected>Precio Fijo</option>
               <?
			   }
			   else
			   {
			   ?>
               <option value="P">Precio Fijo</option>
			   <?
			   }
			   if("-1"==$CmbAcuerdo)
			   {
		   		?>
               <option value="-1" selected>Mes -1</option>
               <?
			   }
			   else
			   {
		   		?>
               <option value="-1">Mes -1</option>
               <?
			   }
				for($i=1;$i<=6;$i++)
				 {
				   if($i==$CmbAcuerdo)
						echo "<option value='".$i."' selected>Mes+".$i."</option>";
				   else
						echo "<option value='".$i."'>Mes+".$i."</option>";
				 }
		  		 ?>
             </select></span><span class="InputRojo">(*)</span></td>
		   <td class="formulariosimple">&nbsp;</td>
		   <?
		    }
		    else
			{
				echo "<td class='formulario2' colspan='2'>&nbsp;M+".$CmbAcuerdo."";
				echo "<input type='hidden' name='CmbAcuerdo' value='".$CmbAcuerdo."'></td>";
				
			}	?>			
		   <td class='formulario2'><span class="formulariosimple">
		     <?
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					if($CmbAcuerdo=='T')
					{
						echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Cu' checked disabled>Acuerdo Cu";
						echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Ag' checked disabled>Acuerdo Ag";
						echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Au' checked disabled>Acuerdo Au";
					}
					else
					{
						if($CmbAcuerdo!='P'&&$CmbAcuerdo!='S')
							$Tipo='1';
						if($CmbAcuerdo=='P')
							$Tipo='2';	
						$ConsultaChecke="select * from scop_carry_cost t1 inner join scop_carry_cost_proceso t2 on t1.corr=t2.corr and t1.parcializacion=t2.parcializacion";
						$ConsultaChecke.=" where t1.ano='".$Ano."' and t1.mes='".$CmbMes."' and t2.cod_ley='1'and t2.cod_ley='2'and t2.cod_ley='3'";
						$ConsultaChecke.=" and acuerdo_contractual='".$CmbAcuerdo."'";
						//echo $ConsultaChecke."<br>";
						$RespChecke=mysql_query($ConsultaChecke);
						if($FilaChecke=mysql_fetch_array($RespChecke))
						{
							echo "Inventario(Cu,Ag,Au) para Cobertura realizado para este A�o, Acuerdo y Mes";
						}
						$ConsultaChecke="select * from scop_carry_cost t1 inner join scop_carry_cost_proceso t2 on t1.corr=t2.corr and t1.parcializacion=t2.parcializacion";
						$ConsultaChecke.=" where t1.ano='".$Ano."' and t1.mes='".$CmbMes."' and t2.cod_ley='1'";
						$ConsultaChecke.=" and acuerdo_contractual='".$CmbAcuerdo."'";
						$RespChecke=mysql_query($ConsultaChecke);
						if(!$FilaChecke=mysql_fetch_array($RespChecke))
						{
								$ConsultaAcuerdo="select * from scop_contratos where tipo_cu='".$Tipo."' and vigente='1'";
								if($Tipo!='2')
									$ConsultaAcuerdo.=" and acuerdo_cu='".$CmbAcuerdo."'";
								$RespAcuerdo=mysql_query($ConsultaAcuerdo);
								if($FilaAcuerdo=mysql_fetch_array($RespAcuerdo))
								{
									echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Cu'";
									for($i=0;$i<=$x;$i++)
									{
										echo $arreglo[$i][0];
										if('Cu'==$arreglo[$i][0])
										echo " checked ";	
									}
									echo ">Acuerdo Cu&nbsp;&nbsp;";
								}
						}
							
						$ConsultaChecke="select * from scop_carry_cost t1 inner join scop_carry_cost_proceso t2 on t1.corr=t2.corr and t1.parcializacion=t2.parcializacion";
						$ConsultaChecke.=" where t1.ano='".$Ano."' and t1.mes='".$CmbMes."' and t2.cod_ley='2'";
						$ConsultaChecke.=" and acuerdo_contractual='".$CmbAcuerdo."'";
						$RespChecke=mysql_query($ConsultaChecke);
						if(!$FilaChecke=mysql_fetch_array($RespChecke))
						{
							$ConsultaAcuerdo="select * from scop_contratos where tipo_ag='".$Tipo."' and vigente='1'";
							if($Tipo!='2')
								$ConsultaAcuerdo.=" and acuerdo_ag='".$CmbAcuerdo."'";
							$RespAcuerdo=mysql_query($ConsultaAcuerdo);
							if($FilaAcuerdo=mysql_fetch_array($RespAcuerdo))
							{
								echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Ag'";
								for($i=0;$i<=$x;$i++)
								{
									echo $arreglo[$i][0];
									if('Ag'==$arreglo[$i][0])
									echo " checked ";	
								}
								echo ">Acuerdo Ag&nbsp;&nbsp;";
							}
						}
							
						$ConsultaChecke="select * from scop_carry_cost t1 inner join scop_carry_cost_proceso t2 on t1.corr=t2.corr and t1.parcializacion=t2.parcializacion";
						$ConsultaChecke.=" where t1.ano='".$Ano."' and t1.mes='".$CmbMes."' and t2.cod_ley='3'";
						$ConsultaChecke.=" and acuerdo_contractual='".$CmbAcuerdo."'";
						$RespChecke=mysql_query($ConsultaChecke);
						if(!$FilaChecke=mysql_fetch_array($RespChecke))
						{
							$ConsultaAcuerdo="select * from scop_contratos where tipo_au='".$Tipo."' and vigente='1'";
							if($Tipo!='2')
								$ConsultaAcuerdo.=" and acuerdo_au='".$CmbAcuerdo."'";
							$RespAcuerdo=mysql_query($ConsultaAcuerdo);
							if($FilaAcuerdo=mysql_fetch_array($RespAcuerdo))
							{
								echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Au'";
								for($i=0;$i<=$x;$i++)
								{
									echo $arreglo[$i][0];
									if('Au'==$arreglo[$i][0])
									echo " checked ";	
								}
								echo ">Acuerdo Au&nbsp;&nbsp;";
							}
						}	
					}
				?>
		   </span></td>
         </tr>		 		 		 
		 <tr>
           <td width="110" class="formulario2">Mes</td>           
		   <?		   
		   	if($Opc=='N'||$Opc=='NI')
			{
		   ?>
		   <td colspan="2" class="formulariosimple">
			   <select name="CmbMes" id="CmbMes" onChange="JavaScript:RecargaAcuerdo('<? echo $Opc;?>')">
			   <option value="-1" class="NoSelec">Seleccionar</option>
				<?						    		 		 
					$Consulta="select distinct mes from scop_inventario where ano='".$Ano."' and cod_estado='2'";							
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbMes==$Fila["mes"])
							echo "<option selected value=".$Fila["mes"].">".$Meses[$Fila["mes"]-1]."</option>\n";
						else
							echo "<option value=".$Fila["mes"].">".$Meses[$Fila["mes"]-1]."</option>\n";
					}
				?>
			   </select><?  //echo $Consulta; ?>
			   <span class="InputRojo">(*)</span>		   
			   </td>
			<?
			 }
			 else
			 {
			 	echo "<td class='formulario2'colspan='2'>".$Meses[$CmbMes-1]."";
				echo "<input type='hidden' name='CmbMes' value='".$CmbMes."'>";
			 }
			?>
			<td class='formulario2'>&nbsp;</td>
		</tr>
			<tr>
			<? if($Buscar=='S'){?>
				<td align='left' class='formulario2'>Tipo Cobertura Compra </td>	
					<td width="118" class='formulario2'>
					   <select name="CmbTipoCobertura" id="CmbTipoCobertura" onChange="RecargaCombos('<? echo $Opc;?>','<? echo $TipoEst?>','<? echo $CmbMes?>')">
					   <option value="-1" class="formulario">Selec.</option> 
					   <?
						$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='33005'";
						$Resp=mysql_query($Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbTipoCobertura==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}
					   ?>
					   </select><span class="InputRojo">(*)</span>	                </td>	
						 <td width="145" align="left" class='formulario2'>&nbsp;</td>
				         <td class='formulario2' align="left"><?
						        if($CmbTipoCobertura==2)
							  	{
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
											?>
                           <span class="formulario">Precio Fijo Cu</span>
                           <input type='hidden' name='Cober' value='2'>
                           <input type='text' name='ValorPrecioFijoCu' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)'>
                           <span class="InputRojo">(*)</span>
                           <?
										}		
										if('Ag'==$arreglo[$i][0])
										{
											?>
                           <span class="formulario">Precio Fijo Ag</span>
                           <input type='hidden' name='Cober' value='2'>
                           <input type='text' name='ValorPrecioFijoAg' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)'>
                           <span class="InputRojo">(*)</span>
                           <?
										}		
										if('Au'==$arreglo[$i][0])
										{
											?>
                           <span class="formulario">Precio Fijo Au</span>
                           <input type='hidden' name='Cober' value='2'>
                           <input type='text' name='ValorPrecioFijoAu' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)'>
                           <span class="InputRojo">(*)</span>
                           <?
										}		
									}	
							    }						   				
						        if($CmbTipoCobertura==1)
							  	{
									echo "<input type='hidden' name='Cober' value='1'>";	
									for($k=0;$k<=$x;$k++)
									{
										if('Cu'==$arreglo[$k][0])
										{
											  ?>
											   <span class="formulario">Mes Cambio  QP Cu</span>
											   <select name="CmbAcuerdoCarryCu" >
												 <option value="N" class="NoSelec">Seleccionar</option>
												 <?
											   if("-1"==$CmbAcuerdoCarryCu)
											   {
											   ?>
												 <option value="-1" selected>Mes -1</option>
												 <?
											   }
											   else
											   {
											   ?>
												 <option value="-1">Mes -1</option>
												 <?
												}
												for($i=1;$i<=6;$i++)
												{
												   if($i==$CmbAcuerdoCarryCu)
														echo "<option value='".$i."' selected>Mes+".$i."</option>";
												   else
														echo "<option value='".$i."'>Mes+".$i."</option>";
												}
												?>
												</select><span class="InputRojo">(*)</span>&nbsp;
												<?
										}
										if('Ag'==$arreglo[$k][0])
										{
											  ?>
											   <span class="formulario">Mes Cambio  QP Ag</span>
											   <select name="CmbAcuerdoCarryAg" >
												 <option value="N" class="NoSelec">Seleccionar</option>
												 <?
											   if("-1"==$CmbAcuerdoCarryAg)
											   {
											   ?>
												 <option value="-1" selected>Mes -1</option>
												 <?
											   }
											   else
											   {
											   ?>
												 <option value="-1">Mes -1</option>
												 <?
												}
												for($i=1;$i<=6;$i++)
												{
												   if($i==$CmbAcuerdoCarryAg)
														echo "<option value='".$i."' selected>Mes+".$i."</option>";
												   else
														echo "<option value='".$i."'>Mes+".$i."</option>";
												}
												?>
												</select><span class="InputRojo">(*)</span>&nbsp;
												<?
										 }
										if('Au'==$arreglo[$k][0])
										{
											  ?>
											   <span class="formulario">Mes Cambio  QP Au</span>
											   <select name="CmbAcuerdoCarryAu" >
												 <option value="N" class="NoSelec">Seleccionar</option>
												 <?
											   if("-1"==$CmbAcuerdoCarryAu)
											   {
											   ?>
												 <option value="-1" selected>Mes -1</option>
												 <?
											   }
											   else
											   {
											   ?>
												 <option value="-1">Mes -1</option>
												 <?
												}
												for($i=1;$i<=6;$i++)
												{
												   if($i==$CmbAcuerdoCarryAu)
														echo "<option value='".$i."' selected>Mes+".$i."</option>";
												   else
														echo "<option value='".$i."'>Mes+".$i."</option>";
												}
												?>
												</select><span class="InputRojo">(*)</span>
												<?
										 }
									 }	 		
									   ?>
                           
                           
                           <? }
							}
							?></td>
			</tr>
		<tr>	 		 		  				 				  	 
           <td colspan="5" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
        </tr>		 		 
       </table>
			<table width="100%"  border="1" align="center" cellpadding="3"  cellspacing="0">				 
				  <?
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					for($i=0;$i<=$x;$i++)
					{
						if('Cu'==$arreglo[$i][0])
							$Cu=1;$Colspan=4;	
						if('Ag'==$arreglo[$i][0])
							$Ag=2;$Colspan=$Colspan+4;
						if('Au'==$arreglo[$i][0])
							$Au=3;$Colspan=$Colspan+4;	
					}
					if(!isset($Buscar))
						echo "<input type='hidden' name='Grabar' value='2'>";		
				  ?>	
				  <tr>
				  <? if($Buscar=='S'){?>
				   <td class="TituloTablaVerde" colspan="4" align="center">Inventario</td>
				   <td class="TituloTablaVerde" colspan="<? echo $Colspan;?>" align="right">
				   <a href="JavaScript:Excel('EX','<? echo $TipoEst;?>','2','<? echo $ContInvo?>')"><img src="archivos/excel.png"   alt="Excel Inventario para cobertura Detalle"  border="0" align="absmiddle" /></a>
				   <a href="JavaScript:Excel('EX','<? echo $TipoEst;?>','1','')"><img src="archivos/excel.png"   alt="Excel Inventario para cobertura Resumen"  border="0" align="absmiddle" /></a></td>
				  </tr>
				    <tr class="TituloTablaVerde">
					<td width="2%">&nbsp;</td>
					<td colspan="3">Contratos</td>
					<? 
					$arregloContr=array();
					$DatosContr = explode("~",$ContInvo);
					$c=0;
					while (list($clave,$CodigoContr)=each($DatosContr))
					{
						$arregloContr[$c][0]=$CodigoContr;
						$c=$c+1; 
					}	
					
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					if($CmbAcuerdo!='P')
						$TipoAcu='1';
					else
						$TipoAcu='2';						
					for($i=0;$i<=$x;$i++)
					{		
						if('Cu'==$arreglo[$i][0])
						{
							if($CmbAcuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_cu='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_cu='".$CmbAcuerdo."' or";									
							}
							else
								$TipoCon.=" and t2.tipo_cu='".$TipoAcu."' ";
						}
						if('Ag'==$arreglo[$i][0])
						{
							if($CmbAcuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_ag='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_ag='".$CmbAcuerdo."' or";
							}
							else
								$TipoCon.=" and t2.tipo_ag='".$TipoAcu."' ";
						}										
						if('Au'==$arreglo[$i][0])
						{
							if($CmbAcuerdo!='P')
							{
								$TipoCon.=" and t2.tipo_au='".$TipoAcu."' ";
								$Dato.=" t2.acuerdo_au='".$CmbAcuerdo."' or";									
							}
							else
								$TipoCon.=" and t2.tipo_au='".$TipoAcu."' ";
						}	
					}
					if($Dato!='')
						$Dato=substr($Dato,0,strlen($Dato)-2);
					if($CmbAcuerdo!='P')
					{
						$Dato=' and ('.$Dato.')';
					}
						$Cobre="[LB]";$Plata="[OZ]";$Oro="[OZ]";
						if($Cu==1)
						{
						?>
							<td width="5%" align='center'>Cobre [Kg]</td>
							 <td width="5%" align='center'>Cobre <? echo $Cobre;?></td>
						<?
						}
						if($Ag==2)
						{
						?>
							 <td width="5%" align='center'>PLata [Grs]</td>
							 <td width="5%" align='center'>PLata <? echo $Plata;?></td>
						<?
						}
						if($Au==3)
						{
						?>
							 <td width="5%" align='center'>Oro [Grs]</td>
							 <td width="5%" align='center'>Oro <? echo $Oro;?></td>
						<?
						}
					?>
					</tr>
					<?
						if($Opc=='N'&&$Buscar=='S')
							echo "<input type='hidden' name='Grabar' value='1'>";
							$ArrFinos=array();
							$Consulta="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.mes='".$CmbMes."' and t1.cod_estado='2'";
							if($CmbAcuerdo!=='T')
								$Consulta.=" $TipoCon $Dato";
						    $Consulta.="and t2.vigente='1' group by t2.cod_contrato";
							//echo "<br>".$Consulta."<br>";
							$Resp=mysql_query($Consulta);$Contratos='';
							while ($Fila=mysql_fetch_array($Resp))
							{	
								$Consulta2=" select * from scop_contratos t1 inner join scop_contratos_flujos t2 on t1.cod_contrato=t2.cod_contrato where t2.cod_contrato='".$Fila["cod_contrato"]."' and t2.tipo_inventario='4' and t1.vigente='1'";
								//echo "<br>PARA DATOS ENABAL:    ".$Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);$ArrFinos[1][Cu]='';$ArrFinos[2][Ag]='';$ArrFinos[3][Au]='';
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									$TipoInventario=$Fila2[tipo_inventario];
									$TipoFlujo=$Fila2[tipo_flujo];
									$CodFlujo=$Fila2["flujo"];
									$Contrato=$Fila2["cod_contrato"];
									
									$Buscar2='S';
									$ValorPeso=DatosEnabalFlujos($Ano,$CmbMes,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,'4');
									
								}
								$Contratos=$Contratos.$Fila["cod_contrato"]."~";								
									echo "<tr bgcolor='#FFFFFF'>";
									$CheckedCtto="";
									if(!isset($ContInvo))
										$CheckedCtto="checked";	
									for($i=0;$i<=$c;$i++)
									{
										//echo $arregloContr[$i][0];
										if($Fila["cod_contrato"]==$arregloContr[$i][0])
											$CheckedCtto="checked";	
									}
									$DetalleContrato=$Ano."~".$CmbMes."~".$CmbAcuerdo;
									echo "<td width='29'><input name='ContInvo2'  onClick=JavaScript:RecargaContratos('".$Opc."','".$TipoEst."','".$CmbMes."') type='checkbox' class='SinBorde' value=".$Fila["cod_contrato"]." ".$CheckedCtto.">";				
									if($CmbAcuerdo=='P')
									{
										for($i=0;$i<=$x;$i++)
										{
											if('Cu'==$arreglo[$i][0])
												$PF="<span class='formulario'>&nbsp;&nbsp;P.F Cu:  ".$Fila[acuerdo_cu]."&nbsp;cUSD/Lb</span>,";
											if('Ag'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Ag:   ".$Fila[acuerdo_ag]."&nbsp;USD/Oz</span>,";
											if('Au'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Au:  ".$Fila[acuerdo_au]."&nbsp;USD/Oz</span>,";
										}
									}
									if($PF!='')
										$PF=substr($PF,0,strlen($PF)-1);
									echo "<td><a href=JavaScript:DetalleContrato('".$DetalleContrato."','".$Fila["cod_contrato"]."') class='LinkSinLinea'>".$Fila["num_contrato"]."</a></td>";									
									if($CmbAcuerdo=='P')
									{
										echo "<td>".$PF."&nbsp;</td>";
										echo "<td width='287'>".$Fila[descrip_contrato]."</td>";
									}
									else
										echo "<td width='287' colspan='2'>".$Fila[descrip_contrato]."</td>";
									echo "</td>";$ValorCobre=0;$ValorPLata=0;$ValorOro=0;
									$arreglo=array();
									$Datos = explode("~",$TipoEst);
									$x=0;
									foreach($Datos as $clave => $Codigo)
									{
										$arreglo[$x][0]=$Codigo;
										$x=$x+1; 
									}	
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_cu]==$CmbAcuerdo)
												{													
													echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
													$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
													echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}
											if($CmbAcuerdo=='P')
											{
												echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
												$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
											}
											if($CmbAcuerdo=='T')
											{
												echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
												$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
											}
										}
										if('Ag'==$arreglo[$i][0])
										{		
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_ag]==$CmbAcuerdo)
												{
													echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
													$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
													echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}
											}
											if($CmbAcuerdo=='P')		
											{
												echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
												$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
												echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
											}
											if($CmbAcuerdo=='T')		
											{
												echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
												$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
												echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
											}
										}
										if('Au'==$arreglo[$i][0])
										{
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_au]==$CmbAcuerdo)
												{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}	
											if($CmbAcuerdo=='P')
											{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
											}	
											if($CmbAcuerdo=='T')
											{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
											}	
										}
									}
								  echo "</tr>";	
								  $AcuerdoCU=$Fila2[acuerdo_cu];$AcuerdoAG=$Fila2[acuerdo_ag];$AcuerdoAU=$Fila2[acuerdo_au];						  
							}	
					$Consulta="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.mes='".$CmbMes."' and t1.cod_estado='2'";
					if($CmbAcuerdo!=='T')
						$Consulta.=" $TipoCon $Dato";
					$Consulta.=" and t2.vigente='1'";
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{	
							echo "<tr>";
									echo "<td align='right' colspan='4'>Total</td>";
									if(!isset($ContInvo))	
									{
										if($Contratos!='')
											$Contratos=substr($Contratos,0,strlen($Contratos)-1);
										echo "<input type='hidden' name='ConSelec' value='".$Contratos."'>";
										$Contratos = explode("~",$Contratos);
										$c=0;
										while (list($clave,$CodigoContr)=each($Contratos))
										{
											$arregloContr[$c][0]=$CodigoContr;
											$c=$c+1; 
										}	
									}
									else
									{
										$arregloContr=array();
										if($ContInvo!='')
											$Contratos=substr($ContInvo,0,strlen($ContInvo)-1);
										$DatosContr = explode("~",$Contratos);
										$c=0;
										while (list($clave,$CodigoContr)=each($DatosContr))
										{
											$arregloContr[$c][0]=$CodigoContr;
											$c=$c+1; 
										}	
									}		
									$ValorCobre2=0;$ValorPLata2=0;$ValorOro2=0;																
									for($i=0;$i<=$c;$i++)
									{										
										$ConsultaFlujos="select * from scop_contratos_flujos t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.cod_contrato='".$arregloContr[$i][0]."' and t1.cod_contrato<>'' and t1.tipo_inventario='4' and t2.vigente='1'";
										$RespFlujos = mysql_query($ConsultaFlujos);
										while($FilaFlujos=mysql_fetch_array($RespFlujos))
										{
											if($FilaFlujos[tipo_inventario]=='1')
											{
												if($CmbMes==1)
												{
													$AnoFlujo=$AnoFlujo-1;
													$CmbMes=12;
												}
												else
													$CmbMes=$CmbMes-1;
											}
											if($FilaFlujos[tipo_inventario]=='1'||$FilaFlujos[tipo_inventario]=='4')
												$TipoMovimiento=3;
											else
												$TipoMovimiento=2;		
											$Signo=$FilaFlujos["signo"];
											$ConsultaEnabal="select cobre,plata,oro";
											$ConsultaEnabal.=" from scop_datos_enabal where ano='".$Ano."' and mes='".$CmbMes."' and origen='".$FilaFlujos[tipo_flujo]."' and cod_flujo='".$FilaFlujos["flujo"]."' and tipo_mov='".$TipoMovimiento."'";		
											$RespEnabal=mysql_query($ConsultaEnabal);
											while($FilaEnabal=mysql_fetch_array($RespEnabal))
											{
												if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
												{
													if($FilaFlujos[acuerdo_cu]==$CmbAcuerdo)
													{
														if($Signo=='1')
															$ValorCobre2=$ValorCobre2+$FilaEnabal[cobre];
														else
															$ValorCobre2=$ValorCobre2-$FilaEnabal[cobre];
													}												
													else
														$ValorCobre2=$ValorCobre2+0;	
													if($FilaFlujos[acuerdo_ag]==$CmbAcuerdo)
													{
														if($Signo=='1')
															$ValorPLata2=$ValorPLata2+$FilaEnabal[plata];
														else
															$ValorPLata2=$ValorPLata2-$FilaEnabal[plata];
													}
													else
														$ValorPLata2=$ValorPLata2+0;		
													if($FilaFlujos[acuerdo_au]==$CmbAcuerdo)
													{
														if($Signo=='1')
															$ValorOro2=$ValorOro2+$FilaEnabal[oro];
														else
															$ValorOro2=$ValorOro2-$FilaEnabal[oro];
													}
													else
														$ValorOro2=$ValorOro2+0;												
												}
												if($CmbAcuerdo=='P'||$CmbAcuerdo=='T')
												{
													if($Signo=='1')
													{
														$ValorCobre2=$ValorCobre2+$FilaEnabal[cobre];
														$ValorPLata2=$ValorPLata2+$FilaEnabal[plata];
														$ValorOro2=$ValorOro2+$FilaEnabal[oro];
													}
													else
													{
														$ValorCobre2=$ValorCobre2-$FilaEnabal[cobre];
														$ValorPLata2=$ValorPLata2-$FilaEnabal[plata];
														$ValorOro2=$ValorOro2-$FilaEnabal[oro];
													}
												}
											}
										}												
									}
									$ValorCobreOZ=Convertir($ValorCobre2,'Cobre');
									$ValorPlataOZ=Convertir($ValorPLata2,'PLata');
									$ValorOroOZ=Convertir($ValorOro2,'Oro');	
									$arreglo=array();
									$Datos = explode("~",$TipoEst);
									$x=0;
									foreach($Datos as $clave => $Codigo)
									{
										$arreglo[$x][0]=$Codigo;
										$x=$x+1; 
									}	
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorCobre2,3,',','.')."</td>";				
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioCu' value=".number_format($ValorCobreOZ,3,',','.')."></td>";				
										}
										if('Ag'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorPLata2,3,',','.')."</td>";		
												echo "<td align='right'>".number_format($ValorPlataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAg' value=".number_format($ValorPlataOZ,3,',','.')."></td>";	
										}
										if('Au'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorOro2,3,',','.')."</td>";				
												echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAu' value=".number_format($ValorOroOZ,3,',','.')."></td>";	
										}
									}
								echo "</tr>";		
						}
					}	
					?>
		    </table>
	 </td>
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
	if ($Mensaje)
		echo "alert('".$Mensaje."');";
	if ($Mensaje1)
		echo "alert('".$Mensaje1."');";
	if ($MensajeFlujo)
		echo "alert('".$MensajeFlujo."');";	
	if ($MensajeEli)
		echo "alert('".$MensajeEli."');";				
	echo "</script>";
?>
<?
function DatosEnabalFlujos($AnoFlujo,$MesFlujo,$Contrato,$TipoFlujo,$CodFlujo,$ArrFinos,$i)
{
	$Consulta="select * from scop_contratos_flujos where cod_contrato='".$Contrato."' and  tipo_inventario='".$i."' and flujo='".$CodFlujo."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[tipo_inventario]=='1')
		{
			if($MesFlujo==1)
			{
				$AnoFlujo=$AnoFlujo-1;
				$MesFlujo=12;
			}
			else
				$MesFlujo=$MesFlujo-1;
		}
		if($Fila[tipo_inventario]=='1'||$Fila[tipo_inventario]=='4')
			$TipoMovimiento=3;
		else
			$TipoMovimiento=2;		
		$Flujo= $Fila["flujo"];
		$Consulta="select cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."'";		
		$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysql_query($Consulta);
		while($FilaValor=mysql_fetch_array($RespValor))
		{
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			if($Fila["signo"]==1)
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]+$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]+$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]+$Au;
			}
			else
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]-$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]-$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]-$Au;
			}
		}			
	}	
}
function Convertir($Valor,$Dato)
{
	switch($Dato)
	{
		case "Cobre"://DE KG A lb
				$ValorSalida=$Valor*2.2;
		break;
		case "PLata"://de grs a OZ
		case "Oro"://de grs a OZ
				$ValorSalida=$Valor*0.032150746568628;
		break;
	}
	return($ValorSalida);
}
?>