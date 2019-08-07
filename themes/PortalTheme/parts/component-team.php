<?php 
    $copy = $values['copy'];
    $user = 'user_'. get_current_user_id() ;
?>

<div class="container small-padding min-600">

    <div class="mt-5">
        <h1>Meet your team</h1>
    </div>
    
    <div class="session-info">

        <!-- Account manager -->
        <?php 
            $account_manager_id = get_field('account_manager', $user);

            if ($account_manager_id): 
                $image = get_field('picture', $account_manager_id );
                $name =  get_the_title($account_manager_id ); 
                $description = get_field('description', $account_manager_id ); 
                $bio = get_field('bio', $account_manager_id ); ?>
                            
                <div class="row p-0 mt-4">

                    <div class="col-12 col-md-4 col-lg-3 col-xl-2 p-0">
                        <img class="my-2 my-md mx-auto mx-md-0 d-block avatar-big rounded-img" src="<?php echo $image ?> "/>    
                    </div>
                        
                    <div class="col-12 col-md-8 col-lg-9 col-xl-10 p-0">
                        <div class="h-100 d-flex mt-3">
                            <div class="w-100 text-center text-md-left">

                                <p class="subtitle m-0 d-block d-md-inline-block">Your account manager</p>
                                <i class="fas fa-plus ml-0 ml-sm-4 plus" data-toggle="collapse" href="#bio-<?php echo $account_manager_id ?>"  aria-controls="bio" ></i></a>
                                <p class="name m-0"><?php echo $name ?></p>
                                <p class="m-0"><?php echo $description ?></p>

                                <div class="collapse mt-3" id="bio-<?php echo $account_manager_id ?>">
                                    <?php echo $bio ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                    
        <?php endif; ?>

        <!-- Point of contact -->
        <?php 
            $point_contact_id = get_field('point_of_contact', $user);

            if ($point_contact_id): 
                $image = get_field('image', $point_contact_id);
                $name =  get_the_title($point_contact_id); 
                $description = get_field('description', $point_contact_id); 
                $bio = get_field('bio', $point_contact_id );?>
                            
                <div class="row p-0 mt-4">
                    <div class="col-12 col-md-4 col-lg-3 col-xl-2 p-0">
                        <img class="my-2 my-md mx-auto mx-md-0 d-block avatar-big rounded-img" src="<?php echo $image ?> "/>    
                    </div>
                            
                    <div class="col-12 col-md-8 col-lg-9 col-xl-10 p-0">
                        <div class="h-100 d-flex mt-3">
                            <div class="w-100 text-center text-md-left">
                                <p class="subtitle m-0 d-block d-md-inline-block">Your point of contact</p>
                                <i class="fas fa-plus ml-4 plus" data-toggle="collapse" href="#bio-<?php echo $point_contact_id ?>"  aria-controls="bio" ></i></a>
                                <p class="name m-0"><?php echo $name ?></p>
                                <p class="m-0"><?php echo $description ?></p>

                                <div class="collapse mt-3" id="bio-<?php echo $point_contact_id ?>">
                                    <?php echo $bio ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            <?php endif;
        ?>

        <!-- Trainers -->
        <?php 

            //Current delegate
            if ($user_delegate) {
                $current_delegate = $user_delegate;
            }
            else {
                $current_delegate = get_current_user_id();
            }

           /* Get all trainers from the user's agendas */
            $trainers_user = array();
            $args = array(
                'numberposts' => -1,
                'post_type'   => 'agendas',
            );
            $agendas = get_posts( $args );

            foreach ($agendas as $agenda):
                $agenda_id = $agenda->ID;
                $delegates = get_field('delegates', $agenda_id );
                
                if ($delegates):
                    foreach ($delegates as $single_delegate_id): 
                                    
                        if( $single_delegate_id == $current_delegate ): 
                            $trainers_agenda = get_field('trainers', $agenda_id);
                            foreach ($trainers_agenda as $trainer_agenda){

                                if (!in_array($trainer_agenda, $trainers_user)) {
                                    array_push($trainers_user, $trainer_agenda);
                                }
                            }
                        endif;
                    endforeach;
                endif;

            endforeach;
                    
            //Show trainers
            if ($trainers_user): 
                foreach ($trainers_user as $trainer):
                    $trainer_id = $trainer;
                    $name =  get_the_title($trainer_id); 
                    $image = get_field('picture', $trainer_id );
                    $description = get_field('description', $trainer_id );
                    $bio = get_field('bio', $trainer_id );
                ?>

                <div class="row p-0 mt-4">

                    <div class="col-12 col-md-4 col-lg-3 col-xl-2 p-0">
                        <img class="my-2 my-md mx-auto mx-md-0 d-block avatar-big rounded-img" src="<?php echo $image ?> "/>    
                    </div>

                    <div class="col-12 col-md-8 col-lg-9 col-xl-10 p-0">
                        <div class="h-100 d-flex mt-3">
                            <div class="w-100 text-center text-md-left">

                                <p class="subtitle m-0 d-block d-md-inline-block">Your trainer</p>
                                <i class="fas fa-plus ml-4 plus" data-toggle="collapse" href="#bio-<?php echo $trainer_id ?>"  aria-controls="bio" ></i></a>
                                <p class="name m-0"><?php echo $name ?></p>
                                <p class="m-0"><?php echo $description ?></p>

                                <div class="collapse mt-3" id="bio-<?php echo $trainer_id ?>">
                                    <?php echo $bio ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <?php endforeach;
            endif; ?>

            </div>

    </div>
    
