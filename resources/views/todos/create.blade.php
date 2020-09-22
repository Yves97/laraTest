@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            Ajout d'une nouvelle todo
        </div>
        <div class="card-body">
        <form method="post" action="{{ route('todos.store')  }}">
            @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Titre</label>
                  <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entrez votre titre">
                  <small id="emailHelp" class="form-text text-muted">Entrez votre nouvelle todos</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  <input type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="Description">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    </div>



@stop