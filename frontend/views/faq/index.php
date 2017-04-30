<?php
use frontend\modules\faq\api\Faq;
use frontend\modules\page\api\Page;

$page = Page::get('page-faq');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>
<div class='centerplease'>

</div>
<br>

<div class="content">
    <div>
        <input type="checkbox" id="question1" name="q"  class="questions">
        <div class="plus">+</div>
        <label for="question1" class="question">
            Как открыть оффшорный счет?
        </label>
        <div class="answers">
            Следует понимать, что оффшорной бывает компания, а уже на данную компанию открывается счет, при чем совсем не обязательно в той же юрисдикции, где зарегистрирована компания. Это важно так, как законное избежание налогообложения должно сочетаться с надежным банком, каковыми банки в оффшорных зонах зачастую не являются.
            Для открытия счета прежде мы для Вас подбираем подходящую юрисдикцию и регистрируем компанию. А уже на зарегистрированную компанию мы для Вас открываем счет. В том числе можем открыть в надежном европейском банке.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question2" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question2" class="question">
            Как завести оффшорный счет?
        </label>
        <div class="answers">
            От Вас необходимы заверенные следующие документы: паспорт бенефициара и документ подтверждающий адрес регистрации, либо проживания.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question3" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question3" class="question">
            Как открыть оффшорный счет на физическое лицо?
        </label>
        <div class="answers">
            Если речь идет о личном счете, то мы подберем для Вас банк с максимальной конфиденциальностью. Все, что необходимо от Вас это два простых документа:<br>
            1. Документ подтверждающий личность. <br>
            2. Документ подтверждающий Ваш адрес регистрации или проживания.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question4" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question4" class="question">
            Что значит оффшорный счет?
        </label>
        <div class="answers">
            Оффшорного счета как такового понятия не существует. Как правило речь идет об островных банках. Наша компания является официальным агентом целого ряда островных банков, в которых можем открыть счет в том числе и без личного присутствия.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question5" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question5" class="question">
            Как снять деньги с оффшорного счета?
        </label>
        <div class="answers">
           <b>Корпоративный счет:</b> само понятие «снять» для корпоративного счета является прямым противоречием нормам использования средств юридических лиц. Какие существуют варианты законного решения данного вопроса - Вы можете узнать, обратившись за бесплатной помощью к нашему специалисту.<br><br>
            <b>Личный счет:</b> средствами с личного счета Вы можете распоряжаться  по своему усмотрению. Учитывайте только перед открытием счета дневные и месячные лимиты, установленные в том или ином банке с карточки. Также Вы можете в некоторых островных банках снимать крупные суммы, посетив отделение банка. Какой банк лучше для данных целей подходит - Вы можете узнать, обратившись за бесплатной консультацией к специалисту нашей компании.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question6" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question6" class="question">
            Для чего нужен оффшорный счет?
        </label>
        <div class="answers">
            Принято считать, что счет открытый в банке оффшорной юрисдикции дает повышенную степень конфиденциальности её владельцу. На практике те банки, которые открывают счета в евро или долларах имеют довльно сомнительные аргументы на предмет повышенной конфиденциальности. Но бывают различного типа счета: инвестиционные, зберегательные, рассчетные, мерчант, зарплатные и т.д. Мы рекомендуем обращаться к нашему консультанту, чтобы получить индивидуальную бесплатную консультацию.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question7" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question7" class="question">
            Где открыть оффшорный счет?
        </label>
        <div class="answers">
            В зависимости от цели и назначения открытия счета, размера оборачиваемых сумм имеет значение, в каком банке оптимальнее открыть счет. В мире существует огромное количество банков. И какой из них наиболее соответствует Вашим запросам - советуем обратиться за советом к нашему специалисту бесплатно.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question8" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question8" class="question">
            Платить за открытие счета или открывать самому?
        </label>
        <div class="answers">
            Открыть счет в своей стране и зарубежом - это две разные вещи. Вы можете попробовать самостоятельно, но если получите отказ, то повторная подача даже при помощи нас уже лишена смысла. В банке программа зачастую автоматически выбивает отказ на вторичные заявки. Если Ваша компания зарегистрирована в оффшорной юрисдикции, а счет Вы хотите открыть в одном из надежных, да еще и лояльном европейском банке, то у Вас шансы на успешное открытие минимальны. Особенностью агентов банка является то, что они знают специфику банка и открывают в ряде случаев через банкира.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question9" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question9" class="question">
            Почему открытие в латвийских и кипрских банках заметно дешевле, чем в других банках Европы?
        </label>
        <div class="answers">
            Несколько лет назад была глобальная американская международная проверка банков этих стран. Не секрет, что именно в латвихских и кипрских банках открыта была львиная доля счетов на оффшорные компнии. Банки попали под санкции, некоторых лишили лицензий, оштрафовали, ограничили оборот американских долларов. Банки в свою очередь ужесточили требования для своих клиентов и, как следствие, пошел отток капиталов из банков, но от этого лояльнее банки не стали. Главный акцент они сделали на работу со своими агентами. Суть этой работы заключается в том, что банк сам оплачивает за каждого приведенного клиента агентом.<br>
            Список банков, в которых мы предлагаем открытие счета доступен по данной <a href="http://iq-offshore.com/banks">ссылке</a>…<br>
            Мы не уговариваем и не отговариваем – просто стараемся рассказывать о причинах и следствии.
        </div>
    </div>

    <div>
        <input type="checkbox" id="question10" name="q" class="questions">
        <div class="plus">+</div>
        <label for="question10" class="question">
            Какие банки самые надежные?
        </label>
        <div class="answers">
            Надежность у нас у всех ассоциируется со Швейцарией. Первенство в самом деле и по сегодняшний день поддерживают швейцарских банки. Не  каждый только может себе позволить свыше 1 млн евро для открытия внести, как минимальный постоянный депозит на счету – это требование большинства швейцарских банков. Рекомендую обратить внимание на лихтенштейнские банки, которые не уступают по надежности, но не требуют подобные суммы вносить. Наши предложения о швейцарских банках и о лихтенштейнских можете на нашем сайте.


        </div>
    </div>
</div>

<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:300,800);



    .content {
        width: 80%;
        padding: 20px;
        margin: 0 auto;
        padding: 0 60px 0 0;
    }

    .centerplease {
        margin: 0 auto;
        max-width: 270px;
        font-size: 40px;
    }

    .question {
        position: relative;
        background: #7DC20F;
        margin: 0;
        padding: 10px 10px 10px 50px;
        display: block;
        width:100%;
        cursor: pointer;
        color: #fff;
    }

    .answers {
        background: #fff;
        padding: 0px 15px;
        margin: 5px 0;
        height: 0;
        overflow: hidden;
        z-index: 1;
        position: relative;
        opacity: 0;
        -webkit-transition: .7s ease;
        -moz-transition: .7s ease;
        -o-transition: .7s ease;
        transition: .7s ease;
    }


    .questions:checked ~ .answers{
        height: auto;
        opacity: 1;
        padding: 15px;
    }

    .plus {
        position: absolute;
        margin-left: 10px;
        z-index: 5;
        font-size: 2em;
        line-height: 100%;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
        -webkit-transition: .3s ease;
        -moz-transition: .3s ease;
        -o-transition: .3s ease;
        transition: .3s ease;
    }

    .questions:checked ~ .plus {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .questions {
        display: none;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>