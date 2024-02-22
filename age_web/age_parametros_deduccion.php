<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 97;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	if(!isset($CmbRecepcion))
		$CmbRecepcion='S';
	if(!isset($SubProducto))
		$SubProducto='S';
	if(!isset($Proveedor))
		$Proveedor='S';
	/*$Consulta="select t1.cod_subproducto,t1.rut_proveedor,t2.nombre_prv from age_web.relaciones t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor=t2.rut_prv ";
	//$Consulta.=" where t1.rut_proveedor='11944959-6'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))	
	{
		$CodProd=str_pad($Fila["cod_subproducto"],3,'0',STR_PAD_LEFT);
		$RutPrv=str_pad(str_replace('-','',$Fila["rut_proveedor"]),9,'0',STR_PAD_LEFT);
		$NomPrv=$Fila["nombre_prv"];
		$Consulta="select * from imp_web.proveedores where tipo_producto='".$CodProd."' and rut_proveedor='".$RutPrv."'";
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);
		if(!$Fila2=mysqli_fetch_array($Resp2))
		{
			$Insertar="insert into imp_web.proveedores(tipo_producto,rut_proveedor,nombre) values(";
			$Insertar.="'".$CodProd."','".$RutPrv."','".$NomPrv."')";
			echo $Insertar."<br>";
			//mysqli_query($link, $Insertar);
		}
	}*/
	
?>
<html>
<head>
<title>Parametros Deduccion Metalurgica</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 400 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="age_parametros_deduccion.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=60";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "age_parametros_deduccion.php?Mostrar=<?php echo $Mostrar; ?>";
			f.submit(); 
			break;
		case "C":
			f.action = "age_parametros_deduccion.php?Mostrar=S";
			f.submit(); 
			break;
		case "N":
			window.open("age_parametros_deduccion_proceso2.php","","top=50,left=10,width=850,height=350,scrollbars=yes,resizable = yes");					
			break;			
		case "E":
			f.action = "age_parametros_deduccion_excel.php?Mostrar=S";
			f.submit(); 
			break;
		case "EL":
			var Parametros="";
			for (i=1;i<f.elements.length;i++)
			{
				alert (f.elements[i].name.substring(0,13));
				alert (f.elements[i].value);
				if (f.elements[i].name.substring(0,13)=="ChkRemuestreo" && f.elements[i].checked==true)
				{
					Parametros = Parametros + f.elements[i].value + "~~" + f.elements[i+1].value + "//";
				}
			}
			if (Parametros=="")
			{
				alert("No hay nada seleccionado!!");
				return;
			}
			f.Valores.value=Parametros;
			f.action = "age_parametros_deduccion01.php?Proceso=EL";
			f.submit(); 
			break;

		case "G":
			var Parametros="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name.substring(0,13)=="ChkRemuestreo" && f.elements[i].checked==true)
				{
					Parametros = Parametros + f.elements[i].value + "~~" + f.elements[i+1].value + "//";
				}
			}
			//alert(Parametros);
			if (Parametros=="")
			{
				alert("No hay nada seleccionado!!");
				return;
			}
			f.Valores.value=Parametros;
			f.action = "age_parametros_deduccion01.php?Proceso=G";
			f.submit(); 
			break;
	}	
}
function Deduccion(Datos)
{
	//alert(Datos);
	window.open("age_parametros_deduccion_proceso.php?Datos="+Datos,"","top=50,left=10,width=850,height=350,scrollbars=yes,resizable = yes");					
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=850,height=450,scrollbars=yes,resizable = yes");					
}

function Habilita(obj,lote,rec)
{
	var f = document.frmPrincipal;
	if (obj.checked==true)
	{
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".disabled=false;");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".style.background='#FFFFFF';");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".focus();");
	}
	else
	{
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".value='';");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".disabled=true;");
		eval("f.TxtRemuestreo_"+ lote +"_"+rec+".style.background='#CCCCCC';");
	}	
}
</script></head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="800" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>PARAMETROS DEDUCCION METALURGICA </strong></td>
        </tr>
        <tr>
          <td width="60" height="23" align="right">Asignacion:</td>
          <td><select name="CmbRecepcion" style="width:200" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" >
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
				$TxtFechaIni = date("Y-m-d", mktime(0,0,0,date('m')-1,1,date('Y')));
				$TxtFechaFin = date("Y-m-d", mktime(0,0,0,date('m')+1,1,date('Y')));
				$Consulta = "select distinct cod_recepcion from age_web.lotes where fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				$Consulta.= " and cod_recepcion <>'' order by cod_recepcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbRecepcion == $Fila["cod_recepcion"])
						echo "<option selected value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_recepcion"]."'>".strtoupper($Fila["cod_recepcion"])."</option>";
				}
			  ?>
          </select><?php //echo $Consulta;?></td>
          <td width="58" align="left">&nbsp;</td>
          <td width="345">&nbsp;</td>
        </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="254" height="23"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
          </select></td>
          <td colspan="2" align="left">Proveedor:
            <select name="Proveedor" style="width:260" onChange="Proceso('R')">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' ";  					
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				}
			?>
            </select>
            <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">            </td>
          </tr>
        <tr align="center">
            <td height="30" colspan="4">
			   <input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;"> 
              <input name="btnnuevo" type="button" value="Nuevo" onClick="Proceso('N')" style="width:70px;">
              <input name="BtnExcel" type="hidden" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
<tr class="ColorTabla01">
<td align="center">&nbsp;</td>
<td align="center">Asignacion</td>
<td align="center">Sub-Producto</td>
<td align="center">Proveed</td>
<td align="center">Ley</td>
<td align="center">Valor1</td>
<td align="center">Valor2</td>
<td align="center">Valor3</td>
<td align="center">Valor4</td>
</tr>	
<?php
$Mostrar="S";		
if ($Mostrar=="S")
{
	$Consulta="select t1.cod_recepcion,t1.cod_subproducto,t1.rut_proveedor,t1.cod_leyes,t2.descripcion, nombre_prv,valor1,valor2,valor3,valor4 from age_web.deduc_metalurgicas t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="left join sipa_web.proveedores t3 on t1.rut_proveedor=t3.rut_prv where t1.cod_recepcion<>'' ";
	if($CmbRecepcion!='S')
		$Consulta.="and t1.cod_recepcion='$CmbRecepcion'";
	if($SubProducto!='S')	
		$Consulta.=" and t1.cod_producto='1' and t1.cod_subproducto='$SubProducto' ";
	if($Proveedor!='S')	
		$Consulta.=" and t1.rut_proveedor='$Proveedor' ";

	$RespDeduc=mysqli_query($link, $Consulta);
	//echo $Consulta;	
	while($FilaDeduc=mysqli_fetch_array($RespDeduc))
	{
		echo "<tr>";
		$Valores=str_replace(' ','*',$FilaDeduc[cod_recepcion])."~".$FilaDeduc["cod_subproducto"]."~".$FilaDeduc["rut_proveedor"]."~".$FilaDeduc["cod_leyes"];
		echo "<td><input type='radio' name='OptDeduc' onClick=Deduccion('".$Valores."')></td>";
		echo "<td>".$FilaDeduc[cod_recepcion]."</td>";
		echo "<td>".$FilaDeduc["descripcion"]."</td>";
		if($FilaDeduc["rut_proveedor"]!="T")
		//if($FilaDeduc[cod_recepcion]!='MAQ ENM')  16-02-2010
			echo "<td>".$FilaDeduc["nombre_prv"]."</td>";
		else	
			echo "<td>TODOS</td>";
		switch($FilaDeduc["cod_leyes"])
		{
			case "02":
				$Ley='Cu';
				break;
			case "04":
				$Ley='Ag';
				break;
			case "05":
				$Ley='Au';
				break;
		}	
		echo "<td>".$Ley."</td>";
		echo "<td>".$FilaDeduc[valor1]."</td>";
		echo "<td>".$FilaDeduc[valor2]."</td>";
		echo "<td>".$FilaDeduc[valor3]."</td>";
		echo "<td>".$FilaDeduc[valor4]."</td>";	
		echo "<tr>";
	}
}
?>
</table>	  
</td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
