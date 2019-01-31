@section('content')
    <div class="container">
        <div class="col-md-12">
            <h1 class="home-title">Laravel Task</h1>
            <form method="post" class="task-form">
                <div class="form-row">
                    <div class="col-md-10">
                        <label class="sr-only" for="taskName">Task name</label>
                        <input type="text" class="form-control" id="taskName" name="taskName" aria-describedby="The name of your task" placeholder="Enter task name">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary mb-2" id="addTask">Add task</button>
                    </div>
                </div>
            </form>
            <hr>
        </div>
        <div class="col-md-12" id="response"></div>

        <div id="updateModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="updateName">Task name : </label>
                        <input type="text" class="input-group" name="task_name" id="updateName">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="updateTask($('#updateName').data('id'))">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

<style>
    #response {
        width: 50%;
        margin: auto;
    }
    .home-title {
        text-align: center;
    }

    .task-form {
        margin: auto;
        width: 80%;
    }
    .taskLine {
        display: flex;
        margin-bottom: 10px;
    }

    .textPart {
        width: 100%;
    }

    .commandLine {
        width: 100%;
        text-align: right;
    }

    .pagination {
        width: 50%;
        margin: auto;
    }
    .editTask {
        border: 1px solid black;
        padding: 3px;
        color : black;
        cursor: pointer;
        margin-left: 5px;
    }

    .deleteTask {
        border: 1px solid black;
        padding: 3px;
        color : black;
        cursor: pointer;
    }
</style>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>
    $(function() {
        loadTask('/tasks');

        $('#addTask').on('click', function (e) {
            e.preventDefault();

            let taskName = $('#taskName').val();
            
            $.ajax({
                url:'/task',
                method: 'POST',
                dataType: 'JSON',
                data: 'name='+taskName,
            })
                .done(function (data, status) {
                    $('#taskName').val('');
                    if(data.status === "success") {
                        let taskId = data.id;

                        $('#response').prepend('<div class="taskLine" id="'+taskId+'"><span class="textPart">'+taskName+'</span></div>');
                        $('#response > #'+taskId).append('<div class="commandLine"></div>');
                        $('#response > #'+taskId+' > .commandLine').append('<span class="editTask" data-id="'+taskId+'" onclick="updateMode($(this).data(\'id\'))">Edit</span> | <span class="deleteTask" onclick="deleteTask($(this).data(\'id\'));" data-id="'+taskId+'">Delete</span>');

                        $('.task-form').prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"></div>');
                        $('.alert').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your task is created !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');



                    }

                })
                .fail(function (data, status, error) {
                    
                })
            
        })

    });

    function deleteTask(id) {
        $.ajax({
            url:'/task/'+id,
            method: 'post',
            dataType: 'json',
        })
            .done(function (data, status) {
                if(data.status === "success")
                {
                    $('#'+id).remove();

                }
            })
            .fail(function (data, status, error) {

            })
    }

    function updateTask(id) {
        let updateName = $('#updateName').val();

        $.ajax({
            url:'/task/'+id,
            method:'PUT',
            dataType: 'JSON',
            data: 'name='+updateName
        })
            .done(function (data, status) {
                if(data.status === 'success')
                {
                    $('#'+id+' > .textPart').html('');
                    $('#'+id+' > .textPart').append(id+' - '+updateName);
                    $('#updateModal').modal('hide');
                }
            })
            .fail(function (data, status) {

            })
    }

    function updateMode(id) {
        $('#updateModal').modal();
        $('#updateName').attr('data-id',id);

    }

    function loadTask(url) {
        $('#response').html('');
        $.ajax({
            url: url,
            method : 'GET',
            dataType : 'json',
        })
            .done(function(data, status) {
                let response = data;
                for (let i in response.data)
                {
                    let taskId = response.data[i].id;
                    let taskName = response.data[i].name;
                    $('#response').append('<div class="taskLine" id="'+taskId+'"><span class="textPart">'+taskName+'</span></div>');
                    $('#response > #'+taskId).append('<div class="commandLine"></div>');
                    $('#response > #'+taskId+' > .commandLine').append('<span class="editTask" data-id="'+taskId+'" onclick="updateMode($(this).data(\'id\'))">Edit</span> | <span class="deleteTask" onclick="deleteTask($(this).data(\'id\'));" data-id="'+taskId+'">Delete</span>');
                }

                let currentPage = response.current_page;
                let nextPageUrl = response.next_page_url;
                let lastPageUrl = response.last_page_url;
                $('#response').append('<div class="pagination"></div>');
                if(currentPage !== 1)
                {
                    let prevPageUrl  = response.prev_page_url;
                    $('.pagination').append('<li class="page-item"><a class="page-link" onclick=\'loadTask("'+prevPageUrl+'")\'>Previous</a></li>');
                }

                $('.pagination').append('<li class="page-item"><a class="page-link" href="#">'+currentPage+'</a></li>');

                if(nextPageUrl != null)
                {
                    $('.pagination').append('<li class="page-item"><a class="page-link" onclick=\'loadTask("'+nextPageUrl+'")\'>Next</a></li>');
                }
                if(url != lastPageUrl)
                {
                    $('.pagination').append('<li class="page-item"><a class="page-link" onclick=\'loadTask("'+lastPageUrl+'")\'>Last</a></li>');
                }


            })
            .fail(function (data, status, error) {

            });
    }

</script>