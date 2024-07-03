<?php 
  	include("../principal/conectar_sea_web.php");
	
	$CodigoDeSistema = 2;	
	$CodigoDePantalla = 56;

	if(isset($_REQUEST["RecargaPag"])) {
		$RecargaPag = $_REQUEST["RecargaPag"];
	}else{
		$RecargaPag =  "";
	}
	if(isset($_REQUEST["EjecAuto"])) {
		$EjecAuto = $_REQUEST["EjecAuto"];
	}else{
		$EjecAuto =  "";
	}

	if(isset($_REQUEST["Dia"])) {
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia =  date("d");
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes =  date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano =  date("Y");
	}

	if(isset($_REQUEST["Dia2"])) {
		$Dia2 = $_REQUEST["Dia2"];
	}else{
		$Dia2 =  date("d");
	}
	if(isset($_REQUEST["Mes2"])) {
		$Mes2 = $_REQUEST["Mes2"];
	}else{
		$Mes2 =  date("m");
	}
	if(isset($_REQUEST["Ano2"])) {
		$Ano2 = $_REQUEST["Ano2"];
	}else{
		$Ano2 =  date("Y");
	}
	


	if($EjecAuto=='S')
		//exec("stockanodos.exe");
		
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

function Recarga()
{	
	document.formulario.action="sea_util_con_movtos.php?RecargaPag=S";
	document.formulario.submit();
}

/**************/
function Imprimir()
{	
	window.print();
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30"
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="formulario" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> 
        <table width="753" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="118">Fecha Inicio</td>
            <td><SELECT name="Dia" style="width:50px">
                <?php 
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  ?>
              </SELECT> <SELECT name="Mes" style="width:100px">
                <?php
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == date("n"))
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
					?>
              </SELECT> <SELECT name="Ano" style="width:60px">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("Y"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}				
			?>
              </SELECT> </td>
			  	<td width="118">Hasta</td>
            	<td><SELECT name="Dia2" style="width:50px">
                <?php 
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia2))
						{
							if ($i == $Dia2)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  ?>
              	</SELECT> <SELECT name="Mes2" style="width:100px">
                <?php
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes2))
						{
							if ($i == $Mes2)
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == date("n"))
								echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
					?>
              	</SELECT> <SELECT name="Ano2" style="width:60px">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano2))
						{
							if ($i == $Ano2)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == date("Y"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}				
			?>
              </SELECT> </td>
  		</tr>
		</table>
        <table width="753" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr align="center"> 
		  	<td>&nbsp;</td>
            <td><input name="BtnCansultar" type="button" value="Consultar" onClick="Recarga()" style="width:70px"></td>
		  	<td>&nbsp;</td>
			<td><input name="btnimprimir2" type="button" style="width:70;" value="Imprimir" onClick="Imprimir()"></td> 
		  	<td>&nbsp;</td>
            <td><input name="btnsalir2" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
		  	<td>&nbsp;</td>
          </tr>
        </table>
        <br>
		
        <table width="780" border="1" cellspacing="0" cellpadding="3">
          <tr class="ColorTabla01"> 
			<td  align="center">Tipo Mov</td>		
            <td  align="center">Producto</td>
            <td  align="center">Subprod.</td>
            <td  align="center">Hornada</td>			
            <td  align="center">Recarga</td>			
            <td  align="center">Fecha Mov</td>			
            <td  align="center">Fecha Ben</td>			
            <td  align="center">Unidades</td>			
            <td  align="center">Peso</td>			
            <td  align="center">Grupo</td>			
            <td  align="center">Lado</td>			
          </tr>
<?php
		if ($RecargaPag=="S")
		{
			if (strlen($Mes)==1)
				$Mes = "0".$Mes;
			if (strlen($Mes2)==1)
				$Mes2 = "0".$Mes2;
			if (strlen($Dia)==1)
				$Dia = "0".$Dia;
			if (strlen($Dia2)==1)
				$Dia2 = "0".$Dia2;
				
			$fecha = $Ano."-".$Mes."-".$Dia;
			$fecha2 = $Ano2."-".$Mes2."-".$Dia2;
			$consulta = "SELECT tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,fecha_benef,";
			$consulta.="unidades,peso,campo2,campo1 FROM sea_web.movimientos ";
			$consulta.= " WHERE fecha_movimiento between '".$fecha."' and '".$fecha2."' ";
			$consulta.=" order by fecha_movimiento,cod_producto,cod_subproducto,hornada,tipo_movimiento";
			//echo $consulta;
			$resp=mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($resp))
			{
				$tipos = "Otros";
				if ($row["tipo_movimiento"]==1)
					$tipos = "Recepcion";
				if ($row["tipo_movimiento"]==2)
					$tipos = "Beneficio";
				if ($row["tipo_movimiento"]==3)
					$tipos = "Produccion";
				if ($row["tipo_movimiento"]==4)
					$tipos="Trasp. a Raf";
				if ($row["tipo_movimiento"]==10)
					$tipos = "A Embarque";
				echo '<tr>';
						echo '<td align="right">'.$tipos.'</td>';
						echo '<td align="center">'.$row["cod_producto"].'</td>';						
						echo '<td align="center">'.$row["cod_subproducto"].'</td>';
						echo '<td align="right">'.$row["hornada"].'</td>';
						echo '<td align="right">'.$row["numero_recarga"].'</td>';
						echo '<td align="right">'.$row["fecha_movimiento"].'</td>';			
						echo '<td align="right">'.$row["fecha_benef"].'</td>';
						echo '<td align="right">'.$row["unidades"].'</td>';
						echo '<td align="right">'.$row["peso"].'</td>';	
						echo '<td align="right">'.$row["campo2"].'</td>';
						echo '<td align="right">'.$row["campo1"].'</td>';
					echo '</tr>';
			}								
		}
?>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
