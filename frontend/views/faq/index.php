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
<br>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="container" id="faq-content">
    <? foreach ($faqs as $item): ?>
        <div class="toggle">
            <div class="toggle-title ">
                <h3>
                    <i></i>
                    <span class="title-name"><?= $item->question?></span>
                </h3>
            </div>
            <div class="toggle-inner">
                <p><?= $item->answer?></p>
            </div>
        </div><!-- END OF TOGGLE -->
    <? endforeach; ?>
</div>



<style>
    @import url(//fonts.googleapis.com/css?family=Open+Sans:300,800);
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
        margin: 0;
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
        background: url("//arielbeninca.com/Storage/plus_minus.png") 0px -24px no-repeat;
        width: 24px;
        height: 24px;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
        margin: 20px;
        right: 0;
    }
    .toggle .toggle-title.active i {
        background: url("//arielbeninca.com/Storage/plus_minus.png") 0px 0px no-repeat;
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