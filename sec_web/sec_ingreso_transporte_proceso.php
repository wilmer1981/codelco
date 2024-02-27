<?php 		
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sec_web.php");
	
	switch($Proceso)
	{

		case "P":
			$Consulta="SELECT * FROM sec_web.contrato_transporte WHERE num_cont_transporte = $Contrato AND num_contrato = $ContratoVent";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Dia = substr($Fila[fecha_contrato],8,2);
			$Ano = substr($Fila[fecha_contrato],0,4);
			$Mes = substr($Fila[fecha_contrato],5,2);			
			$TxtContrato=str_pad($Fila[num_cont_transporte],6,"0",STR_PAD_LEFT);
			$Contrato = $Fila[num_cont_transporte];
			$estado = "V";
			break;

		case "N":
			$Consulta = "SELECT ifnull(max(num_cont_transporte),0)+1 as mayor from sec_web.contrato_transporte ";
			$Resultado = mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$TxtContrato=str_pad($Fila["mayor"],6,"0",STR_PAD_LEFT);
			$Contrato = $Fila["mayor"];
			$estado = "V";
			break;
			
		case "M":
			$Consulta="SELECT * FROM sec_web.contrato_transporte WHERE num_cont_transporte = $Contrato AND num_contrato = $ContratoVent";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Dia = substr($Fila[fecha_contrato],8,2);
			$Ano = substr($Fila[fecha_contrato],0,4);
			$Mes = substr($Fila[fecha_contrato],5,2);
			$DiaIni = substr($Fila["fecha_ini"],8,2);
			$AnoIni = substr($Fila["fecha_ini"],0,4);
			$MesIni = substr($Fila["fecha_ini"],5,2);			
			$DiaTer = substr($Fila["fecha_ter"],8,2);
			$AnoTer = substr($Fila["fecha_ter"],0,4);
			$MesTer = substr($Fila["fecha_ter"],5,2);			
			$TxtContrato=str_pad($Fila[num_cont_transporte],6,"0",STR_PAD_LEFT);
			$Contrato = $Fila[num_cont_transporte];
			$TxtNombreCont=$Fila[nombre_contrato];
			$estado = $Fila[vigente];
			$cmbcontrato=str_pad($Fila["num_contrato"],6,"0",STR_PAD_LEFT).str_pad($Fila["num_subcontrato"],6,"0",STR_PAD_LEFT);
			$TxtPesoVenta = $Fila[peso_venta];
			$cmbtransportista = $Fila[transportista];
			$TxtRepresentante = $Fila["representante"];
			$cmbproducto = $Fila["cod_producto"];
			$cmbsubproducto = $Fila["cod_subproducto"];
			$radio1 = $Fila[estado_peso];
			$Transporte = $Fila[tipo_contrato];
			break;
	}	

?>
<html>
<head>
<script language="JavaScript">
function Buscar_Transportista()
{
	var f = document.FrmProceso;

	f.action = "sec_ingreso_transporte_proceso.php?Proceso=T" ;
	f.submit();	

}

function Recarga2()
{
	var f = document.FrmProceso;

	f.action = "sec_ingreso_transporte_proceso.php" ;
	f.submit();	
			
//	f.action = "sec_ing_produccion.php?" + linea;
}


function recarga_subcontrato()
{
	var f=document.FrmProceso;
	f.action = "sec_ingreso_transporte_proceso.php";
	f.submit();	
}

function Datos_Transportista()
{
	var f=document.FrmProceso;
	f.action = "sec_ingreso_transporte_proceso.php?Proceso=B&Buscar=S";
	f.submit();	
}

function Buscar_Contrato()
{
	var f=document.FrmProceso;
	f.action = "sec_ingreso_transporte_proceso.php?Proceso=B";
	f.submit();	
}

function Grabar()
{
	var Frm=document.FrmProceso;
	
	if (Frm.cmbcontrato.value == -1)
	{
		alert("Debe Ingresar El Contrato De Venta")
		Frm.cmbcontrato.focus();
		return;
	}
	if (Frm.cmbtransportista.value == -1)
	{
		alert("Debe Seleccionar Transportista")
		Frm.cmbtransportista.focus();
		return;
	}
	

	if (Frm.TxtRepresentante.value == "")
	{
		alert("Debe Ingresar El Representante")
		Frm.TxtRepresentante.focus();
		return;
	}


	Frm.action="sec_ingreso_transporte_proceso01.php?Proceso=G";
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">

<body background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>
<form name="FrmProceso" method="post" action="">
  <table width="532" height="157" border="0" cellpadding="3" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="524"><table width="519" border="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="156">Fecha Contrato</td>
            <td width="334"> <SELECT name="Dia" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
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
              </SELECT> <SELECT name="Mes" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </SELECT> <SELECT name="Ano" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
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
          </tr>
          <tr> 
            <td>Fecha Inicio</td>
            <td><SELECT name="DiaIni" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($DiaIni))
					{
						if ($DiaIni == $i)
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
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesIni))
					{
						if ($MesIni == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoIni))
					{
						if ($AnoIni == $i)
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
              </SELECT></td>
          </tr>
          <tr> 
            <td>Fecha Termino</td>
            <td><SELECT name="DiaTer" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($DiaTer))
					{
						if ($DiaTer == $i)
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
              </SELECT> <SELECT name="MesTer" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesTer))
					{
						if ($MesTer == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </SELECT> <SELECT name="AnoTer" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoTer))
					{
						if ($AnoTer == $i)
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
              </SELECT></td>
          </tr>
          <tr> 
            <td>Nro Contr. Transporte</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtContrato' style='width:60' maxlength='10' ReadOnly value='$TxtContrato'>";					
						echo "<input type='hidden' name='Contrato' style='width:60' maxlength='10' value='$Contrato'>";
					}
					else
					{
						echo "<input type='text' name='TxtContrato' style='width:60' maxlength='10' ReadOnly value='$TxtContrato'>";
						echo "<input type='hidden' name='Contrato' style='width:60' maxlength='10' value='$Contrato'>";
					}	
				?>
              <?php		
			if($estado != '')
			{					
			  echo "Vigente";
              if($estado == 'V')
				  echo '<input type="radio" name="estado" value="V" Checked>';
			  else	
				  echo '<input type="radio" name="estado" value="V">';

              echo "&nbsp;Cerrado&nbsp;&nbsp;&nbsp;&nbsp;";
              if($estado == 'C')
              	  echo '<input type="radio" name="estado" value="C" Checked>';
			  else		
              	  echo '<input type="radio" name="estado" value="C">';
			}
			else
			{
			 echo 'Vigente
                  <input type="radio" name="estado" value="V">
	              &nbsp;Cerrado&nbsp;&nbsp;&nbsp;&nbsp;
    	          <input type="radio" name="estado" value="C">';
            }
			?>
            </td>
          </tr>
          <tr> 
            <td>Nro Contr. Ventanas</td>
            <td> <SELECT name="cmbcontrato" style="width:300px">
                <option value="-1" SELECTed>Contratos</option>
                <?php
				$Consulta = "SELECT * FROM sec_web.det_contrato WHERE vigente = 'V' AND transporte = 'E'";
				$rs = mysqli_query($link, $Consulta);
				while($row = mysqli_fetch_array($rs))
				{
					$contrato = str_pad($row["num_contrato"],6,"0",STR_PAD_LEFT).str_pad($row["num_subcontrato"],6,"0",STR_PAD_LEFT);
					if($contrato == $cmbcontrato)
							echo '<option value="'.$contrato.'" SELECTed>'.str_pad($row["num_contrato"],6,"0",STR_PAD_LEFT).' - '.str_pad($row["num_subcontrato"],6,"0",STR_PAD_LEFT).' - '.$row["nom_contrato"].'</option>';
					else 
						echo '<option value="'.$contrato.'">'.str_pad($row["num_contrato"],6,"0",STR_PAD_LEFT).' - '.str_pad($row[num_subcontrato],6,"0",STR_PAD_LEFT).' - '.$row["nom_contrato"].'</option>';				
				}
			  ?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td>Nombre Contrato</td>
            <td><input name="TxtNombreCont" type="text" style="width:200" value="<?php echo $TxtNombreCont; ?>"></td>
          </tr>
          <tr> 
            <td>Rut Cliente (Opcional)</td>
            <td><input type="text" name="TxtRut" maxlength="12" style="width:90" value="<?php echo $TxtRut; ?>"> 
              <input type="button" name="BtnOk" value="Ok" style="width:30" onClick="Buscar_Transportista();"></td>
			  <?php
				if($Proceso == 'T')
					$cmbtransportista = $TxtRut;
			  ?>	
          </tr>
          <tr> 
            <td>Cliente</td>
            <td> <SELECT name="cmbtransportista" style="width:300px">
                <option value="-1">SELECCIONAR</option>
                <?php				
				$Consulta = "SELECT rut_transportista, nombre_transportista FROM sec_web.transporte Group BY rut_transportista Order By nombre_transportista";
				$Rs = mysqli_query($link, $Consulta);

				while($row = mysqli_fetch_array($Rs))
				{
					if ($row["rut_transportista"] == $cmbtransportista)
						echo '<option value="'.$row["rut_transportista"].'" SELECTed>'.$row["rut_transportista"].' - '.$row[nombre_transportista].'</option>';
					else 
						echo '<option value="'.$row["rut_transportista"].'">'.$row["rut_transportista"].' - '.$row[nombre_transportista].'</option>';
				}	
			?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td>Representante</td>
            <td><input name="TxtRepresentante" type="text" style="width:120" value="<?php echo $TxtRepresentante; ?>"></td>
          </tr>
          <tr> 
            <?php 
			?>
            <td>Producto</td>
            <td><SELECT name="cmbproducto" style="width:300px" onChange="Recarga2()">
                <option value="-1">SELECCIONAR</option>
                <?php
				$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "LAMINAS APROBADAS");
				foreach($productos as $clave => $valor)
				{
					if ($clave == $cmbproducto)
						echo '<option value="'.$clave.'" SELECTed>'.$valor.'</option>';
					else 
						echo '<option value="'.$clave.'">'.$valor.'</option>';
				}	
			?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td>SubProducto</td>
            <td><SELECT name="cmbsubproducto" style="width:300px">
                <option value="-1">SELECCIONAR</option>
                <?php	
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = ".$cmbproducto."";
			//echo '<option value="-1">'.$consulta.'</option>';
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				$codigo = $row["cod_subproducto"];
				$descripcion = $row["descripcion"];
				if ($codigo == $cmbsubproducto)
					echo '<option value="'.$codigo.'" SELECTed>'.$descripcion.'</option>';
				else
					echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
			}						
		?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td>Peso Venta</td>
            <td> <input type="text" name="TxtPesoVenta" style="width:60" value="<?php echo $TxtPesoVenta; ?>"> 
              <?php
			if($radio1 != '')
			{					
			  echo "&nbsp;Seco";
              if($radio1 == 'S')
				  echo '<input type="radio" name="radio1" value="S" Checked>';
			  else	
				  echo '<input type="radio" name="radio1" value="S">';

              echo "Humedo";
              if($radio1 == 'H')
              	  echo '<input type="radio" name="radio1" value="H" Checked>';
			  else		
              	  echo '<input type="radio" name="radio1" value="H">';

			}
			else
			{
			 echo '&nbsp;Seco
                  <input type="radio" name="radio1" value="S">
	              Humedo
    	          <input type="radio" name="radio1" value="H">';
            }
			?>
            </td>
          </tr>
          <tr> 
            <td>Tipo Contrato Transp.</td>
            <td> 
              <?php	
			if($Transporte != '')
			{					
			  echo "Enami&nbsp;";
              if($Transporte == 'E')
				  echo '<input type="radio" name="Transporte" value="E" Checked>';
			  else	
				  echo '<input type="radio" name="Transporte" value="E">';

              echo "&nbsp;Cliente";
              if($Transporte == 'C')
              	  echo '<input type="radio" name="Transporte" value="C" Checked>';
			  else		
              	  echo '<input type="radio" name="Transporte" value="C">';
			}
			else
			{
			 echo 'Enami&nbsp;
                  <input type="radio" name="Transporte" value="E">
	              &nbsp;Cliente
    	          <input type="radio" name="Transporte" value="C">';
            }
			?>
            </td>
          </tr>
        </table>
        <br>
        <table width="519" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="502">
			  <input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar();">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
