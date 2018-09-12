<?php
use frontend\modules\feedback\api\Feedback;
use frontend\modules\page\api\Page;

$page = \frontend\modules\novanews\api\Novanews::get('page-contact');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<style type="text/css">
    #listsocial {
        display: flex;
        list-style: none;
    }
    /* Set a size for our map container, the Google Map will take up 100% of this container */
    .maps-grid-contact {
        width: 100%;
        height: 500px;
    }

    @import url(//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600);

    #contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea, #contact button[type="submit"] { font:400 12px/16px "Open Sans", Helvetica, Arial, sans-serif; }

    #contact {
        background:#F9F9F9;
        padding:25px;
        margin:50px 0;
    }

    #contact h3 {
        color: #F96;
        display: block;
        font-size: 30px;
        font-weight: 400;
    }

    #contact h4 {
        margin:5px 0 15px;
        display:block;
        font-size:13px;
    }

    fieldset {
        border: medium none !important;
        margin: 0 0 10px;
        min-width: 100%;
        padding: 0;
        width: 100%;
    }

    #contact input[type="text"], #contact input[type="email"], #contact input[type="tel"], #contact input[type="url"], #contact textarea {
        width:100%;
        border:1px solid #CCC;
        background:#FFF;
        margin:0 0 5px;
        padding:10px;
    }

    #contact input[type="text"]:hover, #contact input[type="email"]:hover, #contact input[type="tel"]:hover, #contact input[type="url"]:hover, #contact textarea:hover {
        -webkit-transition:border-color 0.3s ease-in-out;
        -moz-transition:border-color 0.3s ease-in-out;
        transition:border-color 0.3s ease-in-out;
        border:1px solid #AAA;
    }

    #contact textarea {
        height:100px;
        max-width:100%;
        resize:none;
    }

    #contact button[type="submit"] {
        cursor:pointer;
        width:100%;
        border:none;
        background:#7dc20f;
        color:#FFF;
        margin:0 0 5px;
        padding:10px;
        font-size:15px;
    }

    #contact button[type="submit"]:hover {
        background:#54820a;
        -webkit-transition:background 0.3s ease-in-out;
        -moz-transition:background 0.3s ease-in-out;
        transition:background-color 0.3s ease-in-out;
    }

    #contact button[type="submit"]:active { box-shadow:inset 0 1px 3px rgba(0, 0, 0, 0.5); }

    #contact input:focus, #contact textarea:focus {
        outline:0;
        border:1px solid #999;
    }
    ::-webkit-input-placeholder {
        color:#888;
    }
    :-moz-placeholder {
        color:#888;
    }
    ::-moz-placeholder {
        color:#888;
    }
    :-ms-input-placeholder {
        color:#888;
    }



[title="Обратная связь"] {
    width: 790px !important;
}


    .formFooter-heightMask {
        display: none;
    }
    .formFooter {
        display: none;
    }
</style>



<div class="container-fluid" id="page-contact">
    <div class="row contact-zone">
        <div class="col-md-4">
            <div class="row top10">
                <div class="col-md-12 ">
                    <p>
                        <strong><i class="fa fa-map-marker"></i> <?= Yii::t('easyii','address_in_london')?></strong><br>
                        <?= Yii::t('easyii','addressinfo3')?>
                    </p>
                    <p><strong><i class="fa fa-phone"></i> <?= Yii::t('easyii','number_eng')?></strong><br>
                        +44 7562 787794, +44 (0) 1727 834359</p>

                    <p><strong><i class="fa fa-clock-o"></i> <?= Yii::t('easyii','works_time_eng')?></strong><br>09:00-19:00</p>
                    <p><strong><i class="fa fa-envelope"></i> E-mail</strong><br><a href="mailto:one@iq-offshore.com">
                            one@iq-offshore.com</a></p>
                    <p><strong><i class="fa fa-commenting" aria-hidden="true"></i> Messengers (+44 7562 787794)</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="mapThird" class="maps-grid-contact"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row top10">
                <div class="col-md-12 ">
                    <p>
                        <strong><i class="fa fa-map-marker"></i> <?= Yii::t('easyii','address_in_moskow')?></strong><br>
                        <?= Yii::t('easyii','addressinfo1')?>
                    </p>
                    <p><strong><i class="fa fa-phone"></i> <?= Yii::t('easyii','number')?></strong><br>
                        +7 925 470 50 02</p>

                    <p><strong><i class="fa fa-clock-o"></i> <?= Yii::t('easyii','works_time')?></strong><br>09:00-19:00</p>
                    <p><strong><i class="fa fa-envelope"></i> E-mail</strong><br><a href="mailto:one@iq-offshore.com">
                        one@iq-offshore.com</a></p>
                    <p><strong><i class="fa fa-commenting" aria-hidden="true"></i> Messengers (+7 925 470-50-02)</strong></p>
                </div>
             </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="mapFirst" class="maps-grid-contact"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row top10">
                <div class="col-md-12 ">
                    <p>
                        <strong><i class="fa fa-map-marker"></i> <?= Yii::t('easyii','address_in_kiev')?></strong><br>
                        <?= Yii::t('easyii','addressinfo2')?>
                    </p>
                    <p><strong><i class="fa fa-phone"></i> <?= Yii::t('easyii','number')?></strong><br>
                         +38 067 193 11 17</p>

                    <p><strong><i class="fa fa-clock-o"></i> <?= Yii::t('easyii','works_time')?></strong><br>09:00-19:00</p>
                    <p><strong><i class="fa fa-envelope"></i> E-mail</strong><br><a href="mailto:one@iq-offshore.com">
                            one@iq-offshore.com</a></p>
                    <p><strong><i class="fa fa-commenting" aria-hidden="true"></i> Messengers (+38 067 193 11 17)</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="mapSecond" class="maps-grid-contact"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if (false): ?>
    <?php if(Yii::$app->request->get(Feedback::SENT_VAR)) : ?>
        <h4 class="text-success"><i class="glyphicon glyphicon-ok"></i> Message successfully sent</h4>
    <?php else : ?>
        <div class="well well-sm">
            <?= Feedback::form() ?>
        </div>
    <?php endif; ?>
<?php endif; ?>


<script type="text/javascript">
    var mapInitizlize = true;


</script>



