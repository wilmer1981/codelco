<?php
include("../principal/conectar_principal.php");
//echo "EB".$ElectBarras."<br>";
$AuxElectBarras=$ElectBarras;
$Mostrar="S";
for($j= 0;$j <= strlen($ElectBarras); $j++)
{
	if (substr($ElectBarras,$j,2) == "//")
	{
		$ElecBarra =substr($ElectBarras,0,$j);	
		for ($x=0;$x<= strlen($ElecBarra);$x++)
		{
			if (substr($ElecBarra,$x,2) == "~~")
			{
				$Electrolisis = substr($ElecBarra,0,$x);
				$Barra = substr($ElecBarra,$x+2,strlen($ElecBarra));
				$Elect=$Elect.$Electrolisis.'-'; 	
				$Barras=$Barras.$Barra.'-';
				$Consulta="select peso_bruto,nro_sello from pmn_web.carga_fusion_oro ";
				$Consulta.=" where num_electrolisis='".$Electrolisis."' and num_barra ='".$Barra."' ";
				$Respuesta=mysqli_query($link, $Consulta); 
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ((!is_null($Fila[nro_sello])) || ($Fila[nro_sello]!=""))
					{
						$Mostrar="N";
					}
				}
			}	
		}	
		$ElectBarras = substr($ElectBarras,$j + 2);
		$j = 0;
	}
}

?>
<html>
<head>
<title>Ingreso Valores Muestras</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
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
function Grabar(E,F)//Electrolisis,Barra,Fecha del dia
{
	var frm =document.FrmRetalla;	 
	if (frm.TxtPesoBruto.value=="") 
	{
		alert("Debe Ingresar Peso Bruto");
		frm.TxtPesoBruto.focus();
		return;
	}
	if (frm.TxtNumSello.value=="") 
	{
		alert("Debe Ingresar #Sello");
		frm.TxtNumSello.focus();
		return;
	}
	//alert(E);
	//alert(F);
	frm.action="pmn_carga_fusion_oro01.php?ElectBarras="+E + "&Fe="+F + "&PesoBruto="+frm.TxtPesoBruto.value + "&Sello="+frm.TxtNumSello.value + "&Proceso=Embalaje";
	frm.submit(); 
}
function Salir()
{
	var frm =document.FrmRetalla;	 
	window.close();
	//frm.action="cal_leyes_por_solicitud_retalla01?Opcion=5";
	//frm.submit(); 
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="FrmRetalla" method="post" action="">
  <table width="451" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="439"><table width="438" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center" class="TituloCabeceraAzul">Embalaje</div></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">N&deg;ELEC</td>
            <td width="132" class="formulario">:<?php echo $Elect;    ?></td>
            <td width="41" class="titulo_azul">N&deg;Barra</td>
            <td width="171" class="formulario">:<?php echo $Barras;?></td>
          </tr>
          <tr> 
            <td width="67" class="titulo_azul">Peso Bruto</td>
            <td>: 
              <input name="TxtPesoBruto" type="text" onKeyDown="TeclaPulsada()" id="TxtPesoBruto" value="<?php  echo $TxtPesoBruto; ?>"> 
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="titulo_azul">N&deg;Sello</td>
            <td>:
              <input name="TxtNumSello" type="text" onKeyDown="TeclaPulsada()" id="TxtNumSello" value="<?php  echo $TxtNumSello; ?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="439" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="185"><div align="right">
				<?php
			  //if ($Mostrar=='S')
			//	{
					echo "<input name='BtnOk' type='button' style='width:50'  value='OK' onClick=\"Grabar('$AuxElectBarras','$Fecha')\"; >";
			//	}
				?>																					
              </div></td>
            <td width="11">&nbsp;</td>
            <td width="222"><input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
echo "<script language='JavaScript'>";
if ($Mostrar=='N')
{
	echo "var Frm=document.FrmRetalla;";
	echo "alert('Ya existe un #Sello para esta electrolisis ');";
	echo "Frm.TxtPesoBruto.focus();";	
}
echo "</script>";
?>
