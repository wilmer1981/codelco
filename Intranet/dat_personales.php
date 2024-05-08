
<?	
	include("conectar2.php");
	{
		$Datos=str_replace('**',' ',$Datos);
		$Datos2=explode('~',$Datos);
		$sql="select t1.NOMBRES,t1.APELLIDO_PATERNO, t1.APELLIDO_MATERNO,t1.COD_CARGO,t1.ANEXO,t1.FECHA_NACIMIENTO, t1.COD_CENTRO_COSTO,t2.NOMBRE_CENTRO_COSTO, t2.COD_CENTRO_COSTO,t2.COD_AREA,t3.CODIGO_CARGO,t3.CARGO ";
		$sql.="from bd_rrhh.antecedentes_personales t1 inner join  bd_rrhh.centros t2 on t1.COD_CENTRO_COSTO=t2.COD_CENTRO_COSTO ";
		$sql.="inner join  bd_rrhh.cargo t3 on t1.COD_CARGO=t3.CODIGO_CARGO ";
		$sql.="where NOMBRES ='".$Datos2[0]."' and APELLIDO_PATERNO='".$Datos2[1]."' and APELLIDO_MATERNO='".$Datos2[2]."'";
		$buscando=mysql_query($sql);
		while($row=mysql_fetch_array($buscando))
		{
		  $Nombres=$row["NOMBRES"]." ".$row["APELLIDO_PATERNO"]." ".$row["APELLIDO_MATERNO"];
		  $Cargo=$row["COD_CARGO"]."&nbsp;&nbsp;-&nbsp;&nbsp; ".$row["CARGO"];
		  $Area=$row["COD_AREA"];
		  $CodCCosto=$row["COD_CENTRO_COSTO"]."&nbsp;&nbsp;-&nbsp;&nbsp; ".$row["NOMBRE_CENTRO_COSTO"];	  
		  $Anexo=$row["ANEXO"];	  
		  $FecNac=$row["FECHA_NACIMIENTO"];	  
		 }
	}
	
	
?>
<html>
	<head>
		<title>Documento sin t&iacute;tulo</title>
	</head>

<body background="../images/Fondo.gif">
<p> </p>

<p align="center"><font face size="5"><strong>Antecedentes Personales</strong></font></p>

<hr size="1" width="75%">
<p>
<table align="center" border="0" cellPadding="1" cellSpacing="1" width="95%" background="Cracks.gif">
    <tr>
        <td align="right"><strong>Nombre:</strong></td>
        <td align="left"><strong><? echo $Nombres;?></strong>
</td>
    </tr>
    <tr>
        <td align="right"><strong>Cargo:</strong></td>
        <td><strong><? echo $Cargo;?></strong>
</td>
    </tr>

    <tr>
        <td align="right"><strong>Area:</strong></td>
        <td><strong><? echo $Area;?></strong>

</td>
    </tr>
    <tr>
        <td align="right"><strong>C. 
            Costo:</strong></td>
        <td><strong><? echo $CodCCosto;?></strong>
      
</td>
    </tr>
    <tr>
        <td align="right"><strong>Anexo:</strong></td>
        <td><strong><? echo $Anexo;?></strong>

</td>
    </tr>
    <tr>
        <td align="right"><strong>FechaCumpleaños:</strong></td>
		<td><em><strong><? echo $FecNac;?></strong></em>
	</td>
        <td>


</td></tr></table></p>
<hr size="1" width="75%">

<p>&nbsp;
<center><a href="cumple.php">Volver</a></center>

</p>

</body>
</html>
