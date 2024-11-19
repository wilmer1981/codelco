

<?php 
  include("../principal/conectar_ref_web.php");

  $opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
  $turno        = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
  $cod_novedad  = isset($_REQUEST["cod_novedad"])?$_REQUEST["cod_novedad"]:"";
  $fecha        = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
  $observaciones= isset($_REQUEST["observaciones"])?$_REQUEST["observaciones"]:"";
   
  $Area         = isset($_REQUEST["Area"])?$_REQUEST["Area"]:"";
  $Estado       = isset($_REQUEST["Estado"])?$_REQUEST["Estado"]:"";
  $cmbturno     = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
  $observacion  = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
  
  	$ano1  = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$mes1  = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$dia1  = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");

    //echo "Opcion:".$opcion;
    //echo "ano1:".$ano1;
    //echo "<br>mes1:".$mes1;
	//echo "<br>dia1:".$dia1;
  if ($opcion=='M')
      {

	
       $consulta_codigo="select * from ref_web.novedades where TURNO='".$turno."' and COD_NOVEDAD='".$cod_novedad."' "; 
	  
	   $respuesta_codigo = mysqli_query($link, $consulta_codigo);
	   $fila_codigo=mysqli_fetch_array($respuesta_codigo);
	   $cod_novedad=isset($fila_codigo["COD_NOVEDAD"])?$fila_codigo["COD_NOVEDAD"]:"";
	   $observaciones=isset($fila_codigo["NOVEDAD"])?$fila_codigo["NOVEDAD"]:"";
	   $Area=isset($fila_codigo["area"])?$fila_codigo["area"]:"";
	   $Estado=isset($fila_codigo["estado"])?$fila_codigo["estado"]:"";
	   if (isset($fila_codigo["compromiso"]))
	      {
		   $ano1=substr($fila_codigo["compromiso"],0,4);
		   $mes1=substr($fila_codigo["compromiso"],5,2);
		   $dia1=substr($fila_codigo["compromiso"],8,2);
		  }
		else {
		       $ano1=intval(date("Y"));
		       $mes1=intval(date("n"));
		       $dia1=intval(date("j"));
		     }   
	  } 
  
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<script language="JavaScript">
function Guardar(f,cod_novedad)
{
var frm = document.FrmPrincipal;

    var Gerencia='';
	var Mantencion='';
	var Condicion_insegura='';
	if (f.checkbox1.checked)
	   {
	    Mantencion='S';
	   }
	  
	 if (f.checkbox3.checked)
	   {
	    Gerencia='S';
	   }
 
	if (f.checkbox5.checked)
	   {
	    Condicion_insegura='S';
	   }  
  
	Mensaje = confirm("Esta Seguro de la Operacion");
    
		if (Mensaje==false)
		{
		 return;
		}
        else
        {
		var opcion =frm.opcion.value;
			f.action = "ing_general01.php?Proceso=G"+"&cod_novedad="+cod_novedad+"&gerencia="+Gerencia+"&mantencion="+Mantencion+"&Condicion_insegura="+Condicion_insegura+"&opcion="+opcion;

			//f.action = "prueba2_ing_general01.php?Proceso=G"+"&cod_novedad="+cod_novedad+"&gerencia="+Gerencia+"&mantencion="+Mantencion+"&prueba_d=��";
			f.submit();
	    }
    //alert(f.observacion.value);
	//alert(Mantencion);		
    		
}
function salir() // RECARGA PAGINA DE FROMULARIO
{
	var frm = document.FrmPrincipal;
	frm.action = "general.php";
	frm.submit();
}



</script>

<body>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
<input type="hidden" name="opcion" value="<?php echo $opcion; ?>">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TR> 
   <TD width=9><IMG height=16 src="archivos/hbw_bar_l.gif" width=9 border=0></TD>
   <TD align=middle bgColor=#6b8ec6><FONT style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #ffffff; FONT-FAMILY: Arial; LETTER-SPACING: 3px; TEXT-ALIGN: center; TEXT-DECORATION: none" size=3>CUADRO DE MODIFICACIONES </FONT></TD>
   <TD align=right width=9><IMG height=16 src="archivos/hbw_bar_r.gif" width=9 border=0></TD>
  </TR>
</TABLE>
<TABLE style="BORDER-RIGHT: #6b8ec6 2px solid; BORDER-LEFT: #6b8ec6 2px solid" cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TR> 
      <TD style="BACKGROUND-REPEAT: repeat-x" background="archivos/bg_grad3.gif" bgColor=#d7dce8> <TABLE id=tbl cellSpacing=0 cellPadding=0 width="100%"                   border=0>
        <TR> 
          <TD width=8><IMG height=1 src="archivos/spaceit.gif" width=5></TD>
          <TD> 
		  <TABLE cellSpacing=0 cellPadding=0 width="86%" border=0>   
                <TR> 
                  <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1></TD>
                </TR>
                <TR> 
                  <TD width="54" rowspan="2"><b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">TURNO:</FONT><font face="Arial, Helvetica, sans-serif"> 
                    </font></b></TD>
                  <TD width="73" rowspan="2"> 
                    <?php
					    
		
	            if ($cmbturno=="")
				{ 
					$Consulta = "select case when CURTIME() between '00:00:00' and '07:59:59' then 'C' else ";
					$Consulta.= " case when CURTIME() between '08:00:00' and '15:59:59' then 'A' else ";
					$Consulta.= " case when CURTIME() between '16:00:00' and '23:59:59' then 'B' end end end as turno ";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
						if ($opcion == "M")
						{					
							$cmbturno = $turno;						
						}	
						else
						{					
							$cmbturno = $Fila["turno"];
						}	
				}
				
				echo '<select name="cmbturno">';
		        echo '<option value="R">SELECCIONAR</option>';
		 	    $consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
				$respuesta = mysqli_query($link, $consulta);
				while ($fila1=mysqli_fetch_array($respuesta))
				{
					if ($cmbturno==$fila1["turno"])
						echo "<option value='".$fila1["turno"]."' selected>".$fila1["turno"]."</option>";
					else
						echo "<option value='".$fila1["turno"]."'>".$fila1["turno"]."</option>";
		    	}
				echo '</select></td>';
			 ?>
</TD>
                  <TD width="296" rowspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">FECHA 
                    :&nbsp;&nbsp;&nbsp; 
                    <?php  echo $fecha; ?>
                    </FONT></b></b></TD>
                  <TD width="77" rowspan="2"><b><b><FONT size="1" style="FONT-WEIGHT: bold; COLOR: #000000">Enviar 
                    a:</FONT></b></b></TD>
					
				  <?php 
				  //	echo "codmantencion".$fila_codigo["mantencion"];
				  $mantencion=isset($fila_codigo["mantencion"])?$fila_codigo["mantencion"]:"";
				if ($mantencion<>'')
				{ ?>
					<td width="348" height="12"><input name="checkbox1" type="checkbox" id="checkbox1" value="<?php echo $fila_codigo["mantencion"]; ?>" checked>					  <?php }
				else { ?>
					<td width="348" height="12"><input name="checkbox1" type="checkbox" id="checkbox2" value="Mantencion" >				
				      
				  <?php } ?>
                    Informe Mantencion</td>
                </TR>
                <TR>
				  <?php 
				  $gerencia=isset($fila_codigo["gerencia"])?$fila_codigo["gerencia"]:"";
				  if ($gerencia<>'')
				        { ?>
                  <td height="13"><input name="checkbox3" type="checkbox" id="checkbox3" value="<?php echo $fila_codigo["gerencia"]; ?>" checked>                    <?php }
					 else { ?>
					
					  	 <td height="13"><input name="checkbox3" type="checkbox" id="checkbox4" value="Gerencia">
					   <?php } ?>
                    Informe Gerencia</td>
			</TR>
            <TR> 
            	<TD colspan="5" align=middle> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                	<TR> 
                    	<TD width=44>&nbsp; </TD>
                        <TD width="722"> <TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
                        <TR> 
                        	<TD><IMG height=8 src="archivos/spaceit.gif" width=1 border=0></TD>
                     	</TR>
                        <TR> 
                        	<TD> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
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
                                          <TD width="63%"><p><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Observaciones:</FONT></p>
                                            <p align="center"> 
                                              <textarea name="observacion" cols="80" rows="10" ><?php echo $observaciones; ?></textarea>
                                            </p>
                                            <p align="center">&nbsp;</p></TD>
            <?php 	
			if ($mantencion<>'') 
			{
				?>
					<TD width="34%"><p><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></p><p><strong>Fecha Ejecuci&oacute;n</strong></p>
                    <select name="dia1" size="1">
                <?php
					for ($i = 1;$i <= 31; $i++)
					{
						if (isset($dia1))
						{
							if ($dia1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
							else	
									echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					?>
              		</select>
                	<select name="mes1" size="1" >
                   <?php    
						for ($i = 1;$i <= 12; $i++)
						{
							$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
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
                   	</select>
                   	<select name="ano1" size="1" >
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
                  	</select>
                    </p>
                    <p><strong>Areas Mantenci&oacute;n</strong> 
                    </p>
                   	<p> 
                    <select name="Area" size="1" >
                    <?php 
					for ($i = 1;$i <= 8; $i++)
					{
						$obras=array('M. Mecanica','M. Instrumentista','M. Obras y Serv.','Electricistas','Personal Aseo','Ingenieria','Mec. Grúas','Lubricación');
						if ($Area!="")
						{
							if ($Area == $i)
								echo "<option selected value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
							else	echo "<option value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
						}
						else
						{
							echo "<option value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
						}
					}
					?>
                    </select>                                            
                     <p><strong>Estado</strong>
                     <p> 
                     <select name="Estado" size="1" >
                     <?php 
					for ($i = 1;$i <= 2; $i++)
					{
						$estado=array('Pendiente','Realizado');
						if ($Estado!="")
						{
							if ($Estado == $i)
								echo "<option selected value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
							else	echo "<option value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
						}
						else
						{
							echo "<option value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
						}
					}
					?>
                    </select>
                    <?php 
			} 
			else
			{
				
				$Estado_aux=1;?>
				
				<input type="hidden" name="Estado" value="<?php echo $Estado_aux; ?>">
			

             	<TD width="10%"><p><IMG height=1 src="archivos/spaceit.gif" width=10 border=0></p>
				<?php
				//aqui inserto todo igual cuando se modifica
				?>
				<?php				
				?>
					<TD width="34%"><p>
					<?php
/*					<IMG height=1 src="archivos/spaceit.gif" width=10 border=0></p><p><strong>Fecha Ejecuci�n</strong></p>
                    <select name="dia1" size="1">
                <?php
					for ($i = 1;$i <= 31; $i++)
					{
						if (isset($dia1))
						{
							if ($dia1 == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
							else	
									echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					?>
              		</select>
                	<select name="mes1" size="1" >
                   <?php    
						for ($i = 1;$i <= 12; $i++)
						{
							$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
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
                   	</select>
                   	<select name="ano1" size="1" >
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
					}*/
					?>
                  	</select>
					
                    </p>
                    <p><strong>Areas Mantenci&oacute;n</strong> 
                    </p>
                   	<p> 
                    <select name="Area" size="1" >
                    <?php 
					for ($i = 1;$i <= 8; $i++)
					{
						$obras=array('M. Mecanica','M. Instrumentista','M. Obras y Serv.','Electricistas','Personal Aseo','Ingenieria','Mec. Grúas','Lubricación');

						if ($Area!="")
						{
							if ($Area == $i)
								echo "<option selected value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
							else	echo "<option value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
						}
						else
						{
							echo "<option value='".$i."'>".ucwords(strtolower($obras[$i - 1]))."</option>\n";
						}
					}
					?>

					<?php

					/*
                    </select>                                            
                     <p><strong>Estado</strong>
                     <p> 
                     <select name="Estado" size="1" >
                     <?php 
					for ($i = 1;$i <= 2; $i++)
					{
						$estado=array('Pendiente','Realizado');
						if (isset($Estado))
						{
							if ($Estado == $i)
								echo "<option selected value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
							else	echo "<option value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
						}
						else
						{
							echo "<option value='".$i."'>".ucwords(strtolower($estado[$i - 1]))."</option>\n";
						}
					}*/
					?>
                    </select>
                    <?php 

				
				
				
				
			?>	
				
			<?php
			} 
			?> 
                   	</p>
                   	<p>
					<?php 
					 $Condicion_insegura=isset($fila_codigo["Condicion_insegura"])?$fila_codigo["Condicion_insegura"]:"";
					if ($Condicion_insegura<>'')
				        { 
					?>
						<input name="checkbox5" type="checkbox" id="checkbox5" value="<?php echo $fila_codigo["Condicion_insegura"]; ?>" checked>
					<?php
					}
					 else
					 { 
					 ?>
					  	 <input name="checkbox5" type="checkbox" id="checkbox6" value="Condicion_insegura">
					   
					  <?php
					   }
					  ?>
                   	  <strong>Condici&oacute;n Insegura</strong>                 
			</p></TD>
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
                  <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
                </TR>
                <TR> 
                  <TD colspan="5"><div align="center"><b><font face="Arial, Helvetica, sans-serif"> 
				
                  <input name="button" type="button"  onClick="JavaScript:Guardar(this.form,'<?php echo $cod_novedad;?>');"   value="Guardar"  >
</font></b> </div></TD>
                </TR>
                <TR> 
                  <TD colspan="5"><IMG height=5 src="archivos/spaceit.gif" width=1 border=0></TD>
                </TR>
                <TR> 
                  <TD colspan="5" id=rasc> </TD>
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
<TD> <FONT class=small><B>Sistema Jefe Turno de Refineria (Versi&oacute;n 1)</B> <BR>
<font color="#0000FF">Formulario de Ingreso</font></FONT></TD>
<TD align=right> <TABLE cellSpacing=0 cellPadding=0 border=0>
<TR> 
<TD width=20><A href="javascript:salir();"><IMG height=20 hspace=3 src="archivos/btn_sec.gif" width=20 border=0></A></TD>
<TD id=st vAlign=center><A href="javascript:salir();"><B><FONT color=#000000>Volver</FONT></B></A></TD>
</TR>
</TABLE></TD>
</TR>
<TR> 
<TD align=middle colSpan=2> <DIV id=tele  style="DISPLAY: none; PADDING-TOP: 5px"></DIV></TD>
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
<TD vAlign=bottom width=8><IMG height=8 src="archivos/hbw_line_l.gif" width=8 border=0></TD>
<TD vAlign=bottom width="100%"><IMG height=2 src="archivos/6b8ec6dot.gif" width="100%"></TD>

<TD vAlign=bottom align=right width=8><IMG height=8 src="archivos/hbw_line_r.gif" width=8 border=0></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</form>
</body>
</html>
