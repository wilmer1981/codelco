
<? include("../principal/conectar_sget_web.php");

if ($Opc=='M')
{
	$Consulta="SELECT * from sget_ipc t1 ";
	$Consulta.=" where t1.ano='".$Valores."' ";
	
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtA�o=$Fila["ano"];
	}
}
else
{
	$TxtA�o=$Valores;
	$Consulta = "SELECT distinct ano ";
	$Consulta.= " from sget_ipc ";
	$Consulta.= " order by ano desc";
	$Resp = mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$A�osOk=$A�osOk.$Fila["ano"].",";	
	}
	$A�osOk=substr($A�osOk,0,strlen($A�osOk)-1);
	//echo $A�osOk."<br>";
	/*$CmbAno='2005';
	if(strpos($A�osOk,$CmbAno)===false)
		echo "NO ENCONTRO";
	else
		echo "ENCONTRO";*/	
}
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nuevo IPC</title>";
		else	
			echo "<title>Modifica IPC</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":
			if(f.CmbAno.value=='S')
			{
				alert('Debe Seleccionar A�o');	
				return;
			}
			Valores=f.TxtValorMes[0].value+"~"+f.TxtValorMes[1].value+"~"+f.TxtValorMes[2].value+"~"+f.TxtValorMes[3].value+"~"+f.TxtValorMes[4].value+"~"+f.TxtValorMes[5].value+"~"+f.TxtValorMes[6].value;
			Valores=Valores+"~"+f.TxtValorMes[7].value+"~"+f.TxtValorMes[8].value+"~"+f.TxtValorMes[9].value+"~"+f.TxtValorMes[10].value+"~"+f.TxtValorMes[11].value;
			f.action = "sget_mantenedor_ipc01.php?Opcion="+ Opcion+"&Codigo="+f.CmbAno.value+"&Valores="+Valores;
			f.submit();
		break;
		case "M":
			Valores=f.TxtValorMes[0].value+"~"+f.TxtValorMes[1].value+"~"+f.TxtValorMes[2].value+"~"+f.TxtValorMes[3].value+"~"+f.TxtValorMes[4].value+"~"+f.TxtValorMes[5].value+"~"+f.TxtValorMes[6].value;
			Valores=Valores+"~"+f.TxtValorMes[7].value+"~"+f.TxtValorMes[8].value+"~"+f.TxtValorMes[9].value+"~"+f.TxtValorMes[10].value+"~"+f.TxtValorMes[11].value;
			f.action = "sget_mantenedor_ipc01.php?Opcion="+ Opcion+"&Codigo="+f.CmbAno.value+"&Valores="+Valores;
			f.submit();
		break;
	}
}
function Salir()
{
	window.close();
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(archivos/f1.gif);
}
-->
</style></head>
<?
if ($Opc=='N')
	echo '<body onLoad="document.FrmPopupProceso.CmbAno.focus();">';
	else
		echo '<body onLoad="document.FrmPopupProceso.CmbAno.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input name="TxtCodigo" type="hidden"     value="<? echo $TxtCodigo;?>" >
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="17" height="15"></td>
	<td width="816" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="archivos/sub_tit_ipc_n.png"><? }else{?><img src="archivos/sub_tit_ipc_m.png"><?	}?></td>
       <td align="right"><a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
           <td width="48" class="formulario2">&nbsp;</td>
           <td width="756" class="formulario2" >&nbsp;</td>
         </tr>
         <tr>
           <td align="right" class="formulario2">A&ntilde;o:</td>
           <td class="formulario2"><?
			if($Opc=='N')
			{
			?>
               <SELECT name="CmbAno" size="1" style="width:100px;">
                 <option value="S" SELECTed="SELECTed">Seleccionar</option>
                 <?
			$Val=explode(',',A�osOk);
			for ($i=date("Y")-6;$i<=date("Y");$i++)
			{
				$Encontro='N';
				reset($Val);
				while(list($c,$v)=each($Val))
				{
					if($v==$i)
					   $Encontro='S';
				}
				if($Encontro=='N')
				{
					if ($i==$CmbAno)
						echo "<option SELECTed value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}
			}
			?>
               </SELECT>
               <?
			}
			else
			{
				echo "<input type='text' name='CmbAno' value='".$TxtA�o."' readonly size=5>";
			}
			?></td>
         </tr>
         <tr>
           <td colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
               <tr>
                 <td colspan="12" align="center" class="TituloTablaNaranja">Meses</td>
               </tr>
               <tr align="center">
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
				if($Opc=='M')
				{
					$Consulta = "SELECT distinct ano ";
					$Consulta.= " from sget_ipc where ano='$TxtA�o'";
					$Consulta.= " order by ano desc";
					$Resp = mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						echo "<tr>";
						$Consulta="SELECT * from sget_ipc where ano = '".$Fila["ano"]."' order by mes";
						$RespMes=mysql_query($Consulta);
						while($FilaMes=mysql_fetch_array($RespMes))
						{	
							echo "<td align='center'><input type='text' name='TxtValorMes' value='".$FilaMes["valor"]."' size='6' onkeydown='TeclaPulsada(true)'></td>";
						}
						echo "</tr>";
					}
			   }
			   else
			   {
			   		echo "<tr>";
					for($i=1;$i<=12;$i++)
					{
						echo "<td align='center'><input type='text' name='TxtValorMes' value='' size='6' onkeydown='TeclaPulsada(true)'></td>";
					}
			   		echo "</tr>";
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

  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="17" height="15"><img src="archivos/images/interior/esq3.gif" width="17" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
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