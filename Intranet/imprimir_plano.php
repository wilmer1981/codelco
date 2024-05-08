<?
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<?
function DibujaTabla($Nom_Sec, $Nom_Ar, $Tit_Plano, $N_Enami, $N_Proyecto, $Gaveta, $Nom_Suministro, $Cad, $Revisado, $Observacion)
{
  	echo "<td width='100'><font size=1 color='blue' face='verdana'>";
  	echo "&nbsp";
	echo $Nom_Sec;
    echo "</font></td>";

    echo "<td width='10'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Ar;
    echo "</font></td>";

    echo "<td width='50%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Tit_Plano;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $N_Enami;
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
	echo "&nbsp";
	echo $N_Proyecto;
    echo "</font></td>";

	echo "<td><font size=1 color='blue' face='verdana'>";
	echo "&nbsp";
	echo $Gaveta;
    echo "</font></td>";

    /*
    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Suministro;
    echo "</font></td>";
    */

    $var_c = '';
    if($Cad == '0')
   	{
   		$var_c = 'No';
   	}
    else if($Cad == '1')
   	{
   		$var_c = 'Si';
   	}

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
    echo "$var_c";
    echo "</font></td>";

	$var_r = '';
    if($Revisado == '0')
   	{
   		$var_r = 'No';
   	}
    else if($Revisado == '1')
   	{
   		$var_r = 'Si';
   	}

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
    echo "$var_r";
    echo "</font></td>";

    echo "<td><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Observacion;
    echo "</font></td>";

    echo "</tr>";
}

function DibujaCabecera()
{
	echo "<table bgcolor='#FFE89F' border=1>";
	echo "<tr bgcolor='#FFFF99'>";
    echo "<td width='25%'><b>Sección</b></td>";
	echo "<td width='25%'><b>Area</b></td>";
    echo "<td width='50%'><b>Título del Plano</b></td>";
	echo "<td width='100%'><b>Nº Enami</b></td>";
    echo "<td width='25%'><b>Nº Proyecto</b></td>";
	echo "<td><b>Gaveta</b></td>";
	/*
    echo "<td width='25%'><b>Suministro</b></td>";
    */
	echo "<td width='25%'><b>Cad</b></td>";
    echo "<td width='25%'><b>Rev</b></td>";
    echo "<td width='25%'><b>Obs</b></td>";
   	echo "</tr>";
}
?>

<? $conexion = odbc_connect("BD-ING","","","")?>

<?php
echo "<INPUT TYPE=hidden NAME=cmb_sec VALUE='$cmb_sec'>";
echo "<INPUT TYPE=hidden NAME=cmb_ar VALUE='$cmb_ar'>";
/*
echo "<INPUT TYPE=hidden NAME=cmb_sumi VALUE='$cmb_sumi'>";
*/
echo "<INPUT TYPE=hidden NAME=txt_titulo VALUE='$txt_titulo'>";
echo "<INPUT TYPE=hidden NAME=txt_n_enm VALUE='$txt_n_enm'>";
echo "<INPUT TYPE=hidden NAME=txt_n_proy VALUE='$txt_n_proy'>";
echo "<INPUT TYPE=hidden NAME=cad VALUE='$cad'>";

$txt_titulo = str_replace("*", "%", "$txt_titulo");
$txt_n_enm = str_replace("*", "%", "$txt_n_enm");
$txt_n_proy = str_replace("*", "%", "$txt_n_proy");


		/*inicio de la consulta*/
		$argumento = 0;
		$Consulta = "SELECT DISTINCTROW T1.[Id Seccion], T1.[Id Area], T1.[Titulo Plano], ";
	    $Consulta = $Consulta."T1.[Nº Enami], T1.[Nº Proyecto], T1.Gaveta, ";
        $Consulta = $Consulta."T1.[Id Suministro], T1.Cad, T1.Revisado, T1.Observacion, ";
        $Consulta = $Consulta."T2.[Id Seccion], T2.[Nombre Seccion], ";
        $Consulta = $Consulta."T3.[Id Area], T3.[Id Area], T3.[Nombre Area], ";
        $Consulta = $Consulta."T4.[Id Suministro], T4.[Nombre Suministro] ";
        $Consulta = $Consulta."FROM Planos AS T1, Secciones AS T2, Areas AS T3, Suministros AS T4 ";

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

       	/*
       	if($cmb_sumi != '-1')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Id Suministro]=$cmb_sumi ";
        	$Consulta = $Consulta."AND T4.[Id Suministro]=$cmb_sumi ";
       	}
       	*/

       	if($cad == 'TRUE' || $cad == 'FALSE')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.Cad=$cad ";
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

	       	$Consulta = $Consulta."T1.[Titulo Plano] Like '$txt_titulo' ";
       	}

       	if($txt_n_enm != '')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Nº Enami] Like '$txt_n_enm' ";
       	}

       	if($txt_n_proy != '')
       	{
	       	if($argumento == 1)
	       		{
		       		$Consulta = $Consulta."AND ";
	       		}
	       	else
	       		{
		       		$argumento++;
       			}

	       	$Consulta = $Consulta."T1.[Nº Proyecto] Like '$txt_n_proy' ";
       	}

      	if($cmb_sec != '-1' || $cmb_ar != '-1' /*|| $cmb_sumi != '-1' */|| $txt_titulo != '' || $txt_n_enm != ''  || $txt_n_proy != '')
        {
	        $Consulta = $Consulta."AND ";
        }
       	$Consulta = $Consulta."T1.[Id Seccion]=T2.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Seccion]=T3.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Area]=T3.[Id Area] ";
       	$Consulta = $Consulta."AND T2.[Id Seccion]=T3.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Seccion]=T2.[Id Seccion] ";
       	$Consulta = $Consulta."AND T1.[Id Suministro]=T4.[Id Suministro] ";
       	$Consulta = $Consulta."ORDER BY [Nombre Seccion], [Nombre Area], [Titulo Plano] ASC ";

       	$Respuesta = odbc_exec($conexion,$Consulta);
		/*fin de la consulta*/

        DibujaCabecera();
		$j = 1;
        while (odbc_fetch_row($Respuesta) )
        {
		   	DibujaTabla(odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Titulo Plano"), odbc_result($Respuesta,"Nº Enami"), odbc_result($Respuesta,"Nº Proyecto"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro"), odbc_result($Respuesta,"Cad"), odbc_result($Respuesta,"Revisado"), odbc_result($Respuesta,"Observacion") );
			$j++;
		}
	    echo "</table><br>";
?>

<?odbc_close_all();?>
