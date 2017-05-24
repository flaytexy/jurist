<?php
use frontend\modules\feedback\api\Feedback;
use frontend\modules\page\api\Page;

$page = Page::get('page-contact');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<style type="text/css">
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

    /*тестовое для формы*/
    .element.style {

        display: none !important;

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
                        <strong><i class="fa fa-map-marker"></i> Адрес</strong><br>
                        Старый Петровско-Разумовский проезд, 1/23 стр.1, Москва, 127287
                    </p>
                    <p><strong><i class="fa fa-phone"></i> Номер телефона</strong><br>
                        +7 925 470 50 02</p>
                    <p><strong><i class="fa fa-clock-o"></i> Часы работы</strong><br>
                        09:00-19:00</p>
                    <p>
                        <strong><i class="fa fa-envelope"></i> E-mail</strong><br><a href="mailto:one@iq-offshore.com">
                        one@iq-offshore.com</a></p>
                    <p><strong><i class="fa fa-skype"></i> Skype</strong><br>
                        <a href="skype:IQ Decision?call">IQ Decision</a></p>


                </div>
             </div>
        </div>

        <div class="col-md-6">
            <div class="row top10">
                <div class="col-md-12">

             <!--   <form action="http://iq-offshore.com/contact" id="contact" method="post">

                            <fieldset>
                                <input name="name" placeholder="Имя" type="text" tabindex="1" required autofocus>
                            </fieldset>
                            <fieldset>
                                <input name="email" placeholder="Email-адрес" type="email" tabindex="2" required>
                            </fieldset>
                            <fieldset>
                                <input name="number" placeholder="Номер телефона" type="tel" tabindex="3" required>
                            </fieldset>
                            <fieldset>
                                <textarea name="message" placeholder="Текст..." tabindex="4" required></textarea>
                            </fieldset>
                            <fieldset>
                                <button type="submit" id="contact-submit">Отправить</button>
                            </fieldset>
                        </form> -->

                    <script type="text/javascript" src="https://form.jotformeu.com/jsform/71136944138357"></script>
                    <script src="http://192.168.0.103:8080/target/target-script-min.js#anonymous"></script>
                    <br>
                    <br>
                    <br>








                </div>
            </div>
        </div>





    </div>
</div>


<div id="map"></div>
