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
        let [hour, minute, ampm] = time.match(/(\d+):(\d+) (\w+)/).slice(1);
        hour = parseInt(hour);
        if (ampm === "PM" && hour !== 12) hour += 12;
        if (ampm === "AM" && hour === 12) hour = 0;
        return hour * 60 + parseInt(minute);
    }

    function isTimeDisabled(date, time) {
        let formattedDate = formatDateToYYYYMMDD(date);
        if (disabledTimes[formattedDate]) {
            return disabledTimes[formattedDate].some((range) => {
                let startMinutes = convertToMinutes(range[0]);
                let endMinutes = convertToMinutes(range[1]);
                let selectedMinutes = convertToMinutes(time);
                return (
                    selectedMinutes >= startMinutes &&
                    selectedMinutes <= endMinutes
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

    let picker = flatpickr("#datessssss", {
        mode: "range",
        enableTime: true,
        dateFormat: "Y-m-d h:i K", // Ensure it includes year, month, and day
        minDate: "today",
        time_24hr: false,
        minuteIncrement: 30,
        minTime: "08:00", // Default min time
        maxTime: "22:00", // Default max time
        disable: getDisabledDates(), // Fully booked days are disabled
        onDayCreate: function (dObj, dStr, fp, dayElem) {
            let dateStr = formatDateToYYYYMMDD(dayElem.dateObj);

            if (isFullyBooked(dayElem.dateObj)) {
                dayElem.classList.add("fully-booked"); // Fully booked days in black
            } else if (disabledTimes[dateStr]) {
                dayElem.classList.add("booked"); // Partially booked days in red
            }
        },
        onClose: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                let startDate = instance.formatDate(selectedDates[0], "Y-m-d");
                let startTime = instance.formatDate(selectedDates[0], "h:i K");
                let endDate = instance.formatDate(selectedDates[1], "Y-m-d");
                let endTime = instance.formatDate(selectedDates[1], "h:i K");

                // Check if selected times are within blocked periods
                if (
                    isTimeDisabled(selectedDates[0], startTime) ||
                    isTimeDisabled(selectedDates[1], endTime)
                ) {
                    alert(
                        "Selected time includes reserved periods. Please choose another time."
                    );
                    picker.clear();
                    document.getElementById("start_time_display").value = "";
                    document.getElementById("end_time_display").value = "";
                } else {
                    document.getElementById("start_time_display").value =
                        startDate + " " + startTime;
                    document.getElementById("end_time_display").value =
                        endDate + " " + endTime;
                }
            }
        },
    });

    document
        .getElementById("start_time_display")
        .addEventListener("click", function () {
            picker.open();
        });

    document
        .getElementById("end_time_display")
        .addEventListener("click", function () {
            picker.open();
        });
});
