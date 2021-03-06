<?php
use frontend\modules\article\api\Article;
use frontend\modules\page\api\Page;
use yii\helpers\Html;

$page = Page::get('page-articles');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

function renderNode($node){
    if(!count($node->children)){
        $html = '<li>'.Html::a($node->title, ['/articles/cat', 'slug' => $node->slug]).'</li>';
    } else {
        $html = '<li>'.$node->title.'</li>';
        $html .= '<ul>';
        foreach($node->children as $child) $html .= renderNode($child);
        $html .= '</ul>';
    }
    return $html;
}
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>

<br/>
<ul>
    <?php foreach(Article::tree() as $node) echo renderNode($node); ?>
</ul>