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

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="container">


    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Как открыть оффшорный счет?</span>
            </h3>
        </div>
        <div class="toggle-inner">
            <p> Следует понимать, что оффшорной бывает компания, а уже на данную компанию открывается счет, при чем совсем не обязательно в той же юрисдикции, где зарегистрирована компания. Это важно так, как законное избежание налогообложения должно сочетаться с надежным банком, каковыми банки в оффшорных зонах зачастую не являются.
                Для открытия счета прежде мы для Вас подбираем подходящую юрисдикцию и регистрируем компанию. А уже на зарегистрированную компанию мы для Вас открываем счет. В том числе можем открыть в надежном европейском банке.
            </p>
        </div>
    </div><!-- END OF TOGGLE -->


    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Как завести оффшорный счет?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>От Вас необходимы заверенные следующие документы: паспорт бенефициара и документ подтверждающий адрес регистрации, либо проживания.</p>
        </div>
    </div><!-- END OF TOGGLE -->

    <div class="toggle">
        <div class="toggle-title  ">
            <h3>
                <i></i>
                <span class="title-name"> Как открыть оффшорный счет на физическое лицо?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p> Если речь идет о личном счете, то мы подберем для Вас банк с максимальной конфиденциальностью. Все, что необходимо от Вас это два простых документа:<br>
                1. Документ подтверждающий личность. <br>
                2. Документ подтверждающий Ваш адрес регистрации или проживания.</p>
        </div>

    </div><!-- END OF TOGGLE -->



    <div class="toggle">
        <div class="toggle-title  ">
            <h3>
                <i></i>
                <span class="title-name"> Что значит оффшорный счет?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>Оффшорного счета как такового понятия не существует. Как правило речь идет об островных банках. Наша компания является официальным агентом целого ряда островных банков, в которых можем открыть счет в том числе и без личного присутствия.</p>
        </div>

    </div><!-- END OF TOGGLE -->



    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name">  Как снять деньги с оффшорного счета?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p><b>Корпоративный счет:</b> само понятие «снять» для корпоративного счета является прямым противоречием нормам использования средств юридических лиц. Какие существуют варианты законного решения данного вопроса - Вы можете узнать, обратившись за бесплатной помощью к нашему специалисту.<br><br>
                <b>Личный счет:</b> средствами с личного счета Вы можете распоряжаться  по своему усмотрению. Учитывайте только перед открытием счета дневные и месячные лимиты, установленные в том или ином банке с карточки. Также Вы можете в некоторых островных банках снимать крупные суммы, посетив отделение банка. Какой банк лучше для данных целей подходит - Вы можете узнать, обратившись за бесплатной консультацией к специалисту нашей компании.
            </p>
        </div>

    </div><!-- END OF TOGGLE -->




    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name">Для чего нужен оффшорный счет?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>Принято считать, что счет открытый в банке оффшорной юрисдикции дает повышенную степень конфиденциальности её владельцу. На практике те банки, которые открывают счета в евро или долларах имеют довльно сомнительные аргументы на предмет повышенной конфиденциальности. Но бывают различного типа счета: инвестиционные, зберегательные, рассчетные, мерчант, зарплатные и т.д. Мы рекомендуем обращаться к нашему консультанту, чтобы получить индивидуальную бесплатную консультацию.</p>
        </div>

    </div><!-- END OF TOGGLE -->



    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Где открыть оффшорный счет?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>В зависимости от цели и назначения открытия счета, размера оборачиваемых сумм имеет значение, в каком банке оптимальнее открыть счет. В мире существует огромное количество банков. И какой из них наиболее соответствует Вашим запросам - советуем обратиться за советом к нашему специалисту бесплатно.</p>
        </div>

    </div>


    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Платить за открытие счета или открывать самому?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>Открыть счет в своей стране и зарубежом - это две разные вещи. Вы можете попробовать самостоятельно, но если получите отказ, то повторная подача даже при помощи нас уже лишена смысла. В банке программа зачастую автоматически выбивает отказ на вторичные заявки. Если Ваша компания зарегистрирована в оффшорной юрисдикции, а счет Вы хотите открыть в одном из надежных, да еще и лояльном европейском банке, то у Вас шансы на успешное открытие минимальны. Особенностью агентов банка является то, что они знают специфику банка и открывают в ряде случаев через банкира.</p>
        </div>

    </div>





    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Почему открытие в латвийских и кипрских банках заметно дешевле, чем в других банках Европы?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>Несколько лет назад была глобальная американская международная проверка банков этих стран. Не секрет, что именно в латвихских и кипрских банках открыта была львиная доля счетов на оффшорные компнии. Банки попали под санкции, некоторых лишили лицензий, оштрафовали, ограничили оборот американских долларов. Банки в свою очередь ужесточили требования для своих клиентов и, как следствие, пошел отток капиталов из банков, но от этого лояльнее банки не стали. Главный акцент они сделали на работу со своими агентами. Суть этой работы заключается в том, что банк сам оплачивает за каждого приведенного клиента агентом.<br>
                Список банков, в которых мы предлагаем открытие счета доступен по данной <a href="http://iq-offshore.com/banks">ссылке</a>…<br>
                Мы не уговариваем и не отговариваем – просто стараемся рассказывать о причинах и следствии.
            </p>
        </div>

    </div>




    <div class="toggle">
        <div class="toggle-title ">
            <h3>
                <i></i>
                <span class="title-name"> Какие банки самые надежные?</span>
            </h3>
        </div>

        <div class="toggle-inner">
            <p>Надежность у нас у всех ассоциируется со Швейцарией. Первенство в самом деле и по сегодняшний день поддерживают швейцарских банки. Не  каждый только может себе позволить свыше 1 млн евро для открытия внести, как минимальный постоянный депозит на счету – это требование большинства швейцарских банков. Рекомендую обратить внимание на лихтенштейнские банки, которые не уступают по надежности, но не требуют подобные суммы вносить. Наши предложения о швейцарских банках и о лихтенштейнских можете на нашем сайте.
            </p>
        </div>

    </div><!-- END OF TOGGLE -->


</div>



<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:300,800);
    /* Styles for Accordion */
    .toggle:last-child {
        border-bottom: 1px solid #dddddd;
    }
    .toggle .toggle-title {
        position: relative;
        display: block;
        border-top: 1px solid #dddddd;
        margin-bottom: 6px;
    }
    .toggle .toggle-title h3 {
        font-size: 20px;
        margin: 0px;
        line-height: 1;
        cursor: pointer;
        font-weight: 200;
    }
    .toggle .toggle-inner {
        padding: 7px 25px 10px 25px;
        display: none;
        margin: -7px 0 6px;
    }
    .toggle .toggle-inner div {
        max-width: 100%;
    }
    .toggle .toggle-title .title-name {
        display: block;
        padding: 25px 25px 14px;
    }
    .toggle .toggle-title a i {
        font-size: 22px;
        margin-right: 5px;
    }
    .toggle .toggle-title i {
        position: absolute;
        background: url("http://arielbeninca.com/Storage/plus_minus.png") 0px -24px no-repeat;
        width: 24px;
        height: 24px;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
        margin: 20px;
        right: 0;
    }
    .toggle .toggle-title.active i {
        background: url("http://arielbeninca.com/Storage/plus_minus.png") 0px 0px no-repeat;
    }


   
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    if( jQuery(".toggle .toggle-title").hasClass('active') ){
        jQuery(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
    }
    jQuery(".toggle .toggle-title").click(function(){
        if( jQuery(this).hasClass('active') ){
            jQuery(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
        }
        else{	jQuery(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
        }
    });
</script>