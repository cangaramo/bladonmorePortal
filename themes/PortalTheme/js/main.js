//Document ready
$(document).ready(function () {


    /** OPEN QUESTIONNAIRE */
    $( ".openQuestionnaire" ).click(function() {
        //Change icon
        index =  $('.openQuestionnaire').index(this) ;
        status = $(".openQuestionnaire img").data("status");
        console.log(status);
        if (status == "closed") {
            path_up = $(".openQuestionnaire img").attr("up");
            $(".openQuestionnaire img").eq(index).attr("src", path_up );
            status = $(".openQuestionnaire img").data("status", "open");
        }
        else {
            path_down = $(".openQuestionnaire img").attr("down");
            $(".openQuestionnaire img").eq(index).attr("src", path_down );
            status = $(".openQuestionnaire img").data("status", "closed");
        }
        
    });

    /*** LOAD AGENDAS ***/

    $( ".openAgenda" ).click(function() {
        //Hide others
        $(".infoAgenda").collapse('hide');

        //Get index
        index =  $('.openAgenda').index(this) ;

        //Change icon
        path_up = $(".openAgenda img").attr("up");
        $(".openAgenda img").eq(index).attr("src", path_up );

        //Show
        agenda = $(".infoAgenda").eq(index);
        post_id = agenda.attr("id");
        action = agenda.attr("action");
        agenda.collapse('show');
        LoadAgenda(index, post_id, action);
    });

    //Empty box when hidden
    $('.infoAgenda').on('hidden.bs.collapse', function () {

        //Empty
        $(this).children().empty();

        //Change icon
        index =  $('.infoAgenda').index(this) ;
        path_down = $(".openAgenda img").attr("down");
        $(".openAgenda img").eq(index).attr("src", path_down);

    })

    /*** LOAD FEEDBACK ***/

    $( ".openFeedback" ).click(function() {
        //Hide others
        $(".infoFeedback").collapse('hide');
    
        //Get index
        index =  $('.openFeedback').index(this) ;
    
        //Change icon
        path_up = $(".openFeedback img").attr("up");
        $(".openFeedback img").eq(index).attr("src", path_up );
    
        //Show
        feedback = $(".infoFeedback").eq(index);
        post_id = feedback.attr("id");
        action = feedback.attr("action");
        feedback.collapse('show');
        LoadFeedback(index, post_id, action);
    });
    
    //Empty box when hidden
    $('.infoFeedback').on('hidden.bs.collapse', function () {
    
        //Empty
        $(this).children().empty();
    
        //Change icon
        index =  $('.infoFeedback').index(this) ;
        path_down = $(".openFeedback img").attr("down");
        $(".openFeedback img").eq(index).attr("src", path_down);
    
    })

    /** LOAD VIDEOS */
    $( ".openVideo" ).click(function() {
        //Hide others
        $(".infoVideo").collapse('hide');
    
        //Get index
        index =  $('.openVideo').index(this) ;
    
        //Change icon
        path_up = $(".openVideo img").attr("up");
        $(".openVideo img").eq(index).attr("src", path_up);
    
        //Show
        video = $(".infoVideo").eq(index);
        post_id = video.attr("id");
        action = video.attr("action");
        video.collapse('show');
        LoadVideo(index, post_id, action);
    });
    
    //Empty box when hidden
    $('.infoVideo').on('hidden.bs.collapse', function () {
    
        //Empty
        $(this).children().empty();
    
        //Change icon
        index =  $('.infoVideo').index(this) ;
        path_down = $(".openVideo img").attr("down");
        $(".openVideo img").eq(index).attr("src", path_down );
    
    })

    //OPEN DELEGATE 
    $('.infoDelegate').on('show.bs.collapse', function () {
        //Change icon
        index =  $('.infoDelegate').index(this) ;
        path_up = $(".openDelegate img").attr("up");
        $(".openDelegate img").eq(index).attr("src", path_up);
    })

    $('.infoDelegate').on('hide.bs.collapse', function () {
        index =  $('.infoDelegate').index(this) ;
        path_down = $(".openDelegate img").attr("down");
        $(".openDelegate img").eq(index).attr("src", path_down);
    })

    ajaxEvents();

});

$(document).ajaxComplete(function() {
    ajaxEvents();
});

function ajaxEvents(){
    //OPEN QUESTIONS
    $( "#openQuestions" ).click(function() {
        $('.questions-wrap').slideToggle();
    });

    //APROVE BUTTON
    $( ".approve" ).click(function() {

        disable = $(this).hasClass("disable");

        if (!disable) {

            //Prepara form for AJAX
            post_id = $(this).data("id");
            post_type = $(this).data("type");
            action = $(this).attr("action");
            $('#approveAlert').attr("post_id", post_id);
            $('#approveAlert').attr("post_type", post_type);
            $('#approveAlert').attr("action", action);

            //Open form
            $('#approveAlert').modal("show");
        }
    });

    //CONFIRM APPROVE BUTTON
    $( "#approveAlert #confirmApprove" ).unbind().click(function() {

        //Show confirmation 
        $('.alert-confirmation').slideToggle("fast");
        $('.alert-confirmation span').show();

        setTimeout(function () {
                $('.alert-confirmation span').hide();
                $('.alert-confirmation').slideToggle();
            }, 3000); 
        
        //Gray out labels
        $('.approve').addClass("disable");
        $('.request').addClass("disable");

        //Ajax        
        post_id = $('#approveAlert').attr("post_id");
        post_type = $('#approveAlert').attr("post_type");
        action = $('#approveAlert').attr("action");
        status = "Approved";
        updateStatus(post_id, post_type, action, status);     
    });

    //REQUEST CHANGE FORM
    $( ".request" ).click(function() {

        disable = $(this).hasClass("disable");

        if (!disable) {

            //Change values in form
            link = $(this).data('item');
            $('#field_7_4 #input_7_4').val(link);

            //Prepara form for AJAX
            post_id = $(this).data("id");
            post_type = $(this).data("type");
            action = $(this).attr("action")

            $('#requestForm').attr("post_id", post_id);
            $('#requestForm').attr("post_type", post_type);
            $('#requestForm').attr("action", action);

            //Open form
            $('#requestForm').modal("show");
        }

    });

    //SUBMIT REQUEST
    $( "#requestForm :submit" ).click(function() { 

        //Gray out request
        $('.request').addClass("disable");
        $('.request span').text("Changes requested");
        $('.request i').removeClass("fas fa-times-circle");
        $('.request i').addClass("far fa-clock");
        

        post_id = $('#requestForm').attr("post_id");
        post_type = $('#requestForm').attr("post_type");
        action = $('#requestForm').attr("action");
        status = "Awaiting feedback";

        console.log(post_id);
        console.log(post_type);
        console.log(action);
        console.log(status);

        //Ajax
        updateStatus(post_id, post_type, action, status);

    });
}


//AGENDA AJAX
function LoadAgenda(index, post_id, action){

    var ajaxurl = action;

     $.ajax({
         url: ajaxurl,
         type : 'post',
         data : {
			action : 'load_agendas',
			post_id : post_id
		},
         beforeSend:function(xhr){
             /* Before send */

         },
         success:function(response){
            //Make sure the panels are empty
            $('.infoAgenda .content').empty();
            if ( $('.infoAgenda .content').eq(index).children().length == 0 ){
                $('.infoAgenda .content').eq(index).append(response).hide().fadeIn();
            } 

         }
     });
 return false;
}

//FEEDBACK AJAX
function LoadFeedback(index, post_id, action){

    var ajaxurl = action ;

     $.ajax({
         url: ajaxurl,
         type : 'post',
         data : {
			action : 'load_feedbacks',
			post_id : post_id
		},
         beforeSend:function(xhr){
             /* Before send */

         },
         success:function(response){
            //Make sure the panels are empty
            $('.infoFeedback .content').empty();
            if ( $('.infoFeedback .content').eq(index).children().length == 0 ){
                $('.infoFeedback .content').eq(index).append(response).hide().fadeIn();
            } 

         }
     });
 return false;
}

//VIDEOS AJAX
function LoadVideo(index, post_id, action){

    var ajaxurl = action;

     $.ajax({
         url: ajaxurl,
         type : 'post',
         data : {
			action : 'load_videos',
			post_id : post_id
		},
         beforeSend:function(xhr){
             /* Before send */

         },
         success:function(response){
            //Make sure the panels are empty
            $('.infoVideo .content').empty();
            if ( $('.infoVideo .content').eq(index).children().length == 0 ){
                $('.infoVideo .content').eq(index).append(response).hide().fadeIn();
            } 

         }
     });
 return false;
}

//UPDATE STATUS AJAX
function updateStatus(post_id, post_type, action, status){

    var ajaxurl = action;

    $.ajax({
        url: ajaxurl,
        type : 'post',
        data : {
            action : 'update_status',
            post_id : post_id,
            post_type : post_type,
            status : status,
        },
        beforeSend:function(xhr){
            /* Before send */

        },
        success:function(response){
            //Make sure the panels are empty

        }
    });
    return false;
}
