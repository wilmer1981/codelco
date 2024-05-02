<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 38;
	$Dia   = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes   = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano   = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

	$mensaje   = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
?>

<html>
<head>
<title>Ingreso Rectificadores</title>
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
			linea = linea + "&txtrectificador=" + ValorCheckBox(f);
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
		
	window.open("ref_ing_rectificador.php?opcion2=B&Dia=" + f.Dia.value +"&Mes=" + f.Mes.value + "&Ano=" + f.Ano.value + "&" + linea,"","top=195,left=180,width=450,height=170,scrollbars=no,resizable = no,toolbar=no");
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
			f.action = "ref_ing_rectificadores_proceso01.php?proceso=E&parametros=" + valores;
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
	document.frmPrincipal.action = "ref_ing_rectificadores.php";
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
							}/*
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}*/
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
					}/*
					else
					{
						if ($i == date("n"))
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}*/
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
					}/*
					else
					{
						if ($i == date("Y"))
							echo "<option value='".$i."' selected>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
			?>
              </select>
              <input name="BtnOK" type="button" id="BtnOK" value="Buscar" onClick="Recarga();"> </td>
          </tr>
        </table>        
        <div style="position:absolute; left: 12px; top: 100px; width: 730px; height: 30px;" id="div1">
          <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="52" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
                Todo</td>
              <td align="center">Cod Rectificador</td>
              <td align="center">Descripcion Rectificador</td>
              <td align="center">Corriente Aplicada</td>
            </tr>
          </table>
 
 </div>
 
		
        <div style="position:absolute; left: 6px; top: 127px; width: 750px; height: 189px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php		
	if ($Mes < 10)
		$Mes = "0".$Mes;
	if ($Dia < 10)
	    $Dia= "0".$Dia;	
	$consulta_rectificador="select distinct max(fecha) as fecha1,cod_rectificador from ref_web.rectificadores where fecha <='".$Ano."-".$Mes."-".$Dia."'  group by cod_rectificador order by cod_rectificador ";
	$rs_rectificador=mysqli_query($link, $consulta_rectificador);	
	while ($row_rectificador = mysqli_fetch_array($rs_rectificador))
	     {  
		   $consulta_datos="SELECT max(fecha),cod_rectificador,descripcion_rectificador,Corriente_aplicada ";
	       $consulta_datos.=" FROM ref_web.rectificadores "; 
	       $consulta_datos.=" where fecha ='".$row_rectificador["fecha1"]."' and cod_rectificador = '".$row_rectificador["cod_rectificador"]."' group by cod_rectificador order by cod_rectificador";
		   $rs = mysqli_query($link, $consulta_datos);
	       $row = mysqli_fetch_array($rs);
		   echo '<tr>';
		   echo '<td width="35" height="25"><input type="checkbox" name="checkbox" value="'.$row["cod_rectificador"].'"></td>';
		   echo '<td width="85" align="center">'.$row["cod_rectificador"].'</td>';
		   echo '<td width="100" align="center">'.$row["descripcion_rectificador"].'</td>';
		   echo '<td width="55" align="center">'.$row["Corriente_aplicada"].'</td>';
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
	if ($mensaje!="")
	{
		echo '<script language="JavaScript">';		
		echo 'alert("'.$mensaje.'");';			
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>
