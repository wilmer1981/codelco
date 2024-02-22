<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 4;
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$MuestraReproceso='N';
	if ($ConsultaHornoCarg == "S")
	{
		$Busca = "S";
		$DiaC = intval($IdDiaHornoCarg);
		$MesC = intval($IdMesHornoCarg);
		$AnoC = intval($IdAnoHornoCarg);
		$Hornada = $IdHornadaHornoCarg;
		$MuestraReproceso='S';
	}
	if ($Buscar == "S")
	{
		$Consulta = "select distinct(observacion) as obs from carga_horno_trof ";
		$Consulta.= "where fecha = '".$AnoC."-".$MesC."-".$DiaC."'";
		$Consulta.= " and hornada = '".$Hornada."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Obs = $Row[obs];
		}
		$Busca = "S";
		$MuestraReproceso='S';
	}
	if($MuestraReproceso=="S")
	{
		$Consulta = "select * from carga_horno_trof ";
		$Consulta.= "where fecha = '".$AnoC."-".$MesC."-".$DiaC."'";
		$Consulta.= " and hornada = '".$Hornada."' and cod_producto=0 and cod_subproducto=0 order by cod_producto";
		$Respuesta = mysqli_query($link, $Consulta);
		while($Row = mysqli_fetch_array($Respuesta))
		{
			$ObsRepr2=explode('//',$Row[observacion_reproceso]);
			$ObsRepr2=$ObsRepr2[0];
			
			$ObsRepr=$ObsRepr.$ObsRepr2.", ";
			$Hornada=$Row["hornada"];
		}		
	}
	if(isset($DiaC))
		$Dia=$DiaC;
	if(isset($MesC))
		$Mes=$MesC;
	if(isset($AnoC))
		$Ano=$AnoC;
		
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Recarga(Dato)
{
	var f = document.frmPrincipalRpt;
	f.action= "pmn_principal_reportes.php?Tab2=true&TabHorno1=true&DiaC="+f.Dia.value+"&MesC="+f.Mes.value+"&AnoC="+f.Ano.value+"&LimpiaObsRep=S&Buscar=S";
	f.submit();
}
function ProcesoHorno(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "B":
			var URL = "pmn_ing_carga_horno_trof02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "C":
			f.action= "pmn_ing_carga_horno_trof01.php?Proceso=C";
	 		f.submit();
			break;
		case "A":
			if (f.CmbTurno.value == "S")
			{
				alert("Debe Seleccionar Turno");
				f.Turno.focus();
				return;
			}
			if (f.Producto.value == "S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.SubProducto.value == "S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			}
			f.action ="pmn_ing_carga_horno_trof01.php?Proceso=A"; 
			f.submit();
			break;
		case "G":
			
			f.action= "pmn_ing_carga_horno_trof01.php?Proceso=G";
	 		f.submit();
			break;
		case "M":
			f.action= "pmn_ing_carga_horno_trof01.php?Proceso=M";
	 		f.submit();
			break;
		case "E":
			var mensaje = confirm("�Seguro que desea eliminar este(os) registro?");
			if (mensaje == true)
			{
				f.action= "pmn_ing_carga_horno_trof01.php?Proceso=E";
				f.submit();
			}
			break;
		case "R":
			f.action= "pmn_principal_reportes.php?Tab2=true&TabHorno1=true&DiaC="+f.Dia.value+"&MesC="+f.Mes.value+"&AnoC="+f.Ano.value+'&Buscar=S';
	 		f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=103";
	 		f.submit();
			break;
		case "H":
			var URL = "pmn_ing_carga_horno_trof03.php?Hornada=" + f.Hornada.value ;//+ "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "CargaHRepr":	
			if (f.Hornada.value == "")
			{
				alert("Debe Ingresar Hornada a la cual se agrega la Hornada Reproceso");
				f.Hornada.focus();
				return;
			}
			if (f.HornadaElect.value == "-1")
			{
				alert("Debe Seleccionar Hornada Reproceso para Cargar a Hornada "+f.Hornada.value);
				f.HornadaElect.focus();
				return;
			}
			if(f.ObsRepr.value=='')
			{
				alert("Debe Ingresar Observaci�n de Reproceso");
				f.ObsRepr.focus();
				return;
			}
			var HornadaRepr=f.HornadaElect.value;
			var DatosRepr=HornadaRepr.split('~');
			if(f.CantAnRepr.value > DatosRepr[1])
			{
				alert('Cant. Anodos a Beneficiar no Puede Exceder Cant. Anodos de Hornada Reproceso.')
				f.CantAnRepr.value
				return;
			}
			if(parseInt(f.PesoBeneRepr.value) > parseInt(DatosRepr[2]))
			{
				alert('Peso a Beneficiar no Puede Exceder Peso de Hornada Reproceso.')
				f.CantAnRepr.value
				return;
			}
			var mensaje=confirm('�Esta Seguro de Cargar Hornada Reproceso a Hornada '+f.Hornada.value+'?');
			if(mensaje==true)
			{
				f.action= "pmn_ing_carga_horno_trof01.php?Proceso=CargaHRepr";
				f.submit();
			}
		break;
	}	      
}

</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body>
<form name="frmPrincipalHorno" method="post" action="">
<?php //include("../principal/encabezado.php")?>
<table width="98%" height="330" border="0" cellpadding="0" cellspacing="0" class="TituloCabeceraOz">
 <tr>
   <td align="center" valign="top">
		<table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="64" height="30" class="titulo_azul">Fecha</td>
            <td width="328" >
              <?php 
				if ($Busca == "S")
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
					echo "<select name='Dia' style='width:50px' >\n";				
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
					for ($i=2002;$i<=date("Y");$i++)
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
			?>            </td>
            <td width="685"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoHorno('B');"></td>
          </tr>
        </table>
		<br>
		<table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="60" class="titulo_azul">Hornada</td>
            <td width="89">
              <?php
			if ($Busca == "S")
			{
				echo $Hornada;
				echo "<input name='Hornada' type='hidden' value='".$Hornada."' size=12 maxlength=20>\n";
			}
			else
			{
				echo "<input name='Hornada' type='text' value='".$Hornada."' size=12 maxlength=20>\n";
			}
			?>
            </td>
            <td width="90"><input name="BtnHornada" type="button" id="BtnHornada" value="Ver Hornada" onClick="ProcesoHorno('H');"></td>
            <td width="77" class="titulo_azul">Observaci&oacute;n</td>
            <td width="357"><input name="Obs" type="text" id="Obs" value="<?php echo $Obs; ?>" size="60" maxlength="100"></td>
          </tr>
        </table>
		<br> 
		<table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="39" class="titulo_azul">Turno:</td>
            <td width="55">
				<select name="CmbTurno" style="width:50px">
                <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Row["cod_subclase"] == $CmbTurno)
						echo "<option selected value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>";
					else	echo "<option value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>";
				}
			?>
              </select>
            </td>
            <td width="54" class="titulo_azul">Producto:</td>
            <td width="210"><select name="Producto" style="width:220px" onChange="ProcesoHorno('R');">
                <?php
				echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select distinct t2.cod_producto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='2'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				//echo "<option value='S'>-----------------------------</option>\n";
/*				$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							//printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
              </select></td>
            <td width="81"><div align="left" class="titulo_azul">SubProducto: </div></td>
            <td width="282"><select name="SubProducto" id="SubProducto" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta = "select t2.cod_subproducto, t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Producto."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Producto."' and t1.nombre_subclase='2'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($SubProducto == $Row["cod_subproducto"])
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					else	echo "<option value='".$Row["cod_subproducto"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				//echo "<option value='S'>-----------------------------</option>\n";
/*				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($SubProducto == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>";														
							else	echo "<option value='".$Row["cod_subproducto"]."'>";
							//printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
              </select> 
			  <?php
			  //echo $Consulta."<br>";
			  ?>
              <input type="button" name="BtnOK" value="OK" onClick="ProcesoHorno('A');"></td>
          </tr>
        </table><br>
		<?php
		if($MuestraReproceso=='S')
		{
		?>
		<table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="261" class="titulo_azul">Hornada Reproceso </td>
            <td width="288"><select name="HornadaElect" onChange="Recarga('Obs')">
              <option value='-1' selected="selected">Ninguna</option>
              <?php
			$FechaCon=$Ano."-".$Mes."-".$Dia;
			$ConsulHorn="select t1.hornada from pmn_web.produccion_horno_trof t1 inner join carga_electrolisis_plata t2 on t1.hornada=t2.hornada where year(t1.fecha) >= '2011'";
			//if(isset($HornadaElect))
			$ConsulHorn.=" and t1.hornada<>'".$Hornada."'";	
			$ConsulHorn.=" order by t1.hornada asc";
			$RespHorn=mysqli_query($link, $ConsulHorn);
			while($FilaHorn=mysqli_fetch_array($RespHorn))
			{
				$Consul2="select num_anodos,peso from pmn_web.produccion_horno_trof where hornada='".$FilaHorn["hornada"]."'";
				$Resp2=mysqli_query($link, $Consul2);$NumAnodos=0;$PesoProd=0;
				while($Fila2=mysqli_fetch_array($Resp2))		
				{		
					$NumAnodos=$Fila2[num_anodos];
					$PesosProd=$Fila2["peso"];
				}	
				$Consul3="select cant_anodos,peso_anodos from pmn_web.carga_electrolisis_plata where hornada='".$FilaHorn["hornada"]."'";
				$Resp3=mysqli_query($link, $Consul3);$NumAnodos2=0;$PesoAnodos2=0;
				while($Fila3=mysqli_fetch_array($Resp3))		
				{
					$PesoAnodos2=$PesoAnodos2+$Fila3[peso_anodos];		
					$NumAnodos2=$NumAnodos2+$Fila3[cant_anodos];
				}						
				$ValorResta=$NumAnodos-$NumAnodos2;
			
				$ValorRestaPesoAux=$PesosProd-$PesoAnodos2;
				if($ValorResta>'0' && $ValorRestaPesoAux>'0')
				{
					if($HornadaElect==$FilaHorn["hornada"]."~".$ValorResta."~".$ValorRestaPesoAux)
						echo "<option selected value='".$FilaHorn["hornada"]."~".$ValorResta."~".$ValorRestaPesoAux."'>".$FilaHorn["hornada"]." Cant. Anodos: ".$ValorResta." Peso: ".$ValorRestaPesoAux." Kg.</option>";
					else
						echo "<option value='".$FilaHorn["hornada"]."~".$ValorResta."~".$ValorRestaPesoAux."'>".$FilaHorn["hornada"]." Cant. Anodos: ".$ValorResta." Peso: ".$ValorRestaPesoAux." Kg.</option>";	
				}
			}
			?>
            </select>
              <?php //echo $ConsulHorn;?>
            &nbsp;</td>
            <td width="185" class="titulo_azul">Cant. Anodos: </td>
            <td width="161"><label>
              <input name="CantAnRepr" type="text" id="CantAnRepr" onKeyDown="SoloNumeros(true,this)">
            </label></td>
            <td width="210" class="titulo_azul">Peso a Beneficiar </td>
            <td width="157"><input name="PesoBeneRepr" type="text" id="PesoBeneRepr" onKeyDown="SoloNumeros(true,this)"></td>
          </tr>
		  <?php
		  if($LimpiaObsRep=='S')
		  	$ObsRepr='';
		  ?>
          <tr>
            <td class="titulo_azul"><div align="left" class="titulo_azul">Observaci&oacute;n</div></td>
            <td colspan="3"><textarea name="ObsRepr" cols="100" rows="3" id="ObsRepr"><?php echo $ObsRepr; ?></textarea></td>
            <td><input name="BtnGrabar2" type="button" value="Cargar a Hornada" onClick="ProcesoHorno('CargaHRepr');" style="width:120px"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
		<?php }?>
		<br>
        <table width="500" border="0" class="TablaInterior">
          <tr>
            <td align="center">
<input name="BtnGrabar" type="button" value="Grabar" onClick="ProcesoHorno('G');" style="width:70px"> 
              <input name="BtnCancelar" type="button" style="width:70px" onClick="ProcesoHorno('C');" value="Cancelar"> 
            <input name="BtnEliminar" type="button" value="Eliminar" onClick="ProcesoHorno('E');" style="width:70px"></td>
          </tr>
        </table> 
        <br>
		<table width="663" cellpadding="3" border="0" cellspacing="0" class="TablaInterior">
          <tr class="TituloCabeceraAzul"> 
            <td width="24" height="18" >&nbsp;</td>
            <td width="59" align="center"> <strong>Turno</strong></td>
            <td width="286" align="center"> <strong>Prod.Sub-Producto</strong></td>
            <td width="161" align="center"> <strong>Stock Inicial </strong></td>
            <td width="100" align="center"> <strong>Peso Beneficiado </strong></td>
          </tr>
          <?php
	if ((isset($Hornada)) && ($Hornada != ""))
	{	
		$Consulta = "select * from pmn_web.carga_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.turno = t2.cod_subclase left join proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto ";
		$Consulta.= " and t1.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " where t2.cod_clase = 1 ";
		$Consulta.= " and hornada = '".$Hornada."'";
		$Consulta.= " and fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " order by t1.turno";
		$Respuesta = mysqli_query($link, $Consulta);		
		//echo "<input type='hidden' name='IdTurno' value=''>";
		//echo "<input type='hidden'   name='IdProducto' value=''>";
		//echo "<input type='hidden'   name='IdSubProducto' value=''>"; 
		//echo "<input type='hidden'   name='IdMostrar' value=''>"; 
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
		
			$Observacion_Repr=explode('//',$Row[observacion_reproceso]);
			$Observacion_Repr=explode('~',$Observacion_Repr[1]);
			if($Row["cod_producto"]==0 && $Row["cod_subproducto"]==0 && $Observacion_Repr[0]=='Reproceso')			
				$Nombre=$Observacion_Repr[0];
			else
				$Nombre=$Row["descripcion"];
			echo "<tr>\n";
			echo "<td>";
			echo "<input type='checkbox' name='IdTurno[".$i."]' value='".$Row[turno]."'>";
			echo "<input type='hidden'   name='IdProducto[".$i."]' value='".$Row["cod_producto"]."'>";
			echo "<input type='hidden'   name='IdSubProducto[".$i."]' value='".$Row["cod_subproducto"]."'>"; 
			echo "<input type='hidden'   name='IdMostrar[".$i."]' value='".$Row[mostrar_pmn]."'>"; 
			echo "</td>\n";
			echo "<td align='center'><input readonly name='TxtTurno[".$i."]'       type='text' size='5' value='".$Row["nombre_subclase"]."'></td>\n";
			echo "<td align='center'><input readonly name='TxtSubProducto[".$i."]' type='text' size='60' value='".$Nombre."'><input readonly name='TxtProducto' type='hidden' size='50' value='".$Row["cod_producto"]."'></td>\n";
			//echo "<td align='center'><input          name='TxtCantDisp[".$i."]'    type='text' size='12' value='".$Row[cant_disponible]."'></td>\n";
			
			$StockAux=MuestraSTOCK($Ano,$Mes,$Row["cod_producto"],$Row["cod_subproducto"],'P');
			echo "<td align='center'><input readonly name='TxtPesoDisp[".$i."]'    type='text'  value='".number_format($StockAux,2,',','.')."'></td>\n";				
			echo "<td align='center'><input name='TxtCantidad[".$i."]'    type='text' value='".number_format($Row[cantidad],2,',','.')."' onKeyDown='SoloNumeros(true,this)'></td>\n";
			echo "</tr>\n";
			$i++;
		}
	}
?>
        </table>      </td>
  </tr>
</table>
  <?php //include("../principal/pie_pagina.php");
	 echo "<script languaje='JavaScript'>";
	 echo "var f=document.frmPrincipal;";
	 if ($Mensaje=='ExisEnT')
	 {
		echo "alert('Existe Reproceso para el Turno Seleccionado.');";
	 }
	 if ($Mensaje=='S')
	 {
		echo "alert('El valor ingresado es mayor que el stock ');";
	 }
	 if ($Mensaje2!='')
	 {
		echo "alert('".$Mensaje2."');";
	 }
	 if ($Elim!='')
	 {
		echo "alert('Detalle Eliminado con �xito');";
	 }
	 if ($ErrorRepr=='NoH')
	 {
		echo "alert('Hornada ".$Hornada." no se ha Ingresado al Sistema');";
	 }
	 if ($GrabaReproc=='S')
	 {
		echo "alert('Se a Cargado Hornada Reproceso.');";
	 }
	 echo "</script>";
  
  ?>		
</form>
</body>
</html>
<?php
function Sales($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta1 = "Select SUM(peso) as Peso from pmn_web.produccion_subproductos ";
	$Consulta1.= " where year(fecha_produccion)= '".$Ano."' and month(fecha_produccion)='".$Mes."'  and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta1."<br>";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Row1 = mysqli_fetch_array($Respuesta1))
		$Valor1=$Row1["peso"];							

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function Calcina($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta1 = "Select SUM(prod_calcina) as ValorCal from pmn_web.deselenizacion ";
	$Consulta1.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Row1 = mysqli_fetch_array($Respuesta1))
		$Valor1=$Row1[ValorCal];							

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function oxido($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta3 = "Select SUM(valor) as ValorPeso from pmn_web.produccion_circulantes_oxidos ";
	$Consulta3.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta1."<br>";
	$Respuesta3 = mysqli_query($link, $Consulta3);
	if ($Row3 = mysqli_fetch_array($Respuesta3))
		$Valor1=$Row3[ValorPeso];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
function ranodos($producto,$subproducto,$Ano,$Mes,$Valor1,$Valor2)
{
	$Consulta4 = "Select SUM(peso_resto) as ValorPeso from pmn_web.descarga_electrolisis_plata ";
	$Consulta4.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta4 = mysqli_query($link, $Consulta4);
	if ($Row4 = mysqli_fetch_array($Respuesta4))
		$Valor1=$Row4[peso_resto];
	
	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function BarroAuLixi($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta4 = "Select SUM(peso) as ValorPeso from pmn_web.carga_lixiviacion_barro_aurifero ";
	$Consulta4.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta1."<br>";
	$Respuesta4 = mysqli_query($link, $Consulta4);
	if ($Row4 = mysqli_fetch_array($Respuesta4))
		$Valor1=$Row4[ValorPeso];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function MetalDore($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta = "select sum(num_anodos) as ProdAnodos from pmn_web.produccion_horno_trof ";
	$Consulta.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	if($Row = mysqli_fetch_array($Respuesta))
		$Valor1=$Row4[ProdAnodos];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}

function Escorias($producto,$subproducto,$Ano,$Mes,&$Valor1,&$Valor2)
{
	$Consulta = "select sum(peso) as PesoFusi from pmn_web.fusion ";
	$Consulta.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."'";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	if($Row = mysqli_fetch_array($Respuesta))
		$Valor1=$Row4[PesoFusi];

	$Consulta2 = "Select SUM(cantidad) as ValCant from pmn_web.carga_horno_trof ";
	$Consulta2.= " where year(fecha)= '".$Ano."' and month(fecha)='".$Mes."' and  cod_producto='".$producto."' and cod_subproducto='".$subproducto."'";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Row2 = mysqli_fetch_array($Respuesta2))
		$Valor2=$Row2[ValCant];
}
?>