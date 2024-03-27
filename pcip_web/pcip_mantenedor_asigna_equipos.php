
<? include("../principal/conectar_pcip_web.php");

?>
<html>
<head>
<title>Asigna Equipos a Sistemas</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../pcip_web/funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function Guardar()
{
	var f= document.FrmPopupProceso;
		if(f.CmbSistema.value=='-1')
		{
			alert("Debe seleccionar Sistema");
			f.CmbSistema.focus();
			return;
		}
		if(f.CmbEquipo.value=='-1')
		{
			alert("Debe seleccionar Equipo");
			f.CmbEquipo.focus();
			return;
		}
		f.action = "pcip_mantenedor_asigna_equipos_proceso01.php?Opc=G&Sistema="+f.CmbSistema.value+"&Equipo="+f.CmbEquipo.value;
		f.submit();
	
}
function Eliminar(Cod)
{
	var f= document.FrmPopupProceso;
		f.action = "pcip_mantenedor_asigna_equipos_proceso01.php?Opc=E&Cod="+Cod;
		f.submit();
	
}
function Recarga()
{
    f=document.FrmPopupProceso;
	f.action = "pcip_mantenedor_asigna_equipos.php";
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
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="733" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15%"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="../pcip_web/archivos/sub_tit_asigna_equipos.png"></td>
       <td align="right"><a href="JavaScript:Guardar()"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="14%" class="formulario2" align="justify">Sistema</td>
           <td width="86%" class="formulario2" ><select name="CmbSistema" onChange="Recarga()">
			  <option value="-1" selected="selected">Seleccionar</option>
			  <?
			  $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas order by nom_sistema ";			
				$Resp=mysqli_query($link, $Consulta);
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
				 $Consulta = "select t1.cod_equipo from pcip_eec_equipos_por_sistema t1  ";			
				 $Consulta.= " where t1.cod_sistema='".$CmbSistema."'";
					$Resp=mysqli_query($link, $Consulta);
						while ($FilaTC=mysql_fetch_array($Resp))
						{
							$In=$In."'".$FilaTC[cod_equipo]."',";
						
						}
				 
				 $In="(".substr($In,0,strlen($In)-1).")";
				 //echo "IN".$In; 
		 ?>		 
		 <tr>
           <td width="14%" class="formulario2" align="justify">Equipos</td>
           <td width="86%" class="formulario2" ><select name="CmbEquipo">
			<option value="-1" selected="selected">Seleccionar</option>
			    <?
				if($CmbSistema=='-1')
				{
					$Consulta = "select t2.cod_equipo,t2.nom_equipo from  pcip_eec_equipos t2 order by t2.nom_equipo";
				}
				else
				{
					$Consulta = "select t2.cod_equipo,t2.nom_equipo from  pcip_eec_equipos t2 ";
					if(strlen($In)>4)
					$Consulta.= " where  t2.cod_equipo not in $In ";
					$Consulta.= "order by t2.nom_equipo ";
				}
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEquipo==$FilaTC["cod_equipo"])
						echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
				}	
				?>
		  </select><? //echo $Consulta;?></td>
         </tr>
          <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
               <td width="8%" class="TituloTablaVerde">Elim.</td>
               <td width="8%" class="TituloTablaVerde">Codigo</td>
               <td width="78%" class="TituloTablaVerde">Equipos</td>
             </tr>
             <?
		
				$Consulta = "select t1.cod_equipo,t1.nom_equipo from pcip_eec_equipos_por_sistema t2 inner join pcip_eec_equipos t1 on t1.cod_equipo=t2.cod_equipo";
				$Consulta.= " where t2.cod_sistema='".$CmbSistema."' order by t1.cod_equipo";			
				$Resp = mysqli_query($link, $Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
				
					$Cod=$Fila["cod_equipo"];
					$Equipo=$Fila["nom_equipo"];
			 ?>
             <tr class="FilaAbeja">
               <td align="center"><a href="JavaScript:Eliminar('<? echo $Cod;?>')"><img src="../pcip_web/archivos/elim_hito.png"  border="0"  alt=" Eliminar " align="absmiddle"></a></td>
               <td align="center"><? echo $Cod; ?></td>
               <td ><? echo $Equipo; ?></td>
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
   <td width="26" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
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