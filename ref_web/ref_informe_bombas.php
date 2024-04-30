<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 27;
	$consulta="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema='10' ";
	//echo $consulta;
	$rss = mysqli_query($link, $consulta);
    $rows = mysqli_fetch_array($rss);
	$permiso=$rows[nivel];
?>

<html>
<head>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<title>Sistema Informacion Refineria Electrolitica Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">

<script language="JavaScript">
function Buscar()
{
	var  f=document.frmPrincipal;
	var fecha=f.ano1.value+"-"+f.mes1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;
	var bombas=f.bombas.value;
	//var checkbox=0;
	document.location = "../ref_web/ref_informe_bombas.php?opcion=H&fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1+"&bombas="+bombas+"&checkbox=0";
}
function ValorCheckBox(f)
{
	for(i=0; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			return f.checkbox[i].value;
	}
}
/***********************/
function SeleccionarTodos(f)
{
	try{	
		if (f.checkbox[0].checked == true)
			valor = true
		else valor = false;
				
		for(i=1; i<f.checkbox.length; i++)	
			f.checkbox[i].checked = valor;
	}catch(e){
	}
}
/************************/
function ValoresChequeados(f)
{
	valores = "";
	for(i=0; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '-';
	}
	return valores;
}
/************************/
function CantidadChecheado(f)
{
	cont = 0;
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			cont++;
	}	
	return cont;
}
/************************/
function Proceso(f,opc)
{
	switch (opc)
	{
		case "M":
				window.open("ref_ing_ren_HM2.php?Proceso=M&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value + "","","top=70,left=100,width=800,height=550,scrollbars=yes,resizable = yes");
				break;
		case "A":
			f.action = "Renovacion_HM.php?opcion=H";
			f.submit();
			break;
		case "E":
		    var valores = "";	
			for(i=1; i<f.elements.length; i++)	
			{
				if ((f.elements[i].name == "checkbox") && (f.elements[i].checked))
					valores = valores + f.elements[i].value;
			}
			if (valores == "")
			{
				alert("Debe seleccionar un registro para Modificar");
				return;
			}
			else
			{
		     alert("Se eliminara el registro para el dia seleccionado");
		     f.action = "ref_ing_ren_HM01.php?Proceso=E&Dia=" + valores + "&Mes=" + f.mes1.value + "&Ano=" + f.ano1.value ;
			 f.submit();
			 break;
			} 	
	}
}
/*****************/
function Modificar(f)
{
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
	  window.open("ref_ing_ren_HM.php?parametros=" + valores+ "","","top=70,left=100,width=380,height=450,scrollbars=no,resizable = no");
	}
}

function Imprimir(f)
{
	window.print();
}

/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}

function Excel(f)
{
	//var  f=document.form1;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	


	//document.location = "../ref_web/Renovacion_HM_excel.php?opcion=H&ano1="+ano+"&mes1="+mes;
	f.action="Renovacion_HM_excel.php?opcion=H&ano1="+ano+"&mes1="+mes;
	f.submit();
}
function Historial(f)
{
  if (f.checkbox.checked)
     {
      f.action="ref_informe_bombas.php?opcion=H&checkbox=1&ver=S";
	  f.submit();
	 }
  else {
        f.action="ref_informe_bombas.php?opcion=H&checkbox=0";
	    f.submit();
	   }	  
}

</script>
</head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
   <TR> 
        <TD    class=tabson      align=middle>
		<TABLE width="773" border=0 cellPadding=0 cellSpacing=0>
        <TBODY>
        <TBODY>
          <TR> 
            <TD width="52"   class=tabson      align=middle><IMG height=40 alt=""  src="archivos/tabFrontOn.gif" width=52 border=0></TD>
            <TD width="175"  class=tabsonline align=middle><B class=tabstext>Informe Estado de Bombas</B></TD>
            <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
            <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_informe_filtros.php"><B>Informe Estado de Filtros</B></A></TD>'; ?>
            <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
            <?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_informe_intercambiador.php"><B>Informe Estado de Intercambiadores</B></A></TD>'; ?>
            <TD width="22"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabEndOff.gif" width=22 border=0></TD>
           
            <?php echo '<TD width="600%" class=tabsline    align=center><B><A style="COLOR: #ffffff" href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'" target=_top><SPAN style="COLOR: #ffffcc"><font size="4"> 
                  </font></SPAN></A></B></TD>'; ?>
          </TR>
        </TBODY>
		</Table>
   
  <table width="770" height="119" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="175" height="32" align="center" valign="middle"><strong>BOMBA:</strong> 
        <select name="bombas" id="bombas">
          <option value="-1" selected>Todo</option>
          <?php
			 $Consulta = "SELECT * FROM ref_web.bombas ORDER BY cod_bomba";
			 //echo $Consulta;
			 $Respuesta = mysqli_query($link, $Consulta);
			 while ($Row = mysqli_fetch_array($Respuesta))
				{
				  //$cod_bomba=$Row[cod_bomba];
                  if($bombas==$Row[cod_bomba])
                     {
					   echo "<option value=".$Row[cod_bomba]." selected>".$Row[bomba]."</option>\n";
           		     }
				  else
					  {
					    echo "<option value='".$Row[cod_bomba]."' >".$Row[bomba]."</option>\n";
					  }
				}
           ?>
        </select> </td>
      <td width="41" align="center" valign="middle">&nbsp;</td>
      <td width="164" align="center" valign="middle"><strong>Historial de Bombas 
        <?php  if ($ver=='S')
	      { ?>
        <input type="checkbox" name="checkbox" value="" onClick="Historial(this.form)" checked>
		  <?php } 
		   else {?>	 <input type="checkbox" name="checkbox" value="" onClick="Historial(this.form)" > <?php } ?>
        </strong></td>
      <td width="348" align="center" valign="middle"><strong> FECHA: </strong> 
        <select name="dia1" size="1" >
          <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{   
					    if (($mostrar == "S") && ($i == $dia1))
						   {  if (($mostrar == "S") && ($Sig == "S"))
						         { 
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
								   $i=$i+1;
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
							     }
							  else if  (($mostrar == "S") && ($Ant == "S"))
							          {
									   $i=$i-1;
									   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
									   $i=$i+1;
									   
									  }
							      else echo '<option selected value="'.$i.'">'.$i.'</option>';
					       }  
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
        </select> <select name="mes1" size="1" id="select">
          <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
        </select> <select name="ano1" size="1" id="select2">
          <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
        </select>
        &nbsp; <input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
    </tr>
    <tr> 
      <td height="71" colspan="4" align="center" valign="middle"> 
          <table width="730" border="2" cellspacing="0" cellpadding="0" bordercolor="white" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="118" height="20" align="left">Equipo</td>
              <td width="72" align="center">Estado</td>
              <td width="128" align="center">Fecha</td>
              <td width="128" align="center">Hora</td>
              <td width="273" align="center">Observacion</td>
            </tr>
          </table>
     
       
          <table width="730" border="2" cellspacing="0" cellpadding="0" class="TablaInterior">
            <?php
			  if ($opcion=='H')
			     {
				  if ($checkbox=='0')
				     {
				      if ($bombas<>'-1')
				        {
			             $consulta="select * from ref_web.historia_bombas where fecha='".$ano1.'-'.$mes1.'-'.$dia1."' and cod_bomba='".$bombas."' order by fecha asc";
					    }
				       else { $consulta="select * from ref_web.historia_bombas where fecha='".$ano1.'-'.$mes1.'-'.$dia1."' order by fecha asc";}	  
					  }
				   else {
				         if ($bombas<>'-1')
						    { $consulta="select * from ref_web.historia_bombas where cod_bomba='".$bombas."' order by fecha asc";}
						 else {$consulta="select * from ref_web.historia_bombas order by fecha asc";}
						} 	
				   //echo $consulta;   
			      $resultado=mysqli_query($link, $consulta);
			      while($row1 = mysqli_fetch_array($resultado))
				    {    
				    
							    if($row1["situacion"]=="En Servicio")
								  {$icono="Indicator1.gif";}
							    if($row1["situacion"]=="Fuera de Servicio")
								  {$icono="Indicator2.gif";}
							    if($row1["situacion"]=="En Observación")
								   {$icono="Indicator3.gif";}
							    if($row1[situacion]=="En Mantención")
								   {$icono="Indicator4.gif";}
							    echo'<TR class=lcolor> ';
								$consulta_equipo=" select * from ref_web.bombas where cod_bomba='".$row1[cod_bomba]."'";
								$resultado_equipo=mysqli_query($link, $consulta_equipo);
			                    $row_equipo = mysqli_fetch_array($resultado_equipo);
								echo'<TD width="118" ><div align="center"><B>'.$row_equipo[bomba].'</B></div></TD>';
							    echo'<TD width="72" ><div align="center"><img src="archivos/'.$icono.'" width="12" height="12"></div></TD>';
							    echo'<TD width="128" ><div align="center"><B>'.$row1["fecha"].'</B></div></TD>';
							    echo'<TD width="128" ><div align"center"><B>&nbsp;'.$row1[hora].'</B></div></TD>';
								echo'<TD width="273" ><div align"center"><B>&nbsp;'.$row1["observacion"].'</B></div></TD>';
							    echo'</TR>';

			      }	  	
		       }		
    
          ?>
          </table>
       
       
          <table width="760" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
            <tr> 
              <td width="743" align="center"><input name="btnExcel" type="button" id="btnexcel" value="Excel"style="width:70"  onClick="JavaScript:Excel(this.form)"> 
                <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()"> 
              </td>
            </tr>
          </table>
       </td>
    </tr>
  </table>
<?php include("../principal/pie_pagina.php")?>
</form>
<?php
	if (isset($mensaje))
	{
		echo '<script language="JavaScript">';		
		echo 'alert("'.$mensaje.'");';			
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>
