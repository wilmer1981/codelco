<?php 

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

	    ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename = "";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        	$filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);

        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 		header("Expires: 0");
  		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	//$link = mysql_connect("10.56.11.6","user_conect","perfil7");
	//mysql_select_db("bd_rrhh", $link);
	$Consulta = "SELECT t1.rut, t1.cod_cargo, t2.cargo FROM antecedentes_personales t1 ";
	$Consulta.= " INNER JOIN cargo t2 ON t1.cod_cargo=t2.codigo_cargo";
	$Resp=mysqli_query($link, $Consulta);
	$ArrCargos=array();
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrCargos[$Fila["rut"]][0] = $Fila["cod_cargo"];
		$ArrCargos[$Fila["rut"]][1] = $Fila["cargo"];
	}
	//mysqli_close($link);
	
?>
<html>
<head>
<title>Sistemas Informaticas Locales</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <br>
<?php
if ($Consultar == "S")
{
	$Consulta = "select t1.nivel,t1.descripcion as nom_nivel,t1.cod_sistema, t2.descripcion as nom_sistema from proyecto_modernizacion.niveles_por_sistema t1 inner join proyecto_modernizacion.sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	$Consulta.= " where nivel <> '1' ";
	if($Sistema!='S')
		$Consulta.= " and t1.cod_sistema = '".$Sistema."'";
	if ($Nivel != "T"&&$Nivel != "S")
		$Consulta.= " and t1.nivel = '".$Nivel."'";
	$Consulta.= " order by nom_sistema,nivel";
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
		$Consulta.= " FROM acceso_menu t1 ";
		$Consulta.= " INNER JOIN pantallas t2 ON t1.cod_sistema = t2.cod_sistema AND t1.cod_pantalla = t2.cod_pantalla";
		$Consulta.= " WHERE t1.cod_sistema = '".$Fila["cod_sistema"]."'";
		$Consulta.= " AND t1.nivel = '".$Fila["nivel"]."'";
		$Consulta.= " ORDER BY t1.cod_sistema, t1.nivel, t1.cod_pantalla";
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
		$Consulta.= " INNER JOIN funcionarios t2 ON t1.rut = t2.rut ";
		$Consulta.= " WHERE t1.cod_sistema = '".$Fila["cod_sistema"]."' ";
		$Consulta.= " AND t1.nivel = '".$Fila["nivel"]."' ";
		$Consulta.= " order by t1.cod_sistema, t1.rut ";
		$Respuesta2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<tr>\n";
			echo "<td>".$Fila2["rut"]." - ".ucwords(strtolower($Fila2["nombres"]))." ".ucwords(strtolower($Fila2["apellido_paterno"]))." ".ucwords(strtolower($Fila2["apellido_materno"]))."/ ".$Fila2["Bloqueo"]."</td>\n";			
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
