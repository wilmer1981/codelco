<?php
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaIni=date("d");
		$MesIni=date("m");
		$AnoIni=date("Y");
		$DiaFin=date("d");
		$MesFin=date("m");
		$AnoFin=date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni ="0".$DiaIni;
	if ($MesIni < 10)
		$MesIni ="0".$MesIni;
	if (DiaFin  < 10)
		$DiaFin ="0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	$fecha_inicio = $AnoIni."-".$MesIni."-".$DiaIni;
	/*$fecha_termino= $AnoFin."-".$MesFin."-".$DiaFin;*/
	$fecha_termino =date("Y-m-d", mktime(0,0,0,$MesFin,$DiaFin ,$AnoFin));	
	/*$fecha_termino =date("Y-m-d", mktime(0,0,0,$MesFin,$DiaFin + 1,$AnoFin)); sum 1 dia*/
?>
<html>
<head>
<script>
function Proceso(opt)
{
	var f =document.consulta2;

	switch(opt)
	{
		case "C":
			f.action ="consulta_2.php";
			f.submit();
			break;
			
	}	
} 
function recarga()
{
	var f=document.consulta2;
	if (f.subproducto.value == -1)
		f.action = "consulta_2.php";
	else
		f.action = "consulta_2.php?recarga=S";
		f.submit();	
}
function mostrar_guia(cod_bulto,num_bulto,corr_enm,num_envio)
{
	var f=document.consulta2;
	window.open("consulta_guia.php?cod_lote="+cod_bulto+"&num_lote="+num_bulto+"&ie="+corr_enm+"&envio="+num_envio,"","top=110,left=3,width=770,height=340,scrollbars=no,resizable = yes");
}
</script> 
<title>Consulta_2</title>
<link rel="stylesheet" href="../principal/estilos/css_principal.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<form name="consulta2" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>DESPACHO DE PRODUCTOS</strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="120" height="22" align="right">Fecha Inicio :</td>
      <td><select name="DiaIni" style="width:50px">
          <?php
	  			  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
				
		?>
        </select>
		
        <select name="MesIni"  style="width:90px">
			<?php
			for ($i = 1; $i<13;$i++)
			{
				if (isset($MesIni))
				{
					if ($MesIni == $i)
					{
						echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}	
					else
					{
						 echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i -1]))."</option>\n";
					}	 
						
				}
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}	
					else
					{ 
						echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i -1]))."</option>\n";
					}		
				}
			}	
			?>
		</select>
		
        <select name="AnoIni"  style="width:60px">
          <?php
			for ($i = (date("Y") - 1);$i <=(date("Y") +1); $i++)
			   {
					if (isset($AnoIni))
					{
						if ($AnoIni == $i)
							echo "<option selected value ='".$i."'>".$i."</option>\n";
						else echo "<option value ='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i==date("Y"))
							echo "<option selected value ='".$i."'>".$i."</option>\n";
							else echo "<option value ='".$i."'>".$i."</option>\n";
					}
				}
			?>
        </select></td>
      <td width="355">Fecha Termino :
	 	<select name="DiaFin"  style="width:50px">
			<?php
	  	  		for ($i = 1;$i <= 31; $i++)
				{
					if (isset($DiaFin))
					{
						if ($DiaFin == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
							
		?>
		</select>
        <select name="MesFin"  style="width:90px">
			<?php
				for ($i = 1; $i<=12;$i++)
				{
					if (isset($MesFin))
				
				{
					if ($MesFin == $i)
						echo  "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i -1]))."</option>\n";
					else echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i -1]))."</option>\n";
				}
				else
				{
					if ($i==date("n"))
						echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i -1]))."</option>\n";
				}
			}	
			?>
        </select>
        <select name="AnoFin"  style="width:60px">
		    <?php
				for ($i =(date("Y") -1); $i <=(date("Y") +1); $i++)
			
				{
					if (isset($AnoFin))
					{
						if ($AnoFin == $i)
							echo "<option selected value ='".$i."'>".$i."</option>\n";
						else echo "<option value ='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i==date("Y"))
							echo "<option selected value ='".$i."'>".$i."</option>\n";
							else echo "<option value ='".$i."'>".$i."</option>\n";
					}
				}
			?>

        </select></td>
    </tr>
	<tr align="center"> 
    	
      <td height="22" colspan="3"> 

	  	<input name="consulta" type="button" value="Consultar" style="width:70;" onClick="JaveScript:Proceso('C')"> 
        <input type="submit" name="Submit2" value="Imprimir">
        <input type="submit" name="Submit3" value="Salir">
        </font></td>
    </tr>
    <tr> 
      <td height="22"><strong>Producto :</strong></td>
      <td height="22" colspan="2"><strong>
		<?php
			$consulta="select * from proyecto_modernizacion.productos where cod_producto = '18' order by descripcion";
			$respuesta =mysqli_query($link, $consulta);
			if ($fila = mysqli_fetch_array($respuesta))
				echo $fila["descripcion"];
			else 
				echo "&nbsp;";
		?>
	  </td>
    </tr>
    <tr> 
		
      <td width="33" height="24"><strong>Subproducto:</strong></td>
		<td>
		
     		<select name="subproducto"  style="width:200px" onChange="recarga()">
        	<option value='-1' selected>Seleccionar</option>
        	<?php
					
				$consulta="select * from proyecto_modernizacion.subproducto where cod_producto = '18'";
				$respuesta=mysqli_query($link, $consulta);
				while ($fila= mysqli_fetch_array($respuesta))
				{
					$codigo = $fila["cod_subproducto"];
					$descripcion = $fila["descripcion"];
					if ($codigo == $subproducto) 
					{
						echo "<option value = '".$codigo."' selected>".$descripcion."</option>\n";
					}	
						else
					{	
							echo "<option value='".$codigo."'>".$descripcion."</option>\n";
					}		
				}	
			?>
        	</select>
		</td>
    </tr>
 </table>
 <br>
  <table align="center" width="900" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="40"><div align="center">N� Envio</div></td>
      <td width="40"><div align="center">I.E</div></td>
      <td width="50"><div align="center">Lote</div></td>
      <td width="80"><div align="center">Fecha Programada</div></td>
      <td width="80"><div  align="center">Marca</div></td>
      <td width="80"><div align="center">Cliente</div></td>
      <td width="30"><div align="center">Tipo</div></td>
      <td width="80"><div align="center">Fecha Envio</div></td>
	  <td width="30"><div align="center">Paq.</div></td>
      <td width="50"><div align="center">Peso</div></td>
    </tr>
	<?php
		$total_peso = 0;
		$total_paquetes = 0;
		$consulta1="select * from sec_web.embarque_ventana where fecha_envio between '".$fecha_inicio."' and '".$fecha_termino."' and cod_producto = '18' and cod_subproducto = '".$subproducto."' order by num_envio";
		$respuesta1=mysqli_query($link, $consulta1);
		while ($fila1=mysqli_fetch_array($respuesta1))
		{
			echo "<tr>";
			echo "<td align='center'>$fila1["num_envio"]</td>";
			echo "<td align='left'>$fila1["corr_enm"]</td>";
			$lote = $fila1["cod_bulto"]."-".$fila1["num_bulto"];
			echo "<td align='left'><a href=\JAvaScript:mostrar_guias('".$fila1["cod_bulto"]."','".$fila1["num_bulto"]."','",$fila1["corr_enm"]."','".$fila1["num_envio"]."')\">\n";
			echo $fila1["cod_bulto"]."-".$fila1["num_bulto"]."</a></td>\n";
			echo "<td align='center'>$fila1["fecha_programacion"]</td>";
			$total_peso = $total_peso + $fila1["despacho_peso"];
			$total_paquetes = $total_paquetes + $fila1["despacho_paquetes"];
			$consulta2="select cod_marca,descripcion from sec_web.marca_catodos where cod_marca = '".$fila1["cod_marca"]."'";
			$respuesta2=mysqli_query($link, $consulta2);
			while ($fila2=mysqli_fetch_array($respuesta2))
			{
				echo "<td align='left'>$fila2["descripcion"]</td>";
			}
			$consulta3="select cod_cliente,nombre_cliente from sec_web.cliente_venta where cod_cliente = '".$fila1["cod_cliente"]."'";
			$respuesta3=mysqli_query($link, $consulta3);
			while ($fila3=mysqli_fetch_array($respuesta3))
			{
				if ($fila3 != ' ')
				{	
					echo "<td align='left'>$fila3["nombre_cliente"]</td>";
				}
			}	

			$consulta4="select cod_nave, nombre_nave from sec_web.nave where cod_nave = '".$fila1["cod_cliente"]."'";
			$respuesta4=mysqli_query($link, $consulta4);
			while ($fila4=mysqli_fetch_array($respuesta4))
			{
				if ($fila4 != ' ')
				{
					echo "<td align='left'>$fila4["nombre_nave"]</td>";
				}
			}
			if ($fila1[tipo_enm_code]=='C')
			{
				echo "<td align='center'>Codelco</td>";
			}
			else
			{
				echo "<td align='center'>Enami</td>";
			}			
			/*echo "<td align='center'>$fila1[tipo_enm_code]</td>";*/
			echo "<td align='center'>$fila1["fecha_envio"]</td>";
			echo "<td align='right'>".number_format($fila1["despacho_paquetes"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($fila1["despacho_peso"],0,'','.')."</td>";
			echo "</tr>";  
		}	
	
    echo "<tr class='detalle02'>"; 
	echo "<td colspan='8'><strong>Total Despachado</strong></td>";
	echo "<td align='right'>".number_format($total_paquetes,0,'','.')."</td>";
	echo "<td align='right'>".number_format($total_peso,0,'','.')."</td>";
     ?>
    </tr>
  </table>
  <br>
</form>
</body>
</html>
