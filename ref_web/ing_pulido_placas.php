<?php include("../principal/conectar_ref_web.php");    ?>


<?php
$sqls = "select * from ref_web.pulido_placas WHERE FECHA = '$fecha' AND TURNO = '$turno'";
$results=mysqli_query($link, $sqls);
$num = mysqli_num_rows($results);
if($num<>0)
{
	$sql1 = "select * from ref_web.pulido_placas WHERE FECHA = '$fecha' AND TURNO = '$turno' AND COD_OPERACION = '1'   ";
	$result1=mysqli_query($link, $sql1);
	$row1 = mysqli_fetch_array($result1);
	$arman1= $row1['PLACAS_NEGRAS'];
	$arman2= $row1['PLACAS_PERNOS'];
	
	$sql2 = "select * from ref_web.pulido_placas WHERE FECHA = '$fecha' AND TURNO = '$turno' AND COD_OPERACION = '2'   ";
	$result2=mysqli_query($link, $sql2);
	$row2 = mysqli_fetch_array($result2);
	$cambian1= $row2['PLACAS_NEGRAS'];
	$cambian2= $row2['PLACAS_PERNOS'];
	
	$sql3 = "select * from ref_web.pulido_placas WHERE FECHA = '$fecha' AND TURNO = '$turno' AND COD_OPERACION = '3'   ";
	$result3=mysqli_query($link, $sql3);
	$row3 = mysqli_fetch_array($result3);
	$stock1= $row3['PLACAS_NEGRAS'];
	$stock2= $row3['PLACAS_PERNOS'];
	$Proceso="M";
}
else
	{
	  $Proceso="G";
	}
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
function Validar()
{
	var frm = document.FrmPrincipal;
    turno=frm.turno.value;
    fecha=frm.fecha.value;
    arman1=frm.arman1.value;
    arman2=frm.arman2.value;
    cambian1=frm.cambian1.value;
    cambian2=frm.cambian2.value;
    stock1=frm.stock1.value;
    stock2=frm.stock2.value;

	Mensaje = confirm("Esta Seguro de la Operacion");

		if (Mensaje=="false")
		{
		}
        else
        {
				frm.action = "ing_pulido_placas01.php?turno=" + turno + "&arman1=" + arman1 + "&arman2=" + arman2 + "&cambian1=" + cambian1 + "&cambian2=" + cambian2  + "&stock1=" + stock1 + "&stock2=" + stock2;
				frm.submit();
	    }
}
function salir(fecha) // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "pulido_placas.php?fecha="+fecha;
	frm.submit();
}
//-->
</script>

<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
<input type="hidden" name="Proceso" value="<?php echo''.$Proceso.''; ?>">

<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
     <TR> 
        <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
        
      <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong>FORMULARIO DE PROCEDIMIENTOS</strong></FONT></TD>
        <TD align=right width=9><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
     </TR>
  </TBODY>
</TABLE>

<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR> 
      <TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%"                   border=0>
         <TBODY>
           <TR> 
             <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
             <TD> 
				<TABLE cellSpacing=0 cellPadding=0 width="86%" border=0>
                  <TBODY>
                    <TR> 
                      <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
                    </TR>
                    <TR> 
                      <TD width="25%">&nbsp;</TD>
                      <TD width="6%"><b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">TURNO:</FONT><font face="Arial, Helvetica, sans-serif">                         </font></b></TD>
                      <TD width="23%">
                        <?php
							if (!isset($cmbturno))
							{ 
								$Consulta = "select case when CURTIME() between '00:00:00' and '07:59:59' then 'C' else ";
								$Consulta.= " case when CURTIME() between '08:00:00' and '15:59:59' then 'A' else ";
								$Consulta.= " case when CURTIME() between '16:00:00' and '23:59:59' then 'B' end end end as turno ";
								$Respuesta = mysqli_query($link, $Consulta);
							if ($Fila = mysqli_fetch_array($Respuesta))
								$cmbturno = $Fila["turno"];
							}
				
							echo '<select name="turno">';
							echo '<option value="R">SELECCIONAR</option>';
							$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
							$respuesta = mysqli_query($link, $consulta);
							while ($fila1=mysqli_fetch_array($respuesta))
								  {
									 
									if ($cmbturno==$fila1[turno])
										echo "<option value='".$fila1[turno]."' selected>".$fila1[turno]."</option>";
									else
										echo "<option value='".$fila1[turno]."'>".$fila1[turno]."</option>";
								  }
							echo '</select></td>';
					 ?>	
                      </TD>
                        <TD colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FECHA :&nbsp;&nbsp;&nbsp;<?phpphp  echo $fecha; ?></FONT></b></b></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><b>&nbsp;</b></TD>
                    </TR>
                    
                    <TR> 
                      <TD colspan="5" align=middle> <TABLE cellSpacing=0 cellPadding=0 width="100%" 
                              border=0>
                          <TBODY>
                            <TR> 
                              <TD width=44>&nbsp; </TD>
                              <TD width="722"> <TABLE height="100%" cellSpacing=0 cellPadding=0 
                                width="100%" border=0>
                                  <TBODY>
                                    <TR> 
                                      <TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
                                    </TR>
                                    <TR> 
                                      <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                          <TBODY>
                                            <TR> 
                                              <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
                                              <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                                              <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
                                            </TR>
                                            <TR> 
                                              <TD width="100%" colSpan=3> <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
                                                  <TBODY>
                                                    <TR> 
                                                      <TD width="0%">&nbsp; </TD>
                                                      <TD width="20%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
                                                      <TD width="60%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Pulido 
                                                            Placas :</FONT></p>
                                                          <table width="119%" border="1" align="center">
                                                            <tr> 
                                                              <td width="32%">&nbsp;</td>
                                                              <td width="33%"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">PLACAS                                                                 NEGRAS</FONT></td>
                                                              <td width="35%"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">PLACAS                                                                 C/PERNOS</FONT></td>
                                                            </tr>
                                                            <tr> 
                                                              <td><FONT style="FONT-WEIGHT: bold; COLOR: #000000">CAMBIAN</FONT></td>
                                                              <td> <div align="center"> 
                                                                  <input name="cambian1" type="text" size="5" maxlength="2"  value=<?phpphp if(isset($cambian1)){ echo $cambian1;} ?>>
                                                                </div></td>
                                                              <td><div align="center"> 
                                                                  <input name="cambian2" type="text" size="5" maxlength="2"  value=<?phpphp if(isset($cambian2)){ echo $cambian2;} ?>>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <td><font style="FONT-WEIGHT: bold; COLOR: #000000">ARMAN</font></td>
                                                              <td><div align="center">
                                                                  <input name="arman1" type="text" size="5" maxlength="2" value=<?phpphp if(isset($arman1)){ echo $arman1;} ?>>
                                                                </div></td>
                                                              <td><div align="center">
                                                                  <input name="arman2" type="text" size="5" maxlength="2"  value=<?phpphp if(isset($arman2)){ echo $arman2;} ?>>
                                                                </div></td>
                                                            </tr>
                                                            <tr> 
                                                              <td><FONT style="FONT-WEIGHT: bold; COLOR: #000000">STOCK</FONT></td>
                                                              <td><div align="center"><input name="stock1" type="text" size="5" maxlength="2"  value=<?phpphp if(isset($stock1)){ echo $stock1;} ?>></div></td>
                                                              <td><div align="center"><input name="stock2" type="text" size="5" maxlength="2"  value=<?phpphp if(isset($stock2)){ echo $stock2;} ?>></div></td>
                                                            </tr>
                                                          </table>
                                                          <p align="center">&nbsp;</p></TD>
                                                      <TD width="20%"><IMG height=1 
                                src="archivos/spaceit.gif" 
                                width=10 
                                border=0></TD>
                                                    </TR>
                                                  </TBODY>
                                                </TABLE></TD>
                                            </TR>
                                            <TR> 
                                              <TD width=7><IMG height=7 
                                src="archivos/hbw_Corner3.gif" 
                                width=7 border=0></TD>
                                              <TD vAlign=bottom><IMG height=1 
                                src="archivos/6b8ec6dot.gif" 
                                width="100%"></TD>
                                              <TD width=7><IMG height=7 
                                src="archivos/hbw_Corner4.gif" 
                                width=7 
                                border=0></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                    </TR>
                                  </TBODY>
                                </TABLE></TD>
                            </TR>
                          </TBODY>
                        </TABLE></TD>

                    </TR>
                    <TR> 
                      <TD colspan="5"><IMG height=5                               src="archivos/spaceit.gif"                               width=1 border=0></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
                          <input type=submit   value="Guardar"  onClick="JavaScript:Validar();"  >
                          </font></b> </div></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><IMG height=5 
                              src="archivos/spaceit.gif" 
                              width=1 border=0></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5" id=rasc> </TD>
                    </TR>
                  </TBODY>
                </TABLE></TD>
                                      <TD width=8><IMG height=1 
                        src="archivos/spaceit.gif" 
                        width=5></TD>
                                    </TR>

                                  </TBODY>
                                </TABLE></TD>
                            </TR>
                            <TR> 
                              <TD id=ca></TD>
                            </TR>

                            <TR> 
                              <TD bgcolor="#FFFFFF"> 
                                <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                  <TBODY>
                                    <TR> 
                                      <TD width=8><IMG height=1 
                        src="archivos/spaceit.gif" 
                        width=5></TD>
                                      <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" 
border=0>
                                          <TBODY>
                                            <TR> 
                                              <TD> <FONT class=small><B>Sistema                             Jefe Turno de Refineria</B><BR>
                          <font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
                                              <TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
                                                  <TBODY>
                                                    <TR> 
                                                      <TD width=20><A href="javascript:salir('<?php echo $fecha ?>');"><IMG 
                                height=20 hspace=3 
                                src="archivos/btn_sec.gif" 
                                width=20 border=0></A></TD>
                                                      <TD id=st vAlign=center><A 
                                href="javascript:salir();"><B><FONT 
                                color=#000000>Volver</FONT></B></A></TD>
                                                    </TR>
                                                  </TBODY>
                                                </TABLE></TD>
                                            </TR>
                                            <TR> 
                                              <TD align=middle colSpan=2> <DIV id=tele 
                              style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                      <TD width=8><IMG height=1 
                        src="archivos/spaceit.gif" 
                        width=5></TD>
                                    </TR>
                                  </TBODY>
                                </TABLE></TD>
                            </TR>
                          </TBODY>
                        </TABLE></TD>
                    </TR>
                    <TR> 
                      <TD> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
                          <TBODY>
                            <TR> 
                              <TD vAlign=bottom width=8><IMG height=8                   src="archivos/hbw_line_l.gif"                   width=8 border=0></TD>
                              <TD vAlign=bottom width="100%"><IMG height=2                   src="archivos/6b8ec6dot.gif"                   width="100%"></TD>
                              <TD vAlign=bottom align=right width=8><IMG height=8                   src="archivos/hbw_line_r.gif"                  width=8       border=0></TD>
                            </TR>
                          </TBODY>
                        </TABLE></TD>
                    </TR>
                  </TBODY>
                </TABLE>
              </TD>
            </TR>
          </TBODY>
        </TABLE>
</form>
</body>
</html>
