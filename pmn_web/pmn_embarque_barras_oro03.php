<?php
include("../principal/conectar_principal.php");
//echo "EB".$ElectBarras."<br>";
//echo $Datos;
$Datos2=explode('//',$Datos);
while(list($c,$v)=each($Datos2))
{
	//echo $v."<br>";
	$Datos3=explode('~',$v);
	$Barras=$Barras.$Datos3[0]."//";
	//echo $Datos3[0]."<br>";
}
//$Barras=substr($Barras,0,strlen($Barras)-2);
//echo $Barras."<br>";	
$AuxBarras=$Barras;
$Mostrar="S";

for($j= 0;$j <= strlen($Barras); $j++)
{
	if (substr($Barras,$j,2) == "//")
	{
		$Barra =substr($Barras,0,$j);	
		//$B=$B.$Barra.'-';
		$Consulta="select num_barra,peso_neto_barra,num_sello,peso_neto_caja,peso_bruto_caja,valor_declarado from pmn_web.embarque_oro ";
		$Consulta.=" where num_barra='".$Barra."' and fecha ='".$Ano."-".$Mes."-".$Dia."'   ";
		//echo $Consulta."<br>";
		$Respuesta=mysqli_query($link, $Consulta); 
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			//echo "num sello ant".$NroSelloAnt."<br>";
			//echo "num sello".$NroSelloAnt."<br>";
			if ($NroSelloAnt==$Fila[num_sello])
			{
				$PesoNeto=$Fila[peso_neto_caja];
				$PesoBruto=$Fila[peso_bruto_caja];
				$Sello=$Fila[num_sello];
				$Valor=$Fila[valor_declarado];
				$Mensaje="N";
			}
			else
			{
				$Mensaje="S";
			
			}
			$PesoNBarra=$PesoNBarra.$Fila[peso_neto_barra].'-';
			if ((!is_null($Fila[num_sello])) || ($Fila[num_sello]!=""))
			{
				$Mostrar="N";
				$A='<font color="red">'.$A.$Fila[num_barra].'-';
			}
			else
			{
				$B=$B.$Fila[num_barra].'-';		
			}
		$NroSelloAnt=$Fila[num_sello];
		}
		$Barras = substr($Barras,$j + 2);
		$j = 0;
	}
}
?>
<html>
<head>
<title>Ingreso Valores Muestras</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="funciones/funciones_java.js"></script>
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
function Grabar(B,A,M,D)//Barras,Fecha del dia
{
	var frm =document.FrmRetalla;	 
	if (frm.PesoNeto.value=="") 
	{
		alert("Debe Ingresar Peso Neto Cajas");
		frm.PesoNeto.focus();
		return;
	}
	
	if (frm.PesoBruto.value=="") 
	{
		alert("Debe Ingresar Peso Bruto");
		frm.PesoBruto.focus();
		return;
	}
	if (frm.Sello.value=="") 
	{
		alert("Debe Ingresar Sello");
		frm.Sello.focus();
		return;
	}
	frm.action="pmn_embarque_barras_oro01.php?Barras="+B +"&Dia="+D +"&Ano="+A +"&Mes="+M+"&PesoNeto="+frm.PesoNeto.value + "&PesoBruto="+frm.PesoBruto.value + "&Sello="+frm.Sello.value + "&Valor="+frm.Valor.value + "&Proceso=Valores";
	frm.submit(); 
}
function TeclaPulsada1(salto) 
{ 
	var f = document.FrmRetalla;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
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
<input type="hidden" name="Fecha" value='<?php echo $Ano."-".$Mes."-".$Dia;?>'>
  <table width="527" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="515"><table width="513" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center" class="TituloCabeceraAzul"><strong>Valores Barras</strong></div></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">N&deg; Barras</td>
            <td width="148" class="formulario">:<?php echo $B.$A ?></td>
			<td width="112" class="titulo_azul">Peso Neto Barra</td>
            <td width="123" class="formulario"><?php echo $PesoNBarra;    ?></td>
          </tr>
          <tr> 
            <td width="103" class="titulo_azul">Peso Neto Caja</td>
            <td>: 
              <input name="PesoNeto" type="text" onKeyDown="SoloNumeros(true,this)" id="PesoNeto" value="<?php  echo number_format($PesoNeto,2,',','.') ?>"> 
            </td>
            <td class="titulo_azul">Peso Bruto Caja</td>
            <td><input name="PesoBruto" type="text" onKeyDown="SoloNumeros(true,this)" id="PesoBruto" value="<?php  echo number_format($PesoBruto,2,',','.'); ?>"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Valor Dec</td>
            <td>:
              <input name="Valor" type="text" onKeyDown="SoloNumeros(true,this)" id="Valor" value="<?php  echo number_format($Valor,2,',','.')?>"></td>
            <td class="titulo_azul">N&deg; Sello</td>
            <td><input name="Sello" type="text" id="Sello" value="<?php  echo $Sello ?>"></td>
          </tr>
        </table>
        <br>
        <table width="512" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="185"><div align="right"> 
                <?php
			  //if ($Mostrar=='S')
			//	{
					echo "<input name='BtnOk' id='BtnOk'  type='button' style='width:50'  value='OK' onClick=\"Grabar('$AuxBarras','$Ano','$Mes','$Dia')\"; >";
			//	}
				?>
              </div></td>
            <td width="11">&nbsp;</td>
            <td width="295"><input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
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
if ($Mensaje=="S")
{
	echo "var Frm=document.FrmRetalla;";
	echo "alert('Los Valores de las Electrolisis son diferentes  ');";
	echo "Frm.PesoNeto.focus();";	
}

/*if ($Mostrar=='N')
{
	echo "var Frm=document.FrmRetalla;";
	echo "alert('Ya sean ingresados Valores Para esta Barra  ');";
	echo "Frm.PesoNeto.focus();";	
}*/
echo "</script>";
?>
