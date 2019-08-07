<?php

    require('query-get_documents.php');
    
?>

<!-- AGENDA -->			
<div class="container small-padding min-650">

    <!-- Title -->
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-8 order-2 order-lg-1 mt-4 mt-lg-5">
                <h1>Documents</h1>
        </div>
         <div class="col-12 col-lg-6 col-xl-4 order-1 order-lg-2 ">
            <?php require('part-team_top.php'); ?>
        </div>
    </div>

    <!-- Sessions list -->
    <div class="mt-4">
        <hr class="m-0">
        <?php 

        if (!empty($selected_documents)):
            foreach ($selected_documents as $index=>$document):
                $document_id = $document->ID;  
                $title = get_the_title($document_id);
                $file = get_field('file', $document_id);
                $link = get_the_permalink($document_id);
            ?>

                <div class="p-0 px-3 px-lg-4 py-4 list-item ">
                    <i class="far fa-file mr-4"></i><a class="title link m-0" href="<?php echo $file ?>" target="_blank"><?php echo $title ?></a>
                </div>

                <hr class="m-0">

            <?php endforeach;  

        else: ?>
            <p class="no-sessions">No upcoming sessions</p>
        <?php endif; ?>

    </div>

</div>
