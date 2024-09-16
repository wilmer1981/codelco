<?php
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Buscar"])){
		$Buscar=$_REQUEST["Buscar"];
	}else{
		$Buscar="";
	}
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valor"])){
		$Valor = $_REQUEST["Valor"];
	}else{
		$Valor = "";
	}
	if(isset($_REQUEST["ValoresAgregados"])){
		$ValoresAgregados = $_REQUEST["ValoresAgregados"];
	}else{
		$ValoresAgregados = "";
	}

	if(isset($_REQUEST["TxtDescripcion"])){
		$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	}else{
		$TxtDescripcion = "";
	}
	if(isset($_REQUEST["CmbProducto"])){
		$CmbProducto = $_REQUEST["CmbProducto"];
	}else{
		$CmbProducto = "";
	}
	if(isset($_REQUEST["TxtCodGrupo"])){
		$TxtCodGrupo = $_REQUEST["TxtCodGrupo"];
	}else{
		$TxtCodGrupo = "";
	}
	
	//$OptAbast     = isset($_REQUEST["OptAbast"])?$_REQUEST["OptAbast"]:"";

	if(!isset($OptAbast))
	{
		$EstOpt1='checked';
		$EstOpt2='';
	}
	$NombreBoton='Grabar';
	$Habilitar='';	
	$SubProdAgregados=array();
	switch($Proceso)
	{
		case "N":
			$Consulta="SELECT ifnull(max(cod_grupo)+1,1) as grupo_nuevo from sipa_web.grupos_productos";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtCodGrupo=$Fila["grupo_nuevo"];
			break;
		case "M":
			$NombreBoton='Modificar';
			$Habilitar='disabled';		
			$Datos2=explode('~~',$Valor);
			$TxtCodGrupo=$Datos2[0];
			$Consulta="SELECT distinct t2.cod_producto,t1.cod_grupo,t1.descripcion_grupo,t1.abast_minero from sipa_web.grupos_productos t1 inner join  ";
			$Consulta.="sipa_web.grupos_prod_subprod t2 on t1.cod_grupo=t2.cod_grupo where t1.cod_grupo='".$TxtCodGrupo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$TxtDescripcion=$Fila["descripcion_grupo"];
			if($Fila["abast_minero"]=='S')
			{
				$EstOpt1='checked';
				$EstOpt2='';
			}
			else
			{
				$EstOpt1='';
				$EstOpt2='checked';
			}
			//$CmbProducto=$Fila["cod_producto"];
		 	if($Buscar=="")
			//if(!isset($Buscar) || $Buscar=="")
			{
				$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nomprod,t3.abreviatura as nomsubprod,lpad(t1.cod_subproducto,2,0) as orden,t3.cod_subproducto as subprod from sipa_web.grupos_prod_subprod t1 ";
				$Consulta.="left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";			
				$Consulta.="left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";			
				$Consulta.="where t1.cod_grupo='".$TxtCodGrupo."' order by nomprod,nomsubprod";
				//echo $Consulta;
				$RespSubProd=mysqli_query($link, $Consulta);
				while($FilaSubProd=mysqli_fetch_array($RespSubProd))
				{
					$Clave=$FilaSubProd["cod_producto"].$FilaSubProd["cod_subproducto"];
					$SubProdAgregados[$Clave][0]=$FilaSubProd["cod_producto"];
					$SubProdAgregados[$Clave][1]=$FilaSubProd["cod_subproducto"];
					$SubProdAgregados[$Clave][2]=$FilaSubProd["nomprod"];
					$SubProdAgregados[$Clave][3]=$FilaSubProd["nomsubprod"];			
				}
			}	
			break;
	}
	if($ValoresAgregados!="")
	{
		//echo $ValoresAgregados;
		reset($SubProdAgregados);
		$Datos=explode('//',$ValoresAgregados);
		foreach($Datos as $c => $v)
		{
			$Datos2=explode('~',$v);
			if(isset($Datos2[0]) and isset($Datos2[1])){
				$Clave=$Datos2[0].$Datos2[1];
			}else{
				$Clave="";
			}
			//$Clave=$Datos2[0].$Datos2[1];
			if(isset($Datos2[0])){
				$SubProdAgregados[$Clave][0]=$Datos2[0];
			}else{
				$SubProdAgregados[$Clave][0]="";
			}
			if(isset($Datos2[1])){
				$SubProdAgregados[$Clave][1]=$Datos2[1];
			}else{
				$SubProdAgregados[$Clave][1]="";
			}
			if(isset($Datos2[2])){
				$SubProdAgregados[$Clave][2]=$Datos2[2];
			}else{
				$SubProdAgregados[$Clave][2]="";
			}
			if(isset($Datos2[3])){
				$SubProdAgregados[$Clave][3]=$Datos2[3];
			}else{
				$SubProdAgregados[$Clave][3]="";
			}
			/*
			$SubProdAgregados[$Clave][0]=$Datos2[0];
			$SubProdAgregados[$Clave][1]=$Datos2[1];
			$SubProdAgregados[$Clave][2]=$Datos2[2];
			$SubProdAgregados[$Clave][3]=$Datos2[3];
			*/
		}
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
	var Datos="";
	var Datos2="";
	
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			//if(ValidarCampos())
			//{
				Datos=RecuperarValoresCheckeado();
				//alert(Datos);
				f.action='rec_grupos_producto_proceso01.php?Proceso=N&Valores='+Datos;
				f.submit();
			//}	
			break;
		case 'M'://MODIFICAR
			Datos=RecuperarValoresCheckeado();
			//alert(Datos);
			f.action='rec_grupos_producto_proceso01.php?Proceso=M&Valores='+Datos;
			f.submit();
			break;
		case 'A'://AGREGAR PRODUCTOS Y SUBPRODUCTO AL GRUPO
			Datos=RecuperarValoresCheckeado2();
			Datos2=RecuperarValoresCheckeado();
			if(Datos2!='')
				Datos=Datos+'//'+Datos2;
			if(Datos!='')
			{
				f.action='rec_grupos_producto_proceso.php?ValoresAgregados='+Datos;
				f.submit();
			}	
			break;
		case 'S'://SALIR
			window.close();
			break;
	}
	
}
function ValidarCampos()
{
	var f = document.frmPrincipal;
	var Validado=true;
	var Valores="";
	
	if(f.TxtDescripcion.value=='')
	{
		alert('Debe Ingresar Descripcion');
		f.TxtDescripcion.focus();
		Validado=false;
		return;
	}
	if(f.TxtConjunto.value=='')
	{
		alert('Debe Ingresar Conjunto');
		f.TxtConjunto.focus();
		Validado=false;
		return;
	}
	Valores=RecuperarValoresCheckeado();
	if(Valores=='')
	{					
		alert('Debe Seleccionar Proveedor(s)');
		Validado=false;
		return;
	}	
}
function Recarga()
{
	var f = document.frmPrincipal;
	var Datos='';
	
	Datos=RecuperarValoresCheckeado();
	if(Datos!='')
		f.action='rec_grupos_producto_proceso.php?Buscar=S&ValoresAgregados='+Datos;
	else
		f.action='rec_grupos_producto_proceso.php?Buscar=S';
	f.submit();		
}
function RecuperarValoresCheckeado()
{
	var f = document.frmPrincipal;
	var Valores="";
	
	for (i=1;i<f.CheckSubProd.length;i++)
	{
		if (f.CheckSubProd[i].checked==true)
			Valores=Valores + f.CheckSubProd[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function RecuperarValoresCheckeado2()
{
	var f = document.frmPrincipal;
	var Valores="";
	
	for (i=1;i<f.CheckAgregar.length;i++)
	{
		if (f.CheckAgregar[i].checked==true)
			Valores=Valores + f.CheckAgregar[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function CheckearTodo()
{
	var f = document.frmPrincipal;
	try
	{
		f.CheckSubProd[0];
		for (i=1;i<f.CheckSubProd.length;i++)
		{
			if (f.CheckTodos.checked==true)
				f.CheckSubProd[i].checked=true;
			else
				f.CheckSubProd[i].checked=false;
		}
	}
	catch (e)
	{
	}
}
function CheckearTodo2()
{
	var f = document.frmPrincipal;
	try
	{
		f.CheckAgregar[0];
		for (i=1;i<f.CheckAgregar.length;i++)
		{
			if (f.CheckTodos2.checked==true)
				f.CheckAgregar[i].checked=true;
			else
				f.CheckAgregar[i].checked=false;
		}
	}
	catch (e)
	{
	}
}
function BuscarSubProd()
{
	window.open("rec_buscar_subproducto.php","","top=10,left=50,width=600,height=460,scrollbars=yes,resizable=yes");
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<?php echo $Proceso;?>">
<input type="hidden" name="Valor" value="<?php echo $Valor;?>">
<table width="720" height="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="360" height="137" valign="top">
	<table width="356" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
      <tr align="center" bgcolor="#FFFFFF">
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td width="68" align="right">Cod.Grupo:</td>
        <td width="273"><div align="left">
            <input type="text" name="TxtCodGrupo" size="10" value='<?php echo $TxtCodGrupo;?>' readonly="true" >
        </div></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td height="28" align="right">Descripcion:</td>
        <td><div align="left">
            <input type="text" name="TxtDescripcion" size="40" value='<?php echo $TxtDescripcion;?>' onKeyDown="TeclaPulsada2('N',true,this.form,'TxtConjunto');">
        </div></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td align="right">Abast.Minero:</td>
        <td><div align="left">
          Si
          <input name="OptAbast" type="radio" value="S" <?php echo $EstOpt1;?>>
          No
          <input name="OptAbast" type="radio" value="N" <?php echo $EstOpt2;?>>
</div></td>
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
        <td>&nbsp; </td>
        <td><input name="BtnNuevo" type="button" style="width:70px;" value="<?php echo $NombreBoton;?>" onClick="Procesos('<?php echo $Proceso;?>')">
            <input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Procesos('S')"></td>
      </tr>
    </table></td>
    <td width="344" rowspan="2" valign="top">
	<div style="position:absolute; left: 390px; top: 30px; width: 340px; height: 420px; OVERFLOW: auto;" id="div2">
	<table width="320" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
      <tr class="ColorTabla01">
        <td width="20" align="center"><input type="checkbox" name="CheckTodos" onClick="CheckearTodo()" value="checkbox"></td>
        <td width="20" align="center" >Cod</td>
        <td width="120" align="center" >Producto</td>
        <td width="20" align="center" >Cod</td>
        <td width="120" align="center" >SubProducto</td>
      </tr>
      <?php
			reset($SubProdAgregados);
			echo "<input type='hidden' name='CheckSubProd'>";
			//while(list($c,$v)=each($SubProdAgregados))
			foreach($SubProdAgregados as $c => $v)
			{
				echo "<tr bgcolor='#FFFFFF'>";
				$CodValor=$v[0]."~".$v[1]."~".$v[2]."~".$v[3];
				echo "<td align='center'><input type='checkbox' name='CheckSubProd' value='".$CodValor."' checked></td>";
				echo "<td align='right'>".str_pad($v[0],2,0,STR_PAD_LEFT)."&nbsp;</td>";
				echo "<td align='left'>".$v[2]."</td>";
				echo "<td align='right'>".str_pad($v[1],2,0,STR_PAD_LEFT)."&nbsp;</td>";
				echo "<td align='left'>".$v[3]."</td>";
				echo "</tr>";
			}
		 ?>
    </table></div></td>
    </tr>
  <tr>
    <td valign="top">
	
	<table width="335" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
      <tr align="center" bgcolor="#FFFFFF">
        <td width="49" align="right"><a href="javascript:BuscarSubProd()">Producto:</a></td>
        <td width="292" align="left"><SELECT name="CmbProducto" onChange="Recarga()" style="width:200">
            <option class="NoSelec" value="S">Seleccionar</option>
            <?php
				$Consulta = "SELECT cod_producto, abreviatura as nom_prod, ";
				$Consulta.= " case when length(cod_producto)<2 then concat('0',cod_producto) else cod_producto end as orden ";
				$Consulta.= " from proyecto_modernizacion.productos ";
				$Consulta.= " order by nom_prod ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProducto == $Fila["cod_producto"])
						echo "<option SELECTed value='".$Fila["cod_producto"]."'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_prod"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_producto"]."'>".str_pad($Fila["cod_producto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_prod"])."</option>\n";
				}
			  ?>
        </SELECT>
          <input name="BtnAgregar" type="button" style="width:55px;" value="Agregar" onClick="Procesos('A')"></td>
      </tr>
    </table>      
	<div style="position:absolute; left: 14px; top: 190px; width: 355px; height: 250px; OVERFLOW: auto;" id="div2">      
	  <table width="335" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
      <tr class="ColorTabla01">
        <td width="20" align="center"><input type="checkbox" name="CheckTodos2" onClick="CheckearTodo2()" value="checkbox"></td>
        <td width="20" align="center" >Cod</td>
        <td width="290" align="center" >SubProducto</td>
      </tr>
      <?php
		 	$Consulta="SELECT t1.cod_producto,t2.cod_subproducto,t1.abreviatura as nomprod,t2.abreviatura as nomsubprod,lpad(t2.cod_subproducto,2,0) as orden from proyecto_modernizacion.productos t1 ";			
			$Consulta.="inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta.="where t1.cod_producto='".$CmbProducto."' order by orden";
			//echo $Consulta;
			$RespSubProd=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckAgregar'>";
			while($FilaSubProd=mysqli_fetch_array($RespSubProd))
			{
				echo "<tr bgcolor='#FFFFFF'>";
				$CodValor=$FilaSubProd["cod_producto"]."~".$FilaSubProd["cod_subproducto"]."~".$FilaSubProd["nomprod"]."~".$FilaSubProd["nomsubprod"];
				echo "<td align='center'><input type='checkbox' name='CheckAgregar' value='".$CodValor."'></td>";
				echo "<td align='right'>".str_pad($FilaSubProd["cod_subproducto"],2,0,STR_PAD_LEFT)."&nbsp;</td>";
				echo "<td align='left'>".$FilaSubProd["nomsubprod"]."</td>";
				echo "</tr>";
			}
		 ?>
    </table></div>	</td>
    </tr>
</table>
<br>
		 <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>
