<!DOCTYPE html>
<html lang="[$site_lang]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="[$site_description]">
    <meta name="keywords" content="[$site_keywords]">
    <meta name="author" content="[$site_author]">
    <title>[$site_title] [$page_title] </title>
      [$cssfile]
</head>

<body>
<header>
    <nav id="menu">
        <ul>
            <li class="active"><a href="/">Home</a></li>
            <li><a href="#">A propos</a></li>
            <li id="hamburger" class="burgerMenuBtn">
                <svg class="menu__icon no--select" width="24px" height="24px" viewBox="0 0 48 48" fill="#000">
                    <path d="M6 36h36v-4H6v4zm0-10h36v-4H6v4zm0-14v4h36v-4H6z"></path>
                </svg>
            </li>
        </ul>
    </nav>
    <ul id="param">
        <li id="pushBtn" class="inactive">
            <img src="[$imgpath]svg/pushbtn.svg">
            <span>notification</span></li>
    </ul>
</header>
<div id="overlay"> </div>
<div id="mobileNavigation">
    <div class="inner">
        <div id="illu">
            <img src="[$imgpath]svg/logo.svg">
            <br/> [$site_title] </div>
        <ul id="mobileNav">
            <li><a href="/">Home</a></li>
        </ul>
        <ul id="mobileParam">
            <li id="mobilePushBtn">Notification</li>
        </ul>
        <div id="mobileFooter"> <a href="https://github.com/PrinMeshia" target="_blank">[$site_title]</a> - [= date("Y")] </div>
    </div>
</div>
<div class="toast__container"></div>
<div class="loader">
        <svg viewBox="0 0 32 32" width="32" height="32">
                <circle id="spinner" cx="16" cy="16" r="14" fill="none"></circle>
            </svg>
</div>
<section id="container">
    <main class='content'>
        <div class="cg">
            [$body]
        </div>
        <div class="cg container"></div>
    </main>
</section>
<footer> <a href="https://github.com/PrinMeshia" target="_blank">[$site_title]</a> - [= date("Y")] </footer>
</body>
[$jsfile]

</html>