<div class="auth_title">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-info">Добавление товара</h4>
        </div>
    </div>
</div>
<div class="ins_prod">
    <div class="row">
        <div class="col-sm-12">
            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="/product/add">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">Название товара</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Название товара">
                    </div>
                </div>
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Цена*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Цена">
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="col-sm-2 control-label">Количество*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Количество">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Краткое описание</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="description" placeholder="Краткое описание" name="description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="file" class="col-sm-2 control-label">Загрузите картинку*</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" >
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Добавить</button>
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