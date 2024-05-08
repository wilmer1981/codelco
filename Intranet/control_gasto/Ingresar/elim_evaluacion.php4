<html>
<body background="imagenes\amarillo1.jpg">

<?php
    $link=mysql_connect("200.1.6.254","root");
    mysql_select_db("bd_contrato_maestranza",$link);
    if($opcion == Eliminar)
    {
       $sql="delete from evaluacion where numero_contrato = '$Codigo'";
       $result=mysql_query($sql);
       echo '<center>'.'<h1>'.'¡ELIMINACION EXITOSA!'.'</h1>'.'</center>';
    }
    else
    {
       echo '<form method="POST" action="mod_evaluacion.php4">';
       echo '<li>Registro(s):'.'<br>';
       $sql="select * from evaluacion where numero_contrato like '$Codigo' order by numero_contrato";
       $result1=mysql_query($sql);
       $result2=mysql_query($sql);
       $yatu=" ";

       if($row = mysql_fetch_array($result1))
       {
          echo '<li>'.'Numero evaluacion a Modificar       :';
          echo '<select name ="Mod">';
          while($row1 = mysql_fetch_array($result2))
          {
             echo '<option>'.$row1['numero_contrato'].'</option>\n';
          }
          echo '</select>';
          echo '<center>';
          echo '<TABLE border = 4 cellspacing = 4 cellpadding = 4 width =65%>';
          echo '<th align = center colspan = 2>'.'Registro';
          echo '<tr>';
          echo '<TD align = center>'.'Fecha evaluacion : ';
          echo '<TD align = center>'.$row['fecha_evaluacion'];
          echo '<TD align = center>'.'<input  type="text" name="Fecha_evaluacion" size="8" maxlength="8">';
          echo '<tr>';
          echo '<TD align = center>'.'Rut encargado : ';
          echo '<TD align = center>'.$row['rut_encargado'];
          echo '<TD align = center>'.'<input  type="text" name="Rut2" size="8" maxlength="8" >-<input  type="text" name="Dv" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Rut jefe : ';
          echo '<TD align = center>'.$row['rut_jefe_acepta'];
          echo '<TD align = center>'.'<input  type="text" name="Rut1" size="8" maxlength="8" >-<input  type="text" name="D" size="1" maxlength="1">';
          echo '<tr>';
          echo '<TD align = center>'.'Concepto1 : ';
          echo '<TD align = center>'.$row['concepto1'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto1" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto2 : ';
          echo '<TD align = center>'.$row['concepto2'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto2" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto3: ';
          echo '<TD align = center>'.$row['concepto3'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto3" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto4 : ';
          echo '<TD align = center>'.$row['concepto4'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto4" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto5: ';
          echo '<TD align = center>'.$row['concepto5'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto5" size="8" maxlength="8" >';
          echo '<tr>';
          echo '<TD align = center>'.'Concepto6 : ';
          echo '<TD align = center>'.$row['concepto6'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto6" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto7 : ';
          echo '<TD align = center>'.$row['concepto7'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto7" size="8" maxlength="8" >';
          echo '<tr>';
            echo '<tr>';
          echo '<TD align = center>'.'Concepto8: ';
          echo '<TD align = center>'.$row['concepto8'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto8" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto9 : ';
          echo '<TD align = center>'.$row['concepto9'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto9" size="8" maxlength="8" >';
          echo '<tr>';
           echo '<tr>';
          echo '<TD align = center>'.'Concepto10 : ';
          echo '<TD align = center>'.$row['concepto10'];
          echo '<TD align = center>'.'<input  type="text" name="Concepto10" size="8" maxlength="8" >';
          echo '<tr>';
          echo '</TABLE>';
          echo '<br>'.'<br>'.'<input type="Submit" name="enviar" value="Modificar">';
          echo '</center>';
       }
    }
?>


<H2><A href="http://200.1.6.254/contrato%20y%20maestranza/bus_evaluacion.html">ATRAS</A></H2>
</body>
</html>
