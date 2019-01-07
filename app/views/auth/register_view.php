<div class="auth_title">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-info">Регистрация нового пользователя</h4>
        </div>
    </div>
</div>
<div class="auth">
    <div class="row">
        <div class="col-sm-12">
            <form class="form-horizontal" method="post" action="/user/register">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Е-майл</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Е-майл">
                    </div>
                </div>
                <div class="form-group">
                    <label for="fio" class="col-sm-2 control-label">ФИО</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Номер телефона</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Номер телефона">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_copy" class="col-sm-2 control-label">Повторите пароль</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password_copy" name="password_copy"
                               placeholder="Повторите пароль">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Зарегистрироваться</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>