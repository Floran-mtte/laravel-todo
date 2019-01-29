@extends('layouts.app')

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
                        <button type="submit" class="btn btn-primary mb-2">Add task</button>
                    </div>

                </div>
            </form>
            <hr>
        </div>
        <div class="col-md-12" id="response">
        </div>
</div>
@endsection

<style>
    .home-title {
        text-align: center;
    }

    .task-form {
        margin: auto;
        width: 80%;
    }
</style>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script>
    $(function() {

        $.ajax({
            url: '/tasks',
            method : 'GET',
            dataType : 'json',
        })
            .done(function(data, status) {
                let response = data;
                console.log(response);
                for (let i in response.data)
                {
                    let taskId = response.data[i].id;
                    let taskName = response.data[i].name;
                    $('#response').append('<div class="taskLine">'+taskId+' - '+taskName+'</div>');
                }

                let currentPage = response.current_page;
                let nextPageUrl = response.next_page_url;
                let lastPageUrl = response.last_page_url;
                $('#response').append('<div class="pagination"></div>');
                if(currentPage !== 1)
                {
                    let firstPageUrl  = response.first_page_url;
                    $('.pagination').append('<li class="page-item"><a class="page-link" href="'+firstPageUrl+'">Previous</a></li>');
                }

                $('.pagination').append('<li class="page-item"><a class="page-link" href="#">'+currentPage+'</a></li>');
                $('.pagination').append('<li class="page-item"><a class="page-link" href="'+nextPageUrl+'">Next</a></li>');
                $('.pagination').append('<li class="page-item"><a class="page-link" href="'+lastPageUrl+'">Last</a></li>');

            })
            .fail(function (data, status, error) {

            });
    })
</script>