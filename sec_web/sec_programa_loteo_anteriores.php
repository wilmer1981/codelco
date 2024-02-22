<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 1;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}

	switch($Proceso)
	{
		case "N":
			$Consulta = "select max(num_prog_loteo) as CodMayor from sec_web.programa_loteo";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{
				$NroPrg=$Fila["CodMayor"]+1;	
			}
			else
			{
				$NroPrg=1;	
			}
			break;
		case "M":
			$Datos=explode('~~',$Valores);
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$CodDescripcion=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($CodDescripcion);$j++)
					{
						if (substr($CodDescripcion,$j,2)=="~~")
						{
							$Codigo=substr($CodDescripcion,0,$j);
							$Descripcion=substr($CodDescripcion,$j+2);
						}	
					}
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
function RecuperarValores()
{
	var Frm=document.FrmProceso;
	var Valores=new String();
	
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked==true)
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 

function Imprimir()
{
	var Frm=document.FrmProceso;

	Valores=RecuperarValores();	
	if (Valores!="")
	{
		window.open("sec_imprimir_programa_loteo.php?Valores="+Valores,""," fullscreen=no,left=50,top=10,width=660,height=480,scrollbars=yes,resizable = no");
	}	
}
function Recarga()
{
	var Frm=document.FrmProceso;
	
	Frm.action="sec_programa_loteo_anteriores.php";
	Frm.submit();
	
}

function Salir()
{
	window.close();
}
</script>
<title>Programas de Loteos Anteriores</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="407" height="225" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td>
		<div style="position:absolute; left: 15px; top: 10px; width: 395px; height: 127px; OVERFLOW: auto;" id="div2"> 
          <table width="375" border="1"  cellpadding="1" cellspacing="0" class='tablainterior'>
          <tr>
		  <td colspan="3">&nbsp;Fecha:&nbsp;&nbsp;
		<?php
			echo"<select name='CmbMes' onchange='Recarga()'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbAno' onchange='Recarga()'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			echo "</select>&nbsp;&nbsp;";
		?>		  
		  </td>
		  </tr>
		  </table>
		  </div>
			<div style="position:absolute; left: 15px; top: 38px; width: 395px; height: 127px; OVERFLOW: auto;" id="div2"> 		  
          <table width="375" border="0"  cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="ColorTabla01">
		  <tr> 
            <td>&nbsp;</td>
			<td width="100" align="center">N� Prog.Loteo</td>
            <td width="140" align="center">Fecha Creacion</td>
			<td width="100" align="center">Fecha Maxima</td>
          </tr>
        </table>
		</div>
		<div style="position:absolute; left: 15px; top: 55px; width: 391px; height: 134px; OVERFLOW: auto;" id="div2"> 
          <?php
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-01";
			$FechaTermino=$CmbAno."-".$CmbMes."-31";
			echo "<table width='375' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$Consulta="select * from sec_web.programa_loteo where substring(fecha_hora,1,10) >= '".$FechaInicio."' and substring(fecha_hora,1,10) <= '".$FechaTermino."' order by num_prog_loteo desc";
			$Respuesta=mysqli_query($link, $Consulta);
        //  echo $Consulta;
			echo "<input type='hidden' name='OptSeleccionar'>";
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='20' align='center'><input type='radio' name='OptSeleccionar' value='".$Fila["num_prog_loteo"]."'></td>";
				echo "<td width='100' align='right'>".$Fila["num_prog_loteo"]."</td>";
				echo "<td width='140' align='center'>".$Fila["fecha_hora"]."</td>";
				echo "<td width='100' align='center'>".$Fila["fecha_maxima"]."</td>";
				echo "</tr>";
			}
			echo "</table>";	
		?>
        </div>
        <br>
		<div style="position:absolute; left: 15px; top: 195px; width: 395px; height: 30px; OVERFLOW: auto;" id="div2">
        <table width="375" border="1" cellpadding="1" cellspacing="0" class='tablainterior'>
          <tr> 
              <td align="center">
			  <input type="button" name="BtnImprimrir" value="Ver" style="width:60" onClick="Imprimir();">
			  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </td>
          </tr>
        </table>
		</div>
	</td>
  </tr>
  </table>
  </form>
</body>
</html>
