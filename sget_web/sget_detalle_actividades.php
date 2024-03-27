<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Consulta="SELECT t3.razon_social,t1.fecha_ingreso,t2.descripcion,t2.cod_contrato,t2.rut_adm_contratista, ";
	$Consulta.=" t4.nombres, t4.ape_paterno,t4.ape_materno,t2.rut_prev ";
	$Consulta.=" from sget_hoja_ruta t1 ";
	$Consulta.=" inner join sget_contratos t2 on t1.cod_contrato=t2.cod_contrato ";
	$Consulta.=" inner join sget_contratistas t3 on t1.rut_empresa=t2.rut_empresa ";
	$Consulta.=" inner join sget_administrador_contratistas t4 on t2.rut_adm_contratista=t4.rut_adm_contratista ";
	$Consulta.=" where num_hoja_ruta='".$TxtHoja."' ";
	/*echo $Consulta;*/
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysql_fetch_array($Resp);
	$Empresa=$Fila[razon_social];
	$Contrato=$Fila["cod_contrato"].' '.$Fila["descripcion"];
	$FechaIngreso=$Fila[fecha_ingreso];
	$AdmContratistaD=$Fila["nombres"]." ".$Fila[ape_paterno]." ".$Fila[ape_materno];
	$RutPrev=$Fila[rut_prev];
?>
<title>Reporte</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Procesos(Opt)
{
	var f=document.FrmProceso;
	switch (Opt)
	{
		case "I":
			window.print();
			break;		
		case "S":
			window.close();
			break;
	}
}
</script>
<form name="FrmProceso" action="" method="post">
<input type="hidden" name="NumHr" value="<? echo $NumHr;?>">
<input type="hidden" name="Fecha" value="<? echo $Fecha;?>">
<input type="hidden" name="Run" value="<? echo $Run;?>">

<br>
	<table width="85%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  	<tr>
	<td width="17" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1011" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="18" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  	</tr>
  	<tr>
   	<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   	<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="74%" align="left"><img src="archivos/sub_tit_det_act.png" /></td>
        <td align="right"><a href="JavaScript:Procesos('S')"><img src="archivos/close.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
      </tr>
    </table>
   	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td colspan="3"align="center" class="TituloTablaVerde"></td>
        </tr>
        <tr>
          <td width="1%" align="center" class="TituloTablaVerde"></td>
          <td align="center"><table width="100%" align="center" border="0" cellpadding="2" cellspacing="0"  >
            <tr align="right">
              <td colspan="5" ></td>
            </tr>
            <tr >
              <td width="23%" align="center" class="TituloCabecera">Fecha </td>
              <td width="23%" align="center" class="TituloCabecera">Funcionario</td>
              <td width="25%" align="center" class="TituloCabecera">Actividad</td>
              <td width="21%" align="center" class="TituloCabecera">Personal</td>
              <td width="8%" align="center" class="TituloCabecera">Estado</td>
			   <td width="8%" align="center" class="TituloCabecera">Tarjeta</td>
            </tr>
            <?
	
		$Consulta = "SELECT * from sget_registro_actividad ";
		$Consulta.= " where num_hoja_ruta='".$NumHr."' and fecha_hora='".$Fecha."' and rut='".$Run."'";
		$RespCrea=mysqli_query($link, $Consulta);
		while($FilaCrea=mysql_fetch_array($RespCrea))
		{
			?>
            <tr>
              <td align="center" ><? echo $FilaCrea["FECHA_HORA"]; ?> </td>
              <td align="left" ><?
			$Consulta="SELECT * from proyecto_modernizacion.funcionarios where rut='".$FilaCrea["rut"]."' ";
			$Resp1=mysqli_query($link, $Consulta);
			$Fila1=mysql_fetch_array($Resp1);
			{
				echo substr($Fila1["nombres"],0,1).'.'.$Fila1["apellido_paterno"].' '.$Fila1["apellido_materno"];
			}
			?>
              </td>
              <td  align="left" ><?
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase ='".$FilaCrea["cod_estado"]."' ";
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				{
					echo $Fila["nombre_subclase"];
				}
			?>
                &nbsp;</td>
              <td  align="left" ><?
			
			$Consulta="SELECT * from  sget_personal where rut='".$FilaCrea["rut_funcionario"]."' ";
			$Resp1=mysqli_query($link, $Consulta);
			$Fila1=mysql_fetch_array($Resp1);
			{
				echo substr($Fila1["nombres"],0,1).'.'.$Fila1[ape_paterno].' '.$Fila1[ape_materno];
			}
			?>
              </td>
              <td  align="center" ><?
			
				if($FilaCrea["estado"] =='A')
					echo '<img src="archivos/aprobado.png"  border="0"  alt=" Aprobado " align="absmiddle" />';
				else
					echo '<img src="archivos/rechazado.png"  border="0"  alt=" Aprobado " align="absmiddle" />';
			
			?>
              </td>
			     <td align="center" >
				 <?
			    $Consulta="SELECT * from  sget_hoja_ruta_nomina_hitos_personas where fecha_hora='".$FilaCrea["FECHA_HORA"]."' and num_hoja_ruta='".$NumHr."' and rut_personal='".$FilaCrea["rut_funcionario"]."'";
				$RespTar=mysqli_query($link, $Consulta);
				$FilaTar=mysql_fetch_array($RespTar);
				{
					echo $FilaTar[num_tarjeta];
				}
			    ?>
				 &nbsp; </td>
            </tr>
            <?
		}
	?>
          </table></td>
          <td width="0%" align="center" class="TituloTablaVerde"></td>
        </tr>
        <tr>
          <td colspan="3"align="center" class="TituloTablaVerde"></td>
        </tr>
      </table>
   	  <br></td>
  <td  background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td  height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td  height="15"><img src="archivos/images/interior/esq4.gif" ></td>
  </tr>
  </table>	
</form>
