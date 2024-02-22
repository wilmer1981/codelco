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

if(!isset($Ano))
	$Ano=date('Y');
if(!isset($Mes))	
	$Mes=date('m');
?>
<html>
<head>
<title>Imputaci�n CC</title>
<script language="javascript" src="../scop_web/funciones/scop_funciones.js"></script>
<script language="javascript">

var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action="scop_proceso_cobertura_imputacion_cc.php?&Buscar=S";
			f.submit();
		break;
		case "PM":
			URL="scop_proceso_cobertura_precios.php?Opc=NP";
			opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=900,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='scop_mantenedor_contratos_proceso01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;
		case "I"://IMPRIMIR
			window.print();
		break;	
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=33";
		break;
	}	
}
function Recarga(TipoEst)
{
	var f=document.FrmPrincipal;
	f.action="scop_proceso_cobertura_imputacion_cc.php?";
	f.submit();
}
function Excel(Opc,TipoEst)
{
	var f=document.FrmPrincipal;
	URL='scop_proceso_cobertura_imputacion_cc_excel.php?&Ano='+f.Ano.value+'&Mes='+f.Mes.value;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
}
function AbrirCerrarCandado(Opc,Datos,TipoEst)
{
	var f=document.FrmPrincipal;
	if(Opc=='AC')//CERRAR CANDADO
		Mensaje='�Esta Seguro de Abrir Candado?';	
	mensaje=confirm(Mensaje);
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_imputacion_cc01.php?Opcion="+Opc+"&Valores="+Datos+'&TipoEst='+TipoEst;
		f.submit();
	}
}
function GrabaImputacion(Opc,Datos)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Realmente Desea Grabar lo Imputado?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_imputacion_cc01.php?Opcion="+Opc+"&Valores="+Datos;
		f.submit();
	}
}
function ImputacionValores(Opc,Datos,CoPlOr)
{
	var f=document.FrmPrincipal;
	var Datos2='';
	Datos2=Datos.split("~")
	URL = "scop_proceso_cobertura_imputacion_valores.php?Opcion="+Opc+"&Ano="+Datos2[0]+"&Mes="+Datos2[1]+"&CoPlOr="+CoPlOr;
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=900,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function Detalle(Datos)
{
	var f=document.FrmPrincipal;
	var Datos2='';
	Datos2=Datos.split("~")
	URL = "scop_proceso_cobertura_imputacion_cc_detalle.php?Ano="+Datos2[0]+"&Mes="+Datos2[1];
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1200,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
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
		}
	}
</script>	
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'imputacion_cc.png')
 ?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
    <td width="920" height="15"background="../scop_web/archivos/images/interior/form_arriba.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="15" background="../scop_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
        <td align="right" class='formulario2' colspan="3">
		<a href="JavaScript:Proceso('C')"><img src="archivos/buscar.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		<!--<a href="JavaScript:Proceso('PM')"><img src="archivos/precios.png"  border="0"  alt="Nuevo" align="absmiddle" /></a> -->
		<a href="JavaScript:Excel('EX','<? echo $TipoEst;?>')"><img src="archivos/excel.png"   alt="Excel"  border="0" align="absmiddle" /></a> 
		<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/salir.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
      </tr>
      <tr>
        <td width="19%" height="17" class='formulario2'>A&ntilde;o</td>
        <td colspan="3" class="formulario2" ><select name="Ano" id="Ano">
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
        </tr>
      <tr>
        <td width="19%" height="17" class='formulario2'>Mes<span class="formulariosimple"></span></td>
        <td width="20%" class="formulario2" >
		<select name="Mes" id="Mes" >
          <option value="T" selected="selected" >Todos</option>
          <?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=".$i.">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=".$i.">".$Meses[$i-1]."</option>\n";
				}
				?>
        </select></td>
        <td class="formulario2">&nbsp;</td>
        <td class="formulario2">&nbsp;</td>
      </tr>
    </table></td>
    <td width="15" background="../scop_web/archivos/images/interior/form_der.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
    <td height="15" background="../scop_web/archivos/images/interior/form_abajo.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
  </tr>
</table>
<br>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
    <td width="920" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
    <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
  </tr>
  <tr>
    <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td align="center"><table width="930" border="1" cellpadding="4" cellspacing="0" >
		<?
		 if($Buscar=='S')
		 {
		 ?>
      <tr align="center" class="TituloTablaVerde">
        <td width="7%" rowspan="2">A&ntilde;o/Mes</td>
        <td colspan="3">Resultado</td>
		<td width="14%" rowspan="2">Proceso</td>
        <td width="6%" rowspan="2">Estado</td>
      </tr>
      <tr align="center" class='TituloTablaVerde' >
			<td width="10%"><? echo "Cobre [USD]";?></td>
			<td width="12%"><? echo "PLata [USD]";?></td>
			<td width="11%"><? echo "Oro [USD]";?></td>
		  </tr>
			  <?			  
			   $ArrInventario=array();$ArrCarry=array();$ArrPrecios=array();$ArrPrecios2=array();
			   for($i=1;$i<=3;$i++)
			   {
					$ArrInventario[$i][Cu]='';$ArrInventario[$i][Au]='';$ArrInventario[$i][Ag]='';
					$ArrCarry[$i][Cu]='';$ArrCarry[$i][Au]='';$ArrCarry[$i][Ag]='';
					$ArrPrecios[$i][Cu]='';$ArrPrecios[$i][Au]='';$ArrPrecios[$i][Ag]='';
					$ArrPrecios2[$i][Cu]='';$ArrPrecios2[$i][Au]='';$ArrPrecios2[$i][Ag]='';
			   }						   					 
				echo "<tr>";
				$Consulta="select t1.acuerdo_contractual,t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.estado,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t3.vigente='1'";				
				if($Mes!='T')
					$Consulta.=" and t1.mes='".$Mes."'";	
				$Consulta.="  and t1.estado in ('5','6') group by corr,parcializacion order by corr,ano,mes";
				$Resp = mysql_query($Consulta);$ED=0;
				while($Fila=mysql_fetch_assoc($Resp))
				{	
					$Correlativo=$Fila["corr"];
					$Parcializacion=$Fila[parcializacion];
					if($Fila["estado"]=='5')
						$Clase="class='BordeFecha'";
					else	
						$Clase="bgcolor='#FFFFFF'";
					$ConsultaRows="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$ConsultaRows.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.corr='".$Correlativo."' and t1.parcializacion='".$Parcializacion."' and t1.ano='".$Ano."' and t3.vigente='1'";				
					$ConsultaRows.="  and t1.estado in ('5','6') group by corr,parcializacion";	
					$RespRows = mysql_query($ConsultaRows);$Rowspan=0;
					while($FilaRows=mysql_fetch_assoc($RespRows))
					{
						$Rowspan=$Rowspan+1;
						$Abrircandado=$Abrircandado.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";
						$Imputar2=$Imputar2.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";
					}
					$Consulta2="select t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.estado,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$Consulta2.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t3.vigente='1'";				
					if($Mes!='T')
						$Consulta2.=" and t1.mes='".$Mes."'";	
					$Consulta2.="  and t1.estado in ('5','6') group by ano,mes";	
					$Resp2 = mysql_query($Consulta2);$ED=0;
					while($Fila2=mysql_fetch_assoc($Resp2))
					{
							$Ano2=$Fila2["ano"];$Mes2=$Fila2["mes"];
					}
					
					ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Fila[parcializacion],$CmbAcuerdo,$TipoEst,&$ArrInventario);
					ValoresCarryCost($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
					ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
					ValorPreciosOperacionesAcuerdo($Fila["corr"],$Fila[parcializacion],$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
		
							reset($ArrPrecios);	reset($ArrInventario);reset($ArrCarry);	reset($ArrPrecios2);
							if($ArrPrecios[1][Cu]!='0')
							{
								$ImputarCu=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
								$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
								$ResultadoCu=($ArrInventario[1][Cu]*($ResultadoPrecioCVCobre)/100)+$CarryCostTotalCu;
								$SumaCu=$SumaCu+$ResultadoCu;
							}	
							else
								$SumaCu=0;
							if($ArrPrecios[2][Ag]!='0')
							{
								$ImputarAg=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
								$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
								$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
								$SumaAg=$SumaAg+$ResultadoAg;
							}	
							else
								$SumaAg=0;
							if($ArrPrecios[3][Au]!='0')
							{
								$ImputarAu=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
								$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];					
								$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
								$SumaAu=$SumaAu+$ResultadoAu;
							}
							else
								$SumaAu=0;
							
					$NumParcial++;	
					$Corr=$Fila["corr"];$Ano=$Fila["ano"];$Mes=$Fila["mes"];$Parc=$Fila[parcializacion];$Estado=$Fila["estado"];
					$Detalle=$Fila["ano"]."~".$Mes=$Fila["mes"];
				}
				if($Abrircandado!='')
					$Abrircandado=substr($Abrircandado,0,strlen($Abrircandado)-2);
				if($Imputar2!='')
					$Imputar2=substr($Imputar2,0,strlen($Imputar2)-2);
				
				$Consulta1="select distinct t1.corr,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta1.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where ano='".$Ano."' and mes='".$Mes."' and t3.vigente='1'";				
				$Resp1 = mysql_query($Consulta1);$Contratos='';
				while($Fila1=mysql_fetch_assoc($Resp1))
					$Contratos=$Contratos.$Fila1[cod_contratos]."~";
					
				if($Contratos!='')
					$Contratos=substr($Contratos,0,strlen($Contratos)-1);	
				echo "<input type='hidden' name='Contratos' value=".$Contratos.">";
				
				?><td rowspan=".$Rowspan." <? echo $Clase;?>><? echo "<a href=JavaScript:Detalle('".$Detalle."') class='LinksinLinea'>".$Ano2."/".substr($Meses[$Mes2-1],0,3)."</a>";?></td><?
				$Imputar=$Imputar.$Ano."~".$Mes."//";
				if($Imputar!='')
					$Imputar=substr($Imputar,0,strlen($Imputar)-2);
				if($SumaCu!=0)
				{
					?><td align='right' <? echo $Clase;?>><? echo number_format($SumaCu,0,',','.');	
				}
				else
				{
					?><td align='center' <? echo $Clase;?>>- - -<?	
				}
				if($Estado=='5')
				{	
					if($SumaCu!=0)
					{
						$ConsultaEstImpu="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and cod_ley='1' and estado='6'";	
						$RespEstImpu = mysql_query($ConsultaEstImpu);
						if(!$FilaEstImpu=mysql_fetch_assoc($RespEstImpu))											
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarCu."','1')><img src='archivos/ico_depo.gif' width='25' height='21'  border='0'  alt='Ingresar Imputaci�n' align='absmiddle'></a></td>";
						else
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarCu."','1')><img src='archivos/acepta.png'  border='0'  alt='Imputacion Realizada, �Desea Modificar?' align='absmiddle'></a></td>";
					}
				}
				if($SumaAg!=0)
				{
					?><td align='right' <? echo $Clase;?>><? echo number_format($SumaAg,0,',','.');	
				}
				else
				{
					?><td align='center' <? echo $Clase;?>>- - -<?	
				}
				if($Estado=='5')
				{	
					if($SumaAg!=0)
					{
						$ConsultaEstImpu="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and cod_ley='2' and estado='6'";	
						$RespEstImpu = mysql_query($ConsultaEstImpu);
						if(!$FilaEstImpu=mysql_fetch_assoc($RespEstImpu))											
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarAg."','2')><img src='archivos/ico_depo.gif' width='25' height='21'  border='0'  alt='Ingresar Imputaci�n' align='absmiddle'></a></td>";
						else
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarAg."','2')><img src='archivos/acepta.png'  border='0'  alt='Imputacion Realizada, �Desea Modificar?' align='absmiddle'></a></td>";
					}
				}
				if($SumaAu!=0)
				{
					?><td align='right' <? echo $Clase;?>><? echo number_format($SumaAu,0,',','.');	
				}
				else
				{
					?><td width="40%" align='center' <? echo $Clase;?>>- - -<?	
				}
				if($Estado=='5')
				{	
					if($SumaAu!=0)
					{
						$ConsultaEstImpu="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and cod_ley='3' and estado='6'";	
						$RespEstImpu = mysql_query($ConsultaEstImpu);
						if(!$FilaEstImpu=mysql_fetch_assoc($RespEstImpu))											
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarAu."','3')><img src='archivos/ico_depo.gif' width='25' height='21'  border='0'  alt='Ingresar Imputaci�n' align='absmiddle'></a></td>";
						else
							echo "<a href=Javascript:ImputacionValores('N','".$ImputarAu."','3')><img src='archivos/acepta.png' border='0'  alt='Imputacion Realizada, �Desea Modificar?' align='absmiddle'></a></td>";
					}
				}
				//SABER QUE ESTADO TIENE EL CARRY COST SI ES CANDADO O GUARDAR NUEVO CARRY
				$ConsultaCarry="select distinct t1.estado,t2.cod_subclase,t2.nombre_subclase as nom_cobertura,t1.tipo_cobertura,t1.parcializacion from scop_carry_cost t1 ";
				$ConsultaCarry.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33005' and t1.tipo_cobertura=t2.cod_subclase";
				$ConsultaCarry.=" inner join scop_carry_cost_proceso t3 on t1.corr=t3.corr";
				$ConsultaCarry.=" where t1.corr='".$Corr."' and  t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.estado in ('5','6') ";
				$RespCarry=mysql_query($ConsultaCarry);
				if ($FilaCarry=mysql_fetch_array($RespCarry))
				{
					echo "<input type='hidden' name='CmbTipoCobertura' value='".$FilaCarry[tipo_cobertura]."'>";						
					if($FilaCarry[parcializacion]==1)
					{
						if($FilaCarry["estado"]=='3')
						{
							//CANDADO ABIERTO ESTE ES EL ESTADO N� 3
							$ValorAnoMesPar=ValorEstados($Corr,$Parc,$Ano,$Mes,$TipoEst);	
							if($ValorAnoMesPar!='')// MUESTRA CUANDO EL ESTADO ES 3 Y VALOR PARA EL MES ES DISTINTO A CERO
							{
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'>Sin Acci�n</td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/opc3.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'><img src='archivos/vco.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'></td>";
							}
							else//SI EL VALOR PRECIO METAL NO TIENE VALOR PARA EL MES CONSULTADO, NO MUESTRA NADA.
							{
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'>Sin Acci�n</td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/opc3.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'><img src='archivos/vco.png'  border='0'  alt='Ingreso Precios de Metales por O.C' align='absmiddle'></td>";
							}
						}
						if($FilaCarry["estado"]=='4')
						{
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'>Sin Acci�n</td>";
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/opc3.png'  border='0'  alt='Ingreso de Precios por O.C y Envio VCO Validaci�n Resultados' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Ingreso de Precios por O.C y Envio VCO Validaci�n Resultados' align='absmiddle'><img src='archivos/vco.png'  border='0'  alt='Ingreso de Precios por O.C y Envio VCO Validaci�n Resultados' align='absmiddle'></td>";
						}
						if($FilaCarry["estado"]=='5')
						{
							$ConsultaEstImpu="select * from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' and estado='6'";	
							$RespEstImpu = mysql_query($ConsultaEstImpu);
							if($FilaEstImpu=mysql_fetch_assoc($RespEstImpu))
								$Existe='S';
							else
								$Existe='N';	
							if($Existe=='S')
								echo "<td align='center' bgcolor='#FFFFFF'><a href=Javascript:GrabaImputacion('GIPV','".$Imputar2."')><img src='archivos/grabar.png'  border='0'  alt='Grabar Imputaciones' align='absmiddle'></a></td>";
							else
								echo "<td align='center' bgcolor='#FFFFFF'>Sin Valores Imputados</td>";
							echo "<td align='center' bgcolor='#FFFFFF'><img src='archivos/vco2.png'  border='0'  alt='Cierre de Proceso Cobertura' align='absmiddle'></td>";
						}
						if($FilaCarry["estado"]=='6')
						{
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><a href=JavaScript:AbrirCerrarCandado('AC','".$Abrircandado."')><img src='archivos/candado_cerrado.gif'  border='0'  alt='Proceso Imputaci�n Cerrado' align='absmiddle'></a></td>";
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/btn_pagar.png'  border='0'  alt='Cierre Cobertura de Precios y Resultados Cobertura Imputaci�n a Centros de Cotos' align='absmiddle'></td>";
						}
					}
				}	
				echo "</tr>";
		}	
		?>
    </table></td>
    </td>
    <td width="10" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15"><img src="../scop_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1"background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15"><img src="../scop_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
<?
CierreEncabezado()
?></body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }
	if($Envio=='S')
   {
?>
	<script language="javascript">
	alert("Proceso validado y Envio Satisfactorio")
	</script>
<? }
	if($Envio=='N')
   {
?>
	<script language="javascript">
	alert("Proceso validado, no hay Correos para este Proceso")
	</script>
<? }

function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp = mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		if($Fila["estado"]=='5')
			$Clase="class='BordeFecha'";
		else	
			$Clase="bgcolor='#FFFFFF'";
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1'";
		$Resp = mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_ley"]==1)
				$ValorCobre=$Fila["valor"];
			if($Fila["cod_ley"]==2)
				$ValorPLata=$Fila["valor"];
			if($Fila["cod_ley"]==3)
				$ValorOro=$Fila["valor"];
		}
	}
	$ArrInventario[1][Cu]=$ValorCobre;
	$ArrInventario[2][Ag]=$ValorPLata;
	$ArrInventario[3][Au]=$ValorOro;
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
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
				$ValorCobre=$FilaPro["valor"];
			if($FilaPro["cod_ley"]==2)
				$ValorPLata=$FilaPro["valor"];
			if($FilaPro["cod_ley"]==3)
				$ValorOro=$FilaPro["valor"];
		}
	}
	$ArrCarry[1][Cu]=$ValorCobre;
	$ArrCarry[2][Ag]=$ValorPLata;
	$ArrCarry[3][Au]=$ValorOro;
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Corr=$Fila["corr"];
		if($Fila[acuerdo_contractual]=='P')
		{
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
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
				//echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
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
			if($Fila[tipo_cobertura]==1)//CAMBIO QP
			{
				$Consulta="select t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_cu='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadCu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
				$ValorCobre=$CantidadCu;
				
				$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_ag='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadAg=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAg=$CantidadAg+$Fila[acuerdo_ag];
				$ValorPLata=$CantidadAg;
				
				$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_au='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadAu=0;
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
				$Resp=mysql_query($Consulta);
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
	$Resp=mysql_query($Consulta);
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
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorCobre=$Fila["valor"];
				else
					$ValorCobre=0;
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAg."' and cod_ley='2'";
				//echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorPLata=$Fila["valor"];
				else
					$ValorPLata=0;	
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAu."' and cod_ley='3'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorOro=$Fila["valor"];
				else
					$ValorOro=0;	

			$ArrPrecios[1][Cu]=$ValorCobre;
			$ArrPrecios[2][Ag]=$ValorPLata;
			$ArrPrecios[3][Au]=$ValorOro;
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$ArrPrecios[1][Cu]=$Fila[precio_fijo_cu];
				$ArrPrecios[2][Ag]=$Fila[precio_fijo_ag];
				$ArrPrecios[3][Au]=$Fila[precio_fijo_au];
			}
		}
	}	
}
function ValorEstados($Corr,$Parci,$Ano,$Mes,$TipoEst)
{
	$Consulta="select ano,mes,acuerdo_contractual_qp from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{	
			$Acuerdo_contractual_qp=$Fila[acuerdo_contractual_qp];	
			$MesDeEntregaValor=$Mes+$Acuerdo_contractual_qp;
			$Consulta="select * from scop_precios_metales where ano='".$Fila["ano"]."' and mes='".$MesDeEntregaValor."'";
			//echo $Consulta."<br>";
			$Resp=mysql_query($Consulta);$Existe='';
			if($Fila=mysql_fetch_array($Resp))
					$Existe=1;
	}
	return($Existe);
}
?>
