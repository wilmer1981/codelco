
<?php include("../principal/conectar_ref_web.php"); 

$DiaIni    = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
$MesIni    = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
$AnoIni    = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");	

$DiaFin    = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
$MesFin    = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
$AnoFin    = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");

$proceso    = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
/*
    if (!isset($DiaIni) and ($fecha_ini==''))
	{
	 	   $MesIni = date("m");
		   $AnoIni = date("Y");
	}
	*/
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	?>
<HTML>
<HEAD>
<TITLE>Informe Datos Consumo de Energia Electrica y Produccion de Hojas Para C.I.</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/**********/
function Recarga1()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini.php?recargapag1=S";
	f.submit();
}
/**********/
function Recarga2()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini02.php?recargapag2=S";
	f.submit();
}
/**********/
function Excel()

{
	var  f=document.frmPrincipal;
	var AnoIni=f.AnoIni.value;
	var MesIni=f.MesIni.value;
	document.location = "../ref_web/datos_consumo_xls.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&proceso=C";
}
/**********/
function Proceso(f)
{
	var f = document.frmPrincipal;
	f.action = "datos_consumo.php?proceso=C";
	f.submit();
}
function lectura()
{

 window.open("lectura_rectificador_proceso.php?proceso=M","","top=195,left=180,width=420,height=180,scrollbars=no,resizable = no");
}
function ValorCheckBox(f)
{
	for(i=1; i<f.checkbox.length; i++)	
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
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '~';
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
/*poly 09-03-05function Eliminar(f)
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
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "ref_elimina_datos_consumo.php?opcion=E&parametros=" + valores;
			f.submit();
		}
	}
}*/
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY background="../principal/imagenes/fondo3.gif" >
<FORM name="frmPrincipal" action="" method="post">
  <p align="center"><font color="#0000FF"><strong>Informe de Datos de Consumo 
    de Energia Electrica y Produccion de Hojas para CI</strong></font></p>
          </div>
        <div align="left"> 
    <table width="955" border="0" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="95">Informe </td>
        <td width="271"> 
		<?php	echo '<input name="DiaIni" type="hidden" value="01" size="1" readonly >'; ?>
          <select name="MesIni" style="width:90px;">
            <?php    
						for ($i = 1;$i <= 12; $i++)
						{$Meses=array('Enero','Febrero','Marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
							if (isset($MesIni))
							{
								if ($MesIni == $i)
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
          </select> <select name="AnoIni" style="width:60px;">
            <?php
						for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
						{
							if (isset($AnoIni))
							{
								if ($AnoIni == $i)
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
          </select> <font face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
        <td width="63"> <div align="left"> 
            <input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
          </div>
          <div align="left"></div></td>
        <td width="489"> <div align="left"> </div>
          <div align="left"><font face="Arial, Helvetica, sans-serif"> </font><font face="Arial, Helvetica, sans-serif"> 
            </font></div></td>
      </tr>
    </table>
          <font face="Arial, Helvetica, sans-serif"> </font></div></td>
    </tr>
    <tr> 
      <td height="88" align="center" bordercolor="#0000FF"> <div align="left"> 
          
        <table width="955" height="27" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="TablaDetalle">
        <tr class="ColorTabla01"> 
		<?php
		  /*poly 09-03-05  <td width="58" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
		  Todo</td>*/
		?>	
            <td width="120" height="24"> <div align="center"><font color="#FFFFFF"><strong>fecha</strong></font></div></td>
            <td width="120"> <div align="center"></div>
              <div align="center"><strong>K.A.H. REC-1</strong></div></td>
            <td width="120"><div align="center">PROM K.A</div></td>
            <td width="120"><div align="center">Peso Hoja Buena</div></td>
            <td width="120"><div align="center">Peso Hoja Rech.</div></td>
            <td width="120"><div align="center">Peso Total Producc. Hojas</div></td>
          </tr>
        </table>
          <table width="955" border="1">
            <tr>
			<?php 
			    if ($proceso == "C")
              	 {           
				              $FechaInicio = $AnoIni."-".$MesIni."-01";
							  $fecha_termino = $AnoIni."-".$MesIni."-31";
							  $consulta="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha between '".$FechaInicio."' and '".$fecha_termino."' order by fecha asc";
							  $respuesta = mysqli_query($link, $consulta);
					          while ($row= mysqli_fetch_array($respuesta))
						            {
									  $meses=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
									  $dia=substr($row["fecha"],8,2);
									  $mes=substr($row["fecha"],5,2);
									  $ano=substr($row["fecha"],0,4);
									  $cont=intval($mes);
							          $mes1=$meses[$cont-1];
	                                  $fecha2=$dia."-".$mes1;
									 //poly 09-03-05 echo '<td width="3.5%" height="25"><input type="checkbox" name="checkbox" value="'.$row["fecha"].'"></td>';
									  echo "<td width='7%' align='center' class=detalle01><font color='blue'>".$fecha2."&nbsp;</font></td>\n";
									  echo "<td width='7%' align='center' class=detalle02><font color='blue-red-white'>".$row["lectura_rectificador"]."&nbsp;</font></td>\n";
									  if ($dia=='01')
									     {
										   $mes_aux=intval($mes);
										   if ($mes_aux==1)
										      {
											    $mes_aux=strval(12);
												$ano_aux=strval(intval($ano-1));
												$ano=$ano_aux;
												$fecha_ini=$ano."-".$mes_aux."-01";
												$fecha_ter=$ano."-".$mes_aux."-31";
											  }
										   else{$mes_aux=($mes_aux-1);
										        $fecha_ini=$ano."-".$mes_aux."-01";
												$fecha_ter=$ano."-".$mes_aux."-31";}
										   $consulta2="select max(fecha) as fecha from ref_web.detalle_produccion where fecha between '$fecha_ini' and '$fecha_ter' ";
										   $respuesta2 = mysqli_query($link, $consulta2);
					                       $row2= mysqli_fetch_array($respuesta2);
										   $consulta_rect_ant="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha ='".$row2["fecha"]."' ";
										   $respuesta_rect_ant = mysqli_query($link, $consulta_rect_ant);
					                       $row_rect_ant= mysqli_fetch_array($respuesta_rect_ant); 
										  }	
										       
										   else {$dia_aux=strval(intval($dia-1));
										        $fecha_ini=$ano."-".$mes."-".$dia_aux;
												$consulta2="select max(fecha) as fecha from ref_web.detalle_produccion where fecha = '$fecha_ini' ";
												$respuesta2 = mysqli_query($link, $consulta2);
					                            $row2= mysqli_fetch_array($respuesta2);
												$consulta_rect_ant="select fecha,lectura_rectificador from ref_web.detalle_produccion where fecha = '$fecha_ini' ";
												$respuesta_rect_ant = mysqli_query($link, $consulta_rect_ant);
					                            $row_rect_ant= mysqli_fetch_array($respuesta_rect_ant); 	}   
									  $consulta3="select lectura_rectificador from ref_web.detalle_produccion where fecha ='".$row2["fecha"]."'";
									  $respuesta3 = mysqli_query($link, $consulta3);
					                  $row3= mysqli_fetch_array($respuesta3);
									  $promedio=number_format((($row["lectura_rectificador"]-$row_rect_ant["lectura_rectificador"])/24),"2",".","");
									  if ($promedio < 0)
									     {$promedio = 0;
										  }
									  echo "<td width='7%' align='center' class=detalle01>$promedio&nbsp;</td>\n";
									  /**********laminas aprovadas NE hoy ********************************************************************************/
						
									  $consulta_lam_apro="select sum(peso_produccion) as aprobadas,sum(peso_tara) as tara_aprobadas ";
									  $consulta_lam_apro.="from sec_web.produccion_catodo ";
									  $consulta_lam_apro.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
									  $consulta_lam_apro.="and cod_subproducto='1'";
									  //echo  $consulta_lam_apro."<br>";
									  $respuesta_lam_apro = mysqli_query($link, $consulta_lam_apro);
									  $row_lam_apro= mysqli_fetch_array($respuesta_lam_apro);
									
									  /*********************************************************************************************************/
						
						
									  /**********laminas co hoy ********************************************************************************/
									  $consulta_lam_co="select sum(peso_produccion) as co,sum(peso_tara) as tara_co ";
									  $consulta_lam_co.="from sec_web.produccion_catodo ";
									  $consulta_lam_co.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
									  $consulta_lam_co.="and cod_subproducto='2'";
									  $respuesta_lam_co= mysqli_query($link, $consulta_lam_co);
									  $row_lam_co= mysqli_fetch_array($respuesta_lam_co);
									  //echo $consulta_lam_co."<br>";
									  /*************************************laminas venta*******************************************************************/
									  $consulta_lam_ven="select sum(peso_produccion) as venta, sum(peso_tara) as tara_venta ";
									  $consulta_lam_ven.="from sec_web.produccion_catodo ";
									  $consulta_lam_ven.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
									  $consulta_lam_ven.="and cod_subproducto='4'";
									  //echo $consulta_lam_ven."<br>";
									  $respuesta_lam_ven= mysqli_query($link, $consulta_lam_ven);
									  $row_lam_ven= mysqli_fetch_array($respuesta_lam_ven);
									  $peso_hoja_buena=($row_lam_apro["aprobadas"]-$row_lam_apro["tara_aprobadas"])+($row_lam_co["co"]-$row_lam_co["tara_co"])+($row_lam_ven["venta"]-$row_lam_ven["tara_venta"]);
									  //echo $peso_hoja_buena.'='.$row_lam_apro["aprobadas"].'+'.$row_lam_co["co"].'-'.$row_tara_co["tara_co"].'-'.$row_lam_ven["venta"].'-'.$row_tara_ven["tara_venta"].'-'.$row_tara_apro["tara_aprobadas"];
									  /*****************************************************************************************/
									  echo "<td width='7%' align='center' class=detalle02>".$peso_hoja_buena."&nbsp;</td>\n";
									  /*****************************************************************************************/
									  $consulta_sin_orejas="select sum(peso_produccion) as peso_rechazo_sin_orejas, sum(peso_tara) as tara_rechazo_s_orejas ";
									  $consulta_sin_orejas.="from sec_web.produccion_catodo ";
									  $consulta_sin_orejas.="where fecha_produccion='".$row["fecha"]."' and cod_producto='66' ";
									  $consulta_sin_orejas.="and cod_subproducto='5'";
									  //echo $consulta_sin_orejas."<br>";
									  $respuesta_sin_orejas = mysqli_query($link, $consulta_sin_orejas);
									  $row_sin_orejas= mysqli_fetch_array($respuesta_sin_orejas);
									  $peso_hoja_rech=$row_sin_orejas["peso_rechazo_sin_orejas"]-$row_sin_orejas["tara_rechazo_s_orejas"];
									  //echo $peso_hoja_rech.'='.$row_sin_orejas[sin_orejas].'+'.$row_sin_orejas_retorno_hoy[sin_orejas_retorno].'-'.$row_sin_orejas_retorno_ayer[sin_orejas_retorno_ayer]."<br>";
									  /***********************************************************************************************/
									  echo "<td width='7%' align='center' class=detalle01>".$peso_hoja_rech."&nbsp;</td>\n";
									  $peso_prod_hojas=$peso_hoja_buena+$peso_hoja_rech;
									  echo "<td width='7%' align='center' class=detalle02>".$peso_prod_hojas."&nbsp;</td>\n";
									  echo "</tr>\n";
									 }
				}			  
			?>  
          </table>
    </tr>
    <tr>
	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
		<?php
        // poly 09-08-03 <input name="btneliminar" type="button" id="btneliminar" value="Eliminar"style="width:70"  onClick="JavaScript:Eliminar(this.form)">?>
        <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" title="Ejecutar Planilla Excel con datos de informes">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
        </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font><br>
  <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
  </font> 
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	}
?>
