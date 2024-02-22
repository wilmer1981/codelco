<?php 
	$CodigoDeSistema = 1;
	$CookieRut=$_COOKIE["CookieRut"];

	if(isset($_REQUEST["CmbProductos"])) {
		$CmbProductos = $_REQUEST["CmbProductos"];
	}else{
		$CmbProductos ="";
	}
	if(isset($_REQUEST["CmbSubProducto"])) {
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto ="";
	}
	if(isset($_REQUEST["CmbPeriodo"])) {
		$CmbPeriodo = $_REQUEST["CmbPeriodo"];
	}else{
		$CmbPeriodo ="";
	}
	if(isset($_REQUEST["CmbTipo"])) {
		$CmbTipo = $_REQUEST["CmbTipo"];
	}else{
		$CmbTipo ="";
	}
	if(isset($_REQUEST["CmbTipoAnalisis"])) {
		$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
	}else{
		$CmbTipoAnalisis ="";
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias=1;
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes=date("n");
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno=date("Y");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT=date("j");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT=date("n");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT = date("Y");
	}
	if(isset($_REQUEST["LimitFinAux"])) {
		$LimitFinAux = $_REQUEST["LimitFinAux"];
	}else{
		$LimitFinAux = 50;
	}
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni = 0;
	}
	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc = 1;
	}
	if(isset($_REQUEST["Chk"])) {
		$Chk = $_REQUEST["Chk"];
	}else{
		$Chk="S";
	}

	if(isset($_REQUEST["ChkAgrupacion"])) {
		$ChkAgrupacion = $_REQUEST["ChkAgrupacion"];
	}else{
		$ChkAgrupacion = "";
	}
	if(isset($_REQUEST["ChkFechaMuestra"])) {
		$ChkFechaMuestra = $_REQUEST["ChkFechaMuestra"];
	}else{
		$ChkFechaMuestra = "";
	}
	if(isset($_REQUEST["ChkProducto"])) {
		$ChkProducto = $_REQUEST["ChkProducto"];
	}else{
		$ChkProducto = "";
	}
	if(isset($_REQUEST["ChkSubProducto"])) {
		$ChkSubProducto = $_REQUEST["ChkSubProducto"];
	}else{
		$ChkSubProducto = "";
	}
	if(isset($_REQUEST["ChkPesoMuestra"])) {
		$ChkPesoMuestra = $_REQUEST["ChkPesoMuestra"];
	}else{
		$ChkPesoMuestra = "";
	}
	if(isset($_REQUEST["ChkObservacion"])) {
		$ChkObservacion = $_REQUEST["ChkObservacion"];
	}else{
		$ChkObservacion = "";
	}
	if(isset($_REQUEST["TxtFiltroPrv"])) {
		$TxtFiltroPrv = $_REQUEST["TxtFiltroPrv"];
	}else{
		$TxtFiltroPrv = "";
	}

	/*
	if(isset($_REQUEST["ChkLimite"])) {
		$ChkLimite = $_REQUEST["ChkLimite"];
	}else{
		$ChkLimite = "";
	}*/
	

//	$CodigoDePantalla = 22;
	include("../principal/conectar_principal.php");

$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];

?>
<html>
<head>
<script language="JavaScript">

function Recarga3()
{
	var Frm = document.FrmConsultaLimiteControl;
	var Chk='';
	if(Frm.ChkLimite.checked==true)
		Chk='S';
	Frm.action="cal_consulta_limite_control.php?Busq=S&Chk="+Chk;
	Frm.submit();	
}
function Recarga(Opcion)
{
	var Frm=document.FrmConsultaLimiteControl;
	var Chk='';
	if(Frm.ChkLimite.checked==true)
		Chk='S';
	Frm.action="cal_consulta_limite_control.php?Opc=1&Chk="+Chk;
	Frm.submit();

}
function Proceso(Opcion,Tipo)
{
	var Frm=document.FrmConsultaLimiteControl;
	var Producto="";
	var SubProducto="";
	var CCosto="";
	var Areas="";
	var Periodo="";
	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	
	if (Tipo=="")
	{
		alert ("Debe Seleccionar Opcion");
		return;
	}
		//alert (Frm.CmbPeriodo.value);
    switch (Tipo)
	{
		case "1":
			/*if (Frm.CmbProductos.value == "-1")
			{
				alert ("Debe Ingresar Producto");
				Frm.CmbProductos.focus();
				return;
			}
			else
			{*/
				Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
			/*}
			if (Frm.CmbSubProducto.value == "-1")
			{
				alert ("Debe Ingresar SubProducto");
				Frm.CmbSubProducto.focus();
				return;
			}
			else
			{*/
				SubProducto=Frm.CmbSubProducto.options[Frm.CmbSubProducto.selectedIndex].text
			/*}*/
			break;
		case "3":		
			if (Frm.CmbCCosto.value=="-1")
			{
				alert ("Debe Ingresar Centro Costo");
				Frm.CmbCCosto.focus();
				return;
			}
			else
			{
				CCosto=Frm.CmbCCosto.options[Frm.CmbCCosto.selectedIndex].text;
			}
			break;
		case "2":	
			if (Frm.CmbAreasProceso.value=="-1")
			{
				alert ("Debe Ingresar Area");
				Frm.CmbAreasProceso.focus();
				return;
			}
			else
			{
				Areas=Frm.CmbAreasProceso.options[Frm.CmbAreasProceso.selectedIndex].text;
			}
			break;
	}		
	if (Frm.CmbPeriodo.value=="-1")
	{
		alert ("Debe Ingresar Periodo");
		Frm.CmbPeriodo.focus();
		return;
	}
		
	else
	{	
		Periodo=Frm.CmbPeriodo.options[Frm.CmbPeriodo.selectedIndex].text;
	}
		//
	switch (Opcion)
	{
		case "L":
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
					
						Frm.action= "cal_consulta_limite_control_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value;
						Frm.submit();
					}
					else
					{
						//alert("Debe Ingresar Periodo Mensual");
						Frm.action= "cal_consulta_limite_control_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value;
						Frm.submit();
					}
				}
				else
				{
						Frm.action= "cal_consulta_limite_control_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value;
						Frm.submit();
				}
			
			break;
		case "E":
			
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
					
						var ChkAgrupacion='';
						var ChkFechaMuestra='';
						var ChkProducto='';	
						var ChkSubProducto='';
						var ChkPesoMuestra='';
						var ChkObservacion='';
						var ChkLimite='';
											
						if(Frm.ChkAgrupacion.checked==true)
							ChkAgrupacion='S';
						if(Frm.ChkFechaMuestra.checked==true)
							ChkFechaMuestra='S';
						if(Frm.ChkProducto.checked==true)
							ChkProducto='S';
						if(Frm.ChkSubProducto.checked==true)
							ChkSubProducto='S';
						if(Frm.ChkPesoMuestra.checked==true)
							ChkPesoMuestra='S';
						if(Frm.ChkObservacion.checked==true)
							ChkObservacion='S';	
						
						if(Frm.ChkLimite.checked==true)
							ChkLimite='S';	
						URL="cal_consulta_limite_control_respuesta_excel.php?LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
						URL=URL+"&ChkAgrupacion="+ChkAgrupacion+"&ChkFechaMuestra="+ChkFechaMuestra+"&ChkProducto="+ChkProducto+"&ChkSubProducto="+ChkSubProducto+"&ChkPesoMuestra="+ChkPesoMuestra+"&ChkObservacion="+ChkObservacion+"&ChkLimite="+ChkLimite;
						window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				
								
					}
					else
					{
						var ChkAgrupacion='';
						var ChkFechaMuestra='';
						var ChkProducto='';	
						var ChkSubProducto='';
						var ChkPesoMuestra='';
						var ChkObservacion='';
						var ChkLimite='';
											
						if(Frm.ChkAgrupacion.checked==true)
							ChkAgrupacion='S';
						if(Frm.ChkFechaMuestra.checked==true)
							ChkFechaMuestra='S';
						if(Frm.ChkProducto.checked==true)
							ChkProducto='S';
						if(Frm.ChkSubProducto.checked==true)
							ChkSubProducto='S';
						if(Frm.ChkPesoMuestra.checked==true)
							ChkPesoMuestra='S';
						if(Frm.ChkObservacion.checked==true)
							ChkObservacion='S';	
						
						if(Frm.ChkLimite.checked==true)
							ChkLimite='S';	
						URL="cal_consulta_limite_control_respuesta_excel.php?LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
						URL=URL+"&ChkAgrupacion="+ChkAgrupacion+"&ChkFechaMuestra="+ChkFechaMuestra+"&ChkProducto="+ChkProducto+"&ChkSubProducto="+ChkSubProducto+"&ChkPesoMuestra="+ChkPesoMuestra+"&ChkObservacion="+ChkObservacion+"&ChkLimite="+ChkLimite;
						window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
					
					}
				}
				else
				{
						var ChkAgrupacion='';
						var ChkFechaMuestra='';
						var ChkProducto='';	
						var ChkSubProducto='';
						var ChkPesoMuestra='';
						var ChkObservacion='';
						var ChkLimite='';
											
						if(Frm.ChkAgrupacion.checked==true)
							ChkAgrupacion='S';
						if(Frm.ChkFechaMuestra.checked==true)
							ChkFechaMuestra='S';
						if(Frm.ChkProducto.checked==true)
							ChkProducto='S';
						if(Frm.ChkSubProducto.checked==true)
							ChkSubProducto='S';
						if(Frm.ChkPesoMuestra.checked==true)
							ChkPesoMuestra='S';
						if(Frm.ChkObservacion.checked==true)
							ChkObservacion='S';	
						
						if(Frm.ChkLimite.checked==true)
							ChkLimite='S';	
						URL="cal_consulta_limite_control_respuesta_excel.php?LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
						URL=URL+"&ChkAgrupacion="+ChkAgrupacion+"&ChkFechaMuestra="+ChkFechaMuestra+"&ChkProducto="+ChkProducto+"&ChkSubProducto="+ChkSubProducto+"&ChkPesoMuestra="+ChkPesoMuestra+"&ChkObservacion="+ChkObservacion+"&ChkLimite="+ChkLimite;
						window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				
				}
			
			break;
	}			
}
function Salir()
{
	var Frm=document.FrmConsultaLimiteControl;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}


</script>
<title>Consulta Limite Control </title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0"> 
<form name="FrmConsultaLimiteControl" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="761" align="center" valign="middle">
	  <table width="755" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
            <td colspan="4">CONSULTA LIMITE DE CONTROL </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="11%"> Producto:</td>
            <td colspan="3" align="left" bgcolor="#efefef">
			<select name="CmbProductos" style="width:250" onChange="Recarga();" <?php if ($Opc!=1) echo "Disabled";?>>
<option value="-1" selected>Todos</option><?php
				if ($Opc=="1")
				{
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
					{
						$Consulta="select cod_producto,descripcion from productos order by descripcion"; 
					}
					else
					{
						$Consulta="select cod_producto,descripcion from productos  order by descripcion"; 
					}
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
						{
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
						else
						{
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					}
				}
		
		    ?>              
</select> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>SubProducto:</td>
            <td colspan="3" bgcolor="#efefef"><select name="CmbSubProducto" style="width:250" <?php if ($Opc!=1) echo "disabled"; ?>>
            <?php
				if ($Opc=="1")
				{
					/*if ($CmbProductos==59)
					{*/
						echo "<option value='-2' selected>Todos</option>";
					/*}
					else
					{
						echo "<option value='-1' selected>Seleccionar</option>";
					}*/
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
					{
						$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
					}
					else
					{
						if ($CmbProductos=='1')
						{
							$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '1' and cod_subproducto='92' "; 											
						}
						else
						{
							$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
						}
					}	
					$Consulta.=" order by descripcion ";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
												
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				else
				{
					echo "<option value='-2' selected>Todos</option>";					
				}			
		    ?>
              </select> </td>
          </tr>
           <?php 
		  if($CmbProductos=='1')
		  {
		  	if(!isset($CmbProveedores))
				$CmbProveedores='T';
		  ?>
			  <tr bgcolor="#FFFFFF"> 
				<td>Proveedores  </td>
				<td width="6%">
				  <select name="CmbProveedores" style="width:280">
					<option value="T" selected>Todos</option>
					<?php
						$Consulta="select rut_prv,nombre_prv from sipa_web.proveedores "; 
						if($Busq=='S'&&$TxtFiltroPrv!='')
						  	 $Consulta.= " where  nombre_prv like '%".$TxtFiltroPrv."%' "; 	
						$Consulta.= " order by nombre_prv";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbProveedores == $Fila["rut_prv"])
								echo "<option value = '".$Fila["rut_prv"]."' selected>".str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]))."</option>\n";				
							else
								echo "<option value = '".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]))."</option>\n";
						}
					?>
				  </select></td>
			      <td >Filtro&nbsp;Prv:</td>
		          <td bgcolor="#efefef"><input type="text" name="TxtFiltroPrv" size="20" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
        </tr>
			
		  <?php
		  }
		  else
		  {
		  ?>
		 	 <input type="hidden" name="CmbProveedores" value="">
		  
		  <?php
		  }?>	
		  
          <tr bgcolor="#FFFFFF"> 
            <td>Periodo:</td>
            <td bgcolor="#efefef"> 
              <?php	
					if (($Opc=="1")||($Opc=="2")||($Opc=="3"))
					{
						echo "<select name='CmbPeriodo' style='width:130'>";
					}
					else
					{
						echo "<select name='CmbPeriodo' disabled style='width:130'>";					
					}	
                	echo "<option value ='T' selected>Todos</option>";
					$Consulta = "select * from sub_clase where cod_clase = 2 order by cod_subclase";
					$Respuesta= mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						$Descripcion = str_replace(".","",$Fila["nombre_subclase"]);
						
						if ($CmbPeriodo==$Fila["cod_subclase"])
						{
						
							echo "<option value = '".$Fila["cod_subclase"]."' selected>".$Descripcion."</option>\n";						
						}
						else
						{
							echo "<option value = '".$Fila["cod_subclase"]."'>".$Descripcion."</option>\n";
						}	
					}
					echo "</select>&nbsp;";
						
				?>            </td>
			<td width="13%">&nbsp;</td>
			<td width="39%" bgcolor="#efefef">&nbsp;</td>
          </tr>
		  <tr bgcolor="#FFFFFF">
		  <td>Tipo Muestra:</td>
		  <td colspan="1" bgcolor="#efefef">
			<?php					
					echo "<select name='CmbTipo' style='width:110'>";
					echo "<option value='-1' selected>Todos</option>";
					$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase=1005 order by cod_subclase";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($Fila["cod_subclase"]== $CmbTipo)
						{
							echo "<option value =".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";				
						}
						else
						{
							echo "<option value =".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";
						}	
					}
					echo "</select>";
					?>
			<td>Tipo&nbsp;Analisis:</td><td bgcolor="#efefef"><?php 
					echo "<select name='CmbTipoAnalisis' style='width:120'>";
					echo "<option value = '-1' selected>Todos</option>\n";
					$Consulta= "select * from sub_clase where cod_clase = 1000";
					$Respuesta= mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbTipoAnalisis == $Fila["cod_subclase"])
						{
							echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 			
						}
						else			
						{	
							if ($Fila["cod_subclase"]=='1')
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
							else
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
						}
					}
			?>		
		  </td>
		  </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26" align="left">Fecha Inicio:</td>
            <td colspan="1" bgcolor="#efefef"><?php
				//if (($CmbPeriodo=='1')||($CmbPeriodo=='2')||($CmbPeriodo=='3'))
				//{

					echo "<select name='CmbDias'>";
						for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}
							else
							{
								if ($i==date("j"))
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}	
						  }
					echo"</select>";
					echo"<select name='CmbMes'>";
					  for($i=1;$i<13;$i++)
					  {
							if (isset($CmbMes))
							{
								if ($i==$CmbMes)
								{
									echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$meses[$i-1]."</option>\n";
								}
							
							}	
							else
							{
								if ($i==date("n"))
								{
									echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$meses[$i-1]."</option>\n";
								}
							}	
						}
					echo "</select>";
					echo "<select name='CmbAno'>";
						for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}
							else
							{
								if ($i==date("Y"))
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
	    			echo "</select>&nbsp;&nbsp;";
					?>			</td>	<td>Fecha&nbsp;Termino:</td>
						<td bgcolor="#efefef"><?php
					echo "<select name='CmbDiasT'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDiasT))
						{
							if ($i==$CmbDiasT)
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}
						else
						{
							if ($i==date("j"))
							{
								echo "<option selected value= '".$i."'>".$i."</option>";
							}
							else
							{
							  echo "<option value='".$i."'>".$i."</option>";
							}
						}	
					}
				  echo "</select>";
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
				   echo "</select>";
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}		
					}
				  echo "</select>";
				?></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>Ver Adicional:</td>
            <td colspan="3" bgcolor="#efefef">
			<input name="ChkAgrupacion" type="checkbox" value="S">
            Agrupacion 
            <input name="ChkFechaMuestra" type="checkbox" value="S">
            FechaMuestra
            <input name="ChkProducto" type="checkbox" value="S"> 
            Producto 
            <input name="ChkSubProducto" type="checkbox" value="S">
            SubProducto 
            <input name="ChkPesoMuestra" type="checkbox" value="S">
            Peso Muestra 
            <input name="ChkObservacion" type="checkbox" value="S">
            Observacion </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>N&deg; Result:</td>
            <td colspan="3" bgcolor="#efefef"><input name="LimitIni" type="hidden" value="0"><input name="LimitFinAux" type="text" value="<?php echo $LimitFinAux; ?>" size="10" maxlength="4">
			 <?php 
			
			 
			    /*if(!isset($Chk))
			 	{
					$Chk="S";
				}*/
				$checked=''; //WSO
				if($Chk=='S')
					 $checked='checked';
			 ?> &nbsp;&nbsp;&nbsp;&nbsp;<input name="ChkLimite" type="checkbox"  <?php echo $checked;?> value="S"> Solo Limite Control
			
			</td>
            
          </tr>
          
          
          <tr bgcolor="#FFFFFF">
            
            <td colspan="4" bgcolor="#efefef" align="center">
			El rango de fechas no Puede Exceder a 1 mes, por tiempo de respuesta. 
			</td>
            
          </tr>
          
          <tr bgcolor="#FFFFFF" class="Detalle02"> 
            <td height="30" colspan="4" align="center"><input name="BtnImprimir" type="button" value="Consultar" style="width:70" onClick="Proceso('L','<?php echo $Opc; ?>');"> 
              &nbsp; 
              <input name="BtnExcel" type="button" value="Excel" style="width:70" onClick="Proceso('E','<?php echo $Opc; ?>');">
              &nbsp;
            <input name="BtnSalir" type="button" value="Salir" style="width:70" onClick="Salir();">            </td>
          </tr><br>
        </table>
	  <br>
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
