<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Love Animation with Image (Responsive)</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
            flex-direction: column;
            padding: 0 20px; /* Add padding for mobile */
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        .image {
            width: 200px; /* Set default width */
            border-radius: 10px; /* Optional rounded corners */
            margin-bottom: 20px;
        }

        .heart {
            font-size: 100px;
            color: red;
            animation: pulse 2s infinite;
            margin-bottom: 20px;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .typing-text {
            font-size: 30px;
            color: #333;
            white-space: nowrap;
            border-right: 2px solid;
            width: fit-content;
            overflow: hidden;
            opacity: 0; /* Hidden initially */
        }

        .text-1, .text-2 {
            opacity: 0;
        }

        /* Typing animation */
        .text-1.show {
            opacity: 1;
            animation: typing 3s steps(17), blink 0.5s step-end infinite alternate;
        }

        .text-2.show {
            opacity: 1;
            animation: typing 3s steps(20) 4s forwards, blink 0.5s step-end infinite alternate 7s;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink {
            50% { border-color: transparent; }
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .heart {
                font-size: 80px; /* Reduce heart size on mobile */
            }

            .image {
                width: 150px; /* Smaller image size on mobile */
            }

            .typing-text {
                font-size: 24px; /* Smaller font size for typing text */
            }
        }

        @media (max-width: 480px) {
            .heart {
                font-size: 60px; /* Further reduce heart size on small screens */
            }

            .image {
                width: 120px; /* Even smaller image on very small screens */
            }

            .typing-text {
                font-size: 20px; /* Smaller font size for typing text on small screens */
            }
        }
    </style>
</head>
<body>
<!-- Add your image here -->
<img src="{{asset('/')}}front/assets/img/arman+tamanna.jpeg" alt="Your Image" class="image">

<div class="container">
    <!-- Pulsing heart emoji -->
    <div class="heart">❤️</div>

    <!-- Hidden typing text -->
    <div class="typing-text text-1">I love you Pesi ❤️</div>
    <div class="typing-text text-2" style="margin-top: 10px;">I love you Tamanna ❤️</div>
</div>

<script>
    // JavaScript to reveal the texts after a delay
    document.addEventListener('DOMContentLoaded', function() {
        // Show the first text after 2 seconds
        setTimeout(function() {
            document.querySelector('.text-1').classList.add('show');
        }, 2000); // Delay for the first text

        // Show the second text after the first finishes (5 seconds later)
        setTimeout(function() {
            document.querySelector('.text-2').classList.add('show');
        }, 5000); // Delay for the second text
    });
</script>
</body>
</html>

