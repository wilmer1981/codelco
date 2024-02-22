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
?>
<html>
<head>
<title>Proceso Carry Cost</title>
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
				else
				{
					f.action="scop_proceso_cobertura_carry_cost.php?&Buscar=S&TipoEst="+Valores2;
					f.submit();
				}
			}
		break;
		case "N"://NUEVOS PRECIOS
			URL="scop_proceso_cobertura_carry_cost_proceso.php?Opc="+Opc;
			opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=950,height=400,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			//popup.moveTo((screen.width - 1024)/2,0);
		break;
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "R":
			f.action = "scop_proceso_cobertura_carry_cost.php";
			f.submit();
		break;	
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=33";
		break;
	}	
}
function Excel(Opc,TipoEst)
{
	var f=document.FrmPrincipal;
	URL='scop_proceso_cobertura_carry_cost_excel.php?&Ano='+f.Ano.value+'&CmbAcuerdo='+f.CmbAcuerdo.value+'&TipoEst='+TipoEst;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
}
function ModificarCarryCost(Datos,TipoEst)
{
	var f=document.FrmPrincipal;
	URL="scop_proceso_cobertura_carry_cost_precio.php?Valores="+Datos+"&TipoEst="+TipoEst;
	opciones='left=50,top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=200,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function AbrirCandado(Opcion,Datos,TipoEst)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Esta Seguro de Abrir Carry Cost?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion="+Opcion+"&Valores="+Datos+"&TipoEst="+TipoEst;
		f.submit();
	}
}
function ProcesoGrabarCarry(Datos,Codigo,TipoEst)
{
	var f=document.FrmPrincipal;
	var MDatos='';
	var MCodigo='';
	var MCajas='';
	var Valores='';var Valores2='';
	var Valor='';
	var i=0;var j=0;var k=0;		
	MDatos=TipoEst.split("~");
	for(i=0;i<=MDatos.length;i++)//SEPARO SI ES CU, AG AU
	{		
		if(MDatos[i]=='Cu')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Cu_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para Cobre");				
					return;
				}
				else	
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=String(Valores+Valor+"//");
			}	
		}
		if(MDatos[i]=='Ag')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Ag_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para PLata");				
					return;
				}
				else
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=Valores+Valor+"//";
			}
		}	
		if(MDatos[i]=='Au')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Au_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para Oro");				
					return;
				}
				else
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=Valores+Valor+"//";
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	Valores2=Valores2+Valores+"//";
	Valores2=Valores2.substr(0,Valores2.length-2);
	if(f.CmbTipoCobertura.value=='-1')
	{
		alert("Debe Seleccionar Tipo Cobertura");
		f.CmbTipoCobertura.focus();
		return;
	}
	if(f.CmbTipoCobertura.value=='1')
	{
		if(f.CmbAcuerdoCarry.value=='N')
		{
			alert("Debe Seleccionar Acuerdo Carry");
			f.CmbAcuerdoCarry.focus();
			return;
		}
	}
	if(f.CmbTipoCobertura.value=='2')
	{		
		if(f.ValorPrecioFijo.value=='')
		{
			alert("Debe Ingresar Numero Fijo");
			f.CmbAcuerdoCarry.focus();
			return;
		}
	}
	mensaje=confirm("�Esta Seguro de Grabar el Carry Cost?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion=GC&DatosPrincipal="+Datos+"&Codigo="+Codigo+"&TipoEst="+TipoEst+"&Valores2="+Valores2;
		f.submit();
	}
}
function ProcesoGrabarCarry2(Datos,Codigo,TipoEst)
{
	var f=document.FrmPrincipal;
	var MDatos='';
	var MCodigo='';
	var MCajas='';
	var Valores='';var Valores2='';
	var Valor='';
	var i=0;var j=0;var k=0;
	
	MDatos=TipoEst.split("~");
	for(i=0;i<=MDatos.length;i++)//SEPARO SI ES CU, AG AU
	{		
		if(MDatos[i]=='Cu')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Cu_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para Cobre");				
					return;
				}
				else	
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=String(Valores+Valor+"//");
			}	
		}
		if(MDatos[i]=='Ag')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Ag_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para PLata");				
					return;
				}
				else
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=Valores+Valor+"//";
			}
		}	
		if(MDatos[i]=='Au')
		{
			MCodigo=Codigo.split("//");
			for(j=0;j<MCodigo.length;j++)//SEPARO LAS PARCIALIZACIONES
			{	
				MCajas="Au_"+MCodigo[j];
				if(eval("f."+MCajas+".value")=='')
				{
					alert("Debe Ingresar Valor Para Oro");				
					return;
				}
				else
					Valor=MDatos[i]+"_"+MCodigo[j]+"_"+eval("f."+MCajas+".value");
				Valores=Valores+Valor+"//";
			}
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	Valores2=Valores2+Valores+"//";
	Valores2=Valores2.substr(0,Valores2.length-2);
	mensaje=confirm("�Esta Seguro de Grabar el Carry Cost?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion=GC&DatosPrincipal="+Datos+"&Codigo="+Codigo+"&TipoEst="+TipoEst+"&Valores2="+Valores2;
		f.submit();
	}
}
function Parcializar(Datos,Opc,TipoEst,Acu,CPO)
{
	var f=document.FrmPrincipal;
	URL = "scop_proceso_cobertura_carry_cost_desglozar_inv.php?Buscar=S&Opc="+Opc+"&Datos="+Datos+"&TipoEst="+TipoEst+"&Acu="+Acu+"&CPO="+CPO;
	opciones='left=50,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1000,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function Recarga(Datos)
{
	var f=document.FrmPrincipal;
	f.action = "scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst="+Datos;
	f.submit();
}
function ValidaPM(Datos,NomTxtCCost,TipoEst)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Esta Seguro de Validar, Para Imputar Valores?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion=VPM&Valores="+Datos+"&CorrParci="+NomTxtCCost+"&TipoEst="+TipoEst;
		f.submit();
	}
}
function DesValidaPM(Datos,NomTxtCCost,TipoEst)
{
	var f=document.FrmPrincipal;
	mensaje=confirm("�Esta Seguro de desactivar Validaci�n?");
	if(mensaje==true)
	{
		f.action = "scop_proceso_cobertura_carry_cost01.php?Opcion=DVPM&Valores="+Datos+"&CorrParci="+NomTxtCCost+"&TipoEst="+TipoEst;
		f.submit();
	}
}
function ResumenContratos(Datos,TipoEst)
{
	var popup=0;
	var f= document.FrmPopupProceso;
	var Dato=Datos.split('~');
	URL="scop_proceso_cobertura_carry_cost_resumen.php?Ano="+Dato[0]+"&CmbMes="+Dato[1]+"&CmbAcuerdo="+Dato[2]+"&TipoEst="+TipoEst;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=1200,height=300,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
</script>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<body>
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'cobertura_carry_cost.png')
 ?>
   <table width="970" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
      <td width="1%" height="15"><img src="../scop_web/archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="98%" height="15"background="../scop_web/archivos/images/interior/form_arriba.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="1%" height="15"><img src="../scop_web/archivos/images/interior/esq2em.png" width="15" height="15" /></td>
      </tr>
    <tr>
      <td width="15" background="../scop_web/archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
				<td width="19%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	            <td align="right" class='formulario2' colspan="3">
				<a href="JavaScript:Proceso('C')"><img src="archivos/buscar.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
			    <a href="JavaScript:Proceso('N')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
				<a href="JavaScript:Excel('EX','<? echo $TipoEst;?>')"><img src="archivos/excel.png"   alt="Excel"  border="0" align="absmiddle" /></a>
				<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
				<a href="JavaScript:Proceso('S')"><img src="archivos/salir.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
		  </tr>
      <tr>
    	<td width="19%" height="17" class='formulario2'>A&ntilde;o Desde </td>
    	<td colspan="3" class="formulario2" >
		<select name="Ano" id="Ano">
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
    	<td width="19%" height="17" class='formulario2'>Acuerdo <span class="formulariosimple"> Contractual</span></td>
    	<td class="formulario2" >
		 <select name="CmbAcuerdo" id="CmbAcuerdo">
		   <option value="S" class="NoSelec">Seleccionar</option>
		   <?
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
       </select>	   			    
	   </td>
	    	<td class="formulario2">Tipo</td>		
	    	<td class="formulario2">		
			<?
				$arreglo=array();
				$Datos = explode("~",$TipoEst);
				$x=0;
				foreach($Datos as $clave => $Codigo)
				{
					$arreglo[$x][0]=$Codigo;
					$x=$x+1; 
				}	
				echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Cu'";
				for($i=0;$i<=$x;$i++)
				{
					echo $arreglo[$i][0];
					if('Cu'==$arreglo[$i][0])
						echo " checked ";	
				}
				echo ">Acuerdo Cu&nbsp;&nbsp;";
				echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Ag'";
				for($i=0;$i<=$x;$i++)
				{
					echo $arreglo[$i][0];
					if('Ag'==$arreglo[$i][0])
						echo " checked ";	
				}
				echo ">Acuerdo Ag&nbsp;&nbsp;";
				echo "<input type='checkbox' class='SinBorde' name='Acuerdo' value='Au'";
				for($i=0;$i<=$x;$i++)
				{
					echo $arreglo[$i][0];
					if('Au'==$arreglo[$i][0])
						echo " checked ";	
				}
				echo ">Acuerdo Au&nbsp;&nbsp;";
			?>		
		</td>
		 </tr>
	   </table>   
	</td>
      <td width="15" align="center" background="../scop_web/archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="../scop_web/archivos/images/interior/form_abajo.png"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="../scop_web/archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
  <br>	
<table width="970" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="930" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
    <tr>
       <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td align="center">
	   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
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
				{
					$Cu=1;$Colspan=1;	
				}
				if('Ag'==$arreglo[$i][0])
				{
					$Ag=2;$Colspan=$Colspan+1;	
				}
				if('Au'==$arreglo[$i][0])
				{
					$Au=3;$Colspan=$Colspan+1;	
				}
			}
			
		 if($Buscar=='S')
		 {
		 ?>
         <tr align="center" class="TituloTablaVerde">
           <td width="6%" rowspan="2">A&ntilde;o/Mes</td>
           <td width="10%" colspan="<? echo $Colspan;?>">Inventario</td>
           <td width="10%" colspan="<? echo $Colspan;?>">Carry Cost </td>
           <td width="10%" colspan="<? echo $Colspan;?>">Precio Compra </td>
           <td width="10%" colspan="<? echo $Colspan;?>">Precio Venta </td>
           <td width="10%" colspan="<? echo $Colspan;?>">Carry Cost </td>
           <td width="11%" colspan="<? echo $Colspan;?>">Resultado</td>
           <td width="11%" rowspan="2">Tipo Cobert.</td>
           <td rowspan="2" colspan="2">Grabar<br>
            Carry Costs</td>
           <td width="8%" rowspan="2" >Proceso Validar</td>
           <td width="4%" rowspan="2">Est.</td>
         </tr>
         <tr align="center" class='TituloTablaVerde' >
           <? 
				for($i=0;$i<=5;$i++)
				{
					if($i==0)
					{
						$Cobre="[LB]";$Plata="[OZ]";$Oro="[OZ]";
					}
					if($i==1)
					{
						$Cobre="[cUSD/lb]";$Plata="[USD/oz]";$Oro="[USD/oz]";
					}
					if($i==4)
					{
						$Cobre="[USD]";$Plata="[USD]";$Oro="[USD]";
					}
					if($i==3||$i==2)
					{
						$Cobre="[cUSD/lb]";$Plata="[USD/OZ]";$Oro="[USD/OZ]";
					}
					if($i==0||$i==1||$i==4||$i==5)
					{
						if($Cu==1)
							 echo "<td>Cobre ".$Cobre."</td>";
						if($Ag==2)
							 echo "<td>PLata ".$Plata."</td>";
						if($Au==3)
							 echo "<td>Oro ".$Oro."</td>";
					}
					if($i==2||$i==3)
					{
						if($Cu==1)
							 echo "<td>Cobre ".$Cobre."</td>";
						if($Ag==2)
							 echo "<td>PLata ".$Plata."</td>";
						if($Au==3)
							 echo "<td>Oro ".$Oro."</td>";
					}
				}
				?>
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
						$Datos1=$Datos1."'1',";
					if('Ag'==$arreglo[$i][0])
						$Datos1=$Datos1."'2',";
					if('Au'==$arreglo[$i][0])
						$Datos1=$Datos1."'3',";
				}
				if($Datos1!='')
					$Datos1=substr($Datos1,0,strlen($Datos1)-1);
				$In="(".$Datos1.")";
				$Consulta="select t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.acuerdo_contractual,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
				$Consulta.=" where ano='".$Ano."' and acuerdo_contractual='".$CmbAcuerdo."' and t3.vigente='1' group by corr,parcializacion order by corr,ano,mes";				
				$Resp = mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{		
					$Correlativo=$Fila["corr"];
					$Parcializacion=$Fila[parcializacion];
					$ConsultaRows="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$ConsultaRows.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
					$ConsultaRows.=" where t1.ano='".$Ano."' and t1.acuerdo_contractual='".$CmbAcuerdo."' and t1.corr='".$Fila["corr"]."' and t3.vigente='1' group by corr,parcializacion";				
					$RespRows = mysql_query($ConsultaRows);$Rowspan=0;$NomTxtCCost='';$Abrircandado='';$Guardar='';$Guardar2='';
					while($FilaRows=mysql_fetch_array($RespRows))
					{
						$TipoCobertura=$FilaRows[tipo_cobertura];
						$Rowspan=$Rowspan+1;
						$NomTxtCCost=$NomTxtCCost.$Fila["corr"]."_".$Rowspan."//";
						$Guardar=$Guardar.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."~".$FilaRows[tipo_cobertura]."//";
						$Guardar2=$Guardar2.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."~3//";
						$Abrircandado=$Abrircandado.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";					
					}
					$Rowspan=$Rowspan;
					if($NomTxtCCost!='')
						$NomTxtCCost=substr($NomTxtCCost,0,strlen($NomTxtCCost)-2);
					if($Abrircandado!='')
						$Abrircandado=substr($Abrircandado,0,strlen($Abrircandado)-2);
					if($Guardar!='')
						$Guardar=substr($Guardar,0,strlen($Guardar)-2);
						
					$Consulta1="select distinct t1.corr,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$Consulta1.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
					$Consulta1.=" where t1.corr='".$Fila["corr"]."' and t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."' and t1.parcializacion='".$Fila[parcializacion]."' and acuerdo_contractual='".$CmbAcuerdo."' and t3.vigente='1'";				
					//echo $Consulta1."<br>";
					$Resp1 = mysql_query($Consulta1);$Contratos='';
					while($Fila1=mysql_fetch_array($Resp1))
						$Contratos=$Contratos.$Fila1[cod_contratos]."~";
						
					if($Contratos!='')
						$Contratos=substr($Contratos,0,strlen($Contratos)-1);	
					echo "<input type='hidden' name='Contratos' value=".$Contratos.">";
					echo "<tr bgcolor='#FFFFFF'>";
					if($Parcializacion==1)						
					{
						$Datos=$Fila["ano"]."~".$Fila["mes"]."~".$Fila[acuerdo_contractual];
						echo "<td rowspan=".$Rowspan."><a href=JavaScript:ResumenContratos('".$Datos."','".$TipoEst."') class='LinkSinLinea'>".substr($Fila["ano"],2)."/".substr($Meses[$Fila["mes"]-1],0,3)."</a></td>";
						echo "<input type='hidden' name='Mes' value=".$Fila["mes"].">";
					}
					for($k=0;$k<=5;$k++)
					{
						if($k==0)
							ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Parcializacion,$CmbAcuerdo,$TipoEst,&$ArrInventario);
						if($k==1)
							ValoresCarryCost($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
						if($k==2)//compra
							ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
						if($k==3)//Venta
							ValorPreciosOperacionesAcuerdo($Fila["corr"],$Parcializacion,$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
						if($k==4)//Calculo de VALORES CARRY COST DE LA GRILLA
						{
							for($i=0;$i<=$x;$i++)
							{
								reset($ArrPrecios);reset($ArrInventario);reset($ArrCarry);								
								if('Cu'==$arreglo[$i][0])
								{
									if($ArrPrecios[1][Cu]!='0')
									{
										$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;							
										echo "<td align='right' $Clase>".number_format($CarryCostTotalCu,2,',','.')."</td>";
										$CarryCostTotalCu=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
								if('Ag'==$arreglo[$i][0])
								{
									if($ArrPrecios[2][Ag]!='0')
									{
										$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
										echo "<td align='right' $Clase>".number_format($CarryCostTotalAg,2,',','.')."</td>";
										$CarryCostTotalAg=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
								if('Au'==$arreglo[$i][0])
								{
									if($ArrPrecios[3][Au]!='0')
									{
										$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
										echo "<td align='right' $Clase>".number_format($CarryCostTotalAu,2,',','.')."</td>";
										$CarryCostTotalAu=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
							}						
						}	
						if($k==5)// CALCULO DE LOS VALORES DEL RESULTADO DE LA GRILLAA
						{	$Existe=0;
							for($i=0;$i<=$x;$i++)
							{
								reset($ArrPrecios);reset($ArrPrecios2);	reset($ArrInventario);reset($ArrCarry);	
								if('Cu'==$arreglo[$i][0])
								{
									if($ArrPrecios[1][Cu]!='0')
									{ 
										$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
										$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
										$ResultadoCu=($ArrInventario[1][Cu]*($ResultadoPrecioCVCobre)/100)+$CarryCostTotalCu;
										if($ResultadoCu!=0)
										{
											$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoCu,2,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";
								}
								if('Ag'==$arreglo[$i][0])
								{	
									if($ArrPrecios[2][Ag]!='0')
									{
										$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
										$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
										$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
										if($ResultadoAg!=0)
										{	$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoAg,0,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";
								}
								if('Au'==$arreglo[$i][0])
								{	
									if($ArrPrecios[3][Au]!='0')
									{
										$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
										$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];	
										$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
										if($ResultadoAu!=0)
										{	
											$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoAu,0,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";	
								}
							}																																					
						}	
					}
					//SABER QUE ESTADO TIENE EL CARRY COST SI ES CANDADO O GUARDAR NUEVO CARRY
					for($i=0;$i<=$x;$i++)
					{
						if('Cu'==$arreglo[$i][0])
							$Datos=1;
						if('Ag'==$arreglo[$i][0])
							$Datos=2;
						if('Au'==$arreglo[$i][0])
							$Datos=3;
					}					
					$ConsultaExValor="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_ley in $In and cod_tipo_titulo='1'";
					$RespExValor = mysql_query($ConsultaExValor);$DatosExValor='';
					while($FilaExValor=mysql_fetch_array($RespExValor))
					{
						if($FilaExValor["cod_ley"]==1)
							$DatosExValor=$DatosExValor."Cu~";
						if($FilaExValor["cod_ley"]==2)
							$DatosExValor=$DatosExValor."Ag~";
						if($FilaExValor["cod_ley"]==3)
							$DatosExValor=$DatosExValor."Au~";
					}
					$ConsultaCarry="select distinct t1.acuerdo_contractual,t1.corr,t1.precio_fijo_cu,t1.precio_fijo_ag,t1.precio_fijo_au,t1.estado,t2.cod_subclase,t2.nombre_subclase as nom_cobertura,t1.tipo_cobertura,t1.acuerdo_contractual_qp_cu,t1.acuerdo_contractual_qp_ag,t1.acuerdo_contractual_qp_au,t1.parcializacion from scop_carry_cost t1 ";
					$ConsultaCarry.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33005' and t1.tipo_cobertura=t2.cod_subclase";
					$ConsultaCarry.=" inner join scop_carry_cost_proceso t3 on t1.corr=t3.corr and  t1.parcializacion=t3.parcializacion and t3.cod_ley in $In and t3.cod_tipo_titulo='1'";
					$ConsultaCarry.=" where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
					//echo $ConsultaCarry."<br>";
					$RespCarry=mysql_query($ConsultaCarry);
					if($FilaCarry=mysql_fetch_array($RespCarry))
					{
						echo "<input type='hidden' name='CmbTipoCobertura' value='".$FilaCarry[tipo_cobertura]."'>";						
						if($FilaCarry[acuerdo_contractual]=='P'||$FilaCarry[acuerdo_contractual]!='P')
						{
							if($FilaCarry[tipo_cobertura]=='1')//para ver si es QP o Precio Fijo
							{
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{
									for($i=0;$i<=$x;$i++)
									{
										if($FilaQp[acuerdo_contractual_qp_cu]=='-1'||$FilaQp[acuerdo_contractual_qp_ag]=='-1'||$FilaQp[acuerdo_contractual_qp_au]=='-1')
											$Mes='M&nbsp;';
										else
											$Mes='M&nbsp;+';	
										if('Cu'==$arreglo[$i][0])
										{
											if($FilaQp[acuerdo_contractual_qp_cu]!='')
												$QP="Cu&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_cu]."&nbsp;,";						
										}
										if('Ag'==$arreglo[$i][0])
										{
											if($FilaQp[acuerdo_contractual_qp_ag]!='')
												$QP=$QP."Ag&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_ag]."&nbsp;,";
										}
										if('Au'==$arreglo[$i][0])
										{
											if($FilaQp[acuerdo_contractual_qp_au]!='')
												$QP=$QP."Au&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_au]."&nbsp;,";
										}
									}					
								}					
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."&nbsp;".$QP."</td>";
							}
							if($FilaCarry[tipo_cobertura]=='2')//Precio Fijo
							{
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
											$QP="Cu&nbsp;".number_format($FilaQp[precio_fijo_cu],3,',','.')."&nbsp;,";						
										if('Ag'==$arreglo[$i][0])
											$QP=$QP."Ag&nbsp;".number_format($FilaQp[precio_fijo_ag],3,',','.')."&nbsp;,";
										if('Au'==$arreglo[$i][0])
											$QP=$QP."Au&nbsp;".number_format($FilaQp[precio_fijo_au],3,',','.')."&nbsp;,";
									}	
								}	
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."<br>&nbsp;".$QP."</td>";
							}
						}
						if($FilaCarry[parcializacion]==1)
						{
							if($FilaCarry["estado"]=='2'||$FilaCarry["estado"]=='1')
							{	
								//$TipoEst=substr($TipoEst,0,strlen($TipoEst)-1);
								echo "<input type='hidden' name='Cober' value='3'>";
								echo "<td align='center' rowspan='".$Rowspan."' colspan='2'>";
								echo "</span><a href=JavaScript:ProcesoGrabarCarry2('".$Guardar."','".$NomTxtCCost."','".$DatosExValor."')><img src='archivos/grabar.png'  border='0'  alt='Grabar' align='absmiddle'></a></td>";
								echo "<td align='center' rowspan='".$Rowspan."'>&nbsp;</td>";
								echo "<td align='center' rowspan='".$Rowspan."'><img src='archivos/opc2.png'  border='0'  alt='Inventario Validado por O.C, Toma de Cobertura' align='absmiddle'></td>";
							}
							if($FilaCarry["estado"]=='3')//PROCESO CARRY COST INGRESADO
							{
								echo "<td align='center' rowspan='".$Rowspan."' colspan='2'><a href=JavaScript:AbrirCandado('AC','".$Abrircandado."','".$TipoEst."')><img src='archivos/candado_cerrado.gif'  border='0'  alt='Carry Cost Guardado, Abrir Candado' align='absmiddle'></a></td>";
								$Validar="select * from scop_carry_cost_proceso where corr='".$FilaCarry["corr"]."' and parcializacion='".$FilaCarry[parcializacion]."' and cod_tipo_titulo='1'";
								$RespVali=mysql_query($Validar);$CanMetal=0;
								while($FilaVali=mysql_fetch_array($RespVali))
								{
									$CanMetal=$CanMetal+1;
								}
								if($Existe==$CanMetal)// MUESTRA CUANDO EL ESTADO ES 3 Y VALOR PARA EL MES ES DISTINTO A CERO
									echo "<td align='center' rowspan='".$Rowspan."'><a href=JavaScript:ValidaPM('".$Guardar."','".$NomTxtCCost."','".$TipoEst."')><img src='archivos/acepta_final6.png'  border='0'  alt='Validar Precios Metales para Imputar' align='absmiddle'></a></td>";
								else
									echo "<td align='center' rowspan='".$Rowspan."'>Metales no Ingresados</td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/vco3.png'  border='0'  alt='Ingreso de Carry Cost por la VCO y envio a O.C' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Ingreso de Carry Cost por la VCO y envio a O.C' align='absmiddle'><img src='archivos/opc.png'  border='0'  alt='Ingreso de Carry Cost por la VCO y envio a O.C' align='absmiddle'></td>";
							}
							if($FilaCarry["estado"]=='4')//PROCESO IMPUTACION INGRESADO
							{
								echo "<td align='center' rowspan='".$Rowspan."' colspan='2'><img src='archivos/candado_cerrado.gif'  border='0'  alt='Proceso Imputacion/Precio Ingresado' align='absmiddle'></td>";
								echo "<td align='center' rowspan='".$Rowspan."'><a href=JavaScript:ValidaPM('".$Guardar."','".$NomTxtCCost."','".$TipoEst."')><img src='archivos/acepta_final6.png'  border='0'  alt='Validar Precios Metales para Imputar' align='absmiddle'></a></td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/opc3.png'  border='0'  alt='Ingreso Precios Metales y Envio correo a VCO para Validaci&oacute;n' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Ingreso Precios Metales y Envio correo a VCO para Validaci&oacute;n' align='absmiddle'><img src='archivos/vco.png'  border='0'  alt='Ingreso Precios Metales y Envio correo a VCO para Validaci&oacute;n' align='absmiddle'></td>";
							}
							if($FilaCarry["estado"]=='5')//ESTADO VALIDADO DE METALES POR LA VCO 
							{
								echo "<td align='center' rowspan='".$Rowspan."' colspan='2'><img src='archivos/candado_cerrado.gif'  border='0'  alt='Proceso Imputacion/Precio Ingresado' align='absmiddle'></td>";
								echo "<td align='center' rowspan='".$Rowspan."'><a href=JavaScript:DesValidaPM('".$Guardar."','".$NomTxtCCost."','".$TipoEst."')><img src='archivos/acepta.png'  border='0'  alt='Precios Validados' align='absmiddle'></a></td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/vco2.png'  border='0'  alt='Resultado Validado VCO y Envio Correo Contraloria' align='absmiddle'><img src='archivos/email.png'  border='0'  alt='Resultado Validado VCO y Envio Correo Contraloria' align='absmiddle'><img src='archivos/contraloria.png'  border='0'  alt='Resultado Validado VCO y Envio Correo Contraloria' align='absmiddle'></td>";
							}
							if($FilaCarry["estado"]=='6')//VALOR IMPUTACION INGRESADO 
							{
								echo "<td align='center' rowspan='".$Rowspan."' colspan='2'><img src='archivos/candado_cerrado.gif'  border='0'  alt='Cerrado' align='absmiddle'></td>";
								echo "<td align='center' rowspan='".$Rowspan."'><img src='archivos/acepta.png'  border='0'  alt='Validado' align='absmiddle'></td>";
								echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'><img src='archivos/btn_pagar.png'  border='0'  alt='Cierre Cobertura de Precios y Resultados Cobertura Imputaci&oacute;n a Centros de Cotos' align='absmiddle'></td>";
							}
						}
					}	
					else
					{
							echo "<td align='center' rowspan='".$Rowspan."' colspan='2'>&nbsp;</td>";
							echo "<td align='center' rowspan='".$Rowspan."'>&nbsp;</td>";
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'>&nbsp;</td>";
							echo "<td align='center' bgcolor='#FFFFFF' rowspan='".$Rowspan."'>&nbsp;</td>";
					}
					$NumParcial++;	
				}
					
		}	
		?>
       </table></td>
       <td width="10" background="../scop_web/archivos/images/interior/form_der.gif"></td>
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
<? 
}
	if($Enviocc=='S')
   {
?>
	<script language="javascript">
	alert("Proceso Carry Cost validado y Envio Correo Satisfactorio")
	</script>
<? }
	if($Enviocc=='N')
   {
?>
	<script language="javascript">
	alert("Proceso Carry Cost validado, no hay Correos para este Proceso")
	</script>
<? }
	if($EnvioPv=='S')
   {
?>
	<script language="javascript">
	alert("Proceso Precios Metales validado y Envio Satisfactorio")
	</script>
<? }
	if($EnvioPv=='N')
   {
?>
	<script language="javascript">
	alert("Proceso Precios Metales validado, no hay Correos para este Proceso")
	</script>
<? }

function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
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
			$Datos1=$Datos1."'1',";
		if('Ag'==$arreglo[$i][0])
			$Datos1=$Datos1."'2',";
		if('Au'==$arreglo[$i][0])
			$Datos1=$Datos1."'3',";
	}
	if($Datos1!='')
		$Datos1=substr($Datos1,0,strlen($Datos1)-1);
	$In="(".$Datos1.")";
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";	
	$Resp = mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_ley in $In and cod_tipo_titulo='1'";
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
		for($i=0;$i<=$x;$i++)
		{
			if('Cu'==$arreglo[$i][0])
			{	
				echo "<td align='right'>".number_format($ValorCobre,3,',','.')."";
				echo "<input type='hidden' size='10' class='SinBorde' name='InventarioCu' value=".number_format($ValorCobre,3,',','.').">";				
				if($Datos=='S'&&$Parci==1&&($ValorCobre!=0||$ValorCobre!=''))
					echo "<a href=JavaScript:Parcializar('".$Parcializar."','N','".$TipoEst."','".$Acuerdo."','1')><img src='archivos/mod_inventario.png' width='16' height='16' border='0'  alt='Parcializar Valor' align='absmiddle'></a></td>";
				$ArrInventario[1][Cu]=$ValorCobre;
			}
			if('Ag'==$arreglo[$i][0])
			{	
				echo "<td align='right'>".number_format($ValorPLata,3,',','.')."";
				echo "<input type='hidden' size='10' class='SinBorde' name='InventarioAg' value=".number_format($ValorPLata,3,',','.').">";	
				if($Datos=='S'&&$Parci==1&&($ValorPLata!=0||$ValorPLata!=''))
					echo "<a href=JavaScript:Parcializar('".$Parcializar."','N','".$TipoEst."','".$Acuerdo."','2')><img src='archivos/mod_inventario.png' width='16' height='16' border='0'  alt='Parcializar Valor' align='absmiddle'></a></td>";
				$ArrInventario[2][Ag]=$ValorPLata;
			}
			if('Au'==$arreglo[$i][0])
			{			
				echo "<td align='right'>".number_format($ValorOro,3,',','.')."";
				echo "<input type='hidden' size='10' class='SinBorde' name='InventarioAu' value=".number_format($ValorOro,3,',','.').">";	
				if($Datos=='S'&&$Parci==1&&($ValorOro!=0||$ValorOro!=''))
					echo "<a href=JavaScript:Parcializar('".$Parcializar."','N','".$TipoEst."','".$Acuerdo."','3')><img src='archivos/mod_inventario.png' width='16' height='16' border='0'  alt='Parcializar Valor' align='absmiddle'></a></td>";
				$ArrInventario[3][Au]=$ValorOro;
			}
		}
	}
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Datos='';	
	for($i=0;$i<=$x;$i++)
	{
		if('Cu'==$arreglo[$i][0])
			$Datos=$Datos."'1',";
		if('Ag'==$arreglo[$i][0])
			$Datos=$Datos."'2',";
		if('Au'==$arreglo[$i][0])
			$Datos=$Datos."'3',";
	}
	if($Datos!='')
		$Datos=substr($Datos,0,strlen($Datos)-1);
	$In="(".$Datos.")";
	for($s=1;$s<=3;$s++)
	{
		$ArrCarry[1][Cu]=0;$ArrCarry[2][Ag]=0;$ArrCarry[3][Au]=0;
	}
	for($i=0;$i<=$x;$i++)
	{
		if('Cu'==$arreglo[$i][0])
		{
			$Datos=1;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$NomTxt="Cu_".$Fila["corr"]."_".$Fila[parcializacion];
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							echo "<a href=JavaScript:ModificarCarryCost('".$Cod."','".$TipoEst."')><img src='archivos/modificar2.png' width='15' height='15' border='0'  alt='Modificar' align='absmiddle'></a></td>";		
							$ArrCarry[1][Cu]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[1][Cu]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<input type='hidden' name='EstadoCu' value='2'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='".number_format($FilaPro["valor"],3,',','.')."'></td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."'></td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'><input type='hidden' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='0'>&nbsp;</td>";
			}
		}
		if('Ag'==$arreglo[$i][0])
		{
			$Datos=2;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$NomTxt="Ag_".$Fila["corr"]."_".$Fila[parcializacion];
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							echo "<a href=JavaScript:ModificarCarryCost('".$Cod."','".$TipoEst."')><img src='archivos/modificar2.png' width='15' height='15' border='0'  alt='Modificar' align='absmiddle'></a></td>";		
							$ArrCarry[2][Ag]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[2][Ag]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<input type='hidden' name='EstadoCu' value='2'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='".number_format($FilaPro["valor"],3,',','.')."'></td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."'></td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'><input type='hidden' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='0'>&nbsp;</td>";
			}
		}			
		if('Au'==$arreglo[$i][0])
		{
			$Datos=3;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$NomTxt="Au_".$Fila["corr"]."_".$Fila[parcializacion];
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							echo "<a href=JavaScript:ModificarCarryCost('".$Cod."','".$TipoEst."')><img src='archivos/modificar2.png' width='15' height='15' border='0'  alt='Modificar' align='absmiddle'></a></td>";		
							$ArrCarry[3][Au]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[3][Au]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<input type='hidden' name='EstadoCu' value='2'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='".number_format($FilaPro["valor"],3,',','.')."'></td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'><input type='text' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."'></td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'><input type='hidden' maxlength='10' size='10' onKeyDown='SoloNumerosyNegativo(true,this)' name='".$NomTxt."' value='0'>&nbsp;</td>";
			}
		}	
	}		
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Consulta="select corr,acuerdo_contractual,tipo_precio,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Corr=$Fila["corr"];
		if($Fila[acuerdo_contractual]=='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Consulta="select t2.cod_contrato,t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_cu='2' and t2.vigente='1'";
						$Resp=mysql_query($Consulta);$CantidadCu=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
						echo "<td align='right'>".number_format($CantidadCu,3,',','.')."<input type='hidden' size='10' name='OpeCu1' class='SinBorde' value=".number_format($CantidadCu,2,',','.').">&nbsp;</td>";	
						$ArrPrecios2[1][Cu]=$CantidadCu;
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_ag='2' and t2.vigente='1'";
						$Resp=mysql_query($Consulta);$CantidadAg=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadAg=$CantidadAg+$Fila[acuerdo_ag];
						echo "<td align='right'>".number_format($CantidadAg,3,',','.')."<input type='hidden' size='10' name='OpeAg1' class='SinBorde' value=".number_format($CantidadAg,2,',','.').">&nbsp;</td>";	
						$ArrPrecios2[2][Ag]=$CantidadAg;
					}
					if('Au'==$arreglo[$i][0])
					{
						$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_au='2' and t2.vigente='1'";
						$Resp=mysql_query($Consulta);$CantidadAu=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadAu=$CantidadAu+$Fila[acuerdo_au];
						echo "<td align='right'>".number_format($CantidadAu,3,',','.')."<input type='hidden' size='10' name='OpeAu1' class='SinBorde' value=".number_format($CantidadAu,2,',','.').">&nbsp;</td>";	
						$ArrPrecios2[3][Ag]=$CantidadAu;
					}
				}			
			}
		}
		if($Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//CAMBIO QP
			{
				$MesSuma=$CmbAcuerdo+$Mes;		
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
					$MesDeEntregaValor=$CmbAcuerdo+$Mes;		
					$AnoAux=$Ano;
				}
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Ley=1;
						//CONSULTO EL VALOR CON EL QP INGRESADO
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeCu1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios2[1][Cu]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Ley=2;
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeAg1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios2[2][Ag]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Au'==$arreglo[$i][0])
					{
						$Ley=3;
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						//echo $Consulta."<br>";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeAu1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios2[3][Au]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
				}	
			}		
		}
	}	
}
function ValorPreciosOperacionesAcuerdoQp($Corr,$Parci,$Ano,$Mes,$TipoEst,$ArrPrecios)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Consulta="select acuerdo_contractual,tipo_precio,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);$MesDeEntregaValor=0;
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
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Ley=1;
						//CONSULTO EL VALOR CON EL QP INGRESADO
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorCu."' and cod_ley='".$Ley."'";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeCu1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios[1][Cu]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Ley=2;
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAg."' and cod_ley='".$Ley."'";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeAg1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios[2][Ag]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Au'==$arreglo[$i][0])
					{
						$Ley=3;
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAu."' and cod_ley='".$Ley."'";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."<input type='hidden' size='10' name='OpeAu1' class='SinBorde' value=".number_format($Fila["valor"],2,',','.').">&nbsp;</td>";	
							$ArrPrecios[3][Au]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
				}	
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_cu],3,',','.')."<input type='hidden' size='10' name='OpeCu1' class='SinBorde' value=".number_format($Fila[precio_fijo_cu],2,',','.').">&nbsp;</td>";	
						$ArrPrecios[1][Cu]=$Fila[precio_fijo_cu];
					}
					if('Ag'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_ag],3,',','.')."<input type='hidden' size='10' name='OpeAg1' class='SinBorde' value=".number_format($Fila[precio_fijo_ag],2,',','.').">&nbsp;</td>";	
						$ArrPrecios[2][Ag]=$Fila[precio_fijo_ag];
					}
					if('Au'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_au],3,',','.')."<input type='hidden' size='10' name='OpeAu1' class='SinBorde' value=".number_format($Fila[precio_fijo_au],2,',','.').">&nbsp;</td>";	
						$ArrPrecios[3][Au]=$Fila[precio_fijo_au];
					}
				}			
			}
		}
	}	
}
?>

