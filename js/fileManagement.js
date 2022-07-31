const domain = window.location.hostname;

function CopyURL(url) {
	navigator.clipboard.writeText("https://" + domain + "/files/" + url);
}

function OpenURL(url) {
	window.location = "https://" + domain + "/files/" + url;
}