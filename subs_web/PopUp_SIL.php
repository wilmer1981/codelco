<html>
<head>
	<title>Subsidio de Incapacidad Laboral (S.I.L)</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>

<body>
	  <table width="608" border="1" align="center" cellpadding="2" id="dv" cellspacing="0" class="TablaInterior">
		<tr  class="ColorTabla01"> 
			<td colspan="8">
				<strong>Informaci&oacute;n Del Accidentado</strong>
			</td>
		</tr>
		<tr>					
       	   <td width="124">Rut:</td>
		   <td colspan="3">
				&nbsp;&nbsp;<input name="rut" type="text" id="rut" size="10" align="top" class="InputColor"  readonly maxlength="9" value="<? echo number_format($rut_trab,0,',','.'); ?>"> 
				- 
				<input name="dv" type="text" id="dv" size="1" maxlength="1" align="top" class="InputColor" readonly value="<? echo $rut_trab_dv; ?>">
			</td>
		</tr> 
	</table>

</body>
</html>
