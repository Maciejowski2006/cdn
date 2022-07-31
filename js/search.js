const searchInput = document.querySelector('[search]');

let item;
let title;
let tags;


function main() {
	item = document.querySelectorAll('.item');
	title = document.querySelectorAll('.item__title');

	for (let i = 0; i < title.length; i++) {
		item[i].classList = "item search";
	}
}

searchInput.addEventListener('input', (e) => {
	const result = e.target.value.toLowerCase();
	
	for (let i = 0; i < title.length; i++) {
		if (title[i].innerText.toLowerCase().includes(result)) {
			item[i].classList = "item search";
		}
		else {
			item[i].classList = "item";
		}
	}
	if (result === "") {
		for (let i = 0; i < title.length; i++) {
			item[i].classList = "item search";
		}
	}
});