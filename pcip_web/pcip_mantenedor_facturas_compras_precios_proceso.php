
<? include("../principal/conectar_pcip_web.php");

if($Opc=='M')
{
$Disabled='disabled';
}

if($Volver=='S')
{
	if($Valores=='S')
	{
		$Opc='N';
	}
	else
	{
		$Opc='M';
	}
}
if ($Opc=='M')
{
    $Datos=explode("~",$Valores);
	$Consulta="select * from pcip_fac_compra_precios t1 ";
	$Consulta.=" where t1.ano='".$Datos[0]."'and t1.mes='".$Datos[1]."'and t1.cod_fino='".$Datos[2]."' ";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$CmbFino=$Fila["cod_fino"];
		$TxtValor=$Fila["valor"];
		$Ano=$Fila["ano"];		
		$Mes=$Fila["mes"];
		$CmbMoneda=$Fila["cod_moneda"];
	}
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo Precio Metales</title>";
		else	
			echo "<title>Modifica Precio Metales</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">


function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
    var Validado=true;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":	
			if(f.CmbFino.value=='-1')
			{
				alert("Debe Seleccionar Fino");
				f.CmbFino.focus();
				return;
			}			
				if(f.Ano.value=='-1')
			{
				alert("Debe Seleccionar Año");
				f.Ano.focus();
				return;
			}	
				if(f.Mes.value=='-1')
			{
				alert("Debe Seleccionar Mes");
				f.Mes.focus();
				return;
			}				
				if(f.TxtValor.value=='')
			{
				alert("Debe Ingresar Valor");
				f.TxtValor.focus();
				return;
			}	
				if(f.CmbMoneda.value=='-1')
			{
				alert("Debe Seleccionar Tipo Moneda");
				f.CmbMoneda.focus();
				return;
			}	
				f.action = "pcip_mantenedor_facturas_compras_precios_proceso01.php?Opcion="+Opcion;
				f.submit();
		        break;
		case "M":
			if(f.CmbFino.value=='T')
			{
				alert("Debe Seleccionar Fino");
				f.CmbFino.focus();
				return;
			}			
				if(f.Ano.value=='-1')
			{
				alert("Debe Seleccionar Año");
				f.Ano.focus();
				return;
			}	
				if(f.Mes.value=='-1')
			{
				alert("Debe Seleccionar Mes");
				f.Mes.focus();
				return;
			}	
				if(f.TxtValor.value=='')
			{
				alert("Debe Ingresar Valor");
				f.TxtValor.focus();
				return;
			}	
				if(f.CmbMoneda.value=='-1')
			{
				alert("Debe Seleccionar Tipo Moneda");
				f.CmbMoneda.focus();
				return;
			}	
				f.action = "pcip_mantenedor_facturas_compras_precios_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "NI":
			f.action = "pcip_mantenedor_facturas_compras_precios_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
				
	}
}
function Salir()
{
	window.close();
}
</script>
</head>
<?
if ($Opc=='N')
	echo '<body onLoad="document.FrmPopupProceso.CmbFino.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.TxtValor.focus();">';
?>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_precios_metales_n.png"><? }else{?><img src="../pcip_web/archivos/sub_tit_precios_metales_m.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
		<td height="17" class='formulario2'>Fino</td>
		<td colspan="3" class='formulario2'>
			   <select name="CmbFino" onChange="Proceso('R')" <? echo $Disabled;?>>
			   <option value="-1" class="NoSelec" >Seleccionar</option>
			   <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31012' and cod_subclase in('1','2','3')";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbFino==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
			  </select>
			  <?
			   if($Disabled!='')				  
				  {				  
				  echo"<input type='hidden' name='CmbFino' value='".$CmbFino."'>";				  
				  }			  
			  ?>			  
			  <span class="InputRojo">(*)</span>		  </td>  
	  </tr>
	      <tr>
		     <td height="17" class='formulario2'>A&ntilde;o </td>
		     <td width="322" class='formulario2'>
		      <select name="Ano" id="Ano" <? echo $Disabled;?>>
		      <option value="-1" selected="selected" >Seleccionar</option>	  
		      <?
			  for ($i=2003;$i<=date("Y");$i++)
			  {
				if ($i==$Ano)
					echo "<option selected value=\"".$i."\">".$i."</option>\n";
				else
					echo "<option value=\"".$i."\">".$i."</option>\n";
			  }
		      ?>
		      </select>
		      <?
				 if($Disabled!='')				  
					{				  
					echo"<input type='hidden' name='Ano' value='".$Ano."'>";				  
					}			  
		      ?>
			  <span class="InputRojo">(*)</span>	
			  </td> 
			   <td width="77" class='formulario2'>Mes </td>   
			   <td width="450" class='formulario2'>
				<select name="Mes" id="Mes" <? echo $Disabled;?>>
				<option value="-1" selected="selected" >Seleccionar</option>
				<?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
				?>
				</select>
			    <?
		          if($Disabled!='')				  
					{				  
					echo"<input type='hidden' name='Mes' value='".$Mes."'>";				  
					}			  
			    ?>
                <span class="InputRojo">(*)</span>
			   </td>
	       </tr> 	  
	       <tr>
		     <td width="95" class="formulario2">Valor</td>
		     <td width="322" class="formulariosimple" colspan="3">
		     <input name="TxtValor" maxlength= "10" onKeyDown="TeclaPulsada(true)" size="20" type="text" id="TxtValor" value="<? echo number_format($TxtValor,2,',','.'); ?>">
		     <span class="InputRojo">(*)</span></td>
          </tr>
          <tr>
             <td class="formulario2">Moneda</td>
             <td colspan="3" class="formulario2">
			  <select name="CmbMoneda" onChange="Proceso('R')">
              <option value="-1" class="NoSelec">Seleccionar</option>
              <?
				$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31001' and cod_subclase in ('1','2','3')";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbMoneda==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				}
			   ?>
               </select>
			  </td>
            </tr>
          <tr>
           <td colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
          </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   </td>
   <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
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
		echo "alert('Ingreso Satisfactorio');";
	if ($Mensaje2==true)
		echo "alert('Modificación Satisfactoria');";
		
	echo "</script>";
     
?>