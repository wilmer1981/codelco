<?php
//include("../principal/conectar_sec_web.php");
$CodigoDeSistema = 3;
$CodigoDePantalla = 8;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">
function Ejecutar_Web()
{ 
var f = formulario;
	
	if(f.cmbconsulta.value == -1)
	{
		alert("Debe Escoger Tipo de Consulta");
		f.cmbconsulta.focus();
		return
	}
	
	if(f.cmbconsulta.value == 1)
	{
		f.action = "sec_con_inf_pesaje_prod.php";
		f.submit();
	}
	
	if(f.cmbconsulta.value == 2)
	{
			//f.action = "sec_con_inf_pesaje_prod.php";
			//f.submit();
	}		
}

function Ejecutar_Excel()
{ 
var f = formulario;
	
	if(f.cmbconsulta.value == -1)
	{
		alert("Debe Escoger Tipo de Consulta");
		f.cmbconsulta.focus();
		return
	}
	
	if(f.cmbconsulta.value == 1)
	{
		f.action = "ram_xls_mov_del_dia.php";
		f.submit();
	}
	
	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_xls_turno_lugar.php";
			f.submit();
		}
		else
		{
			alert("Debe Escoger Turno");
			f.cmbturno.focus();
			return
		}
	}		

	if(f.cmbconsulta.value == 3)
	{
		f.action = "ram_xls_inf_diario.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_xls_mov_acum.php";
		f.submit();
	}


}

function Recarga()
{
var f=formulario;
    f.action ="sec_generador_consultas.php?Proceso=R";
	f.submit();
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=3";
	f.submit();
}

</script>
</head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	  <td height="312" align="center" valign="top" > 
        <table width="300" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td width="90"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo Listado</td>
            <td width="199">
			<?php
			echo'<SELECT name="cmbconsulta" style="width:200" onChange="Recarga();">';
          	echo'<option value="-1" SELECTed>Seleccionar</option>';

            if($cmbconsulta == "1")
          		echo'<option value="1" SELECTed>Informe de Pesaje de Producci�n</option>';
            else 	
          		echo'<option value="1">Informe de Pesaje de Producci�n</option>';

            if($cmbconsulta == "2")
          		echo'<option value="2" SELECTed></option>';
            else 	
          		echo'<option value="2"></option>';
          	
			echo'</SELECT>';
		    ?>	
			</td>        
		  </tr>
		</table>
		<br>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr class="TablaInterior"> 
            <td width="78">Fecha Inicio:</td>
            <td width="263"><SELECT name="DiaIni" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
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
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
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
              </SELECT></td>
            <td width="99">Fecha Termino:</td>
            <td width="241"><SELECT name="DiaFin" style="width:50px;">
                <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
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
              </SELECT> <SELECT name="MesFin" style="width:90px;">
                <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT> <SELECT name="AnoFin" style="width:60px;">
                <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
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
              </SELECT></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table> 
        <p>&nbsp;</p>
        <p><br>
        </p>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
		  <tr> 
            <td><div align="center">
                <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">
                <input name="ejecutar_excel" type="button"  value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
     </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
