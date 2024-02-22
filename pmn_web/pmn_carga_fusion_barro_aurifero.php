<?php
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 15;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.carga_fusion_barro_aurifero ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Operador = $Row[operador];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action="pmn_carga_fusion_barro_aurifero.php";
			f.submit();
		break;
		case "G": //GRABAR			
			if (f.Operador.value == "")
			{
				alert("Debe Seleccionar Operador");
				f.Operador.focus();
				return;
			}
			f.action= "pmn_carga_fusion_barro_aurifero01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.CmbProductos.value == 'S')
			{
				alert("Debe Seleccionar Producto");
				f.CmbProductos.focus();
				return;
			}
			if (f.CmbSubProducto.value == 'S')
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.Unidades.value == "")
			{
				alert("Debe Ingresar Unidades");
				f.Unidades.focus();
				return;
			}
			if (f.Pesos.value == "")
			{
				alert("Debe Ingresar Pesos");
				f.Pesos.focus();
				return;
			}					
			f.action= "pmn_carga_fusion_barro_aurifero01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_carga_fusion_barro_aurifero01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("�Seguro que desea Eliminar todos los registros asociados a la fecha?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_fusion_barro_aurifero01?Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("�Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_fusion_barro_aurifero01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_fusion_barro_aurifero01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_carga_fusion_barro_aurifero02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=107";
	 		f.submit();
			break;
	}

}
function Recarga()
{
	var f=document.frmPrincipal;
	f.action="pmn_carga_fusion_barro_aurifero.php";
	f.submit();
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 100 )&&(teclaCodigo != 190 ))
	{
		if (((teclaCodigo != 8)&&(teclaCodigo !=9 )) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal">
    <tr>
    <td><table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="30" colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
					$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
					$Resultado= mysqli_query($link, $Consulta);
					if ($Fila =mysqli_fetch_array($Resultado))
					{	
						echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					}	  
					else
					{
						$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
						}
					}
		  			?>
              </strong></font></font></td>
            <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
              </strong>&nbsp; <strong> 
              <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="105" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == $MesActual)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $AnoActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					echo "</select>\n";
				}
			//echo $Mes=$MesActual."<br>";
			?>
            </td>
            <td width="176"> <div align="left">
                <input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');">
              </div></td>
            <td width="114">&nbsp;</td>
          </tr>
          <tr> 
            <td width="105">Operador:</td>
            <td width="228"><select name="Operador" id="select6" style="width:220px" on onChange="Recarga();">
                <option value="S">Seleccionar</option>
                <?php
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '10' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					if ($row[rut] == $Operador)
					{
						echo "<option selected value='".$row[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$row[rut]."'>".$Nombre."</option>\n";
					}
				}
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta="select * from proyecto_modernizacion.funcionarios order by apellido_paterno,apellido_materno,nombres ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));
					if ($Fila[rut] == $Operador)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}
			?>
              </select> </td>
            <td width="105">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
		  
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> 
              <input name="BtnGrabar" type="button" id="BtnGrabar2" value="Grabar" style="width:60px;" onClick="Proceso('G');">
              <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
              <font size="1"><font size="1"><font size="2"><strong> </strong></font></font></font> 
              <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2">Producto:</td>
            <td colspan="3"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              <select name="CmbProductos" style="width:220px" onChange="Proceso('R');">
                <?php
				echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select distinct t2.cod_producto,t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='6'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							//printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
			?>
              </select>
              </strong></font></font></font></font></font></td>
            <td>SubProducto</td>
            <td colspan="2"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"><strong> 
			  <select name="CmbSubProducto" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$CmbProductos."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$CmbProductos."' and t1.nombre_subclase='6'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Row["cod_subproducto"])
					{	
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					}
					else
					{
						echo "<option value='".$Row["cod_subproducto"]."'>";
					}
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$CmbProductos."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Row["cod_subproducto"])
					{
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					}
					else
					{
						echo "<option value='".$Row["cod_subproducto"]."'>";
					}
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
			?>
              </select>
              </strong></font></font></font><font size="2"><strong> </strong></font></font></font></td>
          </tr>
          <tr> 
            <td width="75">Unidades:</td>
            <td colspan="4"> 
              <input name="Unidades" type="text" onKeyDown="TeclaPulsada();" value="<?php echo str_replace(".",",",$Unidades);?>" size="15" maxlength="15"></td>
            <td width="112">Pesos:</td>
            <td width="91"><input name="Pesos" type="text" onKeyDown="TeclaPulsada();" value="<?php echo str_replace(".",",",$Pesos);?>" size="15" maxlength="15"></td>
            <td width="193" align="center"><input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');"> 
            </td>
          </tr>
        </table>
        <br> 
        <table width="761" height="18" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="51" height="15">&nbsp;</td>
            <td width="203"><strong>Producto</strong></td>
            <td width="203"><strong>SubProducto</strong></td>
            <td width="73"><strong>Unidades</strong></td>
            <td width="72"><strong>Pesos</strong></td>
          </tr>
          <?php	
		$Consulta= "select t1.unidades,t1.peso,t2.descripcion as DesProducto,t3.descripcion as DesSubProducto, ";
		$Consulta= $Consulta." t3.cod_subproducto,t2.cod_producto  ";
		$Consulta= $Consulta." from pmn_web.detalle_carga_fusion_barro_aurifero t1 ";
		$Consulta= $Consulta." inner join proyecto_modernizacion.productos t2 on ";
		$Consulta= $Consulta." t1.producto = t2.cod_producto "; 
		$Consulta= $Consulta." inner join proyecto_modernizacion.subproducto t3 on ";
		$Consulta= $Consulta." t1.subproducto = t3.cod_subproducto and t2.cod_producto=t3.cod_producto ";
 		$Consulta= $Consulta." where fecha = '".$Ano."-".$Mes."-".$Dia."'  order by t1.fecha,t1.producto,t1.subproducto ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td align='center'><input type='checkbox' name='ChkFecha[".$i."]' value='".$Row["fecha"]."'>\n";
			echo "<input type='hidden' name='ChkProducto[".$i."]' value='".$Row["cod_producto"]."'>\n";
			echo "<input type='hidden' name='ChkSubProducto[".$i."]' value='".$Row["cod_subproducto"]."'>\n";
			echo "<input type='hidden' name='ChkUnidades[".$i."]' value='".str_replace(".",",",$Row["unidades"])."'>\n";
			echo "<input type='hidden' name='ChkPesos[".$i."]' value='".str_replace(".",",",$Row["peso"])."'>\n";
			echo "</td>\n";
			echo "<td align='left'>".$Row[DesProducto]."</td>\n";
			echo "<td align='left'>".$Row[DesSubProducto]."</td>\n";
			echo "<td align='center'>".$Row["unidades"]."</td>\n";
			echo "<td align='center'>".$Row["peso"]."</td>\n";
			echo "</tr>\n";
			$i++;
		}
?>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
