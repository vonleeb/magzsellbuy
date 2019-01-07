<div class="content">
    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <form method="get" id="form_sort" action="/main">
                <select id="sel_sort"  name="sort">
                    <option value="">Выберите сортировку</option>
                    <option value="titleUp">Имя - А-Я</option>
                    <option value="titleDown">Имя - Я-А</option>
                    <option value="priceUp">Цена - по возрастанию</option>
                    <option value="priceDown">Цена - по убыванию</option>
                    <option value="dateUp">Дата создания - по возрастанию</option>
                    <option value="dateDown">Дата создания - по убыванию</option>
                </select>
            </form>
            <div class="cur_sort" id="cur_sort" hidden><?=$sort?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>№</th>
                    <th><a href="#">Картинка</a></th>
                    <th><a href="#">Название</a></th>
                    <th><a href="#">Цена, бел.руб.</a></th>
                </tr>
                <?php if(isset($products)) : $i=0; foreach($products as $product) :  ?>
                    <tr>
                        <td><?=++$i?></td>
                        <td><a href="/product/get/?id=<?=$product['id']?>"><img src="<?php if($product['image_url']
                                    != ''){ echo $product['image_url'];}else{ echo '/public/uploads/no_photo.png';
                        }?>" alt="изображение" style="height:50px; width:auto;"></a></td>
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

