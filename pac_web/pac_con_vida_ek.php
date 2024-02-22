<?php
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var Frm = document.FrmVidaEK;
	switch (opt)
	{
		case "W":
			Frm.action = "pac_con_vida_ek.php";
			Frm.submit();
			break;
		case "E":
			Frm.action = "pac_xls_vida_ek.php";
			Frm.submit();
			break;
		case "I":
			window.print();			
	}
}
function Salir()
{
	var Frm = document.FrmVidaEK;

	Frm.action = "../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();

}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmVidaEK" action="" method="post">
  <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td width="101"> Inicio Consulta:</td>
      <td width="155"><select name="MesIni">
	  <?php
	  	for ($i = 1; $i<= 12;$i++)
		{
			if (isset($MesIni))
			{
				if ($i == $MesIni)
					echo "<option selected value='".$i."'>".$meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".$meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
			}
		}
	  ?>
        </select> 
        <select name="AnoIni">
		<?php
	  	for ($i = (date("Y")-1); $i<= (date("Y")+1);$i++)
		{
			if (isset($AnoIni))
			{
				if ($i == $AnoIni)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select></td>
      <td width="130">Termino Consulta:</td>
      <td width="175"><select name="MesFin" id="MesFin">
          <?php
	  	for ($i = 1; $i<= 12;$i++)
		{
			if (isset($MesFin))
			{
				if ($i == $MesFin)
					echo "<option selected value='".$i."'>".$meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".$meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$meses[$i-1]."</option>\n";
			}
		}
	  ?>
        </select> 
        <select name="AnoFin" id="AnoFin">
          <?php
	  	for ($i = (date("Y")-1); $i<= (date("Y")+1);$i++)
		{
			if (isset($AnoFin))
			{
				if ($i == $AnoFin)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select></td>
      <td width="70">Estanque:</td>
      <td width="80"><select name="CmbEstanque">
	  <option value="-1">Todos</option>
	  <?php
	  	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '9001' and cod_subclase <> '5' ";
		$Consulta.= " order by cod_subclase";
		$Resultado = mysqli_query($link, $Consulta);
		while ($Row = mysqli_fetch_array($Resultado))
		{
			if ($CmbEstanque == $Row["cod_subclase"])
			{
				echo "<option selected value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>\n";
			}	
			else
			{
				echo "<option value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>\n";
			}	
		}
	  ?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td colspan="6"> <input name="BtnConsulta" type="button" value="Consultar" style="width:70px;" onClick="Proceso('W');"> 
        <input name="BtnExcel" type="button" value="Excel" style="width:70px;" onClick="Proceso('E');"> 
        <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I');"> 
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Salir();"> 
      </td>
    </tr>
  </table>
  <br>
  <table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>
    <tr class='ColorTabla01'> 
      <td width='55' align='center'>MES</td>
      <td width='63' align='center'>A&Ntilde;O</td>
      <td width='54' align='center'>EK</td>
      <td width='89' align='right'>Stock-Inicial</td>
      <td width='84' align='right'>Recepcion</td>
      <td width='99' align='right'>Envio</td>
      <td width='98' align='right'>Ajustes</td>
      <td width='122' align='right'>Stock-Actual</td>
    </tr>
    <?php			
		if ($CmbEstanque=='-1')
		{
			$Filtro='';
		}
		else
		{
			$Filtro=" and t1.cod_estanque='".$CmbEstanque."'";		
		}
		$Consulta = "select count(*) as TotalRegistro ";
		$Consulta.= " from pac_web.stock_estanques t1 left join proyecto_modernizacion.sub_clase t2 on ";
		$Consulta.= " t2.cod_clase = 9001 and t1.cod_estanque=t2.cod_subclase ";
		$Consulta.= " where (ano >= '".$AnoIni."' and ano <= '".$AnoFin."') ";
		$Consulta.= " and (mes >= '".$MesIni."' and mes <= '".$MesFin."')";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		if ($Fila["TotalRegistro"] > 0 )
		{
			$FechaDesde=$Ano."-".$Mes."-01 00:00:01";
			$FechaHasta=$Ano."-".$Mes."-31 23:59:59";
			$Consulta = "select * from pac_web.stock_estanques t1 left join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.= " on t2.cod_clase = 9001 and t1.cod_estanque=t2.cod_subclase ";
			$Consulta.= " where (ano >= '".$AnoIni."' and ano <= '".$AnoFin."') ";
			$Consulta.= " and (mes >= '".$MesIni."' and mes <= '".$MesFin."')";
			$Consulta.= " and t2.cod_subclase <> '5' ".$Filtro." order by t1.ano, t1.mes, t1.cod_estanque";

			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td align='center'>".$Fila["mes"]."</td>";
				echo "<td align='center'>".$Fila["ano"]."</td>";
				echo "<td align='center'>".$Fila["nombre_subclase"]."</td>";
				echo "<td align='right'>".$Fila["stock_inicial"]."</td>";
				echo "<td align='right'>".$Fila["recepcion"]."</td>";
				echo "<td align='right'>".$Fila["envio"]."</td>";
				echo "<td align='right'>".$Fila["signo"]." ".$Fila["ajuste"]."</td>";
				echo "<td align='right'>".$Fila["stock_actual"]."</td>";
				echo "</tr>";
			}	
		}
	?>
  </table>		
</form>		
</body>
</html>
