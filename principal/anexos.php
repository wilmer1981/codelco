<?php
	include("conectar_principal.php");
	
?>
<html>
	<head>
		<title>Gu&iacute;a de Anexos</title>
<link href="estilos/style_new.css" rel=stylesheet>		
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
                   <input name="paterno" type="text" class="InputIzq" value='<?php echo $paterno; ?>' size=25 maxlength=20>              </td>
    </tr>
            <tr>
                 <td class="texto_bold">Ap. Materno           
    <td class="BordeBajo"><INPUT  name="materno" type="text" class="InputIzq" value='<?php echo $materno; ?>' size=25 maxLength=20></tr>
            <tr>
			     <td class="texto_bold">Nombres</td>
			  <td class="BordeBajo"><input name="nombre" type="text" class="InputIzq" value='<?php echo $nombre; ?>' size=25 maxlength=20></td> 
    </tr>
			<!--<tr>
                 <td height="22" class="texto_bold">Cargo
                 <td class="BordeBajo"><select name="cmbcargo" style="width:300px">
                <option value="S">Seleccionar</option>
                <?php							
					/*$query="select CODIGO_CARGO,CARGO from cargo;";
					$res_tmp=mysql_db_query("bd_rrhh",$query,$link);
					while($r=mysqli_fetch_array($res_tmp))
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
		<?php
				//se cargan todos los centros de costo
				$query="select CENTRO_COSTO,DESCRIPCION,centro_costo_enm from proyecto_modernizacion.centro_costo order by(CENTRO_COSTO);";
				$res_tmp=mysqli_query($link, $query);
				while($r=mysqli_fetch_array($res_tmp))
				{
					if ($cmbUbicacion==$r["centro_costo_enm"])
						echo '<option value="'.$r["centro_costo_enm"].'" selected>'.$r["CENTRO_COSTO"].' - '.ucwords(strtolower($r["DESCRIPCION"])).'</option>';
					else
						echo '<option value="'.$r["centro_costo_enm"].'">'.$r["CENTRO_COSTO"].' - '.ucwords(strtolower($r["DESCRIPCION"])).'</option>';
				}
				/*if(mysqli_num_rows($res_tmp))
					mysql_free_result($res_tmp);
				else
					echo '<option value="1">NO HAY CENTROS DE COSTO</option>';*/
			 ?>
              </select>
			  <?php  //echo $query;?>
			  </tr>
			<tr align="center" bgcolor="#FFFFFF">
    <td height="30" colspan="2" class="BordeBajo"><input type=button name="BuscarNombrePersonal" value="Buscar" onClick="buscar('a')" style="width:70px ">			   
	<input name="BtnLimpiar" type=button id="BtnLimpiar" onClick="buscar('L')" value="Limpiar" style="width:70px ">
    <input name="BtnImprimir" type=button id="BtnImprimir" onClick="buscar('I')" value="Imprimir" style="width:70px "></tr>
  </table><br>

<?php
//include("conectar2.php");
if ($Buscar=="a")
{
?>
	<table width="500" border="0" align="center" cellpadding="2" cellspacing="0" class="BordeTabla">
	<tr>
	<td class="cab_tabla">Nombre</td>
	<td class="cab_tabla">Cargo</td>
	<td class="cab_tabla">Anexo</td>
	</tr>
<?php	
	$sql="select distinct(t1.rut),t1.nombres,t1.apellido_paterno,t1.apellido_materno ";
	$sql.=" ,t1.anexo,t1.cod_cargo,t1.cod_centro_costo ";//,t2.DESCRIPCION t3.CARGO";
	$sql.=" from proyecto_modernizacion.funcionarios t1 ";
	//$sql.=" left join proyecto_modernizacion.centro_costo t2 on t1.cod_centro_costo=t2.centro_costo ";
	//$sql.=" left join proyecto_modernizacion.cargo t3 on t1.cod_cargo=t3.CODIGO_CARGO ";
	if ($paterno!="" || $materno!="" || $nombre!="" || $cmbcargo!="S" || $cmbUbicacion!="S")
	{
		$sql.=" where t1.rut<>'' ";
		if ($paterno!="")
			$sql.=" and t1.apellido_paterno like '%".$paterno."%' ";
		if ($materno!="")
			$sql.=" and t1.apellido_materno like '%".$materno."%' ";
		if ($nombre!="")
			$sql.=" and t1.nombres like '%".$nombre."%' ";
		//if ($cmbcargo!="S")
			//$sql.=" and t1.COD_CARGO = '".$cmbcargo."' ";
		if ($cmbUbicacion !="S")
		{
			$CmbCosto='02-'.substr($cmbUbicacion,0,2).".".substr($cmbUbicacion,2);
			$sql.= " and t1.cod_centro_costo = '".$CmbCosto."' ";
		}	
			//$sql.=" and t1.cod_centro_costo='".$cmbUbicacion."' ";
	}
	$sql.=" order by t1.apellido_paterno, t1.apellido_materno, t1.nombres, t1.rut";	
	//echo $sql;
	$Resp=mysqli_query($link, $sql);		
	$Cont=0;
	$Color = "#efefef";
	while($Fila=mysqli_fetch_array($Resp))
	{
		if ($Color=="#efefef")
			$Color="#ffffff";
		else
			$Color="#efefef";
		$Nombre = ucwords(strtolower($Fila["apellido_paterno"]))." ". ucwords(strtolower($Fila["apellido_materno"]))." ". ucwords(strtolower($Fila["nombres"]));
		echo"<tr class=\"BordeBajo\">\n";		
		echo"<td class=\"BordeBajo\"><a href=\"JavaScript:AbreVentana('".$Fila["rut"]."')\"><img src=\"imagenes/vineta.gif\" border=\"0\">".$Nombre."</td>\n";
		$Consulta="select * from proyecto_modernizacion.cargo where CODIGO_CARGO ='".$Fila[cod_cargo]."' ";
		$Res=mysqli_query($link, $Consulta);
		if($Fila1=mysqli_fetch_array($Res))
			$Cargo=$Fila1["CARGO"];
		else
			$Cargo="No Definido";
		echo"<td class=\"BordeBajo\">".$Cargo."</td>\n";	  
		if ($Fila["anexo"]!="0" && $Fila["anexo"]!="")
			echo"<td align=\"center\" class=\"BordeBajo\">".$Fila["anexo"]."</td>\n";	  
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