<?php
include './assets/conn/config.php';
include './assets/include/nav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About - Lasse Lykke</title>
</head>

<body>
    <div class="contentWrapper">
        <section class="breadcrumbs">
            <p>about / <span>Lasse</span></p>
        </section>

        <div class="aboutWrapper">
            <section class="aboutText">
                <h1>About</h1>
                <p>Hi there! I’m a self-taught web developer with a passion for bringing data to life through clean
                    code
                    and thoughtful design. <br>
                    I work primarily with <span class="highlight">HTML, CSS/SASS, PHP, and JavaScript</span>—and I’m
                    always curious to explore new
                    languages and technologies when inspiration strikes.<br>
                    My skillset also includes working with SQL and databases, which I enjoy shaping into efficient,
                    reliable backends for dynamic websites and tools.<br>
                    Whether it's crafting a custom CMS, visualizing user data, or building interactive interfaces, I
                    aim
                    to create digital solutions that just make sense.<br>
                    I like to think of myself as a <span class="highlight">friendly hacker</span>—the kind who solves
                    everyday challenges with
                    clever
                    tech, not the kind in a hoodie breaking into your WiFi. Coding may not be my full-time job, but
                    it’s
                    definitely my favorite way to unwind and think creatively.</p>
            </section>
            <section class="aboutContent">
                <img src="./assets/include/img/about-1.png" class="aboutImage">
            </section>
        </div>
        <div class="contactWrapper" id="contact">
            <h1>Let's connect</h1>
            <p>Got a project in mind? I’d really love to hear about it.<br>
                Whether it’s a small idea or something a bit bigger, I enjoy helping turn thoughts into clean,
                functional, and user-friendly web solutions.<br> I may not have all the answers right away, but I’m
                always eager to learn and genuinely care about doing things the right way.<br>

                I aim to build with care—focusing on clarity, usability, and the little details that make something feel
                just right.<br>
                If you're looking for someone who's easy to talk to and enjoys crafting digital things that actually
                work for real people—I'd be happy to connect.</p>
            <br>
            <a href="https://www.github.com/LasseLykke" target="_blank" rel="noopener noreferrer">
                <img src="./assets/include/img/github.png" class="icons" alt="GitHub icon">
            </a>
            <a href="https://www.linkedin.com/in/lasse-lykke-46998922/" target="_blank" rel="noopener noreferrer">
                <img src="./assets/include/img/linkedin.png" class="icons" alt="Linkedin icon">
            </a>
            <a href="mailto:dev@lasselykke.com" target="_blank" rel="noopener noreferrer">
                <img src="./assets/include/img/email.png" class="icons" alt="Email icon">
            </a>

        </div>
</body>
<script src="./assets/style/script.js"></script>

</html>