<?
	include("conectar2.php");
?>
<html>
	<head>
		<title>Gu&iacute;a de Anexos</title>
<link href="js/style_new.css" rel=stylesheet>		
	<style type="text/css">
<!--
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
.Estilo2 {
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
}
.Estilo4 {font-family: Arial, Helvetica, sans-serif; color: #333333; }
.Estilo9 {font-size: 12px; color: #FFFFFF;}
.Estilo10 {
	color: #FFFFFF;
	font-size: 12pt;
}
-->
    </style>
	</head>

<script language="JavaScript">
	function buscar(TipoVal)
	{
			var f=document.frmprincipal;
		    switch(TipoVal)				
	        {           
	            case "a":
					f.action="anexos.php?Buscar=a";
					f.submit();
					break;
				case "I":
					window.print();
					break;
				case "L":
					f.nombre.value="";
					f.paterno.value="";
					f.materno.value="";
					f.cmbcargo.value="S";
					f.cmbUbicacion.value="S";
					f.paterno.focus();
					break;				
				case "W":
					f.action="anexos.php?vv=W";
					f.submit();
					break;
		     }
	}

function AbreVentana(datos)
{
	pag="datos_anexo.php?RutFun="+datos;
	window.open(pag,"","top=80,left=100,height=300,width=550,scrollbars=yes,ressizable=yes,menubars=no");
}
</script>
<body onLoad="document.frmprincipal.paterno.focus();">
<form name="frmprincipal" action="" method="post">
  <table width="450" border="0" align="center" cellPadding="1" cellSpacing="0" class="BordeTabla">
            <tr align="center">
              <td colspan="2"  class="cab_tabla">Anexos</td>
    </tr>
            <tr bgcolor="#FFFFFF">
              <td colspan="2" class="BordeBajo">Complete uno o varios campos</td>
    </tr>
            <tr>
                 <td width="99" class="texto_bold">Ap. Paterno</td>
                 <td width="334" class="BordeBajo">
                   <input name="paterno" type="text" class="InputIzq" value='<? echo $paterno; ?>' size=25 maxlength=20>              </td>
    </tr>
            <tr>
                 <td class="texto_bold">Ap. Materno           
    <td class="BordeBajo"><INPUT  name="materno" type="text" class="InputIzq" value='<? echo $materno; ?>' size=25 maxLength=20></tr>
            <tr>
			     <td class="texto_bold">Nombres</td>
			  <td class="BordeBajo"><input name="nombre" type="text" class="InputIzq" value='<? echo $nombre; ?>' size=25 maxlength=20></td> 
    </tr>
			<!--<tr>
                 <td height="22" class="texto_bold">Cargo
                 <td class="BordeBajo"><select name="cmbcargo" style="width:300px">
                <option value="S">Seleccionar</option>
                <?							
					/*$query="select CODIGO_CARGO,CARGO from cargo;";
					$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
					{
						if ($cmbcargo==$r["CODIGO_CARGO"] && $r["CODIGO_CARGO"]!="")
							echo '<option value="'.$r["CODIGO_CARGO"].'" selected> '.$r["CODIGO_CARGO"].'-'.ucwords(strtolower($r["CARGO"])).'</option>';
						else
							echo '<option value="'.$r["CODIGO_CARGO"].'"> '.$r["CODIGO_CARGO"].'-'.ucwords(strtolower($r["CARGO"])).'</option>';
					}*/
					
				 ?>
              </select></tr>-->
			<tr>
			  <td class="texto_bold">Centro Costo          
			  <td class="BordeBajo"><select name="cmbUbicacion" style="width:300px">
                <option value="S">Seleccionar</option>
		<?
				//se cargan todos los centros de costo
				$query="select cod_centro_costo,nombre_centro_costo from bd_rrhh.centros order by(cod_centro_costo);";
				$res_tmp=mysql_query($query);
				while($r=mysql_fetch_array($res_tmp))
				{
					if ($cmbUbicacion==$r["cod_centro_costo"])
						echo '<option value="'.$r["cod_centro_costo"].'" selected>'.$r["cod_centro_costo"].' - '.ucwords(strtolower($r["nombre_centro_costo"])).'</option>';
					else
						echo '<option value="'.$r["cod_centro_costo"].'">'.$r["cod_centro_costo"].' - '.ucwords(strtolower($r["nombre_centro_costo"])).'</option>';
				}
				if(mysql_num_rows($res_tmp))
					mysql_free_result($res_tmp);
				else
					echo '<option value="1">NO HAY CENTROS DE COSTO</option>';
			 ?>
              </select></tr>
			<tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="2" class="BordeBajo"><input type=button name="BuscarNombrePersonal" value="Buscar" onClick="buscar('a')" style="width:70px ">			   
	<input name="BtnLimpiar" type=button id="BtnLimpiar" onClick="buscar('L')" value="Limpiar" style="width:70px ">
    <input name="BtnImprimir" type=button id="BtnImprimir" onClick="buscar('I')" value="Imprimir" style="width:70px "></tr>
  </table><br>

<?
include("conectar2.php");
if ($Buscar=="a")
{
?>
	<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" class="BordeTabla">
	<tr>
	<td class="cab_tabla">Nombre</td>
	<td class="cab_tabla">Cargo</td>
	<td class="cab_tabla">Anexo</td>
	</tr>
<?	
	$sql="select distinct(t1.RUT),t1.NOMBRES,t1.APELLIDO_PATERNO,t1.APELLIDO_MATERNO ";
	$sql.=" ,t1.ANEXO,t1.COD_CARGO,t3.CODIGO_CARGO,t3.CARGO,t1.cod_centro_costo,t2.nombre_centro_costo ";
	$sql.=" from bd_rrhh.antecedentes_personales t1 ";
	$sql.=" left join bd_rrhh.centros t2 on t1.cod_centro_costo=t2.cod_centro_costo ";
	$sql.=" left join bd_rrhh.cargo t3 on t1.COD_CARGO=t3.CODIGO_CARGO ";
	if ($paterno!="" || $materno!="" || $nombre!="" || $cmbcargo!="S" || $cmbUbicacion!="S")
	{
		$sql.=" where t1.rut<>'' ";
		if ($paterno!="")
			$sql.=" and t1.APELLIDO_PATERNO like '%".$paterno."%' ";
		if ($materno!="")
			$sql.=" and t1.APELLIDO_MATERNO like '%".$materno."%' ";
		if ($nombre!="")
			$sql.=" and t1.NOMBRES like '%".$nombre."%' ";
		//if ($cmbcargo!="S")
			//$sql.=" and t1.COD_CARGO = '".$cmbcargo."' ";
		if ($cmbUbicacion!="S")
			$sql.=" and t1.COD_CENTRO_COSTO='".$cmbUbicacion."' ";
	}
	$sql.=" order by t1.apellido_paterno, t1.apellido_materno, t1.nombres, t1.rut";	
	//echo $sql;
	$Resp=mysql_query($sql);		
	$Cont=0;
	$Color = "#efefef";
	while($Fila=mysql_fetch_array($Resp))
	{
		if ($Color=="#efefef")
			$Color="#ffffff";
		else
			$Color="#efefef";
		$Nombre = ucwords(strtolower($Fila["APELLIDO_PATERNO"]))." ". ucwords(strtolower($Fila["APELLIDO_MATERNO"]))." ". ucwords(strtolower($Fila["NOMBRES"]));
		echo"<tr class=\"BordeBajo\">\n";		
		echo"<td class=\"BordeBajo\"><a href=\"JavaScript:AbreVentana('".$Fila["RUT"]."')\"><img src=\"images/vineta.gif\" border=\"0\">".$Nombre."</td>\n";
		echo"<td class=\"BordeBajo\">".$Fila["CARGO"]."</td>\n";	  
		if ($Fila["ANEXO"]!="0" && $Fila["ANEXO"]!="")
			echo"<td align=\"center\" class=\"BordeBajo\">".$Fila["ANEXO"]."</td>\n";	  
		else
			echo"<td align=\"center\" class=\"BordeBajo\">-</td>\n";	  
		echo"<tr>\n";
		$Cont++;
	}
	echo "<tr align=\"center\"  class=\"BordeBajo\">\n";
	echo "<td colspan=\"3\" class=\"BordeBajo\">Total ".number_format($Cont,0,",",".")."</td>\n";
	echo "</tr>\n";
}

?></table>
</span></form>
</body>
</html>