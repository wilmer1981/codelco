<?php
include("../principal/conectar_principal.php");
$Consulta="select * from pmn_web.carga_fusion_oro where num_electrolisis = '".$Elect."' ";
$Consulta.=" and fecha= '".$Fecha."' and correlativo = '".$Corr."' and sobrante ='".$Sobrante."' ";
//echo $Consulta."<br>";
$Respuesta=mysqli_query($link, $Consulta);
if ($Fila=mysqli_fetch_array($Respuesta))
{
	$TxtPesoSob=$Fila[peso_sobrante];
	if ($Fila[sobrante]=="S")
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
	$Consulta.="	where num_electrolisis='".$Elect."' and fecha='".$Fecha."' and sobrante='S' ";
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
	if (frm.TxtPesoSob.value=="") 
	{
		alert("Debe Ingresar Peso Sobrante");
		frm.TxtPesoSob.focus();
		return;
	}
	//Fecha=frm.Ano.value + '-' + frm.Mes.value + '-' + frm.Dia.value;
	frm.action="pmn_carga_fusion_oro01.php?Elect="+E + "&Corr="+C +"&Barra="+B + "&Fe="+F + "&PesoS="+frm.TxtPesoSob.value + "&Proceso=Sobrante";
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
            <td colspan="4"><div align="center" class="TituloCabeceraAzul">Ingreso Valor Sobrante</div></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">N&deg;ELEC</td>
            <td width="132" class="formulario">:<?php echo $Elect;    ?></td>
            <td width="41" class="titulo_azul">N&deg;Barra</td>
            <td width="171" class="formulario">:<?php echo $Barra;?></td>
          </tr>
          <tr> 
		    <td width="67" class="titulo_azul">Peso Sob</td>
            <td>:
              <input name="TxtPesoSob" type="text" onKeyDown="SoloNumeros(true,this)" id="TxtPesoSob" value="<?php  echo number_format($TxtPesoSob,4,',','.'); ?>"> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="439" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
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
	echo "alert('Ya existe un sobrante para esta electrolisis ');";
	
}
echo "</script>";
?>
