function textCounter (field, countfield, maxlimit) {
	if (field.value.length > maxlimit) field.value = field.value.substring(0, maxlimit);
	else countfield.value = maxlimit - field.value.length;
}
function windowOpen (p, w, h) {
	if(screen.width) { var winl = (screen.width-w)/6; var wint = (screen.height-h)/7; } else { winl = 0;wint =0; }
	if (winl < 0) winl = 0;
	if (wint < 0) wint = 0;
	var settings = 'height=' + h + ','; settings += 'width=' + w + ','; settings += 'top=' + wint + ','; settings += 'left=' + winl + ',';settings += ' scrollbars=yes ';
	var n = ''; win = window.open(p,n,settings); win.window.focus();
}
function confirmDelete(msg){
	if (!msg) {msg="Are you sure?"} var agree=confirm(msg); if (agree) return true ; else return false;
}