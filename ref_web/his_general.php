<?php include("../principal/conectar_sec_web.php"); ?>


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
function Buscar()
{
	var f = document.FrmPrincipal;
	fecha=f.ano1.value+'-'+f.mes1.value;
    f.action = "his_general.php?buscar=S"+"&campo="+f.campo.value+"&fecha="+fecha;
	f.submit();
}
function Imprimir()
{
	window.print();
}


//-->
</script>
<body>
<FORM action="" method=post name=FrmPrincipal>
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
<TR  vAlign=top  class=dt> 
<TD vAlign=bottom> <H4><B>BUSCAR EN NOVEDADES</A></B></H4></TD>
<?php 
  echo'<TD width="14%" ><div align="right">';
  echo "<a href=\"JavaScript:Imprimir()\">";
  echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>'; 
?>
</TR>
<TR  vAlign=top  class=dt> 
  <TD width="45%" vAlign=bottom colspan=2> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
  <TR> 
    <TD align=middle width="100%"> <TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0>
    <TR bgcolor="#FFFFFF"> 
      <TD width="1" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <TD width="722" align="center">
      <TABLE height="100%" cellSpacing=0 cellPadding=0    align="center" width="100%" border=0>
      <TR> 
        <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
      </TR>
      <TR> 
         <TD> 
         <TABLE cellSpacing=0 cellPadding=0 width="80%" border=0>
         <TR> 
           <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
           <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
           <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
        </TR>
        <TR> 
          <TD width="100%" colSpan=3> <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
          <TR> 
            <TD width="0%">&nbsp; </TD>
            <TD width="3%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
            <TD width="78%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Buscar 
                                        por ::</FONT> 
                                        <input type="text" name="campo">
                                        <b><font face="Arial, Helvetica, sans-serif">
                                        <select name="mes1" size="1" id="select2">
                                          <?php
				$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for($i=1;$i<13;$i++)
					{
						if (isset($mes1))
						{
							if ($i == $mes1)
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}
						else
						{
							if ($i == date("n"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
							else
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}						
					}
				?>
                                        </select>
                                        <select name="ano1" size="1" id="select3">
                                          <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($ano1))
						{
							if ($i == $ano1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("Y"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>
                                        </select>
                                        <input name=b222222 type=submit id=b222222  value="Buscar"   onClick="JavaScript:Buscar();">
                                        </font></b> <TD width="19%"><IMG height=8 src="archivos/spaceit.gif" width=10 border=0></TD>
          </TR>
          </TABLE>
          </TD>
       </TR>
       <TR> 
         <TD width=7><IMG height=7  src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
         <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
         <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
       </TR>
       </TABLE>
       </TD>
       </TR>
       <TR> 
          <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
       </TR>
       </TABLE>
       </TD>
    </TR>
    </TABLE></TD>
    </TR>
    </TABLE></TD>
    </TR>
    <TR class=lcol vAlign=top> 
    <TD colSpan=4 bgcolor="#ffffff"> 
    <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
          <TR class=lcol> 
            <TD width=15% ><div align="center"><font size="6"><strong>FECHA</strong></font></div></TD>
            <TD width=6% ><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
            <TD width=79% ><div align="left"><font size="6"><strong>DESCRIPCI&Oacute;N</strong></font></div></TD>
          </TR>
          <TR class=lcol> 
		  <?php 
		     if ($buscar=='S')
			    {
				 if(!isset($page))
				    {
					 $page =1;
					}
				 $encontrados=1;
                 $cantidad =1;
                 $contador=0;	
		         $consulta="select * from ref_web.novedades where novedad like '%".$campo."%' and fecha between '".$fecha."-01' and '".$fecha."-31'";
				 $resultado=mysqli_query($link, $consulta);
				  while($row1 = mysqli_fetch_array($resultado))
				    {
					  $contador=$contador+1;
					  if($contador >= 10*($page-1))
					    {
						  if($contador <= 10*$page)
						    {
						     $cantidad=$cantidad+1;
						     $indice=$contador;
						  if ( $j==1)
					         {$color= "lcol";
						     $j=0;}
					      else{$color= "lcolver";
							   $j=1;} //color fila
					      echo '<TR class='.$color.'>';
					      echo '<TD><div align="center"><strong>'.$row1[FECHA].'</strong></div></TD>';
                          echo '<TD ><div align="center">'.$row1[TURNO].'</div></TD>';
                          echo '<TD><div align="left">'.$row1[NOVEDAD].'</div></TD>';
                          echo '</TR>';
						 } 
					   }
					}
				} 
		          
  					$sql="select * from ref_web.novedades where fecha between '".$fecha."-01' and '".$fecha."-31'";
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
                    if($page != 1) { echo'<A href="his_general.php?page='.($page - 1).'&buscar=S&fecha='.$fecha.'&campo='.$campo.'"><strong>&lt;&lt;&lt;</strong></A>&nbsp; &nbsp; &nbsp;'; }
                      $in = 1;
                    while($in <= $paginas)
                       {
                         if($in==$page)
                         {
                           echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<FONT color=#0000FF><b>'.$in.'</b></FONT>&nbsp;&nbsp;&nbsp;';
                         }
                         else
                         {

                           echo '&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<A href="his_general.php?ingreso='.$ingreso.'&amp;page='.$in.'&buscar=S&fecha='.$fecha.'&campo='.$campo.'"><FONT class=tiny>'.$in.'</FONT></A>&nbsp;&nbsp;&nbsp;';

                           if($in==$paginas)
                           {
                             echo '&nbsp; &nbsp; &nbsp; <A href="his_general.php?page='.($page + 1).'&buscar=S&fecha='.$fecha.'&campo='.$campo.'">&gt;&gt;&gt;</A>';
                           }

                         }
                         $in = $in + 1;
                       }
                    echo '</TD>';
                    echo '</TR>';


?>

          <TR bgcolor="#FFFFFF" > 
           
          </TR></TBODY>
        </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>

</FORM>
</BODY>
</HTML>
