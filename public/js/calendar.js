document.addEventListener("DOMContentLoaded", function () {
    let disabledTimes = {
        "2025-02-25": [["08:00 AM", "12:00 PM"]], // Partially booked
        "2025-02-28": [["08:00 AM", "10:00 PM"]], // Fully booked (whole day)
    };

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
        // Check if time includes AM/PM
        let match = time.match(/(\d+):(\d+)(?: (\w+))?/);
        if (!match) {
            return null; // Return null if the time doesn't match the expected format
        }

        let [hour, minute, ampm] = match.slice(1);
        hour = parseInt(hour);
        minute = parseInt(minute);

        // If no AM/PM is provided, assume AM by default
        if (!ampm) {
            ampm = "AM";
        }

        // Adjust hour based on AM/PM
        if (ampm === "PM" && hour !== 12) hour += 12;
        if (ampm === "AM" && hour === 12) hour = 0;

        return hour * 60 + minute;
    }

    function isTimeDisabled(date, startTime, endTime) {
        let formattedDate = formatDateToYYYYMMDD(date);
        if (disabledTimes[formattedDate]) {
            return disabledTimes[formattedDate].some((range) => {
                let rangeStartMinutes = convertToMinutes(range[0]);
                let rangeEndMinutes = convertToMinutes(range[1]);
                let selectedStartMinutes = convertToMinutes(startTime);
                let selectedEndMinutes = convertToMinutes(endTime);

                // Check if any of the following conditions hold:
                return (
                    (selectedStartMinutes < rangeEndMinutes &&
                        selectedEndMinutes > rangeStartMinutes) ||
                    (selectedStartMinutes >= rangeStartMinutes &&
                        selectedStartMinutes < rangeEndMinutes) ||
                    (selectedEndMinutes > rangeStartMinutes &&
                        selectedEndMinutes <= rangeEndMinutes)
                );
            });
        }
        return false;
    }

    function isFullyBooked(date) {
        let formattedDate = formatDateToYYYYMMDD(date);
        if (disabledTimes[formattedDate]) {
            return disabledTimes[formattedDate].some(
                (range) =>
                    convertToMinutes(range[0]) ===
                        convertToMinutes("08:00 AM") &&
                    convertToMinutes(range[1]) === convertToMinutes("10:00 PM")
            );
        }
        return false;
    }

    function getDisabledDates() {
        return Object.keys(disabledTimes)
            .filter((date) => isFullyBooked(new Date(date)))
            .map((date) => date);
    }

    let datePicker = flatpickr("#start_date", {
        dateFormat: "Y-m-d", // Only date
        minDate: "today",
        disable: getDisabledDates(), // Fully booked days are disabled
    });

    let startTimePicker = flatpickr("#start_time", {
        noCalendar: true, // No calendar, just time picker
        enableTime: true,
        time_24hr: false,
        minuteIncrement: 30,
        minTime: "08:00", // Default min time
        maxTime: "22:00", // Default max time
        onClose: function (selectedDates, dateStr, instance) {
            let startDate = document.getElementById("start_date").value;
            let startTime = dateStr;
            let endTime = document.getElementById("end_time").value;

            // If start and end time overlap with reserved time, show alert
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
        noCalendar: true, // No calendar, just time picker
        enableTime: true,
        time_24hr: false,
        minuteIncrement: 30,
        minTime: "08:00", // Default min time
        maxTime: "22:00", // Default max time
        onClose: function (selectedDates, dateStr, instance) {
            let startDate = document.getElementById("start_date").value;
            let endTime = dateStr;
            let startTime = document.getElementById("start_time").value;

            // If end time is set but no start date or time, show alert
            if (!startDate) {
                alert("Please select the start date first.");
                instance.clear();
                document.getElementById("end_time").value = "";
            } else {
                // If start and end time overlap with reserved time, show alert
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

    document
        .getElementById("start_date")
        .addEventListener("click", function () {
            datePicker.open();
        });

    document
        .getElementById("start_time")
        .addEventListener("click", function () {
            startTimePicker.open();
        });

    document.getElementById("end_time").addEventListener("click", function () {
        endTimePicker.open();
    });

    // Validate the form before submission
    window.validateForm = function () {
        let startDate = document.getElementById("start_date").value;
        let startTime = document.getElementById("start_time").value;
        let endTime = document.getElementById("end_time").value;

        // Check if all required fields are filled
        if (!startDate || !startTime || !endTime) {
            alert("Please fill out all required fields.");
            return false; // Prevent form submission
        }

        // Check if the difference between start and end time is at least 1 hour
        let startDateTime = new Date(`${startDate} ${startTime}`);
        let endDateTime = new Date(`${startDate} ${endTime}`);
        let timeDifference = (endDateTime - startDateTime) / (1000 * 60); // in minutes

        if (timeDifference < 60) {
            alert(
                "The minimum duration between start and end time must be 1 hour."
            );
            return false; // Prevent form submission
        }

        // Check if the selected time overlaps with any reserved dates/times
        if (isTimeDisabled(new Date(startDate), startTime, endTime)) {
            alert(
                "Selected time overlaps with reserved periods. Please choose another time."
            );
            return false; // Prevent form submission
        }

        // If validation passes, allow form submission
        return true;
    };
});
