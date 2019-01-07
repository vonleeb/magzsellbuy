<div class="auth_title">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-info">Редактирование товара</h4>
        </div>
    </div>
</div>
<?php if( ! empty($edit)) :?>
<div class="ins_prod">
    <div class="row">
        <div class="col-sm-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="post"
                  action="/product/save/?id=<?=$edit['id']?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Название товара</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="<?=$edit['name']?>"
                               placeholder="Название
                        товара">
                    </div>
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Цена*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price" name="price" value="<?=$edit['price']?>"
                               placeholder="Цена">
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="col-sm-2 control-label">Количество*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quantity" name="quantity"
                               value="<?=$edit['quantity']?>" placeholder="Количество">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Краткое описание</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" placeholder="Краткое описание"
                                  name="description"><?=$edit['description']?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file" class="col-sm-2 control-label">Загрузите картинку*</label>
                    <div class="col-sm-3">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" >
                        <input type="file" class="form-control" id="file" name="file">

                    </div>
                    <div class="col-sm-2">
                        <img src="<?=$edit['image_url']?>" alt="изображение" style="height:50px; width:auto;">
                    </div>
                    <div class="col-sm-3">
                        <label>
                            Не обновлять картинку<input type="checkbox" checked name="file">
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="ins_msg">
    <div class="row">
        <div class="col-sm-12">
            <p class="text-info">* - цена указывается в бел.руб.</p>
            <p class="text-info">* - кол-во единиц товара от 1 до 100</p>
            <p class="text-info">* - картинки только .jpg, .png, .gif не более 2Мб</p>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="ins_msg">
        <div class="row">
            <div class="col-sm-12">
                <p class="text-info">Товар не найден.</p>
            </div>
        </div>
    </div>
<?php endif;?>