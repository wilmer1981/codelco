<? 
include('conectar_ori.php');
include('funciones/siper_funciones.php');

	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "G":
			$BuscarCPARENT=ObtenerCodParent($SelTarea);
			$CPARENTAUX=$BuscarCPARENT.",";
			$CPARENTAUX=str_replace($CPARENTAUX,'',$SelTarea);
			
			//ARBOL ORIGEN
			$Consulta="SELECT * from sgrs_areaorg where CPARENT='".$Navega."'";
			$RespTipo=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($RespTipo))
				$NAREA=$Fila[NAREA];//NOMBRE DE EL AREA QUE SE KIERE MOVER				
			$Consulta="SELECT * from sgrs_organica where CORGANICA='".$Nivel."'";
			$RespTipo=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($RespTipo))
				$ORGAAREA=$Fila[NORGANICA];//NOMBRE DE LA DESCIPCION

			$Consulta="SELECT CAREA,CPARENT,NAREA,CTAREA from sgrs_areaorg where MVIGENTE='1' and (CPARENT like '".$SelTarea."%' or  CAREA='".$BuscarCPARENT."') order by CTAREA,CAREA";
			//echo $Consulta."<BR><br>";
			$Respuesta=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Respuesta))
			{
				$NuevoCPARENT=str_replace($CPARENTAUX,$SelTarea2,$Fila[CPARENT]);
				//echo $Fila[CPARENT]." ".$Fila[NAREA]." ".$Fila[CTAREA]."<br>";
				$Actualizar="UPDATE sgrs_areaorg set CPARENT='".$NuevoCPARENT."' where CAREA='".$Fila[CAREA]."'";
				mysql_query($Actualizar);
				//echo $Actualizar."<br>"; 
			}
				
			//ARBOL DESTINO
			$Consulta="SELECT * from sgrs_areaorg where CPARENT='".$Navega2."'";
			$RespTipo=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($RespTipo))
				$NAREA2=$Fila[NAREA];//NOMBRE DE EL AREA DONDE SE MUEVE		
			$Consulta="SELECT * from sgrs_organica where CORGANICA='".$Nivel2."'";
			$RespTipo=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($RespTipo))
				$ORGAAREA2=$Fila[NORGANICA];//NOMBRE DE LA DESCIPCION

			OrigenOrg($Navega,&$Ruta);//ORIGEN ARBOL 1
			OrigenOrg($SelTarea2,&$Ruta2);//ORIGEN ARBOL 2
			$Obs="Se a movido Nivel ".$ORGAAREA." de Nombre: ".$NAREA.", desde ruta: ".$Ruta." a Nivel ".$ORGAAREA2." ruta: ".$Ruta2."";
			//echo 	$ObsEli."<br>";
			//echo $Obs."<br>";
			InsertaHistorico($CookieRut,'4',$Obs,$ObsEli,'','');//MODIFICA ORGANICA ITEM
			
			$Mensaje='Proceso Terminado Exitosamente';
			$Nivel=$Nivel2;
			$Navega=$Navega2;
			$Estado=$Estado2;
			$SelTarea=$BuscarCPARENT;
			header("location:proceso_mant_organica_mover.php?MostrarMensaje=S&Mensaje=".$Mensaje."&Nivel=".$Nivel2."&Navega=".$Navega2."&Estado=".$Estado2."&SelTarea=".$SelTarea2."&Nivel2=".$Nivel2."&Navega2=".$Navega2."&Estado2=".$Estado2."&SelTarea2=".$SelTarea2);
		break;

	}
?>
