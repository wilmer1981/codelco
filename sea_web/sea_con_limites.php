<?php
	$CodigoDeSistema = 2;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["TipoMovimiento"])) {
		$TipoMovimiento = $_REQUEST["TipoMovimiento"];
	}else{
		$TipoMovimiento =  "";
	}
	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto =  "";
	}
	if(isset($_REQUEST["DiaIni"])) {
		$DiaIni = $_REQUEST["DiaIni"];
	}else{
		$DiaIni =  date("d");
	}
	if(isset($_REQUEST["MesIni"])) {
		$MesIni = $_REQUEST["MesIni"];
	}else{
		$MesIni =  date("m");
	}
	if(isset($_REQUEST["AnoIni"])) {
		$AnoIni = $_REQUEST["AnoIni"];
	}else{
		$AnoIni =  date("Y");
	}
	if(isset($_REQUEST["DiaFin"])) {
		$DiaFin = $_REQUEST["DiaFin"];
	}else{
		$DiaFin =  date("d");
	}
	if(isset($_REQUEST["MesFin"])) {
		$MesFin = $_REQUEST["MesFin"];
	}else{
		$MesFin =  date("m");
	}
	if(isset($_REQUEST["AnoFin"])) {
		$AnoFin = $_REQUEST["AnoFin"];
	}else{
		$AnoFin =  date("Y");
	}
	
	

?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		   
		case "E":			
			var Valores = "";
			if (f.TipoProducto.value=="0-0")
			{
					alert("Debe seleccionar Producto");
					return;
					break;
			}

			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{					
					//COD_LEY,SIGNO,VALOR
					var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
				}	
			}
			var Largo = Valores.length;
			Valores = Valores.substring(0,Largo-2);
			
			if(Valores!='')
				{	
			f.action = "sea_con_limites_excel.php?Valores=" + Valores;
			f.submit();
				}
				else
				{
					alert("Debe seleccionar Leyes");
					}
		
			break;
		case "R":
			f.action = "sea_con_limites.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=2";
			f.submit(); 
			break;
		case "W":		
				var Valores = "";
				var cuenta = 0;
				if (f.TipoProducto.value=="0-0")
				{
					alert("Debe seleccionar Producto");
					return;
					break;
				}

				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
					{					
						//COD_LEY,SIGNO,VALOR
						var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
						cuenta = cuenta + 1;
					}	
				}
				var Largo = Valores.length;
				Valores = Valores.substring(0,Largo-2);
				if(Valores!='')
				{f.action = "sea_con_limites_web.php?Valores=" + Valores;
				f.submit();
				
				}
				else
				{
					alert("Debe seleccionar Leyes");
					}break;
		
		case "GP": //GUARDA PLANTILLA
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{					
					//COD_LEY,SIGNO,VALOR
					var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
				}	
			}
			var Largo = Valores.length;
			Valores = Valores.substring(0,Largo-2);
			var msg = confirm("�Confirma que desea Guardas esta Plantilla\nSe reemplazaran las anteriores?");
			if (msg==true)
			{
				f.action = "sea_con_limites01.php?Proceso=GP&Valores=" + Valores;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "EP": //ELIMINA PLANTILLA
		
			var msg = confirm("�Confirma que desea eliminar esta Plantilla?");
			if (msg==true)
			{
				f.action = "sea_con_limites01.php?Proceso=EP";
				f.submit();
			}
			else
			{
				return;
			}
			break;
	}
}

function MarcaTodos()
{
	var f=document.frmPrincipal;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="ChkLeyes")
		{
			if (f.ChkMarcaTodos.checked == false)
				f.elements[i].checked = false;
			else 	f.elements[i].checked = true;
		}
	}
}

function Marca(J)
{
	var f=document.frmPrincipal;
	if (f.elements[J].value != "")
	{
		f.elements[J-2].checked = true;
	}
	else
	{
		f.elements[J-2].checked = false;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="730" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr> 
            <td width="106">Tipo Movimiento:</td>
            <td width="243"><font color="#FFFFFF">
              <SELECT name="TipoMovimiento">
			  <option value="S">STOCK</option>
                <?php			
			$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2001";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{			
	          	if ($Fila["cod_subclase"] == $TipoMovimiento)	
					echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".strtoupper($Fila["nombre_subclase"])."</option>";
				else 
					echo "<option value='".$Fila["cod_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>";
			}    			 					
		?>
              </SELECT>
            </font></td>
            <td width="104" align="right">Producto:</td>
            <td width="235"><font color="#FFFFFF">
				<SELECT name="TipoProducto" style="width:220px" onChange="Proceso('R');">
                <option value="0-0">TODOS</option>
                <?php					

                	$consulta = "SELECT DISTINCT * FROM proyecto_modernizacion.subproducto ";
					$consulta.= " WHERE cod_producto IN(17,19) AND mostrar_sea = 'S' ORDER BY cod_producto";
					$rs3 = mysqli_query($link, $consulta);
					while ($row3 = mysqli_fetch_array($rs3))
					{
						$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];
						
						if ($prod == $TipoProducto)
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" SELECTed>'.$row3["descripcion"].'</option>';
						else 
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["descripcion"].'</option>';
					}

				?>
              </SELECT>
</font></td>
          </tr>
          <tr> 
            <td>Fecha Inicio:</td>
            <td><SELECT name="DiaIni" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </SELECT></td>
            <td align="right">Fecha Termino:</td>
            <td><SELECT name="DiaFin" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
              </SELECT> <SELECT name="MesFin" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoFin" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </SELECT></td>
          </tr>
          <tr valign="middle"> 
            <td height="18" colspan="3" align="center">              <input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
                <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">
                <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
            </td>
            <td height="18" align="center"><input name="BtnGuardar" type="button" id="BtnGuardar" style="width:110px" onClick="Proceso('GP');" value="Guardar Plantilla">            
            <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:110px" onClick="Proceso('EP');" value="Eliminar Plantilla"></td>
          </tr>          
        </table>
		<br>
        <table width="730" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr>
            <td align="center"><strong>MOSTRAR HORNADAS CUYAS LEYES SEAN:</strong>              <table width="250" border="1" cellpadding="1" cellspacing="0" class="TablaInterior">
              <tr align="center" class="ColorTabla01">
                <th width="18" scope="row">Ver				
                  <input type="checkbox" name="ChkMarcaTodos" value="" onClick="MarcaTodos();"></th>
                <td width="52">Ley</td>
                <td width="70">Signo</td>
                <td width="91">Valor</td>
              </tr>
<?php	
	$Datos = explode("-",$TipoProducto);
	if(isset($Datos[0])){
		$Producto = $Datos[0];
	}else{
		$Producto = 0;
	}
	if(isset($Datos[1])){
		$SubProducto = $Datos[1];
	}else{
		$SubProducto = 0;
	}

	
	$Consulta = "SELECT distinct t1.cod_leyes, t2.abreviatura ";
	$Consulta.= " from sea_web.leyes_por_hornada t1 inner join proyecto_modernizacion.leyes t2";
	$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
	if ($Producto != 0)
	{
		$Consulta.= " where t1.cod_producto = '".$Producto."'";
		if ($SubProducto != 0)
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
	}
	$Consulta.= " order by t1.cod_leyes"; 
	$Respuesta = mysqli_query($link, $Consulta); 
	$i=12;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ValorA = "";
		$Signo = "";
		$Consulta = "SELECT * from sea_web.limites ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
		$Consulta.= " and sistema = 'SEA'";
		$Consulta.= " and corr = '1'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			$ValorA = $Fila2["limite"];
			$Signo = $Fila2["signo"];
		}
		echo "<tr>\n";
		echo "<th scope='row'>";
		if ($ValorA > "")
			echo "<input type='checkbox' checked name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		else
			echo "<input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		echo "</th>\n";
		echo "<td align='center'>".$Fila["abreviatura"]."</td>\n";
		echo "<td align='center'>";
		echo "<SELECT name='Signo[".$i."]'>";
		switch ($Signo)
		{
			case ">":
				echo "<option SELECTed value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "<":
				echo "<option value='>'>></option>";
				echo "<option SELECTed value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "=":
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option SELECTed value='='>=</option>";	
				break;
			default:
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;						
		}
		echo "</SELECT>";
		echo "</td>\n";
		echo "<td align='center'><input name='Valor[".$i."]' type='text' size='15' maxlength='10' value='".$ValorA."' onFocus='Marca(".($i+2).");' onBlur='Marca(".($i+2).");'></td>\n";
		echo "</tr>\n";
		$i=$i+3;
	}

?>		</table></td>
		</tr>
        </table> 
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
