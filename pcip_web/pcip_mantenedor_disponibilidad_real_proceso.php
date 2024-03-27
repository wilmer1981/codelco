<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");
if(!isset($Ano))
 	$Ano=date('Y');

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		$Cod=explode('~',$Codigos);
		$Consulta="select t1.cod_sistema,t1.cod_equipo,t1.ano,t2.nom_sistema,t3.nom_equipo,t1.mes,t1.valor,t1.valor_real,t1.observacion from pcip_eec_disponibilidades t1 inner join pcip_eec_sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	    $Consulta.="inner join pcip_eec_equipos t3 on t1.cod_equipo=t3.cod_equipo where t1.tipo_disponibilidad='R' and t1.cod_sistema = '".$Cod[0]."' and t1.cod_equipo='".$Cod[1]."' and t1.ano='".$Cod[2]."' and mes='".$Cod[3]."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Sistema=$Fila["nom_sistema"];
			$Equipo=$Fila["nom_equipo"];
			$Ano=$Fila["ano"];
			$Mes=$Meses[$Fila[mes]-1];
			$TxtValorDisp=$Fila[valor];
			$TxtValorReal=$Fila[valor_real];
			$TxtObs=$Fila["observacion"];
		}
	}
	else
	{
		$TxtValorDisp='';
		$TxtValorReal='';
		$TxtObs='';
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Disponibilidad Real</title>";
	else	
		echo "<title>Modifica Disponibilidad Real</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Adm="";
	var Check="";
	var i="";
	var Valores="";
	
	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "pcip_mantenedor_disponibilidad_real_proceso01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			f.action = "pcip_mantenedor_disponibilidad_real_proceso01.php?Opcion="+Opcion;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_disponibilidad_real_proceso.php?Opcion=N";
			f.submit();
		break;
		case "R":	
			f.action = "pcip_mantenedor_disponibilidad_real_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
function TeclaPulsada1(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 


		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		
} 
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	if(f.CmbSistema.value=='-1')
	{
		alert("Debe seleccionar Sistema");
		f.CmbSistema.focus();
		Res=false;
		return;
	}
	if(f.CmbEquipos.value=='-1')
	{
		alert("Debe seleccionar Equipo");
		f.CmbEquipos.focus();
		Res=false;
		return;
	}
	if(f.TxtValorDisp.value=='')
	{
		alert("Debe Ingresar Valor Disponibilidad");
		f.TxtValorDisp.focus();
		Res=false;
		return;
	}
	if(f.TxtValorReal.value=='')
	{
		alert("Debe Ingresar Valor Real");
		f.TxtValorReal.focus();
		Res=false;
		return;
	}
	
	return(Res);

}
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
  <input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
 <input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="Codigos" type="hidden" value="<? echo $Codigos; ?>">

  <table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_disponibilidad_r_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_disponibilidad_r_m.png"><? }?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> 
	   <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
         <tr>
           <td width="180" class="formulario2">Sistema </td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbSistema" onChange="Proceso('R')">
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
	  $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas where vigente='S' and mostrar='S' order by nom_sistema ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSistema==$FilaTC["cod_sistema"])
				echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
		}
			?>
             </select>
           </span><span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$Sistema."</span>";	
		   ?>		   </td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Equipo</td>
           <td width="387" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
		   <select name="CmbEquipos">
             <option value="-1" class="NoSelec">Seleccionar</option>
             <?
	  	$Consulta = "select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' order by t2.nom_equipo ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEquipos==$FilaTC["cod_equipo"])
				echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
		}
			?>
           </select>
		   </span>		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$Equipo."</span>";	
		   ?>		   </td>
           <td width="462" colspan="2" class="FilaAbeja2" >&nbsp;</td>
         </tr>
         <tr>
           <td height="25" class="formulario2">A&ntilde;o</td>
           <td class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
             <select name="Ano" id="Ano">
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
           </span>
		   <?
		    }
		   	else
				echo "<span class='formulario2'>".$Ano."</span>";	
		   ?></td>
           <td class="FilaAbeja2">&nbsp;</td>
           <td class="FilaAbeja2">&nbsp;</td>
         </tr>
         <tr>
           <td class='formulario2'>Mes</td>
           <td class='formulario2'><span class="FilaAbeja2">
             <?
		   if($Opcion=='N')
		   {
		   ?>
             <select name="Mes" id="Mes">
               
s
             
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
		    }
		   	else
				echo "<span class='formulario2'>".$Mes."</span>";	
		   
		   
		   ?>
           </span></td>
           <td class='formulario2'>&nbsp;</td>
           <td class='formulario2'>&nbsp;</td>
         </tr>
        <tr>
           <td class='formulario2'>Horas Operaci&oacute;n Disponibles </td>
           <td class='formulario2'>
		   <input type='text' name='TxtValorDisp' value='<? echo $TxtValorDisp;?>' size='14' onkeydown='TeclaPulsada(true)' maxlength="15"></td>
           <td class='formulario2'>&nbsp;</td>
           <td class='formulario2'>&nbsp;</td>
         </tr>
        <tr>
           <td class='formulario2'> Horas Operaci&oacute;n Reales</td>
           <td class='formulario2'><input type='text' name='TxtValorReal' value='<? echo $TxtValorReal;?>' size='14' onkeydown='TeclaPulsada(true)' maxlength="15"></td>
           <td class='formulario2'>&nbsp;</td>
           <td class='formulario2'>&nbsp;</td>
         </tr>
        <tr>
           <td class='formulario2'>Observaci�n</td>
           <td colspan="2" class='formulario2'><textarea name="TxtObs" cols="80" rows="4"><? echo $TxtObs;?></textarea></td>
           <td class='formulario2'>&nbsp;</td>
         </tr>
		 
         <tr>
           <td height="14" colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>		
<? 
echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Disponibilidad Ingresada Correctamente');";
	if ($Mensaje=='2')
		echo "alert('Disponibilidad Existente');";
	if ($Mensaje=='3')
		echo "alert('Disponibilidad Modificada Correctamente');";
	echo "</script>";
?>
</body>
</html>
