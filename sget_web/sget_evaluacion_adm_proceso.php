<? 
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
?>
<html>
<head>
<?
	if ($Opcion=='N')
	{
		$Titulo="Nuevo ";
		echo "<title>Nuevo Evaluacion Administrador de Contrato</title>";
	}	
	else	
	{
		echo "<title>Modifica Evaluacion Administrador de Contrato</title>";
		$Titulo="Modificaci�n ";
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupUsuario;
	var Valida=true;
	var Veri="";
	var Adm="";
	var Check="";
	var Valores="";
	var contador=0;
	var Largo="";
	var i="";
	switch(Opcion)
	{	
		case "N":
		case "M":
			//alert('Entro');
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				for (i=1;i<f.elements.length;i++)
				{
					
					if (f.elements[i].name=="CmbTipoEva" && f.elements[i].value!='S')
					{
						Valores = Valores + f.elements[i].value + "||";
						contador=contador+1;
					}	
				}
				//alert(Valores);
				if (Valores=="")
				{
					alert("Debe Seleccionar Evaluaci�n");
					return;
				}
				else
				{
					if (contador >= 1)
					{
						var Largo=Valores.length;
						Valores=Valores.substring(0,Largo-2);
						f.action = "sget_evaluacion_adm01.php?Opcion="+Opcion+"&Valores="+Valores;
						f.submit();
					}
				}	
			}
		break;
		case "R":	
			f.action = "sget_evaluacion_adm_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos()
{
	var f= document.FrmPopupUsuario;
	var Res=true;
	if (f.CmbNumEval.value=="S")
	{
		alert("Debe Selecionar Evaluacion");
		f.CmbNumEval.focus();
		Res=false;
		return;
	}
	return(Res);
}


</script>
<style type="text/css">
<!--
body {
	background-image: url(archivos/f1.gif);
}
-->
</style></head>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupUsuario" method="post" action="">
  <input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
  
  
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="1%" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_eva_adm_ctto_n.png"><? }else{?><img src="archivos/sub_tit_eva_adm_ctto_m.png"><?	}?></td>
       <td align="right"><a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td class="formulario2">&nbsp;</td>
         </tr>
         <tr>
           <td align="left" class="formulario2">Contrato:&nbsp;
               <?
		if ($Opcion=='N')
		{
			?>
               <SELECT name="CmbContrato" style="width:250" onChange="Proceso('R');">
                 <option value="S" SELECTed="SELECTed">Seleccionar</option>
                 <?
			$FechaActual=date("Y")."-".date("m")."-".date("d");
			$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."' order by fecha_termino desc";
			$RespCtto=mysqli_query($link, $Consulta);
			while($FilaCtto=mysql_fetch_array($RespCtto))
			{
				if ($FechaActual > $FilaCtto[fecha_termino])
					$Color="red";
				else
					$Color='white';
				if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
				{
					echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				}	
				else
					echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
			}
			?>
               </SELECT>
               <?
		}
		else
		{
			echo "<input type='hidden' name='CmbContrato' value=".$CmbContrato.">";
			echo $CmbContrato."&nbsp;&nbsp;";
			$ArrayCtto=explode('~',DescripCtto($CmbContrato));
			echo $ArrayCtto[1];
		}
		?>           </td>
         </tr>
         <tr>
           <td align="left" class="formulario2">Adm. Ctto : 
		   <? $Consulta="Select  t2.* from sget_contratos t1 left join sget_administrador_contratos t2 on t1.rut_adm_contrato=t2.rut_adm_contrato where t1.cod_contrato='".$CmbContrato."'";
		   		$RespCTTO=mysqli_query($link, $Consulta);
				if($FilaCTTO=mysql_fetch_array($RespCTTO))
				 echo  FormatearNombre($FilaCTTO["nombres"])." ".FormatearNombre($FilaCTTO[ape_paterno])." ".FormatearNombre($FilaCTTO[ape_materno]);
		   ?></td>
         </tr>
         <tr>
           <td width="1032"align="left" class="formulario2"><?
		if ($Opcion=='N')
		{
			if($CmbContrato!='S')
			{
				$Consulta="SELECT ifnull(max(nro_evaluacion)+1,1) as num_eva from sget_evaluacion_adm where cod_contrato='".$CmbContrato."' group by cod_contrato";
				//echo $Consulta."<br>";
				$RespEva=mysqli_query($link, $Consulta);
				if($FilaEva=mysql_fetch_array($RespEva))
					$CmbNumEval=$FilaEva[num_eva];
				else
					$CmbNumEval=1;
			}		
			echo "<input type='hidden' name='CmbNumEval' value=".$CmbNumEval.">";
			echo "Evaluaciones&nbsp;N&ordm;&nbsp;".$CmbNumEval;
		}
		else
		{
		?>
             Selecci&oacute;n Evaluaciones&nbsp;
             <SELECT name="CmbNumEval" onChange="Proceso('R')">
               <option value="S" class="NoSelec">Seleccionar</option>
               <?
			$Consulta="SELECT nro_evaluacion,fecha from sget_evaluacion_adm where cod_contrato='".$CmbContrato."' group by nro_evaluacion";
			//echo $Consulta."<br>";
			$RespEva=mysqli_query($link, $Consulta);
			while($FilaEva=mysql_fetch_array($RespEva))
			{
				if ($CmbNumEval==$FilaEva["nro_evaluacion"])
					echo "<option SELECTed value='".$FilaEva["nro_evaluacion"]."'>Evaluacion N&ordm;&nbsp;".$FilaEva["nro_evaluacion"]."&nbsp;Realizada el ".$FilaEva["fecha"]."</option>\n";
				else
					echo "<option value='".$FilaEva["nro_evaluacion"]."'>Evaluacion N&ordm;&nbsp;".$FilaEva["nro_evaluacion"]."&nbsp;Realizada el ".$FilaEva["fecha"]."</option>\n";
			}
				?>
             </SELECT>
             <?
		}
		?>           </td>
         </tr>
         <tr>
           <td align="left" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
         <tr>
           <td align="left" class="formulario2"><table width="100%" border="1" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
             <tr>
               <td width="8%" align="center"  class="TituloCabecera">Item</td>
               <td width="55%" align="center"  class="TituloCabecera">Descripci&oacute;n</td>
               <td width="37%" align="center"  class="TituloCabecera">Evaluaci&oacute;n<span class='InputRojo'>(*) </span></td>
             </tr>
             <?
		if($Opcion=='M'&&$Recarga=='S'&&$CmbNumEval!='S')
		{
			$Consulta="SELECT t2.fecha,t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva,t2.cod_nota from proyecto_modernizacion.sub_clase t1 ";
			$Consulta.="left join sget_evaluacion_adm t2 on t2.cod_evaluacion=t1.cod_subclase and t2.cod_contrato='".$CmbContrato."' and t2.nro_evaluacion='".$CmbNumEval."'";
			$Consulta.="where t1.cod_clase='30012' ";
			//echo $Consulta."<br>";
			$Cont=1;
			$RespEva=mysqli_query($link, $Consulta);
			while($FilaEva=mysql_fetch_array($RespEva))
			{
				echo "<tr>";
				echo "<td align='right'>".$Cont."</td>";
				echo "<td><input name='CodEva' type='hidden' value='".$FilaEva[cod_eva]."'>".$FilaEva[nom_eva]."</td>";
				echo "<td><SELECT name='CmbTipoEva'>";
				echo "<option value='S' SELECTed>Seleccionar</option>";
				$Consulta="SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30013'";
				$RespTipoEva=mysqli_query($link, $Consulta);
				while($FilaTipoEva=mysql_fetch_array($RespTipoEva))
				{
					if($FilaEva[cod_nota]==$FilaTipoEva["cod_subclase"])
						echo "<option value='".$FilaEva[cod_eva]."~~".$FilaTipoEva["cod_subclase"]."' SELECTed>".$FilaTipoEva["nombre_subclase"]."</option>";
					else
						echo "<option value='".$FilaEva[cod_eva]."~~".$FilaTipoEva["cod_subclase"]."'>".$FilaTipoEva["nombre_subclase"]."</option>";	
				}
				echo "</SELECT></td>";
				echo "</tr>";
				$Cont++;
			}
		}
		else
		{
			if ($Opcion=='N'&&$CmbContrato!='')
			{
				$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30012' ";
				//echo $Consulta."<br>";
				$Cont=1;
				$RespEva=mysqli_query($link, $Consulta);
				while($FilaEva=mysql_fetch_array($RespEva))
				{
					echo "<tr>";
					echo "<td align='right'>".$Cont."</td>";
					echo "<td>".$FilaEva[nom_eva]."</td>";
					echo "<td><SELECT name='CmbTipoEva'>";
					echo "<option value='S' SELECTed>Seleccionar</option>";
					$Consulta="SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30013'";
					$RespTipoEva=mysqli_query($link, $Consulta);
					while($FilaTipoEva=mysql_fetch_array($RespTipoEva))
					{
						echo "<option value='".$FilaEva[cod_eva]."~~".$FilaTipoEva["cod_subclase"]."'>".$FilaTipoEva["nombre_subclase"]."</option>";	
					}
					echo "</SELECT></td>";
					echo "</tr>";
					$Cont++;
				}
			}		
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
   <br></td>
   <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="1" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="1" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>		
<? 
CalculaReajuste();
?>
</body>
</html>
