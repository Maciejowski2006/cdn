document.querySelector('input').onchange = function () {
	const filepath = this.value;

	const file = filepath.split("\\");

	document.querySelector("[filename]").innerHTML = `Selected file: ${file[file.length - 1]}`;
};