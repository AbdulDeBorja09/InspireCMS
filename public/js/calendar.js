// Declare disabledTimes globally as an empty object
let disabledTimes = {};

// ---------------- Utility Functions ----------------

function formatDateToYYYYMMDD(date) {
    return (
        date.getFullYear() +
        "-" +
        String(date.getMonth() + 1).padStart(2, "0") +
        "-" +
        String(date.getDate()).padStart(2, "0")
    );
}

function convertToMinutes(time) {
    // Matches time formats like "08:00 AM" or "12:30 PM"
    let match = time.match(/(\d+):(\d+)(?: (\w+))?/);
    if (!match) return null;
    let [hour, minute, ampm] = match.slice(1);
    hour = parseInt(hour);
    minute = parseInt(minute);
    if (!ampm) ampm = "AM";
    if (ampm === "PM" && hour !== 12) hour += 12;
    if (ampm === "AM" && hour === 12) hour = 0;
    return hour * 60 + minute;
}

// Overlap check: returns true if the selected time overlaps any blocked range.
function isTimeDisabled(date, startTime, endTime) {
    let formattedDate = formatDateToYYYYMMDD(date);
    if (!disabledTimes[formattedDate]) return false;

    let selectedStart = convertToMinutes(startTime);
    let selectedEnd = convertToMinutes(endTime);

    return disabledTimes[formattedDate].some((range) => {
        let rangeStart = convertToMinutes(range[0]);
        let rangeEnd = convertToMinutes(range[1]);
        // There is an overlap if the selected start is before the range's end and
        // the selected end is after the range's start.
        return selectedStart < rangeEnd && selectedEnd > rangeStart;
    });
}

// ---------------- Process API Blocked Dates ----------------
// This function splits multi-day blocked ranges into daily blocks.
function processBlockedDates(apiBlockedDates) {
    disabledTimes = {}; // Clear previous data

    apiBlockedDates.forEach(function (dateObj) {
        // Parse the API dates (assumed format: "YYYY-MM-DD HH:mm:ss")
        let start = moment(dateObj.start_date, "YYYY-MM-DD HH:mm:ss");
        let end = moment(dateObj.end_date, "YYYY-MM-DD HH:mm:ss");

        // If the end is before start, log a warning and skip
        if (end.isBefore(start)) {
            console.warn("Invalid blocked range:", dateObj);
            return;
        }

        // Loop through each day in the range (inclusive)
        let current = start.clone();
        while (current.isSameOrBefore(end, "day")) {
            let dateKey = current.format("YYYY-MM-DD");
            let startTimeStr, endTimeStr;

            if (current.isSame(start, "day") && current.isSame(end, "day")) {
                // Single-day block: use the provided times.
                startTimeStr = start.format("hh:mm A");
                endTimeStr = end.format("hh:mm A");
            } else if (current.isSame(start, "day")) {
                // First day of a multi-day block: from the start time to the end of booking window.
                startTimeStr = start.format("hh:mm A");
                endTimeStr = "10:00 PM"; // Adjust if needed.
            } else if (current.isSame(end, "day")) {
                // Last day of a multi-day block: from the beginning of booking window to the end time.
                startTimeStr = "08:00 AM"; // Adjust if needed.
                endTimeStr = end.format("hh:mm A");
            } else {
                // Full day block
                startTimeStr = "08:00 AM";
                endTimeStr = "10:00 PM";
            }

            if (disabledTimes[dateKey]) {
                disabledTimes[dateKey].push([startTimeStr, endTimeStr]);
            } else {
                disabledTimes[dateKey] = [[startTimeStr, endTimeStr]];
            }
            current.add(1, "day");
        }
    });
}

// ---------------- Flatpickr Setup ----------------

let datePicker = flatpickr("#start_date", {
    dateFormat: "Y-m-d",
    minDate: "today",
    disable: [], // Will update once API data is processed.
});

let startTimePicker = flatpickr("#start_time", {
    noCalendar: true,
    enableTime: true,
    time_24hr: false,
    minuteIncrement: 30,
    minTime: "08:00",
    maxTime: "22:00",
    onClose: function (selectedDates, dateStr, instance) {
        let startDate = document.getElementById("start_date").value;
        let startTime = dateStr;
        let endTime = document.getElementById("end_time").value;
        if (
            startDate &&
            endTime &&
            isTimeDisabled(new Date(startDate), startTime, endTime)
        ) {
            alert(
                "Selected time overlaps with reserved periods. Please choose another time."
            );
            instance.clear();
            document.getElementById("start_time").value = "";
        } else {
            document.getElementById("start_time").value = startTime;
        }
    },
});

let endTimePicker = flatpickr("#end_time", {
    noCalendar: true,
    enableTime: true,
    time_24hr: false,
    minuteIncrement: 30,
    minTime: "08:00",
    maxTime: "22:00",
    onClose: function (selectedDates, dateStr, instance) {
        let startDate = document.getElementById("start_date").value;
        let endTime = dateStr;
        let startTime = document.getElementById("start_time").value;
        if (!startDate) {
            alert("Please select the start date first.");
            instance.clear();
            document.getElementById("end_time").value = "";
        } else {
            if (isTimeDisabled(new Date(startDate), startTime, endTime)) {
                alert(
                    "Selected time overlaps with reserved periods. Please choose another time."
                );
                instance.clear();
                document.getElementById("end_time").value = "";
            } else {
                document.getElementById("end_time").value = endTime;
            }
        }
    },
});

document.getElementById("start_date").addEventListener("click", function () {
    datePicker.open();
});

document.getElementById("start_time").addEventListener("click", function () {
    startTimePicker.open();
});

document.getElementById("end_time").addEventListener("click", function () {
    endTimePicker.open();
});

// ---------------- Form Validation ----------------

window.validateForm = function () {
    let startDate = document.getElementById("start_date").value;
    let startTime = document.getElementById("start_time").value;
    let endTime = document.getElementById("end_time").value;

    if (!startDate || !startTime || !endTime) {
        alert("Please fill out all required fields.");
        return false;
    }

    let startDateTime = new Date(`${startDate} ${startTime}`);
    let endDateTime = new Date(`${startDate} ${endTime}`);
    let timeDifference = (endDateTime - startDateTime) / (1000 * 60);

    if (timeDifference < 60) {
        alert(
            "The minimum duration between start and end time must be 1 hour."
        );
        return false;
    }

    if (isTimeDisabled(new Date(startDate), startTime, endTime)) {
        alert(
            "Selected time overlaps with reserved periods. Please choose another time."
        );
        return false;
    }

    return true;
};

// ---------------- Confirm Button Handling ----------------

// ---------------- Calendar Initialization ----------------

function initializeCalendar(blockedDates) {
    var calendarEl = document.getElementById("View_calendar");
    if (!calendarEl) {
        console.error("Error: Calendar element not found!");
        return;
    }

    // Destroy existing calendar instance if it exists
    if (calendarEl._calendar) {
        calendarEl._calendar.destroy();
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        events: blockedDates.map((date) => {
            return {
                title: `(${moment(date.start_date).format(
                    "hh:mm A"
                )}) - (${moment(date.end_date).format("hh:mm A")})`,
                start: moment(date.start_date).toISOString(),
                end: moment(date.end_date).toISOString(),
                color: "#064e3b",
                backgroundColor: "#122444",
                allDay: false,
            };
        }),
        eventDidMount: function (info) {
            info.el.style.whiteSpace = "normal";
            info.el.style.display = "block";
        },
        eventContent: function (arg) {
            return { html: arg.event.title };
        },
    });

    calendarEl._calendar = calendar;
    calendar.render();
}

// ---------------- AJAX Call to Fetch Blocked Dates ----------------

function ViewCalendar(Item) {
    $.ajax({
        url: "/User/Request/Dates/api", // API endpoint
        type: "GET",
        data: { id: Item.id }, // Pass the service ID or identifier
        dataType: "json",
        success: function (response) {
            console.log("Response Data:", response);
            if (Array.isArray(response.blocked_dates)) {
                // Process the API data and update disabledTimes accordingly.
                processBlockedDates(response.blocked_dates);

                // Update the date picker's disabled dates.
                let newDisabledDates = Object.keys(disabledTimes).filter(
                    (date) => {
                        // Disable dates that are fully booked (i.e. at least one block covers full window)
                        return disabledTimes[date].some(
                            (range) =>
                                convertToMinutes(range[0]) ===
                                    convertToMinutes("08:00 AM") &&
                                convertToMinutes(range[1]) ===
                                    convertToMinutes("10:00 PM")
                        );
                    }
                );
                datePicker.set("disable", newDisabledDates);

                // Update the calendar.
                initializeCalendar(response.blocked_dates);
            } else {
                console.warn(
                    "Blocked dates not an array:",
                    response.blocked_dates
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching blocked dates:", error);
        },
    });

    // Show the modal (if using Bootstrap modal)
    let modal = new bootstrap.Modal(document.getElementById("staticBackdrop"));
    modal.show();
}
