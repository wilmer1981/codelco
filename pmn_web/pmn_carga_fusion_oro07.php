<?php
include("../principal/conectar_principal.php");
//echo "muestra".$Muestra."<br>";
$Consulta="select * from pmn_web.carga_fusion_oro where  ";
$Consulta.=" fecha= '".$Fecha."' and correlativo = '".$Corr."' and muestra ='".$Muestra."' ";
$Respuesta=mysqli_query($link, $Consulta);
if ($Fila=mysqli_fetch_array($Respuesta))
{
	$TxtMtra=$Fila[mtra];
	if ($Muestra=="S")
	{
		$Ver='N';
		$Mostrar="S";
	}
	else
	{
		$Ver='S';
		$Mostrar='S';
	}
}
if ($Ver=='S')
{
	$Consulta="select count(num_electrolisis) as cantidad from pmn_web.carga_fusion_oro  ";
	$Consulta.="	where correlativo='".$Corr."' and fecha='".$Fecha."' and muestra='S' ";
	$Respuesta1=mysqli_query($link, $Consulta);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Cantidad=$Fila1[cantidad];
	if ($Cantidad >=1)
	{
		$Mostrar='N';
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
function Grabar(E,B,F,C)//Electrolisis,Barra,Fecha del dia
{
	var frm =document.FrmRetalla;	 
	if (frm.TxtMtra.value=="") 
	{
		alert("Debe Ingresar Mtra");
		frm.TxtMtra.focus();
		return;
	}
	//Fecha=frm.Ano.value + '-' + frm.Mes.value + '-' + frm.Dia.value;
	frm.action="pmn_carga_fusion_oro01.php?Corr="+C +"&Barra="+B + "&Fe="+F + "&Mtra="+frm.TxtMtra.value  + "&Proceso=Muestra2";
	frm.submit(); 
}
function Salir()
{
	var frm =document.FrmRetalla;	 
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="FrmRetalla" method="post" action="">
  <table width="474" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="462"><table width="460" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center" class="TituloCabeceraAzul">Ingreso Valores</div></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">N&deg;Barra</td>
            <td class="formulario">:<?php echo $Barra;?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul"><strong>CATODOS</strong></td>
            <td width="139">&nbsp;</td>
            <td width="81">&nbsp;</td>
            <td width="131">&nbsp;</td>
          </tr>
          <tr> 
            <td width="82" class="titulo_azul">Mtra</td>
            <td>: 
              <input name="TxtMtra" type="text" onKeyDown="TeclaPulsada()" id="TxtMtra" value="<?php  echo $TxtMtra;?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="459" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="185"><div align="right">
				<?php
			    if ($Mostrar=='S')
				{
					echo "<input name='BtnOk' type='button' style='width:50'  value='OK' onClick=\"Grabar('$Elect','$Barra','$Fecha','$Corr')\"; >";
				}
				?>																					
              </div></td>
            <td width="11">&nbsp;</td>
            <td width="242"> 
              <input name="BtnSalir" style="width:50" type="button" id="BtnSalir2" value="Salir" onClick="Salir();"> 
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
	echo "alert('Ya existe una muestra para esta electrolisis ');";
	
}
echo "</script>";
?>