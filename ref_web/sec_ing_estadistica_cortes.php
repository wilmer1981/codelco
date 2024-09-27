<?php 
	include("../principal/conectar_principal.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 5;


	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$mostrar  = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$dia2    = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:date("d");
	$mes2    = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date("m");
	$ano2    = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date("Y");

	$mensaje  = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";

	
	function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
?>

<html>
<head>
<title>Ingreso Estadisticas de Cortes</title>
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
/*****************/
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
/*****************/
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
			
			linea = linea + "&grupo=" + valor[0];
			linea = linea + "&fecha_desconexion=" + valor[1];
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay más de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("sec_ing_estadistica_cortes_proceso.php?"+linea,"","top=195,left=180,width=517,height=238,scrollbars=no,resizable = no");
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
		if (confirm("Esta Seguro de Eliminar los Registros Seleccionados"))
		{
			f.action = "sec_ing_estadistica_cortes_proceso01.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
/****************/
function Buscar(f)
{
	linea = "mostrar=S&dia1=" + f.dia1.value + "&mes1=" + f.mes1.value + "&ano1=" + f.ano1.value;
	linea = linea + "&dia2=" + f.dia2.value + "&mes2=" + f.mes2.value + "&ano2=" + f.ano2.value;
	f.action = "sec_ing_estadistica_cortes.php?" + linea;
	f.submit();
}
/****************/
function Excel(f)
{
	f.action = "sec_xls_estadistica_cortes.php";
	f.submit();
}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}
</script></head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
        <td width="762" align="center" valign="middle">
          <table width="730" border="0" cellpadding="3" class="TablaInterior">
            <tr> 
              <td width="67">Desde</td>
              <td width="227"><select name="dia1" size="1" id="select2">
				<?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{	
						if (($mostrar == "S") && ($i == $dia1))			
							echo '<option selected value="'.$i.'">'.$i.'</option>';				
						else if (($i == date("j")) and ($mostrar != "S")) 
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else					
							echo '<option value="'.$i.'">'.$i.'</option>';												
					}		
				?>
                </select> <select name="mes1" size="1" id="mes1">
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
                </select> <select name="ano1" size="1" id="select4">
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
                </select></td>
              <td width="47">Hasta</td>
              <td width="215"><select name="dia2" size="1" id="dia2">
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{	
						if (($mostrar == "S") && ($i == $dia2))			
							echo '<option selected value="'.$i.'">'.$i.'</option>';				
						else if (($i == date("j")) and ($mostrar != "S")) 
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else					
							echo '<option value="'.$i.'">'.$i.'</option>';												
					}		
				?>
                </select> <select name="mes2" size="1" id="select3">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes2))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';			
					}		  
				?>
                </select> <select name="ano2" size="1" id="select5">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano2))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
                </select></td>
              <td width="140"><input name="btnbuscar" type="button" value="Buscar" onClick="Buscar(this.form)"></td>
            </tr>
          </table>  

        <br>
        <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
		<tr class="ColorTabla01"> 
			<td width="63"><input type="checkbox" name="checkbox" onClick="SeleccionarTodos(this.form)">
			Todo</td>
			<td width="54" align="center">Grupo</td>	  
			<td width="82" align="center">Tipo Desconexion</td>
			<td width="166" align="center">Fecha y Hora Desconexion</td>
			<td width="95" align="center">Kah dir d.</td>
			<td width="165" align="center">Fecha y Hora Conexion</td>
			<td width="89" align="center">Kah dir c.</td>
		</tr>
		</table>



<table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php
	if ($mostrar == "S")
	{
		$desde = $ano1.'-';
		if (strlen($mes1) == 1)
			$desde = $desde.'0';
		$desde = $desde.$mes1.'-';
		if (strlen($dia1) == 1)
			$desde = $desde.'0';
		$desde = $desde.$dia1;

		$hasta = $ano2.'-';
		if (strlen($mes2) == 1)
			$hasta = $hasta.'0';
		$hasta = $hasta.$mes2.'-';
		if (strlen($dia2) == 1)
			$hasta = $hasta.'0';
		$hasta = $hasta.$dia2;						
	
		$consulta = "SELECT * FROM sec_web.cortes_refineria AS t1";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.sub_clase AS t2";
		$consulta = $consulta." ON t1.tipo_desconexion = t2.valor_subclase1";
		$consulta = $consulta." WHERE t2.cod_clase = 3000";
		$consulta = $consulta." AND t1.fecha_desconexion BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59'";
		$consulta = $consulta." ORDER BY t1.fecha_desconexion DESC";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		
		while ($row = mysqli_fetch_array($rs))
		{		
			echo '<tr>';
			echo '<td width="63" height="25">';
			echo '<input type="checkbox" name="checkbox" value="'.$row["cod_grupo"].'/'.$row["fecha_desconexion"].'"></td>';
			echo '<td width="54" align="center">'.$row["cod_grupo"].'</td>';
			echo '<td width="82" align="center">'.$row["nombre_subclase"].'</td>';			
			echo '<td width="166" align="center">'.FormatoFecha($row["fecha_desconexion"]).'</td>';
			echo '<td width="95" align="center">'.$row["kahdird"].'</td>';
			echo '<td width="165" align="center">'.FormatoFecha($row["fecha_conexion"]).'</td>';
			echo '<td width="89" align="center">'.$row["kahdirc"].'</td>';
			echo '</tr>';
		}
	}
?>
</table>


<br>
<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  <tr>
    <td align="center"><input name="btnnuevo" type="button" value="Nuevo" style="width:70" onClick="Proceso(this.form,'N')">
      <input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="Proceso(this.form,'M')">
      <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="Eliminar(this.form)">
              <input name="btnexcel" type="button" value="Excel" style="width:70" onClick="Excel(this.form)"> 
              <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="Salir()"></td>
  </tr>
</table>


</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>

<?php include("../principal/cerrar_sec_web.php"); ?>