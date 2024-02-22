
<? include("../principal/conectar_scop_web.php");

if ($Opc=='MF')
{
    $Datos=explode("~",$Valores);
	$Consulta="select ano,mes,tipo_mov,tipo_dato,origen,cod_flujo,nom_flujo,peso,cobre,plata,oro from scop_datos_enabal where origen='OTRO' and ano='".$Datos[0]."'and mes='".$Datos[1]."' and tipo_mov='".$Datos[3]."'";
	$Resp=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		$TxtCodFlujo=$Fila["cod_flujo"];
		$TxtDescripcion=$Fila[nom_flujo];
		$Ano=$Fila["ano"];
		$Mes=$Fila["mes"];
		$TipoDato=$Fila[tipo_mov];
		$TxtPesoSeco=$Fila["peso"];
		$TxtCu=$Fila[cobre];$TxtAg=$Fila[plata];$TxtAu=$Fila[oro];
	}
}	
else
{
	$TxtCodFlujo='';
	$TxtDescripcion='';
	$Ano=date('Y');
	$Mes=date('m');
	$TxtPesoSeco='';
	$TxtCu='';$TxtAg='';$TxtAu='';
	if(!isset($CmbSeleccionar))
		$CmbSeleccionar='-1';
}
if(!isset($AnoBus))
	$AnoBus=date('Y');
?>
<html>
<head>
<?
	if ($Opc=='NF')
		echo "<title>Nuevo Flujo</title>";
	else	
		echo "<title>Modifica Flujo</title>";
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
		case "NF":
			if(f.TxtCodFlujo.value=='')
			{
				alert("Debe Ingresar C�digo Flujo");
				f.TxtCodFlujo.focus();
				return;
			}
			if(f.TxtDescripcion.value=='')
			{
				alert("Debe Ingresar Nombre de Flujo");
				f.TxtDescripcion.focus();
				return;
			}			
			if(f.TipoDato.value=='-1')
			{
				alert("Debe Seleccionar Tipo dato");
				f.TipoDato.focus();
				return;
			}			
			if(f.Ano.value=='-1')
			{
				alert("Debe Seleccionar A�o");
				f.Ano.focus();
				return;
			}
			if(f.Mes.value=='-1')
			{
				alert("Debe Seleccionar Mes");
				f.MEs.focus();
				return;
			}
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion;
			f.submit();
			break;
		case "MF":
			if(f.TipoDato.value=='-1')
			{
				alert("Debe Seleccionar Tipo dato");
				f.TipoDato.focus();
				return;
			}			
			if(f.Ano.value=='-1')
			{
				alert("Debe Seleccionar A�o");
				f.Ano.focus();
				return;
			}
			if(f.Mes.value=='-1')
			{
				alert("Debe Seleccionar Mes");
				f.Mes.focus();
				return;
			}
			f.action = "scop_mantenedor_contratos_proceso01.php?Opcion="+Opcion;
			f.submit();
			break;
		case "NI":
			f.action = "scop_mantenedor_contratos_otros_flujos.php?Opc=NF";
			f.submit();
			break;
		case "R":	
			f.action = "scop_mantenedor_contratos_otros_flujos.php";
			f.submit();
		break;
				
	}
}
function Eliminar(Datos)
{
	var f= document.FrmPopupProceso;	
	f.action = "scop_mantenedor_contratos_proceso01.php?Opcion=EF";
	f.submit();
}
function Buscar(Opc)
{
	var f= document.FrmPopupProceso;	
	f.action = "scop_mantenedor_contratos_otros_flujos.php?Opc="+Opc;
	f.submit();
}
function Modificar(Datos)
{
	var f= document.FrmPopupProceso;	
	f.action = "scop_mantenedor_contratos_otros_flujos.php?Opc=MF&Valores="+Datos;
	f.submit();
}
function Recarga(Opc)
{
	var f= document.FrmPopupProceso;
	f.action = "scop_mantenedor_contratos_otros_flujos.php?Opc="+Opc;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
</head>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" >
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
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
       <td width="74%" align="left"><?	if($Opc=='NF'){?><img src="../scop_web/archivos/subtitulos/sub_tit_otros_flujos.png"><? }else{?><img src="../scop_web/archivos/subtitulos/sub_tit_otros_flujos_m.png"><?	}?></td>
       <td align="right">	   
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a><a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../scop_web/archivos/grabar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../scop_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" cellpadding="3" cellspacing="0" >
		   <?
		   if($Opc=='NF')
		   {
		   ?>	
			 <tr>
			   <td width="185" class="formulario2">Seleccionar </td>
			   <td class="formulario2" colspan="3">
				   <select name="CmbSeleccionar" onChange="JavaScript:Recarga('<? echo $Opc;?>')">
				   <option value="-1" class="NoSelec">Ingresar</option>
					   <?
						$Consulta = "select distinct cod_flujo,nom_flujo from scop_datos_enabal where origen='OTRO'";
						$Resp=mysql_query($Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbSeleccionar==$Fila["cod_flujo"]."~".$Fila["nom_flujo"])
								echo "<option selected value='".$Fila["cod_flujo"]."~".$Fila["nom_flujo"]."'>".$Fila["cod_flujo"]." - ".ucfirst($Fila["nom_flujo"])."</option>\n";
							else
								echo "<option value='".$Fila["cod_flujo"]."~".$Fila["nom_flujo"]."'>".$Fila["cod_flujo"]." - ".ucfirst($Fila["nom_flujo"])."</option>\n";
						}
					   ?>
				   </select>			 </td>
			</tr> 
		   <?
		   }
		   
		   if($Opc=='NF')
		   {
				$CmbSeleccionar=explode("~",$CmbSeleccionar);
				if($CmbSeleccionar[0]=='-1')
				{
			   ?>
				 <tr>
				   <td width="185" class="formulario2">Codigo Flujo </td>
				   <td class="formulario2" colspan="3">
					 <input name="TxtCodFlujo" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "48"  size="10" type="text" id="TxtCodFlujo" value="<? echo $TxtCodFlujo; ?>">
				   <span class="InputRojo">(*)</span></td>
				 </tr>
			  <?
				}
				else
				{
				 echo "<tr>";
				   echo "<td width='96' class='formulario2'>Codigo Flujo</td>";
				   echo "<td width='289' class='formulario2' colspan='3'>";
					echo $CmbSeleccionar[0];
				   echo "</td>";
				 echo "</tr>";  	
					echo "<input type='hidden' name='TxtCodFlujo' value='".$CmbSeleccionar[0]."'>";
				}
			}
			else
			{
			 echo "<tr>";
			   echo "<td width='96' class='formulario2'>Codigo Flujo&nbsp;&nbsp;</td>";
			   echo "<td width='289' class='formulario2' colspan='3'>";
				echo $TxtCodFlujo;
				echo "<input type='hidden' name='TxtCodFlujo' value='".$TxtCodFlujo."'>";
			   echo "</td>";
			 echo "</tr>";  	
			} 
				
		   if($Opc=='NF')
		   {
				if($CmbSeleccionar[0]=='-1')
				{
			   ?>
				<tr>	 		 		  				 				  	 
				   <td width="185" class="formulario2">Nombre Flujo </td>
				   <td class="formulario2" colspan="4"><span class="formulariosimple">
					 <input name="TxtDescripcion" maxlength= "48"  size="80" type="text" id="TxtDescripcion" value="<? echo $TxtDescripcion; ?>">
					 <span class="InputRojo">(*)</span></span></td>
			    </tr>
			  <?
				}
				else
				{
				 echo "<tr>";
				   echo "<td width='96' class='formulario2'>Nombre Flujo</td>";
				   echo "<td width='289' class='formulario2' colspan='3'>";
					echo $CmbSeleccionar[1];
				   echo "</td>";
				 echo "</tr>";  	
					echo "<input type='hidden' name='TxtDescripcion' value='".$CmbSeleccionar[1]."'>";
				}
			}
			else
			{
			 echo "<tr>";
			   echo "<td width='96' class='formulario2'>Nombre Flujo</td>";
			   echo "<td width='289' class='formulario2' colspan='3'>";
				echo $TxtDescripcion;
				echo "<input type='hidden' name='TxtDescripcion' value='".$TxtDescripcion."'>";
			   echo "</td>";
			 echo "</tr>";  	
			}
			  ?> 
		<tr>	 		 		  				 				  	 
		   <td width="185" class="formulario2">Tipo Dato </td>
		   <td class="formulario2" colspan="4">
		  <select name="TipoDato" id="TipoDato">
		  <option value="-1" selected="selected" >Seleccionar</option>	  
		   <?
		     switch($TipoDato)
			 {
			 	case '2':	
						echo "<option value='2' selected>Flujo</option>";
						echo "<option value='3'>Existencia</option>";
				break;
			 	case '3':	
						echo "<option value='2'>Flujo</option>";
						echo "<option value='3' selected>Existencia</option>";
				break;
			 	default:	
						echo "<option value='2'>Flujo</option>";
						echo "<option value='3'>Existencia</option>";
				break;
			 }
		   ?>
		   </select>
		   </td>
		</tr>
		   <tr>
			<td height="17" class='formulario2'>A&ntilde;o </td>
		     <td width="361" class='formulario2'>
		      <select name="Ano" id="Ano">
		      <option value="-1" selected="selected" >Seleccionar</option>	  
		      <?
				  for ($i=date("Y")-2;$i<=date("Y")+1;$i++)
				  {
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				  }
		      ?>
		      </select>
			  <span class="InputRojo">(*)</span>			  </td> 
			   <td width="43" align="right" class='formulario2'>Mes </td>   
			   <td width="451" class='formulario2' >
				<select name="Mes" id="Mes" >
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
                <span class="InputRojo">(*)</span>			   </td>
		  </tr>	
          <tr>
           <td align="left" class="formulario2">Peso Seco </td>
           <td align="left" class="formulario2"><span class="formulariosimple">
             <input name="TxtPesoSeco" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "48"  size="20" type="text" id="TxtPesoSeco" value="<? echo $TxtPesoSeco; ?>">
             [Kg]
             <span class="InputRojo">(*)</span></span></td>
           <td align="right" class="formulario2">Cu</td>
           <td align="left" class="formulario2"><span class="formulariosimple">
             <input name="TxtCu" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "48"  size="20" type="text" id="TxtCu" value="<? echo $TxtCu; ?>">
             [kg]
             <span class="InputRojo">(*)</span></span></td>
          </tr>
          <tr>
            <td align="left" class="formulario2">Ag</td>
            <td align="left" class="formulario2"><span class="formulariosimple">
              <input name="TxtAg" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "48"  size="20" type="text" id="TxtAg" value="<? echo $TxtAg; ?>">
            [Grs]<span class="InputRojo">(*)</span></span></td>
            <td align="right" class="formulario2">Au</td>
            <td align="left" class="formulario2"><span class="formulariosimple">
              <input name="TxtAu" onKeyDown="SoloNumerosyNegativo(true,this)" maxlength= "48"  size="20" type="text" id="TxtAu" value="<? echo $TxtAu; ?>">
            [Grs]<span class="InputRojo">(*)</span></span></td>
          </tr>
          <tr>
            <td colspan="2" align="left" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
            <td align="left" class="formulario2">&nbsp;</td>
            <td align="left" class="formulario2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="formulario2"><em>Busqueda de Flujos </em></td>
            </tr>
          <tr>
            <td colspan="4" align="left" class="formulario2">A&ntilde;o
              <select name="AnoBus" id="AnoBus" onChange="JavaScript:Buscar('<? echo $Opc;?>')">
                <option value="T" selected="selected" >Todos</option>
                <?
				  for ($i=date("Y")-2;$i<=date("Y")+1;$i++)
				  {
					if ($i==$AnoBus)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				  }
		      ?>
              </select></td>
            </tr>
          <tr>
            <td colspan="4" align="left" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
              <tr align="center">
			    <td width="10%" class="TituloTablaVerde">Elim.</td>
				<td width="10%" class="TituloTablaVerde">Modif.</td>
			    <td width="10%" class="TituloTablaVerde">N� Flujo</td>
			    <td width="10%" class="TituloTablaVerde">Tipo Flujo</td>
                <td width="26%" class="TituloTablaVerde">Descripci�n</td>
				<td width="26%" class="TituloTablaVerde">A�o/Mes</td>
				<td width="13%" class="TituloTablaVerde">Peso Seco </td>
                <td width="13%" class="TituloTablaVerde">Cu [Kg] </td>
                <td width="13%" class="TituloTablaVerde">Ag [Grs]</td>
                <td width="13%" class="TituloTablaVerde">Au [Grs]</td>
              </tr>
			  <?
			    $Consulta="select ano,mes,tipo_mov,tipo_dato,origen,cod_flujo,nom_flujo,peso,cobre,plata,oro from scop_datos_enabal where origen='OTRO' ";
				if($AnoBus!='T')
					$Consulta.=" and ano='".$AnoBus."'";
				$Resp=mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					if($Fila[tipo_mov]==2)
						$Datos='Flujo';
					else
						$Datos='Existencia';	
					$Cod=$Fila["ano"]."~".$Fila["mes"]."~".$Fila[origen]."~".$Fila[tipo_mov]."~".$Fila[tipo_dato]."~".$Fila["cod_flujo"];
					echo "<input type='hidden' size='59' name='Cod' value='".$Cod."'>";
				?>	
				  <tr>
					<td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')"><img src="archivos/eliminar2.png"  border="0"  alt="Nuevo" align="absmiddle"></a></td>
					<td align="center"><a href="JavaScript:Modificar('<? echo $Cod;?>')"><img src="archivos/modificar2.png"  border="0"  alt="Nuevo" align="absmiddle"></a></td>
					<td align="center"><? echo $Fila["cod_flujo"]?></td>
					<td align="center"><? echo $Datos?></td>
					<td align="center"><? echo $Fila[nom_flujo]?></td>
					<td align="center"><? echo $Fila["ano"]." - ".$Meses[$Fila["mes"]-1];?></td>
					<td align="center"><? echo $Fila["peso"]?></td>
					<td align="center"><? echo $Fila[cobre]?></td>
					<td align="center"><? echo $Fila[plata]?></td>
					<td align="center"><? echo $Fila[oro]?></td>
				  </tr>
				<?
				}
			  ?>
            </table></td>
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
	if ($Mensaje)
		echo "alert('".$Mensaje."');";
	if ($Mensaje1)
		echo "alert('".$Mensaje1."');";
	if ($Mensaje2)
		echo "alert('".$Mensaje2."');";
	echo "</script>";
?>