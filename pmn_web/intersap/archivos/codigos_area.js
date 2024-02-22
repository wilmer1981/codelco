<!--
var codigos_regiones = Array("02", "32", "33", "34" ,"35", "41", "42", "43", "45", "51", "52", "53", "55", "57", "58", "61", "63", "64", "65", "67", "71", "72", "73", "75", "09", "08");

//** Codigos Area **//
		for(i=0;i<codigos_regiones.length;i++){
			if (i==0){
				document.write('					<option value="' + codigos_regiones[i] + '" selected>' + codigos_regiones[i] + '</option>');
			}else{
				document.write('					<option value="' + codigos_regiones[i] + '">' + codigos_regiones[i] + '</option>');
			}
		}
//** Codigos Area **//
//-->