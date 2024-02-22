<?
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 3;
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">


<script language="JavaScript">
function Recarga()
{ 
	var f = formulario;
    f.action = "raf_lista_general.php";
	f.submit();
}

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
		f.action = "raf_con_hornadas_abiertas.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 2)
	{
		f.action = "raf_con_cargas_beneficio.php";
		f.submit();		
	}

	if(f.cmbconsulta.value == 3)
	{
		f.action = "raf_con_mov_diario.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "raf_con_mov_raf.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "raf_con_control_carga.php";
		f.submit();
	}
	if(f.cmbconsulta.value == 6)
	{
		f.action = "raf_con_mov_diario_leyes.php";
		f.submit();
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
		f.action = "raf_con_hornadas_abiertas_xls.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 2)
	{
		f.action = "raf_con_cargas_beneficio_xls.php";
		f.submit();					
	}

	if(f.cmbconsulta.value == 3)
	{
		f.action = "raf_con_mov_diario_xls.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "raf_con_mov_raf_xls.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "raf_con_control_carga_xls.php";
		f.submit();
	}
	
	if(f.cmbconsulta.value == 6)
	{
		f.action = "raf_con_mov_diario_leyes_xls.php";
		f.submit();
	}	
}
function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=9";
	f.submit();
}

</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="formulario" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <? include("../principal/conectar_principal.php") ?> 
  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	<td height="313" align="center" valign="top">
		<p><b>C O N S U L T A S&nbsp;&nbsp;R A F</b></p>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo 
              de Consulta</td>
            <td width="240">
              <?
		  echo'<select name="cmbconsulta" style="width:230" onChange="Recarga();">';
          	echo'<option value="-1" selected>Seleccionar</option>';
          	echo'<option value="0">-----------------</option>';

            if($cmbconsulta == "1")
          		echo'<option value="1" selected>Hornadas Del Mes</option>';
            else 	
          		echo'<option value="1">Hornadas Del Mes</option>';
            /*if($cmbconsulta == "2")
				echo'<option value="2" selected>Cargas En Beneficio(Diario)</option>';
			else
				echo'<option value="2">Cargas En Beneficio(Diario)</option>';*/

            if($cmbconsulta == "3")
          		echo'<option value="3" selected>Hornadas Beneficio (diario)</option>';
			else
          		echo'<option value="3">Hornadas Beneficio (diario)</option>';

            if($cmbconsulta == "4")
          		echo'<option value="4" selected>Movimientos En Raf(Por Producto)</option>';
			else
          		echo'<option value="4">Movimientos En Raf(Por Producto)</option>';

            if($cmbconsulta == "5")
          		echo'<option value="5" selected>Control Carga Nave De Horno</option>';
			else
          		echo'<option value="5">Control Carga Nave De Horno</option>';
			if($cmbconsulta == "6")
          		echo'<option value="6" selected>Movimientos En Raf (Leyes)</option>';
			else
          		echo'<option value="6">Movimientos En Raf (Leyes)</option>';

				
          echo'</select>';
		  ?>
            </td>
		  <td width="48">&nbsp;</td>	
          <tr> 
            <td width="120"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha 
              Consulta </td>
			<td>
				<?
				if($cmbconsulta != 1)
				{ 				
				?>
				<select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
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
			  <?
			  }
			  ?>	
			  <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select> </td>
			<td>
						<?
			if($cmbconsulta == 2)
			{
			/*	echo "<img src='../principal/imagenes/left-flecha.gif' width='11' height='11'>&nbsp;Turno";*/						
			}
			?>&nbsp;
			</td>
			<td width="273">
            <?
			if($cmbconsulta == 2)
			{/*
				echo'<select name="cmbturno">';
					echo'<option value="-1" selected>Seleccionar</option>';
					echo'<option value="A">Turno A</option>';
					echo'<option value="B">Turno B</option>';
					echo'<option value="C">Turno C</option>';
				echo'</select>';*/
			}
		     ?>
            </td>
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
      </table>     </td>
  </tr>
</table>
 <? include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
