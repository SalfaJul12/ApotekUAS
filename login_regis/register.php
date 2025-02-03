<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <title>Form Register</title>
</head>
<body>
        <form method="post" action="register_procced.php">
            <table>   
             <h1>FORM REGISTER</h1>
             <h4></h4>
             <tr>
                 <td><input type="email" name="email" placeholder="Email" required></td>
             </tr>
             <tr>
                <tr>
                    <td><input type="text" name="username" placeholder="Username" required></td>
                </tr>
                <tr>
                    <td><input type="password" name="password" id="pass" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td style="text-align : left"><input type="checkbox" onclick="show()"> Show Password</td>
                </tr>
                <tr>
                
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="register" value="REGISTER">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center; padding-top: 10px;">
                        Kembali Ke <a href="login-form.php">Login</a>
                    </td>
                </tr>
            </table>
        </form>     

    <script>
        function show(){
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>