<?php 	
	//session_start();
	//session_destroy('Valores');

	$CodigoDeSistema = 9;
	$CodigoDePantalla = 26;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Fecha_Hora = date("Y-m-d" );

	$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$CmbOpcion  = isset($_REQUEST["CmbOpcion"])?$_REQUEST["CmbOpcion"]:"";
	$CmbEK      = isset($_REQUEST["CmbEK"])?$_REQUEST["CmbEK"]:"";
	$Leyes      = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";
	


?>
<html>
<head>
<script language="Javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga(Tipo)
{
	var Frm=document.FrmLeyes;
	
	switch (Tipo)
	{
		case '1':
			if (Frm.Leyes=='-1')
			{
				alert('Debe Seleccionar Ley');
				Frm.Leyes.focus
				return;
			}
			Frm.action="pac_consulta_leyes.php?Buscar=S";		
			break;
		case '2':
			if (Frm.CmbEK=='-1')
			{
				alert('Debe Seleccionar Estanque');
				Frm.CmbEK.focus
				return;
			}
			Frm.action="pac_consulta_leyes.php?Buscar=S";		
			break;
	}
	Frm.submit();
}
function Excel()
{
	var Frm=document.FrmLeyes;
	
	if (Frm.CmbOpcion.value=='-1')
	{
		alert('Debe Seleccionar Opcion de Consulta');
		Frm.CmbOpcion.focus();
		return;
	}
	Frm.action="pac_consulta_leyes_excel.php?Buscar=S";		
	Frm.submit();
}
function Salir()
{
	var Frm=document.FrmLeyes;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();
}
</script>
<title>Consulta Leyes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmLeyes" method="post" action="" >
 <?php
	echo "<table width='740' border='0' class='tablainterior' align='center'>";
	echo "<tr>";
	echo "<td align='left'>Fecha</td><td align='left'>";
	echo "<select name='CmbMes' size='1' style='width:90px;' onchange='Recarga()'>";
	for($i=1;$i<13;$i++)
	{
		if ($Proceso=='M')
		{
			if ($i==$CmbMes)
			{
				echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
		}
		else
		{
			if (isset($CmbMes))
			{
				if ($i==$CmbMes)
				{
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			
			}	
			else
			{
				if ($i==date("n"))
				{
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}
		}		
	}
	echo "</select>";
	echo "<select name='CmbAno' size='1' style='width:70px;' onchange='Recarga()'>";
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if ($Proceso=='M')
		{
			if ($i==$CmbAno)
			{
				echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		else
		{
			if (isset($CmbAno))
			{
				if ($i==$CmbAno)
					{
						echo "<option selected value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}
			else
			{
				if ($i==date("Y"))
					{
						echo "<option selected value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}		
		}	
	}
	echo "</select></td><tr>";
	echo "<tr><td>Tipo Consulta</td><td>";
	echo "<select name='CmbOpcion' style='width:150' onchange='Recarga();'>";
	echo "<option value='-1' selected>Seleccionar</option>";
	switch ($CmbOpcion)
	{
		case "E":
			echo "<option value='E' selected>Estanques</option>";
			echo "<option value='L'>Leyes</option>";
			break;
		case "L":
			echo "<option value='E'>Estanques</option>";
			echo "<option value='L' selected>Leyes</option>";
			break;
		default:
			echo "<option value='E'>Estanques</option>";
			echo "<option value='L'>Leyes</option>";
			break;
	}
	echo "</select>";
	echo "</td>";
	echo "<tr>";
	echo "<td>";
	switch($CmbOpcion)
	{
		case "E":
			echo "Estanques</td>";
			echo "<td>";
			echo "<select name='CmbEK' style='width:100'>";
			echo "<option value='-1' selected>Seleccionar</option>";
			$Consulta=" select * from proyecto_modernizacion.sub_clase where cod_clase='9001' and cod_subclase <> '5'";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbEK==$Fila["cod_subclase"])
				{
					echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			}
			echo "</select>&nbsp;&nbsp;";
			echo "<input type='button' name='BtnOK' value='Ok' onclick=Recarga('2');>";
			echo "<td>";
			break;
		case "L":
			echo "Leyes</td>";
			echo "<td>";
			echo "<select name='Leyes' style='width:200px'>";
			$sql = "select * from proyecto_modernizacion.leyes order by cod_leyes";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Leyes == $row["cod_leyes"])
				{
					echo "<option selected value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
				}
				else
				{
					echo "<option value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
				}
			}
	        echo "</select>&nbsp;&nbsp;";
			echo "<input type='button' name='BtnOK' value='Ok' onclick=Recarga('1');>";
			echo "</td>";
			break;
	}
	echo "<tr>";
	echo "</tr>";
	echo "</table><br>";
    echo "<table width='740' border='1' cellpadding='0' cellspacing='0' class='tablainterior' align='center'>";
    echo "<tr class='ColorTabla01'>";
	echo "<td width='30' align='center'>EK</td>";
	echo "<td width='70' align='center'>Fecha</td>";
	echo "<td width='150' align='center'>Descripcion</td>";
	echo "<td width='35' align='center'>Valor</td>";
	echo "<td width='40' align='center'>Unidad</td>";
	echo "</tr>";
	if ($Buscar=='S')
	{
		$FechaInicio=$CmbAno."-".$CmbMes."-01";
		$FechaTermino=$CmbAno."-".$CmbMes."-31";
		$Consulta="select t1.correlativo,t4.nombre_subclase as estanque,t2.abreviatura as cod_ley,t1.fecha,t1.valor,t2.nombre_leyes,t2.abreviatura,t3.abreviatura from pac_web.leyes_por_estanques t1 ";
		$Consulta.="left join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes left join proyecto_modernizacion.unidades t3 ";
		$Consulta.="on t1.cod_unidad=t3.cod_unidad left join proyecto_modernizacion.sub_clase t4 on t1.cod_estanque=t4.cod_subclase and t4.cod_clase='9001' ";
		switch ($CmbOpcion)
		{
			case "E"://POR ESTANQUE
				$Consulta.= " where (t1.fecha between '".$FechaInicio."' and '".$FechaTermino."') and t1.cod_estanque='".$CmbEK."'";
				break;
			case "L"://POR LEYES
				$Consulta.= " where (t1.fecha between '".$FechaInicio."' and '".$FechaTermino."') and t1.cod_leyes='".$Leyes."'";
				break;
		}
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr>"; 
			echo "<td width='30' align='center'>".$Fila["estanque"]."</td>";
			echo "<td width='70' align='center'>".$Fila["fecha"]."</td>";
			echo "<td width='150'>&nbsp;".$Fila["nombre_leyes"]."&nbsp;(".$Fila["cod_ley"].")</td>";
			echo "<td width='35' align='right'>".$Fila["valor"]."</td>";
			echo "<td width='40'>".$Fila["abreviatura"]."</td>";
			echo "</tr>";
		}
	}	
	echo "</table><br>";
	?>
     <table width="740" border="0" class="tablainterior" align="center">
      <tr> 
        <td align="center">
		<?php
			 echo "<input type='button' name='BtnExcel' value='Excel' style='width:75' onClick='Excel();'>&nbsp;";
			 echo "<input type='button' name='BtnSalir' value='Salir' style='width:75' onClick='Salir();'>";
       ?>
	  </td>
	  </tr>
    </table>
</form>
</body>
</html>