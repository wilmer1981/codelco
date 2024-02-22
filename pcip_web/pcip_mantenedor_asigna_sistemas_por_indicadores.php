
<? include("../principal/conectar_pcip_web.php");

?>
<html>
<head><title>Asignación de Sistemas por Indicadores</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar()
{
	var f= document.FrmPopupProceso;
	  if (f.CmbSistema.value=='-1')
    {
     	alert("Debe Seleccionar Sistema")
		f.CmbSistema.focus();
		return;
	}
	if (f.CmbIndica.value=='-1')
	{
     	alert("Debe Seleccionar Indicador")
		f.CmbIndica.focus();
		return;	
	}
	if (f.CmbDivisor.value=='-1')
	{
     	alert("Debe Seleccionar Divisor del Indicador")
		f.CmbDivisor.focus();
		return;	
	}

	f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores_proceso01.php?Opc=G&Sistema="+f.CmbSistema.value+"&Equipo="+f.CmbIndica.value;
	/*alert(f.action)*/
	f.submit();
}
var popup=0;
function Nuevo()
{   
  var f= document.FrmPopupProceso;
	URL="pcip_mantenedor_asigna_sistemas_por_indicadores_Nuevo_proceso.php?Sistema="+f.CmbSistema.value;
	opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=400,scrollbars=1';
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);
}
function Eliminar(Cod)
{   
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores_proceso01.php?Opc=E&Cod="+Cod;
		f.submit();
}
function Recarga()
{
		f=document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_sistemas_por_indicadores.php";
		f.submit();
}
function Salir()
{
		window.close();
}

</script>
</head>
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<table width="92%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_sistemas_por_indicadores.png"></td>
       <td align="right"><a href="JavaScript:Nuevo()"><img src="../pcip_web/archivos/btn_agregar.png" alt="Nuevo/Modificar Indicador"  border="0" align="absmiddle" /></a> <a href="JavaScript:Guardar()"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="20%" class="formulario2" align="justify">Sistema</td>
           <td width="80%" class="formulario2" ><select name="CmbSistema" onChange="Recarga()">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
			  $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas order by nom_sistema ";			
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbSistema==$FilaTC["cod_sistema"])
						echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
				}
			   ?>
			</select></td>
         </tr>
		 <? 	 
				 $Consulta = "select t1.cod_indicador from pcip_eec_sistemas_por_indicadores t1  ";			
				 $Consulta.= " where t1.cod_sistema='".$CmbSistema."'";
					$Resp=mysql_query($Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							$In=$In."'".$FilaTC[cod_indicador]."',";
						
						}
				 
				 $In="(".substr($In,0,strlen($In)-1).")";
				 //echo "IN".$In; 
		 ?>		 
		 <tr>
           <td width="20%" class="formulario2" align="justify">Indicadores</td>
           <td width="80%" class="formulario2" ><select name="CmbIndica">
			<option value="-1" selected="selected">Seleccionar</option>
			    <?
				if($CmbSistema=='-1')
				{
					$Consulta = "select t2.cod_indicador,t2.nom_indicador from  pcip_eec_indicadores t2 order by t2.nom_indicador";
				}
				else
				{
					$Consulta = "select t2.cod_indicador,t2.nom_indicador from  pcip_eec_indicadores t2 ";
					if(strlen($In)>4)
					$Consulta.= " where  t2.cod_indicador not in $In ";
					$Consulta.= "order by t2.cod_indicador ";
				}
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbIndica==$FilaTC["cod_indicador"])
						echo "<option selected value='".$FilaTC["cod_indicador"]."'>".ucfirst($FilaTC["nom_indicador"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_indicador"]."'>".ucfirst($FilaTC["nom_indicador"])."</option>\n";
				}	
				?>
		  </select><? //echo $Consulta;?></td>
         </tr>
		 <tr>
           <td width="20%" class="formulario2" align="justify">Divisor Indicadores</td>
           <td width="80%" class="formulario2" ><select name="CmbDivisor">
			<option value="-1" selected="selected">Seleccionar</option>
			    <?
				$Consulta = "select cod_subclase,nombre_subclase as nom_divisor from  proyecto_modernizacion.sub_clase where cod_clase='31011' order by cod_subclase";
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbDivisor==$FilaTC["cod_subclase"])
						echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nom_divisor"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nom_divisor"])."</option>\n";
				}	
				?>
		  </select><? //echo $Consulta;?></td>
         </tr>          
		  <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
				 <tr align="center">
				   <td width="5%" class="TituloTablaVerde">Elim.</td>
				   <td width="6%" class="TituloTablaVerde">Codigo</td>
				   <td width="35%" class="TituloTablaVerde">Indicadores</td>
				   <td width="47%" class="TituloTablaVerde">Divisor Indicador</td>
				   <td width="7%" class="TituloTablaVerde">Vigente</td>				   
				 </tr>
             <?
		
				$Consulta = "select t1.cod_indicador,t1.nom_indicador,t1.vigente,t3.nombre_subclase as nom_divisor  from pcip_eec_sistemas_por_indicadores t2 inner join pcip_eec_indicadores t1 on";			
				$Consulta.=" t1.cod_indicador=t2.cod_indicador left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31011' and t2.cod_divisor=t3.cod_subclase where t2.cod_sistema='".$CmbSistema."' order by t1.cod_indicador";
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {				
					$Cod=$Fila["cod_indicador"];
					$Ind=$Fila["nom_indicador"];
					$Div=$Fila["nom_divisor"];
			        $Vig=$Fila["vigente"]; 
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')" name="Elim"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Ind; ?></td>
			   <td ><? echo $Div; ?></td>
			   <td  align="center"><? echo $Vig; ?></td>
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
   <td width="1%" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="26" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>