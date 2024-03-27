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
		echo "<title>Nuevo Bono Contratista</title>";
	}	
	else	
	{
		echo "<title>Modifica Bono Contratista</title>";
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
	var Datos="";
	var contador=0;
	var Largo="";
	var i="";
	switch(Opcion)
	{	
		case "N":
		case "M":
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="TxtRut"&&f.elements[i].value!="")
					{	
						Datos= Datos + f.elements[i].value + "~~" + f.elements[i + 1].value + "//";
					}	
				}
				Datos = Datos.substring(0,(Datos.length-2));
				f.Valores.value=Datos;
				//alert(f.Valores.value);
				f.action = "sget_bonos_contratistas01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "R":	
			f.action = "sget_bonos_contratistas_proceso.php?Recarga=S";
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
	if (f.CmbContrato.value=="S")
	{
		alert("Debe Selecionar Contrato");
		f.CmbContrato.focus();
		Res=false;
		return;
	}
	if (f.CmbNumBono.value=="S")
	{
		alert("Debe Selecionar N� Bono");
		f.CmbNumBono.focus();
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
 <input type="hidden" name="Valores" value="<? echo $Valores;?>">
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_bono_n.png"><? }else{?><img src="archivos/sub_tit_bono_m.png"><?	}?></td>
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
           <td colspan="2" class="formulario2">&nbsp;</td>
         </tr>
         <tr>
           <td width="70" align="right" class="formulario2">Contrato </td>
           <td width="995" align="left" class="formulariosimple"><?
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
		?>
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td align="right" class="formulario2">A&ntilde;o</td>
           <td align="left" class="formulariosimple"><?
		if ($Opcion=='N')
		{
		?>
               <SELECT name="CmbAno" id="CmbAno"  onchange="Proceso('R','<? echo $CmbAno; ?>')">
                 <?
		for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAno))
			{
				if ($i==$CmbAno)
				{
					echo "<option SELECTed value ='$i'>$i</option>";
				}
				else	
				{
					echo "<option value='".$i."'>".$i."</option>";
				}
			}
			else
			{
				if ($i==date("Y"))
				{
					echo "<option SELECTed value ='$i'>$i</option>";
				}
				else	
				{
					echo "<option value='".$i."'>".$i."</option>";
				}
			}
		}
		?>
               </SELECT>
               <?
	  }
	  else
	  {
			echo "<input type='hidden' name='CmbAno' value=".$CmbAno.">";
			echo $CmbAno."&nbsp;";
	  }
	  ?>           </td>
         </tr>
         <tr>
           <td align="right" class="formulario2">Bono N&ordm;</td>
           <td align="left" class="formulariosimple"><SELECT name="CmbNumBono" onChange="Proceso('R')">
               <option value="S" class="NoSelec">Seleccionar</option>
               <?
			$Consulta="SELECT t1.nombre_subclase as nom_eva,t1.cod_subclase as cod_eva from proyecto_modernizacion.sub_clase t1 where t1.cod_clase='30014' order by cod_subclase";
			//echo $Consulta."<br>";
			$RespBono=mysqli_query($link, $Consulta);
			while($FilaBono=mysql_fetch_array($RespBono))
			{
				if ($CmbNumBono==$FilaBono["cod_eva"])
					echo "<option SELECTed value='".$FilaBono["cod_eva"]."'>".$FilaBono["nom_eva"]."</option>\n";
				else
					echo "<option value='".$FilaBono["cod_eva"]."'>".$FilaBono["nom_eva"]."</option>\n";
			}
			?>
             </SELECT>
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td colspan="2" align="left" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
         <tr>
           <td colspan="2" align="left" class="formulario2"><table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
             <tr>
               <td width="20%" align="center"  class="TituloCabecera">Rut</td>
               <td width="25%" align="center"  class="TituloCabecera">Nombre</td>
               <td width="25%" align="center"  class="TituloCabecera">Apellido Paterno</td>
               <td width="25%" align="center"  class="TituloCabecera">Apellido Materno</td>
			   <td width="25%" align="center"  class="TituloCabecera">Monto($)</td>
             </tr>
             <?
			 if(isset($CmbNumBono)&&$CmbNumBono!='S')
			 {
				$Consulta="SELECT t2.rut,t2.nombres,t2.ape_paterno,t2.ape_materno,t1.monto FROM sget_personal t2  left join sget_bonos_contratistas t1 on t1.rut_persona=t2.rut and t1.num_bono='".$CmbNumBono."'  and t1.ano='".$CmbAno."'";
				$Consulta.="WHERE t2.cod_contrato ='".$CmbContrato."'  and t2.estado='A' and t2.tipo=1 ";
				$Resp=mysqli_query($link, $Consulta);echo "<input type='hidden' name='TxtMontoPers'><input type='hidden' name='TxtRut'>";
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr bgcolor='#FFFFFF'>";
					echo "<td align='center'>".$Fila["rut"]."</td>";
					echo "<td align='left'>".ucfirst(strtolower($Fila["nombres"]))."</td>";
					echo "<td align='left'>".ucfirst(strtolower($Fila[ape_paterno]))."</td>";
					echo "<td align='left'>".ucfirst(strtolower($Fila[ape_materno]))."</td>";
					echo "<td align='left'><input type='hidden' name='TxtRut' value='".$Fila["rut"]."'><input type='text' name='TxtMontoPers' value=".number_format($Fila[monto],0,'','.')." size='10' maxlength='8' onKeyDown='TeclaPulsada1()' onKeyUp=PoneMiles(this,this.value.charAt(this.value.length-1))></td>";
					echo "</tr>";
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
   </td>
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
CalculaReajuste();
?>
</body>
</html>
