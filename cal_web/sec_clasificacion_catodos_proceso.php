<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	
	if(isset($_REQUEST["Valores"])) {
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["CmbLey"])) {
		$CmbLey = $_REQUEST["CmbLey"];
	}else{
		$CmbLey = "";
	}
	if(isset($_REQUEST["TxtSTD1"])) {
		$TxtSTD1 = $_REQUEST["TxtSTD1"];
	}else{
		$TxtSTD1 = "";
	}
	if(isset($_REQUEST["TxtSTD2"])) {
		$TxtSTD2 = $_REQUEST["TxtSTD2"];
	}else{
		$TxtSTD2 = "";
	}
	if(isset($_REQUEST["TxtSTD3"])) {
		$TxtSTD3 = $_REQUEST["TxtSTD3"];
	}else{
		$TxtSTD3 = "";
	}
	if(isset($_REQUEST["TxtSTD4"])) {
		$TxtSTD4 = $_REQUEST["TxtSTD4"];
	}else{
		$TxtSTD4 = "";
	}
	if(isset($_REQUEST["TxtSTD5"])) {
		$TxtSTD5 = $_REQUEST["TxtSTD5"];
	}else{
		$TxtSTD5 = "";
	}

	if(isset($_REQUEST["Existe"])) {
		$Existe = $_REQUEST["Existe"];
	}else{
		$Existe = "";
	}
	


	$EstCod='';
	switch ($Proceso)
	{
		case "M":
			$Consulta="select * from cal_web.clasificacion_catodos where cod_leyes='$Valores'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$CmbLey=$Fila["cod_leyes"];
				$TxtSTD1=$Fila["grado_a_codelco"];
				$TxtSTD2=$Fila["grado_a_enami"];
				$TxtSTD3=$Fila["rechazo"];
				$TxtSTD4=$Fila["estandar"];
				$TxtSTD5=$Fila["off_grade"];
			
			}	
		break;
	}
	
	
?>
<html>
<head>
<title>Proceso</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Valida=false;
	
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			Valida=ValidaCampos(Valida,TipoProceso);
			
			if(Valida== false)
			{
				f.action='sec_clasificacion_catodos_01.php?Proceso=N';
				f.submit();
			}
			break;
		case 'M'://MODIFICAR
			f.action='sec_clasificacion_catodos_01.php?Proceso=M&Valores='+f.Valores.value;
			f.submit();
			break;
		case 'S'://SALIR
			window.close();
			break;
	}
}
function ValidaCampos(Res,Op)
{
	var f = document.frmPrincipal;
	if(f.CmbLey.value == 'S')
	{
		alert("Debe Seleccionar Ley");
		f.CmbLey.focus();
		Res=true;
		return;
		
	}
	if(f.TxtSTD1.value == '')
	{
		alert("Debe Ingresar Valor para Grado A Codelco");
		f.TxtSTD1.focus();
		Res=true;
		return;
		
	}
	if(f.TxtSTD2.value == '')
	{
		alert("Debe Ingresar Valor para Grado A Enami");
		f.TxtSTD2.focus();
		Res=true;
		return;
	}
	if(f.TxtSTD3.value == '')
	{
		alert("Debe Ingresar Valor para Rechazo");
		f.TxtSTD3.focus();
		Res=true;
		return;
	}
	if(f.TxtSTD4.value == '')
	{
		alert("Debe Ingresar Valor para Estandar");
		f.TxtSTD4.focus();
		Res=true;
		return;
	}
	return(Res);
}


 

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valores" value="<?php echo $Valores;?>">
	    <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9" align="left">NOTA:Para Los Valores con Decimales usar coma </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Elemento:</td>
            <td width="357" align="left"><span class="ColorTabla02">
			<?php
			if($Proceso =='N')
			{
             	?>	
			  	<select name="CmbLey" style="width:85" onkeypress=buscar_op(this,BtnGrabar,0) >
                <option value='S' selected>Seleccionar</option>
                <?php
				$Consulta="select * from proyecto_modernizacion.leyes order by nombre_leyes";
				$RespMOP=mysqli_query($link, $Consulta);
				while($FilaMop=mysqli_fetch_array($RespMOP))
				{
					if(intval($FilaMop["cod_leyes"])==intval($CmbLey))
						echo "<option value='".$FilaMop["cod_leyes"]."' selected>".$FilaMop["nombre_leyes"]."</option>";
					else
					echo "<option value='".$FilaMop["cod_leyes"]."'>".$FilaMop["nombre_leyes"]."</option>";
				}
				?>
				</select>
				<?php
			}
			else
			{
				$Consulta="select * from proyecto_modernizacion.leyes where cod_leyes='".$CmbLey."' ";
				$RespMOP=mysqli_query($link, $Consulta);
				$FilaMop=mysqli_fetch_array($RespMOP);
				echo $FilaMop["nombre_leyes"];
				?> 
				<input name="CmbLey" type="hidden" value="<?php echo $CmbLey;?>">
				<?php
			}	
				?>	
            </span></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Grado A Codelco:</td>
            <td align="left"><input name="TxtSTD1" type="text" value="<?php echo $TxtSTD1;?>" size="5" maxlength="5" onKeyDown="TeclaPulsada(true)"><span class="InputRojo">*</span> </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Grado A Enami:</td>
            <td align="left"><input name="TxtSTD2" type="text" value="<?php echo $TxtSTD2;?>" size="5" maxlength="5" onKeyDown="TeclaPulsada(true)"><span class="InputRojo">*</span></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Rechazo</td>
            <td align="left"><input name="TxtSTD3" type="text" value="<?php echo $TxtSTD3;?>" size="5" maxlength="5" onKeyDown="TeclaPulsada(true)"><span class="InputRojo">*</span></td>
          </tr>
           <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Estandar</td>
            <td align="left"><input name="TxtSTD4" type="text" value="<?php echo $TxtSTD4;?>" size="5" maxlength="5" onKeyDown="TeclaPulsada(true)"><span class="InputRojo">*</span></td>
          </tr>
           <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Off Grade</td>
            <td align="left"><input name="TxtSTD5" type="text" value="<?php echo $TxtSTD5;?>" size="5" maxlength="5" onKeyDown="TeclaPulsada(true)"></td>
          </tr>
		  <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2"><input name="BtnAceptar" type="button" id="BtnAceptar" style="width:70px;" onClick="Procesos('<?php echo $Proceso;?>')" value="Aceptar">
              <input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Procesos('S')"></td>
          </tr>
		 </table>
	    <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>
<?php
	echo "<script languaje='JavaScript'>";
	if ($Existe==true)
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>	