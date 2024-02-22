<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 15;
?>

<html>
<head>
<title>Sistema Blister</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Ver_Stock(f)
{
	f.action = "sea_con_stock_hornadas3.php?Proceso=V";		
	f.submit();	
}

function Recarga_Subproducto()
{
	var f = document.formulario;
	f.action = "sea_con_stock_hornadas3.php?recargapag=S";		
	f.submit();	
}
/**************/
function Excel(f)
{
	vector = f.cmbproducto.value.split("-");
	if ((f.por_grupo.checked == true) && (vector[0] == '19') && (vector[1] != 8) && (vector[1] != 30) && ((f.RadioTipoFecha[1].checked == true) || (f.RadioTipoFecha[1].checked == false)) && (f.RadioTipoCons[0].checked == true))
		chequeado = "S";
	else chequeado = false;

	f.action = "sea_xls_stock_hornadas.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}
/**************/
function Imprimir()
{	
	window.print();
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="formulario" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="753" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="118">Fecha de Consulta</td>
            <td><SELECT name="Dia" style="width:50px">
                <?php 
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  ?>
              </SELECT> <SELECT name="Mes" style="width:100px">
                <?php
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == date("n"))
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
					?>
              </SELECT> <SELECT name="Ano" style="width:60px">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("Y"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}				
			?>
              </SELECT> </td>
            <td>Al Dia 
			<?php
				if($radio == 1)
					echo '<input type="radio" name="radio" value="1" checked>'; 
				else
					echo '<input type="radio" name="radio" value="1">'; 
			?>
			</td>
            <td>Al Mes
			<?php
				if($radio == 2)
					echo '<input type="radio" name="radio" value="2" checked>'; 
				else
					echo '<input type="radio" name="radio" value="2">';			
			?>
			</td>
          </tr>
          <tr> 
            <td>Producto</td>
            <td width="262"><SELECT name="cmbproducto" style="width:220px" onChange="Recarga_Subproducto()">
                <option value="0-0">SELECCIONAR</option>
                <?php					
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
				$rs = mysqli_query($link, $consulta);		
				while ($row = mysqli_fetch_array($rs))
				{				
					if ($row["cod_subclase"] == $cmbproducto)					
						echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
					else 
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}														   
				?>
              </SELECT> </td>
            <td width="106">&nbsp; </td>
            <td width="240">&nbsp;</td>
          </tr>
          <tr> 
            <td>Sub-Producto</td>
            <td>
			<SELECT name="cmbsubproducto">';
			<?php
				echo'<option value="-1" SELECTed>Seleccionar</option>';
	
				$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto = 16 and ap_subproducto = $cmbproducto"; 
				$rs7 = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs7))
				{
					if ($cmbsubproducto == $Fila["cod_subproducto"])
						echo "<option value = '".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					else
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}					
			?>
			</SELECT>
			</td>
            <td align="left">&nbsp; </td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td colspan="4"> <input name="BtnCansultar" type="button" value="Consultar" onClick="JavaScritp:Ver_Stock(this.form)" style="width:70px"> 
              <input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()"> 
              <input name="BtnExcel" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px"> 
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
		
        <table width="753" border="1" cellspacing="0" cellpadding="3">
          <tr class="ColorTabla01"> 
            <td colspan="2" align="center">Stock Inicial</td>
            <td colspan="2" align="center">Recepci�n</td>
            <td colspan="2" align="center">Traspaso a Raf</td>
            <td colspan="2" align="center">Otros Dest.</td>
            <td colspan="2" align="center">Stock Final</td>			
            <td colspan="2" align="center">Stock Piso</td>			
          </tr>
          <tr class="ColorTabla01"> 
            <td width="43" align="center">Unid.</td>
            <td width="53" align="center">Peso</td>
            <td width="44" align="center">Unid.</td>
            <td width="49" align="center">Peso</td>
            <td width="47" align="center">Unid.</td>
            <td width="55" align="center">Peso</td>
            <td width="55" align="center">Unid.</td>
            <td width="59" align="center">Peso</td>			
            <td width="51" align="center">Unid.</td>
            <td width="65" align="center">Peso</td>
            <td width="63" align="center">Unid.</td>
            <td width="71" align="center">Peso</td>
          </tr>
		  <tr>
			<?php   
				if($Proceso == "V")
				{
					$fecha = $Ano.'-'.$Mes.'-'.$Dia;
					$fecha_ini = $Ano.'-'.$Mes.'-01';
					$fecha_ter = $Ano.'-'.$Mes.'-31';

					$mes = $Mes - 1;
					$ano = $Ano;

					if(strlen($mes) == 1)
						$mes = "0".$mes;

					if($mes == 0)
					{
						$mes = 12;
						$ano = $ano - 1;
					}

					$hornada = $ano.$mes;

					$consulta = "SELECT SUM(unidades) AS unidades, SUM(peso_unidades) AS peso FROM sea_web.hornadas WHERE cod_producto = 16 AND cod_subproducto = ".$cmbsubproducto;
					$consulta = $consulta." AND left(hornada_ventana,6) = ".$hornada;			
					$rs = mysqli_query($link, $consulta);
		
					if ($row = mysqli_fetch_array($rs))
					{
						$unid_ini = $row["unidades"];
						$peso_ini = $row["peso"];
													
						//Busca los Traspasos (-). (tipo 4)
						$consulta = "SELECT IFNULL(SUM(unidades),0) AS unid_mov, IFNULL(SUM(peso),0) AS peso_mov FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 16 AND cod_subproducto = ".$cmbsubproducto;
					    $consulta = $consulta." AND left(hornada,6) = ".$hornada;
						echo $consulta;			
						$rs2 = mysqli_query($link, $consulta);
						$row2 = mysqli_fetch_array($rs2);
						$unid_ini = $unid_ini - $row2[unid_mov];
						$peso_ini = $peso_ini - $row2[peso_mov];
							
					}
					
					//Recepcion
					if($radio == 1)
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.movimientos WHERE fecha_movimiento = '$fecha' AND tipo_movimiento = 1 AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";
					else
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.movimientos WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND tipo_movimiento = 1 AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";						

					$rs = mysqli_query($link, $Consulta);
					if($row = mysqli_fetch_array($rs))
					{
						$unid_recep = $row[unid];
						$peso_recep = $row["peso"];
					}

					//Beneficio A Raf
					if($radio == 1)
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.movimientos WHERE fecha_movimiento = '$fecha' AND tipo_movimiento = 4 AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";
					else
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.movimientos WHERE fecha_movimiento BETWEEN '$fecha_ini' AND '$fecha_ter' AND tipo_movimiento = 4 AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";						

					$rs1 = mysqli_query($link, $Consulta);
					if($row = mysqli_fetch_array($rs1))
					{
						$unid_trasp = $row[unid];
						$peso_trasp = $row["peso"];
					}

					//Stock Final
					$unid_final = ($unid_ini + $unid_recep) - $unid_trasp; 
					$peso_final = ($peso_ini + $peso_recep) - $peso_trasp; 

					//Blister En Piso Raf
					if($radio == 1)
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.stock_piso_raf WHERE fecha = '$fecha' AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";
					else
						$Consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM sea_web.stock_piso_raf WHERE fecha BETWEEN '$fecha_ini' AND '$fecha_ter' AND cod_producto = 16 AND cod_subproducto = $cmbsubproducto";						

					$rs2 = mysqli_query($link, $Consulta);
					if($row = mysqli_fetch_array($rs2))
					{
						$unid_piso = $row[unid];
						$peso_piso = $row["peso"];
					}
				}
			?>
		  	<td align="center">&nbsp;<?php echo $unid_ini; ?></td>
		  	<td align="center">&nbsp;<?php echo $peso_ini; ?></td>
		  	<td align="center">&nbsp;<?php echo $unid_recep; ?></td>
		  	<td align="center">&nbsp;<?php echo $peso_recep; ?></td>
		  	<td align="center">&nbsp;<?php echo $unid_trasp; ?></td>
		  	<td align="center">&nbsp;<?php echo $peso_trasp; ?></td>
		  	<td>&nbsp;</td>
		  	<td>&nbsp;</td>
		  	<td align="center"><font color="blue">&nbsp;<?php echo $unid_final; ?></font></td>
		  	<td align="center"><font color="blue">&nbsp;<?php echo $peso_final; ?></font></td>
		  	<td align="center">&nbsp;<?php echo $unid_piso; ?></td>
		  	<td align="center">&nbsp;<?php echo $peso_piso; ?></td>
		  </tr>		  	
<?php /*          <tr align="right"> 
            <td><?php echo $TotalStockIniUnid; ?></td>
            <td><?php echo $TotalStockIniPeso; ?></td>
            <td><?php echo $TotalBenefUnid; ?></td>
            <td><?php echo $TotalBenefPeso; ?></td>
            <td><?php echo $TotalTrasUnid; ?></td>
            <td><?php echo $TotalTrasPeso; ?></td>
            <td><?php echo $TotalOtrosUnid; ?></td>
            <td><?php echo $TotalOtrosPeso; ?></td>
            <td><font color="blue"><?php echo $TotalStockFinUnid; ?></font></td>
            <td><font color="blue"><?php echo $TotalStockFinPeso; ?></font></td>			
            <td width="63"><?php echo $TotalPisoUnid; ?></td>
            <td width="71"><?php echo $TotalPisoPeso; ?></td>			
          </tr>
*/
?>
        </table>
        <br>

      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="BtnCansultar2" type="button" value="Consultar" onClick="Ver_Stock(this.form)" style="width:70px">
              <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()">
              <input name="BtnExcel2" type="button" onClick="JavaScritp:Excel(this.form)" value="Excel" style="width:70px">
              <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>