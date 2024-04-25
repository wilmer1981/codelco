<?php  include("../principal/conectar_sec_web.php");

$modificar  = isset($_REQUEST["modificar"])?$_REQUEST["modificar"]:"";
$tema       = isset($_REQUEST["tema"])?$_REQUEST["tema"]:"";
$fecha      = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$DESDE      = isset($_REQUEST["DESDE"])?$_REQUEST["DESDE"]:"";
$HASTA      = isset($_REQUEST["HASTA"])?$_REQUEST["HASTA"]:"";
$PROCEDIMIENTO  = isset($_REQUEST["PROCEDIMIENTO"])?$_REQUEST["PROCEDIMIENTO"]:"";
$COD_TIPO_PROCEDIMIENTO  = isset($_REQUEST["COD_TIPO_PROCEDIMIENTO"])?$_REQUEST["COD_TIPO_PROCEDIMIENTO"]:"";
$COD_PROCEDIMIENTO  = isset($_REQUEST["COD_PROCEDIMIENTO"])?$_REQUEST["COD_PROCEDIMIENTO"]:"";

if ($modificar=='S')
	{
	  $ano1=substr($HASTA,0,4);
	  $mes1=substr($HASTA,5,2);
	  $dia1=substr($HASTA,8,2);
	  	
	}

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<script language="JavaScript">
<!--
function Validar()
{
	var frm = document.FrmPrincipal;
    tema=frm.tema.value;
    desde=frm.desde.value;
    hasta=frm.ano1.value+'-'+frm.mes1.value+'-'+frm.dia1.value;
    procedimiento=frm.procedimiento.value;
    fecha=frm.fecha.value;
	if (frm.tema.value=='x')
	   {
	    alert("debe seleccionar tema")
		return false;
	   
	   }
  else {
	    Mensaje = confirm("Esta Seguro de la Operacion");
		if (Mensaje=="false")
		{
		}
        else
        {
				frm.action = "ing_procedimientos01.php?Proceso=G&desde="+desde+"&hasta="+hasta+"&tema="+tema+"&procedimiento="+procedimiento+"&fecha="+fecha;
				frm.submit();
	    }
	  }	
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "procedimientos.php";
	frm.submit();
}
function Modificar(opcion,cod_tipo_procedimiento,cod_procedimiento)
{
 var frm = document.FrmPrincipal;
 tema=frm.tema.value;
 desde=frm.desde.value;
  hasta=frm.ano1.value+'-'+frm.mes1.value+'-'+frm.dia1.value;
 //procedimiento=frm.procedimiento.value;
 fecha=frm.fecha.value;
 frm.action = "ing_procedimientos01.php?Proceso=M&desde="+desde+"&hasta="+hasta+"&tema="+tema+"&fecha="+fecha+"&cod_tipo_procedimiento="+cod_tipo_procedimiento+"&cod_procedimiento="+cod_procedimiento;
 frm.submit();
}
//-->
</script>

<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
     <TR> 
        <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
        <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><strong>FORMULARIO         DE PROCEDIMIENTOS</strong></FONT></TD>
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
                      <TD width="6%"><b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">TEMA:</FONT><font face="Arial, Helvetica, sans-serif"></font></b></TD>
                      <TD width="23%">
                       <select name="tema"  size="1" <?php if ($modificar=='S')
					                                      {?> disabled <?php }?> >
                        <option value="x" selected>Seleccionar</option>
                        <?php
						$Consulta = "SELECT * FROM ref_web.tipo_procedimientos ORDER BY TIPO_PROCEDIMIENTO";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($Respuesta))
						{
						   if ($tema==$Row["COD_TIPO_PROCEDIMIENTO"])
						         echo "<option value='".$Row["COD_TIPO_PROCEDIMIENTO"]."' selected>".$Row["TIPO_PROCEDIMIENTO"]."</option>";
						   else	 
						         echo "<option value='".$Row['COD_TIPO_PROCEDIMIENTO']."'>".$Row['TIPO_PROCEDIMIENTO']."</option>\n";
						}
                        ?>
                       </select>
                      </TD>
                      <TD colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FECHA :&nbsp;&nbsp;&nbsp;<?php  echo $fecha; ?></FONT></b></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><b>&nbsp;</b></TD>
                    </TR>
                    <TR> 
                      <TD width="25%">&nbsp;</TD>
                      <TD width="6%"><b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">DESDE:</FONT><font face="Arial, Helvetica, sans-serif"></font></b></TD>
                      <TD width="23%"><input type="text" name="desde" value=" <?php echo $fecha;?>" disabled></TD>
                      <TD width="6%"><b><font size="1" style="FONT-WEIGHT: bold; COLOR: #000000">HASTA:</font><font face="Arial, Helvetica, sans-serif"></font></b></TD>
                        <TD width="40%"> <select name="dia1" size="1" id="select2">
                            <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($dia1))
							{
								if ($dia1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					  ?>
                          </select> <select name="mes1" size="1" id="mes1">
                            <?php    
						for ($i = 1;$i <= 12; $i++)
						{$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
							if (isset($mes1))
							{
								if ($mes1 == $i)
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
							else
							{
								if ($i == date("n"))
									echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
							}
						}
						?>
                          </select> <select name="ano1" size="1" id="select4">
                            <?php
						for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
						{
							if (isset($ano1))
							{
								if ($ano1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("Y"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
				?>
                          </select></TD>
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
                                                      <TD width="23%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
                                                      <TD width="49%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Observaciones:</FONT></p>
                                                        <p align="center"> 
                                                          <textarea name="procedimiento" cols="85" rows="10" ><?php echo $PROCEDIMIENTO;?></textarea>
                                                        </p>
                                                        <p align="center">&nbsp;</p></TD>
                                                      <TD width="28%"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></TD>
                                                    </TR>
                                                  </TBODY>
                                                </TABLE></TD>
                                            </TR>
                                            <TR> 
                                              <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
                                              <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                                              <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
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
                      <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
					  <?php if ($modificar=='S')
					        { ?>
                               <input type=button   value="Modificar"  onClick="JavaScript:Modificar('M','<?php echo $COD_TIPO_PROCEDIMIENTO; ?>',' <?php echo $COD_PROCEDIMIENTO;?>');"  >							 
						<?php	} 
						  else {?>
                                 <input type=button   value="Guardar"  onClick="JavaScript:Validar('G');"  >
						    <?php } ?>
                          </font></b> </div></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
                    </TR>
                    <TR> 
                      <TD colspan="5" id=rasc> </TD>
                    </TR>
                  </TBODY>
                </TABLE></TD>
                   <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
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
                                      <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
                                      <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                                          <TBODY>
                                            <TR> 
                                              <TD> <FONT class=small><B>Sistema Jefe Turno de Refineria</B><BR>
                                                   <font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
                                              <TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
                                                  <TBODY>
                                                    <TR> 
                                                      <TD width=20><A href="javascript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
                                                      <TD id=st vAlign=center><B><FONT color=#000000>Volver</FONT></B></TD>
                                                    </TR>
                                                  </TBODY>
                                                </TABLE></TD>
                                            </TR>
                                            <TR> 
                                              <TD align=middle colSpan=2> <DIV id=tele style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
                                            </TR>
                                          </TBODY>
                                        </TABLE></TD>
                                      <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
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
                              <TD vAlign=bottom width=8><IMG height=8 src="archivos/hbw_line_l.gif" width=8 border=0></TD>
                              <TD vAlign=bottom width="100%"><IMG height=2 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                              <TD vAlign=bottom align=right width=8><IMG height=8 src="archivos/hbw_line_r.gif" width=8 border=0></TD>
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
