<?php 
include("../principal/conectar_ref_web.php"); 

	$intercambiador  = isset($_REQUEST["intercambiador"])?$_REQUEST["intercambiador"]:"";
	$fecha           = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$horas    = isset($_REQUEST["horas"])?$_REQUEST["horas"]:"";
	$hora     = isset($_REQUEST["hora"])?$_REQUEST["hora"]:date("H");
	$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:date("m");

	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"S";	
    $mensaje   = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
	$opcion='N';
	if($intercambiador!="")
	{
		$opcion='M';
	}
	if($horas!=""){
		$hhoras = explode(":",$horas);
		$hora     = $hhoras[0];
		$minuto   = $hhoras[1];
		$seg      = $hhoras[2];		
	}
	$consulta = "SELECT * FROM ref_web.historia_intercambiadores WHERE fecha = '".$fecha."' and cod_intercambiador = '".$intercambiador."' and hora = '".$horas."' ";
	//echo $consulta; 
	$rs = mysqli_query($link, $consulta);		
	if ($row = mysqli_fetch_array($rs))
	{
		$intercambiador  =$row["cod_intercambiador"];
		$observacion=$row["observacion"];
		$situacion  =$row["situacion"];	
	}else{
		$intercambiador  ="";
		$observacion ="";
		$situacion   ="";
	}	

?>


<HTML>
<HEAD>
<TITLE>Corto Circuitos</TITLE>
<link href="../principal/estilos/css_ref_web.css" type="text/css" rel="stylesheet">
<LINK href="../archivos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="../archivos/petalos.css" rel=stylesheet type=text/css>

<script language="JavaScript">
function Validar()
{
	var frm = document.FrmPrincipal;
    intercambiador=frm.intercambiador.value;
    hora=frm.hora.value;
    minuto=frm.minuto.value;
    observacion=frm.observacion.value;
    situ=frm.situ.value;
	opcion     = frm.opcion.value;
    if (intercambiador=='x')
      {
	   alert('Debe seleccionar intercambiador');
	  }
	else if ((frm.situ[0].checked==false) && (frm.situ[1].checked==false) && (frm.situ[2].checked==false) && (frm.situ[3].checked==false))
	        {
	         alert('Debe seleccionar situacion del intercambiador');
	        }
         else {  
			   if (confirm("Esta Seguro de la Operación"))
			     {
				  frm.action = "ing_intercambiadores01.php?Proceso="+opcion;
			      frm.submit();
			     }
	          }				
}

function Recarga(frm,Pagina) // RECARGA PAGINA DE FROMULARIO
{
	frm.action = Pagina;
	frm.submit();
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "intercambiadores.php";
	frm.submit();
}

</script>

<BODY>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
<input type="text" name="opcion" value="<?php echo $opcion; ?>">
<input type="hidden" name="horas" value="<?php echo $horas; ?>">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
   <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
    <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3><B>INGRESADOR 
        DE INTERCAMBIADOR</B></FONT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FECHA :&nbsp;&nbsp;&nbsp;<?php  echo $fecha; ?></FONT></b></b></TD>
    <TD align=right width=9><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
 </TR>
</TABLE>

<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
 <TR> 
   <TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%" border=0>
   <TR> 
     <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
     <TD> 
  	 <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TR> 
  		  <TD><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
        </TR>
        <TR> 
          <TD> 
		  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TR> 
         <TD class=size11 width=61><font size="1">&nbsp;</font><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">INTERCAMBIADOR:</FONT></TD>
         <TD><font size="1"><IMG height=1 src="archivos/spaceit.gif" width=16></font></TD>
         <TD width="36"><div align="left"><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">HORA:</FONT></div></td>
         <TD><font size="1"><IMG height=1 src="archivos/spaceit.gif" width=16></font></TD>
         <TD colspan="3"><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">MINUTO:</FONT></TD>
        </TR>
        <TR> 
           <TD>
            <select name="intercambiador"  size="1">
        	<option value="x" selected>Seleccionar</option>
        		<?php
					$Consulta = "SELECT * FROM ref_web.intercambiadores ORDER BY INTERCAMBIADOR";
					$Respuesta = mysqli_query($link, $Consulta);
					  while ($Row = mysqli_fetch_array($Respuesta))
						{
						  $cod_intercambiador=$Row["cod_intercambiador"];
              if ($intercambiador==$cod_intercambiador)
              {
                echo "<option value='".$cod_intercambiador."' selected>".$Row['intercambiador']."</option>\n";
              }
              else {
                    echo "<option value='".$Row['cod_intercambiador']."'>".$Row['intercambiador']."</option>\n";
              }
						}
        		?>
        	</select>
            </TD>
            <TD width=16>&nbsp;</TD>
            <TD><b><font face="Arial, Helvetica, sans-serif"> 
            <select name="hora" >
                <?php
				   for($i=0; $i<=23; $i++)
					 {
  				 	  if (($mostrar == "S") && ($i == $hora))
						echo '<option selected value ="'.$i.'">'.$i.'</option>';
				      else if (($i == date("H")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
					 	   else	
						        echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
            </select>
            </font></b> </TD>
            <TD width=16>&nbsp;</TD>
            <TD width="92"><b><font face="Arial, Helvetica, sans-serif"> 
            <select name="minuto">
                 <?php
				   for($i=0; $i<=59; $i++)
					 {
					  if (($mostrar == "S") && ($i == $minuto))
						  echo '<option selected value ="'.$i.'">'.$i.'</option>';
					  else if (($i == date("i")) && ($mostrar != "S"))
							  echo '<option selected value ="'.$i.'">'.$i.'</option>';
						  else	
							  echo '<option value="'.$i.'">'.$i.'</option>';
					}
		  	  ?>
          </select>
          </font></b></TD>
          <TD width="751"><b><font face="Arial, Helvetica, sans-serif"> 
          </font></b></TD>
          <TD width="1">&nbsp;</TD>
        </TR>
        </TABLE></TD>
		</TR>
        <TR> 
          <TD align="middle"> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TR> 
            <TD width=274> <table cellspacing=0 cellpadding=0 width="100%" border=0>
            <tr> 
                <td width="7%" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
                <td width="93%" onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator1.gif" width=12 border=0>
                <?php if($situacion!="" && $situacion=="En Servicio"){ ?>
				<input type="radio" name="situ" value="<?php echo $situacion; ?>" checked><FONT  style="FONT-WEIGHT: bold; COLOR: #000000">En Servicio</font>
				<?php }else{ ?>
				<input type="radio" value="En Servicio" name="situ"><FONT  style="FONT-WEIGHT: bold; COLOR: #000000">En Servicio</font>
				<?php } ?>
				</font></td>
            </tr>
            <tr> 
               <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
               <td onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator3.gif"  width=12 border=0>
               <?php if($situacion!="" && $situacion=="En Observacion"){ ?>
			   <input type="radio" name="situ"  value="<?php echo $situacion; ?>" checked>
               <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Observaci&oacute;n</font>
			   <?php }else{ ?>
			    <input type="radio" value="En Observacion" name="situ">
               <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Observaci&oacute;n</font>
			   <?php } ?>
			   </font></td>
            </tr>
            <tr> 
              <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
              <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator2.gif"  width=12 border=0>
              <?php if($situacion!="" && $situacion=="Fuera de Servicio"){ ?>
			  <input  type="radio" name="situ" value="<?php echo $situacion; ?>" checked>
              <FONT style="FONT-WEIGHT: bold; COLOR: #000000">Fuera de Servicio</font>
			   <?php }else{ ?>
			   <input  type="radio" value="Fuera de Servicio" name="situ">
              <FONT style="FONT-WEIGHT: bold; COLOR: #000000">Fuera de Servicio</font>
			  <?php } ?>
			  </font></td>
            </tr>
            <tr> 
               <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';">&nbsp;</td>
               <td  onMouseOver="if(!document.all){style.cursor='pointer'};style.cursor='hand';"><font class=size13><img height=12 src="archivos/Indicator4.gif" width=12 border=0>
               <?php if($situacion!="" && $situacion=="En Mantencion"){ ?>
			   <input type="radio" name="situ" value="<?php echo $situacion; ?>" checked>
               <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Mantenci&oacute;n</font>
			    <?php }else{ ?>
			   <input type="radio" value="En Mantencion" name="situ">
               <FONT style="FONT-WEIGHT: bold; COLOR: #000000">En Mantenci&oacute;n</font>
			   <?php } ?>
			   </font></td>
             </tr>
             </table></TD>
             <TD width=42>&nbsp;</TD>
             <TD width="657"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
             <TR> 
               <TD><IMG height=8 src="../archivos/spaceit.gif" width=1 border=0></TD>
             </TR>
             <TR> 
               <TD> 
			     <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                   <TR> 
                      <TD width=7><IMG height=7  src="archivos/hbw_Corner1.gif" width=7 border=0></TD>
                      <TD vAlign=top width="100%"><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                      <TD width=7><IMG height=7 src="archivos/hbw_Corner2.gif" width=7 border=0></TD>
                   </TR>
                   <TR> 
                     <TD width="100%" colSpan=3> 
                     <TABLE style="BORDER-RIGHT: #6b8ec6 1px solid; BORDER-LEFT: #6b8ec6 1px solid"  cellSpacing=0 cellPadding=0 width="100%"  border=0>
                        <TR> 
                          <TD width="0%">&nbsp; 
                          </TD>
                          <TD width="23%"><div align="center"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></div></TD>
                          <TD width="49%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Observaciones:</FONT></p>
                          <p align="center">
                          <textarea name="observacion" cols="40" rows="10" ><?php echo $observacion; ?></textarea>
                          </p>
                          <p align="center">&nbsp;</p>
                          </TD>
                          <TD width="28%"><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></TD>
                        </TR>
                      </TABLE></TD>
                    </TR>
                    <TR> 
                      <TD width=7><IMG height=7 src="archivos/hbw_Corner3.gif" width=7 border=0></TD>
                      <TD vAlign=bottom><IMG height=1 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                      <TD width=7><IMG height=7 src="archivos/hbw_Corner4.gif" width=7 border=0></TD>
                     </TR>
                   </TABLE></TD>
                 </TR>
                </TABLE></TD>
               </TR>
               </TABLE></TD>
               </TR>
               <TR> 
                 <TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
               </TR>
               <TR> 
                  <TD><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
                  <input type=button  onclick="Validar();"   value="Guardar"  >
                  </font></b> </div></TD>
               </TR>
               <TR> 
                 <TD><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
               </TR>
               <TR> 
                 <TD id=rasc> </TD>
               </TR>
               </TABLE></TD>
               <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
               </TR>
               </TABLE></TD>
               </TR>
               <TR> 
                 <TD id=ca></TD>
               </TR>
               <TR> 
                  <TD bgcolor="#FFFFFF"> 
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                  <TR> 
                     <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
                     <TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                     <TR> 
                        <TD> <FONT class=small><B>Sistema Jefe Turno de Refineria</B><BR>
                             <font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
                         <TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
                         <TR> 
                            <TD width=20><A href="javascript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
                            <TD id="st" vAlign=center><A href="javascript:salir();"><B><FONT color=#000000>Volver</FONT></B></A></TD>
                          </TR>
                          </TABLE></TD>
                      </TR>
                      <TR> 
                        <TD align="middle" colSpan=2> <DIV id=tele style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
                      </TR>
                    </TABLE></TD>
                    <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
                  </TR>
                 </TABLE></TD>
                 </TR>
                 </TABLE></TD>
               </TR>
               <TR> 
                  <TD> <TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 bgcolor="#FFFFFF">
                  <TR> 
                    <TD vAlign="bottom" width=8><IMG height=8 src="archivos/hbw_line_l.gif" width=8 border=0></TD>
                    <TD vAlign="bottom" width="100%"><IMG height=2 src="archivos/6b8ec6dot.gif" width="100%"></TD>
                    <TD vAlign="bottom" align="right" width=8><IMG height=8 src="archivos/hbw_line_r.gif" width=8 border=0></TD>
                  </TR>
                  </TABLE></TD>
               </TR>
               </TABLE>
</FORM>
<?php
	if ($mensaje!="")
	{
		echo '<script language="JavaScript">';			
			echo 'alert("'.$mensaje.'");';				
		echo '</script>';
	}
?>
</BODY>
</HTML>
