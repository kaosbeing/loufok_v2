document.addEventListener("DOMContentLoaded", function () {
	function renameKey(obj, oldKey, newKey) {
		obj[newKey] = obj[oldKey];
		delete obj[oldKey];
		return obj;
	}
	function datePlus(obj, key) {
		date = new Date(obj[key]);
		date.setDate(date.getDate() + 1);
		obj[key] = date.toISOString().split("T")[0];
		return obj;
	}
	function addKeyValue(obj, key, value) {
		obj[key] = value;
		return obj;
	}
	let firstLoufokerieStartDate = new Date();
	const calendarEl = document.getElementById("calendar");
	const tooltipContainer = document.getElementById("tooltip-container");
	if (periodes_JSON != null) {
		periodes_JSON.forEach((obj) => {
			renameKey(obj, "titre_loufokerie", "title");
			renameKey(obj, "date_debut_loufokerie", "start");
			renameKey(obj, "date_fin_loufokerie", "end");
			addKeyValue(obj, "color", " var(--primary)");
			addKeyValue(obj, "display", "background");
			addKeyValue(obj, "allDay", "true");
			datePlus(obj, "end");
		});
		firstLoufokerieStartDate = periodes_JSON.reduce((minDate, loufokerie) => {
			const startDate = new Date(loufokerie.start);
			const startOfMonth = new Date(
				startDate.getFullYear(),
				startDate.getMonth(),
				1
			);
			return startOfMonth < minDate ? startOfMonth : minDate;
		}, new Date());
	} else {
		periodes_JSON = [];
	}

	const formattedStartDate = firstLoufokerieStartDate
		.toISOString()
		.split("T")[0];
	let calendar = new FullCalendar.Calendar(calendarEl, {
		events: periodes_JSON,
		buttonText: {
			today: "Aujourd'hui",
		},
		locale: "fr",
		height: "auto",
		validRange: {
			start: formattedStartDate,
		},
		eventClick: function (info) {
			// Toggle Tooltip
			if (tooltipContainer.style.display === "none") {
				tooltipContainer.innerHTML = info.event.title;
				tooltipContainer.style.left = info.jsEvent.pageX + "px";
				tooltipContainer.style.top = info.jsEvent.pageY + "px";
				tooltipContainer.style.display = "block";
			} else {
				tooltipContainer.style.display = "none";
			}
		},
	});

	// Initial setup
	calendar.render();

	document.addEventListener("click", function (event) {
		const isClickInsideCalendarEvent = event.target.closest(".fc-event");

		// If the click is inside a calendar event, do nothing
		if (isClickInsideCalendarEvent) {
			return;
		}

		// If not, hide the tooltip
		tooltipContainer.style.display = "none";
	});
});
