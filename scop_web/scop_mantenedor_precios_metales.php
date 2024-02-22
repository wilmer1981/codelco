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

if ($Opc=='MP')
{
    $Datos=explode("~",$Valores);
	$Consulta="select cod_ley,ano,mes,valor,cod_unidad from scop_precios_metales where ano='".$Datos[0]."' and mes='".$Datos[1]."'";	
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Ano=$Fila["ano"];
		$Mes=$Fila["mes"];
		if($Fila["cod_ley"]=='1')
		{
			$TxtValorCu=$Fila["valor"];
			$UniCu=$Fila["cod_unidad"];
		}
		if($Fila["cod_ley"]=='2')
		{
			$UniAg=$Fila["cod_unidad"];
			$TxtValorAg=$Fila["valor"];
		}
		if($Fila["cod_ley"]=='3')
		{	
			$UniAu=$Fila["cod_unidad"];
			$TxtValorAu=$Fila["valor"];				
		}
	}
}	
else
{
	if(!isset($AnoAux))
		$AnoAux=date('Y');
	if(!isset($Ano))
		$Ano=date('Y');
	if(!isset($Mes))
		$Mes=date('m');
	$TxtValorCu='';
	$TxtValorAg='';
	$TxtValorAu='';
}
?>
<html>
<head>
<title>Proceso Cobertura de Precios</title>
<script language="javascript" src="../scop_web/funciones/scop_funciones.js"></script>
<script language="javascript">
function Proceso(Opcion)
{
	var f= document.FrmPrincipal;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "NP":
				if(f.Mes.value=='-1')
				{
					alert("Debe Seleccionar Mes")
					f.Mes.focus();
					return;
				}
				f.action = "scop_mantenedor_precios_metales01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "MP":
				f.action = "scop_mantenedor_precios_metales01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
				f.action = "scop_mantenedor_precios_metales.php?Opc=NP";
				f.submit();
				break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=33";
		break;
		case "I"://IMPRIMIR
			window.print();
		break;			
		case "R":
				f.action = "scop_mantenedor_precios_metales.php?Opc=NP";
				f.submit();
		break;
	}
}
function Excel()
{
	var f=document.FrmPrincipal;
	URL='scop_mantenedor_precios_metales_excel.php?AnoAux='+f.AnoAux.value;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
}
function Modificar(Datos)
{
	var f= document.FrmPrincipal;
	f.action = "scop_mantenedor_precios_metales.php?Opc=MP&Valores="+Datos;
	f.submit();
}
function Eliminar(Datos)
{
	var f= document.FrmPrincipal;	
	f.action = "scop_mantenedor_precios_metales01.php?Opcion=EP&Valores="+Datos;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'cobertura_precios.png')
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
        <td width="168" align="left" class='formulario2'>&nbsp;</td>
        <td align="right" class='formulario2' colspan="5">
		<a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
		<a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Excel('')"><img src="archivos/excel.png"   alt="Excel"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/salir.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
      </tr>
      <tr>
        <td width="168" class="formulario2">A&ntilde;o</td>
           <td colspan="6" class="formulario2">
		   <?
		   	if($Opc=='NP')
			{
		   ?>
			   <select name="Ano" id="Ano" onChange="JavaScript:Proceso('R')">
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
			?>		   </td>
          </tr>
		<tr>	 		 		  				 				  	 
           <td width="168" class="formulario2">Mes</td>
           <td colspan="7" class="formulario2">
		   <?
		   	if($Opc=='NP')
			{
		   ?>
		   <select name="Mes" id="Mes" >
             <option value="-1" selected="selected" >Seleccionar</option>
               <?
				for ($i=1;$i<=12;$i++)
				{
					 $Consulta = "select distinct t1.mes from scop_precios_metales t1  ";			
					 $Consulta.= " where t1.mes='".$i."' and ano='".$Ano."'";
					 //echo $Consulta;
					 $Resp=mysql_query($Consulta);
					 if(!$FilaTC=mysql_fetch_array($Resp))
					 {
						if ($i==$Mes)
							echo "<option selected value=".$i.">".$Meses[$i-1]."</option>\n";
						else
							echo "<option value=".$i.">".$Meses[$i-1]."</option>\n";
					 }	
				}
				?>
           </select>
			<?
			}
			else
			{
				echo $Meses[$Mes-1];
				echo "<input type='hidden' name='Mes' value='".$Mes."'>";
			}	
			?>		   </td>
         </tr>
		<tr>	 		 		  				 				  	 
           <td width="168" class="formulario2">Precio  Cu.</td>
           <td width="201" class="formulariosimple"><span class="formulario2">
             <input name="TxtValorCu" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "15"  size="16" type="text" id="TxtValorCu" value="<? echo number_format($TxtValorCu,3,',','.'); ?>">
			   <select name="UniCu" >
				   <?
						$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='33004' and valor_subclase1='1'";
						$Resp=mysql_query($Consulta);
						while($Fila=mysql_fetch_array($Resp))
						{	
							if ($UniCu==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}							
				   ?>
			   </select>
		   </span></td>
           <td width="72" class="formulario2">Precio  Ag.</td>
           <td width="194" class="formulariosimple"><span class="formulario2">
             <input name="TxtValorAg" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "15"  size="16" type="text" id="TxtValorAg" value="<? echo number_format($TxtValorAg,3,',','.'); ?>">
			   <select name="UniAg" >
				   <?
						$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='33004' and valor_subclase1='2'";
						$Resp=mysql_query($Consulta);
						while($Fila=mysql_fetch_array($Resp))
						{	
							if ($UniAg==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}							
				   ?>
			   </select>
           </span></td>
           <td width="67" class="formulario2">Precio  Au.</td>
           <td width="192" class="formulariosimple"><span class="formulario2">
             <input name="TxtValorAu" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "15"  size="16" type="text" id="TxtValorAu" value="<? echo number_format($TxtValorAu,3,',','.'); ?>">
			   <select name="UniAu" >
				   <?
						$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='33004' and valor_subclase1='3' and nombre_subclase='USD/OZ'";
						$Resp=mysql_query($Consulta);
						while($Fila=mysql_fetch_array($Resp))
						{	
							if ($UniAu==$Fila["cod_subclase"])
								echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
						}							
				   ?>
			   </select>
           </span></td>
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
    <td align="center"><table width="100%" border="1" cellpadding="2" cellspacing="0" >
      <tr>
        <td width="5%" colspan="8" align="left" class="TituloCabecera">A&ntilde;o Busqueda
		&nbsp;&nbsp;
          <select name="AnoAux" id="AnoAux" onChange="JavaScript:Proceso('R')">
            <?
				for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
				{
					if ($i==$AnoAux)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
				?>
          </select>
        </td>
	  </tr>	
      <tr>
        <td width="5%" rowspan="2" align="center" class="TituloCabecera">Elim/Mod</td>
        <td width="20%" rowspan="2" align="center" class="TituloCabecera">A&ntilde;o/Mes</td>
        <td width="15%" colspan="2" align="center" class="TituloCabecera">Cu</td>
        <td width="15%" colspan="2" align="center" class="TituloCabecera">Ag</td>
        <td width="15%" colspan="2" align="center" class="TituloCabecera">Au</td>
      </tr>
      <tr>
        <td  align="center" class="TituloCabecera">Valor</td>
        <td  align="center" class="TituloCabecera">Unidad</td>
        <td  align="center" class="TituloCabecera">Valor</td>
        <td  align="center" class="TituloCabecera">Unidad</td>
        <td  align="center" class="TituloCabecera">Valor</td>
        <td  align="center" class="TituloCabecera">Unidad</td>
      </tr>
      <?
				$Consulta="select t1.cod_ley,t1.ano,t1.mes,t1.valor,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from scop_precios_metales t1";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33003' and t1.cod_ley=t2.cod_subclase";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='33004' and t1.cod_unidad=t3.cod_subclase";
				$Consulta.=" where ano='".$AnoAux."'";						
				$Consulta.=" group by ano,mes";						
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{						
						$Cod=$Fila["ano"]."~".$Fila["mes"];
					 echo "<tr bgcolor='#FFFFFF'>";
					   echo "<td align='center' ><a href=JavaScript:Eliminar('".$Cod."')><img src='archivos/eliminar2.png'  border='0'  alt='Nuevo' align='absmiddle'></a>
					   &nbsp;<a href=JavaScript:Modificar('".$Cod."')><img src='archivos/modificar2.png'  border='0'  alt='Nuevo' align='absmiddle'></a></td>";
					   echo "<td align='left' >".$Fila["ano"]."/".$Meses[$Fila["mes"]-1]."</td>";
						for($i=1;$i<=3;$i++)
						{
							echo "<td align='right' >".number_format($ValorFino=BuscarValor($i,$Fila["ano"],$Fila["mes"],'v'),3,',','.')."</td>";
							echo "<td align='center' >".BuscarValor($i,$Fila[ano],$Fila["mes"],'u')."</td>";
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
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==1&&$Envio=='S')
		echo "alert('Registro Ingresado Exitosamente, Envio de Correo Exitoso');";
	if ($Mensaje==1&&$Envio=='N')
		echo "alert('Registro Ingresado Exitosamente, No Existen Correos para este Proceso');";
	if ($Mensaje==2)
		echo "alert('Este Registro Existe');";
	if ($Mensaje==3)
		echo "alert('Registro Modificado Exitosamente');";
	if ($Mensaje==4)
		echo "alert('Registro Eliminado Exitosamente');";
	echo "</script>";

function BuscarValor($CodLey,$Ano,$Mes,$Tipo)
{
	$Consulta="select t1.valor,t2.nombre_subclase from scop_precios_metales t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33004' and t1.cod_unidad=t2.cod_subclase and t2.valor_subclase1=t1.cod_ley";
	$Consulta.=" where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.cod_ley='".$CodLey."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Nom_uni=$Fila["nombre_subclase"];
		$Valor=$Fila["valor"];
	}	
	if($Tipo=='v')
		return $Valor;
	else
		return $Nom_uni;	
}
?>
