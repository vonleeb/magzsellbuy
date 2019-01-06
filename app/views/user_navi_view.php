<div class="auth_msg">
    <div class="row">
        <div class="col-md-7">
            <?php if ($_SESSION['auth'] === TRUE) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-success">Вы авторизованы, как <?= $_SESSION['name'] ?>! </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-default" href="/product/myprod" role="button">Показать свои товары</a>
                        <a class="btn btn-default" href="/product/buyprod" role="button">Показать купленные товары</a>
                        <a class="btn btn-default" href="/product/sellprod" role="button">Показать проданые товары</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <a class="btn btn-default" href="/main" role="button">На главную</a>
                        <a class="btn btn-default" href="/product/ins" role="button">Добавить товар</a>
                        <a class="btn btn-default" href="/user/logout" role="button">Выйти</a>
                    </div>
                </div>
            <?php else : ?>
                <a class="btn btn-default" href="/user/log" role="button">Войти</a>
                <a class="btn btn-default" href="/user/reg" role="button">Регистрация</a>
            <?php endif; ?>
        </div>

        <div class="col-md-5">
            <p class="text-info">
            <?php if(is_array($msg)) {
                foreach ($msg as $m)
                    echo $m . '<br>';
            }else{
                echo $msg;
            }

            ?>
            </p>
        </div>
    </div>
</div>