<?php 
	include("../principal/conectar_ref_web.php");
	$CodigoDeSistema = 10;

	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$parametros  = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$Grupo1  = isset($_REQUEST["Grupo1"])?$_REQUEST["Grupo1"]:"";
	$Cubas1  = isset($_REQUEST["Cubas1"])?$_REQUEST["Cubas1"]:"";
	$Grupo2  = isset($_REQUEST["Grupo2"])?$_REQUEST["Grupo2"]:"";
	$Cubas2  = isset($_REQUEST["Cubas2"])?$_REQUEST["Cubas2"]:"";

	if ($Proceso=="G")
    {    
	     
			  $borrar="delete from ref_web.renovacion_hm where fecha='".$parametros."' ";
			  mysqli_query($link, $borrar);
			  //echo $borrar;
			  $Insertar = "INSERT INTO ref_web.renovacion_hm ";
			  $Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
			  $Insertar.= " anodos_a_renovar,inicio_renovacion) ";
			  $Insertar.= " VALUES ('".$parametros."','".$Grupo1."','".$Cubas1."', ";
			  $Insertar.= " '0', '".$Grupo1."')";
			  mysqli_query($link, $Insertar);
			  //echo $Insertar;
			  $Insertar = "INSERT INTO ref_web.renovacion_HM ";
			  $Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
			  $Insertar.= " anodos_a_renovar,inicio_renovacion) ";
			  $Insertar.= " VALUES ('".$parametros."','".$Grupo2."','".$Cubas2."', ";
			  $Insertar.= " '0', ' ')";
			  //echo $Insertar;
			  mysqli_query($link, $Insertar);
	}	

	$Dia = substr($parametros,8,2);
	$Mes = substr($parametros,5,2);
	$Ano = substr($parametros,0,4);
	$Fecha = $Ano."-".$Mes."-".$Dia;

	$consulta_grupo="select * from ref_web.renovacion_HM where fecha= '".$parametros."' ";
	$Respuesta_grupo = mysqli_query($link, $consulta_grupo);
	$i=0;
	while ($Fila_grupo = mysqli_fetch_array($Respuesta_grupo))
	      {
		    $cubas[$i]=$Fila_grupo["cubas_renovacion"];
		    $grupos[$i]=$Fila_grupo["cod_grupo"];
			$i=$i+1;
		  }
	$Cubas1=$cubas[0];
	$Cubas2=$cubas[1];
	
	
	
?>
<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
</head>
<script language="JavaScript">
function Proceso(fecha,opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":
			f.action = "ref_ing_ren_HM.php?Proceso=G&parametros="+fecha;
			f.submit();
			break;
	}
}

function Salir()
	{
	   var f = document.frmPopUp;
	   window.opener.document.frmPrincipal.action = "Renovacion_HM.php?opcion=H";
	   window.opener.document.frmPrincipal.submit();
	   window.close();
		
	}
</script>
<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
  <table width="350" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="187"><strong>Fecha:</strong></td>
      <td width="148"> 
        <?php
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if ((isset($Dia)) && (isset($Mes)) && (isset($Ano)))
	{
		echo "<input type='hidden' name='Dia' value='".$Dia."'>";
		echo "<input type='hidden' name='Mes' value='".$Mes."'>";
		echo "<input type='hidden' name='Ano' value='".$Ano."'>";
		echo str_pad($Dia,2,0,STR_PAD_LEFT)." / ".$Meses[intval($Mes) - 1]." / ".$Ano;
	}
	else
	{		
		echo "<select name='Dia'>\n";
		for ($i=1;$i<=31;$i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("j") == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
      	echo "</select> <select name='Mes'>\n";
		for ($i=1;$i<=12;$i++)
		{
			if (isset($Mes))
			{
				if (intval($Mes) == $i)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if (date("n") == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
      	echo "</select> <select name='Ano'>\n";
		for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
		{
			if (isset($Ano))
			{
				if ($Ano == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("Y") == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
      	echo "</select>\n";
	}
?>
      </td>
    </tr>
    <tr align="center"> 
      <td colspan="2"> <input type="button" name="Grabar" value="Grabar" style="width:70px;" onClick="Proceso('<?php echo $parametros ?>','G')"> 
        <input type="button" name="btnsalir" value="Salir" style="width:70px;" onClick="Salir();"> 
      </td>
    </tr>
  </table>
<br>
  <table width="350" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01"> 
      <td><strong>Grupos</strong></td>
      <td width="219"><strong>Cubas</strong></td>
    </tr>
    <tr align="center"> 
      <td width="112"><strong>Grupo 
        <select name="Grupo1">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($grupos[0] == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas1" type="text" id="Cubas1" value="<?php echo $Cubas1 ?>" size="40"> 
      </td>
    </tr>
    <tr align="center"> 
      <td><strong>Grupo 
        <select name="Grupo2">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($grupos[1] == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select>
        </strong></td>
      <td><input name="Cubas2" type="text" id="Cubas2" value="<?php echo $Cubas2 ?>" size="40"></td>
    </tr>
  </table>
</form>
</body>
</html>
