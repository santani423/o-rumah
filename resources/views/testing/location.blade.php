<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocation Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Memuat jQuery -->
</head>

<body>
    <h1>Geolocation Example</h1>
    <button onclick="getLocation()">Detect My Location</button>
    <p id="location"></p>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location").innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            console.log("Latitude:", lat, "Longitude:", long); // Log latitude and longitude
            document.getElementById("location").innerHTML = "Latitude: " + lat + "<br>Longitude----: " + long;

            // Send AJAX request to the server
            $.ajax({
                url: '{{ route('tool.cekJudul') }}',
                type: 'POST',
                data: {
                    latitude: lat,
                    judulIklan: lat,
                    longitude: long
                }
            }).done(function (response) {
                console.log("Response from server:", response); // Log the response
                document.getElementById("location").innerHTML = "Latitude: " + lat + "<br>Longitude---: " + long;
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown); // Log the error
                $('#location').html('Error: Unable to fetch data'); // Display error message
            });


        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById("location").innerHTML = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById("location").innerHTML = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    document.getElementById("location").innerHTML = "The request to get user location timed out.";
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById("location").innerHTML = "An unknown error occurred.";
                    break;
            }
        }

        window.onload = function () {
            getLocation();
        };
    </script>
</body>

</html>