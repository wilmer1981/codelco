<? include("../principal/conectar_ram_web.php")?>
<html>
<head>
<title>Busqueda de Conjuntos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_conjunto()
{
var f = frmPoPup;

    f.action="ram_ing_movimientos03.php?Proceso=B";
	f.submit();
}

function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var valor = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i].value;
		}
	}
	return valor;
}
//*********************//
function Enviar(f)
{
	var valor = ValidaSeleccion(f,'radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
		valores = "&num_conjunto_aux_d=" + valor + "&cmbtipo_aux_d=" + f.cmbtipo.value;
		window.opener.document.formulario.action = "ram_ing_movimientos.php?Proceso=B&Proceso2=B&mostrar2=S"+valores;
		window.opener.document.formulario.submit();
		window.close();
    }
	else
	{
		alert('No hay Conjunto Seleccionado');
		return
    }
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    <table cellpadding="3" cellspacing="0" width="550" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="5"><div align="center">Busqueda de Conjuntos</div></td>
      </tr>
      <tr> 
        <td>T. Conjunto</td>
        <td colspan="4"> <?
			  
			  echo'<select name="cmbtipo" style="width:150">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_principal.php"); 
			  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001";
			  $rs = mysql_query($consulta);
			  
			  while($row = mysql_fetch_array($rs))
			  {
				if ($row[cod_subclase] == $cmbtipo)
					echo '<option value="'.$row[cod_subclase].'" selected>'.$row[nombre_subclase].'</option>';
				else
					echo '<option value="'.$row[cod_subclase].'">'.$row[nombre_subclase].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
        </td>
      </tr>
      <tr> 
        <td width="75" height="26">Producto</td>
        <td width="197"> 
          <?
			  echo'<select name="cmbproducto" style="width:230">';              

			  echo'<option value = "-1" selected>SELECCIONAR</option>';
 			  include("../principal/conectar_ram_web.php"); 
			  $consulta = "SELECT * FROM producto ORDER BY COD_PRODUCTO";
			  $rs = mysql_query($consulta);
			  
			  while($row = mysql_fetch_array($rs))
			  {
				if ($row[COD_PRODUCTO] == $cmbproducto)
					echo '<option value="'.$row[COD_PRODUCTO].'" selected>'.$row[DESCRIPCION].'</option>';
				else
					echo '<option value="'.$row[COD_PRODUCTO].'">'.$row[DESCRIPCION].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
        </td>
        <td width="308" colspan="3"> <input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_conjunto();"></td>
      </tr>
    </table>
    <?
if($Proceso == 'B')
{
    echo'<table cellpadding="3" cellspacing="0" width="550" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
      <td height="20%" colspan="2"><div align="center">Número Conjunto</div></td>
      <td width="30%"><div align="center">Nombre Conjunto</div></td>
      <td width="30%"><div align="center">Lugar</div></td>
      <td width="20%"><div align="center">Stock</div></td>
    </tr>
  </table>
  </div>
  <div align="left" style="position:absolute; overflow:auto; top: 105px; height: 375px;"> 
  <table cellpadding="0" cellspacing="0"  width="550" border="1" class="TablaDetalle">';  
 
	include("../principal/conectar_ram_web.php");
					$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = $cmbtipo AND cod_producto = $cmbproducto ORDER BY num_conjunto"; 
					
					$rs = mysql_query($consulta);

					while ($row = mysql_fetch_array($rs))
					{
						echo '<tr><td width="10%" align="center">';
						echo '<input type="radio" name="radio" value="'.$row[num_conjunto].'"></td>';
						echo '<td width="10%"><div align="center">'.$row[num_conjunto].'</div></td>';
						echo '<td width="30%"><div align="center">'.$row[descripcion].'</div></td>';
					
					    $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $row[cod_lugar] AND num_lugar = $row[num_lugar] ";
					    $rs2 = mysql_query($consulta);
					   
					    if($row2 = mysql_fetch_array($rs2))
					    {
							$lugar_origen = $row2[descripcion_lugar];
	   						echo '<td width="30%"><div align="center">'.$lugar_origen.'</div></td>';					 
					    }

					    $consulta = "SELECT * FROM movimiento_proveedor WHERE cod_existencia = 01 AND cod_conjunto = $row[cod_conjunto] AND num_conjunto = $row[num_conjunto] ";
					    $rs3 = mysql_query($consulta);

					    if($row3 = mysql_fetch_array($rs3))
						{
								$stock = $row3[peso_humedo];

								echo '<td width="20%"><div align="center">'.$stock.'</div></td></tr>';
						}

					}


		
}

?></table>
    </div>
  
  <div align="left" style="position:absolute; top: 475px; left: 24px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
          <input name="btnaceptar" type="button" style="width:70" value="Aceptar" onClick="JavaScript:Enviar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<? include("../principal/cerrar_ram_web.php") ?>
