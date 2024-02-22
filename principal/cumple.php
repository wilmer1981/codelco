<?php
	include("conectar_principal.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	if (!isset($CmbDias))
	{
		$CmbDias=date("j");
		$CmbMes=date("n");
	}
	
?>
<html>
	<head>
		<title>Cumpleaños</title>
<link href="estilos/style_new.css" rel=stylesheet>		
<style type="text/css">
<!--
.Estilo2 {
	font-size: 16px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 10px}
.Estilo5 {font-size: 12px}
.Estilo6 {color: #666666}
.Estilo8 {font-size: 12px; color: #FFFFFF; }
-->
</style>
</head>
<body>

<script language="JavaScript">
function Validar(TipoVal)
{
	var Y=document.frmprincipal;		
	if (TipoVal!="")
	{
		Y.action="cumple.php?Opcion="+TipoVal;
		Y.submit();
	}
}
	
function AbreVentana(datos)
{
	pag="datos_anexo.php?RutFun="+datos;
	window.open(pag,"","top=80,left=100,height=300,width=550,scrollbars=yes,ressizable=yes,menubars=no");
}
</script>
<form name="frmprincipal" action="" method="post">
  <font color="#0000FF" size="3">  </font>
  <p> 
  <table width="475" border="0" align="center" cellpadding="2" cellspacing="1" class="BordeTabla">
    <tr align="center">
      <td colspan="3" valign="center" class="cab_tabla" >CUMPLEA&Ntilde;OS</td>
    </tr>
    <tr align="center">
      <td colspan="3" valign="center" class="BordeBajo" >Fecha: 
        <?php
  	$hoy = date("d-m-Y");
	echo($hoy);
  ?>
      </td>
    </tr>
    <tr>
      <td width="114" class="texto_bold" >Ver Fecha:</td>
      <td width="251" class="BordeBajo" ><select name="CmbDias">
        <?php
				
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
						echo "<option selected value= '".$i."'>".$i."</option>";
					else
					  echo "<option value='".$i."'>".$i."</option>";
				}
				else
				{
					if ($i==date("j"))
						echo "<option selected value= '".$i."'>".$i."</option>";
					else
					  echo "<option value='".$i."'>".$i."</option>";
				}	
			  }
			?>
      </select>
De<select name="CmbMes">
  <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
				
				}	
				else
				{
					if ($i==date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
				}	
			}
		    ?>
</select></td>
      <td width="93" class="BordeBajo" ><input type="button" name="btnbuscar" value="Buscar" onClick="Validar('D')" style="width:70px "></td>
    </tr>
    <tr>
      <td class="texto_bold" >
        Ver&nbsp;&nbsp;
      Cumpleaños de... </td>
      <td colspan="2" class="BordeBajo"><input type="button" name="btnayer" value="Ayer" onClick="Validar('B')" style="width:70px ">
      <input type="button" name="btnHoy" value="Hoy" onClick="Validar('A')" style="width:70px ">
      <input type="button" name="btnmanana" value="Ma�ana" onClick="Validar('C')" style="width:70px "></td>
    </tr>
    <tr>
      <td class="texto_bold">Centro de Costo
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
      <td class="BordeBajo"><input type="button" name="btnbuscar2" value="Buscar" onClick="Validar('CC')" style="width:70px ">    </tr>
  </table>
  <br>
        <table>
<table width="500" border=\"0\" align="center" cellpadding="2" cellspacing="0" class="BordeTabla" aling=\"center\">
<tr align="center"><td width="189" class="cab_tabla" aling=\"center\"><strong>Nombre</td>
<td width="162" class="cab_tabla">Cargo</td>
<td width="41" class="cab_tabla">Anexo</td>
<?php
if ($Opcion=="CC"){
?>
<td width="90" class="cab_tabla">Fecha Cumpl.</td>
<?php } ?>
</tr>		
	<?php
	if ($Opcion!="")
	{
		$sql = " select t1.rut, t1.nombres,t1.apellido_paterno,t1.apellido_materno,t1.cod_cargo,t1.anexo,t1.fecha_nacimiento, t2.CARGO ";		
		$sql.= " from proyecto_modernizacion.funcionarios t1 left join proyecto_modernizacion.cargo t2 on t1.cod_cargo=t2.codigo_cargo ";
		switch ($Opcion)
		{
			case "A"://HOY				
				$sql.= " where t1.fecha_nacimiento like '%".date("m-d")."' ";		
				break;			
			case "B"://AYER
				$sql.= " where t1.fecha_nacimiento like '%".date("m-d",mktime(0,0,0,date("m"),date("d")-1))."' ";
				break;
			case "C":
				//MA�ANA
				$sql.= " where t1.fecha_nacimiento like '%".date("m-d", mktime(0,0,0,date("m"),date("d")+1))."' ";
				break;
			case "CC":
				//MA�ANA
				$CmbCosto='02-'.substr($cmbUbicacion,0,2).".".substr($cmbUbicacion,2);
				$sql.= " where t1.cod_centro_costo = '".$CmbCosto."' ";
				break;
			default:
				$sql.= " where t1.fecha_nacimiento like '%".str_pad($CmbMes,2,'0',STR_PAD_LEFT)."-".str_pad($CmbDias,2,'0',STR_PAD_LEFT)."' ";
				break;			
		}
		$sql.="order by t1.apellido_paterno, t1.apellido_materno, t1.nombres, t1.rut ";
		$Color="#efefef";
		//echo $sql;
		$buscando=mysqli_query($link, $sql);		
		while($row=mysqli_fetch_array($buscando))
		{
			if ($Color=="#efefef")
				$Color="#ffffff";
			else
				$Color="#efefef";
			$Nombre	= ucwords(strtolower($row["apellido_paterno"]))." ".ucwords(strtolower($row["apellido_materno"]))." ".ucwords(strtolower($row["nombres"]));
			echo"<tr class=\"BordeBajo\">\n";
			echo"<td class=\"BordeBajo\"><a href=\"JavaScript:AbreVentana('".$row["rut"]."')\">".$Nombre."</td>\n";
			echo"<td class=\"BordeBajo\">".ucwords(strtolower($row["CARGO"]))."</td>\n";
			if ($row["ANEXO"]!="0" && $row["anexo"]!="")	  
				echo"<td align=\"center\" class=\"BordeBajo\">".$row["anexo"]."</td>\n";	
			else
				echo"<td align=\"center\" class=\"BordeBajo\">-</td>\n";	
			if ($Opcion=="CC")
				echo"<td align=\"center\" class=\"BordeBajo\">".substr($row["fecha_nacimiento"],8,2)." / ".$Meses[intval(substr($row["fecha_nacimiento"],5,2))-1]."</td>\n";	
			echo"<tr>\n";
		}		 
		 echo "</table>\n";
	}
	?>
  </table>		
</form>
</body>
</html>