document.addEventListener("DOMContentLoaded", function () {
  function renameKey(obj, oldKey, newKey) {
    obj[newKey] = obj[oldKey];
    delete obj[oldKey];
    return obj;
  }
  function addKeyValue(obj, key, value) {
    obj[key] = value;
    return obj;
  }
  periodes_JSON.forEach((obj) => renameKey(obj, "titre_loufokerie", "title"));
  periodes_JSON.forEach((obj) =>
    renameKey(obj, "date_debut_loufokerie", "start")
  );
  periodes_JSON.forEach((obj) => renameKey(obj, "date_fin_loufokerie", "end"));
  periodes_JSON.forEach((obj) => addKeyValue(obj, "color", " var(--primary)"));
  periodes_JSON.forEach((obj) => addKeyValue(obj, "display", "background"));
  const calendarEl = document.getElementById("calendar");
  const tooltipContainer = document.getElementById("tooltip-container");
  const firstLoufokerieStartDate = periodes_JSON.reduce(
    (minDate, loufokerie) => {
      const startDate = new Date(loufokerie.start);
      return startDate < minDate ? startDate : minDate;
    },
    new Date()
  );
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
