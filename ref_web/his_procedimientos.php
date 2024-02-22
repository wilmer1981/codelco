<?php include("../principal/conectar_sec_web.php"); 

$carpeta="archivos/";

if(!isset($ingreso)){$ingreso="Todos";} ?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<script language="JavaScript">
<!--
function Proceso(opcion)
{
	 var frm = document.FrmPrincipal;

			frm.action = "his_procedimientos.php";
			frm.submit();

}
function Imprimir()
{
	window.print();
}
</script>

<body>
  <TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
    <TBODY>
      <TR  vAlign=top  class=dt> 
        <TD vAlign=bottom> <H4><B>BUSCAR HISTORIA PROCEDIMIENTOS</B></H4></TD>
       <?php 
         echo'<TD width="14%" ><div align="right">';
         echo "<a href=\"JavaScript:Imprimir()\">";
         echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>'; 
       ?>
      </TR>
      <TR  vAlign=top  class=dt> 
        <TD width="45%" vAlign=bottom colspan=2> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
            <TBODY>
              <TR> 
                <TD align=middle width="100%"> <TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0>
                    <TBODY>
                      <TR bgcolor="#FFFFFF"> 
                        <TD width="1" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <TD width="722" align="center">
                            <TABLE height="100%" cellSpacing=0 cellPadding=0    align="center" width="100%" border=0>
                            <TBODY>
                              <TR> 
                                <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
                              </TR>
                              <TR> 
                                <TD> 
								   <TABLE cellSpacing=0 cellPadding=0 width="92%" border=0>
                                    <TBODY>
                                      <TR> 
                                        <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7  bord er=0></TD>
                                        <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                                        <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
                                      </TR>
                                      <TR> 
                                        <TD width="100%" colSpan=3>
                                        <FORM action="" method=post name=FrmPrincipal id="FrmPrincipal">
                                          <TABLE width="100%" height="59"  border=0 cellPadding=0  cellSpacing=0 style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid">
                                            <TBODY>
                                              <TR> 
                                                <TD width="1%" rowspan="3">&nbsp; </TD>
                                                <TD width="17%"><input type=radio value="1" name=ingreso   <?php if($ingreso=="1"){echo'checked';} ?>  > 
                                                  <FONT style="FONT-WEIGHT: bold; COLOR: #000000">CIRCULACION</font></TD>
                                                <TD width="20%"><input type=radio value="4" name=ingreso   <?php if($ingreso=="4"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">HOJAS 
                                                  MADRES</font> 
                                                <TD width="22%"><input type=radio value="7" name=ingreso   <?php if($ingreso=="7"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">RECTIFICADORES</font> 
                                                <TD width="19%"><input type=radio value="10" name=ingreso   <?php if($ingreso=="10"){echo'checked';} ?>  >
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">R. 
                                                  HUMANOS</font>
                                                <TD colspan="3" rowspan="3"><input type=radio value="Todos" name=ingreso <?php if($ingreso=="Todos"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">Todo</font> 
                                                <TD width="12%" rowspan="3"><div align="right"><b><font face="Arial, Helvetica, sans-serif"> 
                                                    <INPUT type=submit value=Buscar onClick="JavaScript:Proceso('G')">
                                                    </font></b><IMG height=8 src="archivos/spaceit.gif" width=10 border=0><b><font face="Arial, Helvetica, sans-serif"></font></b></div></TD>
                                              </TR>
                                              <TR> 
                                                <TD><input type=radio value="2" name=ingreso   <?php if($ingreso=="2"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">RENOVACION</font></TD>
                                                <TD width="20%"><input type=radio value="5" name=ingreso   <?php if($ingreso=="5"){echo'checked';} ?>  >
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">P. 
                                                  TRATAMIENTO</font> 
                                                <TD width="22%"><input type=radio value="8" name=ingreso   <?php if($ingreso=="8"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">MANTENCION</font>
                                                <TD width="19%"><input type=radio value="11" name=ingreso   <?php if($ingreso=="11"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">SEGURIDAD</font></TR>
                                              <TR> 
                                                <TD><input type=radio value="3" name=ingreso   <?php if($ingreso=="3"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">INSPECCION</font> 
                                                </TD>
                                                <TD width="20%"><input type=radio value="6" name=ingreso   <?php if($ingreso=="6"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">VAPOR 
                                                  Y AIRE</font>
                                                <TD width="22%"><input type=radio value="9" name=ingreso   <?php if($ingreso=="9"){echo'checked';} ?>  > 
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">COSTOS</font> 
                                                <TD width="19%"><input type=radio value="12" name=ingreso   <?php if($ingreso=="12"){echo'checked';} ?>  >
                                                  <font style="FONT-WEIGHT: bold; COLOR: #000000">M. 
                                                  AMBIENTE</font> </TR>
                                            </TBODY>
                                          </TABLE>
                                         </FORM>
                                         </TD>
                                      </TR>
                                       <TR> 
                                        <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
                                        <TD vAlign=bottom> <IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                                        <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
                                      </TR>
                                  </TBODY>
                                  </TABLE>
                                 </TD>
                              </TR>
                              <TR> 
                                <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
                              </TR>

                            </TBODY>
                          </TABLE>
                            </TD>
                      </TR>
                    </TBODY>
                  </TABLE></TD>
              </TR>
            </TBODY>
          </TABLE></TD>
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=4 bgcolor="#ffffff"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TBODY>
            <TR class=lcol> 
              <TD width=1% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
              <TD width=11% ><div align="center"><font size="6"><strong>USUARIO</strong></font></div></TD>
			  <TD width=12% ><div align="center"><font size="6"><strong>TIPO DE PROCEDIMIENTO</strong></font></div></TD>
              <TD width=12% ><div align="center"><font size="6"><strong>DESDE</strong></font></div></TD>
              <TD width=12% ><div align="center"><font size="6"><strong>HASTA</strong></font></div></TD>
              <TD width="52%" ><div align="center"><font size="6"></font></div>
                <div align="left"><font size="6"><strong>OBSERVACION</strong></font></div></TD>
            </TR>
            <?php

     $color_i=0;
     if(!isset($page)){$page =1;}

     if($ingreso=="Todos")
	    {$sql = "select * from ref_web.procedimientos ORDER BY FECHA DESC";}
     else{$sql = "select * from ref_web.procedimientos WHERE COD_TIPO_PROCEDIMIENTO = '".$ingreso."' ORDER BY FECHA DESC";}
	$result=mysqli_query($link, $sql);
    $encontrados=1 ;
    $cantidad =1   ;
    $contador=0;
    while($row = mysqli_fetch_array($result))
    {
      $contador=$contador+1;
      if($contador >= 10*($page-1))
       {
        if($contador <= 10*$page)
        {
         $cantidad=$cantidad+1   ;
         $indice=$contador;
         if ( $j==1){$color= "lcol";$j=0;}else{$color= "lcolver";$j=1;} //color fila
         echo '<TR class='.$color.'>';
         echo '<TD align=center height=15>'.$row[COD_PROCEDIMIENTO].'</TD>';
		 echo '<TD align=center>'.$row[usuario].'</TD>';
		 $consulta="select * from ref_web.tipo_procedimientos where COD_TIPO_PROCEDIMIENTO='".$row[COD_TIPO_PROCEDIMIENTO]."'";
		 $resultado=mysqli_query($link, $consulta);
		 $row2 = mysqli_fetch_array($resultado);
		 echo '<TD align=center>'.$row2[TIPO_PROCEDIMIENTO].'</TD>';
         echo '<TD align=center>'.$row[DESDE].'</TD>';
         echo '<TD align=center>'.$row[HASTA].'</TD>';
         echo '<TD align=left>'.strtoupper($row[PROCEDIMIENTO]).'</TD>';
        }
      }
    }
echo ' </TR> ';
echo ' </TABLE> ';

?>
            <?php           
  					$sql="select * from ref_web.procedimientos";
  					$result=mysqli_query($link, $sql);
  					if($row = mysqli_fetch_array($result))
  					{
   					  $cuenta=0  ;
   					  while($row = mysqli_fetch_array($result))
     				  {
    				    $cuenta=$cuenta+1;
   					  }
                    }
                    $paginas=ceil(($contador/10)) ;
                    
                    echo '<TR>';
                     echo '<TD align=middle colSpan=3 >';
                      echo '<HR>'; 
                     echo '</TD>'; 
                    echo '</TR>';
                    echo '<TR>';
                      echo '<TD align=middle colSpan=3  bgcolor="#ffffff"> PAGINAS</TD>'; 
                    echo '</TR>';

                    echo '<TR>';
                      echo '<TD align=middle colSpan=3  bgcolor="#ffffff">'; 
                        if($page != 1) { echo'<A href="his_procedimientos.php?page='.($page - 1).'"><strong>&lt;&lt;&lt;</strong></A>&nbsp; &nbsp; &nbsp;'; }
 

                       $in = 1;
                        while($in <= $paginas)
                       {
                         if($in==$page)
                         {
                           echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT color=#0000FF><b>'.$in.'</b></FONT>&nbsp;&nbsp;&nbsp;';
                         }
                         else
                         {

                           echo '&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<A href="his_procedimientos.php?ingreso='.$ingreso.'&amp;page='.$in.'"><FONT class=tiny>'.$in.'</FONT></A>&nbsp;&nbsp;&nbsp;';

                           if($in==$paginas)
                           {
                             echo '&nbsp; &nbsp; &nbsp; <A href="his_procedimientos.php?page='.($page + 1).'">&gt;&gt;&gt;</A>';
                           }

                         }
                        $in = $in + 1;
                       }
                      echo '</TD>';
                    echo '</TR>';


?>
          </TBODY>
        </TABLE>
        </TD> 
      </TR> 
<TR>        
 <TD>         
</table>
</BODY>
</HTML>
