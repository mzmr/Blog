function listStyles() {
	var list = "";
	var styles = findStyles(null);
	
	for (var i = 0; i < styles.length; i++) {
		var title = getStyleTitle(styles[i]);
    list += '<a class="style_item" href="#" onclick="setStyle(\'' + title + '\'); return false;">Styl ' + title + '</a>';
	}
	
	document.getElementsByClassName("menu")[0].innerHTML += list;
}

function setStyle(name) {
	var styles = findStyles(null);
	
	for (var i = 0; i < styles.length; i++) {
		styles[i].disabled = true;

		if (getStyleTitle(styles[i]) == name)
			styles[i].disabled = false;
	}
}

function getStyleTitle(style) {
	return style.getAttribute("title");
}

function findStyles(enabled) {
	var styles = [];
	for (var i = 0; (styl = document.getElementsByTagName("link")[i]); i++) {
		var title = getStyleTitle(styl);
		
		if (title && (enabled === null || styl.disabled == !enabled))
			styles.push(styl);
	}
	
	return styles;
}

function getStyle() {
	var styles = findStyles(true);
	
	if (styles.length > 0)
		return getStyleTitle(styles[0]);
	else
		return null;
}

function createCookie(name, value, days) {
	var date = new Date();
	date.setTime(date.getTime() + (days*24*3600));
	var expires = date.toGMTString();
	document.cookie = name + "=" + value + "; expires=" + expires + "; path=/";
}

function readCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2)
		return parts.pop().split(";").shift();
	else
		return null;
}

function getCookieStyle(e) {
	var style = readCookie("style");
	var styleName = style ? style : getStyle();
	setStyle(styleName);
}

function setCookieStyle(e) {
	var style = getStyle();
	createCookie("style", style, 30);
}

window.onload = getCookieStyle;
window.onunload = setCookieStyle;
getCookieStyle();