﻿<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 5;
	$HoraAux=date('G');
	$MinAux=date('i');
	$FechaHoy = date("Y-m-d");
	if(!isset($Hora))
	{
		if(intval($HoraAux)>=0&&intval($HoraAux)<8)
		{
			$Hora="07";
			$Minutos="59";
		}
		if(intval($HoraAux)>=8&&intval($HoraAux)<16)
		{
			$Hora="15";
			$Minutos="59";
		}
		if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
		{
			$Hora="23";
			$Minutos="59";
		}
	}	
	
	//$lados = array(T => "TIERRA", M => "MAR");
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Limpiar()
{
	document.location = "sea_ing_prod_restos_anodos_cor.php";
}
/*******************/
function Valida1(f)
{
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar el Grupo");
		return false;
	}
	//if (f.cmblado.value == -1&&f.cmbgrupo.value!='49')
	if (f.cmblado.value == -1)
	{
		alert("Debe Seleccionar Lado");
		return false;
	}
	return true;
}
/*******************/
function Valida2(f)
{
	/*if(f.cmbgrupo.value==49&&f.cmblado.value != -1)
	{
		alert("Grupo Seleccionado no Posee Lado Dejar en SELECCIONAR");
		return false;
	}*/
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar el Grupo");
		return false;
	}
	//if (f.cmblado.value == -1&&f.cmbgrupo.value!='49')
	if (f.cmblado.value == -1)
	{
		alert("Debe Seleccionar Lado");
		return false;
	}
	if (((f.txttotalunid.value == "") || (f.txttotalunid.value == "0")) && ((f.txthm1.value == "") || (f.txthm1.value == "0")))
	{
		alert("No Existen Anodos para Producir");
		return false;
	}	
	
	if (f.txtpesoprod.value == "")
	{
		alert("Debe Ingresar el Peso de la Produccion");
		return false			
	}
		
	if ((isNaN(parseInt(f.txtpesoprod.value))) || (parseInt(f.txtpesoprod.value) <= 0))			
	{
		alert("El Peso de la Produccion no es Valido");
		return false;
	}		
	if(f.Hora.value=='S')
	{
		alert("Debe Seleccionar Hora Valida");
		return false;
	}
	if(f.Minutos.value=='S')
	{
		alert("Debe Seleccionar Minutos Validos");
		return false;
	}	
	return true;	
}
/********************/
function Valida3(f)
{
	if (f.T_U.value == 0)
	{
		alert("No Se Puede Elimnar, Ya Que No Es Una Produccion Valida");
		return false;
	}
	return true;
}
/*******************/
function Buscar(f)
{
	if (f.cmbgrupo.value == -1)
	{
		document.location = "sea_ing_prod_restos_anodos_cor.php";
		return;
	}

	f.action = "sea_ing_prod_restos_anodos_cor01.php?proceso=B";
	f.submit();
}
/******************/
function Buscar2(f)
{
	if (Valida1(f))
	{	

		f.action = "sea_ing_prod_restos_anodos_cor01.php?proceso=B2";
		f.submit();
	}
}
/*****************/
function Calcula(f)
{
	var pesoproduccion = parseFloat(f.txtpesoprod.value);
	var factor = parseInt(f.txtfactor.value);
	var unidadescor = parseInt(f.txttotalunid.value);
	
	if (f.txttotalunid.value == 0)
	{
		document.frmProduccion.txtpesocor.value = 0;	
		document.frmProduccion.txtpesohm.value = Math.round((pesoproduccion));	
	}	
	else if (f.txthm2.value == "0")
		{		
			document.frmProduccion.txtpesocor.value = Math.round((pesoproduccion));	
			document.frmProduccion.txtpesohm.value = 0;	
		}
		else 
		{
			var pesocte = (pesoproduccion * ((100-factor)/100))
  			document.frmProduccion.txtpesocor.value = Math.round(pesocte);		
			document.frmProduccion.txtpesohm.value = Math.round((pesoproduccion - parseFloat(f.txtpesocor.value)));
		}
}
/******************/
function Verificar(f)
{		
	if (f.txtpesoprod.value == "")
		return;

	var peso = parseInt(f.txtpesoprod.value);	
	if (!isNaN(peso) && (peso > 0))
	{	
		if ((f.txttotalunid.value == 0) && (f.txthm2.value == 0))
		{
			alert("No hay Anodos para Producir");
			return;
		}
		else
			Calcula(f);
	}
	else 
		alert("El Peso de Produccion No es Valido")
}
/******************/
function Generar(f,opc)
{
	if (Valida2(f))
	{		
		linea = "txtpesocor=" + f.txtpesocor.value + "&txtpesohm=" + f.txtpesohm.value + "&txthm1=" + f.txthm1.value;
		linea = linea + "&txttotalunid=" + f.txttotalunid.value + "&cmblado=" + f.cmblado.value;
		linea = linea + "&dia2=" + f.dia2.value + "&mes2=" + f.mes2.value + "&ano2=" + f.ano2.value;
		linea = linea + "&Hora2=" + f.Hora2.value + "&Minutos2=" + f.Minutos2.value;

		if (opc == 2) //crear
			f.action = "sea_ing_prod_restos_anodos_cor01.php?proceso=G&" + linea;
		else if (opc == 1) //modificar
				f.action = "sea_ing_prod_restos_anodos_cor01.php?proceso=M&" + linea;
		
		f.submit();
	}
}
/****************/
function Eliminar(f)
{
	if (confirm("Esta Seguro de Eliminar La Produccion y Sus Traspaso Asociados"))
	{
		if (Valida3(f))
		{
			linea = "&dia2=" + f.dia2.value + "&mes2=" + f.mes2.value + "&ano2=" + f.ano2.value +"&Hora2="+f.Hora2.value +"&Minutos2="+f.Minutos2.value;
			f.action = "sea_ing_prod_restos_anodos_cor01.php?proceso=E" + linea;
			f.submit();
		}
	}
}
/***************/
function Ver_Datos(f)
{
	window.open("sea_ing_prod_cor.php", "","menubar=no resizable=no width=540 height=380");
}

/*******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmProduccion" method="post" action="">
<?php include("../principal/encabezado.php") ?>
<?php include("../principal/conectar_principal.php") ?> 

  <table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">


    <table width="750" border="0" cellpadding="0" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="73" height="40">Fecha Produccion</td>
            <td width="284"> <SELECT name="dia1" size="1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia1))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </SELECT> <SELECT name="mes1" size="1">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes1))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </SELECT> <SELECT name="ano1" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano1))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </SELECT>
              <font size="1"><font size="2">
              <SELECT name="Hora">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </SELECT>
              <strong>:</strong>
              <SELECT name="Minutos">
                <option value="S">S</option>
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </SELECT>
              </font></font> </td>
			  <?php
			  		$anoh = substr($FechaHoy,0,4);
					$mesh = substr($FechaHoy,5,2);
					$diah = substr($FechaHoy,8,2);
					$FechaCarga =date("Y-m-d", mktime(1,0,0,$mesh,($diah - 10),$anoh));

			  ?>
            <td width="32">Grupo</td>
            <td width="83"> <SELECT name="cmbgrupo" id="cmbgrupo" onChange="JavaScript:Buscar(this.form)">
                <option value="-1">GRUPO</option>
                <?php			
			$consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre FROM sea_web.movimientos AS t1";
			$consulta = $consulta." INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
			$consulta = $consulta." ON t1.campo2 = t2.cod_subclase";
			$consulta = $consulta." WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 IN ('T','M','S','N')";
			$consulta = $consulta." AND t1.numero_recarga = 0 and t1.fecha_movimiento <= '".$FechaCarga."' ORDER BY t2.cod_subclase";
				
			$rs = mysqli_query($link, $consulta);
			$var1= $consulta;
			while ($row = mysqli_fetch_array($rs))
			{
				if (($mostrar == "S") and ($row["grupo"] == $cmbgrupo))
					echo '<option value="'.$row["grupo"].'" SELECTed>N° '.$row["grupo"].'</option>';
				else 
					echo '<option value="'.$row["grupo"].'">N° '.$row["grupo"].'</option>';
			}			
		?>
		

              </SELECT> </td><?php //echo "COn2".$consulta;?>
            <td width="33">Lado </td>
            <td width="143"><SELECT name="cmblado"><option value="-1">LADO</option>

    	<?php
			if (($cmblado == "T") and ($mostrar == "S"))
			{
				echo '<option value="T" SELECTed>TIERRA</option>';
				echo '<option value="M">MAR</option>';
				echo '<option value="N">NORTE</option>';
				echo '<option value="S">SUR</option>';
			}
			else if (($cmblado == "M") and ($mostrar == "S"))
			{
				echo '<option value="T">TIERRA</option>';
				echo '<option value="M" SELECTed>MAR</option>';
				echo '<option value="N">NORTE</option>';
				echo '<option value="S">SUR</option>';
//poly
			}
			else if (($cmblado == "N") and ($mostrar == "S"))
			{
			
				echo '<option value="T">TIERRA</option>';
				echo '<option value="M">MAR</option>';
				echo '<option value="N" SELECTed>NORTE</option>';
				echo '<option value="S">SUR</option>';
			}
			else if (($cmblado == "S") and ($mostrar == "S"))
			{
			
				echo '<option value="T">TIERRA</option>';
				echo '<option value="M">MAR</option>';
				echo '<option value="N">NORTE</option>';
				echo '<option value="S" SELECTed>SUR</option>';

//poly
			}
			else 
			{
			
			
				echo '<option value="T">TIERRA</option>';
				echo '<option value="M">MAR</option>';
				echo '<option value="N">NORTE</option>';
				echo '<option value="S">SUR</option>';

				
			}
		
		
			/*
			if ($mostrar == "S")
				echo '<input type="text" name="cmblado" size="10" value="'.$cmblado.'" disabled>';
			else 
				echo '<input type="text" name="cmblado" size="10" value="" disabled>';
			*/
		?>
			</SELECT>
&nbsp;             <input name="btnbuscar" type="button" value="Buscar" onClick="JavaScript:Buscar2(this.form)">&nbsp; </td>
            <td width="52">Factor %</td>
            <td width="47"> 
        <?php
          	if ($mostrar == "S")
		  		echo '<input name="txtfactor" type="text" value="'.$txtfactor.'" size="3" readonly>';
			else 
		  		echo '<input name="txtfactor" type="text" id="txtfactor" size="3" readonly>';
		?>
            </td>
          </tr>
        </table>
        <br>

    <table width="750" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
	<tr>
        <td width="69" height="40">Fecha Carga Anodos</td>
        <td width="291">
          <SELECT name="dia2" size="1" id="dia2" disabled>
		<?php
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia2))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
          </SELECT>
          <SELECT name="mes2" size="1" id="mes2" disabled>	
		<?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes2))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
          </SELECT>
          <SELECT name="ano2" size="1" id="ano2" disabled>
    	<?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano2))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
          </SELECT>
          <font size="1"><font size="2">
          <SELECT name="Hora2" disabled>
            <option value="S">S</option>
            <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora2))
					{	
						if ($Hora2 == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual2 == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
          </SELECT>
          <strong>:</strong>
          <SELECT name="Minutos2" disabled>
            <option value="S">S</option>
            <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos2))
					{	
						if ($Minutos2 == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual2 == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
          </SELECT>
          </font></font>            </td>
        <td width="108">Total Unidades Ctes.</td>
        <td width="86"> 
		<?php
          	if ($mostrar == "S")
				echo '<input name="txttotalunid" type="text" value="'.$txttotalunid.'" size="10" readonly>';		
			else
				echo '<input name="txttotalunid" type="text" id="txttotalunid" size="10" readonly>';
		?>
        </td>
        <td width="110">Peso Unidades Ctes.</td>
        <td width="83"> 
		<?php
			if ($mostrar == "S")
	        	echo '<input name="txttotalpeso" type="text" value="'.$txttotalpeso.'" size="10" readonly>';
			else
	        	echo '<input name="txttotalpeso" type="text" id="txttotalpeso" size="10" readonly>';
		?>
        </td>
    </tr>
  </table><br>

    <table width="600" border="0" cellpadding="3" cellspacing="0" class="ColorTabla01">
      <tr> 
        <td width="300" height="20"><div align="center">Tipo Producto</div></td>
        <td width="150"><div align="center">Unidades</div></td>
        <td width="150"><div align="center">Peso</div></td>
      </tr>
    </table>


    <table width="600" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
	<?php
		if ($mostrar == "S")
		{
			$largo = strlen($parametros);
			for ($i=0; $i < $largo; $i++)
			{
				if (substr($parametros,$i,1) == "/")
				{				
					$valor = substr($parametros,0,$i);
												
					$pos = strpos($valor,"-"); //de donde vienen
					$prod = substr($valor,0,$pos);
					$valor = substr($valor,$pos+1,strlen($valor));					
					
					$pos = strpos($valor,"-"); //unidades
					$unidades = substr($valor,0,$pos);
					$valor = substr($valor,$pos+1,strlen($valor));
					
					$peso = $valor; //peso
									
					$parametros = substr($parametros,$i+1);
					$i = 0;			
					$tabla[$prod][0] = $unidades;
					$tabla[$prod][1] = $peso;
				}	
			}			
		}
		//echo "CC".$var1;
		$consulta = "SELECT valor_subclase1 AS valor FROM sub_clase WHERE cod_clase = 2002";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND cod_subproducto = '".$row[valor]."'";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);

			echo '<tr>';
			echo '<td width="300" height="20">'.$row1["descripcion"].'</td>';
        	echo '<td width="150"><div align="center"><input name="textfield" type="text" size="10" value="'.$tabla[$row[valor]][0].'" readonly></div></td>';
        	echo '<td width="150"><div align="center"><input name="textfield" type="text" size="10" value="'.$tabla[$row[valor]][1].'" readonly></div></td>';
	    	echo '</tr>';				
		}
		echo '<tr>';
		echo '<td width="300" height="20">RESTOS ANODOS H.M.</td>';
       	echo '<td width="150"><div align="center"><input name="txthm1" type="text" size="10" value="'.$txthm1.'" readonly></div></td>';
       	echo '<td width="150"><div align="center"><input name="txthm2" type="text" size="10" value="'.$txthm2.'" readonly></div></td>';
    	echo '</tr>';
		//Totales
		echo '<tr>';
		echo '<td width="300" height="20">TOTAL</td>';	
		echo '<td width="150"><div align="center"><input name="T_U" type="text" size="10" value="'.($txttotalunid + $txthm1).'" readonly></div></td>';
       	echo '<td width="150"><div align="center"><input name="T_P" type="text" size="10" value="'.($txttotalpeso + $txthm2).'" readonly></div></td>';
		echo '</tr>';
	?>
  </table><br>

    <table width="750" height="30" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
<tr>
        <td width="133">Peso Produccion</td>
        <td width="100"> 
		<?php
          	//if ($ocultar == "S")
			if ($mostrar == "S")
				echo '<input name="txtpesoprod" type="text" size="10" value="'.$txtpesoprod.'" onBlur="JavaScript:Verificar(this.form)">';
			else
				echo '<input name="txtpesoprod" type="text" size="10" onBlur="JavaScript:Verificar(this.form)">';
		?>
        </td>
        <td width="133">Peso Anodos Ctes</td>
        <td width="100">
		<?php 	
			if ($mostrar == "S")
		   		echo '<input name="txtpesocor" type="text" value="'.$txtpesocor.'" size="10" readonly>';
			else 
				echo '<input name="txtpesocor" type="text" id="txtpesocor" size="10" readonly>';
		?>
        </td>
        <td width="133">Peso Restos H.M</td>
        <td width="100"> 
		<?php
          	if ($mostrar == "S")
		  		echo '<input name="txtpesohm" type="text" value="'.$txtpesohm.'" size="10" readonly>';
			else 
		  		echo '<input name="txtpesohm" type="text" id="txtpesohm" size="10" readonly>';			
		?>
        </td>
    </tr>
  </table><br>

       <table width="750" height="30" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="797" align="center"> 
		<?php
			if ($cambiarboton == "S")
			{
			  	echo '<input name="btngenerar" type="button" value="Modificar Hornada" onClick="JavaScript:Generar(this.form,1)" style="width=115">&nbsp;';
				echo '<input name="btneliminar" type="button" value="Eliminar Produccion" onClick="JavaScript:Eliminar(this.form)" style="width=115">';
			}
			else 
				echo '<input name="btngenerar" type="button" value="Generar Hornada" onClick="JavaScript:Generar(this.form,2)" style="width=110">';			
		?>
              <input name="btnlimpiar" type="button" value="Limpiar" onClick="JavaScript:Limpiar()" style="width=110">
              <input name="ver datos" type="button" style="width=110" onClick="JavaScript:Ver_Datos(this.form)" value="Ver Datos">
              <input name="btnsalir" type="button" value="Salir" style="width=110" onClick="JavaScript:Salir()">
            </td>
          </tr>
        </table>
		<?php
			//campo oculto.
			echo '<input type="hidden" name="fecha_aux" value="'.$ano1."-".$mes1."-".$dia1.'">';
		?>

</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>

<?php
	//Muestra PopUp con las hornadas generadas.
	if (isset($activar))
		echo '<script language="JavaScript"> window.open("sea_con_hornadas.php?valores='.$valores.'", "","menubar=no resizable=no width=500 height=250") </script>';
?>

<?php
	//Existe produccion el mismo dia, de un grupo.
	if (isset($existe))
	{
		echo '<script language="JavaScript"> alert("Ya Existe Produccion del Grupo '.$grupo.' en la Fecha '.$fecha.'"); </script>';
	}
?>

</body>
</html>
<?php include("../principal/cerrar_principal.php")?> 
