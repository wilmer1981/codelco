<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<title>Consulta de Empresas Excel</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<? 
	include("../principal/conectar_sget_web.php");
?>

  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	    <br>      
	    <table width="750" border="1" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" class="TablaDetalle">
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
		$Consulta.= " where t1.razon_social like '".$Letra."%' and t1.razon_social<>''";
	}
	else
	{ 
		if ($CmbEmpresa!="S")
			$Consulta.= " where t1.rut_empresa='".$CmbEmpresa."' and t1.razon_social<>''";
	}
	$Consulta.= " order by t1.razon_social asc";
	$Resp=mysqli_query($link, $Consulta); 
	$Color="#FFFFFF";
	//echo $Consulta;
	while ($Fila=mysql_fetch_array($Resp)) 
	{ 		
		if ($Color=="#FFFFFF")
			$Color = "#efefef";
		else
			$Color = "#FFFFFF";
		//$Rut=substr($Fila["rut_empresa"],0,3).".".substr($Fila["rut_empresa"],3,3).".".substr($Fila["rut_empresa"],6,3)."-".substr($Fila["rut_empresa"],9,1);
		$Rut=substr($Fila["rut_empresa"],0,2).".".substr($Fila["rut_empresa"],2,3).".".substr($Fila["rut_empresa"],5,3)."-".substr($Fila["rut_empresa"],9,1);	
		echo "<tr bgcolor=\"".$Color."\">\n";
		echo "<td>".$Rut."</td>\n";
		echo "<td>".$Fila["razon_social"]."</td>\n";
		$Consulta = "SELECT count(*) as cant from des_sget.sget_contratos t1  ";
		$Consulta.= " where t1.rut_empresa='".$Fila["rut_empresa"]."' ";
		$Consulta.= " order by cod_contrato";
		$Resp2=mysqli_query($link, $Consulta);
		$Fila2=mysql_fetch_array($Resp2);
		echo "<td>".$Fila2["cant"]."</td>\n";
		echo "<td>".$Fila["calle"]."</td>\n";
		echo "<td>".$Fila["telefono_comercial"]."</td>\n";		
		echo "</tr>\n";
	} 			
}	
?>       
  </table>      </td>
    </tr>
	  </table>
</form>
</body>
</html>
