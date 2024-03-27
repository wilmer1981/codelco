<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

?>
<html>
<head>
<title>Ingreso de Certificados</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
var popup=0;
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action="sget_mantenedor_antecedentes.php?&Buscar=S";
			f.submit();
		break;
		
		case "G":
			//f.Opc.value=Opc;
			//Veri=ValidaCampos();
			Veri = true;
			var TxtApellido = f.TxtApellido.value;
			//alert (TxtApellido);
			if (Veri==true)  
			{
				for (i=1;i<f.elements.length;i++)
				{
					if ((f.elements[i].name=="TxtRut"&&f.elements[i].value!="") && (f.elements[i + 1].value!=""))
					{	
						Datos= Datos + f.elements[i].value + "~~" + f.elements[i + 1].value + "//";
					}	
				}
				Datos = Datos.substring(0,(Datos.length-2));
				
				//alert(Datos);
				//alert (f.TxtApellido.value;);
				//		window.open("sec_informe_camiones.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino,"","statusbar=yes, menubar=no, resizable=yes, top=50, left=50, width=650, height=500, scrollbars=yes")

				f.action = "sget_certificados01.php?Opcion=G&Valores="+Datos+"&TxtApellido="+TxtApellido;
				f.submit();
				break;
			}

		
		
	
	/*	case "N":
			URL="sget_mantenedor_cargos_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=200,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckTipoDoc','M'))
			{
				Datos=Recuperar(f.name,'CheckTipoDoc');
				
				URL="sget_mantenedor_cargos_proceso.php?Opc="+Opc+"&Valores="+Datos;
				opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=200,scrollbars=1';
				verificar_popup(popup);
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckTipoDoc','E'))
			{
				mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckTipoDoc');
					f.action='sget_mantenedor_cargos01.php?Opcion=E&Valor='+ Datos; //Datos; //+"&Pagina="+f.Pagina.value;
					f.submit();
				}
			}	
		break;*/
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=32";
		break;
	}	
}

</script>
<? 
	echo '<body leftmargin="3" topmargin="2"  onLoad="document.FrmPrincipal.TxtApellido.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
 /*$IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_cargos.png')
*/
 ?>
  <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td>
		<table width="100%" cellpadding="2" cellspacing="0">
		  <tr>
		<td width="19%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	     <td width="81%" align="right" class='formulario2' >
		 <a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		 <a href = "JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar" border="0" align="absmiddle" /></a>  
		 <a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>
		 <? /* 
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a></td> */?>
		  </tr>
		  	  <tr>
            <td align="left" class='formulario2'>Letra Apellido a Buscar</td>
		  	    
            <td class='formulario2' > <input name="TxtApellido" maxlength= "20" size="20" type="text" id="TxtApellido" onChange="Proceso('C')"  value="<? echo $TxtApellido; ?>" ></td>
  	      </tr>
		</table>   
	</td>
      <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>
  <br>	
 
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
	  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
</tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td align="center"><table width="930" border="1" cellpadding="4" cellspacing="0" >
     
	  <tr align="center">
	  	<td width="10%" class="TituloTablaVerde">Rut</td>
        <td width="20%" class="TituloTablaVerde">Apellido Paterno </td>
		<td width="20%" class="TituloTablaVerde">Apellido Materno</td>
		<td width="20%" class="TituloTablaVerde">Nombres</td>
		<td width="20%" class="TituloTablaVerde">N� Certificado Antecedentes</td>
        </tr>
<?
	
	
	if($Buscar=='S')
{

		$TxtApellido = strtoupper(trim($TxtApellido));
		$Ape = $TxtApellido."%";
		
		$Consulta= "SELECT t1.rut,t1.ape_paterno,t1.ape_materno,t1.nombres,t1.num_cert_antecedentes ";
 		$Consulta.= " from sget_personal t1"; 
 		$Consulta.= " where (t1.num_cert_antecedentes='' || t1.num_cert_antecedentes=0 || isnull(t1.num_cert_antecedentes))";
		$Consulta.= " and upper(t1.ape_paterno) like '".$Ape."'";  

		$Consulta.= " order by t1.rut,t1.ape_paterno";
	//	echo "WW".$Consulta;
		 $Resp = mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
		$Rut=$Fila["rut"];
		$Paterno =$Fila["ape_paterno"];
		$Materno =$Fila["ape_materno"];
		$Nombres = $Fila["nombres"];
		
?>		
      	<tr >
        <td ><? echo "<input disabled name='TxtRut' align='center'  value = '".$Rut."'>"; ?></td>
		<td ><? echo $Paterno; ?></td>
		<td ><? echo $Materno; ?></td>
		<td ><? echo $Nombres; ?></td>
		<td ><? echo "<input  name='CheckTipoDoc' align='center' type='text'  value=''>";?></td>
        </tr>
<?
	}
}	

?>			
    </table></td>

 </td>
  <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>
<?
CierreEncabezado()
?>	
</form>
<?
if($Mensaje=='S')
{
?>
<script language="javascript">
alert("No se pueden Eliminar, Tiene Requerimientos Asociados")
</script>
<? }?>

