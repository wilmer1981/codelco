<?php
	include("../principal/conectar_principal.php");
	$CodigoDeSistema=2;
	$CodigoDePantalla=50;

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function TeclaPulsada(salto) 
{ 
	var f = document.frmPrincipal;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action = "sea_ing_stock_programado.php";
			f.submit();
			break;
		case "G":
			var Valores="";
			var Largo=0;
			var Dia="";
			var valorDia=0;
			for (i=1;i<f.elements.length;i++)
			{				
				if (f.elements[i].name.substring(0,3)=="Txt")
				{
					if (f.elements[i].value!="")
						ValorDia=f.elements[i].value;
					else
						ValorDia=0;
					Largo = f.elements[i].name.length;
					Dia = f.elements[i].name.substring(Largo-2);
					Valores = Valores + Dia + "//" + ValorDia + "~~";
				}
			}
			f.action = "sea_ing_stock_programado01.php?Proceso=G&Valores=" + Valores;
			f.submit();
			break;
		case "E":
			var msg=confirm("�Seguro que desea Eliminar los datos de este Mes?");
			if (msg==true)
			{
				f.action = "sea_ing_stock_programado01.php?Proceso=E";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?Nivel=1&CodSistema=2&CodPantalla=45";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "X":
			f.action = "sea_ing_stock_programado_xls.php";
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      	<td width="762" height="312" align="center" valign="top"><table width="682" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="77" height="23">Fecha </td>
            <td width="194">
              <SELECT name="Mes" size="1" id="SELECT7">
                <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (isset($Mes))
				{
					if ($i == $Mes)
						echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]."</option>";					
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
				}
				else
				{
					if ($i == date("n"))
						echo "<option SELECTed value ='".$i."'>".$Meses[$i-1]."</option>";					
					else	
						echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
				}					
			}		  
		?>
              </SELECT>
              <SELECT name="Ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($Ano))
				{
					if ($i == $Ano)
						echo "<option SELECTed value ='".$i."'>".$i."</option>";					
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option SELECTed value ='".$i."'>".$i."</option>";					
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}				
			}
		?>
              </SELECT>
            </td>
            <td width="390"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70px " onClick="Proceso('C')" value="Consultar">
            <input name="BtnGrabar" type="button" id="BtnGrabar" onClick="Proceso('G')" value="Grabar" style="width:70px ">
            <input name="BtnEliminar" type="button" id="BtnGrabar3" onClick="Proceso('E')" value="Eliminar" style="width:70px ">
            <input name="BtnSalir" type="button" id="BtnSalir" onClick="Proceso('S')" value="Salir" style="width:70px "></td>
          </tr>
        </table>
		
		  <br>
		  <table width="650" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td><table width="176" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle" align="left">
                <tr align="center" class="ColorTabla01">
                  <td width="48">Dia</td>
                  <td width="187">Stock programado </td>
                </tr>
                <?php	
					$Fecha01 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
					$FinMes = date("d", mktime(0,0,0,substr($Fecha01,5,2),intval(substr($Fecha01,8,2))-1,substr($Fecha01,0,4)));
					$TotalStockMes=0;
					for ($i=1;$i<=$FinMes;$i++)
					{	
						$Consulta = "SELECT * from sea_web.stock_programado ";
						$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$i."'";
						$Resp = mysqli_query($link, $Consulta);
						$PesoDia=0;
						if ($Fila = mysqli_fetch_array($Resp))
						{
							$PesoDia=$Fila["peso"];
						}
						if ($PesoDia==0)
							$PesoDia=0;		
						echo "<tr align='center'>\n";  
						echo "<td>".str_pad($i,2,"0",STR_PAD_LEFT)."</td>\n";
						if (($i+1)>$FinMes)
							echo "<td><input size='12' maxlength='10' name='TxtStockDia".str_pad($i,2,"0",STR_PAD_LEFT)."' type='text' value='".$PesoDia."' ></td>\n";
						else
							echo "<td><input size='12' maxlength='10' name='TxtStockDia".str_pad($i,2,"0",STR_PAD_LEFT)."' type='text' value='".$PesoDia."' onKeyDown=\"TeclaPulsada('TxtStockDia".str_pad($i+1,2,"0",STR_PAD_LEFT)."')\"></td>\n";
						echo "</tr>\n";
						$TotalStockMes = $TotalStockMes + $PesoDia;
						if (($i+1)==11 || ($i+1)==21)
						{
							echo "</table>\n";
							echo "<table width='176' border='1' cellpadding='2' cellspacing='0' class='TablaDetalle' align='left'>\n";
							echo "<tr align='center' class='ColorTabla01'>\n";
							echo "<td width='48'>Dia</td>\n";
							echo "<td width='187'>Stock programado </td>\n";
							echo "</tr>\n";
						}
					}
				?>
                <tr>
                  <td><strong>TOTAL</strong></td>
                  <td align="center"><?php echo number_format($TotalStockMes,0,",","."); ?></td>
                </tr>
              </table></td>
            </tr>
          </table>
	    <br>
	    <table width="359" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="390" height="23" align="center"><input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px " onClick="Proceso('I')" value="Imprimir">
                <input name="BtnExcel" type="button" id="BtnGrabar4" onClick="Proceso('X')" value="Excel" style="width:70px ">                </td>
          </tr>
        </table></td>
	</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
