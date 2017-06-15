function setCurrentDate() {
	var d = new Date();
	var year = d.getFullYear();
	var month = ("0" + (d.getMonth() + 1)).slice(-2);
	var day = ("0" + d.getDate()).slice(-2);
	var date = year + "-" + month + "-" + day;
	delete d;
	
	document.getElementsByName("date")[0].value = date;
}

function setCurrentTime() {
	var d = new Date();
	var hour = ("0" + d.getHours()).slice(-2);
	var minute = ("0" + d.getMinutes()).slice(-2);
	var time = hour + ":" + minute;
	delete d;
	
	document.getElementsByName("time")[0].value = time;
	return;
}

function setDateAndTime() {
	setCurrentDate();
	setCurrentTime();
}

function validateKey(AEvent, inputField)
{
	if (window.Event) {
			kodKlawisza = AEvent.which;
	} else {
			kodKlawisza = AEvent.keyCode;
	}

	if (kodKlawisza == 13) {
			return true;  // Enter
	};

	if (kodKlawisza == 0 || kodKlawisza == 8) {
			return true;  // klawisze sterujące & delete/backspace
	};

	klawisz = String.fromCharCode(kodKlawisza);

	length = inputField.value.length;
	
	if (inputField.name == "date") {
		if (length == 4 || length == 7)
			mask = "-";
		else if (length >= 10)
			mask = "";
		else
			mask = "0123456789";
	} else if (inputField.name == "time") {
		if (length == 2)
			mask = ":";
		else if (length >= 5)
			mask = "";
		else
			mask = "0123456789";
	}
	
	if (mask.indexOf(klawisz) == -1) {
			return false;
	} else {
			return true;
	}
}

//input YYYY-MM-DD
function isValidDate(dateString) {
	if (dateString.length != 10)
		return false;
	
  var bits = dateString.split('-');
  var d = new Date(bits[0], bits[1] - 1, bits[2]);
  return d.getFullYear() == bits[0] && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[2]);
}

//input HH:MM
function isValidTime(timeString) {
	if (timeString.length != 5)
		return false;
	
	var bits = timeString.split(':');
  var d = new Date(0, 0, 0, bits[0], bits[1] - 1);
  return d.getHours() == bits[0] && (d.getMinutes() + 1) == bits[1];
}

function checkForm() {
	if (!isValidDate(document.getElementsByName("date")[0].value)) {
		alert("Błędna data");
		setCurrentDate();
		return false;
	}
	if (!isValidTime(document.getElementsByName("time")[0].value)) {
		alert("Błędny czas");
		setCurrentTime();
		return false;
	}
	
	return true;
}

function addFileButton() {
	var container = document.getElementById("files");
	childCount = container.children.length;
	buttonCount = (childCount + 1) / 2;
	
	for (var i = 1; i < childCount; i += 2) {
		if (container.children[i].value == "")
			return;
	}

	container.appendChild(document.createElement("br"));
	var input = document.createElement("input");
	input.type = "file";
	input.name = "attach" + (buttonCount + 1);
	input.onchange = function() { addFileButton(); };
	container.appendChild(input);
}