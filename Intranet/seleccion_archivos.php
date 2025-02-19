<?php
	$Tipo   = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";	
	$Titulo = isset($_REQUEST["Titulo"])?$_REQUEST["Titulo"]:"";
	$VerDia = isset($_REQUEST["VerDia"])?$_REQUEST["VerDia"]:"";
	$VerMes = isset($_REQUEST["VerMes"])?$_REQUEST["VerMes"]:"";
	$VerAno = isset($_REQUEST["VerAno"])?$_REQUEST["VerAno"]:"";
	$VerAyer = isset($_REQUEST["VerAyer"])?$_REQUEST["VerAyer"]:"";
	$VerSemana = isset($_REQUEST["VerSemana"])?$_REQUEST["VerSemana"]:"";
	$Carpeta = isset($_REQUEST["Carpeta"])?$_REQUEST["Carpeta"]:"";
	$DiaAnt  = isset($_REQUEST["DiaAnt"])?$_REQUEST["DiaAnt"]:"";
	$MesAnt  = isset($_REQUEST["MesAnt"])?$_REQUEST["MesAnt"]:"";
	$AnoAnt  = isset($_REQUEST["AnoAnt"])?$_REQUEST["AnoAnt"]:"";
	
	switch ($Tipo)
	{
		case "AVANCE_DIARIO":
			$Titulo= "Avance Diario";
			$Carpeta="Archivos/principal/avance_diario";
			$VerAyer = "S";
			$VerDia = "S";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TED_REF_ELEC":
			$Titulo= "Tendencias de Refineria";
			$Carpeta="Archivos/tendencias/refineria";
			$VerAyer = "N";
			$VerDia = "N";
			$VerMes = "S";
			$VerAno = "S";
			//GrabarAcceso($Tipo)
			break;
		case "REF_ELEC":
			$Titulo= "Informe Diario Refineria";
			$Carpeta="Archivos/Informed/Inf_refineria";
			$VerAyer = "S";
			$VerDia = "S";
			$VerMes = "S";
			$VerAno = "S";
			//GrabarAcceso($Tipo)
			break;
		case "REF_FUE":
			$Titulo= "Informe Diario Refino a Fuego";
			$Carpeta="Archivos/Informed/Inf_Ref_fuego";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "CNU_FUN":
			$Titulo= "Informe Beneficio CNU";
			$Carpeta="Archivos/Informed/Inf_Fundicion";
			$VerAyer = "S";
			$VerDia = "S";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "INF_PMN":
			$Titulo= "Informe Diario PLAMEN";
			$Carpeta="Archivos/Informed/Inf_met_nobles";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "EMB_PROD":
			$Titulo= "Informe Diario Emb. Productos";
			$Carpeta="Archivos/Informed/Embarque";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "IND_FUN":
			$Titulo= "Indicadores Diarios de Fundicion";
			$Carpeta="Archivos/Informed/ind_fundicion";
			$VerAyer = "S";
			$VerDia = "S";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "MANT_SEMANAL":
			$Titulo= "Principales Mantenciones de la Semana";
			$Carpeta="Archivos/mantencion/programa_mensual/";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			$VerSemana = "S";
			break;
		case "MANT_1":
			$Titulo= "";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "DISTRIB_SERV":
			$Titulo= "Distribuccion de Servicios";
			$Carpeta="Archivos/mantencion/distribuccion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "PROD_GES":
			$Titulo= "Produccion Gestion";
			$Carpeta="Archivos/Principal/Prod_gest";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "INF_FUN_REF":
			$Titulo= "";
			$Carpeta="Archivos/Informed/Inf_Fun_ref";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "IND_ECON":
			$Titulo= "Indicadores Económicos";
			$Carpeta="Archivos/Finanzas/Indica_econ";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "RES_GASTO":
			$Titulo= "Resumen Gasto";
			$Carpeta="Archivos/Finanzas/Res_Gasto";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "COSTO_UNIT":
			$Titulo= "Costo Unitario";
			$Carpeta="Archivos/Finanzas/costo";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TEN_FUN":
			$Titulo= "Tendencias de Fundición ";
			$Carpeta="Archivos/tendencias/fundicion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TEN_RAF":
			$Titulo= "Tendencias Refino a Fuego ";
			$Carpeta="Archivos/tendencias/refino";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TEN_REF":
			$Titulo= "Tendencias Refinería Electrolítica ";
			$Carpeta="Archivos/tendencias/refineria";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TEN_PMN":
			$Titulo= "Tendencias Planta de Metales Nobles";
			$Carpeta="Archivos/tendencias/metales";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TEN_ACID":
			$Titulo= "Tendencias Planta de Acido ";
			$Carpeta="Archivos/tendencias/acido";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "ISO_9001":
			$Titulo= "ISO 9001 : 2000 Cumplimientos Mensuales";
			$Carpeta="Archivos/mantencion/ISO9002";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES1":
			$Titulo= "Servicios Mensual";
			$Carpeta="Archivos/mantencion/servicios";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "PROG_ANUAL":
			$Titulo= "Programa Anual Rep. Mayores";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES3":
			$Titulo= "Disponibilidad de Equipos Anual";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES5":
			$Titulo= "Indicadores de Costo Mantención Anual";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES6":
			$Titulo= "Campaña Convertidor Teniente";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES7":
			$Titulo= "Indicadores Consumo Refractario Anual";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES9":
			$Titulo= "Distribucción Horas Hombre Mantención Anual";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "MES11":
			$Titulo= "Incidencia Mantención en C/Prod.Anual";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "TMF_CTTE":
			$Titulo= "TMF Convertidor Teniente";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "TMF_MFCI":
			$Titulo= "TMF Convertidor Teniente";
			$Carpeta="Archivos/mantencion/inf_mantencion";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "";
			$VerAno = "S";
			break;
		case "TERM_CTTE":
			$Titulo= "Termografia Convertidor Teniente";
			$Carpeta="Archivos/mantencion/termografia";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
		case "TERM_HE":
			$Titulo= "Termografia Horno Electrico";
			$Carpeta="Archivos/mantencion/termografia";
			$VerAyer = "";
			$VerDia = "";
			$VerMes = "S";
			$VerAno = "S";
			break;
	}
?>
  <table width="300" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal2">
    <tr valign="top">
      <td height="25" bgcolor="#efefef" class="main-menu"><?php echo $Titulo; ?></td>
    </tr>
    <tr>
      <td height="30" align="center" valign="top">
        <p>            
<?php	
	//DIA
	if ($VerDia=="S")
	{
		echo "<select name=\"DiaIni\">\n";
		for ($i=1;$i<=31;$i++)
		{
			if ($i==date("j"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}  
		echo "</select>\n";
	}					
	//MES
	if ($VerMes=="S")
	{
		echo "<select name=\"MesIni\">\n";
		for ($i=1;$i<=12;$i++)
		{
			if ($i==date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		echo "</select> \n";
	}
	//AÑO
	if ($VerAno=="S")
	{
		echo "<select name=\"AnoIni\">\n";
		for ($i=(date("Y")-4);$i<=date("Y");$i++)
		{
			if ($i==date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		} 
		echo "</select>\n";
	}
?>            
      </p></td>
    </tr>
<?php	
	if ($VerSemana=="S")
	{
		echo "<tr valign=\"top\">\n";
		echo "<td align=\"center\" height=\"30\">\n";
		echo "<a href=\"Informes_diarios.html\"><img src=\"images/vineta3.gif\" width=\"13\" height=\"12\" border=\"0\"></a><span class=\"main-menu-blanco\">Semana:</span>\n";
		echo "<select name=\"Semana\">\n";
		for ($i=1;$i<=5;$i++)
		{
			if ($i==date("j"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		} 
		echo "</select>\n";          
		echo "</td>\n";
		echo "</tr>\n";
	}
?>	
    <tr valign="top">
      <td align="center" height="30">
<?php	  
	if ($VerAyer=="S")	
		echo "<input name=\"BtnAyer\" type=\"button\" style=\"width:60px\" onClick=\"BuscarArchivo('".$Tipo."','".$DiaAnt."','".$MesAnt."','".$AnoAnt."')\" value=\"Ayer\">\n";
?>		  
          <input name="BtnBuscar" type="button" id="BtnBuscar2" style="width:60px " onClick="BuscarArchivo('<?php echo $Tipo; ?>','','','')" value="Buscar"></td>
    </tr>
    <tr align="center">
      <td ><img src="images/vineta2.gif" width="13" height="12" border="0"><a href="<?php echo $Carpeta; ?>"><font class="main-menu_2">Ver Todos</font></a></td>
    </tr>
    <tr align="center">
      <td bgcolor="#efefef" ><span class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></span></td>
    </tr>
</table>
  <script language="javascript">
function BuscarArchivo(tipo,dia,mes,ano)
{
	var f=document.frmPrincipal;
	var Archivo="";
<?php
	if ($VerDia=="S")
	{	
		echo "if (dia=='') dia=f.DiaIni.value; ";
	}			
	if ($VerMes=="S")
	{	
		echo "if (mes=='') mes=f.MesIni.value;";
	}
	if ($VerAno=="S")
	{
		echo "if (ano=='') ano=f.AnoIni.value;";
	}
?>	
	if (dia<10 && dia!='')
		dia="0"+dia;
	if (mes<10 && mes!='')
		mes="0"+mes;
	switch (tipo)
	{
		case "AVANCE_DIARIO":
			Archivo="Archivos/principal/avance_diario/"+dia+"."+mes+"."+ano+".xls";
			break;
		case "REF_ELEC":
			Archivo="Archivos/Informed/Inf_refineria/"+dia+"."+mes+"."+ano+".xls";
			break;
		case "REF_FUE":
			Archivo="Archivos/Informed/Inf_Ref_fuego/"+mes+"."+ano+".xls";
			break;
		case "CNU_FUN":
			Archivo="Archivos/Informed/Inf_Fundicion/"+dia+"."+mes+"."+ano+".xls";
			break;
		case "INF_PMN":
			Archivo="Archivos/Informed/Inf_met_nobles/"+mes+"."+ano+".xls";
			break;
		case "EMB_PROD":
			Archivo="Archivos/Informed/Embarque/"+mes+"."+ano+".xls";
			break;
		case "IND_FUN":
			Archivo="Archivos/Informed/ind_fundicion/dia_"+dia+"_"+mes+"_"+ano+".xls";
			break;
		case "MANT_1":
			Archivo="Archivos/mantencion/inf_mantencion/prog_anual_rep_"+ano+".xls";
			break;
		case "MANT_SEMANAL":
			Archivo="Archivos/mantencion/programa_mensual/sem"+f.Semana.value+"_"+mes+"_"+ano+".xls";
			break;
		case "DISTRIB_SERV":
			Archivo="Archivos/mantencion/distribuccion/distribuccion_"+ano+".xls";
			break;
		case "PROD_GES":
			Archivo="Archivos/Principal/Prod_gest/"+mes+"."+ano+".xls";
			break;
		case "INF_FUN_REF":
			ano=ano.substring(2);
			Archivo="Archivos/Informed/Inf_Fun_ref/"+dia+"_"+mes+"_"+ano+".txt";
			break;
		case "IND_ECON":
			Archivo="Archivos/Finanzas/Indica_econ/"+mes+"."+ano+".xls";
			break;
		case "RES_GASTO":
			Archivo="Archivos/Finanzas/Res_Gasto/"+mes+"."+ano+".ppt";
			break;
		case "COSTO_UNIT":
			Archivo="Archivos/Finanzas/costo/"+mes+"."+ano+".ppt";
			break;
		case "TEN_FUN":
			Archivo="Archivos/tendencias/fundicion/"+mes+"_"+ano+".xls";
			break;
		case "TEN_RAF":
			Archivo="Archivos/tendencias/refino/"+mes+"."+ano+".xls";
			break;
		case "TEN_REF":
			Archivo="Archivos/tendencias/refineria/"+mes+"."+ano+".xls";
			break;
		case "TEN_PMN":
			Archivo="Archivos/tendencias/metales/"+mes+"."+ano+".xls";
			break;
		case "TEN_ACID":
			Archivo="Archivos/tendencias/acido/"+mes+"."+ano+".xls";
			break;
		case "ISO_9001":
			Archivo="Archivos/mantencion/ISO9002/CUMPLIMIENTO_MES_"+ano+".xls";
			break;
		case "MES1":
			Archivo="Archivos/mantencion/servicios/SERVICIO_MES_"+ano+".xls";
			break;
		case "PROG_ANUAL":
			Archivo="Archivos/mantencion/inf_mantencion/prog_anual_rep_"+ano+".xls";
			break;
		case "MES3":
			Archivo="Archivos/mantencion/inf_mantencion/disp_eq_mes_"+ano+".xls";
			break;
		case "MES5":
			Archivo="Archivos/mantencion/inf_mantencion/ind_costo_mes_"+ano+".xls";
			break;
		case "MES6":
			Archivo="Archivos/mantencion/inf_mantencion/camp_refr_"+ano+".xls";
			break;
		case "MES7":
			Archivo="Archivos/mantencion/inf_mantencion/ind_cons_refrac_mes_"+ano+".xls";
			break;
		case "MES9":
			Archivo="Archivos/mantencion/inf_mantencion/dist_hh_mant_mes_"+ano+".xls";
			break;
		case "MES11":
			Archivo="Archivos/mantencion/inf_mantencion/inc_costo_mes_"+ano+".xls";
			break;
		case "TMF_CTTE":
			Archivo="Archivos/mantencion/inf_mantencion/TMF_CTTE_"+ano+".xls";
			break;
		case "TMF_MFCI":
			Archivo="Archivos/mantencion/inf_mantencion/TMF_MFCI_"+ano+".xls";
			break;
		case "TERM_CTTE":
			Archivo="Archivos/mantencion/termografia/term_CT_"+mes+"_"+ano+".xls";
			break;
		case "TERM_HE":
			Archivo="Archivos/mantencion/termografia/term_HE_"+mes+"_"+ano+".xls";			
			break;
		case "TED_REF_ELEC":
			Archivo="Archivos/tendencias/refineria/"+mes+"."+ano+".xls";			
			break;
	}
	if (Archivo!="")
		window.location=Archivo;
}
</script>
<?php
	//function GrabarAcceso($Tipo)
	//{
		include("conectar.php");
		//$IpUser=$HTTP_SERVER_VARS["REMOTE_ADDR"];
		$IpUser=getenv("REMOTE_ADDR");
		//echo "IpUser:".$IpUser;
		$Fecha=date("Y-m-d h:i:s");
		$Insertar="insert into intranet.acceso_opciones (ip,opcion,fecha,titulo) values('$IpUser','$Tipo','$Fecha','$Titulo')";
		//echo $Insertar;
		mysqli_query($link,$Insertar);
	//}

?>