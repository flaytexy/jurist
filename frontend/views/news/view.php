<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $news->seo('title', $news->model->title);
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['/news']];
$this->params['breadcrumbs'][] = $news->model->title;
?>


<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villarecent-blog">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="blog-post2">
                                    <?= Html::img($news->thumb(600, 450)) ?>
                                    <div class="blogpost-detail">
                                        <ul class="post-meta style2">
                                            <li><i class="fa fa-calendar"></i> <?= $news->date ?></li>
                                            <li><i class="fa fa-user"></i> By <a href="#" title="">Admin</a></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title=""><?= $news->views?> Views</a></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title="">03 Comments</a></li>
                                        </ul>



                                        <h1><?= $news->seo('h1', $news->title) ?></h1>
                                        <div class="tags-social">
                                            <div class="tags">
                                                <ul class="cate-list">
                                                    <?php foreach($news->tags as $tag) : ?>
                                                    <li><a href="<?= Url::to(['/news', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="social-btns">
                                                <ul>
                                                    <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-con">
                                            <?= $news->text ?>
                                        </div>

                                        <div class="comments-sec">
                                            <h2 class="title2"><span><?php echo count($news->photos);?></span> Photos</h2>
                                            <?php if(count($news->photos)) : ?>
                                                <ul class="list-inline">
                                                    <?php foreach($news->photos as $photo) : ?>
                                                    <li><?= $photo->box(150, 120) ?></li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        <?php Page::plugin() ?>
                                    </div>
                                    <div class="author-info">
                                        <span class="author-thumb"><img src="/uploads/theme_villa/author.jpg" alt=""></span>
                                        <div class="about-author">
                                            <div class="author-namesocial">
                                                <span>By Admin</span>
                                                <ul class="social-btns">
                                                    <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                                                </ul>
                                            </div>
                                            <p>Quis autem velum iure reprehe nderit. Lorem ipsum dolor sit amet Proin Condimen adipiscing varius tellus egetmassa pulvinar eu</p>
                                        </div>
                                    </div><!-- Author Info -->
                                    <div class="comments-sec">
                                        <h2 class="title2"><span>03</span> Comments</h2>
                                        <ul class="comment-threads">
                                            <li>
                                                <div class="comment">
                                                    <div class="comment-thumb">
                                                        <img src="/uploads/theme_villa/comment1.jpg" alt="">
                                                        <a href="#" class="comment-reply-link" title="">Message Reply</a>
                                                    </div>
                                                    <div class="comment-content">
                                                        <div class="comment-info">
                                                            <h5>Monica Fernando</h5>
                                                            <i>Nov 17, 2014</i>
                                                        </div>
                                                        <p>Quis autem velum iure reprehe nderit. Lorem ipsum consectetur adipiscing velum iure reprehe varius tellus egetmassa pulvinar eu aliquet nibh dapibus.</p>
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <div class="comment reply">
                                                            <div class="comment-thumb">
                                                                <img src="/uploads/theme_villa/comment2.jpg" alt="">
                                                                <a href="#" class="comment-reply-link" title="">Message Reply</a>
                                                            </div>
                                                            <div class="comment-content">
                                                                <div class="comment-info">
                                                                    <h5>John Smith</h5>
                                                                    <i>Nov 17, 2014</i>
                                                                </div>
                                                                <p>Quis autem velum iure reprehe nderit. Lorem ipsum velum iu nderit varius tellus egetmassa aliquet.</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <div class="comment">
                                                    <div class="comment-thumb">
                                                        <img src="/uploads/theme_villa/comment3.jpg" alt="">
                                                        <a href="#" class="comment-reply-link" title="">Message Reply</a>
                                                    </div>
                                                    <div class="comment-content">
                                                        <div class="comment-info">
                                                            <h5>Kark Fernando</h5>
                                                            <i>Nov 17, 2014</i>
                                                        </div>
                                                        <p>Quis autem velum iure reprehe nderit. Lorem ipsum consectetur adipiscing velum iure reprehe varius tellus egetmassa pulvinar eu aliquet nibh dapibus.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul><!-- Comments Threads -->
                                    </div><!-- Comments Sec -->
                                    <div class="leave-comment">
                                        <div class="title1 style3">
                                            <h2>leave A Comment</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="form-sec">
                                            <form>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input class="text-field" placeholder="Complete Name" type="text">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="text-field" placeholder="Email Address" type="email">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="text-field" placeholder="Subject" type="text">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <textarea class="text-field" placeholder="Description"></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="theme-btn" type="submit">CONTACT NOW</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- Form Sec -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="sidebar">
                                    <div class="widget widget-categories">
                                        <div class="title1 style2">
                                            <h2>Категории</h2>
                                           <!-- <span>We Provide Best Services</span>-->
                                        </div>
                                        <ul>
                                            <?php foreach($categories_tops as $item) : ?>
                                                <li><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>"><?= $item['title'] ?></a> <span><?= $item['counter'] ?></span></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div><!-- Widget -->
                                    <div class="widget villa-photos-widget">
                                        <div class="title1 style2">
                                            <h2>Villa Photos</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <ul class="widget-gallery">
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img1.jpg" alt=""></a></li>
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img2.jpg" alt=""></a></li>
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img3.jpg" alt=""></a></li>
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img4.jpg" alt=""></a></li>
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img5.jpg" alt=""></a></li>
                                            <li><a href="#" title=""><img src="/uploads/theme_villa/widget-gallery-img6.jpg" alt=""></a></li>
                                        </ul>
                                    </div><!-- Widget -->
                                    <div class="widget tags-widget">
                                        <div class="title1 style2">
                                            <h2>Tags Cloud</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="tags">
                                            <ul class="cate-list">
                                                <li><a href="#" title="">Uncategorized</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                                <li><a href="#" title="">Villa</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                                <li><a href="#" title="">Villa</a></li>
                                                <li><a href="#" title="">Category</a></li>
                                                <li><a href="#" title="">Uncategorized</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- Widget -->
                                    <div class="widget quick-links-widget">
                                        <div class="title1 style2">
                                            <h2>Quick Links</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="menu-links">
                                            <ul>
                                                <li><a href="#" title="">Faq's</a></li>
                                                <li><a href="#" title="">Support</a></li>
                                                <li><a href="#" title="">Community</a></li>
                                                <li><a href="#" title="">Membership</a></li>
                                                <li><a href="#" title="">Events</a></li>
                                                <li><a href="#" title="">Contact us</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- Widget -->
                                    <div class="widget recent-posts-widget">
                                        <div class="title1 style2">
                                            <h2>Recent Posts</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="recent-posts">
                                            <div class="recent-post">
                                                <img src="/uploads/theme_villa/recent-post1.jpg" alt="">
                                                <h4><a href="#" title="">That Moment When You Fall in Love....</a></h4>
                                                <span><i class="fa fa-calendar"></i> 26 May 2016</span>
                                            </div>
                                            <div class="recent-post">
                                                <img src="/uploads/theme_villa/recent-post2.jpg" alt="">
                                                <h4><a href="#" title="">That Moment When You Fall in Love....</a></h4>
                                                <span><i class="fa fa-calendar"></i> 26 May 2016</span>
                                            </div>
                                            <div class="recent-post">
                                                <img src="/uploads/theme_villa/recent-post3.jpg" alt="">
                                                <h4><a href="#" title="">That Moment When You Fall in Love....</a></h4>
                                                <span><i class="fa fa-calendar"></i> 26 May 2016</span>
                                            </div>
                                        </div>
                                    </div><!-- Widget -->
                                </div><!-- Sidebar -->
                            </div>
                        </div>
                    </div><!-- Villa Recent Blog -->
                </div>
            </div>
        </div>
    </div>
</section>


<?php /*if(false) : */?><!--
<h1><?/*= $news->seo('h1', $news->title) */?></h1>

<?/*= $news->text */?>

<?php /*if(count($news->photos)) : */?>
    <div>
        <h4>Photos</h4>
        <?php /*foreach($news->photos as $photo) : */?>
            <?/*= $photo->box(100, 100) */?>
        <?php /*endforeach;*/?>
        <?php /*News::plugin() */?>
    </div>
    <br/>
<?php /*endif; */?>
<p>
    <?php /*foreach($news->tags as $tag) : */?>
        <a href="<?/*= Url::to(['/news', 'tag' => $tag]) */?>" class="label label-info"><?/*= $tag */?></a>
    <?php /*endforeach; */?>
</p>

<div class="small-muted">Views: <?/*= $news->views*/?></div>
--><?php /*endif; */?>