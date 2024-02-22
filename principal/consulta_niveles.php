<?php 
	//$link = mysql_connect("10.56.11.6","user_conect","perfil7");
	//mysql_select_db("bd_rrhh", $link);
	include("conectar_principal.php");

	if(isset($_GET["Consultar"])){
		$Consultar = $_GET["Consultar"];
	}else{
		$Consultar = "";
	}

	if(isset($_POST["Sistema"])){
		$Sistema = $_POST["Sistema"];
	}else{
		$Sistema = "";
	}
	if(isset($_POST["Nivel"])){
		$Nivel = $_POST["Nivel"];
	}else{
		$Nivel = "";
	}


	$Consulta = "SELECT t1.rut, t1.cod_cargo, t2.cargo FROM antecedentes_personales t1 ";
	$Consulta.= " INNER JOIN cargo t2 on t1.cod_cargo=t2.codigo_cargo";
	$Resp = mysqli_query($link, $Consulta);
	$ArrCargos = array();
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrCargos[$Fila["rut"]][0] = $Fila["cod_cargo"];
		$ArrCargos[$Fila["rut"]][1] = $Fila["cargo"];
	}
	//mysql_close($link);
	
	
?>
<html>
<head>
<title>Sistemas Informaticas Locales</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.location = "sistemas_usuario.php?CodSistema=99&Nivel=0";
			break;
		case "C":
			f.action = "consulta_niveles.php?Consultar=S";
			f.submit();
			break;
		case "E":
			f.action = "consulta_niveles_excel.php?Consultar=S";
			f.submit();
			break;
		case "R":
			f.action = "consulta_niveles.php";
			f.submit();
			break;
	}
}
</script>
</head>

<body background="imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="1" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="125">Seleccione Sistema:</td>
      <td><select name="Sistema" style="width:300px" onChange="Proceso('R');">
          <option value="S">Todos</option>
          <?php
	  	$Consulta = "SELECT * from proyecto_modernizacion.sistemas order by nombre";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Sistema == $Fila["cod_sistema"])
				echo "<option value='".$Fila["cod_sistema"]."' selected>".$Fila["nombre"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_sistema"]."'>".$Fila["nombre"]."</option>\n";
		}		
	  ?>
        </select></td>
    </tr>
    <tr> 
      <td>Nivel:</td>
      <td><select name="Nivel" style="width:300px">
          <?php
	  	if ((isset($Sistema)) && ($Sistema != "S"))
		{
			echo "<option value='T'>Todos</option>\n";
			$Consulta = "SELECT * from proyecto_modernizacion.niveles_por_sistema where nivel <> '1' ";
			$Consulta.= " and cod_sistema = '".$Sistema."' order by nivel";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				if ($Nivel == $Fila["nivel"])
					echo "<option value='".$Fila["nivel"]."' selected>".$Fila["descripcion"]."</option>\n";
				else
					echo "<option value='".$Fila["nivel"]."'>".$Fila["descripcion"]."</option>\n";
			}
			
		}
		else
		{
			echo "<option value='S'>Todos</option>\n";
		}
	  ?>
        </select></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><input name="btnConsulta" type="button" style="width:70px"  value="Consultar" onClick="Proceso('C');">
        <input name="btnExcel" type="button" style="width:70px"  value="Excel" onClick="Proceso('E');">
        <input name="btnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        <input name="btnSalir" type="button" value="Salir" onClick="Proceso('S');" style="width:70px"></td>
    </tr>
  </table>
  <br>
<?php
if ($Consultar == "S")
{
	$Consulta = "SELECT t1.nivel,t1.descripcion as nom_nivel,t1.cod_sistema, t2.descripcion as nom_sistema FROM proyecto_modernizacion.niveles_por_sistema t1 INNER JOIN proyecto_modernizacion.sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	$Consulta.= " WHERE nivel <> '1' ";
	if($Sistema!='S')
		$Consulta.= " AND t1.cod_sistema = '".$Sistema."'";
	if ($Nivel != "T" && $Nivel != "S")
		$Consulta.= " AND t1.nivel = '".$Nivel."'";
	    $Consulta.= " ORDER BY nom_sistema,nivel";
		//echo $Consulta;
	$NombreSistema='';
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<table width='750' border='1' align='center' cellpadding='1' cellspacing='1' class='TablaDetalle'>\n";
		if($NombreSistema!=$Fila["nom_sistema"])
		{
			echo "<tr>\n";
			echo "<td colspan='2'><strong>".$Fila["nom_sistema"]."</strong></td>\n";
			echo "</tr>\n";
			$NombreSistema=$Fila["nom_sistema"];
		}	
		echo "<tr>\n";
		echo "<td width='65'><strong>Nivel:</strong></td>\n";
		echo "<td width='672' colspan='2'>".$Fila["nivel"]." - ".$Fila["nom_nivel"]."</td>\n";
		echo "</tr>\n";
		echo "<tr> \n";
		echo "<td><strong>Pantallas:</strong></td>\n";
		echo "<td><table width='100%' border='0'>\n";
		$Consulta = "SELECT t1.cod_sistema, t1.nivel, t1.cod_pantalla, t2.descripcion";
		$Consulta.= " from acceso_menu t1 ";
		$Consulta.= " INNER JOIN pantallas t2 ON t1.cod_sistema = t2.cod_sistema";
		$Consulta.= " and t1.cod_pantalla = t2.cod_pantalla";
		$Consulta.= " where t1.cod_sistema = '".$Fila["cod_sistema"]."'";
		$Consulta.= " and t1.nivel = '".$Fila["nivel"]."'";
		$Consulta.= " order by t1.cod_sistema, t1.nivel, t1.cod_pantalla";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$i = 1;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<tr>\n";
			echo "<td>".$i." - ".ucwords(strtolower($Fila2["descripcion"]))."</td>\n";
			echo "</tr>\n";
			$i++;
		}
		echo "</table></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td height='16'><strong>Usuarios:</strong></td>\n";
		echo "<td><table width='100%' border='0'>\n";
		$Consulta = "SELECT t1.cod_sistema, t1.rut, t1.nivel, ";
		$Consulta.= " t2.nombres, t2.apellido_paterno, t2.apellido_materno, t2.Bloqueo ";
		$Consulta.= " FROM sistemas_por_usuario t1  ";
		$Consulta.= " INNER JOIN funcionarios t2 on t1.rut = t2.rut ";
		$Consulta.= " WHERE t1.cod_sistema = '".$Fila["cod_sistema"]."' ";
		$Consulta.= " AND t1.nivel = '".$Fila["nivel"]."' ";
		$Consulta.= " ORDER BY t1.cod_sistema, t1.rut ";
		$Respuesta2 = mysqli_query($link, $Consulta);

	
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<tr>\n";
			echo "<td>".$Fila2["rut"]." - ".ucwords(strtolower($Fila2["nombres"]))." ".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))."       /   ".$Fila2["Bloqueo"]."</td>\n";			
			if(!is_null($ArrCargos) && is_array($ArrCargos) && isset($ArrCargos[1])){
				echo "<td>".$ArrCargos[$Fila2["rut"]][1]."</td>\n";
			}
			echo "</tr>\n";
		}		
		echo "</table></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br>";
	}
}	
?>
</form>
</body>
</html>
