window.addEventListener("DOMContentLoaded", () => {
	cont form = document.querySelector('.form');
	const contrib = document.querySelector(".form__textarea");

	// Create a span element, position absolute into the form textarea
	let lengthIndicator = document.createElement('span');
	lengthIndicator.style.fontSize = "0.8rem";
	lengthIndicator.style.position = "absolute";
	lengthIndicator.style.right = "0.25rem";
	lengthIndicator.style.textAlign = "right";
	lengthIndicator.style.top = "50%";
	lengthIndicator.style.transform = "translateY(-50%)";

	if (contrib != null) {
		contrib.parentNode.appendChild(lengthIndicator); // Appends the 
		contrib.addEventListener('input', () => {
			nbCharac = contrib.value.length;

			if (nbCharac < 50) {
				lengthIndicator.innerText = nbCharac - 50;
				lengthIndicator.style.color = "red";
			} else {
				lengthIndicator.innerText = 280 - nbCharac;

				if (nbCharac > 280) {
					lengthIndicator.style.color = "red";
				} else {
					lengthIndicator.style.color = "";
				}
			}

			autoResize();
		})

		form.addEventListener("submit", (e) => {
			if (contrib.value.length < 50) {
				e.preventDefault();
				alert("La contribution est trop courte !");
			}

			if (contrib.value.length > 280) {
				e.preventDefault();
				alert("La contribution est trop longue !");
			}
		})
	}

	function autoResize() {
		contrib.style.height = "auto"; // Reset the height to auto to determine the natural height
		contrib.style.height = (contrib.scrollHeight) + "px"; // Set the height to match the content height
	}
});
