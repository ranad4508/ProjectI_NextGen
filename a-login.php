<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log In</title>
    <link rel="stylesheet" href="login.css">
    <script src="../Validations/script.js"></script>
    <script src="https://kit.fontawesome.com/c4254e24a8.js" crossorigin="anonymous"></script>
    <style>
        .back_home a {
            text-decoration: none;
        }

        .back_home {
            margin-top: 20px;
        }

        .back_home i {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="form-top" id="a-login">
        <form action="#" method="POST">
            <div class="top-name">
                <h2>Admin Log In</h2>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" placeholder="Enter Email" name="email" id="email">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" name="pass" id="pass">
                <span class="eye" onclick="pass_hidden()">
                    <i id="eye1" class="fa-solid fa-eye"></i>
                    <i id="eye2" class="fa-solid fa-eye-slash"></i>
                </span>

            </div>
            <input type="checkbox" name="remember" value="remember"> Remember Me
            <small id="statusAdminLogMsg"></small>
            <input type="submit" name="submit" id="submit" value="Log In" onclick="checkAdminLogin()">
            <div class="back_home">
                <a href="./index.php"><i class="fa-solid fa-house"></i>Back Home</a>
            </div>
            <span id="error-login">
                <?php
                include("a-Log.php");
                ?>
            </span>

        </form>
    </div>

    <script>
        function pass_hidden() {
            var x = document.getElementById('pass');
            var y = document.getElementById('eye1');
            var z = document.getElementById('eye2');

            if (x.type == "password") {
                x.type = "text";
                y.style.display = "block";
                z.style.display = "none";

            } else {
                x.type = "password";
                y.style.display = "none";
                z.style.display = "block";
            }
        }
    </script>
</body>

</html>