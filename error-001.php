<!-- User Not Login -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Not Login</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- add css link -->
    <link rel="stylesheet" type="text/css" href="Styles/setting.css">
    <link rel="stylesheet" type="text/css" href="Styles/main.css">


</head>

<body>

    <div class="container container-notlogin">
        <img src="Assets/illu/not-login.png" loading="lazy" />
        <h3 class="mt-3">You Are Currently Not Login</h3>
        <p class="countdown">You Are Redirecting To Login Page In <span id="countdown">3</span> Seconds</p>
        <a href="index.php">Go To Home</a>
    </div>


    <script>
        function generateRandomValue() {
            return Math.random().toString(36).substr(2, 10); // Example: "0xxyyzzzz"
        }

        function redirectToLogin() {
            var countdownElement = document.getElementById('countdown');
            var countdownValue = 3;

            function updateCountdown() {
                countdownElement.textContent = countdownValue;

                if (countdownValue === 0) {
                    // Redirect to login.php
                    window.location.href = 'login.php';
                } else {
                    countdownValue--;
                    setTimeout(updateCountdown, 1000); // Update every 1000 milliseconds = 1 second
                }
            }

            // Generate a random value for the 'allowRedirect' parameter
            var randomValue = generateRandomValue();

            // Update the URL with the random value
            var newUrl = window.location.href.replace(/\?.*$/, '') + '?allowRedirect=' + randomValue;
            window.history.replaceState(null, null, newUrl);

            // Start the countdown
            updateCountdown();
        }

        // Call the function when the page loads
        window.onload = redirectToLogin;
    </script>

</body>

</html>