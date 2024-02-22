<?php
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 4;
	include("../principal/conectar_principal.php");	
?>
<html>
<head>
<title>AGE-Ingreso De Conjuntos</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	var Valores="";
	
	switch(TipoProceso)
	{
		case 'N'://NUEVO CONJUNTO
			window.open("rec_ingreso_conjuntos_proceso.php?Proceso=N","","top=50,left=100,width=500,height=250,scrollbars=yes,resizable=yes");
			break;
		case 'M'://MODIFICAR CONJUNTO
			Valores=RecuperarValoresCheckeado();
			f.action='rec_ingreso_conjuntos_proceso01.php?Proceso=M&Valores='+Valores;
			f.submit();
			break;
		case 'E'://ELIMINAR CONJUNTO
			if(confirm('Esta Seguro de Eliminar el Conjunto'))
			{
				Valores=RecuperarValoresCheckeado();
				f.action='rec_ingreso_conjuntos_proceso01.php?Proceso=E&Valores='+Valores;
				f.submit();
			}	
			break;
		case 'S'://SALIR
			document.location = "../principal/sistemas_usuario.php?CodSistema=8";
			break;
	}
	
}
function CheckearTodo()
{
	var f = document.frmPrincipal;

	try
	{
		f.CheckConjunto[0];
		for (i=1;i<f.CheckConjunto.length;i++)
		{
			if(f.CheckearTodos.checked==true)
				f.CheckConjunto[i].checked=true;
			else
				f.CheckConjunto[i].checked=false;
		}
	}
	catch (e)
	{
	}
}
function RecuperarValoresCheckeado()
{
	var f = document.frmPrincipal;
	var Valores="";
	
	for (i=1;i<f.CheckConjunto.length;i++)
	{
		if (f.CheckConjunto[i].checked==true)
			Valores=Valores + f.CheckConjunto[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function SoloUnElementoCheck()
{
	var f = document.frmPrincipal;
	var CantCheck=0;
	for (i=1;i<f.CheckConjunto.length;i++)
	{
		if (f.CheckConjunto[i].checked==true)
			CantCheck=CantCheck+1;
	}
	if (CantCheck > 1||CantCheck==0)
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
		return(true);
}	
function Recarga(Tipo)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case '1'://BUSCAR POR CONJUNTO
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '2'://BUSCAR POR PROVEEDOR
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '3'://BUSCAR POR PRODUCTO
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '5'://BUSCAR TODOS
			f.action='rec_ingreso_conjuntos.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
	}
	f.submit();		
}
function OrdenadoPor(Tipo,TipoBusqueda)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case "C"://CONJUNTO
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "RP"://RUT PROVEEDOR
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "NP"://NOMBRE PROVEEDOR
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "CF"://CODIGO FAENA
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "NF"://NOMBRE FAENA
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "PRO"://NOMBRE PRODUCTO
			f.action='rec_ingreso_conjuntos.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
	}
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center" valign="top">
	    <table width="750" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="9"><span class="Estilo1">
            Ingreso de Conjuntos</span></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td width="135" align="right">Conjunto:</td>
			<td width="559"><div align="left">
			  <input name="TxtConjunto" type="text" value='<?php echo $TxtConjunto;?>' onKeyDown="TeclaPulsada(false)" size="6" maxlength="4">
			  <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Recarga('1')">
			</div></td> 
            <td align="right">SubProducto:</td>
			<td><div align="left">
			  <SELECT name="CmbSubProducto" style="width:250" onChange="Recarga('3')">
                <option class="NoSelec" value="S">Seleccionar</option>
                <?php
				$Consulta = "SELECT cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
              </SELECT>
			</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td align="right">Proveedor:</td>
			<td><div align="left">
			  <SELECT name="CmbProveedor" style="width:300" onChange="Recarga('2')">
                <option class="NoSelec" value="S">TODOS</option>
                <?php
				$Consulta = "SELECT distinct RUTPRV_A,NOMPRV_A from sipa_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				//$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option SELECTed value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
				}
			?>
              </SELECT>
			</div></td>
            <td align="right">Todos:</td>
			<td><div align="left">&nbsp;
                <input name="CheckTodos" type="checkbox" value="checkbox" onClick="Recarga('5')">
			</div></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td colspan="2">
			<input name="BtnNuevo" type="button" style="width:70px;" value="Nuevo" onClick="Proceso('N')">
			<input name="BtnEliminar" type="button" style="width:70px;" value="Eliminar" onClick="Proceso('E')">
			<input name="BtnSalir" type="button" style="width:70px;" value="Salir" onClick="Proceso('S')">
			</td>
            <td>N&ordm; Conjunto:</td>
            <td align="left"><input name="TxtConjunto2" type="text" value='<?php echo $TxtConjunto2;?>' onKeyDown="TeclaPulsada(false)" size="6" maxlength="4">
            <input name="BtnModificar" type="button" style="width:70px;" value="Modificar" onClick="Proceso('M')"></td>
          </tr>
		  
		 </table>
	    <br>
		<table width="750" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" class="ColorTabla01">
			<td><input type="checkbox" name="CheckearTodos" value="checkbox" onClick="CheckearTodo();"></td>
            <td><a href="JavaScript:OrdenadoPor('C','<?php echo $TipoBusqueda;?>')">Conjunto</a></td>
			<td><a href="JavaScript:OrdenadoPor('RP','<?php echo $TipoBusqueda;?>')">Rut Prv</a></td>
			<td><a href="JavaScript:OrdenadoPor('NP','<?php echo $TipoBusqueda;?>')">Proveedor</a></td>
			<td><a href="JavaScript:OrdenadoPor('CF','<?php echo $TipoBusqueda;?>')">Cod Mina </a></td>
			<td><a href="JavaScript:OrdenadoPor('NF','<?php echo $TipoBusqueda;?>')">Mina</a></td>
			<td><a href="JavaScript:OrdenadoPor('PRO','<?php echo $TipoBusqueda;?>')">SubProducto</a></td>
          </tr>
		  <?php
		  	if($Buscar=='S')
			{
				switch($Ordenar)
				{
					case "C":
						$OrderBy='t1.CONJTO_C';
						break;
					case "RP":
						$OrderBy='t1.RUTPRV_C';
						break;
					case "NP":
						$OrderBy='t2.NOMPRV_A';
						break;
					case "CF":
						$OrderBy='t1.MINPRV_C';
						break;
					case "NF":
						$OrderBy='t4.NOMMIN_A';
						break;
					case "PRO":
						$OrderBy='t3.abreviatura';
						break;
					default:
						$OrderBy='t1.CONJTO_C';
						break;
				}
				$Consulta="SELECT t1.PRDPRV_C,t4.NOMMIN_A,t1.RUTPRV_C,t3.abreviatura,t1.MINPRV_C,t1.CONJTO_C,t2.NOMPRV_A from sipa_web.conjunto t1 inner join sipa_web.proved t2 on t1.RUTPRV_C=T2.RUTPRV_A ";
				$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.PRDPRV_C=t3.cod_subproducto ";
				$Consulta.="inner join sipa_web.minaprv t4 on t1.RUTPRV_C=t4.RUTPRV_A and t1.MINPRV_C =t4.CODMIN_A ";
				switch($TipoBusqueda)
				{
					case "1":
						$Consulta.="where t1.CONJTO_C like '".$TxtConjunto."%' ";
						break;
					case "2":
						$Consulta.="where t1.RUTPRV_C ='".$CmbProveedor."' ";
						break;
					case "3":
						$Consulta.="where t1.PRDPRV_C ='".$CmbSubProducto."' ";
						break;
				}
				$Consulta.=" order by ".$OrderBy;
				//echo $Consulta;
				$RespCamion=mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckConjunto'>";
				while($FilaConjunto=mysqli_fetch_array($RespCamion))
				{
					echo "<tr bgcolor=\"#FFFFFF\">";
					$Datos=$FilaConjunto["CONJTO_C"]."~~".$FilaConjunto["RUTPRV_C"]."~~".$FilaConjunto["MINPRV_C"]."~~".$FilaConjunto["PRDPRV_C"];
					echo "<td align='center'><input type='checkbox' name='CheckConjunto' value='$Datos'></td>";
					echo "<td>".$FilaConjunto["CONJTO_C"]."</td>";
					echo "<td>".$FilaConjunto["RUTPRV_C"]."</td>";
					echo "<td>".substr($FilaConjunto["NOMPRV_A"],0,25)."</td>";
					echo "<td>".$FilaConjunto["MINPRV_C"]."</td>";
					echo "<td>".substr($FilaConjunto["NOMMIN_A"],0,25)."&nbsp;</td>";
					echo "<td>".$FilaConjunto["abreviatura"]."</td>";
					echo "</tr>";
				}
			}			  
		  ?>
        </table>
	    <br></td>
 </tr>
</table>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
