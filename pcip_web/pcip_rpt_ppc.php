<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Consulta Control de Programa</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C":
			if(f.CmbVersion.value=='-1')
			{
				alert('Debe Seleccionar Versi�n');
				f.CmbVersion.focus();
				return;
			}
			if(f.CmbProd.value=='-1')
			{
				alert('Debe Seleccionar Producto');
				f.CmbProd.focus();
				return;
			}
			//alert(f.CmbVersion.value);
			f.action = "pcip_rpt_ppc.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_ppc_excel.php?CmbVersion='+f.CmbVersion.value+'&CmbProd='+f.CmbProd.value+'&CmbAsig='+f.CmbAsig.value+'&Ano='+f.Ano.value+'&CmbMostrar='+f.CmbMostrar.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;		
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
/*			if(f.CmbVersion.value=='-1')
			{
				alert('Debe Seleccionar Versi�n');
				f.CmbVersion.focus();
				return;
			}
*/			f.action = "pcip_rpt_ppc.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=9";
		break;
	}
}
</script>
<style type="text/css">
<!--
.Estilo11 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_rpt_ppc.png')
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
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"  border="0"  alt="Excel" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"></a><a href="JavaScript:Procesos('I')"><img src="archivos/impresora2.png"  alt="Imprimir " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td height="25" class='formulario2'>A&ntilde;o</td>
        <td class='formulario2' colspan="4"><select name="Ano" onChange="Procesos('R')">
          <?
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
			{
				if ($i==$Ano)
					echo "<option selected value=\"".$i."\">".$i."</option>\n";
				else
					echo "<option value=\"".$i."\">".$i."</option>\n";
			}
		?>
        </select>		</td>
		</tr>
      <tr>
        <td width="20%" height="17" class='formulario2'>Versi&oacute;n</td>
        <td colspan="4" class="formulario2" ><label></label>        <span class="FilaAbeja2">
          <select name="CmbVersion">
            <option value="-1" selected="selected">Seleccionar</option>
            <?
			$Consulta = "select * from pcip_ppc_version where ano='".$Ano."' order by ano desc,mes desc";			
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($Fila["ult_version"]=='S')
					$Color="#339900";
				else
					$Color="";
				if ($CmbVersion==$Fila["ano"]."-".$Fila["version"])
					echo "<option style='background:".$Color."' selected value='".$Fila["ano"]."-".$Fila["version"]."'>Version:".$Fila["version"]." A&ntilde;o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
				else
					echo "<option style='background:".$Color."' value='".$Fila["ano"]."-".$Fila["version"]."'>Version:".$Fila["version"]." A&ntilde;o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
			}
			?>
          </select>
        </span></tr>		
      <tr>
        <td height="25" class='formulario2'>Asignaci&oacute;n</td>
        <td colspan="4" class='formulario2'><select name="CmbProd" onChange="Procesos('R')">
          <option value="-1" selected="selected">Seleccionar</option>
          <?
	    $Consulta = "select * from pcip_svp_asignacion order by nom_asignacion ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{		    
			if ($CmbProd==$Fila["cod_asignacion"])
				echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
        </select> <? // echo $CmbProd;?>     </tr>
      <tr>
        <td height="25" class='formulario2'>Producto</td>
        <td colspan="4" class='formulario2'><select name="CmbAsig" onChange="Procesos('R')">
          <option value="-1" class="NoSelec">Todos</option>
          <?
	    $Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and mostrar_ppc='1'";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbAsig==$Fila["cod_producto"])
			{
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
				$Unidad=$Fila["cod_unidad"];			
			}
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
        </select>      </tr>
		<tr>
        <td width="20%" align="left" class='formulario2'>Mostrar        
        <td colspan="4" class='formulario2'><select name="CmbMostrar">
          <?
	  	switch($CmbMostrar)
		{
			case "A":
				echo "<option value='A' selected>Acumulado</option>";
				echo "<option value='D'>Detalle</option>";
			break;
			case "D":
				echo "<option value='A'>Acumulado</option>";
				echo "<option value='D' selected>Detalle</option>";
			break;
			default:
				echo "<option value='A' selected>Acumulado</option>";
				echo "<option value='D'>Detalle</option>";
			break;
		}
	  ?>
        </select>              </tr>
      <tr>
        <td height="25" class='formulario2'>Mes Desde</td>
        <td width="12%" class='formulario2'><select name="Mes" id="Mes">
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
        <td width="9%" align="right" class='formulario2'>Mes Hasta      
        <td width="8%" class='formulario2'><select name="MesFin">
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
        <td width="51%" class='formulario2'>      </tr>
    </table></td>
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
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
            <tr class="TituloTablaVerde">
              <td align="center"><span class="Estilo11">Asignaciones Reales de Producci&oacute;n</span></td>
			  <td align="center"><span class="Estilo11">Titulo</span></td>
			  <td align="center"><span class="Estilo11">Tipo</span></td>
			  <?
			  if($CmbMostrar=='D')
			  {
					for($i=$Mes;$i<=$MesFin;$i++)
					{				
						echo "<td align='center'><span class='Estilo11'>".$Meses[$i-1]."</span></td>";
					}			  
			  }
			  ?>
              <td align="center"><span class="Estilo11">TOTAL</span></td>
            </tr>
            <?
		  //$CmbMostrar='X';
			$ArrayTotReal=array(); 
			$ArrayTotProg=array(); 
			$ArraySubTotalGrupoReal=array(); 
			$ArraySubTotalGrupoPpto=array(); 
			for($i=$Mes;$i<=$MesFin;$i++)
			{	
			$ArraySubTotalGrupoReal[$i][0]=0; 
			$ArraySubTotalGrupoPpto[$i][0]=0; 
			$ArraySVP[$i][0]=0;
			}
       if($Buscar=='S')
	   {
		  $ExisteDato=false;
		  $Version=explode('-',$CmbVersion);
		  $CmbVersion=$Version[1];
		  if($CmbMostrar=='D')//DETALLE
		  {
			$Consulta="select t1.cod_producto,t1.nom_asignacion,t1.cod_asignacion,t2.version,t1.cod_unidad,t1.tipo from pcip_svp_asignaciones_productos t1 inner join pcip_ppc_detalle t2 on t1.cod_producto=t2.cod_procedencia ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' and t1.mostrar_ppc='1'";
			if($CmbAsig!='-1')
				$Consulta.=" and t1.cod_producto='".$CmbAsig."'";
			$Consulta.=" group by t1.cod_producto order by t1.orden";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$TotalProd=0;$ExisteDato=true;
				$CantFilas=ObtieneCantFilasTitulos($Fila[cod_asignacion],$Fila["cod_producto"],$Ano,$Mes,$MesFin,$Fila[version]);
				echo "<tr>";
				if($CmbProd=='5')
					echo "<td rowspan='".($CantFilas*3)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				else
				   	echo "<td rowspan='".($CantFilas*2)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				$ConsultaGrupo="select distinct t3.cod_subclase,t3.nombre_subclase from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
				$ConsultaGrupo.=" on t1.cod_asignacion=t2.cod_asignacion inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>'' and t2.mostrar_ppc='1'"; 
				if($CmbProd!='-1')
					$ConsultaGrupo.=" and t2.cod_asignacion='".$CmbProd."'";
				$ConsultaGrupo.=" order by t3.cod_subclase";	
				//echo $ConsultaGrupo."<br>";
				$RespGrupo=mysql_query($ConsultaGrupo);$Cont=0;
				while($FilaGrupo=mysql_fetch_array($RespGrupo))
				{
					$Consulta="select distinct t1.cod_titulo,t1.cod_negocio,t2.nom_titulo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio and t1.cod_titulo=t2.cod_titulo ";
					$Consulta.="where t1.cod_asignacion='".$Fila[cod_asignacion]."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Fila[version]."' and t2.mostrar_ppc='1'";
					$Consulta.="and t1.cod_procedencia='".$Fila["cod_producto"]."' and t2.vigente='1' and t2.grupo='".$FilaGrupo["cod_subclase"]."' order by t2.grupo";
					//echo $Consulta;
					$RespTit=mysqli_query($link, $Consulta);$Cont=0;
					while($FilaTit=mysql_fetch_array($RespTit))
					{
					    if($Fila[cod_asignacion]!='5')
						{
							if($Cont>1)
							echo "<tr>";
							echo "<td rowspan='2' >".$FilaTit[nom_titulo]."</td>";
							echo "<td>Asig.</td>";$TotalDatosReal=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$i,$MesFin,$Fila[version],&$ArrayTotReal,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";
								$Cont++;							
								$ArraySubTotalGrupoReal[$i][0]=$ArraySubTotalGrupoReal[$i][0]+$TotalTipoTit;
								$TotalDatosReal=$TotalDatosReal+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosReal,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								//OBTIENE DATOS PPC
								ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$i,$MesFin,$Fila[version],&$ArrayTotProg,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";								
								$Cont++;	
								$ArraySubTotalGrupoPpto[$i][0]=$ArraySubTotalGrupoPpto[$i][0]+$TotalTipoTit;	
								$TotalDatosPpto=$TotalDatosPpto+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosPpto,0,',','.')."</td>";						
							echo "</tr>";
						}
						else
						{
							if($Cont>1)
							echo "<tr>";
							echo "<td rowspan='3' >".$FilaTit[nom_titulo]."</td>";
							echo "<td>Asig.</td>";$TotalDatosReal=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotReal,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";
								$Cont++;							
								$ArraySubTotalGrupoReal[$i][0]=$ArraySubTotalGrupoReal[$i][0]+$TotalTipoTit;
								$TotalDatosReal=$TotalDatosReal+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosReal,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalTipoTit=0;
								//OBTIENE DATOS PPC
								ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$i,$i,$Fila[version],&$ArrayTotProg,&$TotalTipoTit);
								echo "<td align='right'>".number_format($TotalTipoTit,0,',','.')."</td>";								
								$Cont++;	
								$ArraySubTotalGrupoPpto[$i][0]=$ArraySubTotalGrupoPpto[$i][0]+$TotalTipoTit;	
								$TotalDatosPpto=$TotalDatosPpto+$TotalTipoTit;
							}
							echo "<td align='right'>".number_format($TotalDatosPpto,0,',','.')."</td>";						
							echo "</tr>";
							echo "<tr>";
							echo "<td>Ventas</td>";$TotalDatosPpto=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
							    $Valor=ValorVentas($CmbProd,$Ano,$i,'12');
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";																
								$Cont++;	
								$TotalValorSVP=$TotalValorSVP+$Valor;
								$ArraySVP[$i][0]=$ArraySVP[$i][0]+$Valor;
							}
							echo "<td align='right'>".number_format($TotalValorSVP,0,',','.')."</td>";						
							echo "</tr>";
						}	
					}
					if($Cont>0)
					{
					    if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
						{
							echo "<tr class='formulario2'>";
							echo "<td rowspan='3'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							$TotalGrupoAcum=0;		   
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalGrupo=$ArraySubTotalGrupoReal[$i][0];
								echo "<td align='right'>".number_format($TotalGrupo,0,',','.')."</td>";
								$ArraySubTotalGrupoReal[$i][0]=0;
								$TotalGrupoAcum=$TotalGrupoAcum+$TotalGrupo;
							}					
							echo "<td align='right'>".number_format($TotalGrupoAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Prog</td>";
							$TotalGrupoProgAcum=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$TotalGrupoProg=$ArraySubTotalGrupoPpto[$i][0];
								echo "<td align='right'>".number_format($TotalGrupoProg,0,',','.')."</td>";
								$TotalGrupoProgAcum=$TotalGrupoProgAcum+$TotalGrupoProg;
								$ArraySubTotalGrupoPpto[$i][0]=0;
							}	
							echo "<td align='right'>".number_format($TotalGrupoProgAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Ventas</td>";
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $ValorSubTotal=$ArraySVP[$i][0];
								echo "<td align='right'>".number_format($ValorSubTotal,0,',','.')."</td>";
								$TotalSVPSubTotalAcum=$TotalSVPSubTotalAcum+ValorSubTotal;
								$ArraySVP[$i][0]=0;
							}
							echo "<td align='right'>".number_format($TotalSVPSubTotalAcum,0,',','.')."</td>";
							echo "</tr>";
						}
						else
						{
							echo "<tr class='formulario2'>";
							echo "<td rowspan='2'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							$TotalGrupoAcum=0;		   
							for($i=$Mes;$i<=$MesFin;$i++)
							{	
								$TotalGrupo=$ArraySubTotalGrupoReal[$i][0];
								echo "<td align='right'>".number_format($TotalGrupo,0,',','.')."</td>";
								$ArraySubTotalGrupoReal[$i][0]=0;
								$TotalGrupoAcum=$TotalGrupoAcum+$TotalGrupo;
							}					
							echo "<td align='right'>".number_format($TotalGrupoAcum,0,',','.')."</td>";
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Prog</td>";
							$TotalGrupoProgAcum=0;
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$TotalGrupoProg=$ArraySubTotalGrupoPpto[$i][0];
								echo "<td align='right'>".number_format($TotalGrupoProg,0,',','.')."</td>";
								$TotalGrupoProgAcum=$TotalGrupoProgAcum+$TotalGrupoProg;
								$ArraySubTotalGrupoPpto[$i][0]=0;
							}	
							echo "<td align='right'>".number_format($TotalGrupoProgAcum,0,',','.')."</td>";
							echo "</tr>";
						}
					}		
				}	
				if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
				{
					echo "<tr class='formulario2'>";
					echo "<td rowspan='3' colspan='2'>SUBTOTAL</td>";
					echo "<td>Asig.</td>";
					$TotalRealAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{				    
						$TotalReal=0;
						reset($ArrayTotReal);
						while(list($c,$v)=each($ArrayTotReal))
						{
							if($c==$Fila["cod_producto"])
								$TotalReal=$TotalReal+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
						$TotalRealAcum=$TotalRealAcum+$TotalReal;
					}
					echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Prog</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$TotalProg=0;
						reset($ArrayTotProg);
						while(list($c,$v)=each($ArrayTotProg))
						{
							if($c==$Fila["cod_producto"])
								$TotalProg=$TotalProg+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
						$TotalProgAcum=$TotalProgAcum+$TotalProg;
					}
					echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Ventas</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$ValorSubtotal=$ValorSubtotal+$TotalSVPSubTotalAcum;
						echo "<td align='right'>".number_format($ValorSubtotal,0,',','.')."</td>";
						$TotalProgAcumTotal=$TotalProgAcumTotal+$ValorSubtotal;
					}
					echo "<td align='right'>".number_format($TotalProgAcumTotal,0,',','.')."</td>";
					echo "</tr>";
				}
				else
				{
					echo "<tr class='formulario2'>";
					echo "<td rowspan='2' colspan='2'>SUBTOTAL</td>";
					echo "<td>Asig.</td>";
					$TotalRealAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{				    
						$TotalReal=0;
						reset($ArrayTotReal);
						while(list($c,$v)=each($ArrayTotReal))
						{
							if($c==$Fila["cod_producto"])
								$TotalReal=$TotalReal+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
						$TotalRealAcum=$TotalRealAcum+$TotalReal;
					}
					echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
					echo "</tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Prog</td>";
					$TotalProgAcum=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$TotalProg=0;
						reset($ArrayTotProg);
						while(list($c,$v)=each($ArrayTotProg))
						{
							if($c==$Fila["cod_producto"])
								$TotalProg=$TotalProg+$v[$i];	
						}
						echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
						$TotalProgAcum=$TotalProgAcum+$TotalProg;
					}
					echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
					echo "</tr>";
				}	
			}
			if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
			{
				echo "<tr class='titulotablanaranja'>";
				echo "<td rowspan='3' colspan='2'>TOTALES</td>";
				echo "<td>Asig.</td>";
				$TotalRealAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalReal=0;
					reset($ArrayTotReal);
					while(list($c,$v)=each($ArrayTotReal))
					{
						$TotalReal=$TotalReal+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
					$TotalRealAcum=$TotalRealAcum+$TotalReal;
				}
				echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Prog</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalProg=0;
					reset($ArrayTotProg);
					while(list($c,$v)=each($ArrayTotProg))
					{
						$TotalProg=$TotalProg+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalProg;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Ventas</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalTotalSVP=$TotalTotalSVP+$TotalProgAcumTotal ;
					echo "<td align='right'>".number_format($TotalTotalSVP,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalTotalSVP;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
			}
			else
			{
				echo "<tr class='titulotablanaranja'>";
				echo "<td rowspan='2' colspan='2'>TOTALES</td>";
				echo "<td>Asig.</td>";
				$TotalRealAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalReal=0;
					reset($ArrayTotReal);
					while(list($c,$v)=each($ArrayTotReal))
					{
						$TotalReal=$TotalReal+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td>";
					$TotalRealAcum=$TotalRealAcum+$TotalReal;
				}
				echo "<td align='right'>".number_format($TotalRealAcum,0,',','.')."</td>";
				echo "</tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Prog</td>";
				$TotalProgAcum=0;
				for($i=$Mes;$i<=$MesFin;$i++)
				{
					$TotalProg=0;
					reset($ArrayTotProg);
					while(list($c,$v)=each($ArrayTotProg))
					{
						$TotalProg=$TotalProg+$v[$i];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td>";
					$TotalProgAcum=$TotalProgAcum+$TotalProg;
				}
				echo "<td align='right'>".number_format($TotalProgAcum,0,',','.')."</td>";
				echo "</tr>";
			}	
		  }
		  if($CmbMostrar=='A')//ACUMULADO
		  {
			$Consulta="select t1.cod_producto,t1.nom_asignacion,t1.cod_asignacion,t2.version,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_ppc_detalle t2 on t1.cod_producto=t2.cod_procedencia ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' and mostrar_ppc='1'";
			if($CmbAsig!='-1')
				$Consulta.=" and t1.cod_producto='".$CmbAsig."'";
			$Consulta.=" group by t1.cod_producto order by t1.orden";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$TotalProd=0;$ExisteDato=true;
				$CantFilas=ObtieneCantFilasTitulos($Fila[cod_asignacion],$Fila["cod_producto"],$Ano,$Mes,$MesFin,$Fila[version]);
				//echo $CantFilas."<br>";
				echo "<tr>";
				if($Fila[cod_asignacion]=='5')
					echo "<td rowspan='".($CantFilas*3)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				else
				   	echo "<td rowspan='".($CantFilas*2)."' >".$Fila[nom_asignacion]." [".$Fila[cod_unidad]."]</td>";
				$ConsultaGrupo="select distinct t3.cod_subclase,t3.nombre_subclase from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
				$ConsultaGrupo.=" on t1.cod_asignacion=t2.cod_asignacion inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>'' and t2.mostrar_ppc='1'"; 
				if($CmbProd!='-1')
					$ConsultaGrupo.=" and t2.cod_asignacion='".$CmbProd."'";
				$ConsultaGrupo.=" order by t3.cod_subclase";	
				//echo $ConsultaGrupo."<br>";
				$RespGrupo=mysql_query($ConsultaGrupo);$Cont=0;
				while($FilaGrupo=mysql_fetch_array($RespGrupo))
				{
					$Consulta="select distinct t1.cod_titulo,t1.cod_negocio,t2.nom_titulo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio and t1.cod_titulo=t2.cod_titulo and t2.vigente='1' and t2.grupo='".$FilaGrupo["cod_subclase"]."'";
					$Consulta.=" where t1.cod_asignacion='".$Fila[cod_asignacion]."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Fila[version]."' and t2.mostrar_ppc='1'";
					$Consulta.="and t1.cod_procedencia='".$Fila["cod_producto"]."'  order by t2.grupo";
					//echo $Consulta;
					$RespTit=mysqli_query($link, $Consulta);$Cont=0;
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$ValorReal=ObtieneDatosSVP($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_negocio],$FilaTit[cod_titulo],$Ano,$Mes,$MesFin,$Fila[version],&$ArrayTotReal,0);
						$ValorPPC=ObtieneDatosPPC($Fila[cod_asignacion],$Fila["cod_producto"],$FilaTit[cod_titulo],$Ano,$Mes,$MesFin,$Fila[version],&$ArrayTotProg,0);
												
						if($Fila[cod_asignacion]!='5')//CODIGO SUBPRODUCTO
						{
							if($Cont>1)		
								echo "<tr>";
							echo "<td rowspan='2'>".$FilaTit[nom_titulo]."&nbsp;</td>";
							echo "<td>Asig.</td>";						
							echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
							$TotalGrupo1=$TotalGrupo1+$ValorReal;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($ValorPPC,0,',','.')."</td>";
							$TotalGrupoProg2=$TotalGrupoProg2+$ValorPPC;
							echo "</tr>";
							$Cont++;
						}
						else
						{	
							if($Cont>1)
								echo "<tr>";
							echo "<td rowspan='3'>".$FilaTit[nom_titulo]."&nbsp;</td>";
							echo "<td>Asig.</td>";						
							echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
							$TotalGrupo1=$TotalGrupo1+$ValorReal;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Prog</td>";
							//OBTIENE DATOS PPC
							echo "<td align='right'>".number_format($ValorPPC,0,',','.')."</td>";
							$TotalGrupoProg2=$TotalGrupoProg2+$ValorPPC;
							echo "</tr>";
							echo "<tr>";
							echo "<td>Ventas</td>";
							//OBTIENE ventas SVP
							echo "<td align='right'>".number_format(ValorVentas($Fila["cod_producto"],$Ano,$Mes,$MesFin),0,',','.')."</td>";
							$TotalGrupoSVP=$TotalGrupoSVP+ValorVentas($Fila["cod_producto"],$Ano,$Mes,$MesFin);
							echo "</tr>";
							$Cont++;
						}
					}
					if($Cont>0)
					{
					    if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
						{
							echo "<tr class='formulario2'>";
							echo "<td rowspan='3'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							echo "<td align='right'>".number_format($TotalGrupo1,0,',','.')."</td>";
							$TotalGrupo1=0;
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($TotalGrupoProg2,0,',','.')."</td>";
							$TotalGrupoProg2=0;
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Ventas</td>";
							echo "<td align='right'>".number_format($TotalGrupoSVP,0,',','.')."</td>";
							$TotalSubtotalSVP=$TotalSubtotalSVP+$TotalGrupoSVP;
							$TotalGrupoSVP=0;
							echo "</tr>";
						}
						else
						{
							echo "<tr class='formulario2'>";
							echo "<td rowspan='2'>SUBTOTAL GRUPO</td>";
							echo "<td>Asig.</td>";
							echo "<td align='right'>".number_format($TotalGrupo1,0,',','.')."</td>";
							$TotalGrupo1=0;
							echo "</tr>";
							echo "<tr class='formulario2'>";	
							echo "<td>Prog</td>";
							echo "<td align='right'>".number_format($TotalGrupoProg2,0,',','.')."</td>";
							$TotalGrupoProg2=0;
							echo "</tr>";
						}	
					}
				}	
				if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
				{
					echo "<tr class='formulario2'>";
					echo "<td rowspan='3' colspan='2'>SUBTOTAL</td>";
					echo "<td>Asig.</td>";
					reset($ArrayTotReal);$TotalReal=0;
					while(list($c,$v)=each($ArrayTotReal))
					{
						if($c==$Fila["cod_producto"])
							$TotalReal=$TotalReal+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Prog</td>";
					reset($ArrayTotProg);$TotalProg=0;
					while(list($c,$v)=each($ArrayTotProg))
					{
						if($c==$Fila["cod_producto"])
							$TotalProg=$TotalProg+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Ventas</td>";
					echo "<td align='right'>".number_format($TotalSubtotalSVP,0,',','.')."</td></tr>";
				}
				else
				{
					echo "<tr class='formulario2'>";
					echo "<td rowspan='2' colspan='2'>SUBTOTAL</td>";
					echo "<td>Asig.</td>";
					reset($ArrayTotReal);$TotalReal=0;
					while(list($c,$v)=each($ArrayTotReal))
					{
						if($c==$Fila["cod_producto"])
							$TotalReal=$TotalReal+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
					echo "<tr class='formulario2'>";	
					echo "<td>Prog</td>";
					reset($ArrayTotProg);$TotalProg=0;
					while(list($c,$v)=each($ArrayTotProg))
					{
						if($c==$Fila["cod_producto"])
							$TotalProg=$TotalProg+$v[$Mes];	
					}
					echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
				}
			}
			if($Fila[cod_asignacion]=='5')//CODIGO SUBPRODUCTO
			{
				echo "<tr class='titulotablanaranja'>";
				echo "<td rowspan='3' colspan='2'>TOTALES</td>";
				echo "<td>Asig.</td>";
				reset($ArrayTotReal);$TotalReal=0;
				while(list($c,$v)=each($ArrayTotReal))
				{
					$TotalReal=$TotalReal+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Prog</td>";
				reset($ArrayTotProg);$TotalProg=0;
				while(list($c,$v)=each($ArrayTotProg))
				{
					$TotalProg=$TotalProg+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Venta</td>";
				echo "<td align='right'>".number_format($TotalSubtotalSVP,0,',','.')."</td></tr>";
			}
			else
			{
				echo "<tr class='titulotablanaranja'>";
				echo "<td rowspan='2' colspan='2'>TOTALES</td>";
				echo "<td>Real</td>";
				reset($ArrayTotReal);$TotalReal=0;
				while(list($c,$v)=each($ArrayTotReal))
				{
					$TotalReal=$TotalReal+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalReal,0,',','.')."</td></tr>";
				echo "<tr class='titulotablanaranja'>";	
				echo "<td>Prog</td>";
				reset($ArrayTotProg);$TotalProg=0;
				while(list($c,$v)=each($ArrayTotProg))
				{
					$TotalProg=$TotalProg+$v[$Mes];	
				}
				echo "<td align='right'>".number_format($TotalProg,0,',','.')."</td></tr>";
			}	
		  }	
		}  	  
		  ?>
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Asignaciones (s) Eliminado(s) Correctamente');";
	if($Mensaje!='1'&&$ExisteDato==false&&$Buscar=='S')
		echo "alert('Informaci�n de Asignacion No Encontrada');";	
	echo "</script>";
?>	
</body>
</html>
<?
function NumOrdenesPorNegocio($CodAsig,$CodNeg,$Ano,$Mes,$MesFin,$Prod,$CmbVersion)
{
	$Consulta="select ifnull(count(*),0) as cantidad from pcip_svp_asignaciones_titulos t1 inner join pcip_ppc_detalle t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_negocio=t2.cod_negocio  and t1.cod_titulo=t2.cod_titulo ";
	$Consulta.=" where t1.vigente='S' and t1.cod_asignacion='".$CodAsig."' and t1.cod_negocio='".$CodNeg."' and t1.mostrar_ppc='1' and (t2.ano='".$Ano."' and t2.mes between '".$Mes."' and '".$MesFin."') and t2.version='".$CmbVersion."' ";
	if($Prod!='-1')
		$Consulta.="and t2.cod_procedencia='".$Prod."'";
	$Consulta.=" group by t1.cod_asignacion, t1.cod_negocio,t1.cod_titulo";
	//echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);$Cantidad=0;
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Cantidad++;
	}
	return($Cantidad);	
}
function ObtieneDatosPPC($CodAsig,$CodProd,$CodTit,$Ano,$Mes,$MesFin,$Version,$ArrayTotProg,$TotalTipoTit)
{
	$Consulta="select sum(valor) as valor from pcip_ppc_detalle ";
	$Consulta.="where cod_asignacion='".$CodAsig."' and cod_procedencia='".$CodProd."' and cod_titulo='".$CodTit."' and (ano='".$Ano."' and mes between '".$Mes."' and '".$MesFin."') and version='".$Version."' ";
	//echo $Consulta."<br>";
	$Resp2=mysqli_query($link, $Consulta);$Cantidad=0;
	if($Fila2=mysql_fetch_array($Resp2))
	{
		$ArrayTotProg[$CodProd][$Mes]=$ArrayTotProg[$CodProd][$Mes]+$Fila2[valor];
		$TotalTipoTit=$TotalTipoTit+$Fila2[valor];

	return($Fila2[valor]);							
	}
	else
	{
		$Valor=0;
		return($Valor);		
	}
}
function ObtieneDatosSVP($CodAsig,$CodProd,$CodNeg,$CodTit,$Ano,$Mes,$MesFin,$Version,$ArrayTotReal,$TotalTipoTit)
{
		//OBTIENE DATOS SVP
		$Consulta="select t2.origen,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 ";
		$Consulta.="inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio ";
		$Consulta.="where t2.cod_asignacion='".$CodAsig."'  ";
		if($CodNeg!=99)
			$Consulta.=" and t2.cod_negocio='".$CodNeg."' and t2.cod_titulo='".$CodTit."' and t1.vigente='1'";
		$Consulta.=" and t2.cod_procedencia='".$CodProd."' and ano='".$Ano."' ";
		$Consulta.="order by t1.orden,t2.orden";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);$Cantidad=0;
		while($Fila2=mysql_fetch_array($Resp2))
		{
			if($Fila2[origen]=='SVP')
			{
				//echo "entroooo SVP";
				$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes between '".$Mes."' and '".$MesFin."' ";
				if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
					$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
				if(!is_null($Fila2[cod_material]))
					$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
				if(!is_null($Fila2[consumo_interno]))
					$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
				if(!is_null($Fila2[vptm])&&$Fila2[vptm]!=0)
					$Consulta.=" and vptm='".$Fila2[vptm]."'";
				$Resp3=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($Fila3=mysql_fetch_array($Resp3))
				{
					$Cantidad=$Cantidad+$Fila3[VPcantidad];
				}
			}
			else//CDV
			{
				//echo"entroo CDV";
				$Consulta="select sum(kilos_finos) as kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$Mes."' group by mes";
				$Resp3=mysqli_query($link, $Consulta);
				//echo "CDV:   ".$Consulta."<br>";
				while($Fila3=mysql_fetch_array($Resp3))
				{
					$Cantidad=$Cantidad+$Fila3[kilos_finos];
				}
				
			}
		}
		if($Cantidad!=0)
		{
			$ArrayTotReal[$CodProd][$Mes]=$ArrayTotReal[$CodProd][$Mes]+$Cantidad;
			$TotalTipoTit=$TotalTipoTit+$Cantidad;

		return($Cantidad);	
		}
		else
		{
			$Valor=0;
			return($Valor);	
		}		
}
function ObtieneCantFilasTitulos($CodAsig,$CodProd,$Ano,$Mes,$MesFin,$Version)
{
	$Consulta="select ifnull(count(*),0) as cant from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2 on t1.cod_asignacion=t2.cod_asignacion and t1.cod_titulo=t2.cod_titulo";
	$Consulta.=" where t1.cod_asignacion='".$CodAsig."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Version."'";
	$Consulta.=" and t1.cod_procedencia='".$CodProd."'";
	$Consulta.=" and t2.grupo<>'' and t2.mostrar_ppc='1' group by  t1.cod_asignacion,t1.cod_procedencia,t1.ano,t1.cod_titulo";
	//echo $Consulta."<br>";
	$RespCant=mysqli_query($link, $Consulta);$Cant=0;
	while($FilaCant=mysql_fetch_array($RespCant))
		$Cant++;
		
	$Consulta1="select  t2.grupo from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_titulos t2";
	$Consulta1.=" on t1.cod_asignacion=t2.cod_asignacion and t1.cod_titulo=t2.cod_titulo inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase=t2.grupo where cod_clase='31042' and t2.grupo<>''"; 
	$Consulta1.=" and t1.cod_asignacion='".$CodAsig."' and t1.ano='".$Ano."' and (t1.mes between '".$Mes."' and '".$MesFin."') and t1.version='".$Version."'";
	$Consulta1.=" and t1.cod_procedencia='".$CodProd."' and t2.mostrar_ppc='1'";
	$Consulta1.=" group by t1.cod_asignacion,t1.cod_procedencia,t1.ano,t2.grupo";	
	//echo $Consulta1."<br>";
	$RespCant1=mysql_query($Consulta1);
	while($FilaCant1=mysql_fetch_array($RespCant1))
		$Cant++;
	return($Cant);
}
function ValorVentas($Producto,$Ano,$Mes,$MesFin)
{
	$Valor=0;
	$Consulta = "select * from pcip_svp_asignaciones_productos where cod_producto<>''";
	if($Producto!='-1')
		$Consulta.= " and cod_producto='".$Producto."'";
	//echo $Consulta."<br>";			 
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
	  	$Codigo=$Fila["cod_producto"];	  
		$Consulta = "select * from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia where t1.cod_producto='".$Codigo."'";
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while($Fila=mysql_fetch_array($Resp))		  
		{	
		    $Orden=$Fila[num_orden];
			$Vptm=$Fila[vptm];
			for($i=$Mes;$i<=$MesFin;$i++)
			{
				$Consulta="SELECT sum(VPcantidad) as VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' AND VPmes = '".$i."' AND VPorden = '".$Orden."' "; 
				$Consulta.=" AND VPtm='".$Vptm."'";	
				$Resp2=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if($Fila2=mysql_fetch_array($Resp2))
				{
					$Valor=$Fila2[VPcantidad];
				}		
			}
		}  
	}
	return($Valor);
}
?>