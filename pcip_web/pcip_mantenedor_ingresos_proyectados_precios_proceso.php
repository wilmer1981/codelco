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
	    $Consulta = "select t1.dato,t2.nombre_subclase as nom_producto,t1.ano,t1.mes,cod_producto,t3.nombre_subclase as nom_unidad from pcip_inp_precios_dore t1 inner join";
		$Consulta.= " proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31032' and t1.cod_producto=t2.cod_subclase";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31013' and t2.valor_subclase1=t3.cod_subclase where dato='".$Cod[0]."' and t1.cod_producto='".$Cod[1]."' and t1.ano='".$Cod[2]."'";			
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
		    $CmbDatos=$Fila["dato"];
			$CmbProducto=$Fila["nom_producto"];
			$Unidad=$Fila["nom_unidad"];
			$Ano=$Fila["ano"];
		}
	}
}	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Precio Dor� Ingreso Proyectado</title>";
	else	
		echo "<title>Modifica Precio Precio Dor� Ingreso Proyectado</title>";
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
	var Valor="";
	
	switch(Opcion)
	{	
		case "N":
			f.Opcion.value=Opcion;			
			Veri=ValidaCampos();
			if (Veri==true)
			{
				Valor=RecuperarValor();
				//alert(Valor);
				f.action = "pcip_mantenedor_ingresos_proyectados_precios_proceso01.php?Opcion="+Opcion+"&Valor="+Valor;			    
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			Valor=RecuperarValor();
			//alert(Valor);
			f.action = "pcip_mantenedor_ingresos_proyectados_precios_proceso01.php?Opcion="+Opcion+"&Valor="+Valor;
			f.submit();
		break;
		case "NI":
			f.Opcion.value='N';
			f.action = "pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Opcion=N";
			f.submit();
		break;
		case "R":	
			f.action = "pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Recarga=S";
			f.submit();
		break;
	}
}
function RecuperarValor()
{
	var f=document.FrmPopupProceso;
	var Valores='';
	var LargoForm = document.FrmPopupProceso.elements.length
	for (i=0;i < LargoForm;i++)
	{
		Compara=(document.FrmPopupProceso.elements[i].name)
		Compara=Compara.substring(0,11);
		if (Compara=='TxtValorMes')
		{
		
			Valores = Valores +document.FrmPopupProceso.elements[i].name+"~"+document.FrmPopupProceso.elements[i].value+"//";
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function Salir()
{
	window.close();
}
function TeclaPulsada(tecla) 
{ 
	var Frm=document.FrmPopupProceso;
	var teclaCodigo = event.keyCode; 

		if(teclaCodigo != 189)
		{
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
} 
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;

	if(f.CmbProducto.value=='-1')
	{
		alert("Debe seleccionar Producto");
		f.CmbProducto.focus();
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
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_precio_ingreso_proyectado_n.png" width="450" height="40"><? }else{?><img src="archivos/sub_tit_precio_ingreso_proyectado_m.png" width="450" height="40"><? }?></td>
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
           <td width="180" class="formulario2">Seleccionar Proveniencia </td>
           <td class="FilaAbeja2">
			<select name="CmbDatos">
			<?
			 switch($CmbDatos)
			 {
			 	case "1":
				        echo"<option value='1' selected>PRECIOS</option>";
						echo"<option value='2' >GENER BARRO</option>";  
				break;
			 	case "2":
				        echo"<option value='1' >PRECIOS</option>";
						echo"<option value='2' selected>GENER BARRO</option>";  
				break;
			 	default:
				        echo"<option value='1' selected>PRECIOS</option>";
						echo"<option value='2' >GENER BARRO</option>";  
				break;
				
			 }
			?>
		    </select>		  
			</td>
		 </tr>
		 <tr>
           <td width="108" class="formulario2">Productos</td>
           <td width="1016" colspan="3" class="FilaAbeja2">
		   <?
		   if($Opcion=='N')
		   {
		   ?>
          <select name="CmbProducto" onChange="Proceso('R')">
            <option value="-1" class="NoSelec">Seleccionar</option>
            <?
			$Consulta = "select distinct(t1.cod_subclase),t1.nombre_subclase,t2.nombre_subclase as nom_unidad from proyecto_modernizacion.sub_clase t1";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.valor_subclase1=t2.cod_subclase";	
			$Consulta.= " where t1.cod_clase='31032' order by cod_subclase"; 	
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbProducto==$FilaTC["cod_subclase"])
				{
					echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					$Unidad=$FilaTC["nom_unidad"];
				}
				else
					echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
			?>
          </select><? //echo $Consulta;?>
		   <span class="InputRojo">(*)</span>
		   <?
		   }
		   else
		   		echo "<span class='formulario2'>".$CmbProducto."</span>";	
		   ?>		   
		   </td>
         </tr>
         <tr>
           <td height="25" class="formulario2">A&ntilde;o</td>
           <td colspan="3" class="FilaAbeja2">
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
		   ?>		   
		  </td>
         </tr>

         <tr>
           <td colspan="4" class='formulario2'><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr>
               <td colspan="24" align="center" class="TituloTablaNaranja">Valores a Ingresar [<? echo $Unidad;?>] </td>
             </tr>
             <tr align="center">
			   <td width="7%" class="TituloCabecera" colspan="2">Enero</td>
               <td width="7%" class="TituloCabecera" colspan="2">Febrero</td>
               <td width="7%" class="TituloCabecera" colspan="2">Marzo</td>
               <td width="7%" class="TituloCabecera" colspan="2">Abril</td>
               <td width="7%" class="TituloCabecera" colspan="2">Mayo</td>
               <td width="7%" class="TituloCabecera" colspan="2">Junio</td>
               <td width="7%" class="TituloCabecera" colspan="2">Julio</td>
               <td width="7%" class="TituloCabecera" colspan="2">Agosto</td>
               <td width="7%" class="TituloCabecera" colspan="2">Septiembre</td>
               <td width="7%" class="TituloCabecera" colspan="2">Octubre</td>
               <td width="7%" class="TituloCabecera" colspan="2">Noviembre</td>
               <td width="7%" class="TituloCabecera" colspan="2">Diciembre</td>
			 <tr align="center">
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
				<td width="7%" class="TituloCabecera">Real</td>
				<td width="7%" class="TituloCabecera">Ppto</td>
			 </tr>
             <?
				if($Opcion=='M')
				{
					 for($i=1;$i<=12;$i++)
					 {
					    $TxtValorMesR=0;$TxtValorMesP=0;
			    		$Cod=explode('~',$Codigos);
						$Consulta="select valor_real,valor_ppto from pcip_inp_precios_dore where dato='".$Cod[0]."' and  cod_producto='".$Cod[1]."' and  ano='".$Cod[2]."' and mes='".$i."'";	
						$RespMes=mysqli_query($link, $Consulta);
						//echo $Consulta."<br>";
						if($FilaMes=mysql_fetch_array($RespMes))
						{
						 $TxtValorMesR=$FilaMes[valor_real];
						 $TxtValorMesP=$FilaMes[valor_ppto];
						?>	
						<td align="right"><input type='text' name='TxtValorMes~<? echo $i."~R";?>' value='<? echo number_format($TxtValorMesR,2,',','.');?>' size='6' onkeydown='TeclaPulsada(false)' maxlength="7"></td>
						<td align="right"><input type='text' name='TxtValorMes~<? echo $i."~P";?>' value='<? echo number_format($TxtValorMesP,2,',','.');?>' size='6' onkeydown='TeclaPulsada(false)' maxlength="7"></td>
						<?
						}else{		
						?>
						<td><input type='text' name='TxtValorMes~<? echo $i."~R";?>' value='' size='6' onkeydown='TeclaPulsada(false)' maxlength="7"></td>
						<td><input type='text' name='TxtValorMes~<? echo $i."~P";?>' value='' size='6' onkeydown='TeclaPulsada(false)' maxlength="7"></td>
						<?
						}	
					 }
			   }
			   else
			   {
			   		echo "<tr>";
					for($i=1;$i<=12;$i++)
					{
						?>
						<td align='center'><input type='text' name='TxtValorMes~<? echo $i."~R";?>' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td>
						<td align='center'><input type='text' name='TxtValorMes~<? echo $i."~P";?>' value='' size='6' onkeydown='TeclaPulsada(true)' maxlength='7'></td><?
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
	if ($MensajeInserta==true)
		echo "alert('Precios Ingresados Correctamente');";
	if ($MensajeExiste==true)
		echo "alert('Este Registro Existe');";
	if ($MensajeActualizar==true)
		echo "alert('Precios Modificados Correctamente');";		
	echo "</script>";
?>
</body>
</html>
