<body class=menuwhite>

<?
function DibujaTabla($col,$Nom_Sec, $Nom_Ar, $Tit_Plano, $N_Enami, $N_Proyecto, $Gaveta, $Nom_Suministro, $Cad, $Revisado, $Observacion)
{
	echo "<tr bgcolor='$col'>";

  	echo "<td width='15%'><font size=1 color='blue' face='verdana'>";
  	echo "&nbsp";
	echo $Nom_Sec;
    echo "</font></td>";

    echo "<td width='15%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Ar;
    echo "</font></td>";

    echo "<td width='75%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Tit_Plano;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $N_Enami;
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $N_Proyecto;
    echo "</font></td>";

	echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
	echo "&nbsp";
	echo $Gaveta;
    echo "</font></td>";
/*
    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Nom_Suministro;
    echo "</font></td>";
*/
/*    $var_c = '';
    if($Cad == '0')
   	{
   		$var_c = 'No';
   	}
    else if($Cad == '1')
   	{
   		$var_c = 'Si';
   	}

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
    echo "$var_c";
    echo "</font></td>";
*/
	if ($Cad == 'No' || $Cad == 'Yes')
	{
		echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
		echo "&nbsp";
		echo "</td>";
	}
	else
	{
    	$var1="//10.56.11.4/autocad";
        $var1=$var1.$Cad;
        $var1=$var1.".dwg";
		echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    	echo "&nbsp";
    	echo "<a href=".$var1." target='_blank'>".$Cad."</a>";
    	echo "</font></td>";
    }

	$var_r = '';
    if($Revisado == '0')
   	{
   		$var_r = 'No';
   	}
    else if($Revisado == '1')
   	{
   		$var_r = 'Si';
   	}

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
    echo "$var_r";
    echo "</font></td>";

    echo "<td width='100%'><font size=1 color='blue' face='verdana'>";
    echo "&nbsp";
	echo $Observacion;
    echo "</font></td>";

    echo "</tr>";
}

function DibujaCabecera()
{
	echo "<table bgcolor='#cccccc' border=0>";
	echo "<tr bgcolor='225193'>";
    echo "<td width='15%'><FONT size=1 color=WHITE face='verdana'><b>Sección</b></FONT></td>";
	echo "<td width='15%'><FONT size=1 color=WHITE face='verdana'><b>Area</b></FONT></td>";
    echo "<td width='50%'><FONT size=1 color=WHITE face='verdana'><b>Título del Plano</b></FONT></td>";
	echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Nº Enami</b></FONT></td>";
    echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Nº Proyecto</b></FONT></td>";
	echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Gaveta</b></FONT></td>";
/*
    echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Suministro</b></td>";
*/
	echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Cad</b></FONT></td>";
    echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Rev</b></FONT></td>";
    echo "<td width='100%'><FONT size=1 color=WHITE face='verdana'><b>Obs</b></FONT></td>";
   	echo "</tr>";
}
?>

<Script language=JavaScript>
function recarga_pag(forma, opcion_elegida, num_combo)
{
   if ((opcion_elegida==0 && num_combo==0)||(opcion_elegida==1 && num_combo==0 && document.frm_final.cmb_pag.value!=-1)|| (opcion_elegida==2 && num_combo==0 && document.frm_final.cmb_pag.value!=-1))
    {
	  var p=document.frm_final.cmb_pag.value;
	  forma.action='res_find_planos.php?opcion=1&pag=' + p;
      forma.submit ();
    }
   if ((opcion_elegida==1 && num_combo==0 && document.frm_final.cmb_pag==-1)|| (opcion_elegida==2 && num_combo==0 && document.frm_final.cmb_pag.value==-1))
   {
	  var p=document.frm_final.cmb_pag.value;
	  forma.action='res_find_planos.php?opcion=0&pag=' + p;
      forma.submit ();
   }
   if ((opcion_elegida==1 && num_combo==1)||(opcion_elegida==2 && num_combo==1))
    {
	  var p=document.frm_final.cmb_pag.value;
	  forma.action='res_find_planos.php?opcion=2&pag=' + p;
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
	//var cmb_sumi=frm.cmb_sumi.value;
	var txt_titulo=frm.txt_titulo.value;
	var txt_n_enm=frm.txt_n_enm.value;
	var txt_n_proy=frm.txt_n_proy.value;

	frm.action = 'imprimir_plano.php?cmb_sec=' + cmb_sec + '&cmb_ar=' + cmb_ar + /*'&cmb_sumi=' + cmb_sumi +*/ '&txt_titulo=' + txt_titulo + '&txt_n_enm=' + txt_n_enm + '&txt_n_proy' + txt_n_proy;
	frm.submit();
}
</script>

<script language = JavaScript>
function volver()
{
	var frm=document.frm_final;

	frm.action = 'inicio_find_planos.php';
	frm.submit();
}
</script>


<html>
<head>
<title>Resultado de Busquedad de Planos, Sistema de Planos y Documentos, ENAMI-Ventanas</title>
<!--/ AQUI VA EL CODIGO QUE SE QUIERE INSERTAR EN EL BODY DE LA PAGINA/-->
<FORM NAME="frm_final" METHOD=POST ACTION="res_find_planos.php">
<table border="0" align="center" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>

<!-- INICIO ---------------------------------------------------------------->

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
//echo "<INPUT TYPE=hidden NAME=cad VALUE='$cad'>";

if ($opcion!=1)
   	{
	   	$opcion=0;
	}

	$txt_titulo = str_replace("*", "%", "$txt_titulo");
	$txt_n_enm = str_replace("*", "%", "$txt_n_enm");
	$txt_n_proy = str_replace("*", "%", "$txt_n_proy");

	if($flag != 1)
	{
		/*conteo de datos que daran como resultado*/
			$argumento=0;
			$numero_datos = "SELECT COUNT (T1.[Id Seccion] & T1.[Id Area] & T1.[Titulo Plano] & ";
    		$numero_datos = $numero_datos."T1.[Nº Enami] & T1.[Nº Proyecto] & T1.Gaveta & ";
    		$numero_datos = $numero_datos."T1.[Id Suministro] & T1.Cad & T1.Revisado & T1.Observacion & ";
	    	$numero_datos = $numero_datos."T2.[Id Seccion] & T2.[Nombre Seccion] & ";
    		$numero_datos = $numero_datos."T3.[Id Area] & T3.[Id Area] & T3.[Nombre Area] & ";
    		$numero_datos = $numero_datos."T4.[Id Suministro] & T4.[Nombre Suministro]) AS total_reg ";
	    	$numero_datos = $numero_datos."FROM Planos AS T1, Secciones AS T2, Areas AS T3, Suministros AS T4 ";
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

   			/*
   			if($cmb_sumi != '-1')
	   		{
		   		if($argumento == 1)
				{
	   				$numero_datos = $numero_datos."AND ";
				}
	   			else
				{
			   		$argumento++;
    			}

	    		$numero_datos = $numero_datos."T1.[Id Suministro]=$cmb_sumi ";
        		$numero_datos = $numero_datos."AND T4.[Id Suministro]=$cmb_sumi ";
			}
			*/

			/*
     		if($cad == 'TRUE' || $cad == 'FALSE')
     		{
			   	if($argumento == 1)
			   	{
	    			$numero_datos = $numero_datos."AND ";
	   			}
	   			else
	   			{
		      		$argumento++;
    			}

	   			$numero_datos = $numero_datos."T1.Cad=$cad ";
	    	}
	    	*/

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

			   	$numero_datos = $numero_datos."T1.[Titulo Plano] Like '$txt_titulo' ";
    		}

    		if($txt_n_enm != '')
	    	{
		   		if($argumento == 1)
	   			{
	      			$numero_datos = $numero_datos."AND ";
		   		}
		   		else
	   			{
	      			$argumento++;
    			}

		   		$numero_datos = $numero_datos."T1.[Nº Enami] Like '$txt_n_enm' ";
    		}

    		if($txt_n_proy != '')
    		{
			   	if($argumento == 1)
				{
	    	  		$numero_datos = $numero_datos."AND ";
	   			}
		   		else
		   		{
	    	  		$argumento++;
    			}

			   	$numero_datos = $numero_datos."T1.[Nº Proyecto] Like '$txt_n_proy' ";
    		}

	    	if($cmb_sec != '-1' || $cmb_ar != '-1' /*|| $cmb_sumi != '-1' */|| $txt_titulo != '' || $txt_n_enm != '' || $txt_n_proy != '' /*|| $cad != '2'*/)
    		{
				$numero_datos = $numero_datos."AND ";
	    	}

	    	$numero_datos = $numero_datos."T1.[Id Seccion]=T2.[Id Seccion] ";
       		$numero_datos = $numero_datos."AND T1.[Id Seccion]=T3.[Id Seccion] ";
	       	$numero_datos = $numero_datos."AND T1.[Id Area]=T3.[Id Area] ";
    	   	$numero_datos = $numero_datos."AND T2.[Id Seccion]=T3.[Id Seccion] ";
       		$numero_datos = $numero_datos."AND T1.[Id Seccion]=T2.[Id Seccion] ";
	       	$numero_datos = $numero_datos."AND T1.[Id Suministro]=T4.[Id Suministro] ";

	    	$Resp = odbc_exec($conexion,$numero_datos);
			//echo "<BR>$numero_datos";
		/*fin del conteo*/
		$flag = 0;
	}

if(odbc_result($Resp,'total_reg') != 0)
{

if ($opcion==0 || $opcion==1)
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
 		echo "<select name=cmb_pag OnChange=JavaScript:recarga_pag(this.form,".$opcion.",0)>\n";

        $i=1;
        while ($i <= $NumeroPagina)
           {
				if ($cmb_pag == $i)
				{
         			echo "<option value='$i' selected><font size='2' face='verdana'>Página ".$i."</font></option>\n";
				}
				else
				{
					echo "<option value='$i'><font size='2' face='verdana'>Página ".$i."</font></option>\n";
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

/*BOTONES*/
echo "<input type=BUTTON value='Consulta en Excel' onclick='javascript:enviar();'>";
echo " <input type=BUTTON value='Volver' onclick='javascript:volver();'>";

if($opcion == 1)
	{
/*INICIO DE LA CONSULTA*/
		$argumento = 0;
		$Consulta = "SELECT DISTINCTROW T1.[Id Seccion], T1.[Id Area], T1.[Titulo Plano], ";
	    $Consulta = $Consulta."T1.[Nº Enami], T1.[Nº Proyecto], T1.Gaveta, ";
        $Consulta = $Consulta."T1.[Id Suministro], T1.[Cad], T1.[Revisado], T1.[Observacion], ";
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

       	/*
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
       	*/
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

      	if($cmb_sec != '-1' || $cmb_ar != '-1' /*|| $cmb_sumi != '-1'*/ || $txt_titulo != '' || $txt_n_enm != ''  || $txt_n_proy != '' /*|| $cad != '2'*/)        {
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
       	//echo "<BR>$Consulta";
/*FIN DE LA CONSULTA*/
        echo "<font size='1' face='verdana'><B><BR>El resultado según los criterios de busqueda </font>";
       	echo "<font size='1' face='verdana'>es el siguiente:</B><BR></font>";

       	DibujaCabecera();
		$j = 1;
		$reg_mostrados = 0;
		$color = "#ffe89f";
        while (odbc_fetch_row($Respuesta) && $i <= $NumeroPagina)
        {
	        /*tienen que ser hasta un maximo de reg, que va a ser el registro n°: RegistroPorFila * pag */
	        /* y desde el registro n°: RegistroPorFila * (pag - 1)*/
	        if($j > $desde && $j <= $hasta)
	        {
		       	DibujaTabla($color, odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Titulo Plano"), odbc_result($Respuesta,"Nº Enami"), odbc_result($Respuesta,"Nº Proyecto"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro"), odbc_result($Respuesta,"Cad"), odbc_result($Respuesta,"Revisado"), odbc_result($Respuesta,"Observacion") );
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
		    		DibujaTabla($color, odbc_result($Respuesta,"Nombre Seccion"), odbc_result($Respuesta,"Nombre Area"), odbc_result($Respuesta,"Titulo Plano"), odbc_result($Respuesta,"Nº Enami"), odbc_result($Respuesta,"Nº Proyecto"), odbc_result($Respuesta,"Gaveta"), odbc_result($Respuesta,"Nombre Suministro"), odbc_result($Respuesta,"Cad"), odbc_result($Respuesta,"Revisado"), odbc_result($Respuesta,"Observacion") );
		    		if($color == "#ffe89f")
		    		{
			    		$color = "#FFFFCC";
		    		}
		    		else
		    		{
			    		$color = "#fff4cf";
		    		}

        			$j++;
		        }
			}
		    echo "</table><br>";
		}
		$i++;
		if ($sw == 0)
		{
		    echo "</table><br>";
		}

		if ( $j==1)
	 	{
			echo "<FONT SIZE=2><B><BR>No hay datos que coincidan con los criterios solicitados</B></FONT>";
		}
		echo "<input type=BUTTON value='Consulta en Excel' onclick='javascript:enviar();'>";
		echo "<br>  ..</br>";
		echo "<FONT SIZE=2><B><BR>Vea los Planos de Autocad haciendo click donde dice Cad de c/celda (Solo para los que tienen Volo View Express Instalado) </B></FONT>";

		echo "<FONT SIZE=2 face='verdana'><BR>Instale(Aún no Habilitado) ---> <I><a href='/volo.exe' class='main-menu'>Volo View Express</a><I>.</FONT>";

	}

}

else
{
	echo "<FONT SIZE=2 face='verdana'><B><BR>No hay datos que coincidan con los criterios solicitados</B></FONT>";
}

?>

<?odbc_close_all();?>
<!-- FINAL  -->

</td></tr>

</table>
</form>

<!--/------------------------------------------------------------------/-->
</BODY>
