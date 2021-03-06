/**
 * Created by Vitaliy on 23.12.2016.
 */

if(typeof(mapType)==='undefined')
    mapType = 'world_mill';
if(typeof(myMarker)==='undefined')
    myMarker = [];

var prison = [
    {name: 'Albion', coords: [41.890611, -80.366454], status: 'active', offsets: [0, 2]}
];

var myMarker2 = [
    {latLng: [41.90, 12.45], name: 'Vatican City', imgsrc: '/img/map-pin-marker-circle-512.png'},
    {latLng: [43.73, 7.41], name: 'Monaco', image: '/img/map-pin-marker-circle-512.png'},
    {latLng: [-0.52, 166.93], name: 'Nauru', image: 'img/map-pin-marker-circle-512.png'},
    {latLng: [-8.51, 179.21], name: 'Tuvalu'},
    {latLng: [43.93, 12.46], name: 'San Marino'},
    {latLng: [47.14, 9.52], name: 'Liechtenstein'},
    {latLng: [7.11, 171.06], name: 'Marshall Islands'},
    {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
    {latLng: [3.2, 73.22], name: 'Maldives'},
    {latLng: [35.88, 14.5], name: 'Malta'},
    {latLng: [12.05, -61.75], name: 'Grenada'},
    {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
    {latLng: [13.16, -59.55], name: 'Barbados'},
    {latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
    {latLng: [-4.61, 55.45], name: 'Seychelles'},
    {latLng: [7.35, 134.46], name: 'Palau'},
    {latLng: [42.5, 1.51], name: 'Andorra'},
    {latLng: [14.01, -60.98], name: 'Saint Lucia'},
    {latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
    {latLng: [1.3, 103.8], name: 'Singapore'},
    {latLng: [1.46, 173.03], name: 'Kiribati'},
    {latLng: [-21.13, -175.2], name: 'Tonga'},
    {latLng: [15.3, -61.38], name: 'Dominica'},
    {latLng: [-20.2, 57.5], name: 'Mauritius'},
    {latLng: [26.02, 50.55], name: 'Bahrain'},
    {latLng: [0.33, 6.73], name: 'S?o Tom? and Pr?ncipe'}
];




//@code_start
$(function () {
    //#world-map-markers
    $('#world-map-markers').width($(window).width());
    $('#world-map-markers').height($(window).height());

    var mapData = {
        'world_mill': {
            focusX: 1.74,
            focusY: 1.5,
            scale: 0.55,
            zoomMin: 1.15

        },
        'europe_mill' : {
            focusX: 0.5,
            focusY: 0.6,
            scale: 1.22,
            zoomMin: 1.85
        }
    };


    if($(window).width()>1000){
        $('#world-map-markers').vectorMap({
            map: mapType,
            zoomMin: mapData[mapType].zoomMin,
            focusOn: {x: mapData[mapType].focusX, y: mapData[mapType].focusY, scale: mapData[mapType].scale},
            zoomOnScroll: false,
            scaleColors: ['#C8EEFF', '#b70000'],
            normalizeFunction: 'polynomial',
            hoverOpacity: 0.7,
            hoverColor: false,
            markerStyle: {
                initial: {
                    fill: '#5da0ff',
                    stroke: '#2B4773',
                    "fill-opacity": 1,
                    "stroke-width": 1,
                    "stroke-opacity": 1,
                    r: 5
                },
                hover: {
                    stroke: '#15107',
                    "stroke-width": 15
                },
                selected: {
                    fill: 'blue'
                },
                selectedHover: {}
            },
            markerLabelStyle: {
                initial: {
                    'font-size': '0',
                    fill: '#000'
                },
                hover: {
                    fill: '#2B4773'
                }
            },
            regionStyle: {
                initial: {
                    'font-family': 'Verdana',
                    'font-size': '15',
                    'font-weight': 'bold',
                    cursor: 'default',
                    fill: '#7DC20F'
                },
                hover: {
                    fill: "#7DC20F",
                    cursor: 'default'
                }
            },
            regionLabelStyle: {},
            backgroundColor: '#A3C7FF', //'transparent', //3B5BC6 //
            markers: myMarker,
            labels: {
                markers: {
                    render: function (index) {
                        return myMarker[index].name;
                    },
                    offsets: function (index) {
                        var offset = myMarker[index]['offsets'] || [0, 0];

                        return [offset[0] - 2, offset[1] + 0];
                    }
                }
            },
            series: {
                markers: [{
                    attribute: 'image',
                    scale: {
                        'closed': '/img/icon-np-3.png',
                        'activeUntil2018': '/img/icon-np-2.png',
                        'activeUntil2022': '/img/icon-np-1.png'
                    },
                    values: myMarker.reduce(function (p, c, i) {
                        p[i] = c.status;
                        return p
                    }, {})/*,
                 legend: {
                 horizontal: true,
                 title: 'Nuclear power station status',
                 labelRender: function(v){
                 return {
                 closed: 'Closed',
                 activeUntil2018: 'Scheduled for shut down<br> before 2018',
                 activeUntil2022: 'Scheduled for shut down<br> before 2022'
                 }[v];
                 }
                 }*/
                }]
            },
            onMarkerClick: function (events, label, index, weburl) {
                //console.log(myMarker[label].weburl);
                $('#menu-show-block-zone').show();
                $('#menu-show-block-zone .block-zone').hide();
                //alert('#' + myMarker[label].weburl);
                var mark = $('#' + myMarker[label].weburl);
                mark.show();
                mark.find('button:visible').click();
                //$('button:visible').click();
            }
            /*onMarkerOver: function (event, code, region) {
             console.log('sdadas22');
             }*/
        });
        $('#world-map-markers-block').show();
    }else{
        $('#world-map-markers-block').hide();
    }
});
