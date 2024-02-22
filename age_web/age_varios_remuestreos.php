<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 96;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	
?>
<html>
<head>
<title>AGE-Consulta Comparacion Muestra Paralela</title>
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
	Frm.action="age_varios_remuestreos.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=30";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "age_varios_remuestreos.php?Mostrar=<?php echo $Mostrar; ?>";
			f.submit(); 
			break;
		case "C":
			f.action = "age_varios_remuestreos.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			f.action = "age_varios_remuestreos_excel.php?Mostrar=S";
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
			f.action = "age_varios_remuestreos01.php?Proceso=G";
			f.submit(); 
			break;
	}	
}
function Remuestreo(Lote)
{
	//alert(Lote);
	window.open("age_varios_remuestreos_proceso.php?LoteOri="+Lote,"","top=50,left=10,width=600,height=300,scrollbars=yes,resizable = yes");					
}
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=1000,height=450,scrollbars=yes,resizable = yes");					
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
          <td height="23" colspan="4" class="ColorTabla02"><strong>VARIOS REMUESTREOS  </strong></td>
        </tr>
        <tr>
          <td width="52" height="23" align="right">Periodo:</td>
          <td>
            <select name="Mes">
              <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
            </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>            </td>
          <td width="55" align="left">&nbsp;</td>
          <td width="354">&nbsp;</td>
        </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td width="261" height="23"><select name="SubProducto" style="width:250" onChange="Proceso('R')">
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
          <td height="30" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnExcel" type="hidden" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">              
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
	
<?php		
		
if ($Mostrar=="S")
{
	if ($Ano<2006)
	{
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nombre_prv ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join sipa_web.proveedores t3 on t1.rut_proveedor=t3.rut_prv";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
	$Consulta.= " and t1.remuestreo ='N' and estado_lote=6";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr class=\"ColorTabla02\">\n";
		echo "<td colspan=\"3\">Producto:&nbsp;".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)."-".strtoupper($Fila["descripcion"])."</td>\n";
		echo "<td colspan=\"3\">Proveedor:&nbsp;".str_pad($Fila["rut_proveedor"],10,'0',STR_PAD_LEFT)."-".strtoupper($Fila["nombre_prv"])."</td>\n";
		echo "</tr>\n";
		echo "<tr class=\"ColorTabla01\">";
		echo "<td >&nbsp;</td>";
		echo "<td>Lote Original</td>";
		echo "<td>1 Remuestreo</td>";
		echo "<td>2 Remuestreo</td>";
		echo "<td>3 Remuestreo</td>";
		echo "<td>4 Remuestreo</td>";
		echo "</tr>";
		$Consulta = "select lote ";
		$Consulta.= " from age_web.lotes t1 where t1.lote between '".$LoteIni."' and '".$LoteFin."' and t1.cod_producto='1' and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " and t1.remuestreo ='N' and estado_lote=6";
		$Consulta.= " order by lote";
		//echo $Consulta;
		$RespLote = mysqli_query($link, $Consulta);
		$Cont=0;
		while ($FilaLote = mysqli_fetch_array($RespLote))
		{				
			echo "<tr>";
			echo "<td><input type='radio' name='OptLote' value='$FilaLote[lote]' onclick=Remuestreo('".$FilaLote[lote]."')></td>";
			echo "<td>".$FilaLote[lote]."</td>";
			BuscarRemuestreos($FilaLote[lote],&$LoteEnc);
			echo "<td>".$LoteEnc."&nbsp;</td>";
			BuscarRemuestreos($LoteEnc,&$LoteEnc);
			echo "<td>".$LoteEnc."&nbsp;</td>";
			BuscarRemuestreos($LoteEnc,&$LoteEnc);
			echo "<td>".$LoteEnc."&nbsp;</td>";
			BuscarRemuestreos($LoteEnc,&$LoteEnc);
			echo "<td>".$LoteEnc."&nbsp;</td>";
			echo "</tr>";
		}	
	}
}//FIN MOSTRAR = S
function BuscarRemuestreos($LoteBusc,$LoteEnc)
{
	$LoteEnc='';
	if($LoteBusc!='')
	{
		$Consulta = "select lote from age_web.lotes t1 where t1.num_lote_remuestreo='".$LoteBusc."'";
		//$Consulta.= " and t1.remuestreo ='N' and t1.estado_lote=6";
		//echo $Consulta;
		$RespLoteB = mysqli_query($link, $Consulta);
		if($FilaLoteB=mysqli_fetch_array($RespLoteB))
		{
			$LoteEnc=$FilaLoteB[lote];
		}
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
