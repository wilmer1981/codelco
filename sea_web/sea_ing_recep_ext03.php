<?php 
include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}

if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = date("Y");
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = date("m");
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = date("d");
}


?>
<html>
<head>
<title>Busqueda de Gu&iacute;a</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_guia()
{
var f = frmPoPup;

    f.action="sea_ing_recep_ext03.php?Proceso=B";
	f.submit();
}

function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var valor = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i].value;
		}
	}
	return valor;
}
//*********************//
function Enviar(f)
{
	var valor = ValidaSeleccion(f,'radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
		fecha = f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
		
		valores = "&guia_aux=" + valor + "&fecha=" + fecha;
		window.opener.document.formulario.action = "sea_ing_recep_ext.php?mostrar=S"+valores;
		window.opener.document.formulario.submit();
		window.close();
    }
	else
	{
		alert('No hay Guia Seleccionada');
		return
    }
}
//*********************//
function ModGuia()
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var GUIA = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name =="radio") && (f.elements[i].checked == true))
		{
			var GUIA = f.elements[i].value;
			var FOLIO = f.elements[i+1].value;
			var CORREC = f.elements[i+2].value;
		}
	}
	if (GUIA=="")
	{
		alert("No hay ninguna guia seleccionada");
		return;
	}
	else
	{
		var mensaje = confirm("¿Seguro que desea Modificar esta Guia?");
		if (mensaje == true)
		{
			var URL = "sea_modif_guia.php?Ano=" + f.ano.value + "&Mes=" + f.mes.value + "&Dia=" + f.dia.value + "&GUIA=" + GUIA + "&FOLIO=" + FOLIO + "&CORREC=" + CORREC;
			window.open(URL, "","menubar=no resizable=no Top=100 Left=240 width=450 height=250 scrollbars=no");
		}
		else
		{
			return;
		}
	}
}
</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    <table cellpadding="3" cellspacing="0" width="500" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Gu&iacute;a</div></td>
      </tr>
      <tr> 
        <td width="41" height="32">Fecha</td>
        <td width="220"> <font color="#000000" size="2">
          <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
            <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
          </SELECT>
          </font> <font color="#000000" size="2"> 
          <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
          </SELECT>
          <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
          </SELECT>
          </font><font color="#000000" size="2">&nbsp; </font><font color="#333333" size="2">&nbsp; 
          </font><font color="#000000" size="2">&nbsp; </font></td>
        <td width="219"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_guia();"></td>
      </tr>
    </table>
    <?php
if($Proceso == 'B')
{
    echo'<table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
	  <td height="20" colspan="2">&nbsp;</td>
      <td height="20" colspan="2"><div align="center">Gu&iacute;a</div></td>
      <td width="23%"><div align="center">Patente</div></td>
      <td width="20%"><div align="center">Lote</div></td>
      <td width="23%"><div align="center">Recargo</div></td>
      <td width="15%"><div align="center">Peso</div></td>
    </tr>
  </table>
  </div>
  <div align="left" style="position:absolute; overflow:auto; top: 90px; height: 380px;"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">';  
 
	//include("../principal/conectar_rec_web.php");
    $fecha = $ano.'-'.$mes.'-'.$dia;
	$consulta = "SELECT * FROM SIPA_WEB.recepciones where FECHA = '".$fecha."' AND peso_neto <> '0' and COD_PRODUCTO='1' AND ";
    $consulta.= "(COD_SUBPRODUCTO = '16' or COD_SUBPRODUCTO = '17' or COD_SUBPRODUCTO = '18') and tipo<>'A' ORDER BY GUIA_DESPACHO";
	//echo $consulta;
	$rs = mysqli_query($link, $consulta);

		while ($row = mysqli_fetch_array($rs))
		{
			 if(isset($row["FOLIOS_A"])){
				$folio = $row["FOLIOS_A"];
			 }else{
				$folio = "";
			 }
			echo '<tr><td height="20" colspan="2" align="center">';
			echo '<input type="radio" name="radio" value="'.$row["guia_despacho"].'"></td>';
			echo '<input type="hidden" name="folio" value="'.$folio.'"></td>';
			echo '<input type="hidden" name="correc" value="'.$row["correlativo"].'"></td>';
			echo '<td width="19%">'.$row["guia_despacho"].'</td>';
			echo '<td width="23%"><div align="center">'.$row["patente"].'</div></td>';
			echo '<td width="20%"><div align="center">'.$row["lote"].'</div></td>';
			echo '<td width="23%"><div align="center">'.$row["recargo"].'</div></td>';
			echo '<td><div align="center">'.$row["peso_neto"].'</div></td></tr>';
			
		}

		
}

?>  
    </table>
  </div>
  
  <div align="left" style="position:absolute; top: 475px; left: 24px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
            <input name="btnamodificar" type="button" style="width:70" value="Modificar" onClick="JavaScript:ModGuia()">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
