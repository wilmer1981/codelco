<?php 
	$CodigoDeSistema = 5;
	$CodigoDePantalla = 2;	
	include("../principal/conectar_principal.php");
	$sql = "SELECT * from leyes order by cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		$valor = intval($row["cod_leyes"]);
		$Leyes[$valor] = $row["nombre_leyes"];
	}
	include("../principal/cerrar_principal.php");	

	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else {
		$Producto = "";
	}
	if(isset($_REQUEST["Proveedor"])){
		$Proveedor = $_REQUEST["Proveedor"];
	}else {
		$Proveedor = "";
	}
	
	if(isset($_REQUEST["NomBuscado"])){
		$NomBuscado = $_REQUEST["NomBuscado"];
	}else {
		$NomBuscado = "";
	}


	
?>	
<html>
<head>
<title>Sistema de Impurezas</title>
<link href="../principal/estilos/css_imp_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":   //CARGAR LIMITES
			if (f.Producto.value == "000")
			{
				f.NomBuscado.value = "";
				f.Proveedor.value = "";
			}
			f.action="imp_ing_limites.php";
			f.submit();
			break 
		case "BN":   //BUSCAR POR NOMBRE DE PROVEEDOR
			f.action="imp_ing_limites.php";
			f.submit();
			break 
		case "NL":    //NUEVO LIMITE
			URL="imp_ing_limites02.php?Producto=" + f.Producto.value + "&Proveedor=" + f.Proveedor.value;
			window.open(URL,"","top=320px,left=120px, width=600px, height=200px, menubar=no, resizable=yes, scrollbars=NO");
			break
		case "ML":   //MODIFICAR LIMITES
			var Valor="";
			for (i=0;i<f.length;i++)
			{
				if ((f.elements[i].name=="CodLeyes") && (f.elements[i].checked==true))
				{
					Valor = f.elements[i].value;
				}	
			}
			if (Valor!="")
			{
				URL="imp_ing_limites02.php?Proceso=ML&Producto=" + f.Producto.value + "&Proveedor=" + f.Proveedor.value + "&Ley=" + Valor;
				window.open(URL,"","top=350px,left=120px, width=600px, height=200px, menubar=no, resizable=yes, scrollbars=NO");				
			}
			else
			{
				alert("Debe seleccionar un registro para Modificar.");
				return;
			}						
			break
		case "EL":   //ELIMINAR LIMITES
			var Valor="";
			for (i=0;i<f.length;i++)
			{
				if ((f.elements[i].name=="CodLeyes") && (f.elements[i].checked==true))
				{
					Valor = f.elements[i].value;
				}	
			}
			if (Valor!=""){
				var msg=confirm("Seguro que desea eliminar este registro?");
				//alert("Valor:"+Valor);			
				if (msg==true){
					f.action="imp_ing_limites01.php?Proceso=EL&Leyes=" + Valor;
					f.submit();
				}else{
					return;
				}	
			}else{
				alert("Debe seleccionar un registro para Eliminar.");
				return;
			}						
			break
		case "S":  //SALIR
			f.action="../principal/sistemas_usuario.php?CodSistema=5";
			f.submit();
			break 			 			 			
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php 
	include("../principal/encabezado.php");
	include("../principal/conectar_imp_web.php");
?>
  <table width="770" height="330" border="0" cellspacing="0" cellpadding="0" class="TablaPrincipal">
    <tr>
      <td height="380"><div style="position:absolute; left: 105px; top: 54px; width: 650px; height: 27px;"> 
          <table width="602" height="25" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
            <tr> 
              <td width="15" height="23" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
              </td>
              <td width="55">Producto</td>
              <td width="371"><SELECT name="Producto" style="width:350">
                  <option SELECTed value="000">*** Producto EN GENERAL ***</option>
                  <?php
						$Consulta = "SELECT * from Productos order by tipo_producto";
						$result = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($result))
						{
							if ($Producto == $Row["tipo_producto"])
							{
								echo "<option SELECTed value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
							}
							else
							{
								echo "<option value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
							}
						}
					?>
					</SELECT> </td>
              <td width="222" align="center" valign="middle"><input type="Button" name="BtnCargar" value="Cargar Datos" onClick="Proceso('C');"></td>
            </tr>
          </table>
        </div>
        <div style="position:absolute; left: 105px; top: 87px; width: 649px; height: 67px;"> 
          <table width="603" height="67" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
            <tr> 
              <td width="12" height="63"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
              </td>
              <td width="341">Rut 
                <SELECT name="Proveedor" style="width:300px">
                  <option value='000000000'>*** PROVEEDORES EN GENERAL ***</option>
                  <?php
					if ($Producto != "000")
					{
						$sql = "SELECT * from proveedores ";
						$sql.= " where tipo_producto = '".$Producto."'";
						if ($NomBuscado != "*"){
							$sql.= " and nombre like '%".$NomBuscado."%'";
						}
						$sql.= " order by nombre";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_array($result)){
							if ($Proveedor == $row["rut_proveedor"]){
								echo "<option SELECTed value='".$row["rut_proveedor"]."'>".$row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]))."</option>\n";
							}else{
								echo "<option value='".$row["rut_proveedor"]."'>".$row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]))."</option>\n";
							}
						}
					}
					?>
                </SELECT> </td>
              <td width="238" valign="middle"> <table width="90%" border="0" cellpadding="2" cellspacing="0" class="TablaInterior">
                  <tr> 
                    <td><div align="center"><strong>Cargar Lista de Proveedores</strong></div></td>
                  </tr>
                  <tr> 
                    <td align="center"><input name="NomBuscado" type="text" value="<?php echo $NomBuscado;?>" size="15">                      &nbsp; <input type="Button" name="BtnBuscarNombre" value="Buscar" onClick="Proceso('BN')"> 
                    <strong>[*] = Todos</strong></td></tr>
                </table></td>
            </tr>
          </table>
        </div>
        <div style="position:absolute;width:572px;height:22px;top:160px;left:140px;;overflow:auto"> 
          <table width="547" height="20" border="0" align="left" cellpadding="2" cellspacing="0" id="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="30" height="18">&nbsp;</td>
              <td width="50"><strong>C&oacute;digo</strong></td>
              <td width="300"><strong>Descripci&oacute;n</strong></td>
              <td width="141"><strong>L&iacute;mite</strong></td>
            </tr>
          </table>
        </div>
        <div style="position:absolute;width:565px;height:217px;top:180px;left:140px;overflow:auto"> 
          <table width="547" border="1" cellpadding="0" align="left" cellspacing="0" id="TablaDetalle">
            <?php
	if (isset($Producto))
	{
		$sql = "SELECT * from limites ";
		if ($Producto!="000")
		{
			$sql.= " where tipo_producto = '".$Producto."' ";
			//$sql.= " and rut_proveedor = '".$Proveedor."'"; //estaba desactivado
		}
		$sql.= " order by cod_leyes";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_array($result))
		{
			echo "<tr bgcolor='".$ColorTabla2."'>\n";
			echo "<td width=30 align='center'><input type='radio' name='CodLeyes' value='".$row["cod_leyes"]."'></td>\n";
			echo "<td width=50><font color='#FFFF33'>".$row["cod_leyes"]."&nbsp;</font></td>\n";
			$CodLey = intval($row["cod_leyes"]);
			echo "<td width=300><font color='#FFFF33'>".$Leyes[$CodLey]."&nbsp;</font></td>\n";
			echo "<td width=141 align='right'><font color='#FFFF33'>".number_format($row["limite"],4,',','.')."&nbsp;</font></td>\n";
			echo "</tr>\n";
		}
	}
?>
          </table>
        </div>
        <div style="position:absolute;width:600px;top:405px;left:102px"> 
          <table width="400" border="0" align="center" cellpadding="2" cellspacing="0">
            <tr align="center" valign="middle"> 
              <td><input type="button" name="BtnNuevaLey" value="Nueva Ley" style="width:80px" onClick="Proceso('NL');"></td>
              <td><input type="button" name="BtnModificar" value="Modificar" style="width:80px" onClick="Proceso('ML');"></td>
              <td><input type="button" name="BtnEliminar" value="Eliminar" style="width:80px" onClick="Proceso('EL');"></td>
              <td><input type="button" name="BtnSalir" value="Salir" style="width:80px" onClick="Proceso('S');"></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
