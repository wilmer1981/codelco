<?
 $CodigoDeSistema = 27;
 $CodigoDePantalla = 4;
 set_time_limit(300);
?>
<html>
<head>
<title>Creacion de Archivos Ucas</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	var Valores='';
	var Valores2='';
	
	switch(TipoProceso)
	{
		case 'G'://GRABAR
			if(confirm('Desea Generar Archivo UCAS'))
			{
				fDelete_x('c:/','genum.txt');
				fDelete_x('c:/','genom.txt');
				for (i=0;i<f.TxtTarj.length;i++)
				{
					Valores=f.TxtTarj[i].value+'\r\n';
					Valores2=f.TxtNombre[i].value+'\r\n';
					fwrite_x('c:/','genum.txt',Valores,2);
					fwrite_x('c:/','genom.txt',Valores2,2);
				}
				alert('Archivos Generados');
			}		
			break;
		case "I"://IMPRIMIR
			window.print();
			break;				
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=30";
			f.submit();
			break;
	}
}
function fDelete_x(folder,filename)
//objFSO.DeleteFile(strFileName). 
{ //fwrite_x v1.0 byScriptman
var fso = new ActiveXObject("Scripting.FileSystemObject");

filename=folder+filename;
if(fso.FileExists(filename) != false)
	fso.DeleteFile(filename);
}

function fwrite_x(folder,filename,data,mode)//crea archivo de texto para visor
{ //fwrite_x v1.0 byScriptman
//modes: 0:si no existe, regresa false ;1: sobreescribe; 2:append.
var fso = new ActiveXObject("Scripting.FileSystemObject");

filename=folder+filename;
if(fso.FileExists(filename) == false&&mode==0) return false;
if(fso.FileExists(filename) != false&&mode==2) {
tf = fso.OpenTextFile(filename,1);
var dataold = tf.readall(); tf.close(); }
else dataold="";
var tf = fso.CreateTextFile(filename,2);
tf.write(dataold+data);
tf.close();
return true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image:  url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<input name="TxtValores" type="hidden" value="">
<? 
include("../principal/encabezado.php");

?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	    <table width="700" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla02">
            <td>CREACION DE ARCHIVOS UCAS MIXTOS(PERSONAL CODELCO Y PERSONAL COLABORADOR) </td>
		  </tr>	
		  <tr align="center" bgcolor="#FFFFFF">
            <td>
			    <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:120px;visibility:hidden;" onClick="Procesos('G')" value="Crear Archivos">
				<input name="BtnImprimir" type="button"  style="width:70px;" onClick="Procesos('I')" value="Imprimir">
                <input name="BtnSalir" type="button" style="width:70px;" onClick="Procesos('S')" value="Salir"></td>
          </tr>
		  <tr align="center" bgcolor="#FFFFFF">
		    <td align="left" class="ColorTabla02">------------&gt; Creacion Archivo <strong>GeNum</strong> ------------&gt; Archivos destino en c:\genum.txt</td>
	      </tr>
		  <tr align="center" bgcolor="#FFFFFF">
		    <td align="left" class="ColorTabla02">------------&gt; Creacion Archivo <strong>GeNom</strong> ------------&gt; Archivos destino en c:\genom.txt</td>
          </tr>
        </table>
			<?
			$Buscar='S';
			if($Buscar=='S')
			{
				//include("../principal/conectar_principal.php");
				include("../principal/conectar_sget_web.php");
				$Eliminar='delete from sget_carga_ucas';
				mysql_query($Eliminar);
				//TARJETAS CODELCO
				$Consulta="SELECT rut,nombres,ape_paterno,ape_materno,nro_tarjeta,observacion from uca_web.uca_personas ";
				$Consulta.="where estado='A' and rut_empresa='61704000-k' order by nro_tarjeta asc";
				//echo $Consulta."<br>";
				$RespPersona=mysql_query($Consulta);
				while($FilaPersona=mysql_fetch_array($RespPersona))
				{
					$Nombre=strtoupper(substr($FilaPersona["nombres"],0,1)).".".strtoupper($FilaPersona[ape_paterno])." ".strtoupper(substr($FilaPersona[ape_materno],0,1));			
					$Insertar="INSERT INTO sget_carga_ucas (nombre,tarjeta) values ('".$Nombre."','".$FilaPersona[nro_tarjeta]."')";
					mysql_query($Insertar);
					//echo "<input name='TxtTarj' type='hidden' value='".$FilaPersona[nro_tarjeta]."'><input name='TxtNombre' type='hidden' value='".$Nombre."'>";
				}
				//TARJETAS CONTRATISTA
				$Consulta="SELECT distinct t1.rut,nombres,t1.ape_paterno,t1.ape_materno,t1.nro_tarjeta,t1.rut_empresa,t1.cod_contrato,t2.fecha_inicio,t2.fecha_termino,t3.razon_social from sget_personal t1 left join ";
				$Consulta.="sget_contratos t2 on t1.cod_contrato=t2.cod_contrato and t1.rut_empresa=t2.rut_empresa left join sget_contratistas t3 on t1.rut_empresa=t3.rut_empresa ";
				$Consulta.="where t1.estado='A' and t1.nro_tarjeta <> '' and t1.nro_tarjeta <> '0' and t1.nro_tarjeta <>'Provisoria' and t1.nro_tarjeta <>'Provisor' order by t1.nro_tarjeta asc";
				//echo $Consulta."<br>";
				$RespPersona=mysql_query($Consulta);
				while($FilaPersona=mysql_fetch_array($RespPersona))
				{
					//$Nombre=strtoupper($FilaPersona[ape_paterno])." ".strtoupper(substr($FilaPersona[ape_materno],0,1))."."." ".strtoupper(substr($FilaPersona["nombres"],0,8));			
					$Nombre=strtoupper(substr($FilaPersona["nombres"],0,1)).".".strtoupper($FilaPersona[ape_paterno]).".".strtoupper(substr($FilaPersona[ape_materno],0,1));
					$Insertar="INSERT INTO sget_carga_ucas (nombre,tarjeta) values ('".$Nombre."','".$FilaPersona[nro_tarjeta]."')";
					mysql_query($Insertar);
					//echo "<input name='TxtTarj' type='hidden' value='".$FilaPersona[nro_tarjeta]."'><input name='TxtNombre' type='hidden' value='".$Nombre."'>";
				}
				$Consulta="SELECT * from sget_carga_ucas order by tarjeta asc";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<input name='TxtTarj' type='hidden' value='".$Fila[tarjeta]."'><input name='TxtNombre' type='hidden' value='".$Fila["nombre"]."'>";
				}
			}	
			?>
      </td>
    </tr>
 </table>
 </td>
    </tr>
</table>
<? include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
<?
	echo "<script languaje='JavaScript'>";
	echo "var Frm = document.frmPrincipal;";
	echo "Frm.BtnGrabar.style.visibility='';";
	echo "</script>";
?>	
