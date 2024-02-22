<?
	$CodigoDeSistema=30;
	$CodigoDePantalla=3;
	include("../principal/conectar_sget_web.php");
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action="sget_con_empresas.php?Mostrar=S";
			f.submit();
			break;		
		case "E":
			f.action="sget_con_empresas_excel.php?Mostrar=S&Letra=<? echo $Letra; ?>";
			f.submit();
			break;		
		case "R":
			f.action="sget_con_empresas.php?Mostrar=S";
			f.submit();
			break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
			break;
	}
}
function MuestraCapa(id, opcion)
{
	var f=document.frmPrincipal;
	switch (opcion)
	{
		case "M":
			eval("Div"+id+".style.visibility='visible'");
			break;
		case "C":
			eval("Div"+id+".style.visibility='hidden'");
			break;
	}
}
function Buscar(letra)
{
	var f=document.frmPrincipal;
	f.CmbEmpresa.value="S";
	window.location="sget_con_empresas.php?Mostrar=S&Letra="+letra;
}
function DetalleContrato(emp, cont)
{
	var f=document.frmPrincipal;
	var url="sget_con_empresas_detalle_contrato.php?IdEmpresa="+emp+"&IdContrato="+cont;
	window.open(url,"","top=20;left=20,width=550,height=400,resizable=yes,scrollbars=yes");
}
function BuscarEmp()
{
	var f = document.frmPrincipal;
	
	f.action='sget_con_empresas.php?BuscarEmp=S';
	f.submit();
}

</script>
<title>Consulta de Empresas</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" method="post" action="">
<? 
	include("encabezado.php");
	//include("../principal/conectar_ssgc.php");
?>

  <table width="970" align="center" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	  <table width="820" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2" class="Detalle01"><em>CONSULTA DE EMPRESAS CONTRATISTAS </em></td>
          </tr>
          <tr>
            <td width="94" class="Detalle02">&gt;&gt;Contratistas:</td>
            <td width="522" align="left">&nbsp;&nbsp;
                  <input name="TxtBuscaEmp" type="hidden" value="<? //echo $TxtBuscaEmp;?>" size="15" maxlength="10">
                  <span class="ColorTabla02">
                  <? //echo '<input name="BtnBuscar" type="button" value="Ok" onClick="BuscarEmp()">'; ?>
                  </span>              <SELECT name="CmbEmpresa" style="width:300" onChange=Proceso('R')>
                <option class="NoSelec" value="S">TODOS</option>
                <?
				//include("../principal/conectar_principal.php");
				$Consulta = "SELECT distinct t1.rut_empresa,t1.razon_social from des_sget.sget_contratistas t1 inner join des_sget.sget_contratos t2 on t1.rut_empresa =t2.rut_empresa  and t2.fecha_termino > '".date('Y-m-d')."'";
				$Consulta.= "where t1.razon_social<>'' and t1.rut_empresa<>'61704000-k'";
				if($TxtBuscaEmp!=''&&$BuscarEmp=='S')
					$Consulta.= "and  t1.razon_social like '%".$TxtBuscaEmp."%' ";
				$Consulta.= "order by t1.razon_social asc";
				$Resp=mysql_query($Consulta); 
				//echo $Consulta;
				while ($Fila=mysql_fetch_array($Resp)) 
				{ 
					if ($CmbEmpresa == $Fila["rut_empresa"])
						echo "<option SELECTed value='".$Fila["rut_empresa"]."'>".str_pad($Fila["rut_empresa"],10,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["razon_social"])."</option>";
					else
						echo "<option value='".$Fila["rut_empresa"]."'>".str_pad($Fila["rut_empresa"],10,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["razon_social"])."</option>";
				}
			  ?>
            </SELECT><? //echo $Consulta;?></td></tr>
          <tr align="center">
            <td colspan="2" class="Detalle01">
<?	
	for ($i=65;$i<=90;$i++)
	{
		echo "<a href=\"JavaScript:Buscar('".chr($i)."')\">".chr($i)."</a>";
		if ($i!=90)
			echo "-";
			
	}
?>			
			</td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
      <br>      <table width="820" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
		  <td width="86">Rut</td>
          <td width="258">Empresa</td>
          <td width="51">Contratos</td>
          <td width="270">Direccion</td>
		   <td width="105">Telefono</td>
        </tr>
        <?		
if ($Mostrar=="S")
{
	$Consulta = "SELECT distinct t1.rut_empresa,t1.razon_social,t1.calle,t1.telefono_comercial from des_sget.sget_contratistas t1 inner join des_sget.sget_contratos t2 on t1.rut_empresa =t2.rut_empresa  and t2.fecha_termino >= '".date('Y-m-d')."'";
	if (isset($Letra) && $Letra!="")
	{
		$Consulta.= " where t1.razon_social like '".$Letra."%' and t1.razon_social<>''  and t1.rut_empresa<>'61704000-k'";
	}
	else
	{ 
		if ($CmbEmpresa!="S")
			$Consulta.= " where t1.rut_empresa='".$CmbEmpresa."' and t1.razon_social<>''";
	}
	$Consulta.= " order by t1.razon_social asc";
	$Resp=mysql_query($Consulta); 
	$Color="#FFFFFF";
	//echo $Consulta;
	while ($Fila=mysql_fetch_array($Resp)) 
	{ 		
		if ($Color=="#FFFFFF")
			$Color = "#efefef";
		else
			$Color = "#FFFFFF";
		$Rut=substr($Fila["rut_empresa"],0,2).".".substr($Fila["rut_empresa"],2,3).".".substr($Fila["rut_empresa"],5,3)."-".substr($Fila["rut_empresa"],9,1);	
		//$Rut=substr($Fila["rut_empresa"],0,3).".".substr($Fila["rut_empresa"],3,3).".".substr($Fila["rut_empresa"],6,3)."-".substr($Fila["rut_empresa"],9,1);
		echo "<tr bgcolor=\"".$Color."\">\n";
		echo "<td>".$Rut."</td>\n";
		echo "<td>".$Fila["razon_social"]."</td>\n";
		//CONTRATOS
		echo "<td align=\"left\">";
		$NumContratos=0;
		$FechaHoy = date("Y")."-".str_pad(date("m"),2,'0',STR_PAD_LEFT)."-".str_pad(date("d"),2,'0',STR_PAD_LEFT);
		$Consulta = "SELECT * from des_sget.sget_contratos t1  ";
		$Consulta.= " where t1.rut_empresa='".$Fila["rut_empresa"]."' and fecha_termino > '".$FechaHoy."'";
		$Consulta.= " order by cod_contrato";
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);
		$Rut=substr($Fila["rut_empresa"],0,strlen($Fila["rut_empresa"])-2);
		echo "<div id=\"Div".$Rut."\" style=\"position:absolute;visibility:hidden;width:530;background:#FFCC33;border:solid 1px\">";
		echo "<br><table width=\"500\" bgcolor=\"#000000\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\">";
		echo "<tr bgcolor=\"#CCCCCC\">";
		echo "<td colspan=\"4\">Empresa ".$Fila["razon_social"]."</td>";
		echo "<td align=\"center\" ><a href=\"JavaScript:MuestraCapa('".$Rut."','C')\"><b>Cerrar</b></a></td>";
		echo "</tr>";
		echo "<tr bgcolor=\"#CCCCCC\" align=\"center\">";
		echo "<td width=\"80\">Contrato</td>";
		echo "<td width=\"240\">Descripcion</td>";
		echo "<td width=\"80\">Fecha Inicio</td>";
		echo "<td width=\"80\">Fecha Termino</td>";
		echo "<td width=\"20\">Est.</td>";
		echo "</tr>";
		
		while ($Fila2=mysql_fetch_array($Resp2)) 
		{					
			$NumContratos++; 			 
			echo "<tr bgcolor=\"#efefef\">";
			echo "<td><a href=\"JavaScript:DetalleContrato('".$Fila["rut_empresa"]."','".$Fila2["cod_contrato"]."')\">".$Fila2["cod_contrato"]."</a></td>";
			echo "<td>".$Fila2["descripcion"]."</td>";
			echo "<td align=\"center\">".substr($Fila2["fecha_inicio"],8,2)."/".substr($Fila2["fecha_inicio"],5,2)."/".substr($Fila2["fecha_inicio"],0,4)."</td>";
			echo "<td align=\"center\">".substr($Fila2["fecha_termino"],8,2)."/".substr($Fila2["fecha_termino"],5,2)."/".substr($Fila2["fecha_termino"],0,4)."</td>";
			$FechaActual = date("Y")."-".str_pad(date("m"),2,'0',STR_PAD_LEFT)."-".str_pad(date("d"),2,'0',STR_PAD_LEFT);
			//echo $FechaActual."<br>";
			//echo $Fila2["fecha_termino"]."<br>"; 
			if ($FechaActual > $Fila2["fecha_termino"])
				echo "<td align=\"center\" bgcolor=\"red\">C</td>";
			else
				echo "<td align=\"center\">A</td>";
			echo "</tr>";
		}
		echo "</table>"; 
		echo "<br></div>";
		echo "<a href=\"JavaScript:MuestraCapa('".$Rut."','M')\"><img src=\"../principal/imagenes/ico_pag.gif\" align=\"absmiddle\" border=\"0\"><span class=\"Links02\">&nbsp;".$NumContratos."</span></a></td>\n";
		echo "<td>".$Fila["calle"]."</td>\n";
		echo "<td>".$Fila["telefono_comercial"]."</td>\n";		
		echo "</tr>\n";
	} 			
}	
?>       
  </table>
      </td>
	  </tr>
	  </table>
      <? include("pie_pagina.php")?>
</form>
</body>
</html>
