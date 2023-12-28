<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index_style.css" />
    <title>OneFamilyHRM</title>
</head>

<body>
    <header class="header-panel">
        <h1>Welcome, Family <span class="auto-type"></span></h1> <!-- type animation-->
    </header>
    <div class="button-container">
        <a href="login.php" class="custom-button">
            <p>Log In</p>
        </a>
        <a href="register.php" class="custom-button">
            <p>Sign Up</p>
        </a>
        <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
        <script>
            var typed = new Typed(".auto-type", {
                strings: ["No. 1", "First", "One", "Support",
                    "Care", "Love", "Safety"],
                typeSpeed: 40,
                backSpeed: 40,
                loop: true
            })
        </script>
    </div>
</body>

</html>