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
		$Consulta="select t1.cod_sistema,t1.cod_equipo,t1.ano,t2.nom_sistema,t3.nom_equipo from pcip_eec_disponibilidades t1 inner join pcip_eec_sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	    $Consulta.="inner join pcip_eec_equipos t3 on t1.cod_equipo=t3.cod_equipo where t1.tipo_disponibilidad='P' and t1.cod_sistema = '".$Cod[0]."' and t1.cod_equipo='".$Cod[1]."' and t1.ano='".$Cod[2]."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Sistema=$Fila["nom_sistema"];
			$Equipo=$Fila["nom_equipo"];
			$Ano=$Fila["ano"];
		}
	}

}
	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Disponibilidad Programada</title>";
	else	
		echo "<title>Modifica Disponibilidad Programada</title>";
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
				for (i=0;i<f.TxtValorMes2.length;i++)
				{
					Valores=Valores+f.TxtValorMes2[i].value+"~~"+f.TxtValorMes3[i].value+"~~"+f.TxtValorMes4[i].value+"||";
				}
				Valores=Valores.substr(0,Valores.length-2);
				f.action = "pcip_mantenedor_disponibilidad_proyectada_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			for (i=0;i<f.TxtValorMes2.length;i++)
			{
				Valores=Valores+f.TxtValorMes2[i].value+"~~"+f.TxtValorMes3[i].value+"~~"+f.TxtValorMes4[i].value+"||";
			}
			Valores=Valores.substr(0,Valores.length-2);
			f.action = "pcip_mantenedor_disponibilidad_proyectada_proceso01.php?Opcion="+Opcion+"&Valores="+Valores;
			f.submit();
		break;
		case "R":	
			f.action = "pcip_mantenedor_disponibilidad_proyectada_proceso.php?Recarga=S";
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_disponibilidad_proyectada_proceso.php?Opcion=N";
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
<form name="FrmPopupProceso" method="post" action="" >
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_disponibilidad_p_n.png"><? }else{?><img src="archivos/sub_tit_disponibilidad_p_m.png"><? }?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
						echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
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
             <select name="CmbEquipos" onChange="Proceso('R')">
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
			    $Consulta = "select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' order by t2.nom_equipo ";			
				$Resp=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEquipos==$FilaTC["cod_equipo"])
						echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
					else
						echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
				}
				?>
             </select><? //echo $Consulta;?>
           </span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$Equipo."</span>";	
		   ?>		   </td>
           <td width="462" colspan="2" class="FilaAbeja2" >&nbsp;</td>
         </tr>
         <tr>
           <td height="25" class="formulario2">A&ntilde;o</td>
           <td colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
		   <span class="formulario2">
             <select name="Ano" id="Ano" onChange="Proceso('R')">
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
		   ?>		   </td>
         </tr>
         <tr>
           <td colspan="4" class='formulario2'>
		   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr>
               <td colspan="13" align="center" class="TituloTablaNaranja">Disponibilidad Programada</td>
             </tr>
             <tr align="center">
			   <td width="7%" class="TituloCabecera">Tipo Valor</td>
			   <td width="7%" class="TituloCabecera">Enero</td>
               <td width="7%" class="TituloCabecera">Febrero</td>
               <td width="7%" class="TituloCabecera">Marzo</td>
               <td width="7%" class="TituloCabecera">Abril</td>
               <td width="7%" class="TituloCabecera">Mayo</td>
               <td width="7%" class="TituloCabecera">Junio</td>
               <td width="7%" class="TituloCabecera">Julio</td>
               <td width="7%" class="TituloCabecera">Agosto</td>
               <td width="7%" class="TituloCabecera">Septiembre</td>
               <td width="7%" class="TituloCabecera">Octubre</td>
               <td width="7%" class="TituloCabecera">Noviembre</td>
               <td width="7%" class="TituloCabecera">Diciembre</td>
             </tr>
             <?
				if($Opcion=='M')
				{
					 ?>
					 <tr>
					 <?
					 echo "<td align='left'>Hrs.Oper.Diaria</td>";
					 for($i=1;$i<=12;$i++)
					 {
						$Consulta="select hrs_oper_d as valor from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$i."'";
						$RespMes=mysqli_query($link, $Consulta);
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						?>	
						<td align="right"><input type='text' name='TxtValorMes2' value='<? echo $FilaMes[valor];?>' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}else{		
						?>
						<td><input type='text' name='TxtValorMes2' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}	
					 }
					 ?>
					 </tr>
					 <tr>
					 <?
					 echo "<td align='left'>Hrs.Mant.Men</td>";
					 for($i=1;$i<=12;$i++)
					 {
						$Consulta="select hrs_mant_men as valor from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$i."'";
						$RespMes=mysqli_query($link, $Consulta);
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						?>	
						<td align="right"><input type='text' name='TxtValorMes3' value='<? echo $FilaMes[valor];?>' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}else{		
						?>
						<td><input type='text' name='TxtValorMes3' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}	
					 }
					 ?>
					 </tr>
					 <tr>
					 <?
					 echo "<td align='left'>Hrs.Mant.May</td>";
					 for($i=1;$i<=12;$i++)
					 {
						$Consulta="select hrs_mant_may as valor from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$i."'";
						$RespMes=mysqli_query($link, $Consulta);
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						?>	
						<td align="right"><input type='text' name='TxtValorMes4' value='<? echo $FilaMes[valor];?>' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}else{		
						?>
						<td><input type='text' name='TxtValorMes4' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength="7"></td>
						<?
						}	
					 }
					 ?>
					 </tr>

					 <?
			   }
			   else
			   {
			   		echo "<tr>";
					echo "<td align='left'>Hrs.Oper.Diaria</td>";
					$Consulta="select hrs_oper_d from pcip_eec_equipos where cod_equipo='".$CmbEquipos."'";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					$Fila=mysql_fetch_array($Resp);
					//if(!isset($TxtValorMes2))
						$TxtValorMes2=$Fila[hrs_oper_d];
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes2' value='".$TxtValorMes2."' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   		echo "</tr>";
			   		echo "<tr>";
					echo "<td align='left'>Hrs.Mant.Men</td>";
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes3' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   		echo "</tr>";
			   		echo "<tr>";
					echo "<td align='left'>Hrs.Mant.May</td>";
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes4' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>";
					}
			   		echo "</tr>";
			   }
			   ?>
           </table></td>
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
		echo "alert('Datos Ingresados Correctamente');";
	if ($Mensaje=='2')
		echo "alert('Datos Ingresados Ya Existen');";
	if ($Mensaje=='3')
		echo "alert('Datos Modificados Correctamente');";
echo "</script>";
	
?>
</body>
</html>
