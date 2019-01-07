<div class="content">
    <div class="row">
        <div class="col-md-12">
            <p class="text-info">Список <?=$sb?> товаров</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <?php if(isset($products)) :  ?>
                    <tr>
                        <th>№</th>
                        <th><a href="#">Картинка</a></th>
                        <th><a href="#">Название</a></th>
                        <th><a href="#">Цена</a></th>
                        <th><a href="#">Кол-во <?=$sb?> ед.</a></th>
                        <th><a href="#"><?=$bs?></a></th>
                    </tr>
                    <?php $i=0; foreach($products as $product) :  ?>
                        <tr>
                            <td><?=++$i?></td>
                            <td><a href="/product/get/?id=<?=$product['id']?>"><img src="<?php if($product['image_url'] != ''){ echo $product['image_url'];}else{ echo '/public/uploads/no_photo.jpg'; }?>" alt="изображение" style="height:50px; width:auto;"></a></td>
                            <td><a href="/product/get/?id=<?=$product['id']?>"><?=$product['name']?></a></td>
                            <td><?=$product['price']?></td>
                            <td><?=$product['quantity']?></td>
                            <td><p>ФИО: <?=$product['fio']?></p><p>Е-майл: <?=$product['email']?></p>
                                <p>Телефон: <?=$product['phone']?></p></td>
                        </tr>
                    <?php endforeach; else :?>
                    <p class="text-info">Товаров не обнаружено!</p>
                <?php  endif; ?>
            </table>
        </div>
    </div>
</div>

