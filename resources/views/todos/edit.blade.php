@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Editer une todo <span class="badge badge-dark"> #{{$todo->id}}</span>
    </div>
    <div class="card-body">
    <form method="post" action="{{ route('todos.update', $todo->id) }}">
        @csrf
        @method('PUT')
            <div class="form-group">
                <label for="exampleInputEmail1">Titre</label>
            <input type="text" name="name" value="{{ old('name', $todo->name) }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Entrez votre nouvelle todos</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <input type="text" name="description" value={{ old('description',$todo->description) }} class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="done" id="done" {{ $todo->done ? 'checked' : ''  }} value=1>
                <label for="done" class="form-check-label">Done ?</label>
            </div>
            <button type="submit" class="btn btn-primary">Editer</button>
    </form>
    </div>
</div>



@stop