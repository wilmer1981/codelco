<?php
include("../principal/conectar_principal.php");

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
function Grabar(Acta,A,M,D)//Barras,Fecha del dia
{
	var frm =document.FrmRetalla;	 
	if (frm.NumActa.value=="") 
	{
		alert("Debe Ingresar numero de acta");
		frm.NumActa.focus();
		return;
	}
	frm.action="pmn_embarque_barras_oro01.php?Acta="+Acta +"&Dia="+D +"&Ano="+A +"&Mes="+M+"&Proceso=Acta";
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
  <table width="527" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="515"><table width="513" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2"><div align="center" class="TituloCabeceraAzul"><strong>Valores Acta</strong></div></td>
          </tr>
          <tr> 
            <td width="64" class="titulo_azul">Num Acta</td>
            <td width="434">
			<?php
			$Consulta="select distinct num_acta from pmn_web.embarque_oro        ";
			$Consulta.=" where  fecha = '".$Ano."-".$Mes."-".$Dia."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$NumActa=$Fila[num_acta];
			?>
			<input name="NumActa" type="text" id="NumActa" value="<?php  echo $NumActa;  ?>"></td>
          </tr>
        </table>
        <br>
        <table width="512" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="185"><div align="right">
				<?php
			  //if ($Mostrar=='S')
			//	{
					echo "<input name='BtnOk' type='button' style='width:50'  value='OK' onClick=\"Grabar('$NumActa','$Ano','$Mes','$Dia')\"; >";
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
