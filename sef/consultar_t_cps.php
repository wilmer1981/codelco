<? include("conectar.php") ?>

<html>
<head>
<title></title>
<LINK href="style1.css" rel=StyleSheet type=text/css>
<Script language=JavaScript>
function enviar(f)
{
  ini = f.fecha_ini.value.split("-"); // [0]=dd, [1]=mm, [2]=aa;
  fin = f.fecha_fin.value.split("-");
  parametros = 'fecha_inicio='+ini[2]+'-'+ini[1]+'-'+ini[0]+'&fecha_final='+fin[2]+'-'+fin[1]+'-'+fin[0];  
   
  f.action = 'result_t_cps.php?'+ parametros;
  f.submit();
}


//*********************//
function vacio(i)
{
  if (i.value == "")
  { 
    return true;
  }
  return false;
}

//************************//
function validar(f)
{
  //valida si los campos estan vacios
  if (vacio(f.fecha_ini)) 
  { 
     alert("La fecha de inicio no es valida");
     f.fecha_ini.focus();
     return;
  }
  if (vacio(f.fecha_fin))
  {
    alert("La fecha final no es valida");
    f.fecha_fin.focus();
    return;
  }   
  if (f.fecha_ini.value.length != 10)  //valida el largo de los campos
  {
    alert("Formato de fecha no valido. Ej 01-01-2003");
    f.fecha_ini.focus();
    return;
  }
  if (f.fecha_fin.value.length != 10)
  {  
    alert("Formato de fecha no valido. Ej 01-01-2003");
    f.fecha_fin.focus();
    return;
  }

  //valida los signos '-' y el resto que sean solo numeros
  for (i = 0; i < f.fecha_ini.value.length; i++)
  {
    if ((i == 2) || (i == 5))   
    {
      if (f.fecha_ini.value.charAt(i) != '-')
      {
        alert("Formato de fecha no valido. Ej 01-09-2002 aqui"+i+" " +f.fecha_ini.value.charAt(i));
        f.fecha_ini.focus();
        return;
      } 
    }    
    else 
    {
      if (((f.fecha_ini.value.charAt(i)) < '0') || (f.fecha_ini.value.charAt(i) > '9'))
      {
        alert("Formato de fecha no valido. Ej 01-09-2002");
        f.fecha_ini.focus();
	return;
      }      
    }              
  }  
  
  for (i = 0; i < f.fecha_fin.value.length; i++)
  {
    if ((i == 2) || (i == 5)) 
    {
      if (f.fecha_fin.value.charAt(i) != '-')
      {
        alert("Formato de fecha no valido. Ej 01-09-2002");
        f.fecha_fin.focus();
        return;
      }  
    }  
    else 
    {
      if (((f.fecha_fin.value.charAt(i)) < '0') && (f.fecha_fin.value.charAt(i) > '9'))
      {
        alert("Formato de fecha no valido. Ej 01-09-2002");
        f.fecha_fin.focus();
	return;
      }         
    }  
  }    
         
  //separa fechas en arreglos
  vector_ini = f.fecha_ini.value.split("-"); // [0]=dd, [1]=mm, [2]=aa;
  vector_fin = f.fecha_fin.value.split("-");
  f_ini = vector_ini[2] + vector_ini[1] + vector_ini[0]; // aaaammdd;
  f_fin = vector_fin[2] + vector_fin[1] + vector_fin[0]; 
 
  //valida los meses 
  if ((vector_ini[1] < 1) || (vector_ini[1] > 12))
  {
    alert("Formato de fecha no valido. Mes incorrecto");
    f.fecha_ini.focus();
    return;
  }

  if ((vector_fin[1] < 1) || (vector_fin[1] > 12))
  {
    alert("Formato de fecha no valido. Mes incorrecto");
    f.fecha_fin.focus();
    return;
  }

  //valida los dias del mes
  ultimo = new Array(31,28,31,30,31,30,31,31,30,31,30,31);     

  if ((parseInt(vector_ini[2]) % 4) == 0)
  {
    ultimo[1] = 29;
  }  

  if ((vector_ini[0] < 1) || (vector_ini[0] > ultimo[vector_ini[1]-1]))
  {
    alert("Formato de fecha no valido. Dia incorrecto");
    f.fecha_ini.focus();
    return;    
  }  
 
  if ((parseInt(vector_fin[2]) % 4) == 0)
  {
    ultimo[1] = 29;
  }  
  if ((vector_fin[0] < 1) || (vector_fin[0] > ultimo[vector_fin[1]-1]))
  {
    alert("Formato de fecha no valido. Dia incorrecto");
    f.fecha_fin.focus();
    return;
  }

  //compara fecha inicial con final
  if (f_ini > f_fin)
  {
    alert("La fecha de inicio no puede ser superior a la fecha final");
    f.fecha_ini.focus();         
    return;
  }   

  //validar las casillas de verificacion y si esta ok enviar a otro formulario la respuesta;

  if (f.ck0.checked)          //habilta los checkbox para poder
  {                           //capturar su valor en la pagina siguiente.
    f.ck1.disabled = false;
    f.ck2.disabled = false;
  }  
  
  if (f.ck0.checked)
    f.ck0.value = 1;    //activado
  else f.ck0.value = 0; //desactivado
  
  if (f.ck1.checked)
    f.ck1.value = 1;
  else f.ck1.value = 0;

  if (f.ck2.checked)
    f.ck2.value = 1;
  else f.ck2.value = 0;

  enviar(f); //enviar datos

}
</Script>

<Script language=JavaScript>
function chequear(f)
{
  if (f.ck0.checked) 
    valor = true;
  else valor = false;
  
  f.ck1.checked = valor;
  f.ck2.checked = valor;

  f.ck1.disabled = valor;
  f.ck2.disabled = valor;  

  return;    
}

//*************************//
function desabilita()
{
  if (document.forms[0].activar.value != 1)
  {
    //Ademas pone fechas por defecto
    fecha_aux = document.forms[0].fecha_actual.value.split("-"); // [0]=dd, [1]=mm, [2]=aa;
    //fecha inicio
  
    fecha_ini = '01-';  
  
    if (fecha_aux[1].length == 1)
      fecha_ini = fecha_ini + '0' + fecha_aux[1] + '-' + fecha_aux[2];
    else fecha_ini = fecha_ini + fecha[1] + '-' + fecha_aux[2];

    document.forms[0].fecha_ini.value = fecha_ini;

    //fecha final
    if (fecha_aux[0].length == 1)
      fecha_fin = '0' + fecha_aux[0] + '-';
    else fecha_fin = fecha_aux[0] + '-';  
  
    if (fecha_aux[1].length == 1)
      fecha_fin = fecha_fin + '0' + fecha_aux[1] + '-' + fecha_aux[2];
    else fecha_fin = fecha_fin + fecha[1] + '-' + fecha_aux[2];
  
    document.forms[0].fecha_fin.value = fecha_fin;
    document.forms[0].activar.value = 1;
  }  
  
}

//**************************//
function limpiar(f)
{
  f.reset();
  return;
}

</Script>

</head>
<body bgcolor="#ffffff" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5" onLoad="desabilita()">
<form name=form1 action="" method="post">

<div align=left>SEF-BD</div>
<div align=center>REALIZAR CONSULTAS</div><br>

<? 
  if ($num_cps == 0)
    $cod_eq = 6;   
  else if ($num_cps == 1)
         $cod_eq = 7;
       else if ($num_cps == 2)
              $cod_eq = 8;
	    else if ($num_cps == 3)
	           $cod_eq = 9; 

  $consulta = "select * from equipos where cod_equipo=".$cod_eq;  
  $rs_eq = mysql_query($consulta);
  $row_eq = mysql_fetch_array($rs_eq);
  
  echo "<table align=center width=836>";
  echo "<tr>";
  echo "<td>";
  echo "<table align=left ID=tabla1>";
  echo "<tr>";
  echo "<td width=100 height=20 ID=campo1>Equipo:";
  echo "</td>";
  echo "<td width=300 height=20 ID=campo2>".$row_eq["Nombre_equipo"];
  echo "</td>";
  echo "</tr></table>";  
  echo "</td></tr></table><br>";
?>

<table align=center>
<tr><td>
  <table align=center ID=tabla1>
    <tr>
      <td width=100 height=20 align=left ID=campo1>Fecha Inicio:</td>
      <td width=300 height=20 align=left ID=campo2><input type=text name=fecha_ini maxlength=10 size=9>&nbsp;DD-MM-AAAA</td>      
      <td width=100 height=20 align=left ID=campo1>Fecha Final:</td>
      <td width=300 height=20 align=left ID=campo2><input type=text name=fecha_fin maxlength=10 size=9>&nbsp;DD-MM-AAAA</td>
      </td>
    </tr>
  </table>
</td/></tr>  
</table>
<br><br>

<?
  // campos ocultos
  echo "<input type=hidden name=cod_eq value=$cod_eq>";
  echo "<input type=hidden name=num_cps value=$num_cps>";
  echo "<input type=hidden name=activar>";
?>  



<table border=0>
<tr><td></td><td height=30 ID=campo1>Selecione los Sgts. Datos:</td></tr>
<tr><td width=100></td>
<?
    echo "<td>";
    echo "<table width=280 ID=campo3>";
    echo "<tr><td><input type=checkbox name=ck0 onClick='JavaScript:chequear(this.form)'>Todo</td></tr>";

    echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=ck1 >N� de Carga</td></tr>";
    echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=ck2 >Hrs. Soplado</td></tr>";
    echo "</table></td>";
?>
</tr></table>

<? //Obtiene la Fecha Actual.
  echo "<input type=hidden name=fecha_actual value=".date("j-n-Y").">";
?>

<br><br>
<table border=0 align=right>
  <tr>
    <td><input type=button value=Limpiar onClick="JavaScript:limpiar(this.form)" ID=boton1></td>
    <td><input type=button value="Volver al Menu" onClick="JavaScript:window.history.back();" ID=boton1></td>    
    <td width=300 height=20><input type=button value=Consultar onClick="JavaScript:validar(this.form)" ID=boton1> 
    </td>
  </tr>
</table>  

</form>
</body>
</html>


