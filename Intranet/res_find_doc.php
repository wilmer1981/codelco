<?
function DibujaTabla($col,$Nom_Sec, $Nom_Ar, $Nombre, $Titulo, $Gaveta, $Nom_Suministro)
{
	echo "<tr bgcolor='$col'>";

  	echo "<td><font size=1 color='blue' face='verdana'>";
  	echo "&nbsp";
	echo $Nom_Sec;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Ar;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nombre;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Titulo;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Gaveta;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Suministro;
    echo "</font></td>";

    echo "</tr>";
}

function DibujaCabecera()
{
	echo "<table bgcolor='#cccccc' border=0>";
	echo "<tr bgcolor='#225193'>";
    echo "<td width='25%'><FONT color=WHITE><b>Sección</b></FONT></td>";
	echo "<td width='25%'><FONT color=WHITE><b>Area</b></FONT></td>";
	echo "<td width='45%'><FONT color=WHITE><b>Nombre</b></FONT></td>";
    echo "<td width='85%'><FONT color=WHITE><b>Título del Documento</b></FONT></td>";
	echo "<td width='25%'><FONT color=WHITE><b>Gaveta</b></FONT></td>";
    echo "<td width='25%'><FONT color=WHITE><b>Suminitro</b></FONT></td>";
	echo "</tr>";
}
?>

<Script language=JavaScript>
function recarga_pag(forma, opcion_elegida, num_combo)
{
   if ((opcion_elegida==0 && num_combo==0)||(opcion_elegida==1 && num_combo==0 && forma.cmb_pag.value!=-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_pag.value!=-1))
    {
	  var p=forma.cmb_pag.value;
	  forma.action='res_find_doc.php?opcion=1&pag=' + p;
      forma.submit ();
    }
   if ((opcion_elegida==1 && num_combo==0 && forma.cmb_pag==-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_pag.value==-1))
   {
	  var p=forma.cmb_pag.value;
	  forma.action='res_find_doc?opcion=0&pag=' + p;
      forma.submit ();
   }

}
</Script>

<script language = JavaScript>
function enviar()
{
	var frm=document.frm_final;
	var cmb_sec=frm.cmb_sec.value;
	var cmb_ar=frm.cmb_ar.value;
	var cmb_nom=frm.cmb_nom.value;
	var txt_titulo=frm.txt_titulo.value;

	frm.action = 'imprimir_doc.php?cmb_sec=' + cmb_sec + '&cmb_ar=' + cmb_ar + '&cmb_nom=' + cmb_nom + '&txt_titulo=' + txt_titulo;
	frm.submit();
}
</script>

<script language = JavaScript>
function volver()
{
	var frm=document.frm_final;

	frm.action = 'inicio_find_doc.php';
	frm.submit();
}
</script>

<html>
<head>
<title>Resultado Buscador de Documentos, Sistema de Planos y Documentos, ENAMI-Ventanas</title>

<!--/ AQUI VA EL CODIGO QUE SE QUIERE INSERTAR EN EL BODY DE LA PAGINA/-->

<FORM NAME="frm_final" METHOD=POST ACTION="res_find_doc.php">
    <table border="0" align="center" cellspacing="0" cellpadding="0" width="100%">
    <tr>
                  <td>
<!-- INICIO ---------------------------------------------------------------->

<? $conexion = odbc_connect("BD-ING","","","");?>

<?php

echo "<INPUT TYPE=hidden NAME=cmb_sec VALUE='$cmb_sec'>";
echo "<INPUT TYPE=hidden NAME=cmb_ar VALUE='$cmb_ar'>";
echo "<INPUT TYPE=hidden NAME=cmb_nom VALUE='$cmb_nom'>";
echo "<INPUT TYPE=hidden NAME=txt_titulo VALUE='$txt_titulo'>";

if ($opcion!=1)
   	{
	   	$opcion=0;
	}

	$txt_titulo = str_replace("*", "%", "$txt_titulo");

	if($flag != 1)
	{
		/*conteo de datos que daran como resultado*/
		$argumento=0;
		$numero_datos = "SELECT COUNT(T1.[Id Seccion] & T1.[Id Area] & T1.[Id Nombre] & T1.[Id Suministro] & ";
        $numero_datos = $numero_datos."T1.[Titulo] & T1.Gaveta & ";
        $numero_datos = $numero_datos."T2.[Id Seccion] & T2.[Nombre Seccion] & ";
        $numero_datos = $numero_datos."T3.[Id Area] & T3.[Id Area] & T3.[Nombre Area] & ";
        $numero_datos = $numero_datos."T4.[Id Nombre] & T4.[Nombre] & ";
        $numero_datos = $numero_datos."T5.[Id Suministro] & T5.[Nombre Suministro] ) AS total_reg ";
        $numero_datos = $numero_datos."FROM Documentos AS T1, Secciones AS T2, Areas AS T3, ";
        $numero_datos = $numero_datos."Nombres AS T4, [Suministros Documentos] AS T5 ";

        $numero_datos = $numero_datos."WHERE ";

        if($cmb_sec != '-1')
        {
	        $argumento++;
	        $numero_datos = $numero_datos."T1.[Id Seccion]=$cmb_sec ";
        	$numero_datos = $numero_datos."AND T2.[Id Seccion]=$cmb_sec ";
        	$numero_datos = $numero_datos."AND T3.[Id Seccion]=$cmb_sec ";
        }

        if($cmb_ar != '-1')
       	{
	       	if($argumento == 1)
	       		{
		       		$numero_datos = $numero_datos."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$numero_datos = $numero_datos."T1.[Id Area]=$cmb_ar ";
        	$numero_datos = $numero_datos."AND T3.[Id Area]=$cmb_ar ";
       	}

       	if($cmb_nom != '-1')
       	{
	       	if($argumento == 1)
	       		{
		       		$numero_datos = $numero_datos."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$numero_datos = $numero_datos."T1.[Id Nombre]=$cmb_nom ";
        	$numero_datos = $numero_datos."AND T4.[Id Nombre]=$cmb_nom ";
       	}


       	if($txt_titulo != '')
       	{
	       	if($argumento == 1)
	       		{
		       		$numero_datos = $numero_datos."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$numero_datos = $numero_datos."T1.[Titulo] Like '$txt_titulo' ";
       	}

       	if($cmb_sec != '-1' || $cmb_ar != '-1' || $cmb_nom != '-1' || $txt_titulo != '')
        {
	        $numero_datos = $numero_datos."AND ";
        }
      	$numero_datos = $numero_datos."T1.[Id Seccion]=T2.[Id Seccion] ";
       	$numero_datos = $numero_datos."AND T1.[Id Seccion]=T3.[Id Seccion] ";
       	$numero_datos = $numero_datos."AND T1.[Id Area]=T3.[Id Area] ";
       	$numero_datos = $numero_datos."AND T1.[Id Nombre]=T4.[Id Nombre] ";
       	$numero_datos = $numero_datos."AND T1.[Id Suministro]=T5.[Id Suministro] ";
       	$numero_datos = $numero_datos."AND T2.[Id Seccion]=T3.[Id Seccion] ";

       	$Resp = odbc_exec($conexion,$numero_datos);

		/*fin del conteo*/
		$flag = 0;
	}
if (odbc_result($Resp,'total_reg') != 0)
{
	if ( $opcion==0 || $opcion==1)
	{
	/*este codigo es para el combo de las paginas*/
    	$i=1;
		$sw = 0;
		$RegistrosPorFila = 10;/*son el maximo de registros por pagina*/
		$cont = $RegistrosPorFila;
		$NumeroPagina = intval((odbc_result($Resp,'total_reg') / $RegistrosPorFila));
		$RegistrosExtras = 0;
		if ((odbc_result($Resp,'total_reg')%$RegistrosPorFila) > 0)
		{
			$RegistrosExtras = odbc_result($Resp,'total_reg')%$RegistrosPorFila;
			$NumeroPagina = $NumeroPagina + 1;
		}
		$desde = $RegistrosPorFila * ($pag - 1);
		$hasta = $RegistrosPorFila * ($pag);

		echo "<table bgcolor='#225193' border=0>";
		echo "<tr bgcolor='#fff4cf'>";
		echo "<td>";

			if(odbc_result($Resp,'total_reg') == 1)
			{
 				echo "<font size='2' color='BLUE' face='verdana'>Se ha encontrado ".odbc_result($Resp,'total_reg') ." registro.</FONT>";
 			}
 			else
 			{
 				echo "<font size='2' color='BLUE' face='verdana'>Se han encontrado ".odbc_result($Resp,'total_reg') ." registros.</font>";
 			}
 			echo "</td>";

			echo "<td>";
			echo "<select name=cmb_pag OnChange=JavaScript:recarga_pag(this.form,".$opcion.",0) >\n";

	 		$i=1;

        	while ($i <= $NumeroPagina)
           	{
				if ($cmb_pag == $i)
				{
       				echo "<option value='$i' selected><font size='2'>Página ".$i."</font></option>\n";
				}
				else
				{
					echo "<option value='$i'><font size='2'>Página ".$i."</font></option>\n";
				}
				$i++;
           	}
        	$i=1;
        	echo "</select>\n";
        	echo "</td>";

        	echo "<td>";
        	if($cmb_pag != -1)
			{
 				if(odbc_result($Resp,'total_reg') == 1)
				{
 					echo "<font size='2' color='BLUE' face='verdana'> De ".($NumeroPagina)." página</font>";
 				}
 				else
 				{
	 				echo "<font size='2' color='BLUE' face='verdana'> de ".($NumeroPagina)." páginas</font>";
 				}
 			}
 			echo "</td>";
 			echo "</tr>";
			echo "</table>";
		/*acaba el codigo para los combos*/
	}
echo "<input type=BUTTON value='Consulta en Excel' onclick='javascript:enviar();'>";
echo " <input type=BUTTON value='Volver' onclick='javascript:volver();'>";

if($opcion == 1)
	{
/*INICIO DE LA CONSULTA*/
		$argumento=0;
		$Consulta = "SELECT DISTINCTROW T1.[Id Seccion], T1.[Id Area], T1.[Id Nombre], T1.[Id Suministro], ";
        $Consulta = $Consulta."T1.[Titulo], T1.Gaveta, ";
        $Consulta = $Consulta."T2.[Id Seccion], T2.[Nombre Seccion], ";
        $Consulta = $Consulta."T3.[Id Area], T3.[Id Area], T3.[Nombre Area], ";
        $Consulta = $Consulta."T4.[Id Nombre], T4.[Nombre], ";
        $Consulta = $Consulta."T5.[Id Suministro], T5.[Nombre Suministro] ";
        $Consulta = $Consulta."FROM Documentos AS T1, Secciones AS T2, Areas AS T3, ";
        $Consulta = $Consulta."Nombres AS T4, [Suministros Documentos] AS T5 ";
        $Consulta = $Consulta."WHERE ";

        if($cmb_sec != '-1')
        {
	        $argumento++;
	        $Consulta = $Consulta."T1.[Id Seccion]=$cmb_sec ";
        	$Consulta = $Consulta."AND T2.[Id Seccion]=$cmb_sec ";
        	$Consulta = $Consulta."AND T3.[Id Seccion]=$cmb_sec ";
        }

        if($cmb_ar != '-1')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Id Area]=$cmb_ar ";
        	$Consulta = $Consulta."AND T3.[Id Area]=$cmb_ar ";
       	}

       	if($cmb_nom != '-1')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Id Nombre]=$cmb_nom ";
        	$Consulta = $Consulta."AND T4.[Id Nombre]=$cmb_nom ";
       	}


       	if($txt_titulo != '')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Titulo] Like '$txt_titulo' ";
       	}

       	if($cmb_sec != '-1' || $cmb_ar != '-1' || $cmb_nom != '-1' || $txt_titulo != '')
        {
	        $Consulta = $Consulta."AND ";
        }
      	$Consulta = $Consulta."T1.[Id Seccion]=T2.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Seccion]=T3.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Area]=T3.[Id Area] ";
       	$Consulta = $Consulta."AND T1.[Id Nombre]=T4.[Id Nombre] ";
       	$Consulta = $Consulta."AND T1.[Id Suministro]=T5.[Id Suministro] ";
       	$Consulta = $Consulta."AND T2.[Id Seccion]=T3.[Id Seccion] ";
       	$Consulta = $Consulta."ORDER BY [Nombre Seccion], [Nombre Area], [Nombre], [Titulo] ASC ";

       	$Respuesta = odbc_exec($conexion,$Consulta);
/*FIN DE LA CONSULTA*/
        echo "<font size='3'><B><I><BR>El resultado según los criterios de busqueda </font>";
       	echo "<font size='3'>es el siguiente:</I></B><BR></font>";

       	DibujaCabecera();
		$j = 1;
		$reg_mostrados = 0;
		$color = "#ffe89f";
        while (odbc_fetch_row($Respuesta))
        {
            /*tienen que ser hasta un maximo de reg, que va a ser el registro n°: RegistroPorFila * pag */
	        /* y desde el registro n°: RegistroPorFila * (pag - 1)*/
	        if($j > $desde && $j <= $hasta)
	        {
		       	DibujaTabla($color, odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Nombre"), odbc_result($Respuesta,"Titulo"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro") );
				$reg_mostrados++;
				if($color == "#ffe89f")
		    	{
			    	$color = "#fff4cf";
		    	}
		    	else
		    	{
			    	$color = "#ffe89f";
		    	}
			}
			$j++;
			if ($reg_mostrados > $cont)
			{
				break;
			}
        }

        if ($i == $NumeroPagina && odbc_result($Resp,'total_reg') > $RegistrosPorFila)
        {
			if ($RegistrosExtras > 0)
			{
				$sw = 1;
				echo "</table><br>";
				DibujaCabecera();
				$j = 1;
				$color = "#ffe89f";
				while (odbc_fetch_row($Respuesta) && $j<=$RegistrosExtras && $i <= $NumeroPagina)
		        {
		    		DibujaTabla($color, odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Titulo"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro"));
					$j++;
					if($color == "#ffe89f")
		    		{
			    		$color = "#fff4cf";
		    		}
		    		else
		    		{
			    		$color = "#ffe89f";
		    		}
		        }
			}
		    echo "</table><br>";
		}
		$i++;
		if ($sw == 0)
		{
		    echo "</table><br>";
		}

		echo "<input type=BUTTON value='Consulta en Excel' onclick='javascript:enviar();'>";

		if ( $j==1)
	 	{
			echo "<FONT SIZE=2><B><BR>No hay datos que coincidan con los criterios solicitados</B></FONT>";
		}

	}

}

else
{
	echo "<FONT SIZE=2><B><BR>No hay datos que coincidan con los criterios solicitados</B></FONT>";
}

?>

<?odbc_close_all();?>

<!-- FINAL  -->
                  </td>
                </tr>

</table>
</form>

<!--/------------------------------------------------------------------/-->
