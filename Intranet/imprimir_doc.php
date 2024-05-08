<?
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<?
function DibujaTabla($Nom_Sec, $Nom_Ar, $Nombre, $Titulo, $Gaveta, $Nom_Suministro)
{
	echo "<tr>";

	echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
  	echo "&nbsp";
	echo $Nom_Sec;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Ar;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nombre;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Titulo;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Gaveta;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Suministro;
    echo "</font></td>";

    echo "</tr>";
}

function DibujaCabecera()
{
	echo "<table bgcolor='#FFE89F' border=1>";
	echo "<tr bgcolor='yellow'>";
    echo "<td width='50%'><b>Sección</b></td>";
	echo "<td width='50%'><b>Area</b></td>";
	echo "<td width='100%'><b>Nombre</b></td>";
    echo "<td width='100%'><b>Título del Documento</b></td>";
	echo "<td width='25%'><b>Gaveta</b></td>";
    echo "<td width='25%'><b>Suminitro</b></td>";
	echo "</tr>";
}
?>

<? $conexion = odbc_connect("BD-ING","","","");?>

<?php

echo "<INPUT TYPE=hidden NAME=cmb_sec VALUE='$cmb_sec'>";
echo "<INPUT TYPE=hidden NAME=cmb_ar VALUE='$cmb_ar'>";
echo "<INPUT TYPE=hidden NAME=cmb_nom VALUE='$cmb_nom'>";
echo "<INPUT TYPE=hidden NAME=txt_titulo VALUE='$txt_titulo'>";

$txt_titulo = str_replace("*", "%", "$txt_titulo");

		/*inicio de la consulta*/
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

       	DibujaCabecera();
		$j = 1;
		$reg_mostrados = 0;

        while (odbc_fetch_row($Respuesta))
        {
	        DibujaTabla(odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Nombre"), odbc_result($Respuesta,"Titulo"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro") );
			$j++;
        }

		echo "</table><br>";

?>

<?odbc_close_all();?>
