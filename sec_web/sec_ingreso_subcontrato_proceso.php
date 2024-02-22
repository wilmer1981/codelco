<?php 		
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sec_web.php");
	
	switch($Proceso)
	{
		case "P":
			$Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = $NumContrato AND num_subcontrato = 0";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
            
			$TxtContrato=str_pad($NumContrato,6,"0",STR_PAD_LEFT);
			$Contrato = $NumContrato;
			$estado = "V";
			$ContratoVent = $Fila[contrato_vent];

            //SubContrato
			if($NumSubContrato != '' && $NumSubContrato != 0)
			{
			    $Consulta = "SELECT ifnull(max(num_subcontrato),0)+1 as mayor from sec_web.det_contrato WHERE num_contrato = $Contrato";
			    $Result = mysqli_query($link, $Consulta);
			    $Fil=mysqli_fetch_array($Result);
			    $TxtSubContrato=str_pad($Fil["mayor"],6,"0",STR_PAD_LEFT);
			    $SubContrato = $Fil["mayor"];            
				$cmbproducto = $Fila["cod_producto"];
				$cmbsubproducto = $Fila["cod_subproducto"];				
				$cmbcliente = $Fila["cod_cliente"];				
            } 
			else
			{
				$Dia = substr($Fila["fecha"],8,2);
			    $Ano = substr($Fila["fecha"],0,4);
			    $Mes = substr($Fila["fecha"],5,2);		
			}
			break;
			
		case "M":
			$Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = $Contrato AND num_subcontrato = $SubContrato AND cod_producto = $producto AND cod_subproducto = $subproducto";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Dia = substr($Fila["fecha"],8,2);
			$Ano = substr($Fila["fecha"],0,4);
			$Mes = substr($Fila["fecha"],5,2);			
			$DiaIni = substr($Fila[fecha_ini],8,2);
			$AnoIni = substr($Fila[fecha_ini],0,4);
			$MesIni = substr($Fila[fecha_ini],5,2);			
			$DiaTer = substr($Fila[fecha_ter],8,2);
			$AnoTer = substr($Fila[fecha_ter],0,4);
			$MesTer = substr($Fila[fecha_ter],5,2);			
			$DiaRen = substr($Fila[fecha_ren],8,2);
			$AnoRen = substr($Fila[fecha_ren],0,4);
			$MesRen = substr($Fila[fecha_ren],5,2);						
			$TxtContrato=str_pad($Fila[num_contrato],6,"0",STR_PAD_LEFT);
			$Contrato = $Fila[num_contrato];
			$ContratoVent = $Fila[contrato_vent];
			$estado = $Fila[vigente];			
			$TxtNomContrato = $Fila[nom_contrato];
			$TxtSubContrato=str_pad($Fila[num_subcontrato],6,"0",STR_PAD_LEFT);
			$SubContrato = $Fila[num_subcontrato];
			$cmbproducto = $Fila["cod_producto"];
			$cmbsubproducto = $Fila["cod_subproducto"];
			$TxtPesoVent = $Fila[peso_vendido];
			$TxtPrecioCompVent = $Fila[precio_compraventa];

			$Consulta1="SELECT * FROM sec_web.contrato WHERE num_contrato = $Contrato";
			$Respuesta1=mysqli_query($link, $Consulta1);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$cmbcliente = $Fila1["cod_cliente"];
			break;
	}	

?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtNomContrato.value == "")
	{
		alert("Debe Ingresar Nombre de Contrato")
		Frm.TxtNomContrato.focus();
		return;
	}

	if (Frm.TxtPesoVent.value == "")
	{
		alert("Debe Ingresar El Peso de Venta")
		Frm.TxtPesoVent.focus();
		return;
	}

	if (Frm.TxtPrecioCompVent.value == "")
	{
		alert("Debe Ingresar El Precio de Compra-Venta")
		Frm.TxtPrecioCompVent.focus();
		return;
	}

	Frm.action="sec_ingreso_subcontrato_proceso01.php?Proceso="+Proceso;
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
  <table width="580" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td>
<table width="575" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>Fecha SubContrato</td>
            <td><SELECT name="Dia" style="width:50px;">
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
              </SELECT></td>
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
            <td>Fecha Renovación</td>
            <td><SELECT name="DiaRen" style="width:50px;">
                <?php
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($DiaRen))
					{
						if ($DiaRen == $i)
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
              </SELECT> <SELECT name="MesRen" style="width:90px;">
                <?php
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesRen))
					{
						if ($MesRen == $i)
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
              </SELECT> <SELECT name="AnoRen" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoRen))
					{
						if ($AnoRen == $i)
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
            <td width="182">Fecha Termino</td>
            <td width="364"><SELECT name="DiaTer" style="width:50px;">
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
              </SELECT> </td>
          </tr>
          <tr> 
            <td>Nro Contrato</td>
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
            <td>Nombre Contrato</td>
            <td><input type="text" name="TxtNomContrato" style="width:300" maxlength="60" value="<?php echo $TxtNomContrato; ?>"></td>
          </tr>
          <tr> 
            <td>Contrato Ventana(Opcional)</td>
            <td><input type="text" name="ContratoVent" style="width:60" maxlength="6" value="<?php echo $ContratoVent; ?>"></td>
          </tr>
          <?php
		     if($SubContrato != '' && $SubContrato != 0)
			 {
		        echo"<tr>";
		          echo"<td>Num SubContrato</td>";
		          echo"<td><input type='text' name='TxtSubContrato' style='width:60' maxlength='10' ReadOnly value='$TxtSubContrato'></td>";
				  echo "<input type='hidden' name='SubContrato' style='width:60' maxlength='10' value='$SubContrato'>";
		        echo"</tr>";
             }
		  ?>
          <tr> 
            <td>Peso Venta</td>
            <td><input type="text" name="TxtPesoVent" style="width:60" maxlength="8" value="<?php echo $TxtPesoVent; ?>">
              Tons. </td>
          </tr>
          <tr> 
            <td>Precio Comp-Venta</td>
            <td><input type="text" name="TxtPrecioCompVent" style="width:60" maxlength="8" value="<?php echo $TxtPrecioCompVent;?>"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="575" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('G','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              <input type="hidden" name="cmbcliente" style="width:60" maxlength="8" value="<?php echo $cmbcliente; ?>">
              <input type="hidden" name="cmbproducto" style="width:60" maxlength="8" value="<?php echo $cmbproducto; ?>">
              <input type="hidden" name="cmbsubproducto" style="width:60" maxlength="8" value="<?php echo $cmbsubproducto; ?>">

              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
