<div class="content">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>№</th>
                    <th><a href="#">Картинка</a></th>
                    <th><a href="#">Название</a></th>
                    <th><a href="#">Цена</a></th>
                </tr>
                <?php if(isset($products)) : $i=0; foreach($products as $product) :  ?>
                <tr>
                    <td><?=++$i?></td>
                    <td><a href="/product/get/?id=<?=$product['id']?>"><img src="<?php if($product['image_url'] != ''){ echo $product['image_url'];}else{ echo '/public/uploads/no_photo.jpg'; }?>" alt="изображение" style="height:50px; width:auto;"></a></td>
                    <td><a href="/product/get/?id=<?=$product['id']?>"><?=$product['name']?></a></td>
                    <td><?=$product['price']?></td>
                </tr>
                <?php endforeach; else :?>
                <p class="text-info">Товаров не обнаружено!</p>
                <?php  endif; ?>
            </table>
        </div>
    </div>
</div>

