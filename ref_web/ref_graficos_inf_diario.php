<?php 	
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	$mostrar='S';

  $fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
  $dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");


?>
<html>
<head>
<script language="JavaScript">

/*****************/
function Salir()
{
	var f=document.FrmIngCircuito;
	ano1 =f.ano1.value;
	mes1 =f.mes1.value;
	dia1 =f.dia1.value;
	
	document.location = "../ref_web/turno_a.php?mes1="+mes1+"&dia1="+dia1+"&mostrar=S&ano1="+ano1;
	
	//document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
</script>
<title>Ingreso Circuito Electrolitico</title>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCircuito" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <TABLE cellSpacing=0 cellPadding=0 width="769" border=0>
    <TBODY>
    <TR vAlign=bottom> 
     <TD>
          <TBODY>
            <TR> 
			
			<?php 
				echo "<input name='ano1' type='hidden' value='".$ano1."'>";
				echo "<input name='mes1' type='hidden' value='".$mes1."'>";
				echo "<input name='dia1' type='hidden' value='".$dia1."'>";
			?>
             <TD width="126"   class=tabsoff      align=middle><IMG height=40 alt=""  src="archivos/tab-front_off.gif" width=52 border=0></TD>
              <?php echo '<TD width="175"  class=tabsoffline align=middle><B><A class=tabstext href="turno_a.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'">Produccion</A></B></TD>'; ?>
              <TD width="53"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
                  <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="turno_b.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.' "><B>Leyes</B></A></TD>'; ?>
			  
              <TD width="165"   class=tabsline 	 align=middle><SPAN class=dMSNME_1></SPAN></TD>
			   <TD width="53"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
               <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.' "><B>Informe 
                   Completo </B></A></TD>'; ?>
              
			    <TD width="53"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tab-mid_on1.gif" width=22 border=0></TD>
			  <TD width="290"  class=tabsonline align=middle><B class=tabstext>Graficos</B></TD>
			   <TD width="10"   class=tabsoff     align=middle> <IMG height=40 alt="" src="archivos/tab-end_on.gif" width=10 border=0></TD>
               <?php echo '<TD width="600%" class=tabsline    align=center><B><A style="COLOR: #ffffff" href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'" target=_top><SPAN style="COLOR: #ffffcc"><font size="4">
                  </font></SPAN></A></B></TD>'; ?>
            </TR>
          </TBODY>
  </TBODY>
  </table>
  <table width="770" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center">
	  <br>
	  <table width="700" border="4" class="tablainterior">
	  <?php echo "<img src='ejemplo_grafico.php?ano=".$ano1."&mes=".$mes1."&dia=".$dia1."&fecha=".$fecha."'>"; ?>
	  </table>
	  <table width="700" border="4" class="tablainterior">
	  <?php echo "<img src='Grafico2.php?ano=".$ano1."&mes=".$mes1."&dia=".$dia1."&fecha=".$fecha."'>"; ?>
       </table>
	   <table width="700" border="4" class="tablainterior">
	  <?php echo "<img src='Grafico3.php?ano=".$ano1."&mes=".$mes1."&dia=".$dia1."&fecha=".$fecha."'>"; ?>
       </table>
      <br>
      <table width="480" border="0" class="tablainterior">
          <tr> 
            <td align="right" width="214">&nbsp; </td>
            <td align="left" width="253"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="JavaScript:Salir()"></td>
          </tr>
        </table><br></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>

