$(function(){
    //define variables
    var activeNote = 0;
    var editMode = false;
    //load notes on page load: Ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function (data){
            $('#notes').html(data);
            clickonNote(); 
            clickonDelete();    
        },
        error: function(){
            $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
            $("#alert").fadeIn();
        }
    });
    
    //add a new note: : Ajax call to createnote.php
    $('#addNote').click(function(){
        $.ajax({
            url: "createnote.php",
            success: function(data){        //如果Ajax可行，这里的data是用来表示note的id的
                if(data == 'error'){
                    $('#alertContent').text("There was an issue inserting the new note in the database.");
                    $("#alert").fadeIn();
                }else{
                    //update activeNote to the id of the new note
                    activeNote = data;      //一开始activeNote设置的时候值为0，如果可行，就设置为此时的note的id
                    $("textarea").val("");  //确保一开始textarea上什么都没有
                    //show hide elements
                    showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                    $("textarea").focus();           
                }
            },
            error: function(){
                $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                $("#alert").fadeIn();
            }     
        });   
    });

    
    //type note: : Ajax call to updatenote.php
    $("textarea").keyup(function(){         //因为keyup发生在当前获取焦点的元素上，所以上面的textarea.focus()
        //ajax call to update the task of id activenote
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            //we need to send the current note content with its id to the php file
            data: {note: $(this).val(), id:activeNote},         //这个data和下面的不是一个
            success: function (data){
                if(data == 'error'){
                    $('#alertContent').text("There was an issue updating the note in the database!");
                    $("#alert").fadeIn();
                }
            },
            error: function(){
                $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                $("#alert").fadeIn();
            }
        });       
    });
    
    //click on all notes button
    $("#allNotes").click(function(){
        $.ajax({
            url: "loadnotes.php",
            success: function (data){
                $('#notes').html(data);
                showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad"]);
                clickonNote(); 
                clickonDelete();
            },
            error: function(){
                $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                $("#alert").fadeIn();
            }
        });   
    });
    
    //click on done after editing: load notes again
    $("#done").click(function(){
        //siwtch to non edit mode
        editMode = false;
       //expand notes
        $(".noteheader").removeClass("col-xs-7 col-sm-9");
        //show hide elements
        showHide(["#edit"],[this, ".delete"]);
    });
    
    
    //click on edit: go to edit mode (show delete buttons, ...)
    $("#edit").click(function(){
        //switch to edit mode
        editMode = true;
        //reduce the width of notes
        $(".noteheader").addClass("col-xs-7 col-sm-9");
        //show hide elements
        showHide(["#done", ".delete"],[this]);   //this指代edit本身
    });
    
      
    //functions
    //click on a note，也就是点了相应的note转到只有那个note要编辑的区域
    function clickonNote(){              
        $(".noteheader").click(function(){
            if(!editMode){
                //update activeNote variable to id of note
                activeNote = $(this).attr("id");
                
                //fill text area
                $("textarea").val($(this).find('.text').text());//find('.text')是相对于time而言的，因为每个noteheader都是有text和time
                //show hide elements
                showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                $("textarea").focus();
            }
        });
    }
    
    //click on delete
    function clickonDelete(){
        $(".delete").click(function(){
            var deleteButton = $(this);
            //send ajax call to delete note
            $.ajax({
                url: "deletenote.php",
                type: "POST",
                //we need to send the id of the note to be deleted
                data: {id:deleteButton.next().attr("id")},    //指的是loadnotes.php中的echo那句，.delete的next是noteheader这个div，中的attr("id")
                success: function (data){
                    if(data == 'error'){
                        $('#alertContent').text("There was an issue delete the note from the database!");
                        $("#alert").fadeIn();
                    }else{
                        //remove containing div
                        deleteButton.parent().remove();       //这边是把.delete的parent删除，就是整个note的div删除
                    }
                },
                error: function(){
                    $('#alertContent').text("There was an error with the Ajax Call. Please try again later.");
                    $("#alert").fadeIn();
                }
            });            
        });      
    }
    
    //show Hide function     
    function showHide(array1, array2){
        for(i=0; i<array1.length; i++){
            $(array1[i]).show();   
        }
        for(i=0; i<array2.length; i++){
            $(array2[i]).hide();   
        }
    }; 
});