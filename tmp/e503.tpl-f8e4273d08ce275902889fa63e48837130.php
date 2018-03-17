<!DOCTYPE HTML>
<html>

<head>
	<title>Site en construction</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Petit+Formal+Script' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300' rel='stylesheet' type='text/css'>
	<style>
		html,
		body,
		div,
		span,
		applet,
		object,
		iframe,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		p,
		blockquote,
		pre,
		a,
		abbr,
		acronym,
		address,
		big,
		cite,
		code,
		del,
		dfn,
		em,
		img,
		ins,
		kbd,
		q,
		s,
		samp,
		small,
		strike,
		strong,
		sub,
		sup,
		tt,
		var,
		b,
		u,
		i,
		dl,
		dt,
		dd,
		ol,
		nav ul,
		nav li,
		fieldset,
		form,
		label,
		legend,
		table,
		caption,
		tbody,
		tfoot,
		thead,
		tr,
		th,
		td,
		article,
		aside,
		canvas,
		details,
		embed,
		figure,
		figcaption,
		footer,
		header,
		hgroup,
		menu,
		nav,
		output,
		ruby,
		section,
		summary,
		time,
		mark,
		audio,
		video {
			margin: 0;
			padding: 0;
			border: 0;
			font-size: 100%;
			font: inherit;
			vertical-align: baseline;
		}

		article,
		aside,
		details,
		figcaption,
		figure,
		footer,
		header,
		hgroup,
		menu,
		nav,
		section {
			display: block;
		}

		ol,
		ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		blockquote,
		q {
			quotes: none;
		}

		blockquote:before,
		blockquote:after,
		q:before,
		q:after {
			content: '';
			content: none;
		}

		table {
			border-collapse: collapse;
			border-spacing: 0;
		}

		/* start editing from here */

		a {
			text-decoration: none;
		}

		.txt-rt {
			text-align: right;
		}

		/* text align right */

		.txt-lt {
			text-align: left;
		}

		/* text align left */

		.txt-center {
			text-align: center;
		}

		/* text align center */

		.float-rt {
			float: right;
		}

		/* float right */

		.float-lt {
			float: left;
		}

		/* float left */

		.clear {
			clear: both;
		}

		/* clear float */

		.pos-relative {
			position: relative;
		}

		/* Position Relative */

		.pos-absolute {
			position: absolute;
		}

		/* Position Absolute */

		.vertical-base {
			vertical-align: baseline;
		}

		/* vertical align baseline */

		.vertical-top {
			vertical-align: top;
		}

		/* vertical align top */

		.underline {
			padding-bottom: 5px;
			border-bottom: 1px solid #eee;
			margin: 0 0 20px 0;
		}

		/* Add 5px bottom padding and a underline */

		nav.vertical ul li {
			display: block;
		}

		/* vertical menu */

		nav.horizontal ul li {
			display: inline-block;
		}

		/* horizontal menu */

		img {
			max-width: 100%;
		}

		/*end reset*/

		body {
			background: url(../images/bg.png) no-repeat #fff;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-position: center;
			background-size: cover;
			font-family: "Open Sans", arial, sans-serif;
			font-weight: 300;

		}

		.wrap {
			width: 80%;
			margin: 0px auto;
		}

		.content {
			min-height: 46em;
		}

		.content-grid {
			text-align: center;
		}

		input<?php type="text"?> {
			font-family: 'Alegreya Sans', sans-serif;
			border: none;
			-webkit-border-radius: 3px 33px 33px 3px;
			border-radius: 10px 33px 33px 10px;
			color: rgba(85, 85, 85, 0.85);
			font-size: 1.1em;
			display: inline;
			padding: 19.7px 13px;
			background: #f5f5f5;
			border-top: 2px solid #000;
			outline: none;
			width: 33%;
			box-shadow: 0px 11px 34px #111;
			vertical-align: middle;
		}

		form {
			margin-bottom: 0;
			text-align: center;
			width: 100%;
		}

		.content-grid p img {
			text-align: center;
			z-index: -9999;
			margin-top: -9em;
		}

		.grid {
			text-align: center;
			margin-top: 1em;
		}

		.grid h3 {
			font-family: 'Petit Formal Script', cursive;
			color: #FFF;
			display: block;
			padding-bottom: 2.5em;
			font-size: 1.6em;
			padding-top: 1.5em;
			font-weight: 600;
			text-align: center;
		}

		.footer {}

		.footer p.a {

			display: block;
			line-height: 1.8em;
			text-align: center;
			margin-top: 4em;
		}

		.footer p {
			font-family: 'Titillium Web', sans-serif;
			color: rgba(14, 151, 243, 0.63);
			display: block;
			font-size: 1em;
			font-weight: 100;
			line-height: 1.8em;
			text-align: center;
			margin-top: 1em;
			text-shadow: 0px 1px 0px rgba(255, 250, 250, 0.09);
		}

		.footer p.a a {
			color: #000;
			-webkit-transition: all 0.5s ease-out;
			-moz-transition: all 0.5s ease-out;
			-ms-transition: all 0.5s ease-out;
			-o-transition: all 0.5s ease-out;
			transition: all 0.5s ease-out;
			font-weight: 900;
		}

		.footer p a {
			color: #0E97F3;
			-webkit-transition: all 0.5s ease-out;
			-moz-transition: all 0.5s ease-out;
			-ms-transition: all 0.5s ease-out;
			-o-transition: all 0.5s ease-out;
			transition: all 0.5s ease-out;

		}

		.footer p a:hover {
			color: #fff;
		}

		.btn {
			background: #0d7ec4;
			/* Old browsers */
			background: -moz-linear-gradient(top, #0d7ec4 0%, #0a76b9 19%, #035b98 52%, #045a93 100%);
			/* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #0d7ec4), color-stop(19%, #0a76b9), color-stop(52%, #035b98), color-stop(100%, #045a93));
			/* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top, #0d7ec4 0%, #0a76b9 19%, #035b98 52%, #045a93 100%);
			/* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top, #0d7ec4 0%, #0a76b9 19%, #035b98 52%, #045a93 100%);
			/* Opera 11.10+ */
			background: -ms-linear-gradient(top, #0d7ec4 0%, #0a76b9 19%, #035b98 52%, #045a93 100%);
			/* IE10+ */
			background: linear-gradient(to bottom, #0d7ec4 0%, #0a76b9 19%, #035b98 52%, #045a93 100%);
			/* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0d7ec4', endColorstr='#045a93', GradientType=0);
			/* IE6-9 */
			cursor: pointer;
			padding: 29px 29px;
			display: inline-block;
			position: relative;
			-webkit-transition: all 0.3s;
			-moz-transition: all 0.3s;
			transition: all 0.3s;
			vertical-align: middle;
			margin-left: -67px;
			text-indent: -9999px;
			margin-top: 2.8px;
			outline: none;
			width: 42px;
			height: 14px;
			border: none;
		}

		.btn:after {
			content: '';
			position: absolute;
			z-index: -1;
			-webkit-transition: all 0.3s;
			-moz-transition: all 0.3s;
			transition: all 0.3s;

		}

		button span {
			background: url(../images/arrow.png) repeat-x -8px -4px;
			height: 14px;
			width: 21px;
			display: block;
			-webkit-transition: all 0.6s;
			-moz-transition: all 0.6s;
			transition: all 0.6s;
			top: 23px;
			position: absolute;
			left: 18px;
			outline: none;
		}

		/* Button 4 */

		.btn-4 {
			border-radius: 50px;
			border: 4px solid #0E2955;
			color: #fff;
			overflow: hidden;
		}

		.btn-4:active {
			color: #17954c;
		}

		button span:hover {
			background: url(../images/arrow.png) repeat-x 32px -4px;
			height: 14px;
			width: 21px;
			display: block;
			outline: none;
			border: none;
		}

		.btn-4:before {
			position: absolute;
			left: 70%;

			display: none;
			-webkit-transition: all 0.3s;
			-moz-transition: all 0.3s;
			transition: all 0.3s;

		}

		.btn-4:active:before {
			color: #17954c;
			left: 20%;
			opacity: 0;
			top: 20px;
		}

		/*-----start-responsive-design------*/

		@media only screen and (max-width: 1366px) and (min-width: 1280px) {
			.wrap {
				width: 95%;
			}


		}

		@media only screen and (max-width: 1280px) and (min-width: 1024px) {
			.wrap {
				width: 95%;
			}

			input<?php type="text"?> {
				width: 37%;
			}
		}

		@media only screen and (max-width: 1024px) and (min-width: 768px) {
			.wrap {
				width: 95%;
			}
			.grid p {
				margin-top: 1em;
			}
			.grid h3 {
				padding-top: 1.2em;
				padding-bottom: 2em;
			}
			.footer p.a {
				margin-top: 4em;
			}
			input<?php type="text"?> {
				width: 45%;
			}
			.content-grid p img {
				margin-top: -8em;
			}
		}

		@media only screen and (max-width: 768px) and (min-width: 480px) {
			.wrap {
				width: 95%;
			}
			.content-grid p {
				margin-top: 3em;
			}
			.grid p {
				margin-top: 0em;
			}
			.grid p img {
				width: 80%;
				margin-top: 1em;
			}
			.grid h3 {
				font-size: 1em;
				padding-top: 1.5em;
				padding-bottom: 3em;
			}
			input<?php type="text"?> {
				font-size: 0.8em;
				padding: 19.7px 13px;
				width: 57%;
			}
			.btn {
				padding: 25px 25px;
				margin-left: -61px;
				margin-top: 2.8px;
			}
			.footer p.a {
				margin-top: 4em;
				margin-bottom: 0em;
			}
			.footer p {
				margin-bottom: 1em;
			}
			button span {
				top: 18px;
				left: 14px;
			}
		}

		@media only screen and (max-width: 480px) and (min-width: 320px) {
			.wrap {
				width: 95%;
			}
			.content-grid p img {
				margin-top: -2.2em;
				width: 300px;
				text-align: center;
			}
			.content-grid {
				text-align: center;
				margin: 0px auto;
			}
			.grid {
				margin-top: 0em;
			}
			.grid p {
				margin-top: 0em;
			}
			.grid p img {
				width: 283px;
				margin-top: 0.3em;
			}
			.grid h3 {
				font-size: 0.9em;
				padding-top: 1.2em;
				padding-bottom: 1.7em;
			}
			input<?php type="text"?> {
				font-size: 0.9em;
				padding: 10.7px 13px;
				width: 72%;
			}
			.btn {
				padding: 18px 18px;
				margin-left: -48px;
				margin-top: 2.8px;
			}
			.footer p.a {
				margin-top: 2.7em;
				margin-bottom: 0em;
			}
			.footer p.a a img {
				margin-bottom: 0em;
				width: 100px;
			}
			.footer p {
				margin-bottom: 1em;
				margin-top: 0.8em;
				font-size: 0.9em;
			}
			button span:hover {
				background: url(../images/arrow.png) repeat-x 32px -4px;
				height: 14px;
				width: 21px;
			}
			button span {
				background: url(../images/arrow.png) repeat-x -9px -4px;
				height: 14px;
				width: 21px;
				top: 12px;
				left: 8px;
			}
		}

		@media only screen and (max-width: 320px) and (min-width: 240px) {
			.grid p img {
				width: 100%;
				margin-top: 0em;
			}

			.content-grid p {
				margin-top: 1em;
			}

			.grid p {
				margin-top: 0em;
			}

			.grid h3 {
				font-size: 1em;
				padding-top: 1em;
				padding-bottom: 1.4em;
			}
			input<?php type="text"?> {
				font-size: 0.9em;
				padding: 10.7px 13px;
				width: 72%;
			}
			.btn {
				padding: 18px 18px;
				margin-left: -48px;
				margin-top: 2.8px;
			}
			.footer p.a {
				margin-top: 2.5em;
				margin-bottom: 0em;
			}
			.footer p {
				margin-bottom: 1em;
			}
			button span:hover {
				background: url(../images/arrow.png) repeat-x 32px -4px;
				height: 14px;
				width: 21px;
			}
			button span {
				background: url(../images/arrow.png) repeat-x -9px -4px;
				height: 14px;
				width: 21px;
				top: 12px;
				left: 8px;
			}
			.wrap {
				width: 95%;
			}
		}
	</style>
</head>

<body>
	<div class="content">
		<div class="wrap">
			<div class="content-grid">
				<p>
					<img src="images/top.png" title="">
				</p>
			</div>
			<div class="grid">
				<p>
					<img src="images/coming.png" title="">
				</p>
				<h3>Nous travaillons dessus.</h3>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div class="footer">
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</body>

</html>