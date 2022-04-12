<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --color-dark: 0, 0, 0;
            --color-white: 255, 255, 255;
            --color-light: 243, 244, 246;
        }

        html {
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            transition: all 300ms ease-in-out;
            background-color: rgba(var(--color-light), 1);
        }

        .dark-mode {
            background-color: rgba(var(--color-dark), 0.9);
            color: rgba(var(--color-light), 1);
        }

        .wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
        }

        .switch {
            background-color: rgba(var(--color-white), 1);
            width: 50px;
            height: 25px;
            border: 2px solid rgba(var(--color-dark), 0.8);
            border-radius: 15px;
            display: flex;
            align-items: center;
            transition: all 300ms ease-in-out;
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }

        .toggle {
            display: block;
            width: 20px;
            height: 20px;
            background-color: rgba(var(--color-dark), 0.8);
            border-radius: 50%;
            transform: translateX(5px);
            transition: all 300ms ease-in-out;
            position: relative;
            left: -3px;
            color: rgba(var(--color-light), 1);
            font-size: .8rem;
        }

        .fa-solid {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .text-uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1 class="text-uppercase">Welcome Page</h1>
        <label for="mode" class="switch">
            <div class="toggle">
                <i class="fa-solid fa-sun icon"></i>
            </div>
            <input type="checkbox" id="mode" hidden>
        </label>
    </div>


    <script>
        const body = document.querySelector('body')
        const toggle = document.querySelector('.toggle')
        const toggleSwitch = document.querySelector('.switch')
        const toggleMode = document.querySelector('#mode')
        const toggleIcon = document.querySelector(".icon");

        toggleSwitch.addEventListener('click', function() {
            if (toggleMode.checked) {
                toggle.style.transform = 'translateX(28px)'
                toggle.style.backgroundColor = 'rgba(255, 255, 255, 1)'
                toggleSwitch.style.backgroundColor = 'rgba(0, 0, 0, 0.8)'
                body.classList.add('dark-mode')
                toggleIcon.style.color = 'rgba(0, 0, 0, 0.8)';
                toggleIcon.classList.remove("fa-sun");
                toggleIcon.classList.add("fa-moon");
            } else {
                toggle.style.transform = 'translateX(5px)'
                toggle.style.backgroundColor = 'rgba(0, 0, 0, 0.8)'
                toggleSwitch.style.backgroundColor = 'rgba(255, 255, 255, 1)'
                body.classList.remove('dark-mode')
                toggleIcon.style.color = 'rgba(255, 255, 255, 1)';
                toggleIcon.classList.remove("fa-moon");
                toggleIcon.classList.add("fa-sun");
            }
        })
    </script>
</body>

</html>