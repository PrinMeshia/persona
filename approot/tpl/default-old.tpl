<!DOCTYPE html>
<html lang="[#site_lang]">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="[#site_description]">
  <meta name="keywords" content="[#site_keywords]">
  <meta name="author" content="[#site_author]">
  <title>[#site_title]</title>
    [#cssfile]
</head>

<body>
        <div class="wrap" id="wrapper">
            <div class="content-grid">
                <p>
                    <img src="[#imgpath]top.png" title="">
                </p>
            </div>
            <div class="grid">
                [#body]
            </div>
        </div>
        <div class="footer">
            <div class="content-grid">
                <p>copyright [= date("Y")] @ Prin'Meshia</p>
            </div>
        </div>
        <div class="clear"></div>
    [#jsfile]
</body>

</html>
