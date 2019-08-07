<?php ?>

<hr class="m-0" style="width: 180px; border-top: 7px solid #EEDF00">

<?php
/* Account manager */
          
$user = 'user_'. get_current_user_id() ;

$account_manager_id = get_field('account_manager', $user);
if ($account_manager_id): 
    $image = get_field('picture', $account_manager_id );
    $name =  get_the_title($account_manager_id ); 
    $description = get_field('description', $account_manager_id ); 
    $bio = get_field('bio', $account_manager_id ); ?>
                            
    <div class="row p-0">

        <div class="col-3 p-0">
            <img class="my-2 d-block avatar-big rounded-img" src="<?php echo $image ?> "/>    
        </div>
                        
        <div class="col-9 p-0">
            <div class="h-100 d-flex mt-3">
                <div class="w-100 text-center text-md-left">
                    <p class="role m-0 d-block d-md-inline-block">Account manager</p>
                    <p class="name m-0"><?php echo $name ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; 

/* Point of contact */

$point_contact_id = get_field('point_of_contact', $user);

if ($point_contact_id): 
    $image = get_field('image', $point_contact_id);
    $name =  get_the_title($point_contact_id); 
    $description = get_field('description', $point_contact_id); 
    $bio = get_field('bio', $point_contact_id );?>
                            
    <div class="row p-0">
        <div class="col-3 p-0">
            <img class="my-2 d-block avatar-big rounded-img" src="<?php echo $image ?> "/>    
        </div>
                            
        <div class="col-9 p-0">

            <div class="h-100 d-flex mt-3">
                <div class="w-100 text-center text-md-left">
                    <p class="role m-0 d-block d-md-inline-block">Point of contact</p>
                    <p class="name m-0"><?php echo $name ?></p>
                </div>
             </div>
        </div>
    </div>
                    
<?php endif; ?>
