<?php
include("../principal/conectar_principal.php");

if(isset($_REQUEST["ValoresSA"])) {
	$ValoresSA = $_REQUEST["ValoresSA"];
}else{
	$ValoresSA = "";
}
if(isset($_REQUEST["Rut"])) {
	$Rut = $_REQUEST["Rut"];
}else{
	$Rut = "";
}
if(isset($_REQUEST["SA"])) {
	$SA = $_REQUEST["SA"];
}else{
	$SA = "";
}
if(isset($_REQUEST["Rec"])) {
	$Rec = $_REQUEST["Rec"];
}else{
	$Rec = "";
}
if(isset($_REQUEST["TxtValor"])) {
	$TxtValor = $_REQUEST["TxtValor"];
}else{
	$TxtValor = "";
}

$Recargo = isset($_REQUEST["Recargo"])?$_REQUEST["Recargo"]:"";

for ($j = 0;$j <= strlen($ValoresSA); $j++)
{
	if (substr($ValoresSA,$j,2) == "//")
		{
			$SARutRec = substr($ValoresSA,0,$j);
			for ($x=0;$x<=strlen($SARutRec);$x++)
			{
				if (substr($SARutRec,$x,2) == "~~")
				{
					$SA = substr($SARutRec,0,$x);			
					$RutRec = substr($SARutRec,$x+2,strlen($SARutRec));
					for ($y = 0 ; $y <=strlen($RutRec); $y++ )
					{
						if (substr($RutRec,$y,2)=="||")
						{
							$Rut = substr($RutRec,0,$y);
							$Recargo =substr($RutRec,$y+2,strlen($RutRec));
						}
					}
				}
			$ValoresSA = substr($ValoresSA,$j + 2);
		$j = 0;
			}
		}
}				
?>
<html>
<head>
<title>Ingreso Valor Retalla</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmRetalla;
	var teclaCodigo = event.keyCode; 

	if (teclaCodigo == 13)
	{
		Frm.BtnOk.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((Frm.TxtValor.value.substr(Frm.TxtValor.value.length-1,1)==",")||(Frm.TxtValor.value.substr(Frm.TxtValor.value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}
		}
	}	
} 
function Grabar(Rut,SA,Rec)
{
	var frm =document.FrmRetalla;	 
	 if ((frm.TxtValor.value=="") && (frm.TxtValor.value <=0))
	{
		alert("Debe Ingresar Valor Retalla");
		frm.TxtValor.focus();
		return;
	}
	frm.action="cal_retalla01.php?Rut="+ Rut + "&SA="+ SA + "&Rec="+ Rec;
	frm.submit(); 
}
function MostrarLeyes(Sol,Recargo)
{
	
	var Frm=document.FrmSolicitud;
	window.open("cal_leyes_por_solicitud_retalla.php?Sol="+Sol+"&Rec="+Recargo +"&Opcion=3",""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}	
function Salir()
{
	var frm =document.FrmRetalla;	 
	frm.action="cal_leyes_por_solicitud_retalla01.php?Opcion=5";
	frm.submit(); 
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif" onLoad="document.FrmRetalla.TxtValor.focus();">
<form name="FrmRetalla" method="post" action="">
  <table width="400" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="400"><table width="400" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2"><div align="center">Ingreso Valor Retalla</div></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <?php
			$Consulta= "select nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios " ;
			$Consulta= $Consulta." where rut = '".$Rut."'";			
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			$RutFunc = $Fila["nombres"].' '.$Fila["apellido_paterno"].' '.$Fila["apellido_materno"];
			?>
			
			
			
			<td>Originador</td>
            <td>:<?php echo $RutFunc;    ?></td>
          </tr>
          <tr> 
            <td width="78">N&deg; Solicitud</td>
            <td width="307">:<?php echo $SA;?></td>
          </tr>
          <tr> 
           <?php
		   if (($Recargo=='0')||($Recargo=='N'))
		   {
		   		$Rec='R';
		   }
		   ?>
		   
		    <td>Recargo</td>
            <td> :<?php echo $Rec;?></td>
          </tr>
          <tr> 
            <td height="32">
<div align="left">Peso Muestra</div></td>
            <td>:
<?php
		//Consulta que devuelve 
		$Consulta = "select nro_solicitud,recargo,peso_muestra from cal_web.solicitud_analisis where nro_solicitud = '".$SA."'";
		$Respuesta2= mysqli_query($link, $Consulta);
		while ($Fila2=mysqli_fetch_array($Respuesta2))
		{
			if ($Fila2["recargo"]=='R')
			{
				$TxtValor = str_replace(".",",",$Fila2["peso_muestra"]);

			}
		}
?>
              <input name="TxtValor" type="text" id="TxtValor" onKeyDown="TeclaPulsada()" value="<?php echo $TxtValor ?>"  ></td>
          </tr>
        </table>
        <br>
        <table width="400" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="177"><div align="right">

			    <input name="BtnOk" type="button" style="width:50"  id="BtnOk" value="OK" onClick="Grabar('<?php echo $Rut;?>','<?php echo $SA; ?>','<?php echo $Rec; ?>')" >
																									
              </div></td>
            <td width="10">&nbsp;</td>
            <td width="191"><input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
			<?php
				if ($TxtValor!="")
				{
					echo "<input name='BtnLeyes' type='Button' value='Leyes' style='width:50' onClick=\"MostrarLeyes('$SA','R');\">";
				}
			?>
			</td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
