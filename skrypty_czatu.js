function isChatEnabled() {
	return document.getElementById("checkChat").checked;
}

function isDataCorrect() {
	return document.getElementById("name").value && document.getElementById("message").value;
}

function setChatVisible(isVisible) {
	var items = document.getElementsByClassName("chatItem");
	var dis = isVisible ? "" : "none";
	
	for (var i = 0; i < items.length; i++)
		items[i].style.display = dis;
}

function updateChatArea() {
	setChatVisible(isChatEnabled());
			
	document.getElementById("chatArea").innerHTML = "";
	var xmlhttp;
	
	// jesli korzystamy z normalnej przegladarki
	if (window.XMLHttpRequest)
		xmlhttp = new XMLHttpRequest();
	
	//jesli korzystamy z innej
	else
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 3 && xmlhttp.status == 200) {
			if (isChatEnabled())
				document.getElementById("chatArea").innerHTML = xmlhttp.responseText;
		}
		
		if (xmlhttp.readyState == 4) {
			xmlhttp.open("GET", "messages.php", true);
			xmlhttp.send();
		}
	}
	
	xmlhttp.open("GET", "messages.php", true);
	xmlhttp.send();
}

function checkAndSend() {
	if (!isChatEnabled())
		alert('Błąd! Czat nie jest włączony.');
	else if (!isDataCorrect())
		alert('Błąd! Uzupełnij wszystkie dane.');
	else
		send();
}

function send() {
	var xmlhttp;
	
	if (window.XMLHttpRequest)
		xmlhttp = new XMLHttpRequest();
	else
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

	var name = encodeURIComponent(document.getElementById("name").value);
	var msg = encodeURIComponent(document.getElementById("message").value);

	xmlhttp.open("GET", "send.php?name=" + name + "&message=" + msg, true);
	xmlhttp.send();

	document.getElementById("message").value = ""; 
}
