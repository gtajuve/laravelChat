
$(document).ready(function(){

    var url = "/chatAjax";

    //display modal form for task editing
    $('.open-modal').click(function(){
        var message_id = $(this).val();

        $.get(url + '/' + message_id, function (data) {
            //success data
            console.log(data);
            $('#message_id').val(data.id);
            $('#mess').val(data.message);
            $('#btn-save').val("update");
            $('#ok').val("hsdjfhjksdbfjsd");

            $('#myModal').modal('show');
        })
    });

    //display modal form for creating new task
    $('#btn-add').click(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        e.preventDefault();

        var formData = {
            message: $('#messAdd').val(),
            teams:$('#teams').val()
        }
        var type = "POST";

        $.ajax({

            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var message='<div class="row"><div id="cred'+data.id+'"><div class="col-md-1 "><h3>'+ data.name +'</h3></div><div class="col-md-2 ">'+data.updated_at+'</div> </div>';
                message += ' <div id="mess' + data.id + '"><div class="col-md-6 "><h4>' + data.message + '</h4> </div>';
                message += '<div class="col-md-3 "><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                message += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="'+data.id+'">Delete</button></dir></dir>';
                $('#message-list').append(message);
                $('#messAdd').val('');
                location.reload(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });


    });

    //delete task and remove it from list
    $('.delete-task').click(function(e){
        e.preventDefault();
        var message_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        $.ajax({

            type: "DELETE",
            url: url + '/' + message_id,
            success: function (data) {
                console.log(data);

                $("#mess" + message_id).remove();
                $("#cred" + message_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

        var formData = {
            message: $('#mess').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var message_id = $('#message_id').val();
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + message_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var message = ' <div id="mess' + data.id + '"><div class="col-md-6 "><h4>' + data.message + '</h4> </div>';
                message += '<div class="col-md-3 "><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                message += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="'+data.id+'">Delete</button>';

                if (state == "add"){ //if user added a new record
                    $('#tasks-list').append(message);
                }else{ //if user updated an existing record

                    $("#mess" + message_id).replaceWith( message );
                }

                $('#frmTasks').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});/**
 * Created by joro on 11/21/16.
 */
