// JavaScript Document
function showValue(arg, arg2) {
	//alert("calling show me: arg1 " + arg + " arg2 " +  arg2);
	var s = (arg2 == undefined) ? '' : "<br /><font color='darkgreen'>value:</font> "+ arg2;
	$("#selectedvalue").html("<font color='darkgreen'>label:</font> " + arg +  s);
}

var counter = 1;
function output(msg, id) {
	if(counter>=100) counter = 1;
	var old = $("#output").html();
	var sID = (typeof id == "string") ? id : id.id;
	$("#output").html((counter++)+": id= "+ sID +" : " + msg+"<br />"+old);
}

function disabledcombo(id, disabled) {
	document.getElementById(id).disabled = disabled;
	//custom function
	if(document.getElementById(id).refresh != undefined)
			document.getElementById(id).refresh();
}
var cmbOption = new Object();
cmbOption["0"] = new Array("0");
cmbOption["1"] = new Array("0","1","2","3");
cmbOption["2"] = new Array("0","1","2","3");
cmbOption["3"] = new Array("0","1","2","3","4","5","6","7","8","9","10","11","12","13");
cmbOption["4"] = new Array("0","1","2","3","4");
cmbOption["5"] = new Array("0","1","2","3");
cmbOption["6"] = new Array("0","1","2","3","4","5","6");
cmbOption["7"] = new Array("0","1","2","3","4","5");
cmbOption["8"] = new Array("0","1","2","3","4","5");
cmbOption["9"] = new Array("0","1","2","3","4","5","6","7");
cmbOption["10"] = new Array("0","1","2","3","4");
cmbOption["11"] = new Array("0","1","2","3","4");
cmbOption["12"] = new Array("0","1","2","3","4","5","6","7");
cmbOption["13"] = new Array("0","1","2","3","4","5","6","7","8","9","10");
cmbOption["14"] = new Array("0","1","2","3","4");

function populateCombo(val,id) {
	var targetCombo = 'styleImg';
	document.getElementById(targetCombo).options.length = 0;
	var target_array = cmbOption[val];
		document.getElementById(targetCombo).options['0'] = new Option("No Image","0");
	for(var i=1;i<target_array.length;i++) {
		document.getElementById(targetCombo).options[i] = new Option("<img src=\"/s/"+id+"/"+i+".png\" width=\"90\" height=\"54\">", i);
		//document.getElementById(targetCombo).options[i] = new Option("<img src=\"/s/"+txt.replace(" ","-").toLowerCase()+"/"+i+".png\" width=\"90\" height=\"54\">", i);
		//document.getElementById(targetCombo).options[i].title = "/i/j/dd/enabled.gif";
	}
	document.getElementById(targetCombo).selectedIndex = 0;
		if(document.getElementById(targetCombo).refresh!=undefined)
			document.getElementById(targetCombo).refresh();
}

function txt2URI(str) {
	//encodeURI with clean slug format
}
