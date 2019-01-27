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
