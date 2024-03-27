<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($CmbTipoEva))
 	$CmbTipoEva=2;
if(!isset($Ano))
{
	$Ano=date('Y');
	$Mes=date('m');
}		

?>
<html>
<head>
<title>Evaluaci�n de Negocio</title>
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
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_evaluacion_negocio_proceso.php?Opc=N";
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
					URL="../pcip_web/pcip_evaluacion_negocio_proceso.php?Opc=M&Cod="+Valores;
					window.open(URL,"","top=30,left=30,width=950,height=600,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":	
			f.action = "pcip_evaluacion_negocio.php?Buscar=S";
			f.submit();
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
					f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion=E&Cod="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_evaluacion_negocio.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=16";
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
 EncabezadoPagina($IP_SERV,'evaluacion_negocio.png')
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
				  <td width="142" height="17" class='formulario2'>Material</td>
				  <td width="215" class='formulario2'><select name="CmbMaterial">
				   <option value="T" class="Selected">Todos</option>
					<?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31033' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbMaterial==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
				   ?>
			    </select>
				  <td width="70" class='formulario2'>Origen                  
				  <td width="246" class='formulario2'><select name="CmbOrigen">
                    <option value="T" class="Selected">Todos</option>
                    <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31035' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbOrigen==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                  </select>                  
				  <td width="225" class='formulario2'>                  				</tr>
					  <tr>
						<td height="17" class='formulario2'>A&ntilde;o</td>
						<td class='formulario2'><select name="Ano" id="Ano">
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
						<label></label>                        
						<td class='formulario2'>Mes                        
						<td class='formulario2'><select name="Mes" id="Mes">
                          <option value="T" selected="selected">Todos</option>
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
					  <td class='formulario2'>					  </tr>
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
<td width="5%" class="TituloTablaVerde" align="center"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckDisp','ChkTodos');"></td>
<td width="7%" class="TituloTablaVerde" align="center" >A&ntilde;o</td>
<td width="7%" class="TituloTablaVerde" align="center" >Mes</td>
<td width="20%" class="TituloTablaVerde" align="center" >Evaluaci&oacute;n</td>
<td width="20%" class="TituloTablaVerde" align="center">Material</td>
<td width="10%" class="TituloTablaVerde" align="center">Origen</td>
<td width="31%" class="TituloTablaVerde" align="center">An&aacute;lisis</td>
</tr>
	<?
	  if($Buscar=='S')
	  {
		$Consulta="select t1.corr,t1.ano,t1.mes,t1.nom_archivo,t1.analisis,t2.nombre_subclase as material,t3.nombre_subclase as origen from pcip_eva_negocios t1 ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31033' and t2.cod_subclase=t1.cod_material ";
		$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31035' and t3.cod_subclase=t1.tipo_origen ";
		$Consulta.=" where t1.ano='".$Ano."'";
		if($CmbMaterial!='T')
			$Consulta.=" and t1.cod_material='".$CmbMaterial."'";
		if($Mes!='T')
			$Consulta.=" and t1.mes='".$Mes."'";
		if($CmbOrigen!='T')
			$Consulta.=" and t1.tipo_origen='".$CmbOrigen."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);echo "<input name='CheckDisp' type='hidden'>";
		while($Fila=mysql_fetch_array($Resp))
		{	
			$Cod=$Fila["corr"]; 
			$A�o=$Fila["ano"];			
			$Mes=$Meses[$Fila["mes"]-1];
			$Nombre=$Fila["nom_archivo"];
			$Material=$Fila["material"];
			$Origen=$Fila["origen"];
			$Analisis='';
			$Datos=explode('||',$Fila["analisis"]);
			while(list($c,$v)=each($Datos))
			{
				$Datos2=explode('~',$v);
				if($Datos2[0]!='')
				{
					$TipoAnalisis=$Datos2[0];
					$Consulta = "select nombre_subclase as nom_analisis from proyecto_modernizacion.sub_clase where cod_clase='31034' and cod_subclase='".$TipoAnalisis."'";			
					//echo $Consulta."<br>";
					$RespTipo=mysqli_query($link, $Consulta);		
					$FilaTipo=mysql_fetch_array($RespTipo);
					if($TipoAnalisis==4)
					{
						$Div=$Datos2[1];
						$Consulta = "select nombre_subclase as nom_division from proyecto_modernizacion.sub_clase where cod_clase='31036' and cod_subclase='".$Div."'";			
						$RespDiv=mysqli_query($link, $Consulta);		
						$FilaDiv=mysql_fetch_array($RespDiv);
						//echo $Consulta."<br>";
						$Analisis=$Analisis.$FilaTipo[nom_analisis]."(".$FilaDiv[nom_division]."), ";	
						
					}
					else
						$Analisis=$Analisis.$FilaTipo[nom_analisis].", ";	
				}
			}
			$Analisis=substr($Analisis,0,strlen($Analisis)-2);
    ?>
		<tr class="FilaAbeja">
		<td align="center"><input type="checkbox" name='CheckDisp' class="SinBorde" value="<? echo $Cod; ?>"> </td>
		<td align="center"><? echo $A�o;?></td>
		<td align="left"><? echo $Mes;?></td>
		<td align="left"><? echo $Nombre;?></td>
		<td align="left"><? echo $Material;?></td>
		<td align="left"><? echo $Origen;?>&nbsp;</td>
		<td align="left"><? echo $Analisis;?>&nbsp;</td>
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
	if ($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";
?>	
</body>
</html>

