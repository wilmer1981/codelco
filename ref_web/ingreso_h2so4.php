<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 16;

	$opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";

	$recargapag       = isset($_REQUEST["recargapag"])?$_REQUEST["recargapag"]:"";
	$verificatabla       = isset($_REQUEST["verificatabla"])?$_REQUEST["verificatabla"]:"";
	$agregafila       = isset($_REQUEST["agregafila"])?$_REQUEST["agregafila"]:"";
	$numero       = isset($_REQUEST["numero"])?$_REQUEST["numero"]:"";
	$parametros   = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$buscar   = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:"";
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$dia1      = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1      = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
    $ano1      = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";


	$fecha=ltrim($fecha);
	$ano1=substr($fecha,0,4);
	$mes1=substr($fecha,5,2);
	$dia1=substr($fecha,8,2);
	$recargapag = 'S';	
	
?>
<html>
<head>
<title>Ingresos H2so4</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
			Valores = "v";
	}
	return Valores;
}
/*********************/
function campos_llenos(f,Nombre)
{
 	var LargoForm = f.elements.length;
	var problemas="";	
	i = 5; //numero de elemento, en el que se ubica el checkbox.	
	if (f.elements[i].name == Nombre)
	{
		while ((i < LargoForm) && (f.elements[i].name == Nombre))
		{
			j = i;
			j++;
			if (f.elements[j].value=='R')
			   {
			    problemas='S';
			   }
			j++;
			if (f.elements[j].value=='R')
			   {
			    problemas='S';
			   }
			j++;
			j++;
			i = i + 4;
		}
	}
	return problemas;
}

function ValidaFilas(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	var problemas="";	
	i = 5; //numero de elemento, en el que se ubica el checkbox.	
	if (f.elements[i].name == Nombre)
	{
		while ((i < LargoForm) && (f.elements[i].name == Nombre))
		{
			j = i;
			if (f.elements[j].checked) //Verifica si el checkbox esta marcado
				Valores = Valores + 1 + '~'; //Marcado
			else 
				Valores = Valores + 0 + '~'; //No marcado
			
			j++;
	      Valores = Valores + f.elements[j].value + '~'; //Select turno
	      j++;
		
			/*j++;*/
	      Valores = Valores + f.elements[j].value + '~'; //Select circuito
          j++;
	
            if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '/';
			else
				Valores = Valores + f.elements[j].value + '/'; //texto volumen
			j++;
			i = i + 4;
		}
	}
	if ((problemas!='S1')&&(problemas!='S2'))
	   {
	    return Valores;
	   }
	else {
	       Valores="";
		   return Valores;
	     }   
}
/*******************/
function Agregar(f,fecha)
{
	var f = document.frm1;

	parametros = ValidaFilas(f,'checkbox');
	if (isNaN(parseInt(f.filas.value)))
		filas = 1;
	else
		filas = parseInt(f.filas.value) + 1;

	linea = "recargapag=S&verificatabla=S&agregafila=S&numero=" + filas + "&parametros=" + parametros + "&buscar=S&mostrar=S";
	linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value + "&dia1=" + f.dia1.value;
	f.action = "ingreso_h2so4.php?" + linea+"&fecha="+fecha;
	f.submit();
}
/*******************/
function Grabar()
{
	var f = document.frm1;
       
		parametros = ValidaFilas(f,'checkbox');
		correcto = campos_llenos(f,'checkbox');
		if (correcto!="")
		   {
		    alert ('Revise los Campos de Ingreso, Hay Valores Erroneos')
		   }
		else {   
				if (parametros!="")
				   {
					parametros = parametros.substring(0,parametros.length - 1);
				
					linea = "proceso=G&parametros=" + parametros;
					linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value + "&dia1=" + f.dia1.value;
					f.action = "proceso_h2so4.php?" + linea;
					f.submit();		
				  }	
		}		  
	
}
/*******************/
function Borrar(f,fecha)
{
	if (f.filas.value == 0)
		return;
		
	if (ValidaSeleccion(f,'checkbox') == "")
	{
		alert("Debe Seleccionar una Casilla");
		return;
	}
		
	filas = parseInt(f.filas.value);
	if (filas != 0)
	{
		parametros = ValidaFilas(f,'checkbox');

		linea = "recargapag=S&verificatabla=S&agregafila=N&numero=" + filas + "&parametros=" + parametros + "&buscar=S&mostrar=S";;
		///linea = linea + "&recup4=" + f.recup4.value + "&recha4=" + f.recha4.value + "&prod4=" + f.prod4.value;
		f.action = "ingreso_h2so4.php?" + linea+"&fecha="+fecha;
		f.submit();
	}
}
/*************************/
function Limpiar()
{
	document.location = "ingreso_h2so4.php";
}
/******************/
function Salir(f,fecha)
{
	f.action = "Ingresadores_traspaso.php?fecha="+fecha;
	f.submit();
}
/**************/
function Buscar(f)
{
	f.action = "proceso_h2so4.php?buscar=S&txtbuscar=" + f.txtbuscar.value;
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal"> 
  <tr>
      
    <td width="762" align="center" valign="middle"> <br>
      <table width="506" height="10" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal">
	   <tr class="ColorTabla01"> 
            <td align="center" >Ingreso de Traspasos de H2SO4</td>
        </tr>
        <tr> 
          <td width="594" align="center"> <table width="494" border="0" align="left" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td width="58" height="20">Fecha </td>
                <td width="421" colspan="3"> <select name="dia1" size="1" id="select17">
                    <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag == "S") && ($i == $dia1))			
					echo '<option selected value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($recargapag != "S")) 
						echo '<option selected value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?>
                  </select> <select name="mes1" size="1" id="select18">
      <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag == "S") && ($i == $mes1))
					echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($recargapag != "S"))
						echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?>
                  </select> <select name="ano1" size="1" id="select19">
      <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag == "S") && ($i == $ano1))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($recargapag != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
		      <!--<td width="63">
			   <td colspan="4"><select name="cmbturno" type="hidden" onChange="JavaScript:BuscarRechazo(this.form)"> 
                    <option value="-1">SELECCIONAR</option>
                    <?php

					/*$Consulta="select distinct turno from ref_web.iniciales order by turno";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_turno==$Fila["turno"])
							echo "<option value='".$Fila["turno"]."' selected>'.$Fila["turno"].'</option>";
						else
							echo "<option value='".$Fila["turno"]."'>'.$Fila["turno"].'</option>";
		     		}*/

				?>
                  </select></td>--> 
              </tr>
            </table>
            <p align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </font></p>
            <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
            <div align="left"></div>
            <div align="left"> <font face="Arial, Helvetica, sans-serif"> </font></div>
            <div align="left"></div>
            <div align="left"><font face="Arial, Helvetica, sans-serif"> 
              <input name="btnagregar2" type="button" value="Agregar Detalle" style="width:100" onClick="JavaScript:Agregar(this.form,'<?php echo $fecha; ?>')">
              <input name="btnborrar2" type="button" value="Eliminar Detalle" style="width:100" onClick="JavaScript:Borrar(this.form,'<?php echo $fecha; ?>')">
              </font></div></td>
        </tr>
        <tr> 
          <td align="center"> <table width="495" border="1" align="left" cellpadding="3" cellspacing="0">
              <tr> 
                <td width="137" align="center">Turno</td>
                <td width="202" align="center">Circuito</td>
                <td width="130" align="center">Volumen</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td colspan="3" align="center"> 
            <?php
	include("../principal/conectar_principal.php");
	
	if ($verificatabla == "S")
	{
		echo '<table width="495" border="1" align="left" cellspacing="0" cellpadding="0">';
    	$j = 0;
		$largo = strlen($parametros);
		while (($j < $numero) and ($largo != 0))
		{
			//Separa los parametros. (cod_defecto - recuperables - rechazos)
			for ($i=0; $i < $largo; $i++)
			{
				if (substr($parametros,$i,1) == "/")
				{				
					$valor = explode("~",substr($parametros,0,$i)); //checkbox - select - text - text.
																 
					$parametros = substr($parametros,$i+1);
					$i = 0;			

					if ($valor[0] == 0) //Si es 1, la fila fue eliminada.
					{
						//Genera las filas que ya fueron ingresadas.
					  	echo '<tr>';
				   		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
						echo '<select name="cmbturno">';
					    echo '<option value="R">SELECCIONAR</option>';
						
						$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
						$respuesta = mysqli_query($link, $consulta);
						while ($fila=mysqli_fetch_array($respuesta))
						{
						if ($fila["turno"] == $valor[1])
							  echo '<option value="'.$fila["turno"].'" selected>'.$fila["turno"].'</option>';
						else
							  echo '<option value="'.$fila["turno"].'">'.$fila["turno"].'</option>';
		     			}
						echo '</select></td>';
						
						//Genera las filas que ya fueron ingresadas.

				   	    echo '<td width="360">';
					//  <input type="checkbox" name="checkbox" value="checkbox">';
						echo '<select name="cmbcircuito">';
					    echo '<option value="R">SELECCIONAR</option>';

						$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 3100 ORDER BY cod_clase";
						$rs = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($rs))
						{
							if ($row["cod_subclase"] == $valor[2])
							    echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
							else
						    	echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
						}
						echo '</select></td>';
			    		echo '<td width="70" align="center"><input type="text" name="volumen"  value="'.$valor[3].'" size="8"></td>';
						echo '</tr>';					
					}				
					else 
						$numero = $numero - 1;
				}			
			}
			$j++;
	  	}
		if ($agregafila == "S")
		{
			echo '<tr>';
    		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
			echo '<select name="cmbturno">';
		    echo '<option value="R">SELECCIONAR</option>';
		
			$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
			$respuesta = mysqli_query($link, $consulta);
			while ($fila1=mysqli_fetch_array($respuesta))
			{
				if ($turno==$fila1["turno"])
				echo "<option value='".$fila1["turno"]."' selected>".$fila1["turno"]."</option>";
			else
				echo "<option value='".$fila1["turno"]."'>".$fila1["turno"]."</option>";
		    }
			echo '</select></td>';
			
			
			//Genra la fila nueva.
		 	echo '<td width="360">';
			//<input type="checkbox" name="checkbox" value="checkbox">';
			echo '<select name="cmbcircuito">';
		    echo '<option value="R">SELECCIONAR</option>';
		
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3100 ORDER BY cod_clase";
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
			    echo '<option value="'.$row1["cod_subclase"].'">'.$row1["nombre_subclase"].'</option>';
			}		
			echo '</select></td>';
         	echo '<td width="70" align="center"><input type="text" name="volumen"  size="8"></td>';
			echo '</tr>';
		}  
		echo '</table><br>';	
	}
	
	include("../principal/cerrar_principal.php");
?>
<?php
	//Campo Oculto.
	//Guarda la cantidas de filas.

	echo '<input type="hidden" name="filas" value="'.$numero.'">';
?>
            <div align="left"></div></tr>
        <tr> 
          <td height="52" align="center"> <div align="left"> 
              <table width="498" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
                <tr> 
                  <td width="489" height="29" align="center"> <div align="center">&nbsp; 
                      &nbsp;<font face="Arial, Helvetica, sans-serif"> </font> 
                      <font face="Arial, Helvetica, sans-serif"> </font> 
                      <input name="btngrabar2" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(' <?php echo $fecha?>')">
                      <input name="btnsalir2" type="button" style="width:60" value="Salir" onClick="JavaScript:Salir(this.form,' <?php echo $fecha?>')">
                    </div></td>
                </tr>
              </table>
            </div>
            <div align="left"></div>
            <br> </td>
        </tr>
      </table>
      <br>
        <br>



        <br>
      <br>
      <br>
  </form>
</body>
</html>
<?php
	if (isset($Mensaje))
	{
		echo"<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	}
?>
