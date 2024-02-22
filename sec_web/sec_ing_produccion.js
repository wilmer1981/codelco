
function trecords(){
	alert("1");
	
	this.link='';;
	return this
}

trecords.prototype.set=function(link) {
	alert("2");

	this.link=link;
}

trecords.prototype.searchstring=function() { alert("3"); return this.link }

function add(link) {
	alert(link);
	alert("4");

	al=records.length;
	alert("a1:" + al);
	records[al]=new trecords();
	records[al].set(link);
}

records = new Array()

function initPeso() {
	alert("0");
	
	setTimeout("PonerPeso()",100);
}

function PonerPeso() {
	alert("5");

	var f = document.frm1;

	f.txtpeso.value = records[0].searchstring();
	//alert(records[0].searchstring());
	setTimeout("PonerPeso()",1000);
}