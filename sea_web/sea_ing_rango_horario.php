<?php 
  	include("../principal/conectar_sea_web.php");
  	include("funciones.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 59;

	if(isset($_REQUEST["g"])) {
		$g = $_REQUEST["g"];
	}else{
		$g =  "";
	}
	if(isset($_REQUEST["v_"])) {
		$v_ = $_REQUEST["v_"];
	}else{
		$v_ =  "";
	}
	
if($g=='S')
{
	$Actualiza="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1=0 where cod_clase='2018'";
	mysqli_query($link, $Actualiza);

	$Actualiza="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='S' where cod_clase='2018' and cod_subclase='".$v_."'";
	mysqli_query($link, $Actualiza);

	$Msj='Mod';
}	

$Consulta="SELECT valor1,valor2 from proyecto_modernizacion.clase where cod_clase='2018'";
$R=mysqli_query($link, $Consulta);$AnosAnt=1;
$F=mysqli_fetch_assoc($R);
$Dat1=explode(':',$F["valor1"]);	
$Hor=$Dat1[0];		
//$Min=$Dat1[1];	
$Min2=isset($Dat1[1]) ? $Dat1[1]:"0";	//WSO

$Dat2=explode(':',$F["valor2"]);
$Hor2=$Dat2[0];	
//$Min=$Dat2[1];	
$Min2=isset($Dat2[1]) ? $Dat2[1]:"0";	 //WSO
	
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(Opc)
{
	var f=document.frm1;
	switch(Opc)
	{
		case "G":
			for(i=0;i<f.elements.length;i++)
			{
				if(f.elements[i].name=='ChkRadio' && f.elements[i].checked==true)
					var valor =	f.elements[i].value;
			}
			f.action = "sea_ing_rango_horario.php?g=S&v_="+valor;		
			f.submit();	
		break;	
		case "Mod":
			alert('<?php echo utf8_decode("Dato Modificado con �xito");?>')
		break;
	}
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30"
}
</script>
</head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="Proceso('<?php echo $Msj;?>')">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> <br /><br />
        <table width="300" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td colspan="4" align="center" class="ColorTabla01">Seleccionar Periodo del D�a</td>
          </tr>
          <?php
          $Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='2018'";
		  $R=mysqli_query($link, $Consulta);
		  while($F=mysqli_fetch_assoc($R))
		  {
			  $Checked='';
			  if($F["valor_subclase1"]=='S')
			  	$Checked='checked=checked';
				?>
                <tr>
                	<td width="26" align="right"><input type="radio" name="ChkRadio" <?php echo $Checked;?> value="<?php echo $F["cod_subclase"];?>"></td>
					<td width="121"><?php echo $F["nombre_subclase"];?></td>
					<td width="132"><?php echo $F["valor_subclase2"]."  -  ".$F["valor_subclase3"];?></td>
                </tr>
                <?php  
		  }
		  ?>
        </table>
        <br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="BtnCansultar2" type="button" value="Guardar" onClick="JavaScritp:Proceso('G')" style="width:70px">
            <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
