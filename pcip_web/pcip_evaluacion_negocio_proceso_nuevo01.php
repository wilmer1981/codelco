<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opc)
{
	case "GI":
			if($Opcion=='NREC')
			{
				$CodClase='31038';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";				
			}
			if($Opcion=='NCAR')
			{
				$CodClase='31039';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";
			}
			if($Opcion=='NCAS')
			{
				$CodClase='31040';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";
			}
			if($Opcion=='NDES')
			{
				$CodClase='31036';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";
			}
			if($Opcion=='NLEY')
			{
				$CodClase='31037';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";		
			}
			if($Opcion=='NPREM')
			{
				$CodClase='31052';
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";		
			}
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);		
			if(!$Fila=mysql_fetch_array($Resp))
			{
			    if($Valor1=='')
					$Valor1='';
			    if($Valor2=='')
					$Valor2=0;
			    if($Valor3=='')
					$Valor3=0;
			    if($Valor4=='')
					$Valor4=0;
			    if($Valor5=='')
					$Valor5=0;
			    if($Valor6=='')
					$Valor6=0;
			    if($Valor7=='')
					$Valor7=0;
				$Insertar="insert into proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3,valor_subclase4,valor_subclase5,valor_subclase6,valor_subclase7) values ";
				$Insertar.="('".$CodClase."','".$TxtCodigo."','".strtoupper($TxtNuevo)."','".$Valor1."','".$Valor2."','".$Valor3."','".$Valor4."','".$Valor5."','".$Valor6."','".$Valor7."')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
				$Mensaje='Registro Guardado Exitosamente';	
				if($CodClase=='31038')
					$Opcion=='NREC';
				if($CodClase=='31039')
					$Opcion=='NCAR';
				if($CodClase=='31040')
					$Opcion=='NCAS';
				if($CodClase=='31036')
					$Opcion=='NDES';
				if($CodClase=='31037')
					$Opcion=='NLEY';
				if($CodClase=='31052')
					$Opcion=='NPREM';
			}
			else
				$Mensaje='Este Registro Existe';
			header('location:pcip_evaluacion_negocio_proceso_nuevo.php?Opc=GI&Mensaje='.$Mensaje.'&Opcion='.$Opcion.'&Ptl='.$Ptl.'&ProcesoAbierto='.$ProcesoAbierto);
	break;
	case "MI":
			$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and nombre_subclase='".$TxtNuevo."'";		
			$Resp=mysqli_query($link, $Consulta);		
			if($Fila=mysql_fetch_array($Resp))
				$Valor1=$Fila["valor_subclase1"];$Valor2=$Fila["valor_subclase2"];$Valor3=$Fila[valor_subclase3];	
				$Valor4=$Fila[valor_subclase4];$Valor5=$Fila[valor_subclase5];$Valor6=$Fila[valor_subclase6];				
				$Valor7=$Fila[valor_subclase7];
				//echo $Valor1."<br>";
	
			if($Valor1=='')
				$Valor1='';
			if($Valor2==0)
				$Valor2=0;
			if($Valor3==0)
				$Valor3=0;
			if($Valor4==0)
				$Valor4=0;
			if($Valor5==0)
				$Valor5=0;
			if($Valor6==0)
				$Valor6=0;
			if($Valor7==0)
				$Valor7=0;
			$Actualizar="UPDATE proyecto_modernizacion.sub_clase set nombre_subclase='".strtoupper($TxtNuevo)."', valor_subclase1='".$Valor1."',";
			$Actualizar.=" valor_subclase2='".$Valor2."', valor_subclase3='".$Valor3."', valor_subclase4='".$Valor4."', valor_subclase5='".$Valor5."', valor_subclase6='".$Valor6."', valor_subclase7='".$Valor7."' ";
			$Actualizar.=" where cod_clase='".$CodClase."' and cod_subclase='".$Cod."'";
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Mensaje='Registro Modificado Exitosamente';
			if($CodClase=='31038')
				$Opcion=='NREC';
			if($CodClase=='31039')
				$Opcion=='NCAR';
			if($CodClase=='31040')
				$Opcion=='NCAS';
			if($CodClase=='31036')
				$Opcion=='NDES';
			if($CodClase=='31037')
				$Opcion=='NLEY';
			if($CodClase=='31052')
				$Opcion=='NPREM';
			header('location:pcip_evaluacion_negocio_proceso_nuevo.php?Opc=GI&Mensaje='.$Mensaje.'&Opcion='.$Opcion.'&Ptl='.$Ptl.'&ProcesoAbierto='.$ProcesoAbierto);
	break;
	case "E":
			$Eliminar="delete from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and cod_subclase='".$Cod."'";	
			//echo $Eliminar."<br>";
			mysql_query($Eliminar);
			if($CodClase=='31038')
				$Opcion=='NREC';
			if($CodClase=='31039')
				$Opcion=='NCAR';
			if($CodClase=='31040')
				$Opcion=='NCAS';
			if($CodClase=='31036')
				$Opcion=='NDES';
			if($CodClase=='31037')
				$Opcion=='NLEY';
			if($CodClase=='31052')
				$Opcion=='NPREM';
			$Mensaje='Registro Eliminado Exitosamente';
			header("location:pcip_evaluacion_negocio_proceso_nuevo.php?Mensaje=".$Mensaje.'&Opcion='.$Opcion.'&Ptl='.$Ptl.'&ProcesoAbierto='.$ProcesoAbierto);
	break;
}

?>