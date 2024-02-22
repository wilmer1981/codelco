<?php
 	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPopUp;
	
	f.action = "pmn_ing_existencias_popup.php?recargapag1=S";
	f.submit();
}
/*****************/
function Chequear(r)
{		
	var vector = r.value.split('~'); //0:año, 1:mes, 2:nodo, 3:prod.

	var linea = "opc=M&recargapag1=S&ano=" + vector[0] + "&mes=" + vector[1] + "&nodo=" + vector[2] + "&prod=" + vector[3]; 
	window.opener.document.frmPrincipal.action = "pmn_ing_existencias.php?proceso=B&" + linea;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
/*****************/
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
  <div style="position:absolute; left: 15px; top: 17px; width: 614px; height: 25px;" id="div0"> 
    <table width="600" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr>
      <td align="center">Datos de Existencias Finales</td>
    </tr>
  </table>
  </div>
  <br>
  <div style="position:absolute; left: 15px; top: 52px; width: 615px; height: 29px;" id="div3"> 
    <table width="600" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td width="277">Fecha</td>
      <td width="317"><select name="mes1" size="1">
          <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes1))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
        </select> <select name="ano1" size="1">
          <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano1))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
        </select> <input name="btnbuscar" type="submit" id="btnbuscar" value="Buscar" onClick="Recarga1()"></td>
    </tr>
  </table>
</div>
  <br>
  <div style="position:absolute; left: 15px; top: 95px; width: 617px; height: 233px;OVERFLOW: auto;" id="div";> 
    <table width="600" height="25" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr class="ColorTabla01" height="25"> 
        <td align="center">Nombre Nodo</td>
        <td align="center">Peso </td>
        <td align="center">Fino Ag</td>
        <td align="center">Fino Au</td>
    </tr>
<?php
	if ($recargapag1 == 'S')
	{
		//Si el mes esta bloqueado, no muestra el radio para modificar.	
	    $consulta = "SELECT CASE WHEN count(ifnull(bloqueado,0)) = 0 THEN 'S' ELSE 'N' END AS valor FROM pmn_web.existencia_nodo ";
    	$consulta.= " WHERE ano = '".$ano1."' AND mes = '".$mes1."' and bloqueado = '1'";   		
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$Activar = $row["valor"];
	
		
		$consulta = "SELECT t1.ano, t1.mes, t1.nodo, t1.prod, t2.descripcion, t3.nombre_subclase, t1.peso, t1.fino_ag, t1.fino_au";
		$consulta.= " FROM pmn_web.existencia_nodo AS t1";	
		$consulta.= " INNER JOIN proyecto_modernizacion.nodos AS t2";
		$consulta.= " ON t1.nodo = t2.cod_nodo AND t2.sistema = 'PMN'";
		$consulta.= " LEFT JOIN proyecto_modernizacion.sub_clase AS t3";
		$consulta.= " ON t3.cod_clase = '6011' AND t3.valor_subclase1 = t1.nodo AND t3.cod_subclase = t1.prod";
		$consulta.= " WHERE ano = '".$ano1."' AND mes = '".$mes1."'";
		$consulta.= " ORDER BY t1.nodo, t1.prod";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td height="25">';
			if ($Activar == "S")
				echo '<input name="radio" type="radio" value="'.$row[ano].'~'.$row[mes].'~'.$row["nodo"].'~'.$row[prod].'" onClick="Chequear(this)">';
			
			echo str_pad($row["nodo"],2,'0',STR_PAD_LEFT).' - '.$row["descripcion"].' '.$row["nombre_subclase"].'</td>';
			echo '<td align="right">'.number_format($row["peso"],3,",","").'</td>';
			echo '<td align="right">'.number_format($row[fino_ag],3,",","").'</td>';
			echo '<td align="right">'.number_format($row[fino_au],3,",","").'</td>';
		}
	}
?>	 
    </tr>
  </table>
  </div>
  <div style="position:absolute; left: 15px; top: 345px; width: 617px; height: 29px;" id="div5"> 
    <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr>
    <td align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>  
</form>
</body>
</html>
