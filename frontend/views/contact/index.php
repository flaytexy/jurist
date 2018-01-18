<?php
use frontend\modules\feedback\api\Feedback;
use frontend\modules\page\api\Page;

$page = Page::get('page-contact');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<style type="text/css">
    #listsocial {
        display: flex;
        list-style: none;
    }
    /* Set a size for our map container, the Google Map will take up 100% of this container */
    #map {
        width: 100%;
        height: 500px;
    }
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600);




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
    .otstup {
        margin-left: 50px;
        padding: 50px;
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

<!--
    You need to include this script tag on any page that has a Google Map.

    The following script tag will work when opening this example locally on your computer.
    But if you use this on a localhost server or a live website you will need to include an API key.
    Sign up for one here (it's free for small usage):
        https://developers.google.com/maps/documentation/javascript/tutorial#api_key

    After you sign up, use the following script tag with YOUR_GOOGLE_API_KEY replaced with your actual key.
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY"></script>
-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=
AIzaSyAxsOMhMNNlJe38h-ON-0MkOxBLCT78MRU&callback=initMap"></script>

<script type="text/javascript">
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);
    var locations = [
        ['Bondi Beach', -33.890542, 151.274856, 4],
        ['Coogee Beach', -33.923036, 151.259052, 5],
        ['Cronulla Beach', -34.028249, 151.157507, 3],
        ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
        ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];
    function init() {
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 15,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(55.800312,37.565437), // New York

            // How you would like to style the map.
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#4f595d"},{"visibility":"on"}]}]
        };

        // Get the HTML DOM element that will contain your map
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(55.800312,37.565437),
            map: map,
            title: 'Snazzy!'
        });
    }
</script>

<div>

    </div>
<div class="container" id="page-contact">
    <div class="row contact-zone">
        <div class="col-md-6">
            <div class="row top10">
                <div class="col-md-12 otstup">
                    <p>
                        <strong><i class="fa fa-map-marker"></i> <?= Yii::t('easyii','address')?></strong><br>
                        <?= Yii::t('easyii','addressinfo1')?>
                    </p>
                    <p>
                        <strong><i class="fa fa-map-marker"></i> <?= Yii::t('easyii','address')?> 2</strong><br>
                        <?= Yii::t('easyii','addressinfo2')?>
                    </p>
                    <p><strong><i class="fa fa-phone"></i> <?= Yii::t('easyii','number')?></strong><br>
                        +7 925 470 50 02 <br> +38 067 193 11 17</p>
                    <p><strong><i class="fa fa-clock-o"></i> Часы работы</strong><br>09:00-19:00</p>
                    <p><strong><i class="fa fa-envelope"></i> E-mail</strong><br><a href="mailto:one@iq-offshore.com">
                        one@iq-offshore.com</a></p>
                    <p><strong><i class="fa fa-skype"></i> Skype</strong><br><a href="skype:live:asmofad?call">IQ Decision</a></p>
                    <p><strong><i class="fa fa-commenting" aria-hidden="true"></i> Messengers (+7 925 470-50-02)</strong></p>
                    <ul id="listsocial">
                        <li><a href="viber://add?number=+79254705002"><img src="/images/icons/viber-icon-small.png" height="42" width="42" alt="pricing-table"></a></li>
                        <li><a href="https://api.whatsapp.com/send?phone=79254705002"><img src="/images/icons/WhatsApp-icon-small.png" height="42" width="42" alt="pricing-table"></a></li>
                        <li><a href="#"><img src="/images/icons/telegram-logo-small.png" height="42" width="42" alt="pricing-table"></a></li>
                    </ul>
                </div>
             </div>
        </div>

        <div class="col-md-6">
            <div class="row top10">
                <div class="col-md-12">
                    <script type="text/javascript" src="https://form.jotformeu.com/jsform/71136944138357"></script>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="map"></div>
