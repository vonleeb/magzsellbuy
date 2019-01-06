<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сайт продажи/покупки товаров</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Сайт предназначен для продажи и покупки товаров" />
    <meta name="keywords" content="продажа, покупка" />
    <meta name="author" content="by vonleeb">
    <link type="text/css" rel="stylesheet" href="/public/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="/public/css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="row">
            <div class="col-md-12">
                <h1>Сайт по продаже и покупке товаров</h1>
            </div>
        </div>
    </div>
<?php require_once PATH . '/app/views/user_navi_view.php'; ?>
<?php require_once 'app/views/'.$content_view; ?>

    <div class="footer" id="footer">
        <div class="row">
            <div class="col-md-12">
                <p>здесь должен быть футер</p>
            </div>
        </div>
    </div>
</div>
<script src="/public/js/jquery.js"></script>
<script src="/public/js/jquery.min.js"></script>
<script src="/public/js/bootstrap.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
</body>
</html>