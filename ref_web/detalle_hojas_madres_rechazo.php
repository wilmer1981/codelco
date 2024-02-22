<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 3;
	
function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4);
		return $fecha;
	}	
	
	
?>

<html>
<head>
<title>Ingreso Grupo Electrolitico</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
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
/************************/
function Proceso(f,opc)
{
	linea = "opcion=" + opc;
//	linea = linea + "&dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value;
//	linea = linea + "&dia2=" + f.dia2.value + "&mes2=" + f.mes2.value + "&ano2=" + f.ano2.value;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			valor = ValorCheckBox(f).split('/');
			
			linea = linea + "&fecha=" + valor[0];
			
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay m�s de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("Detalle_hojas_madres_rechazo_proceso.php?" + linea+"&checkbox=0","","top=80,left=180,width=500,height=600,scrollbars=no,resizable = no");
}
/*****************/
function Eliminar(f)
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
		if (confirm("Esta Seguro de Eliminar los detalles de rechazo seleccionados"))
		{
			f.action = "proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}

function Imprimir(f)
{
	window.print();
}

/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
/*****************/
function Recarga()
{
	document.frmPrincipal.action = "detalle_hojas_madres_rechazo.php";
	document.frmPrincipal.submit();
}


</script>
</head>
<BODY background="../principal/imagenes/fondo3.gif" >

<form name="frmPrincipal" action="" method="post">

  
 
    
  <tr> 
    <td width="900" height="200" align="center" valign="top"><table width="100%" height="30" border="0" class="TablaInterior">
        <tr> 
          <td width="11%">Desde:&nbsp;</td>
          <td width="28%"><select name="DiaIni" style="width:50px;">
              <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($DiaIni))
							{
								if ($DiaIni == $i)
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
            </select> <select name="MesIni" style="width:90px;">
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
            </select> </td>
          <td width="6%">Hasta</td>
          <td width="27%"><select name="DiaFin" style="width:50px;">
              <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
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
            </select> <select name="MesFin" style="width:90px;">
              <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
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
            </select> <select name="AnoFin" style="width:60px;">
              <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
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
            </select> </td>
          <td width="28%"><input name="BtnOK" type="button" id="BtnOK4" value="Buscar" onClick="Recarga();"></td>
        </tr>
      </table> 
      <div style="position:absolute; left: 8px; top: 56px; width: 973px; height: 30px;" id="div1"> 
        <table width="957" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">
          <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
            <td width="37" height="20" rowspan="2" align="left"> Todo 
              <input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)"></td>
            <td colspan="2" align="center">&nbsp;</td>
            <td colspan="3" align="center"> Grupo 1</td>
            <td colspan="3" align="center"> Grupo 2</td>
            <td colspan="3" align="center"> Grupo7</td>
            <td colspan="3" align="center"> Grupo 8</td>
          </tr>
          <tr class="ColorTabla01"> 
            <td  width="103" align="center">Fecha</td>
            <td  width="100" align="center">recuperado</td>
            <td width="81" align="center" bordercolor="#FFFFFF">Gruesas</td>
            <td width="56" align="center" bordercolor="#FFFFFF">Delgadas</td>
            <td width="68" align="center" bordercolor="#FFFFFF">Granuladas</td>
            <td width="49" align="center" bordercolor="#FFFFFF">Gruesas</td>
            <td width="56" align="center" bordercolor="#FFFFFF">Delgadas</td>
            <td width="68" align="center" bordercolor="#FFFFFF">Granuladas</td>
            <td width="49" align="center" bordercolor="#FFFFFF">Gruesas</td>
            <td width="56" align="center" bordercolor="#FFFFFF">Delgadas</td>
            <td width="68" align="center" bordercolor="#FFFFFF">Granuladas</td>
            <td width="49" align="center" bordercolor="#FFFFFF">Gruesas</td>
            <td width="56" align="center" bordercolor="#FFFFFF">Delgadas</td>
            <td width="68" align="center" bordercolor="#FFFFFF">Granuladas</td>
          </tr>
        </table>
 
 </div>
 
		
        
      <div style="position:absolute; left: 12px; top: 109px; width: 967px; height: 403px; OVERFLOW: auto;" id="div2"> 
        <table width="955" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php

    if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;


		
		
	 $consulta_fecha="SELECT distinct fecha ";
	 $consulta_fecha.=" FROM ref_web.produccion "; 
	 $consulta_fecha.=" where fecha between '".$FechaInicio."' and '".$FechaTermino."' ";
	 $rs = mysqli_query($link, $consulta_fecha);
	 while ($row = mysqli_fetch_array($rs))
	      {
	 
	        $consulta_datos1="SELECT fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado  ";
			$consulta_datos1.=" FROM ref_web.produccion "; 
			$consulta_datos1.=" where fecha ='".$row["fecha"]."' and cod_grupo='1'";
			$rs1 = mysqli_query($link, $consulta_datos1);
			$row1 = mysqli_fetch_array($rs1);

			$consulta_datos2="SELECT fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado  ";
			$consulta_datos2.=" FROM ref_web.produccion "; 
			$consulta_datos2.=" where fecha ='".$row["fecha"]."' and cod_grupo='2'";
			$rs2 = mysqli_query($link, $consulta_datos2);
			$row2 = mysqli_fetch_array($rs2);
			$consulta_datos7="SELECT fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado  ";
			$consulta_datos7.=" FROM ref_web.produccion "; 
			$consulta_datos7.=" where fecha ='".$row["fecha"]."' and cod_grupo='7'";
			$rs7 = mysqli_query($link, $consulta_datos7);
			$row7 = mysqli_fetch_array($rs7);
			$consulta_datos8="SELECT fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado  ";
			$consulta_datos8.=" FROM ref_web.produccion "; 
			$consulta_datos8.=" where fecha ='".$row["fecha"]."' and cod_grupo='8'";
			$rs8 = mysqli_query($link, $consulta_datos8);
			$row8 = mysqli_fetch_array($rs8);
			$consulta_recuperado="select ifnull(recuperado,0) as recuperado from ref_web.recuperado where fecha='".$row["fecha"]."'";
			$rs_recuperado = mysqli_query($link, $consulta_recuperado);
			$row_r = mysqli_fetch_array($rs_recuperado);
			echo '<tr>';
			echo '<td width="25" height="25" align="center"><input type="checkbox" name="checkbox" value="'.$row["fecha"].'"></td>';
			echo '<td width="20" align="center" class="detalle03">'.FormatoFecha($row1["fecha"]).'</td>';
			echo '<td width="65"align="center" class="detalle01">'.$row_r[recuperado].'</td>';
			echo '<td width="50" align="center" class="detalle02">'.$row1[rechazo_gruesas].'</td>';
			echo '<td width="53" align="center" class="detalle01">'.$row1[rechazo_delgadas].'&nbsp;</td>';
			echo '<td width="64" align="center" class="detalle02">'.$row1[rechazo_granuladas].'&nbsp;</td>';
			echo '<td width="45" align="center" class="detalle01">'.$row2[rechazo_gruesas].'</td>';
			echo '<td width="53" align="center" class="detalle02">'.$row2[rechazo_delgadas].'&nbsp;</td>';
			echo '<td width="64" align="center" class="detalle01">'.$row2[rechazo_granuladas].'&nbsp;</td>';
			echo '<td width="45" align="center" class="detalle02">'.$row7[rechazo_gruesas].'</td>';
			echo '<td width="53" align="center" class="detalle01">'.$row7[rechazo_delgadas].'&nbsp;</td>';
			echo '<td width="64" align="center" class="detalle02">'.$row7[rechazo_granuladas].'&nbsp;</td>';
			echo '<td width="45" align="center" class="detalle01">'.$row8[rechazo_gruesas].'</td>';
			echo '<td width="53" align="center" class="detalle02">'.$row8[rechazo_delgadas].'&nbsp;</td>';
			echo '<td width="64" align="center" class="detalle01">'.$row8[rechazo_granuladas].'&nbsp;</td>';
			echo '</tr>';
		 }
		 
		 
		

?>
</table> 
</div>       

        
      <div style="position:absolute; left: 13px; width: 981px; height: 26px; top: 519px;" id="div3"> 
        <table width="981" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
<td align="center">
<input name="btnnuevo" type="button" id="btnnuevo" value="Nuevo" style="width:70" onClick="JavaScript:Proceso(this.form,'N')">
<input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="JavaScript:Proceso(this.form,'M')">
<input name="btneliminar" type="button" id="btneliminar" value="Eliminar"style="width:70"  onClick="JavaScript:Eliminar(this.form)">
<input name="btninprimir" type="button" id="btnimprimir" value="Imprimir"style="width:70"  onClick="JavaScript:Imprimir(this.form)">
<input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="JavaScript:Salir()"></td>
</tr>
</table>
</div>

      </td>
</tr>
</table>

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
