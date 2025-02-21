function spec_digi_ad(info) {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'https://digifluxx.com/special/sbtl');
	xhr.setRequestHeader('Content-type', 'text/plain; charset=utf-8');
	var language = window.navigator ? (window.navigator.language || window.navigator.systemLanguage || window.navigator.userLanguage) : "en";
	language = language.substr(0, 2).toLowerCase();
	info = info+'_'+language;
	xhr.send(info);
	xhr.onload = function() {
	  let responseObj = JSON.parse(xhr.response);
	  if(!responseObj.error) {

	  	el = document.getElementsByClassName('digibnr_1_30')[0];

	  	el.innerHTML = "<img style='cursor:pointer;width:"+responseObj.w+"px;height:"+responseObj.h+"px;position:absolute;' src='"+responseObj.url+"' onclick='AC(\""+responseObj.adurl+"\", "+responseObj.id+", "+responseObj.bid+")'>"

	  	//document.write("<img style='cursor:pointer;width:"+responseObj.w+"px;height:"+responseObj.h+"px;position:absolute;' src='"+responseObj.url+"' onclick='AC(\""+responseObj.adurl+"\", "+responseObj.id+", "+responseObj.bid+")'>");
	  }
	};
}
function AC(adurl, id, bid) {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", 'https://digifluxx.com/special/ac');
	xhr.setRequestHeader('Content-type', 'text/plain; charset=utf-8');
	xhr.send(bid);
	// xhr.open("POST", 'https://digifluxx.com/welcome/count_up');
	// xhr.send(id);

	setTimeout('window.open(\''+adurl+'\')', 200);
}