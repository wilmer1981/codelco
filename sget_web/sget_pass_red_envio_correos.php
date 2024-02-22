<?
 set_time_limit(3000);
 $CodigoDeSistema = 30;
 $CodigoDePantalla = 1;
 include("../principal/conectar_sget_web.php");
  include("funciones/sget_funciones.php");
?>
<html>
<head>
<title>Envios de Correos</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	
	switch(TipoProceso)
	{
		case 'G'://GRABAR
			f.action="sget_pass_red_envio_correos01.php";
			f.submit();
			break;				
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
			f.submit();
			break;
	}
	
}
function Mensaje(Msj)
{
	if(Msj=='S')
		alert('Datos Actualizados con Exito');
	return;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body onLoad="Mensaje('<? echo $Msj;?>')">
<form name="frmPrincipal" action="" method="post">
<? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271" class="titulo_cafe_bold_chica">Envios de Correos&nbsp;</td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
<table width="950"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%"  cellspacing="0">
      <tr>
                  <td width="4%" class="formulario2">Cuenta</td>
        <td width="48%" class="formulario2"><input type="text" size="50" name="TxtCuenta"></td>
        <td width="26%" class="formulario2">Contrase&ntilde;a de Red &nbsp;&nbsp; 
          <input type="text" name="TxtPass"></td>
        <td width="2%" class="formulario2">&nbsp;</td>
        <td width="17%" align="right" class="formulario2"><a href="JavaScript:Procesos('G')"><img src="archivos/btn_guardar.png" alt="Guardar" border="0"></a>&nbsp;</td>
        <td width="3%" align="right" class="formulario2">&nbsp; <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
        <? 
		if($Check=='S')
		{	
			$checked='checked';
		 	$disabled="";
		}
		else
		{	
			$checked="";
			$disabled="";
		 }
		//  echo "QQQQQ".$TxtBuscaEmp;
		  ?>
      </tr>
    </table></td>
    <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>  
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
</table><br></td>
 </tr>
</table>
 </td>
    </tr>
  </table>
	<? include("pie_pagina.php")?>
</form>
</body>
</html>

