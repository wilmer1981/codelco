<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 3;
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
	linea = "opcion=" + opc;
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			linea = linea + "&txtgrupo=" + ValorCheckBox(f);
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay ms de Una Casilla Marcada");
			return;
		}
	}	
		
	window.open("sec_ing_grupo_electrolitico_proceso_ref.php?opcion2=B&Dia=" + f.Dia.value +"&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value + "&" + linea,"","top=195,left=180,width=437,height=360,scrollbars=no,resizable = no");
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
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "sec_ing_grupo_electrolitico_proceso01_ref.php?proceso=E&parametros=" + valores;
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
	document.frmPrincipal.action = "sec_ing_grupo_electrolitico_ref.php";
	document.frmPrincipal.submit();
}

</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
  
  <table width="770" height="315" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="200" align="center" valign="top"><table width="100%" border="0" class="TablaInterior">
          <tr>
            <td width="11%">Dia/Mes/A&ntilde;o:&nbsp;</td>
            <td width="89%"><select name="Dia" style="width:50px;">
                <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($Dia))
							{
								if ($Dia == $i)
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
              </select>
              <select name="Mes" style="width:100px">
			<?php
				$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
        </select>
              <select name="Ano" style="width:100px">
                <?php				
				for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option value='".$i."' selected>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option value='".$i."' selected>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select>
              <input name="BtnOK" type="button" id="BtnOK" value="Buscar" onClick="Recarga();"> </td>
          </tr>
        </table>        
        <div style="position:absolute; left: 12px; top: 100px; width: 730px; height: 30px;" id="div1">
          <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="58" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
                Todo</td>
			  <td width="52" align="center">Grupo</td>
              <td width="56" align="center">Circuito</td>
              <td width="44" align="center">Total Cubas</td>
              <td width="51" align="center">Estado</td>
              <td width="72" align="center">Cubas Descobriz.</td>
              <td width="66" align="center">Hojas Madres</td>
              <td width="77" align="center">Catodos Por Celda</td>
              <td width="77" align="center">Anodos Por Celda</td>
              <td width="79" align="center">Cubas de Lavado</td>
              <td width="98" align="center">Calle Puente Grua</td>
            </tr>
          </table>
 
 </div>
 
		
        <div style="position:absolute; left: 10px; top: 127px; width: 750px; height: 189px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php		
	if ($Mes < 10)
		$Mes = "0".$Mes;
	if ($Dia < 10)
	    $Dia= "0".$Dia;	
	$consulta_grupo="select distinct max(fecha) as fecha1,cod_grupo from ref_web.grupo_electrolitico2 where fecha <='".$Ano."-".$Mes."-".$Dia."'  group by cod_grupo order by cod_grupo ";
	$rs_grupos=mysqli_query($link, $consulta_grupo);	
	while ($row_grupos = mysqli_fetch_array($rs_grupos))
	     {  
		   $consulta_datos="SELECT max(fecha),cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
	       $consulta_datos.=" FROM ref_web.grupo_electrolitico2 "; 
	       $consulta_datos.=" where fecha ='".$row_grupos[fecha1]."' and cod_grupo = '".$row_grupos["cod_grupo"]."' group by cod_grupo order by cod_grupo";
		   $rs = mysqli_query($link, $consulta_datos);
	       $row = mysqli_fetch_array($rs);
		   
		   $consulta_datos_sec="SELECT fecha,cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado  ";
	       $consulta_datos_sec.=" FROM sec_web.grupo_electrolitico2 "; 
	       $consulta_datos_sec.=" where fecha ='".$Ano."-".$Mes."-01' and cod_grupo = '".$row_grupos["cod_grupo"]."' group by cod_grupo order by cod_grupo";
		   //echo $consulta_datos_sec;
		   $rs_sec = mysqli_query($link, $consulta_datos_sec);
	       if ($row_sec = mysqli_fetch_array($rs_sec))
		      {		   
				$actualizar_ge2 = "UPDATE sec_web.grupo_electrolitico2 SET cod_circuito = '".$row[cod_circuito]."', num_cubas_tot = '".$row[num_cubas_tot]."'";
				$actualizar_ge2.= ", cubas_descobrizacion = '".$row[cubas_descobrizacion]."', hojas_madres = '".$row[hojas_madres]."', cod_estado = '".$row["cod_estado"]."'";
				$actualizar_ge2.= ", num_catodos_celdas = '".$row[num_catodos_celdas]."', num_anodos_celdas = '".$row[num_anodos_celdas]."'";
				$actualizar_ge2.= ", calle_puente_grua = '".$row[calle_puente_grua]."', cubas_lavado = '".$row[cubas_lavado]."'";
				$actualizar_ge2.= " WHERE cod_grupo = '".$row_grupos["cod_grupo"]."'";
				$actualizar_ge2.= " and fecha= '".$Ano."-".$Mes."-01'";
				//echo $actualizar_ge2;
				 mysqli_query($link, $actualizar_ge2);
			 }
			else {
			        $insertar = "INSERT INTO sec_web.grupo_electrolitico2 (fecha,cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
					$insertar = $insertar." VALUES ('".$Ano."-".$Mes."-01','".$row_grupos["cod_grupo"]."','".$row[cod_circuito]."','".$row[num_cubas_tot]."','".$row["cod_estado"]."','".$row[cubas_descobrizacion];
					$insertar = $insertar."','".$row[hojas_madres]."','".$row[num_catodos_celdas]."','".$row[num_anodos_celdas]."','".$row[calle_puente_grua]."','".$row[cubas_lavado]."')";
					//echo $insertar;
					mysqli_query($link, $insertar);
			
			
			      } 	 
		   
		   
		   
		   
		   echo '<tr>';
		   echo '<td width="55" height="25"><input type="checkbox" name="checkbox" value="'.$row["cod_grupo"].'"></td>';
		   echo '<td width="50" align="center">'.$row["cod_grupo"].'</td>';
		   echo '<td width="55" align="center">'.$row[cod_circuito].'</td>';
		   echo '<td width="43" align="center">'.$row[num_cubas_tot].'&nbsp;</td>';
		   echo '<td width="50" align="center">'.$row["cod_estado"].'&nbsp;</td>';
		   echo '<td width="70" align="center">'.$row[cubas_descobrizacion].'&nbsp;</td>';
		   echo '<td width="64" align="center">'.$row[hojas_madres].'&nbsp;</td>';
		   echo '<td width="75" align="center">'.$row[num_catodos_celdas].'&nbsp;</td>';
		   echo '<td width="75" align="center">'.$row[num_anodos_celdas].'&nbsp;</td>';
		   echo '<td width="77" align="center">'.$row[cubas_lavado].'&nbsp;</td>';
		   echo '<td width="89" align="center">'.$row[calle_puente_grua].'&nbsp;</td>';		
		   echo '</tr>';
		 
		 
		 }
		

?>
</table> 
</div>       

        <div style="position:absolute; left: 15px; width: 730px; height: 26px; top: 330px;" id="div3"> 
          <table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
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
