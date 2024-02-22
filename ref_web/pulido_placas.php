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
function Validar(fecha,turno,cod_operacion)
{
	var frm = document.FrmPrincipal;
    variable = "Ing_pulido_placas01.php?fecha=" + fecha + "&Proceso=E" + "&turno=" + turno+"&cod_operacion="+cod_operacion;
	frm.action = variable;
	frm.submit();
}
function Modificar(fecha,turno)
{
	var frm = document.FrmPrincipal;
    variable = "Ing_pulido_placas.php?fecha=" + fecha + "&Proceso=M" + "&turno=" + turno;
	frm.action = variable;
	frm.submit();
}
function Imprimir()
{
	window.print();
}
//-->
</script>
<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
  <TABLE width="48%" align="center" cellPadding=0 cellSpacing=0 class="cm or">
    <TBODY>
     <TR vAlign=top  class=dt> 
        <TD colspan="5" vAlign=bottom> <H4><B>PULIDO PLACAS&nbsp;-&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?>&nbsp;-&nbsp;TURNO A</B></H4></TD>
        <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	    ?>
      </TR>
      <TR vAlign=top> 
        <TD  colSpan=6   bgcolor="#FF9933">
          <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TBODY>
              <TR class=lcolor> 
                <TD width="10%" height=24><div align="center"><b>#</b></div></TD>
                <TD width="40%" height=24><div align="center"><b>OPERACION</b></font></div></TD>
                <TD width="20%" height=24><div align="center"><b>PLACAS NEGRAS</b></font></div></TD>
                <TD width="20%" height="24"><div align="center"><b>PLACAS CON PERNOS</b></div></TD>
                <TD colspan="2" width="10%" height="24"><div align="center">&nbsp;</div></TD>
              </TR>
              <?php
                $turno="A";
                $veces=0;
				$sql1 = "select * from ref_web.pulido_placas where FECHA ='$fecha' AND TURNO='A' ORDER BY COD_OPERACION ASC";
                $result1=mysqli_query($link, $sql1);
                while($row1 = mysqli_fetch_array($result1))
                {    
                 $i++;
				 $cod_operacion= $row1['COD_OPERACION'];
                 $negras= $row1['PLACAS_NEGRAS'];
                 $pernos= $row1['PLACAS_PERNOS'];
                 if($cod_operacion==1){$operacion="ARMAN";}
                 if($cod_operacion==2){$operacion="CAMBIAN";}
                 if($cod_operacion==3){$operacion="STOCK";}
                   echo'<TR class=lcolor> ';
                     echo'<TD ><div align="center"><B>'.$i.'</B></div></TD>';
                     echo'<TD ><div align="left"><B>'.$operacion.'</B></div></TD>';
                     echo'<TD ><div align="center"><B>'.$negras.'</B></div></TD>';
                     echo'<TD ><div align="center"><B>'.$pernos.'</B></div></TD>';
                     echo"<TD ><div align='center'><a href=JavaScript:Validar(".$fecha.",'A',".$cod_operacion.");  ><img border=0 src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";
                     echo"<TD ><div align='center'><a href=JavaScript:Modificar(".$fecha.",'A',".$cod_operacion.");><img border=0 src='archivos/modificar.gif' width='15' height='15'></A></div></TD>";
                  echo'</TR>';
                  $veces=1;
                 }
                 if($veces==0)
                 {
                   echo'<TR class=lcolor> ';
                     echo'<TD colspan=6 height=50><div align="center"><B>NO HAY REGISTROS PARA ESTA FECHA</B></div></TD>';
                   echo'</TR>';
				 }
                ?>
              <TR class=lcolor> 
                <TD colspan="6" width="100%" height=24>&nbsp;</TD>
              </TR>
             <TR vAlign=top  class=dt> 
                <TD colspan="6" vAlign=bottom> <H4><B>PULIDO PLACAS&nbsp;-&nbsp;<?phpphp echo $fecha; ?>&nbsp;-&nbsp;TURNO B</B></H4>
                  <div align="right"></div></TD>
             </TR>
              <TR class=lcolor> 
                <TD width="10%" height=24><div align="center"><b>#</b></div></TD>
                <TD width="40%" height=24><div align="center"><b>OPERACION</b></font></div></TD>
                <TD width="20%" height=24><div align="center"><b>PLACAS NEGRAS</b></font></div></TD>
                <TD width="20%" height="24"><div align="center"><b>PLACAS CON PERNOS</b></div></TD>
                <TD colspan="2" width="10%" height="24"><div align="center">&nbsp;</div></TD>
              </TR>
               <?phpphp
                $turno="B";
                $veces1=0;
				$sql1 = "select * from ref_web.pulido_placas where FECHA ='$fecha' AND TURNO='B'  ORDER BY COD_OPERACION ASC";
                $result1=mysqli_query($link, $sql1);
                while($row1 = mysqli_fetch_array($result1))
                {    
                 $i++;
				 $cod_operacion= $row1['COD_OPERACION'];
                 $negras= $row1['PLACAS_NEGRAS'];
                 $pernos= $row1['PLACAS_PERNOS'];
                 if($cod_operacion==1){$operacion="ARMAN";}
                 if($cod_operacion==2){$operacion="CAMBIAN";}
                 if($cod_operacion==3){$operacion="STOCK";}
                   echo'<TR class=lcolor> ';
                     echo'<TD ><div align="center"><B>'.$i.'</B></div></TD>';
                     echo'<TD ><div align="left"><B>'.$operacion.'</B></div></TD>';
                     echo'<TD ><div align="center"><B>'.$negras.'</B></div></TD>';
                     echo'<TD ><div align="center"><B>'.$pernos.'</B></div></TD>';
                     echo"<TD ><div align='center'><a href=JavaScript:Validar(".$fecha.",'B',".$cod_operacion.");  ><img border=0 src='archivos/papelera.gif' width='15' height='15'></A></div></TD>";
                     echo"<TD ><div align='center'><a href=JavaScript:Modificar(".$fecha.",'B',".$cod_operacion.");><img border=0 src='archivos/modificar.gif' width='15' height='15'></A></div></TD>";
                  echo'</TR>';
                  $veces1=1;
                 }
                 if($veces1==0)
                 {
                   echo'<TR class=lcolor> ';
                     echo'<TD colspan=6 height=50><div align="center"><B>NO HAY REGISTROS PARA ESTA FECHA</B></div></TD>';
                   echo'</TR>';
				 }
			  ?>
            </TBODY>
          </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>
<br>
<br>
</FORM>
</BODY>
</HTML>
