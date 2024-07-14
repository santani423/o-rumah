<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="loginForm">
        <input type="text" name="Auth_Email" id="Auth_Email" placeholder="Email"><br>
        <input type="password" name="Auth_Pass" id="Auth_Pass" placeholder="Password"><br>
        <button type="button" onclick="login()">Login</button>
    </form>

    <script>
        function login() {
            var email = $('#Auth_Email').val();
            var password = $('#Auth_Pass').val();

            // Validasi input
            if (email === "" || password === "") {
                alert('Email dan password harus diisi.');
                return;
            }

            $.ajax({
                url:"https://member.o-rumah.com/auth_get.php?Auth_Email="+email+"&Auth_Pass="+password ,
                type: 'GET',  
                success: function(response) {
                    // Handle response dari server
                    alert('Login berhasil');
                    window.location.href = `{{ route('listing.index') }}`; // Redirect ke halaman listing
                },
                error: function(xhr, status, error) {
                    // Handle error login kedua
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText;
                    alert('Login kedua gagal: ' + errorMessage);
                }
            });
        }
    </script>
</body>
</html>
