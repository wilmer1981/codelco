<?php 
include("../principal/conectar_principal.php");

 	$Seleccion1= "select distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "select distinct t1.nro_solicitud,t1.recargo,t1.rut_proveedor ";
	$Seleccion3= "select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";

	$CodigoDeSistema = 1;
	$CodigoDePantalla = 22;
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
	if(isset($_REQUEST["CmbProveedores"])) {
		$CmbProveedores = $_REQUEST["CmbProveedores"];
	}else{
		$CmbProveedores ="";
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
	if(isset($_REQUEST["Opc"])) {
		$Opc = $_REQUEST["Opc"];
	}else{
		$Opc = 1;
	}
	if(isset($_REQUEST["CmbLey"])) {
		$CmbLey = $_REQUEST["CmbLey"];
	}else{
		$CmbLey = "";
	}
	if(isset($_REQUEST["CmbUnidad"])) {
		$CmbUnidad = $_REQUEST["CmbUnidad"];
	}else{
		$CmbUnidad = "";
	}
	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = "";
	}
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni = 0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin = 50;
	}
	if(isset($_REQUEST["LimitFinAux"])) {
		$LimitFinAux = $_REQUEST["LimitFinAux"];
	}else{
		$LimitFinAux = 50;
	}
	if(isset($_REQUEST["ChkLimite"])) {
		$ChkLimite = $_REQUEST["ChkLimite"];
	}else{
		$ChkLimite = "";
	}
	if(isset($_REQUEST["Chk"])) {
		$Chk = $_REQUEST["Chk"];
	}else{
		$Chk="S";
	}
	if(isset($_REQUEST["Busq"])) {
		$Busq = $_REQUEST["Busq"];
	}else{
		$Busq = "";
	}
	if(isset($_REQUEST["TxtFiltroPrv"])) {
		$TxtFiltroPrv = $_REQUEST["TxtFiltroPrv"];
	}else{
		$TxtFiltroPrv = "";
	}

	//$CodigoDePantalla = 22;

$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Consulta ="SELECT nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila      = mysqli_fetch_array($Respuesta);
$Nivel     = $Fila["nivel"];

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
	Frm.action="cal_consulta_limite_control_grafico.php?Busq=S&Chk="+Chk;
	Frm.submit();	
}
function Recarga(Opcion)
{
	var Frm=document.FrmConsultaLimiteControl;
	var Chk='';
	if(Frm.ChkLimite.checked==true)
		Chk='S';
	Frm.action="cal_consulta_limite_control_grafico.php?Opc=1&Chk="+Chk;
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
	var Chk='N';
	if(Frm.ChkLimite.checked==true)
		Chk='S';
	if (Tipo=="")
	{
		alert ("Debe Seleccionar Opcion");
		return;
	}
	if (Tipo=="")
	{
		alert ("Debe Seleccionar Opcion");
		return;
	}
	if (Frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		Frm.CmbProductos.focus();
		return;
	}
	
	if (Frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		Frm.CmbSubProducto.focus();
		return;
	}
	
	if (Frm.CmbLey.value == "S")
	{
		alert ("Debe Seleccionar Ley");
		Frm.CmbLey.focus();
		return;
	}
	if (Frm.CmbUnidad.value == "S")
	{
		alert ("Debe Seleccionar Unidad");
		Frm.CmbUnidad.focus();
		return;
	}
	
	
    switch (Tipo)
	{
		case "1":
			if (Frm.CmbProductos.value == "-1")
			{
				alert ("Debe Ingresar Producto");
				Frm.CmbProductos.focus();
				return;
			}
			else
			{
				Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
			}
			if (Frm.CmbSubProducto.value == "-1")
			{
				alert ("Debe Ingresar SubProducto");
				Frm.CmbSubProducto.focus();
				return;
			}
			else
			{
				SubProducto=Frm.CmbSubProducto.options[Frm.CmbSubProducto.selectedIndex].text
			}
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
					
						Frm.action= "cal_consulta_limite_control_grafico.php?Buscar=S&LimitIni=0&LimitFin="+Frm.LimitFinAux.value+"&ChkLimite="+Chk+"&Chk="+Chk;
						Frm.submit();
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					
					}
				}
				else
				{
						Frm.action= "cal_consulta_limite_control_grafico.php?Buscar=S&LimitIni=0&LimitFin="+Frm.LimitFinAux.value+"&ChkLimite="+Chk+"&Chk="+Chk;;
						Frm.submit();
				}
			
			break;
	/*	case "E":
			
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
						var ChkLimite='';
						if(Frm.ChkLimite.checked==true)
							ChkLimite='S';	
						URL="cal_consulta_limite_control_respuesta_excel.php?LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
						URL=URL+"&ChkLimite="+ChkLimite;
						window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				
								
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					
					}
				}
				else
				{
						var ChkLimite='';
						if(Frm.ChkLimite.checked==true)
							ChkLimite='S';	
						URL="cal_consulta_limite_control_respuesta_excel.php?LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
						URL=URL+"&ChkLimite="+ChkLimite;
						window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				
				}
			
			break;*/
	}			
}

function Grafico(Inicial)
{	var Frm=document.FrmConsultaLimiteControl;
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
	var Tipo='<?php echo $Opc; ?>'
	if (Tipo=="")
	{
		alert ("Debe Seleccionar Opcion");
		return;
	}
		
  switch (Tipo)
	{
		case "1":
			if (Frm.CmbProductos.value == "-1")
			{
				alert ("Debe Ingresar Producto");
				Frm.CmbProductos.focus();
				return;
			}
			else
			{
				Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
			}
			if (Frm.CmbSubProducto.value == "-1")
			{
				alert ("Debe Ingresar SubProducto");
				Frm.CmbSubProducto.focus();
				return;
			}
			else
			{
				SubProducto=Frm.CmbSubProducto.options[Frm.CmbSubProducto.selectedIndex].text
			}
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
	var Chk='N';
	if(Frm.ChkLimite.checked==true)
		Chk='S';
	URL="cal_consulta_limite_control_respuesta_grafico_2.php?LimitIni="+Inicial+"&LimitFinAux="+Frm.LimitFinAux.value+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&CmbPeriodo="+Frm.CmbPeriodo.value+"&CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&CmbDias="+Frm.CmbDias.value+"&CmbAnoT="+Frm.CmbAnoT.value+"&CmbMesT="+Frm.CmbMesT.value+"&CmbDiasT="+Frm.CmbDiasT.value+"&CmbTipoAnalisis="+Frm.CmbTipoAnalisis.value+"&CmbTipo="+Frm.CmbTipo.value+"&CmbProveedores="+Frm.CmbProveedores.value;
	URL=URL+"&ChkLimite="+Chk+"&CmbLey="+Frm.CmbLey.value+"&CmbUnidad="+Frm.CmbUnidad.value;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				
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
            <td colspan="4">CONSULTA LIMITE DE CONTROL GRAFICO</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="11%"> Producto:</td>
            <td colspan="3" align="left" bgcolor="#efefef">
			<select name="CmbProductos" style="width:250" onChange="Recarga();" <?php if ($Opc!=1) echo "Disabled";?>>
<option value="-1" selected>Seleccionar</option><?php
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
					if ($CmbProductos==59)
					{
						echo "<option value='-2' selected>Todos</option>";
					}
					else
					{
						echo "<option value='-1' selected>Seleccionar</option>";
					}
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
					echo "<option value='-1' selected>Seleccionar</option>";					
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
						$Consulta="SELECT rut_prv,nombre_prv from sipa_web.proveedores "; 
						if($Busq=='S' && $TxtFiltroPrv!='')
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
					$Consulta = "SELECT * from sub_clase where cod_clase = 2 order by cod_subclase";
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
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase=1005 order by cod_subclase";
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
					$Consulta= "SELECT * from sub_clase where cod_clase = 1000";
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
            <td>Ley:</td>
            <td bgcolor="#efefef">  <select name="CmbLey"  onChange="Recarga();">
					<option value="S" selected>Selecionar</option>
					<?php
						$Consulta="SELECT cod_unidad,cod_leyes,abreviatura from proyecto_modernizacion.leyes "; 
						$Consulta.= " where tipo_leyes <> '3' order by abreviatura";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbLey == $Fila["cod_leyes"])
							{	
								echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
								$CmbUnidad=$Fila["cod_unidad"];
								
							}
							else
							{
								echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
							}
						}
					?>
		    </select> </td>
            <td bgcolor="#efefef">Unidad:</td>
            <td bgcolor="#efefef"><select name="CmbUnidad" >
					<option value="S" selected>Selecionar</option>
					<?php
						$Consulta="SELECT cod_unidad,abreviatura from proyecto_modernizacion.unidades "; 
						$Consulta.= " order by abreviatura";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbUnidad == $Fila["cod_unidad"])
								echo "<option value = '".$Fila["cod_unidad"]."' selected>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";				
							else
								echo "<option value = '".$Fila["cod_unidad"]."'>".ucwords(strtolower($Fila["abreviatura"]))."</option>\n";
						}
					?>
				  </select> </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>N&deg; Result:</td>
            <td colspan="3" bgcolor="#efefef"><input name="LimitIni" type="hidden" value="0"><input name="LimitFinAux" type="text" value="<?php echo $LimitFinAux; ?>" size="10" maxlength="4">
			 <?php 
			
			    /*
			    if(!isset($Chk))
			 	{
					$Chk="S";
				}*/
				 if($Chk=='S')
					$checked='checked';
			 ?> &nbsp;&nbsp;&nbsp;&nbsp;<input name="ChkLimite" type="checkbox"  <?php echo $checked;?> value="S"> Solo Limite Control			</td>
          </tr>
          <tr bgcolor="#FFFFFF" class="Detalle02"> 
            <td height="30" colspan="4" align="center"><input name="BtnImprimir" type="button" value="Consultar" style="width:70" onClick="Proceso('L','<?php echo $Opc; ?>');"> 
              &nbsp; 
            <!--  <input name="BtnExcel" type="button" value="Excel" style="width:70" onClick="Proceso('E','<?php echo $Opc; ?>');">
           -->   &nbsp;
            <input name="BtnSalir" type="button" value="Salir" style="width:70" onClick="Salir();">            </td>
          </tr><br>
        </table>
	
	<?php if($Buscar=='S')
	{
	$ConsultaAux = "SELECT t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$ConsultaAux.= " on t1.cod_producto=t2.cod_producto ";
	$ConsultaAux.= " where t1.cod_producto='".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."'";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Producto=$Fila["nom_prod"];
		$SubProducto=$Fila["nom_subprod"];
	}
	
	$Consulta1="SELECT cod_unidad,cod_leyes,abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$CmbLey."' "; 
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Fila=mysqli_fetch_array($Respuesta1))
	{
		$LeyDES=$Fila["abreviatura"];
	}
	$Consulta1="SELECT cod_unidad,abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$CmbUnidad."' "; 
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Fila=mysqli_fetch_array($Respuesta1))
	{
		$UnidadDES=$Fila["abreviatura"];
	}
	$Proveedor=""; //WSO
	if($CmbProveedores=='T' || $CmbProveedores!='' )
	{
		if($CmbProveedores=='T')
		{
			$Proveedor="Todos";
		}
		else
		{
			$ConsultaProv="select rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='".$CmbProveedores."' order by nombre_prv"; 
			$Respuesta = mysqli_query($link, $ConsultaProv);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$Proveedor=str_pad($Fila["rut_prv"], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]));
			}
		}
	}		
	else
	{
		$CmbProveedores='';
	}	
	
	
	
	$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
	mysqli_query($link, $Eliminar);
	?>
	         <br>
        <table width="755"  border="0" align="center" cellpadding="3" cellspacing="1"><!-- class="TablaInterior">-->
          <tr>
            <td align="center">
			<?php
			/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 50;*/
	///echo $LimitIni."   ".$LimitFin."<br>";	
	//$CodigoDeSistema = 1;
	//$CodigoDePantalla = 22;
	$Consulta='';
	if ($CmbTipo=='-1')
	{
		$Tipo='';
	}
	else
	{
		$Tipo=" and t1.tipo='".$CmbTipo."'";
	}
	if ($CmbTipoAnalisis=='-1')
	{
		$TipoAnalisis='';
	}
	else
	{
		$TipoAnalisis=" and t1.cod_analisis='".$CmbTipoAnalisis."'";
	}
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
	$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
//	 inner join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
	$Consulta = $Consulta." where (t1.estado_actual ='6') and t1.recargo<>'R'  ";
	if($CmbPeriodo!='T')
		$Consulta =$Consulta." and (t1.cod_periodo='".$CmbPeriodo."')";
	$Consulta =$Consulta.$Tipo.$TipoAnalisis;
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8')||($CmbCCosto=='6150'))
	{
		$Consulta = $Consulta."  ";
	}
	else
	{
		$Consulta = $Consulta." and t1.cod_producto <> 1 ";
	
	}
	if ($CmbSubProducto==-2)
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t3.cod_producto ='".$CmbProductos."'";
		}
	}
	else
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t3.cod_producto ='".$CmbProductos."'";
		}
		if ($SubProducto!="")
		{
			$Consulta=$Consulta." and t3.cod_subproducto ='".$CmbSubProducto."'";
		}
	}
	if($Proveedor!='')
	{
		if($CmbProveedores!='T')
			$Consulta = $Consulta." and  t1.rut_proveedor='".$CmbProveedores."' ";
	}
	$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";
	$Consulta = $Consulta." and t3.cod_leyes='".$CmbLey."'  and t3.cod_unidad='".$CmbUnidad."' ";
	//if($ChkLimite=="S")
//	{
	
	
		$Marca="N";
		$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
		mysqli_query($link, $Eliminar);
	
		$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud ";
		$Respuesta2=mysqli_query($link, $Criterio);
		while ($Fila=mysqli_fetch_array($Respuesta2))
		{		
								
				$Consulta6 ="select t1.cod_unidad,t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."' and t1.cod_leyes='".$CmbLey."'  and t1.cod_unidad='".$CmbUnidad."'    ";
				$Consulta6.=" and t1.cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'  ";
				$Respuesta3=mysqli_query($link, $Consulta6);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{		
					if($Fila["recargo"]!='R')
					{
						/*if($ChkLimite=='S')
						{
							$Tiene="N";
							$Valor=$Fila3[valor];
							ValorLimiteControl($CmbProductos,$CmbSubProducto,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],&$Valor,&$Tiene);
							if($Tiene=='S')
							{
								$Insertar="insert into cal_web.tmp_limite_control(nro_solicitud,recargo,usuario) values(";
								$Insertar.="'".$Fila["nro_solicitud"]."','".$Fila["recargo"]."','".$CookieRut."')";
								mysqli_query($link, $Insertar);
								$Marca="S";
							}
						}
						else
						{*/
							$Insertar="insert into cal_web.tmp_limite_control(nro_solicitud,recargo,usuario) values(";
							$Insertar.="'".$Fila["nro_solicitud"]."','".$Fila["recargo"]."','".$CookieRut."')";
							mysqli_query($link, $Insertar);
							$Marca="S";
					//	}
					}
				}
						
		
		}
				
		$Consulta= " from cal_web.solicitud_analisis t1 ";
		$Consulta.=" inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and ";
		$Consulta.=" t1.fecha_hora = t3.fecha_hora and t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
		$Consulta.=" inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes inner join  cal_web.tmp_limite_control t5 ";
		$Consulta.=" on t3.nro_solicitud=t5.nro_solicitud and t3.recargo=t5.recargo where t1.recargo<>'R' and t5.usuario='".$CookieRut."' ";
		$Consulta.=" and t3.cod_leyes='".$CmbLey."'  and t3.cod_unidad='".$CmbUnidad."' ";

	
	
	//}

	$ConcRIT2="select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ".$Consulta;
	$Criterio2=$ConcRIT2;
			if($Criterio2!='')
			{
				$Respuesta = mysqli_query($link, $Criterio2);
				$Row = mysqli_fetch_array($Respuesta);
				$Coincidencias = $Row["total_registros"];
				$NumPaginas = ($Coincidencias / $LimitFinAux);
				$LimitFinAnt = $LimitIni;
				$StrPaginas = "";
				echo "Total de registros $Coincidencias <br>   Ver Resultados Graficos en Paginas ";
				for ($i = 0; $i <= $NumPaginas; $i++)
				{
					$LimitIni = ($i * $LimitFin);
					if ($LimitIni == $LimitFinAnt)
					{
						$StrPaginas.=  "<a href=JavaScript:Grafico($LimitIni);>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
					else
					{
						$LimiteInicial=$i * $LimitFin;
						$Param="$LimiteInicial,'$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT','$Enabal','$CmbTipoAnalisis','$CmbTipo','$ChkLimite','$CmbProveedores'";
						$Param=str_replace(" ","%20",$Param);
						//$StrPaginas.=  "<a href=JavaScript:Recarga('$LimiteInicial','$Producto','$SubProducto','$CCosto','$Areas','$CmbProductos','$CmbSubProducto','$CmbCCosto','$CmbAreasProceso','$CmbPeriodo','$CmbAno','$CmbMes','$CmbDias','$CmbAnoT','$CmbMesT','$CmbDiasT');>";
						$StrPaginas.=  "<a href=JavaScript:Grafico($LimitIni);>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
				}	//echo $StrPaginas;
			?>	
		   </td>
		  </tr>
       
  </table>
  
  <?php 
  
  
  }
  
  ?>
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 

function ValorLimiteControl($Producto,$SubProducto,$CodLey,$Unidad,$RutProveedor,$Valor,$Tiene,$link)
	{
	
		
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$RutProveedor."'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
			if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
			{
				$Existe='N';
			}
			else
			{
				$Existe='S';
			}
			
		}
		else
		{
			$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
			$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='T'";
			$RespColor = mysqli_query($link, $Consulta);
			if($FilaColor=mysqli_fetch_array($RespColor))
			{
			
			//    0 <= 70   && 60 >= 70
				if(($Valor>=$FilaColor["limite_inicial"]) && ( $Valor<=$FilaColor["limite_final"] ))
				{
					$Existe='N';
				}
				else
				{
					$Existe='S';
				}
			}
			else
			{
				$Existe='N';
			}
		}
		if($Existe=='S')
			$Tiene='S';
			
		return($Tiene);
	}
	

?>