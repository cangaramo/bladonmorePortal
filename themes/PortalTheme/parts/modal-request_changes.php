<!-- Modal -->
<div class="modal fade" id="requestForm" post_id="" action="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">Request changes</h5>
                    <p class="mt-2">Please detail any changes you would like to make to this agenda in the form below. </p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <?php gravity_form( 7, $display_title = false, $display_description = false,  $ajax = true, $tabindex, $echo = true ); ?>
            </div>
            
        </div>
    </div>
</div>