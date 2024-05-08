<html>
<head>
<title>Buscador de Planos, Sistema de Planos y Documentos, ENAMI-Ventanas</title>
</head>
<body
onload="JavaScript:document.frm_inicial.cmb_sec.focus()">

<!--/ AQUI VA EL CODIGO QUE SE QUIERE INSERTAR EN EL BODY DE LA PAGINA/-->
<FORM NAME="frm_inicial" METHOD=POST ACTION="res_find_planos.php">
    <table border="0" align="center" cellspacing="0" cellpadding="0" width="79%">
      <tr>
        <td>
<!-- INICIO ---------------------------------------------------------------->

<? $conexion = odbc_connect("BD-ING","","","");?>

<font size="3"><b>Seleccione o ingrese los criterios de busqueda:</b><BR></font>

<script language='javascript'>
function enviar()
{
	var frm=document.frm_inicial;
	var p=1;
	var op=1;

	if (frm.cmb_sec.value == '-1' && frm.cmb_ar.value == '-1' && frm.txt_titulo.value == '' && frm.txt_n_enm.value == '' && frm.txt_n_proy.value == '')
	{
		alert('Para buscar algún plano, debe seleccionar algun criterio de busqueda');
		return;
	}
	else
	{
		frm.action='res_find_planos.php?pag=' + p + '&opcion=' + op;
		frm.submit();
	}
}
</script>

<script language = JavaScript>
function volver()
{
	var frm=document.frm_inicial;

	frm.action = 'index.php?Pagina=menu_dinamico.php?CodMenu=28';
	frm.submit();
}
</script>

<SCRIPT language=JavaScript>
function recarga(forma, opcion_elegida, num_combo)
{
   if ((opcion_elegida==0 && num_combo==0)||(opcion_elegida==1 && num_combo==0 && forma.cmb_sec.value!=-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_sec.value!=-1))
    {
      forma.action='inicio_find_planos.php?opcion=1';
      forma.submit ();
    }
   if ((opcion_elegida==1 && num_combo==0 && forma.cmb_sec==-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_sec.value==-1))
   {
	  forma.action='inicio_find_planos.php?opcion=0';
      forma.submit ();
   }
}
</SCRIPT>
<?PHP

if ($opcion!=1)
   	{
	   	$opcion=0;
	}
echo "<table width='450' bgcolor='#cccccc' border=0>";
echo "<tr width='100%'>";
echo "<td bgcolor='#225193'><FONT color=WHITE>Sección</FONT></td>";
if ($opcion==0 || $opcion==1)
       {
	     echo "<td bgcolor='#fff4cf'><select name=cmb_sec style='width: 350' OnChange=JavaScript:recarga(this.form,".$opcion.",0) >\n";
         echo "<option value='-1'>[Seleccionar]</option>\n";
         $Consulta="Select * from Secciones ORDER BY [Nombre Seccion]";
         $Respuesta = odbc_exec($conexion,$Consulta);
         while ($row = odbc_fetch_row($Respuesta))
           {
            if (odbc_result($Respuesta,"Id Seccion") == $cmb_sec)
              {
               echo "<option value='".odbc_result($Respuesta,"Id Seccion")."' selected>".odbc_result($Respuesta,"Nombre Seccion")."</option>\n";
              }
             else
               {
                echo "<option value='".odbc_result($Respuesta,"Id Seccion")."'>".odbc_result($Respuesta,"Nombre Seccion")."</option>\n";
               }
           }
        echo "</select>\n</td>";
       }
else
       {
	       echo "<select name=cmb_sec style='width: 350' >\n";
           echo "<option value='-1'>[No Disponible]</option>\n";
           echo "</select>\n";
       }
echo "</tr>";

echo "<tr width='100%'>";
echo "<td bgcolor='#225193'><FONT color=WHITE>Area</FONT></td>";
if ($opcion==1)
      {
	    echo "<td bgcolor='#fff4cf'>";
      	echo "<select name=cmb_ar style='width: 350' OnChange=JavaScript:recarga(this.form,".$opcion.",1) >\n";
       	echo "<option value='-1'>[Seleccionar]</option>\n";
       	$Consulta="Select [Id Area], [Id Seccion], [Nombre Area] FROM Areas where [Id Seccion]=$cmb_sec ORDER BY [Nombre Area]";
       	$Respuesta = odbc_exec($conexion,$Consulta);
       	while ($row = odbc_fetch_row($Respuesta))
       	{
        	if (odbc_result($Respuesta,"Id Area") == $ar)
          		{
           			echo "<option value='".odbc_result($Respuesta,"Id Area")."' selected>".odbc_result($Respuesta,"Nombre Area")."</option>\n";
              	}
            else
            	{
                	echo "<option value='".odbc_result($Respuesta,"Id Area")."'>".odbc_result($Respuesta,"Nombre Area")."</option>\n";
               	}
        }
       	echo "</select>\n";
       	echo "<td>";
	}
else
	{
		echo "<td bgcolor='#fff4cf'>";
	    echo "<select name=cmb_ar style='width: 350'>\n";
        echo "<option value='-1'>[No Disponible]</option>\n";
        echo "</select>\n";
        echo "<td>";
	}
echo "</tr>";

?>

<?php
/*
echo "<tr width='100%'>";
	 echo "<td bgcolor='#225193'>";
	 	echo"<FONT color=WHITE>Suministro</FONT>";
	 echo "</td>";

	 echo "<td bgcolor='#fff4cf'>";
	 	echo "<select name=cmb_sumi style='width: 350'>\n";
     	echo "<option value='-1'  selected>[Seleccionar]</option>\n";
     	$Consulta="Select * from Suministros ORDER BY [Nombre Suministro]";

    	 $Respuesta = odbc_exec($conexion,$Consulta);

	     while ($row = odbc_fetch_row($Respuesta))
    	 {
			echo "<option value='".odbc_result($Respuesta,"Id Suministro")."'>".odbc_result($Respuesta,"Nombre Suministro")." </option>\n";
     	 }
     	 echo "</select>\n";
     echo "</td>";
echo "</tr>";
*/
echo "<tr width='100%'>";
	 echo "<td bgcolor='#225193'>";
     	echo "<FONT color=WHITE>Título del Plano</FONT>";
     echo "</td>";

     echo "<td bgcolor='#fff4cf'>";
     	echo "<input type='text' name='txt_titulo' style='width: 350' size='30' maxlength=''><BR>";
		echo " (Recuerde que el * sirve de comodin)";
     echo "</td>";
echo "</tr>";

echo "<tr width='100%'>";
	 echo "<td bgcolor='#225193'>";
     	echo "<FONT color=WHITE>N° Enami</FONT>";
     echo "</td>";

     echo "<td bgcolor='#fff4cf'>";
		echo "<input type='text' name='txt_n_enm' style='width: 200' size='30' maxlength=''>";
     	echo " (El * sirve de comodin)";
     echo "</td>";
echo "</tr>";

echo "<tr width='100%'>";
	 echo "<td bgcolor='#225193'>";
     	echo "<FONT color=WHITE>N° Proyecto</FONT>";
     echo "</td>";

     echo "<td bgcolor='#fff4cf'>";
		echo "<input type='text' name='txt_n_proy' style='width: 200' size='30' maxlength=''>";
     	echo " (El * sirve de comodin)";
     echo "</td>";
echo "</tr>";

echo "<tr>";
     echo "<td bgcolor='#225193'>";
     	 echo "<FONT color=WHITE>CAD</FONT>";
     echo "</td>";

     echo "<td bgcolor='#fff4cf'>";
	 	echo "<INPUT TYPE='Radio' NAME='cad' VALUE='TRUE'>Si";
	 	echo "<INPUT TYPE='Radio' NAME='cad' VALUE='FALSE'>No";
	 	echo "<INPUT TYPE='Radio' NAME='cad' VALUE=2 checked>No Sabe";
	 echo "</td>";
echo "</tr>";

echo "</table>";
echo "<input type=BUTTON value='Buscar Plano' onclick='javascript:enviar();'> ";
echo "<input type=BUTTON value='Volver' onclick='javascript:volver();'>";
?>
  <BR>

<BR>

<?odbc_close_all();?>
<!-- FINAL  -->

</td></tr>

</table>
</form>

<!--/------------------------------------------------------------------/-->
</body>
</html>
