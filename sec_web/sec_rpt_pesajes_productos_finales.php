<?php include("../principal/conectar_principal.php");
	$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");

	$CookieRut= $_COOKIE["CookieRut"];
	
	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');

	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

	$CmbProducto = isset($_REQUEST["CmbProducto"])?$_REQUEST["CmbProducto"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";

/*

	if (!isset($DiaIni))
	{
		$DiaIni = date("j");
		$MesIni = date("n");
		$AnoIni = date("Y");
		$DiaFin = date("j");
		$MesFin = date("n");
		$AnoFin = date("Y");
	}
	*/
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
		
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin." 08:00:00";
	$FechaInicio1 =date("Y-m-d", mktime(1,0,0,$MesIni,$DiaIni,$AnoIni));	

	$Fechainiturno =$FechaInicio;
	$Fechafturno =date("Y-m-d", mktime(1,0,0,$MesFin,(intval($DiaFin)+1),$AnoFin));	
	
?>
<html>
<head>
<title>Reporte Pesaje Productos Finales</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmConsulta;
	switch (opt)
	{
		case "C":
			f.action ="sec_rpt_pesajes_productos_finales.php?Buscar=S";
			f.submit();
			break;
		case "E":
		linea= "&CmbProducto="	+ f.CmbProducto.value + "&CmbSubProducto=" + f.CmbSubProducto.value;
	linea=linea+ "&AnoIni="	+ f.AnoIni.value + "&MesIni=" + f.MesIni.value + "&DiaIni=" + f.MesIni.value;
	linea=linea+ "&AnoFin="	+ f.AnoFin.value + "&MesFin=" + f.MesFin.value + "&DiaFin=" + f.DiaFin.value;
			f.action ="sec_rpt_pesajes_productos_finales_excel.php?"+linea;
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Recarga2()
{
	var f = document.frmConsulta;
	
	if (f.CmbProducto.value == 'T')
		linea = "recargapag1=S";
	else
		linea = "recargapag1=S&recargapag2=S";

	linea= linea + "&CmbProducto="	+ f.CmbProducto.value + "&CmbSubProducto=" + f.CmbSubProducto.value;
	linea="sec_rpt_pesajes_productos_finales.php?" + linea;
			
	f.action = linea;
	f.submit();	
}
/*****************/
function Recarga3()
{	
	var f = document.frmConsulta;
	
	if (f.cmbsubproducto.value == 'T')
		linea = "recargapag1=S&recargapag2=S";
	else
		linea = "recargapag1=S&recargapag2=S&recargapag3=S";
	
	linea = linea + "&CmbProducto="	+ f.CmbProducto.value + "&CmbSubProducto=" + f.CmbSubProducto.value;
	linea="sec_rpt_pesajes_productos_finales.php?" + linea;
	f.action = linea;
	f.submit();	
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
 <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="86">Fecha Inicio: </td>
      <td width="259"><select name="DiaIni" id="DiaIni" style="width:50px;">
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
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" id="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
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
        </select> <select name="AnoIni" id="AnoIni" style="width:60px;">
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
        </select></td>
      <td width="119">Fecha Termino:</td>
      <td width="265"><select name="DiaFin" id="DiaFin"  style="width:50px;">
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
        </select> <select name="MesFin"  id="MesFin" style="width:90px;">
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
        </select> <select name="AnoFin"  id="AnoFin" style="width:60px;">
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
        </select></td>
    </tr>
    <tr>
    
    <td width="119">Producto:</td>
     <td width="119"><select name="CmbProducto"  id="CmbProducto" onChange="Recarga2()">
         <option selected value='T'>TODOS</option>
      		<?php
			
			foreach($productos as $clave => $valor)
			{
				if ($clave == $CmbProducto)
					echo '<option value="'.$clave.'" selected>'.$valor.'</option>';
				else 
					echo '<option value="'.$clave.'">'.$valor.'</option>';
			}	
			
			?>			
              </select>
      </td>
      <td width="119">Sub-Producto:</td>
       <td width="119">
			<select name="CmbSubProducto" id="CmbSubProducto"  onChange="Recarga3()">
                <option value="T">TODOS</option>
                <?php	
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$CmbProducto."' ";
			if($CmbProducto==48)
			{
				$consulta.=" and cod_subproducto not in(10)";
				}
			//echo '<option value="-1">'.$consulta.'</option>';
			$var1 = $consulta;
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				$codigo = $row["cod_subproducto"];
				$descripcion = $row["descripcion"];
				if (($CmbProducto == 48) and ($codigo == 1))	
					$descripcion = "LAMINAS";

				if (($codigo == $CmbSubProducto))
					echo '<option value="'.$codigo.'" selected>'.$descripcion.'</option>';
				else
					echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
					
					
			}
			
			
			?>		</select>
            			</td>
			
    </tr>
    <tr> 
      <td colspan="4" align="center"> <input name="btnConsultar" type="button" id="btnConsultar" style="width:70;" onClick="JavaScript:Proceso('C')" value="Consultar"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70;" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
  </table>
  <?php if($Buscar=='S')
  {?>
        <br>
        <table width="800" border="1" align="center" cellpadding="2" cellspacing="1"  class="TablaDetalle">
         <tr> 
             <td colspan="9"><div align="center">Periodo: <strong>Desde :</strong><?php echo $Fechainiturno." 08:00:00";?>  <strong>Hasta :</strong><?php echo $Fechafturno." 08:00:00";?></div></td>
 
          </tr>
          <tr class="ColorTabla01"> 
             <td><div align="center">Fecha/Hora Creaci&oacute;n</div></td>
            <td width="60"><div align="center">Nro de Serie</div></td>
            <td width="50"><div align="center">Peso</div></td>
            <td width="66"><div align="center">Unidad</div></td>
            <td width="66"><div align="center">Estado</div></td>
            <td width="81"><div align="center">Cod. Producto</div></td>
            <td width="64"><div align="center">Grupo</div></td>
           <td width="64"><div align="center">Marca</div></td>  
           <td width="64"><div align="center">I.E.</div></td>
            </tr>
         
			<?php  
			$cont = 0;			
		$Eliminar="Delete from sec_web.tmp_rep_product_final where Rut='".$CookieRut."' ";
		mysqli_query($link, $Eliminar);

		$Consulta="insert into sec_web.tmp_rep_product_final(fecha_creacion_paquete,corr_enm,cod_producto,cod_subproducto,num_paquete,num_unidades,cod_grupo,cod_marca,peso_paquetes,cod_estado,cod_paquete,Rut)";
		$Consulta.=" select CONCAT(t1.fecha_creacion_paquete,' ',t1.hora),t2.corr_enm,t1.cod_producto,t1.cod_subproducto,t1.num_paquete, t1.num_unidades ,t1.cod_grupo,t2.cod_marca,t1.peso_paquetes,t1.cod_estado,t1.cod_paquete,'".$CookieRut."' from sec_web.paquete_catodo t1 ";
		$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
		$Consulta.="  where t1.fecha_creacion_paquete BETWEEN '".$Fechainiturno."' and '".$Fechafturno."'";
		if($CmbProducto!='T')
			$Consulta.=" and t1.cod_producto = '".$CmbProducto."'";	
			
		if($CmbSubProducto!='T')
		{
				$Consulta.=" and t1.cod_subproducto = '".$CmbSubProducto."'";	
		}
		
		mysqli_query($link, $Consulta);
		$Eliminar="Delete from sec_web.tmp_rep_product_final where Rut='".$CookieRut."' and cod_producto = 48 and cod_subproducto = 10 ";	
		mysqli_query($link, $Eliminar);

			
			$Consulta1=" select * from sec_web.tmp_rep_product_final ";
			$Consulta1.=" where Rut='".$CookieRut."'  and (fecha_creacion_paquete  BETWEEN  '".$Fechainiturno." 08:00:00' and  '".$Fechafturno." 08:00:00' )";
			if($CmbProducto!='T')
				$Consulta1.=" and cod_producto = '".$CmbProducto."'";	
			if($CmbSubProducto!='T')
				$Consulta1.=" and cod_subproducto = '".$CmbSubProducto."'";	
			$Consulta1.=" ORDER BY fecha_creacion_paquete ASC ";
			
			$Respuesta=mysqli_query($link, $Consulta1);
			$SumaPeso=0;
			$SumaUnidades=0;
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
					if ($Fila["cod_estado"]=="c")
					{
						$Estado="Cerrado";
					}
					else
					{
						$Estado="Abierto";
					}
					$Consulta="select * from proyecto_modernizacion.subproducto ";
					$Consulta.=" where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."' ";
					$Respuesta1=mysqli_query($link, $Consulta);
					$Fila1=mysqli_fetch_array($Respuesta1);
					$Producto=$Fila1["abreviatura"];	
				   ?><tr>
					 <td><?php echo $Fila["fecha_creacion_paquete"];?></td>
					 <td><?php echo $Fila["cod_paquete"]."-".$Fila["num_paquete"];?></td>
					 <td><?php echo $Fila["peso_paquetes"];?></td>
					 <td><?php echo $Fila["num_unidades"];?></td>
					 <td><?php echo $Estado;?></td>
					 <td><?php echo $Producto;?></td>
					 <td><?php echo $Fila["cod_grupo"];?></td>
                    <td><?php echo $Fila["cod_marca"];?></td>
                    <td><?php echo $Fila["corr_enm"];?></td>
                     
						
				</tr>
                <?php
				$SumaPeso=$SumaPeso+$Fila["peso_paquetes"];
				$SumaUnidades=$SumaUnidades+$Fila["num_unidades"];
				$cont++;
			}
			echo "<tr class='Detalle01'>";
			echo "<td>&nbsp;</td>";
			echo "<td><strong>Total</strong></td>";
			echo "<td align='right'><strong>".$SumaPeso."</strong></td> ";		
			echo "<td align='right'><strong>".$SumaUnidades."</strong></td> ";	
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
			?>
        </table> 
        
        <?php }
		?>
        </td>
    </tr>
  </table>
</form>
</body>
</html>
