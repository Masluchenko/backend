<!DOCTYPE html>
<html lang="">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <title>Задание 3</title>
</head>

<body>
    <div class="form-container">
        <form method="POST" action="">
            <div class="input-group block">
                <input type="text" name="name" placeholder="Ваше имя" />
            </div>
            <div class="input-group block">
                <input type="text" name="email" placeholder="example@mail.ru" />
            </div>
            <div class="block" id="date-block">
                <span class="block-title">Дата рождения</span>
                <input type="date" name="date" />
            </div>
            <div class="radios-container">
                <div class="block" id="gender-block">
                    <span class="block-title">Пол</span>
                    <div class="radios">
                        <div class="male-radio">
                            <input type="radio" name="gender" value="m" />
                            <label for="male">Мужской</label>
                        </div>
                        <div class="female-radio">
                            <input type="radio" name="gender" value="f" />
                            <label for="female">Женский</label>
                        </div>
                    </div>
                </div>
                <div class="block" id="limbs-block">
                    <span class="block-title">Конечности</span>
                    <div class="radios">
                        <div class="limbs-radio">
                            <input type="radio" name="limbs" value="1" />
                            <label for="male">1</label>
                        </div>
                        <div class="limbs-radio">
                            <input type="radio" name="limbs" value="2" />
                            <label for="female">2</label>
                        </div>
                        <div class="limbs-radio">
                            <input type="radio" name="limbs" value="3" />
                            <label for="female">3</label>
                        </div>
                        <div class="limbs-radio">
                            <input type="radio" name="limbs" value="4" />
                            <label for="female">4</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <span class="block-title">Способности</span>
                <select class="form-select form-select-lg mb-2" name="select[]" multiple>
                    <option value="inf" selected>Бессмертие</option>
                    <option value="through">Прохождение сквозь стены</option>
                    <option value="levitation">Левитация</option>
                    <option value="supervision">Суперзрение</option>
                </select>
            </div>
            <div class="block">
                <textarea class="form-control" placeholder="Расскажите о себе..." name="bio"></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" id="policy" name="policy" />
                <label class="form-check-label" for="policy">Согласен с политикой конфиденциальности</label>
            </div>
            <button class="btn btn-primary" type="submit" id="send-btn">Отправить</button>
        </form>
    </div>
</body>

</html>