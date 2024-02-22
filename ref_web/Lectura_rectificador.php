<?php include("../principal/conectar_ref_web.php");    
   $ano1=substr($fecha,0,4);
   $mes1=substr($fecha,5,2);
   $dia1=substr($fecha,8,2)
?>


<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
/*function Validar(fecha,turno,cod_operacion)
{
	var frm = document.FrmPrincipal;
    variable = "lectura_rectificador_proceso.php?fecha="+fecha+"&opcion=B";
	frm.action = variable;
	frm.submit();
}*/
function Modificar(fecha,turno)
{
	var frm = document.FrmPrincipal;
    variable = "lectura_rectificador_proceso.php?fecha="+fecha+"&opcion=B";
	frm.action = variable;
	frm.submit();
}
//-->
</script>
<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
  <TABLE width="48%" align="center" cellPadding=0 cellSpacing=0 class="cm or">
    <TBODY>
     <TR vAlign=top  class=dt> 
        <TD colspan="5" vAlign=bottom> <H4><B>Lectura Rectificador 1 a las 5 AM&nbsp;-&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?>&nbsp;</B></H4></TD>
        <TD  width="14%" vAlign=bottom><div align="right"><img src="archivos/imprimir.gif" width="26" height="18"></div></TD>
      </TR>
      <TR vAlign=top> 
        <TD  colSpan=6   bgcolor="#FF9933">
          <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TBODY>
            <TR class=lcolor> 
              <TD height=17><div align="center">K.A.H. REC-1</div>
                </TD>
              <TD height=17><div align="center">PROM K.A</div>
                <div align="center"></div></TD>
            </TR>
            <?php
			   $consulta="select lectura_rectificador from ref_web.detalle_produccion where fecha='".$fecha."'";
  			   $respuesta=mysqli_query($link, $consulta);
			   $row = mysqli_fetch_array($respuesta);
 			   $sql="SELECT  SUBDATE('".$fecha."',INTERVAL '1' DAY) as fecha_ant";
			   $result=mysqli_query($link, $sql);
			   $row3 = mysqli_fetch_array($result);
			   $consulta2="select lectura_rectificador from ref_web.detalle_produccion where fecha='".$row3[fecha_ant]."'";
			   $respuesta2=mysqli_query($link, $consulta2);
			   $row2 = mysqli_fetch_array($respuesta2);
			   echo'<TR class=lcolor> ';
                    echo'<TD ><div align="center"><B>'.$row[lectura_rectificador].'</B></div></TD>';
					 $promedio=number_format((($row[lectura_rectificador]-$row2[lectura_rectificador])/24),"2",".","");
                    echo'<TD ><div align="center"><B>'.$promedio.'</B></div></TD>';                     
                     /*echo"<TD ><div align='center'><a href=JavaScript:Validar(".$fecha.");  ><img border=0 src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";*/
                     echo"<TD ><div align='center'><a href=JavaScript:Modificar(".$fecha.");><img border=0 src='archivos/modificar.gif' width='15' height='15'></A></div></TD>";
               echo'</TR>';

            ?>
        </TABLE>
<br>
<br>
</FORM>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
				
		echo '</script>';
	}
?>
</BODY>
</HTML>
