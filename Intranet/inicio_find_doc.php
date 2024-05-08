<html>
<head>
<title>Buscador de Documentos, Sistema de Planos y Documentos</title>
<link href="js/style2.css" rel=stylesheet>
</head>
<body
onload="JavaScript:document.frm_inicial.cmb_sec.focus()">

<!--/ AQUI VA EL CODIGO QUE SE QUIERE INSERTAR EN EL BODY DE LA PAGINA/-->
<FORM NAME="frm_inicial" METHOD=POST ACTION="res_find_planos.php">
    <table width="500" height="271" border="0" align="center" cellpadding="0" cellspacing="0" background="images/fondo3.gif" class="TablaInterior">
      <tr>
        <td height="45" align="center" valign="middle"><img src="images/cabecera2.jpg" width="301" height="45">
<!-- INICIO ----------------------------------------------------------------><!-- FINAL  --></td></tr>
      <tr>
        <td align="center" valign="top"><? $conexion = odbc_connect("BD-ING","","","");?>
          <div align="center"><font class="titulo_azul_codelco_informa"><br>
          Seleccione o ingrese los criterios de busqueda:<br>
                <br>
            </font>
              <script language=JavaScript>
function recarga(forma, opcion_elegida, num_combo)
{
   if ((opcion_elegida==0 && num_combo==0)||(opcion_elegida==1 && num_combo==0 && forma.cmb_sec.value!=-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_sec.value!=-1))
    {
      forma.action='inicio_find_doc.php?opcion=1';
      forma.submit ();
    }
   if ((opcion_elegida==1 && num_combo==0 && forma.cmb_sec==-1)|| (opcion_elegida==2 && num_combo==0 && forma.cmb_sec.value==-1))
   {
	  forma.action='inicio_find_doc.php?opcion=0';
      forma.submit ();
   }
}
            </script>
              <script language='javascript'>
function enviar()
{
	var frm=document.frm_inicial;
	var p=1;
	var op=1;

	if (frm.cmb_sec.value == '-1' && frm.cmb_ar.value == '-1' && frm.cmb_nom.value == '-1' && frm.txt_titulo.value == '')
	{
		alert('Para buscar algún, documento debe seleccionar algun criterio de busqueda');
		return;
	}
	else
	{
		frm.action='res_find_doc.php?pag=' + p + '&opcion=' + op;
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
              <?PHP
if ($opcion!=1)
   	{
	   	$opcion=0;
	}
echo "<table width='450' bgcolor='#FFFFFF' border=0 align='center' class='TablaInterior'>";
echo "<tr>";
echo "<td ><font class=\"titulo_azul_codelco_informa\">Sección:</FONT></td>";
if ($opcion==0 || $opcion==1)
       {
	     echo "<td ><select name=cmb_sec style='width: 350' OnChange=JavaScript:recarga(this.form,".$opcion.",0) >\n";
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

echo "<tr>";
echo "<td><font class=\"titulo_azul_codelco_informa\">Area:</FONT></td>";
if ($opcion==1)
      {
	    echo "<td>";
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
		echo "<td>";
	    echo "<select name=cmb_ar style='width: 350'>\n";
        echo "<option value='-1'>[No Disponible]</option>\n";
        echo "</select>\n";
        echo "<td>";
	}
echo "</tr>";

?>
              <?php
echo "<tr>";
	 echo "<td >";
	 	echo"<font class=\"titulo_azul_codelco_informa\">Nombre:</FONT>";
	 echo "</td>";

	 echo "<td >";
	 	echo "<select name=cmb_nom style='width: 350'>\n";
     	echo "<option value='-1'  selected>[Seleccionar]</option>\n";
     	$Consulta="Select * from Nombres ORDER BY [Nombre]";

    	 $Respuesta = odbc_exec($conexion,$Consulta);

	     while ($row = odbc_fetch_row($Respuesta))
    	 {
			echo "<option value='".odbc_result($Respuesta,"Id Nombre")."'>".odbc_result($Respuesta,"Nombre")." </option>\n";
     	 }
     	 echo "</select>\n";
     echo "</td>";
echo "</tr>";

echo "<tr>";
	 echo "<td>";
     	echo "<font class=\"titulo_azul_codelco_informa\">Título:</FONT>";
     echo "</td>";

     echo "<td>";
     	echo "<input type='text' name='txt_titulo' style='width: 350' size='30' maxlength='' class='InpurDer'><BR>";
		echo "<font class=\"titulo_azul_codelco_informa\">(Recuerde que el * sirve de comodin)</font>";
     echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br><br><div align='center'><input type=BUTTON value='Consultar' onclick='javascript:enviar();' style='width:70px'> ";
echo "<input type=BUTTON value='Volver' onclick='javascript:volver();' style='width:70px'></div>";
?>
              <br>
              <br>
              <?odbc_close_all();?>
          </div></td>
      </tr>
</table>
</form>

    <!--/------------------------------------------------------------------/-->

</body>
</html>
