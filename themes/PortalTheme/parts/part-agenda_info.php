<?php
    //General
    $title = get_the_title($agenda_id);
    $link = get_the_permalink($agenda_id);
    $date = get_field('agenda_date', $agenda_id);
    $end_time = get_field('end_time', $agenda_id);
    $start_time = get_field('start_time', $agenda_id);
    $activities = get_field('activities', $agenda_id);

    //Location
    $address = get_field('address', $agenda_id)['address']; 
    $lat = get_field('address', $agenda_id)['lat']; 
    $lng = get_field('address', $agenda_id)['lng'];

    //Team
    $account_manager_id = get_field('account_manager', $agenda_id);
    $point_contact_id = get_field('point_of_contact', $agenda_id);
    $trainers = get_field('trainers', $agenda_id);

    //Status
    $status = get_field('session_status', $agenda_id);

    //Admin 
    $client = get_field('organisation_client', $agenda_id);
    $client_id = $client['ID'];
    $current_id = get_current_user_id();
    if ($client_id == $current_id) {
        $admin = true;
    }
    
?>
<div class="session-info">
          
    <div class="row">

        <div class="col-12 col-lg-6 col-xl-8 p-0 pr-lg-5">

            <!-- Activities -->
            <?php 
            $questions = false;
            foreach ($activities as $activity): ?>
                <div class="row p-0 mt-1">

                    <!-- Hours -->
                    <div class="col-12 col-xl-3 mt-1 mb-2 p-0">
                        <p class="m-0">
                            <i class="far fa-clock d-inline d-lg-none"></i>
                            <span><?php echo $activity['activity_start'] ?></span> - <span><?php echo $activity['activity_end']  ?></span>
                        </p>
                    </div>
                
                    <div class="col-12 col-xl-9 p-0 pl-lg-2">

                        <!-- Title and questions -->
                        <p class="subtitle m-0"><?php echo $activity['activity_name'] ?></p>
                        <div><?php echo $activity['activity_description'] ?></div>

                        <!-- Questions -->
                        <?php if ($activity['questions']): 
                            $questions = true; 
                            ?>
                            <div class="questions-wrap">
                                <div class="questions px-3 py-4 mb-5">
                                    <p class="subtitle ml-3">Potential questions:</p>
                                    <?php echo $activity['questions'] ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>                  
            <?php endforeach;?>

        </div>

        <div class="col-12 col-lg-6 col-xl-4 pl-lg-4 p-0">

            <!-- Trainers -->
            <?php if ($trainers): ?>
                <p class="subtitle m-0 mb-4">Your coaches</p>
                <?php foreach ($trainers as $trainer): 
                    $image = get_field('picture', $trainer);
                    $name =  get_the_title($trainer); 
                    $role =  get_field('role', $trainer); ?>

                    <div class="row p-0 mt-2">
                        <div class="col-4 col-md-2 col-lg-4 p-0">
                            <img class="my-2 my-md- mx-auto mx-md-0 d-block avatar rounded-img" src="<?php echo $image ?> "/>    
                        </div>
                                    
                        <div class="col-8">
                            <div class="h-100 d-flex align-items-center">
                                <div class="w-100 text-left">
                                    <p class="name m-0"><?php echo $name ?></p>
                                    <p class="m-0"><?php echo $role ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                                                        
                <?php endforeach;?>
            <?php endif ?>

            <!-- Questions -->
            <?php if ($questions && $admin) : ?>
                <div>
                    <p class="subtitle mt-4">Display questions</p>
                    <p>Questions and notes for you to review ahead of the session. </p>

                    <label class="switch">
                        <!-- <input type="checkbox" data-toggle="collapse" data-target=".questions-wrap" aria-expanded="false" aria-controls=".questions-wrap" > -->
                        <input type="checkbox" id="openQuestions">
                        <span class="slider round"></span>
                    </label>
                </div>
            <?php endif; ?>

            <!-- Your approval -->
            <?php 
                $class_request = "";
                $class_approve = "";
           
                if ($status == "Pending" ) {
                    $text_request = "Request changes";
                    $text_approve = "Approve";
                    $icon_request = "fas fa-times-circle";
                }
                else if ( $status == "Awaiting feedback") {
                    $class_request = "disable";
                    $text_approve = "Approve";
                    $text_request = "Changes requested";
                    $icon_request = "far fa-clock";
                }
                else {
                    $class_request = "disable";
                    $class_approve = "disable";
                    $text_approve = "Approved";
                    $text_request = "Request changes";
                    $icon_request = "fas fa-times-circle";
                }
            ?>

            <?php if ($admin): ?> 
                <div class="approval">

                    <p class="subtitle mt-4">Your approval</p>
                    <p>Select approve to share this agenda with your delegates. 
                        Alternatively click request changes to provide feedback on any amends required.  </p>

                    <div class="d-flex align-items-center my-3 approve <?php echo $class_approve ?>" 
                        data-id="<?php echo $agenda_id?>"
                        data-type="Agenda"
                        action="<?php echo admin_url('admin-ajax.php'); ?>" >

                        <i class="fas fa-check-circle"></i>
                        <span><?php echo $text_approve ?></span>

                    </div>

                    <div class="d-flex align-items-center my-3 request <?php echo $class_request ?>" 
                        data-id="<?php echo $agenda_id?>" 
                        data-item="<?php echo $link?>" 
                        data-type="Agenda"
                        action="<?php echo admin_url('admin-ajax.php'); ?>"  >

                        <i class="<?php echo $icon_request ?>"></i>
                        <span><?php  echo $text_request?></span>

                    </div>
                </div>
            <?php endif ?>

        </div>

    </div>          
        
    <!-- Map -->
    <?php if ($address): ?>
                
        <div id="map" class="mt-4" style="height:400px" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>">
        </div>

            <script>
                function myMap() {

                    latitude = $('#map').data("lat") ;
                    longitude = $('#map').data("lng") ;

                    var myLatLng = {lat: latitude, lng: longitude};
                
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: myLatLng,
                        streetViewControl: false,
                        zoomControl: true,
                        fullscreenControl: false,
                        mapTypeControl: false,
                        zoom: 14,
                        styles: [
                                {
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#f5f5f5"
                                    }
                                    ]
                                },
                                {
                                    "elementType": "labels.icon",
                                    "stylers": [
                                    {
                                        "visibility": "off"
                                    }
                                    ]
                                },
                                {
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#616161"
                                    }
                                    ]
                                },
                                {
                                    "elementType": "labels.text.stroke",
                                    "stylers": [
                                    {
                                        "color": "#f5f5f5"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "administrative.land_parcel",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#bdbdbd"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#eeeeee"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#757575"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi.park",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#e5e5e5"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "poi.park",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#9e9e9e"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#ffffff"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.arterial",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#757575"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#dadada"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.highway",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#616161"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "road.local",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#9e9e9e"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "transit.line",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#e5e5e5"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "transit.station",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#eeeeee"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "geometry",
                                    "stylers": [
                                    {
                                        "color": "#c9c9c9"
                                    }
                                    ]
                                },
                                {
                                    "featureType": "water",
                                    "elementType": "labels.text.fill",
                                    "stylers": [
                                    {
                                        "color": "#9e9e9e"
                                    }
                                    ]
                                }
                            ]

                    });

                    var marker = new google.maps.Marker({
                        position: myLatLng,
                        animation: google.maps.Animation.DROP,
                        map: map,
                        icon:  '<?php echo get_bloginfo('template_directory'); ?>/images/map-marker.png'
                    });

                    
                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqNFeILeo54DiD7S61Uujr-Ec9ZtS7FU8&callback=myMap"></script>

        <?php endif; ?>

    </div>
    <?php ?>
