<?php 		
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sec_web.php");

	$Dia   = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes   = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano   = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

	$DiaIni   = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni   = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni   = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");

	$DiaTer   = isset($_REQUEST["DiaTer"])?$_REQUEST["DiaTer"]:date("d");
	$MesTer   = isset($_REQUEST["MesTer"])?$_REQUEST["MesTer"]:date("m");
	$AnoTer   = isset($_REQUEST["AnoTer"])?$_REQUEST["AnoTer"]:date("Y");

	$DiaRen   = isset($_REQUEST["DiaRen"])?$_REQUEST["DiaRen"]:date("d");
	$MesRen   = isset($_REQUEST["MesRen"])?$_REQUEST["MesRen"]:date("m");
	$AnoRen   = isset($_REQUEST["AnoRen"])?$_REQUEST["AnoRen"]:date("Y");

	
	$NumContrato   = isset($_REQUEST["NumContrato"])?$_REQUEST["NumContrato"]:"";
	$NumSubContrato   = isset($_REQUEST["NumSubContrato"])?$_REQUEST["NumSubContrato"]:"";
	$ContratoVent   = isset($_REQUEST["ContratoVent"])?$_REQUEST["ContratoVent"]:"";
	$TxtNomContrato   = isset($_REQUEST["TxtNomContrato"])?$_REQUEST["TxtNomContrato"]:"";
	$TxtContrato   = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";


	$cmbcliente   = isset($_REQUEST["cmbcliente"])?$_REQUEST["cmbcliente"]:"";
	$cmbproducto   = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
	$cmbsubproducto   = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";

	$radio   = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
	$radio1   = isset($_REQUEST["radio1"])?$_REQUEST["radio1"]:"";
	$radio2   = isset($_REQUEST["radio2"])?$_REQUEST["radio2"]:"";
	$ValorCheck   = isset($_REQUEST["ValorCheck"])?$_REQUEST["ValorCheck"]:"";
	$ValorCheck2   = isset($_REQUEST["ValorCheck2"])?$_REQUEST["ValorCheck2"]:"";
	$TxtPesoVent   = isset($_REQUEST["TxtPesoVent"])?$_REQUEST["TxtPesoVent"]:"";
	$Leyes   = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";
	$Transporte   = isset($_REQUEST["Transporte"])?$_REQUEST["Transporte"]:"";
	$TxtPrecioCompVent   = isset($_REQUEST["TxtPrecioCompVent"])?$_REQUEST["TxtPrecioCompVent"]:"";

	$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$estado   = isset($_REQUEST["estado"])?$_REQUEST["estado"]:"";

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Contrato   = isset($_REQUEST["Contrato"])?$_REQUEST["Contrato"]:"";
	$SubContrato   = isset($_REQUEST["SubContrato"])?$_REQUEST["SubContrato"]:"";
	$producto   = isset($_REQUEST["producto"])?$_REQUEST["producto"]:"";
	$subproducto= isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";

	$AnalisisComercial = isset($_REQUEST["AnalisisComercial"])?$_REQUEST["AnalisisComercial"]:"";
	$AnalisisImpurezas = isset($_REQUEST["AnalisisImpurezas"])?$_REQUEST["AnalisisImpurezas"]:"";
	

	
	switch($Proceso)
	{
		case "P":
			$Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = '".$NumContrato."' AND num_subcontrato = 0";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
            
			$TxtContrato=str_pad($NumContrato,6,"0",STR_PAD_LEFT);
			$Contrato = $NumContrato;
			$estado = "V";
			$ContratoVent = $Fila["contrato_vent"];

            //SubContrato
			if($NumSubContrato != '' && $NumSubContrato != 0)
			{
			    $Consulta = "SELECT ifnull(max(num_subcontrato),0)+1 as mayor from sec_web.det_contrato WHERE num_contrato = '".$Contrato."'";
			    $Result = mysqli_query($link, $Consulta);
			    $Fil=mysqli_fetch_array($Result);
			    $TxtSubContrato=str_pad($Fil["mayor"],6,"0",STR_PAD_LEFT);
			    $SubContrato = $Fil["mayor"];            
				$cmbproducto = $Fila["cod_producto"];
				$cmbsubproducto = $Fila["cod_subproducto"];				
            } 
			else
			{
				$Dia = substr($Fila["fecha_contrato"],8,2);
			    $Ano = substr($Fila["fecha_contrato"],0,4);
			    $Mes = substr($Fila["fecha_contrato"],5,2);		
			}
			break;

		case "N":
			$Consulta = "SELECT ifnull(max(num_contrato),0)+1 as mayor from sec_web.det_contrato ";
			$Resultado = mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$TxtContrato=str_pad($Fila["mayor"],6,"0",STR_PAD_LEFT);
			$Contrato = $Fila["mayor"];
			$estado = "V";
			break;
			
		case "M":
            if($SubContrato != '' && $SubContrato != 0)
			  $Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = '".$Contrato."' AND num_subcontrato = '".$SubContrato."' AND cod_producto = '".$producto."' AND cod_subproducto = '".$subproducto."'";
            else
			  $Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = '".$Contrato."' AND cod_producto = '".$producto."' AND cod_subproducto = '".$subproducto."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Dia = substr($Fila["fecha_contrato"],8,2);
			$Ano = substr($Fila["fecha_contrato"],0,4);
			$Mes = substr($Fila["fecha_contrato"],5,2);			
			$DiaIni = substr($Fila["fecha_ini"],8,2);
			$AnoIni = substr($Fila["fecha_ini"],0,4);
			$MesIni = substr($Fila["fecha_ini"],5,2);			
			$DiaTer = substr($Fila["fecha_ter"],8,2);
			$AnoTer = substr($Fila["fecha_ter"],0,4);
			$MesTer = substr($Fila["fecha_ter"],5,2);			
			$DiaRen = substr($Fila["fecha_ren"],8,2);
			$AnoRen = substr($Fila["fecha_ren"],0,4);
			$MesRen = substr($Fila["fecha_ren"],5,2);			
			$TxtContrato=str_pad($Fila["num_contrato"],6,"0",STR_PAD_LEFT);
			$Contrato     = $Fila["num_contrato"];
			$ContratoVent = $Fila["contrato_vent"];
			$TxtNomContrato = $Fila["nom_contrato"];
			$TxtSubContrato=str_pad($Fila["num_subcontrato"],6,"0",STR_PAD_LEFT);
			$SubContrato = $Fila["num_subcontrato"];
			$cmbproducto = $Fila["cod_producto"];
			$cmbsubproducto = $Fila["cod_subproducto"];
			$TxtPesoVent    = $Fila["peso_vendido"];
			$estado = $Fila["vigente"];
			$radio1 = $Fila["estado_vendido"];
			$TxtPrecioCompVent = $Fila["precio_compraventa"];
			$radio2            = $Fila["estado_compraventa"];
			$ValorCheck        = $Fila["analisis_comercial"];
			$ValorCheck2       = $Fila["analisis_impurezas"];
			$radio      = $Fila["confeccion"];
			$Transporte = $Fila["transporte"];

			$Consulta1="SELECT * FROM sec_web.contrato WHERE num_contrato ='".$Contrato."'";
			$Respuesta1=mysqli_query($link, $Consulta1);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$cmbcliente = $Fila1["cod_cliente"];
			break;
	}	

?>
<html>
<head>
<script language="JavaScript">
function Buscar_Destino()
{
	var f=document.FrmProceso;
	var TxtCliente = '';
	if (f.cmbcliente.value == -1)
	{
		alert("Debe Seleccionar Cliente")
		f.cmbcliente.focus();
		return;
	}

	valor = f.cmbcliente.value;
	window.open("sec_ing_destino.php?TxtCliente="+valor,"","top=170,left=185,width=455,height=295,scrollbars=no");		

}
function Mostrar_Leyes(Proceso)
{
	var f=document.FrmProceso;
	var Valores = "";
	var radio = "";
	var radio1 = "";
	var radio2 = "";
	var Transporte = "";
	var LargoForm = f.elements.length;

	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio") && (f.elements[i].checked == true))
		{
			radio =  f.elements[i].value;
			break;
		}
	}
	
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio1") && (f.elements[i].checked == true))
		{
			radio1 =  f.elements[i].value;
			break;
		}
	}

	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio2") && (f.elements[i].checked == true))
		{
			radio2 =  f.elements[i].value;
			break;
		}
	}

	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "Transporte") && (f.elements[i].checked == true))
		{
			Transporte =  f.elements[i].value;
			break;
		}
	}
		
	Valores = "&radio=" + radio + "&radio1=" + radio1 + "&radio2=" + radio2 + "&Transporte=" + Transporte;

	if(Proceso == '1')
		window.open("sec_selecion_leyes.php?Proceso=1"+Valores,"","top=10,left=180,width=655,height=600,scrollbars=yes");		
	else
		window.open("sec_selecion_leyes.php?Proceso=2"+Valores,"","top=10,left=180,width=655,height=600,scrollbars=yes");		
}

function Recarga2()
{
	var f = document.FrmProceso;

	document.location = "sec_ingreso_contrato_proceso.php" ;
	f.submit();	
			
//	f.action = "sec_ing_produccion.php?" + linea;
}

function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtNomContrato.value == "")
	{
		alert("Debe Ingresar Nombre de Contrato")
		Frm.TxtNomContrato.focus();
		return;
	}

	if (Frm.cmbcliente.value == -1)
	{
		alert("Debe Seleccionar Cliente")
		Frm.cmbcliente.focus();
		return;
	}

	if (Frm.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar Producto")
		Frm.cmbproducto.focus();
		return;
	}
	if (Frm.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El Subproducto")
		Frm.cmbsubproducto.focus();
		return;
	}	

	if (Frm.TxtPesoVent.value == "")
	{
		alert("Debe Ingresar El Peso de Venta")
		Frm.TxtPesoVent.focus();
		return;
	}

	if(Frm.radio1[0].checked == false && Frm.radio1[1].checked == false && Frm.radio1[2].checked == false)
	{
		alert("Debe Escoger Si Es Humedo o Seco");
		return	
	}

	if (Frm.TxtPrecioCompVent.value == "")
	{
		alert("Debe Ingresar El Precio de Compra-Venta")
		Frm.TxtPrecioCompVent.focus();
		return;
	}
	
	if(Frm.radio2[0].checked == false && Frm.radio2[1].checked == false && Frm.radio2[2].checked == false)
	{
		alert("Debe Escoger Si Es Humedo o Seco");
		return	
	}

	if(Frm.radio[0].checked == false && Frm.radio[1].checked == false)
	{
		alert("Debe escoger Confección");
		return	
	}


	if(Frm.Transporte[0].checked == false && Frm.Transporte[1].checked == false)
	{
		alert("Debe Escoger Transporte");
		return	
	}

	Frm.action="sec_ingreso_contrato_proceso01.php?Proceso="+Proceso;
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
  <table width="580" height="157" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="575" border="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td>Fecha Contrato</td>
            <td> <SELECT name="Dia" style="width:50px;">
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
            <td height="21">Contrato Vent.(Opc)</td>
            <td><input type="text" name="ContratoVent" style="width:60" maxlength="6" value="<?php echo $ContratoVent; ?>"></td>
          </tr>
          <tr> 
            <td>Nombre Contrato</td>
            <td> 
              <input type="text" name="TxtNomContrato" style="width:300" maxlength="60" value="<?php echo $TxtNomContrato; ?>"></td>
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
            <td> Cliente </td>
            <td> <SELECT name="cmbcliente" style="width:300px">
                <option value="-1">SELECCIONAR</option>
                <?php
					echo "<option value='-'>&nbsp;</option>";
					echo "<option value='-'>------CLIENTES VENTAS DIRECTAS--------------------------</option>";
					$Consulta="SELECT * from sec_web.cliente_venta where (cod_cliente like '%VD%') order by nombre_cliente";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($cmbcliente==$Fila["cod_cliente"])
						{
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".$Fila["nombre_cliente"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["nombre_cliente"]."</option>";
						}
					}
					
					echo "<option value='-'>&nbsp;</option>";
					echo "<option value='-'>------CLIENTES CHILE--BRASIL--ARGENTINA-----------------------------</option>";
					echo "<option value='-'>&nbsp;</option>";
					$Consulta="SELECT * from sec_web.cliente_venta where (cod_cliente like '%LX%' or cod_cliente like '%AR%' or ";
					$Consulta.="cod_cliente like '%BR%' or cod_cliente like '%VD%') order by nombre_cliente";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($cmbcliente==$Fila["cod_cliente"])
						{
							echo "<option value='".$Fila["cod_cliente"]."' SELECTed>".$Fila["nombre_cliente"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["nombre_cliente"]."</option>";
						}
					}
					
			?>
              </SELECT> </td>
          </tr>
          <tr> 
            <?php 
			?>
            <td>Producto</td>
            <td><SELECT name="cmbproducto" style="width:300px" onChange="Recarga2()">
                <option value="-1">SELECCIONAR</option>
                <?php
				$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "LAMINAS APROBADAS", 17=> "ANODOS");
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
            <td><input type="text" name="TxtPesoVent" style="width:60" maxlength="8" value="<?php echo $TxtPesoVent; ?>">
              Tons. 
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

              echo "Todos";
              if($radio1 == 'T')
              	  echo '<input type="radio" name="radio1" value="T" Checked>';
			  else		
              	  echo '<input type="radio" name="radio1" value="T">';
			}
			else
			{
			 echo '&nbsp;Seco
                  <input type="radio" name="radio1" value="S">
	              Humedo
    	          <input type="radio" name="radio1" value="H">
	              Todos
    	          <input type="radio" name="radio1" value="T">';
            }
			?>
            </td>
          </tr>
          <tr> 
            <td>Precio Comp-Venta</td>
            <td><input type="text" name="TxtPrecioCompVent" style="width:60" maxlength="8" value="<?php echo $TxtPrecioCompVent;?>"> 
              <?php
			if($radio2 != '')
			{					
			  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seco";
              if($radio2 == 'S')
				  echo '<input type="radio" name="radio2" value="S" Checked>';
			  else	
				  echo '<input type="radio" name="radio2" value="S">';

              echo "Humedo";
              if($radio2 == 'H')
              	  echo '<input type="radio" name="radio2" value="H" Checked>';
			  else		
              	  echo '<input type="radio" name="radio2" value="H">';

              echo "Todos";
              if($radio2 == 'T')
              	  echo '<input type="radio" name="radio2" value="T" Checked>';
			  else		
              	  echo '<input type="radio" name="radio2" value="T">';
			}
			else
			{
			 echo '&nbsp;Seco
                  <input type="radio" name="radio2" value="S">
	              Humedo
    	          <input type="radio" name="radio2" value="H">
	              Todos
    	          <input type="radio" name="radio2" value="T">';
            }
			?>
            </td>
          </tr>
          <tr> 
            <td>Analisis Comercial</td>
            <td> 
              <?php			
   			   $StrLeyes = $ValorCheck;

			   if($ValorCheck != '')
				$AnalisisComercial = $ValorCheck;

			   if($Proceso == 1 || $Proceso == "M")
			   {	
					for ($j = 0;$j <= strlen($StrLeyes); $j++)
					{
						if (substr($StrLeyes,$j,2) == "//")
						{
							$LeyesUnidad = substr($StrLeyes,0,$j);
							for ($x=0;$x<=strlen($LeyesUnidad);$x++)
							{
								if (substr($LeyesUnidad,$x,2) == "~~")
								{
									$CodLeyes = substr($StrLeyes,0,$x);			
									$Consulta = "SELECT abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodLeyes."'";
									$Resultado= mysqli_query($link, $Consulta);
									while ($Fila2=mysqli_fetch_array($Resultado))
									{
										$Leyes=$Leyes.$Fila2["abreviatura"]."-";
									}
								}
							}
							$StrLeyes = substr($StrLeyes,$j + 2);
							$j = 0;
						}
					}			
			}
			?>
              <input type="hidden" name="AnalisisComercial" style="width:200" maxlength="30" value="<?php echo $AnalisisComercial;?>"> 
              <?php
			  	  $tope1= (strlen($Leyes) - 1);				  
			  ?>
              <input type="text" name="Leyes" style="width:200" maxlength="25" ReadOnly value="<?php echo substr($Leyes,0,$tope1);?>"> 
              &nbsp; <input type="button" name="BtnLeyes2" value="Leyes" style="width:60" onClick="Mostrar_Leyes('1')">	
            </td>
          </tr>
          <tr> 
            <td>Analisis Impurezas</td>
            <td> 
              <?php			
			   $StrLeyes = $ValorCheck2;
			   $Leyes2="";

			   if($ValorCheck2 != '')
				 $AnalisisImpurezas = $ValorCheck2;

			   if($Proceso == 2 || $Proceso == "M")
			   {	
					for ($j = 0;$j <= strlen($StrLeyes); $j++)
					{
						if (substr($StrLeyes,$j,2) == "//")
						{
							$LeyesUnidad = substr($StrLeyes,0,$j);
							for ($x=0;$x<=strlen($LeyesUnidad);$x++)
							{
								if (substr($LeyesUnidad,$x,2) == "~~")
								{
									$CodLeyes = substr($StrLeyes,0,$x);			
									$Consulta = "SELECT abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodLeyes."'";
									$Resultado= mysqli_query($link, $Consulta);
									while ($Fila2=mysqli_fetch_array($Resultado))
									{
										$Leyes2=$Leyes2.$Fila2["abreviatura"]."-";
									}
								}
							}
							$StrLeyes = substr($StrLeyes,$j + 2);
							$j = 0;
						}
					}			
			}
			?>
              <input type="hidden" name="AnalisisImpurezas" style="width:200" maxlength="30" value="<?php echo $AnalisisImpurezas;?>"> 
              <?php
			  	  $tope2= (strlen($Leyes2) - 1);				  
			  ?>
              <input type="text" name="Leyes2" style="width:200" maxlength="30" ReadOnly value="<?php echo substr($Leyes2,0,$tope2);?>"> 
              &nbsp; <input type="button" name="BtnLeyes22" value="Leyes" style="width:60" onClick="Mostrar_Leyes('2')"></td>
          </tr>
          <tr> 
            <td>Confección</td>
            <td> 
              <?php
			if($radio != '')
			{					
			  echo "Granel";
              if($radio == 'G')
				  echo '<input type="radio" name="radio" value="G" Checked>';
			  else	
				  echo '<input type="radio" name="radio" value="G">';

              echo "&nbsp;Lote&nbsp;&nbsp;&nbsp;&nbsp;";
              if($radio == 'L')
              	  echo '<input type="radio" name="radio" value="L" Checked>';
			  else		
              	  echo '<input type="radio" name="radio" value="L">';
			}
			else
			{
			 echo 'Granel
                  <input type="radio" name="radio" value="G">
	              &nbsp;Lote&nbsp;&nbsp;&nbsp;&nbsp;
    	          <input type="radio" name="radio" value="L">';
            }
			?>
            </td>
          </tr>
          <tr> 
            <td>Transporte</td>
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
        <table width="575" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('G','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
