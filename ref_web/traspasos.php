<?php include("../principal/conectar_ref_web.php");
$fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$ano1=substr($fecha,0,4);
$mes1=substr($fecha,5,2);
$dia1=substr($fecha,8,2);
 ?>
<html>
<head>
<title>Traspasos</title>
</head>
<LINK href="estilos/css_ref_web.css" rel=stylesheet type=text/css>
<LINK  href="archivos/petalos.css" rel=stylesheet type=text/css>
<LINK href="estilos/HOME-IE6.CSS" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript>
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}

function Eliminar(fecha,turno,circuito)
{
 var f = document.FrmPrincipal;
 if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     f.action = "proceso_h2so4.php?proceso=E"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito ;
     f.submit();	
	} 
}

function Eliminar2(fecha,turno,circuito)
{
 var f = document.FrmPrincipal;
 if (confirm("Esta que desea Eliminar permanentemente el dato"))
	{
     f.action = "proceso_dp.php?proceso=E"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito ;
     f.submit();	
	} 
}

function Eliminar3(fecha,turno,circuito)
{
 var f = document.FrmPrincipal;
 if (confirm("Esta seguro que desea Eliminar permanentemente el dato"))
	{
     f.action = "proceso_electrolito.php?proceso=E"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito ;
     f.submit();	
	} 
}

function Modificar(fecha,turno,circuito,volumen)
{
 var f = document.FrmPrincipal;
 f.action = "popup_h2so4.php?proceso=M"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito+"&Volumen="+volumen ;
 f.submit();	
}
function Modificar2(fecha,turno,circuito,volumen)
{
 var f = document.FrmPrincipal;
 f.action = "popup_desc_parcial.php?proceso=M"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito+"&Volumen="+volumen ;
 f.submit();	
}
function Modificar3(fecha,turno,circuito,destino,volumen)
{
 var f = document.FrmPrincipal;
 f.action = "popup_electrolito.php?Proceso=M"+"&txt_fecha="+fecha+"&Turno="+turno+"&Circuito="+circuito+"&Volumen="+volumen+"&Destino="+destino ;
 f.submit();	
}
function Imprimir()
{
	window.print();
}
</SCRIPT>
<META content="MSHTML 5.00.2614.3500" name=GENERATOR></HEAD>
<BODY leftMargin=3 topMargin=5 marginheight="0" marginwidth="0">
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="fecha" value="<?php echo''.$fecha.''; ?>">
<TABLE width="100%" align="center" cellPadding=0 cellSpacing=0 class="cm lbl">
      <TR  vAlign=top  class=dt>  
        <TD width="90%" vAlign=bottom colspan=3> <H4><B>TRASPASOS<strong> del: &nbsp;&nbsp;<?php echo $dia1.'-'.$mes1.'-'.$ano1; ?></strong></B></H4></TD>
       <?php 
	       echo'<TD width="14%" ><div align="right">';
		   echo "<a href=\"JavaScript:Imprimir()\">";
		   echo '<img src="archivos/imprimir.gif" width="26" height="18" border="0"></A></div></TD>';
	     ?>
      </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TR class=lcol> 
              <TD  colspan=6  vAlign=top class=dt><div align="center">
                <p>&nbsp;</p>
                <p><font size="6"><strong><H4>Agregados de H2SO4 a Circuitos</H4></strong></font></p>
              </div></TD>
            </TR>
            <TR class=lcol> 
              <TD width=10% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
              <TD width=30% ><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
              <TD width="30%"><div align="center"><font size="6"><strong>CIRCUITO</strong></font></div></TD>
              <TD width="30%"><div align="center"><font size="6"><strong>VOLUMEN(m3)</strong></font></div></TD>
            </TR>
           <?php
                $consulta = "select t1.turno,t1.circuito_h2so4,t1.volumen_h2so4,t2.valor_subclase1 from ref_web.electrolito as t1 ";
	            $consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                $consulta .="on t1.turno=t2.nombre_subclase and t2.cod_clase = '1' ";			
				$consulta.="WHERE fecha='".$fecha."' ORDER BY t2.valor_subclase1,t1.fecha ASC  ";
				$respuesta=mysqli_query($link, $consulta);
                if (!$row = mysqli_fetch_array($respuesta))
                   {
				     echo'<TR class=lcol> ';
                        echo'<TD colspan="5" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
                     echo'</TR>'; 
				   } 
                else
                {
				   $respuesta=mysqli_query($link, $consulta);
				   $i=0;
                   while($row = mysqli_fetch_array($respuesta))
                   {
                    $i++;
                    echo'<TR class=lcol> ';
                    echo'<TD width="5%" ><div align="center"><B>'.$i.'</B></div></TD>';
                    echo'<TD width="10%" ><div align="center"><B>'.$row["turno"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["circuito_h2so4"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["volumen_h2so4"].'</B></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Eliminar('$fecha','".$row["turno"]."','".$row["circuito_h2so4"]."')\">";
					echo '<img src="archivos/papelera.gif" width="15" height="15"></A></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Modificar('$fecha','".$row["turno"]."','".$row["circuito_h2so4"]."','".$row["volumen_h2so4"]."')\">";
					echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
                    echo'</TR>';
                   }
                }
            ?>
        </TABLE>
    </TD>
   </TR>
      <TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TR class=lcol> 
              <TD  colspan=6 vAlign=top class=dt><div align="center">
                <p>&nbsp;</p>
                <p><font size="6"><strong>
                <H4>Envios a Descobrizacion Parcial</H4>
                </strong></font></p>
              </div></TD>
            </TR>
            <TR class=lcol> 
              <TD width=10% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
              <TD width=30% ><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
              <TD width="30%"><div align="center"><font size="6"><strong>CIRCUITO</strong></font></div></TD>
              <TD width="30%"><div align="center"><font size="6"><strong>VOLUMEN(m3)</strong></font></div></TD>
            </TR>
           <?php
                $consulta = "select t1.turno,t1.circuito_dp,t1.volumen_dp,t2.valor_subclase1 from ref_web.desc_parcial as t1 ";
				$consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                $consulta .="on t1.turno=t2.nombre_subclase and t2.cod_clase = '1' ";			
				$consulta.="WHERE fecha='".$fecha."' ORDER BY t2.valor_subclase1,t1.fecha ASC  ";
                $respuesta=mysqli_query($link, $consulta);
                if (!$row = mysqli_fetch_array($respuesta))
                   {
				     echo'<TR class=lcol> ';
                        echo'<TD colspan="5" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
                     echo'</TR>'; 
				   } 
                else
                {
				   $respuesta=mysqli_query($link, $consulta);
				   $i=0;
                   while($row = mysqli_fetch_array($respuesta))
                   {
                    $i++;
                    echo'<TR class=lcol> ';
                    echo'<TD width="5%" ><div align="center"><B>'.$i.'</B></div></TD>';
                    echo'<TD width="10%" ><div align="center"><B>'.$row["turno"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["circuito_dp"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["volumen_dp"].'</B></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Eliminar2('$fecha','".$row["turno"]."','".$row["circuito_dp"]."')\">";
					echo '<img src="archivos/papelera.gif" width="15" height="15"></A></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Modificar2('$fecha','".$row["turno"]."','".$row["circuito_dp"]."','".$row["volumen_dp"]."')\">";
					echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
                    echo'</TR>';
                   }
                }
            ?>
        </TABLE>
    </TD>
   </TR>
<TR class=lcol vAlign=top> 
        <TD colSpan=6 bgcolor="#0066CC"> 
         <TABLE width="100%" border=0 cellPadding=2 cellSpacing=2>
            <TR class=lcol> 
              <TD  colspan=6 vAlign=top class=dt><div align="center">
                <p><font size="6"><strong>
                <H4>Envio a Planta deTratamiento Electrolito</H4>
                </strong></font></p>
              </div></TD>
            </TR>
            <TR class=lcol> 
              <TD width=10% ><div align="center"><font size="6"><strong>#</strong></font></div></TD>
              <TD width=20% ><div align="center"><font size="6"><strong>TURNO</strong></font></div></TD>
              <TD width="25%"><div align="center"><font size="6"><strong>CIRCUITO</strong></font></div></TD>
              <TD width="25%"><div align="center"><font size="6"><strong>DESTINO</strong></font></div></TD>
              <TD width="25%"><div align="center"><font size="6"><strong>VOLUMEN(m3)</strong></font></div></TD>
            </TR>
           <?php
                $consulta = "select turno,circuito_pte,destino_pte,volumen_pte,t2.valor_subclase1 from ref_web.tratamiento_electrolito as t1 ";
				$consulta .="inner join proyecto_modernizacion.sub_clase as t2 "; 
                $consulta .="on t1.turno=t2.nombre_subclase and t2.cod_clase = '1' ";			
				$consulta.="WHERE fecha='".$fecha."' ORDER BY t2.valor_subclase1,t1.fecha ASC  ";
                $respuesta=mysqli_query($link, $consulta);
                if (!$row = mysqli_fetch_array($respuesta))
                   {
				     echo'<TR class=lcol> ';
                        echo'<TD colspan="5" height="50"><div align="center"><B>NO HAY REGISTROS</B></div></TD>';
                     echo'</TR>'; 
				   } 
                else
                {
				   $respuesta=mysqli_query($link, $consulta);
				   $i=0;
                   while($row = mysqli_fetch_array($respuesta))
                   {
                    $i++;
                    echo'<TR class=lcol> ';
                    echo'<TD width="5%" ><div align="center"><B>'.$i.'</B></div></TD>';
                    echo'<TD width="10%" ><div align="center"><B>'.$row["turno"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["circuito_pte"].'</B></div></TD>';
                    echo'<TD width="20%" ><div align="center"><B>'.$row["destino_pte"].'</B></div></TD>';
					echo'<TD width="20%" ><div align="center"><B>'.$row["volumen_pte"].'</B></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Eliminar3('$fecha','".$row["turno"]."','".$row["circuito_pte"]."')\">";
					echo '<img src="archivos/papelera.gif" width="15" height="15"></A></div></TD>';
					echo'<TD width="10%" ><div align="center">';
					echo "<a href=\"JavaScript:Modificar3('$fecha','".$row["turno"]."','".$row["circuito_pte"]."','".$row["destino_pte"]."','".$row["volumen_pte"]."')\">";
					echo '<img src="archivos/modificar.gif" width="15" height="15"></A></div></TD>';
                    echo'</TR>';
                   }
                }
            ?>
        </TABLE>
    </TD>
   </TR>
  </TABLE>
<P>&nbsp;</P>
</form>
</body>
</html>
