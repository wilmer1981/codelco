<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 54;

	if(isset($_REQUEST["recargapag"])) {
		$recargapag = $_REQUEST["recargapag"];
	}else{
		$recargapag =  "";
	}
	if(isset($_REQUEST["cmbproducto"])) {
		$cmbproducto = $_REQUEST["cmbproducto"];
	}else{
		$cmbproducto =  "";
	}
	if(isset($_REQUEST["activar"])) {
		$activar = $_REQUEST["activar"];
	}else{
		$activar =  "";
	}

	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = date("Y-m-d");
	}

	/*
	if (!isset($TxtFechaFin))
		$TxtFechaFin = date("Y-m-d");
	*/
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga(f)
{
	vector = f.cmbproducto.value.split("-");
	chequeado = "S";

	f.action = "sea_eli_restos_trasp_sec_e01.php?recargapag=S&cmbproducto=" + f.cmbproducto.value + "&activar=" + chequeado;		
	f.submit();	
}

/**************/
function Elimina()
{
	var f=document.frm1;
	var Valores="";
	//alert (f.cmbproducto.value);
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="OptSelec" && f.elements[i].checked==true)
		{	
			Valores=Valores+f.elements[i+1].value+"//";
		}	
	}
	if (Valores!='')
	{
		Valores=Valores.substring(0,(Valores.length-2));
		if(confirm('Devuelve Movimiento de Preparacion Embarque'))
		{			
			//alert (Valores);
			f.action="sea_ing_restos_trasp_sec01.php?Proceso=EM&Valores="+Valores;
			f.submit();	
		}	
	}
	else
		alert('Debe Seleccionar Grupo a Modificar');	
		
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30"
}
</script>
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 		 <tr><td align="center" bgcolor="#FFFFFF">RESTOS A PREPARACION PARA EMBARQUE </td></tr>

    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="118">Tipo de Producto</td>
            <td><SELECT name="cmbproducto" style="width:220px" onChange="Recarga(this.form)">
              <option value="0-0">SELECCIONAR</option>
              <?php					
				$consulta = "SELECT DISTINCT * FROM proyecto_modernizacion.subproducto ";
				$consulta.= " WHERE cod_producto IN(19) and cod_subproducto in('1','2','3','4','8') ORDER BY cod_producto,cod_subproducto";
				$rs3 = mysqli_query($link, $consulta);
				while ($row3 = mysqli_fetch_array($rs3))
				{
					$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];

					if ($prod == $cmbproducto)
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" SELECTed>'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
					else 
						echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["cod_subproducto"].'-'.$row3["descripcion"].'</option>';
				}
				?>
            </SELECT></td>
          </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		<?php
			$CmbAno=date("Y");
			$Prod = explode("-", $cmbproducto); 
		
			switch(isset($Prod[1]))
			{
				case "1":
					$SubProd=21;//PRODUCTO EMBARQUE HVL
					break;
				case "2":
					$SubProd=22;//PRODUCTO EMBARQUE TTE
					break;
				case "3":
					$SubProd=23;//PRODUCTO EMBARQUE SUR ANDES
					break;
				case "4":
					$SubProd=25;//PRODUCTO EMBARQUE VENTANAS
					break;
				case "8":
					$SubProd=26;//PRODUCTO EMBARQUE HM VENTANAS
					break;
			}
			?>
          <tr> 
          <tr align="center"> 
            <td colspan="2">
              <input name="BtnElimina" type="button" onClick="JavaScritp:Elimina(this.form)" value="Elimina" style="width:70px">
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="400" border="1" cellspacing="0" cellpadding="3">
          <tr align="center" class="ColorTabla01">
            <td width="30">Selec</td>
            <td width="54">Grupo</td>
			<td width="54">Hornada</td>
            <td width="90">Fecha</td>
            <td width="70">Unidades</td>
            <td width="80">Peso(Kg)</td>
          </tr>
        
		<?php

			//if($recargapag=='S')
			//{
				$FechaConsulta = substr($TxtFechaFin,0,8)."31";
				$FechaInicio = substr($TxtFechaFin,0,8)."01";
				$TotalUnidad = 0;
				$TotalPeso = 0;			
				if ($recargapag == "S")
				{
					$consulta = "SELECT hornada,grupo,fecha_movimiento,unidades,peso FROM sea_web.restos_a_sec";
					$consulta.= " WHERE tipo_movimiento = 1 AND cod_producto = '".$Prod[0]."'";
					$consulta.= " AND cod_subproducto = '".$Prod[1]."'";
					$consulta.= " order by  hornada";
					$resp = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($resp))
					{
						$TotalUnidad = $TotalUnidad + $row["unidades"];
						$TotalPeso = $TotalPeso + $row["peso"];
						$datos = $row["hornada"]."~".$Prod[1]."~".$row["grupo"]."~".$row["fecha_movimiento"]."~".$row["unidades"]."~".$row["peso"];
						echo '<tr>';
						echo '<td><input type="checkbox" name="OptSelec" value="datos" ><input type="hidden" value='.$datos.'></td>';
						echo '<td align="center">'.$row["grupo"].'</td>';
						echo '<td align="center">'.$row["hornada"].'</td>';
						echo '<td align="center">'.$row["fecha_movimiento"].'</td>';
						echo '<td align="right"><font color="blue">'.$row["unidades"].'</font></td>';
						echo '<td align="right"><font color="blue">'.$row["peso"].'</font></td>';					
						echo '</tr>';
					}	
				}								
			//}
		
		?>
		<tr>
		<td colspan="4">TOTAL</td>
		<td align="right"><font color="blue"><?php echo $TotalUnidad; ?></font></td>
		<td align="right"><font color="blue"><?php echo $TotalPeso; ?></font></td>
		</tr>
		</table>
		<br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
              <input name="BtnElimina" type="button" onClick="JavaScritp:Elimina(this.form)" value="Elimina" style="width:70px">
              <input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
