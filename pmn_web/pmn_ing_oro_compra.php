<?php 
include("../principal/conectar_pmn_web.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$CookieRut = $_COOKIE["CookieRut"]; 
$Rut =$CookieRut;

$CodigoDeSistema = 6;

if(isset($_REQUEST["VerOro"])){
	$VerOro = $_REQUEST["VerOro"];
}else{
	$VerOro = "";
}
if(isset($_REQUEST["Mostrar"])){
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["Mensaje"])){
	$Mensaje = $_REQUEST["Mensaje"];
}else{
	$Mensaje = "";
}

//echo "Oro:    ".$VerOro."<br>"; 
if ($VerOro == "S")
{
	$CmbDias = $IdDiaOro;
	$CmbMes = $IdMesOro;
	$CmbAno = $IdAnoOro;
}

if(isset($_REQUEST["Correlativo"])){
	$Correlativo = $_REQUEST["Correlativo"];
}else{
	$Correlativo = "";
}
if(isset($_REQUEST["NumBarra"])){
	$NumBarra = $_REQUEST["NumBarra"];
}else{
	$NumBarra = "";
}


if(isset($_REQUEST["LeyOro"])){
	$LeyOro = $_REQUEST["LeyOro"];
}else{
	$LeyOro = "";
}
if(isset($_REQUEST["PesoOro"])){
	$PesoOro = $_REQUEST["PesoOro"];
}else{
	$PesoOro = "";
}
if(isset($_REQUEST["PesoPlata"])){
	$PesoPlata = $_REQUEST["PesoPlata"];
}else{
	$PesoPlata = "";
}
if(isset($_REQUEST["LeyPlata"])){
	$LeyPlata = $_REQUEST["LeyPlata"];
}else{
	$LeyPlata = "";
}

if(isset($_REQUEST["Peso"])){
	$Peso = $_REQUEST["Peso"];
}else{
	$Peso = "";
}


if(isset($_REQUEST["cmbrut"])){
	$cmbrut = $_REQUEST["cmbrut"];
}else{
	$cmbrut = "";
}
if(isset($_REQUEST["Fecha"])){
	$Fecha = $_REQUEST["Fecha"];
}else{
	$Fecha = "";
}


?>
<html>
<head>
<title>Sistema de PLAMEN</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function ProcesoOro(Opcion)
{
	var frm= document.FrmIngOro;
	switch(Opcion)
	{
		case "G"://presiono boton Ok para ingresar  
			ValidarOro();
		break;
		case "M": //MODIFICAR
			frm.action= "pmn_ing_oro_compra01.php?Opcion=M";
			frm.submit();
			break;
		case "E2":
			var mensaje = confirm("Seguro que desea Eliminar este Registro?");
			if (mensaje==true)
			{
				frm.action="pmn_ing_oro_compra01.php?CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value  +"&Opcion=E"; 
				frm.submit(); 
			}
			else
			{
				return;
			}
			break;
		case "Ver": //Consultar 
			var URL = "pmn_ing_oro_compra02.php";//?DiaIniCon=" + frm.CmDias.value + "&MesIniCon=" + frm.CmbMes.value + "&AnoIniCon=" + frm.CmbAno.value;// + "&DiaFinCon=" + frm.CmbDias.value + "&MesFinCon=" + frm.CmbMes.value + "&AnoFinCon=" + frm.CmbAno.value;
			window.open(URL,"","top=120,left=30,width=770,height=400,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "E": //MODIFICAR
			frm.action= "pmn_xls_ing_oro_compra.php?Mostrar=C&CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value;
	 		frm.submit();
			break;
	}
}
//**************
function CancelarOro()
{
	var frm=document.FrmIngOro;
	frm.action="pmn_ing_oro_compra01.php?Opcion=C"; 
	frm.submit(); 
			
}
//*************
function ValidarOro()
{
	var frm =document.FrmIngOro;
	CmbDias=frm.CmbDias.value;
	CmbMes=frm.CmbMes.value;
	CmbAno=frm.CmbAno.value;  
	if (frm.NumBarra.value=="")
	{
		alert("Debe ingresar Numero de Barra");
		frm.NumBarra.focus();
		return;
	}
	if (frm.Peso.value=="")
	{
		alert("Debe ingresar Peso");
		frm.Peso.focus();
		return;
	}
	if (frm.TxtLoteVentana.value=="")
	{
		if (confirm("No ha ingresado el Lote asignado por el SIPA!!\nDesea Ingresarlo ahora?"))
		{
			frm.TxtLoteVentana.focus();
			return;
		}
	}
	if (frm.LeyOro.value=="")
	{
		alert("Debe Porcentaje de oro");
		frm.LeyOro.focus();
		return;
	}
	if (frm.PesoOro.value=="")
	{
		alert("Debe ingresar peso oro");
		frm.PesoOro.focus();
		return;
	}
	if (frm.LeyPlata.value=="")
	{
		alert("Debe Porcentaje de Plata");
		frm.LeyPlata.focus();
		return;
	}
	if (frm.PesoPlata.value=="")
	{
		alert("Debe ingresar peso plata");
		frm.PesoPlata.focus();
		return;
	}
	if (frm.cmbrut.value == -1)
	{
		alert("Debe Seleccionar El Rut De Origen");
		return;
	}
	frm.action="pmn_ing_oro_compra01.php?CmbAno="+CmbAno + "&CmbDias="+CmbDias + "&CmbMes="+CmbMes +"&Opcion=G"; 
	frm.submit(); 
}
var fila = 18; //Posicion Inicial de la Fila.
var col = 6;
function ActivarOro(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
function TeclaPulsada1Oro(salto) 
{ 

	var f = document.FrmIngOro;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}


function SalirOro()
{
	var frm =document.FrmIngOro;
	frm.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=101";
	frm.submit(); 
}
function TeclaPulsadaOro (tecla) 
{ 
	var frm=document.FrmEmbarquePlata;
	var teclaCodigo = event.keyCode;
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110 )&&(teclaCodigo != 190 ))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="2">
<form name="FrmIngOro" method="post" action="">
      <table width="98%" border="0" cellpadding="0" cellspacing="0" class="TituloCabeceraOz">
        <tr>
          <td width="1129" align="center">
		  <table width="100%" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
              <tr> 
                <td width="95" height="26" class="titulo_azul"> Fecha:</td>
                <td colspan="2"> 
                  <?php
					if (($VerOro=='S')||($Mostrar=='C'))
					{
						echo "<input type='hidden' name='CmbDias' value='".$CmbDias."'>\n";
						echo "<input type='hidden' name='CmbMes' value='".$CmbMes."'>\n";
						echo "<input type='hidden' name='CmbAno' value='".$CmbAno."'>\n";
						printf("%'02d",$CmbDias);
						echo "-";
						printf("%'02d",$CmbMes);
						echo "-";
						printf("%'04d",$CmbAno);
                    }
					else
					{
						echo "<select name='CmbDias'  size='1' style='font-face:verdana;font-size:10'>";	
					 	for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}
							else
							{
								if ($i==date("j"))
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}	
					  }
					echo "</select>";
					 echo "<select name='CmbMes' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
					  for($i=1;$i<13;$i++)
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
						echo "</select>";
						echo "<select name='CmbAno' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
						for ($i=2004;$i<=date("Y");$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='".$i."'>".$i."</option>";
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
										echo "<option selected value ='".$i."'>".$i."</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
						echo "</select>";
					}	
					?>
                  <input name="BtnVer" type="button" style="width:100" value="Consultar Fecha" onClick="ProcesoOro('Ver');"> 
                </td>
              </tr>
            </table><br>
            <table width="100%" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
              <tr> 
                <td width="95" height="26" align="right" class="titulo_azul"><input name="Correlativo" type="hidden" size="5" id="Correlativo" value="<?php  echo $Correlativo;  ?>"> 
                N Barra:</td>
                <td width="95" height="26"><p> 
                    <input name="NumBarra" type="text" class="InputCen" id="NumBarra2" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php  echo $NumBarra; ?>">
                  </p></td>
                <td width="95" align="right" class="titulo_azul">Peso Barra:</td>
                <td height="26" class="titulo_azul"><input name="Peso" type="text" class="InputDer" id="Peso5" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php  echo $Peso;  ?>">
                Kg. </td>
              <td height="26" align="right"><em class="titulo_azul"><strong>LOTE SIPA: </strong></em></td>
                <td height="26"> <?php
					$Consulta="select * from pmn_web.ingreso_oro_compra ";
					$Consulta.=" where fecha='".$CmbAno."-".$CmbMes."-".$CmbDias."'	"; 
					$Consulta.=" and correlativo='".$Correlativo."' and num_barra='".$NumBarra."' ";
					//echo $Consulta;
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);					
					if(isset($Fila["lote_ventana"])){
						$TxtLoteVentana = $Fila["lote_ventana"];
					}else{
						$TxtLoteVentana = "";
					}

				?><input name="TxtLoteVentana" type="text" class="InputDer" id="LeyPlata4" style="width:60" onKeyDown="TeclaPulsada2('S',false,this.form,'LeyOro');" value="<?php echo $TxtLoteVentana; ?>" maxlength="8" ></td>
                <td height="26" colspan="2">&nbsp;</td>
              </tr>
              <tr class="Detalle01"> 
                <td width="95" height="26" align="right">Ley Au:</td>
                <td width="95" height="26"><input name="LeyOro" type="text" class="InputDer" id="LeyOro2" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php  echo $LeyOro;  ?>">
                (%)</td>
                <td width="95" align="right"> Fino Au:</td>
                <td width="95"><input name="PesoOro" type="text" class="InputDer" id="PesoOro4" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php echo $PesoOro; ?>" >
                gr.</td>
                <td width="95" align="right">Ley Ag:</td>
                <td width="95"><input name="LeyPlata" type="text" class="InputDer" id="LeyPlata2" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php echo $LeyPlata;?>" >
                (%)</td>
                <td width="95" align="right">Fino Ag:</td>
              <td width="95"><input name="PesoPlata" type="text" class="InputDer" id="PesoPlata3" style="width:60" onKeyDown="SoloNumeros(true,this)" value="<?php echo $PesoPlata;?>" >
                gr.</td>
              </tr>
              <tr>
                <td width="95" height="26" align="right" class="titulo_azul">Proveedor:</td>
                <td colspan="7"><select name="cmbrut">
                  <option value="-1">SELECCIONAR</option>
                  <?php
					$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
					$consulta.= " WHERE cod_clase = '6003'";
					$consulta.= " ORDER BY nombre_subclase";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
                    	if ($cmbrut == $row["valor_subclase1"])
							echo '<option value="'.$row["valor_subclase1"].'" selected>'.$row["nombre_subclase"].'</option>';
						else
							echo '<option value="'.$row["valor_subclase1"].'">'.$row["nombre_subclase"].'</option>';
					}
				?>
                </select>              </tr>
              <tr> 
                <td width="95" height="26" align="right" class="titulo_azul">Observacion:</td>
                <td height="26" colspan="7"> 
                  <?php
					$Consulta="select * from pmn_web.ingreso_oro_compra ";
					$Consulta.=" where fecha='".$CmbAno."-".$CmbMes."-".$CmbDias."'	"; 
					$Consulta.=" and correlativo='".$Correlativo."' and num_barra='".$NumBarra."' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if(isset($Fila["observacion"])){
						$Obs=$Fila["observacion"];
					}else{
						$Obs="";
					}
				?>
              <textarea name="Observacion" cols="70"><?php echo $Obs; ?></textarea>                </tr>
            </table>
            <br>
            <table width="100%"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td align="center" valign="middle"> <input name="FechaHorita" type="hidden" value="<?php echo $Fecha;?>"> 
                  <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" onClick="ProcesoOro('G');" style="width:70"> 
                  <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:70" onClick="ProcesoOro('M');"> 
                  <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="ProcesoOro('E2');" style="width:70">
                <input name="BtnCancelar" type="button" style="width:70" value="Cancelar" onClick="CancelarOro('');"></td>
              </tr>
            </table>
            <br>
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr align="center"  class="TituloCabeceraAzul"> 
                <td width="26" height="22" align="center">&nbsp; </td>
                <td width="61"> <div align="center" ><strong>N Barra</strong></div></td>
                <td width="105"> <div align="center"><strong>Peso Barra(Kg)</strong></div></td>
                <td width="94"> <div align="center"><strong>Ley Oro(%)</strong></div></td>
                <td width="100"><strong>Peso Fino(Oro)</strong></td>
                <td width="68"><strong>Ley Plata</strong></td>
                <td width="107"><strong>Peso Fino(Plata)</strong></td>
                <td width="111"><strong>Observacion</strong></td>
              <td width="55"><strong>Lote.Ven.</strong></td>
              </tr>
              <?php
				$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
				/*if (($Mostrar=='C')|| ($Mostrar =='V'))
				{*/
					$Consulta="select * from pmn_web.ingreso_oro_compra ";
					$Consulta.=" where (fecha = '".$Fecha."') order by num_barra";
					//echo $Consulta."<br>";
					$i=2;
					$Resultado=mysqli_query($link, $Consulta);
					$Cont=0;
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						echo "<tr>";
						echo "<td align='center'><input type='checkbox' class='SinBorde' name='ChkFecha[".$i."]' value='".$Fila["fecha"]."'>\n";
						//echo "<input type='hidden' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkBarra[".$i."]' value='".$Fila["num_barra"]."'>\n";
						echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Fila["peso_barra"]."'>\n";
						echo "<input type='hidden' name='ChkLeyOro[".$i."]' value='".$Fila["ley_oro"]."'>\n";
						echo "<input type='hidden' name='ChkPesoOro[".$i."]' value='".$Fila["peso_oro"]."'>\n";
						echo "<input type='hidden' name='ChkLeyPlata[".$i."]' value='".$Fila["ley_plata"]."'>\n";
						echo "<input type='hidden' name='ChkPesoPlata[".$i."]' value='".$Fila["peso_plata"]."'>\n";
						echo "<input type='hidden' name='ChkRut[".$i."]' value='".$Fila["rut_origen"]."'>\n";
						echo "<input type='hidden' name='ChkObservacion[".$i."]' value='".$Fila["observacion"]."'>\n";
						echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Fila["correlativo"]."'>\n";
						echo "<td><div align='center'>".$Fila["num_barra"]."</div></td>";
						echo "<td><div align='right'>".number_format($Fila["peso_barra"],4,",",".")."</div></td>";								
						echo "<td><div align='right'>".number_format($Fila["ley_oro"],2,",",".")."</div></td>";		
						echo "<td><div align='right'>".number_format($Fila["peso_oro"],1,",",".")."</div></td>";		
						echo "<td><div align='right'>".number_format($Fila["ley_plata"],2,",",".")."</div></td>";		
						echo "<td><div align='right'>".number_format($Fila["peso_plata"],1,",",".")."</div></td>";		
						echo "<td><div align='left'>".$Fila["observacion"]."&nbsp;</div></td>";	
						echo "<td><div align='center'>&nbsp;".$Fila["lote_ventana"]."</div></td>";	
						echo "</tr>";
						$i++;		
						$Cont++;
					}
				//}
				?>
          </table>          </td>
        </tr>
  </table>
 <?php //include("../principal/pie_pagina.php");
echo "<script languaje='JavaScript'>";
echo "var frm=document.FrmIngOro;";
if ($Mensaje=='NE')
{
	echo "alert('No se puede Eliminar ya que el stock es menor al valor a Eliminar   ');";
}
echo "</script>";
?></form>
</body>
</html>
