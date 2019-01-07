<div class="product">
    <div class="row">
        <?php if (isset($product['id'])) : ?>
            <div class="col-sm-4">
                <img src="<?php if ($product['image_url']
                    != '') {
                    echo $product['image_url'];
                } else {
                    echo '/public/uploads/no_photo.png';
                } ?>" style="max-height:300px; width:100%;" alt="изображение">
            </div>
            <div class="col-sm-8">
                <div class="product_title">
                    <p><span class="product_option">Название товара:</span> <span><?= $product['name'] ?></span></p>
                </div>
                <div class="product_description">
                    <p><span class="product_option">Описание:</span> <span><?= $product['description'] ?></span></p>
                </div>
                <div class="product_price">
                    <p><span class="product_option">Цена:</span> <span><?= $product['price'] ?></span></p>
                </div>
                <?php if (isset($_SESSION['auth'])) : ?>
                    <div class="product_seller_name">
                        <p><span class="seller_option">Продавец:</span> <span><?= $product['fio'] ?></span></p>
                    </div>
                    <div class="product_seller_email">
                        <p><span class="seller_option">Е-майл продавца:</span> <span><?= $product['email'] ?></span></p>
                    </div>
                    <div class="product_seller_phone">
                        <p><span class="seller_option">Телефон продавца:</span> <span><?= $product['phone'] ?></span>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="product_buy">
                    <?php if($user_id == $product['user_id']) :?>
                        <a class="btn btn-default" id="edit"  href="/product/edit/?id=<?= $product['id'] ?>"
                           role="button">Редактировать</a>
                    <?php else: ?>
                        <a class="btn btn-default" id="buy" data-href="/product/buyAjax/"
                           data-user="<?=$user_id?>" data-product="<?= $product['id'] ?>"
                           href="/product/buy/?id=<?= $product['id'] ?>"
                           role="button" <?php if(empty($user_id)) echo 'disabled'?>   >Купить</a>
                    <?php if(empty($user_id)) :?>
                            <p>Для покупки необходимо авторизоваться. <a href='/user/log'>Войти</a></p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="col-sm-12">
                <p class="text-danger">Товар не найден!</p>
            </div>
        <?php endif; ?>
    </div>
</div>