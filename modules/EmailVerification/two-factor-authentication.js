document.addEventListener("DOMContentLoaded", function () {
    const digitInputs = document.querySelectorAll(".digit-input");
    digitInputs.forEach(function (input, index) {
        input.addEventListener("input", function (e) {
            const currentValue = e.target.value;

            if (currentValue.match(/\d/)) {
                // If a digit is entered, move focus to the next input
                if (index < digitInputs.length - 1) {
                    digitInputs[index + 1].focus();
                }
            }

            // Clear the input if it's not a digit
            e.target.value = currentValue.replace(/\D/g, "");
        });

        input.addEventListener("paste", function (e) {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData("text");

            // Split the pasted content into individual digits
            const digits = pasteData.split("").filter(char => /\d/.test(char));

            // Distribute the digits into input fields
            for (let i = 0; i < digitInputs.length; i++) {
                if (digits.length > 0) {
                    digitInputs[i].value = digits.shift();
                } else {
                    digitInputs[i].value = "";
                }
            }
        });
    });

    function startTimer(duration) {
        var display = document.querySelector('#time')
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }

    window.onload = function () {
        startTimer(60 * 5);
    };
});