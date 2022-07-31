const searchInput = document.querySelector('[search]');

let item;
let title;

let items = [];

function main() {
	item = document.querySelectorAll('.item');
	title = document.querySelectorAll('.item__title');

	for (let i = 0; i < title.length; i++) {
		item[i].classList = "item search";
	}

	for (let i = 0; i < item.length; i++) {
		const tags = item[i].dataset.tags.split(" ");
		const tagSlot = item[i].childNodes[5];
		items.push({
			"item": item[i],
			"title": title[i].innerText,
			"tags": tags,
			"tagSlot": tagSlot
		});
		for (let i = 0; i < tags.length; i++) {
			let tag = document.createElement('div');
			tag.classList = "item__tags-tag";
			tag.innerHTML = `#${tags[i]}`;
			tagSlot.appendChild(tag);
		}
	}

	if (item[0].dataset.tags === "game") {
		item[0].classList = "item search";
	}
}

searchInput.addEventListener('input', (e) => {
	const result = e.target.value.toLowerCase();

	if (result.includes("#")) {
		let trueResult = result.substring(1);

		for (let i = 0; i < items.length; i++) {
			let foundTag = false;

			for (let j = 0; j < items[i].tags.length; j++) {
				if (items[i].tags[j].includes(trueResult)) {
					foundTag = true;
				}
			}
			if (foundTag) {
				items[i].item.classList = "item search";
			}
			else {
				items[i].item.classList = "item";
			}
		}
	}
	else {
		for (let i = 0; i < items.length; i++) {
			if (items[i].title.toLowerCase().includes(result)) {
				items[i].item.classList = "item search";
			}
			else {
				item[i].classList = "item";
			}
		}
	}

	if (result === "") {
		for (let i = 0; i < title.length; i++) {
			item[i].classList = "item search";
		}
	}
});