<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
?>
<html>
<head>
<title>Mantenedor Facturas</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_mantenedor_facturas_compras_proceso.php?Opc=N&Cod";
			window.open(URL,"","top=30,left=30,width=950,height=600,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckDisp','M'))
			{
				Valores=Recuperar(f.name,'CheckDisp');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Modificar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_mantenedor_facturas_compras_proceso.php?Opc=M&Cod="+Valores;
					window.open(URL,"","top=30,left=30,width=950,height=600,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":	
			if(f.Ano.value<=f.AnoFin.value)
			{
				var mesdesde=parseInt(f.Mes.value);
				var meshasta=parseInt(f.MesFin.value);
				if(f.Ano.value==f.AnoFin.value&&mesdesde>meshasta)		
				{
					alert("Mes Desde No Puede Ser Mayor a Mes Hasta");
					return;	
				}
				f.action = "pcip_mantenedor_facturas_compras.php?Buscar=S";
				f.submit();
			}
			else
				alert("A�o Desde No Puede ser Mayor a A�o Hasta")	
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckDisp');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar los datos Seleccionados?"))
				{
					f.action = "pcip_mantenedor_facturas_compras_proceso01.php?Opcion=E&Cod="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_facturas_compras.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=10";
		break;
	}
}
function Adjuntos(Cod)
{
	URL="pcip_info_archivos_facturas.php?Cod="+Cod;
	opciones='left=90,top=30,toolbar=0,resizable=1,menubar=0,status=1,width=750,height=350,scrollbars=1';
	//verificar_popup(popup);
	popup=window.open(URL,"",opciones);
}

</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_facturas_compras.png')
?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	   <tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	   </tr>
      </table>
	 	  <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
		  <tr>
		  <td width="99" height="17" class='formulario2'>Factura</td>
		  <td class="formulario2" colspan="5"><input name="TxtFact"  maxlength= "10" type="text" id="TxtFact" style="width:100" value="<? echo $TxtFact; ?>" >
		  </tr> 
				<tr>
				  <td height="17" class='formulario2'>Rut Proveedor</td>
				  <td class='formulario2' colspan="5"><select name="CmbRut" onChange="Proceso('R')">
				   <option value="T" class="Selected">Todos</option>
				   <?					    
					$Consulta = "select distinct(t1.rut_proveedor),t2.nom_proveedor from pcip_fac_compra t1 inner join";
					$Consulta.= " pcip_fac_proveedores t2 on t1.rut_proveedor=t2.rut_proveedor";		
					$Resp=mysql_query($Consulta);
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbRut==$Fila["rut_proveedor"])
							echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$Fila["nom_proveedor"]."</option>\n";
						else
							echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$Fila["nom_proveedor"]."</option>\n";
					}
				   ?>
				  </select> <? //echo	$Consulta;	?>     
				</tr>
				    <tr>
					  <td height="17" class='formulario2'>Cuota</td>
					  <td width="111" class='formulario2'><select name="CmbCuota" onChange="Proceso('R')">
					   <option value="T" class="Selected">Todos</option>
					   <?					    
						$Consulta = "select distinct(cuota) from pcip_fac_compra";		
						$Resp=mysql_query($Consulta);
						while ($Fila=mysql_fetch_array($Resp))
						{
							if ($CmbCuota==$Fila["cuota"])
								echo "<option selected value='".$Fila["cuota"]."'>".substr($Fila["cuota"],0,4)." ". $Meses[intval(substr($Fila["cuota"],4)-1)]."</option>\n";
							else
								echo "<option value='".$Fila["cuota"]."'>".substr($Fila["cuota"],0,4)." ". $Meses[intval(substr($Fila["cuota"],4)-1)]."</option>\n";
						}
					   ?>
					  </select> <? //echo	$Consulta;	?>     
					</td>
					<td width="93" class="formulario2">Tipo Contrato</td>
					<td width="113" class="formulariosimple">
					   <select name="CmbTipoContrato" >
					   <option value="T" class="NoSelec">Todos</option>
						   <?
							$Consulta = "select distinct(cod_subclase),nombre_subclase from pcip_fac_compra t2 inner join";
							$Consulta.= " proyecto_modernizacion.sub_clase t1 where t1.cod_clase='31017' and t2.tipo=t1.cod_subclase";							
							$Resp=mysql_query($Consulta);
							while ($FilaTC=mysql_fetch_array($Resp))
							{
								if ($CmbTipoContrato==$FilaTC["cod_subclase"])
									echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
								else
									echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
							}
						   ?>
					   </select>
					  <td width="63" class="formulario2">Tipo</td>
							<td width="415" class="formulariosimple">
							<select name="CmbAbierCerra">
						    <option value="T" class="NoSelec">Todos</option>
							   <?
								switch($CmbAbierCerra)
								{
									case "1":
										echo "<option value='1' selected>Abierta</option>";
										echo "<option value='2'>Cerrada</option>";
									break;
									case "2":
										echo "<option value='1'>Abierta</option>";
										echo "<option value='2' selected>Cerrada</option>";
									break;
									default:
										echo "<option value='1'>Abierta</option>";
										echo "<option value='2'>Cerrada</option>";
									break;	
								}
								?>
							</select><? //echo $CmbDeCre;?>
					 </td>	
		            </tr>
					  <tr>
						<td height="17" class='formulario2'> Fecha Emisi&oacute;n</td>
						<td class='formulario2' colspan="5">Desde 
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
						<select name="Mes" id="Mes">
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
				        Hasta
						<select name="AnoFin">
						<?
						for ($i=2003;$i<=date("Y");$i++)
						{
							if ($i==$AnoFin)
								echo "<option selected value=\"".$i."\">".$i."</option>\n";
							else
								echo "<option value=\"".$i."\">".$i."</option>\n";
						}
						?>
					   </select>
						<select name="MesFin">
						<?
							for ($i=1;$i<=12;$i++)
							{
								if ($i==$MesFin)
									echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
								else
									echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
							}
						?>
						</select>  
				    </tr>
           </table>
        </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
 <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="6%" class="TituloTablaVerde" align="center"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckDisp','ChkTodos');"></td>
<td width="4%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="10%" class="TituloTablaVerde" align="center" >N� Factura</td>
<td width="10%" class="TituloTablaVerde" align="center" >NC / ND</td>
<td width="8%" class="TituloTablaVerde" align="center" >Contrato</td>
<td width="19%" class="TituloTablaVerde" align="center" >Rut. Proveedor</td>
<td width="10%" class="TituloTablaVerde" align="center">Cuota</td>
<td width="10%" class="TituloTablaVerde" align="center">Producto</td>
<td width="12%" class="TituloTablaVerde" align="center">Mercado</td>
<td width="13%" class="TituloTablaVerde" align="center">Fecha Emisi&oacute;n</td>
<td width="10%" class="TituloTablaVerde" align="center">Tipo</td>
<td width="13%" class="TituloTablaVerde" align="center">Observaci&oacute;n</td>
<!--<td width="8%" class="TituloTablaVerde" align="center" >Valor Neto</td>
<td width="4%" class="TituloTablaVerde" align="center" >Iva</td>
<td width="8%" class="TituloTablaVerde" align="center" >valor Total</td>-->
</tr>
	<?
	  if($Buscar=='S')
	  {
		$Consulta="select t1.codigo,t1.num_factura,t1.cod_contrato,t1.rut_proveedor,t5.nom_proveedor,t1.cuota,t1.fecha_emision,t3.nom_producto,t6.cod_subclase as cod_estado,t6.nombre_subclase as nom_estado,";
		$Consulta.=" t1.tipo,t1.observacion,t4.nombre_subclase as nom_mercado from pcip_fac_compra t1 inner join pcip_fac_productos_facturas t3 on t1.cod_producto=t3.cod_producto";
		$Consulta.=" left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31008' and t1.cod_mercado=t4.cod_subclase";
		$Consulta.=" left join pcip_fac_proveedores t5 on t5.rut_proveedor=t1.rut_proveedor ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='31018' and t1.estado_actual=t6.cod_subclase";
		$Consulta.=" where not isnull(t1.codigo)";		
		if(trim($TxtFact)!='')
			$Consulta.= " and num_factura='".trim($TxtFact)."' ";
		if($CmbRut!='T')
			$Consulta.= " and t1.rut_proveedor='".$CmbRut."' ";
		if($CmbCuota!='T')
			$Consulta.= " and cuota='".$CmbCuota."' ";
		if($CmbTipoContrato!='T')
			$Consulta.= " and tipo='".$CmbTipoContrato."' ";
		if($CmbAbierCerra!='T')
			$Consulta.= " and estado_actual='".$CmbAbierCerra."' ";
			
		$FechaInicio=$Ano."-".$Mes."-01";
		$FechaTermino=$AnoFin."-".$MesFin."-31";
		if(trim($TxtFact)=='')
			$Consulta.=" and fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";				
	    $Consulta.=" order by num_factura,t1.rut_proveedor,fecha_emision";
		$Resp=mysql_query($Consulta);
		echo "<input type='hidden' name='CheckDisp'>";
		//echo $Consulta;
		while($Fila=mysql_fetch_array($Resp))
		{	
			$Cod=$Fila["codigo"]; 
			$Correlativo=$Fila["correlativo"]; 
			$Fact=$Fila["num_factura"];			
			$Contr=$Fila["cod_contrato"];
			$Rut=$Fila["rut_proveedor"]." ".ucfirst(strtolower($Fila["nom_proveedor"]));
			$Cuota=$Fila["cuota"];
			$Prod=ucfirst(strtolower($Fila["nom_producto"]));
			$Mercado=$Fila["nom_mercado"];
			$Emision=$Fila["fecha_emision"];
			$CodNomfactura=$Fila["nom_estado"];
			$CodEstadofactura=$Fila["cod_estado"];
			$Obs=$Fila["observacion"];
			//$Neto=number_format($Fila["valor_neto"],'0',',','.');
			//$Iva=number_format($Fila["iva"],'0',',','.');
			//$Total=number_format($Fila["valor_total"],'0',',','.');
       
    ?>
		<tr class="FilaAbeja">
		<td align="center"><input type="checkbox" name='CheckDisp' class="SinBorde" value="<? echo $Cod; ?>"> </td>
			<? 
			  $Consulta1=" select adjunto from pcip_fac_compra_finos_relacion where adjunto!='' and codigo='".$Cod."'";
			  $Resp1=mysql_query($Consulta1);
			  if($Fila1=mysql_fetch_array($Resp1)) 
			  {
			?>
		<td align="center"><a href="JavaScript:Adjuntos('<? echo $Cod;?>')"><img src="../pcip_web/archivos/atachar.png"  border="0"  alt=" Archivos Adjuntos " align="absmiddle" height="20" width="20"></a></td>
			<?
			  }else
			  {
			?>
		<td align="center">&nbsp;</td>
			<?
			  }	
				$DatoNC='';$DatoND='';$NC_ND='';
				$DatoNC=RetornaNC_ND($Cod,'2');
				$DatoND=RetornaNC_ND($Cod,'1');	
				if($DatoNC<>'')
				   $NC_ND="NC:".$DatoNC." ";
				if($DatoND<>'')
				   $NC_ND=$NC_ND."ND:".$DatoND;
			?>
		<td align="right"><? echo $Fact;?></td>
		<td align="right"><? echo $NC_ND;?>&nbsp;</td>		
		<td align="right"><? echo $Contr;?></td>
		<td align="left"><? echo $Rut;?></td>
		<td align="left"><? echo substr($Cuota,0,4)." ". $Meses[intval(substr($Cuota,4)-1)];?></td>
		<td align="left"><? echo $Prod;?>&nbsp;</td>
		<td align="left"><? echo $Mercado;?>&nbsp;</td>		
		<td align="center"><? echo $Emision;?></td>	
		<?
		 if($CodEstadofactura=='2')
		    $Estadofactura="Cerrada";
		 else
		    $Estadofactura="Abierta";	
		?>
		<td align="left"><? echo $Estadofactura;?></td>	
		<td align="right"><textarea name="TexObs" cols="40" rows="2" readonly="readonly"><? echo $Obs;?></textarea></td>	
		</tr>
	<?
		}
	  }
    ?>
</table>
  </td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
  </table>
 </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Factura (s) Eliminada(s) Correctamente');";
	echo "</script>";
?>	
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el Dato, Existen Numero Debito/Credito Asociados ")
	</script>
<? 
   }
function RetornaNC_ND($Codigo,$Tipo)
{
  $Numero='';
  $ConsultaNC_ND="select numero from pcip_fac_compra_finos_relacion where codigo='".$Codigo."' and tipo_nota='".$Tipo."'";
  //echo $ConsultaNC_ND."<br>";
  $RespNC_ND=mysql_query($ConsultaNC_ND);  
  while($FilaNC_ND=mysql_fetch_array($RespNC_ND))
  {
    $Numero=$Numero.$FilaNC_ND[numero].", ";
  }
  if($Numero!='')
  	$Numero=substr($Numero,0,strlen($Numero)-2);
  return($Numero);	
}
?>
