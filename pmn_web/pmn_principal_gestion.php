<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					
?>
<html>
<head>
<title>Acceso Principal PMN</title>
<script language="JavaScript">
function Salir()
{
var f=document.frmPrincipalConsulta;
f.action='pmn_principal.php';
f.submit();
}
function Pantalla(Pant)
{
var f=document.frmPrincipalConsulta;
f.action=Pant;
f.submit();
}
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<form name="frmPrincipalConsulta" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="center"  bgcolor="#F7F2EB" class="formulario" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><script type="text/javascript">
			function showPage(Pant)
			{
				//var f=document.frmPrincipalRpt;
				//alert(Pant);				
			   document.getElementById("A1").style.display = "none";
			   document.getElementById("B2").style.display = "none";
			   document.getElementById("C3").style.display = "none";
		       document.getElementById("D4").style.display = "none";
			   document.getElementById("E5").style.display = "none";
			   document.getElementById("F6").style.display = "none";
			   document.getElementById("G7").style.display = "none";
			   document.getElementById("H8").style.display = "none";
			   document.getElementById("I9").style.display = "none";			   
			   document.getElementById("J10").style.display = "none";			   
			   document.getElementById(Pant).style.display = "block"; 
			}				
		</script>
		 GESTI&Oacute;N - PLAMEN </td>
      <td width="4%" align="right" bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><a href="JavaScript:Salir('')" class="LinkPestana" ><img src="archivos/btn_volver2.png" class="SinBorde"/></a><a href="JavaScript:SalirRpt('')" class="LinkPestana" ></a></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" bgcolor="#F7F2EB">
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" ><img src="archivos/images/interior/transparent.gif" width="4" /></td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5" rowspan="4" align="center" valign="top">
			<?php
			   $CodNivel=Nivel($CookieRut);	
			   $ConsultaP="select * from proyecto_modernizacion.acceso_menu where cod_sistema='6' and cod_pant_agrup='151' and nivel='".$CodNivel."' order by cod_pantalla";
			   //echo $ConsultaP."<br>";
			   $RespP=mysqli_query($link, $ConsultaP);
			   while($FilaP=mysqli_fetch_array($RespP))
			   {
				   $Consulta="select *,link as links from proyecto_modernizacion.pantallas where cod_pantalla='".$FilaP[cod_pantalla]."' and cod_sistema='6'";
				   //echo $Consulta."<br>";
				   $Resp=mysqli_query($link, $Consulta);
				   while($Fila=mysqli_fetch_array($Resp))
				   {
					$Pant=substr($Fila[links],11);
					?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="TituloCabeceraOz">
                  <tr>
                    <td colspan="4" align="left"><a href="JavaScript:Pantalla('<?php echo $Pant;?>')" class="LinkPestana" ><font style="font-size:12px;"><?php echo $Fila["descripcion"];?></font></a></td>
                  </tr>
                </table>
              <?php			   	
				   }			   		
			   }	  
			  ?>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td background="archivos/images/interior/derecho.png">&nbsp;</td>
          </tr>
          <tr>
            <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
            <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
            <td width="18"><img src="archivos/images/interior/esq4.png"></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br>
  
  
</form>
</body>
</html>
