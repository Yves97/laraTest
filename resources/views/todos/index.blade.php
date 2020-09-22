@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mx-auto">
            <div class="col-xs m-3">
                <a name="" id="" href="{{  route('todos.create') }}" class="btn btn-primary" role="button">Ajouter une todo</a>
            </div>
            @if(Route::currentRouteName() == 'todos.index')
            <div class="col-xs m-3">
                <a name="" id="" href="{{  route('todos.undone') }}" class="btn btn-warning" role="button">Voir les todo ouvertes</a>
            </div>
            <div class="col-xs m-3">
                <a name="" id="" href="{{  route('todos.done') }}" class="btn btn-success" role="button">Voir les todo terminés</a>
                @elseif(Route::currentRouteName() == 'todos.done')
                <div class="col-xs m-3">
                    <a name="" id="" href="{{  route('todos.index') }}" class="btn btn-dark" role="button">Voir toutes les todos</a>
                </div>
                <div class="col-xs m-3">
                    <a name="" id="" href="{{  route('todos.undone') }}" class="btn btn-warning" role="button">Voir toutes les todos ouvertes</a>
                @elseif(Route::currentRouteName() == 'todos.undone')
                <div class="col-xs m-3">
                    <a name="" id="" href="{{  route('todos.index') }}" class="btn btn-dark" role="button">Voir toutes les todos</a>
                </div>
                <div class="col-xs m-3">
                    <a name="" id="" href="{{  route('todos.done') }}" class="btn btn-success" role="button">Voir les todo terminés</a>
                </div>
            @endif
        </div>
    </div>
    @if(count($data))

        
            @foreach ($data as $item)
            <div class="alert alert-{{  $item->done ? 'success' : 'warning'   }}" role="alert">
                <div class="row">
                    <div class="col-sm">
                        <p class="my-0">
                            <strong>
                                <span class="badge badge-dark"> #{{$item->id}} </span>
                            </strong>
                        </p>
                        <details>
                            <summary>   
                                <strong>{{  $item->name  }}   
                                    @if($item->done)
                                        <span class="badge badge-success">done</span>
                                    @endif
                                </strong>
                            </summary>
                            <p> {{ $item->description  }} </p>
                        </details>
                        <small>
                            Créé {{$item->created_at->from()}} par 
                            {{ Auth::user()->id == $item->id ? 'moi' : $item->name }}
                            @if($item->todoAffectedTo && $item->todoAffectedTo->id == Auth::user()->id)
                                ,Affecté a moi
                            @elseif($item->todoAffectedTo)
                                {{   $item->todoAffectedTo ? ',affecté a '.$item->todoAffectedTo->name : '' }}
                            @endif
                            {{-- display affected by someone or by user himself --}}
                            @if($item->affectedTo && $item->affectedBy && $item->affectedBy->id == Auth::user()->id )
                                Par moi même
                            @elseif($item->affectedTo && $item->affectedBy && $item->affectedBy->id != Auth::user()->id)
                                Par {{ $item->affectedBy->name  }}
                            @endif
                        </small>
                        @if($item->done)
                            <small>
                                Terminé
                                {{ $item->updated_at->from() }} - Terminé en 
                                {{ $item->updated_at->diffForHumans($item->created_at,1) }}
                                
                            </small>
                        @endif
                    </div>
                    <div class="col-sm form-inline justify-content-end">
                        {{-- Button affected to --}}
                        <div class="dropdown open">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Affecter à
                                    </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach ($users as $user)
                                    <a class="dropdown-item" href="/todos/{{$item->id}}/affectedTo/{{$user->id }}">{{  $user->name  }}</a>
                                @endforeach
                            </div>
                        </div>
                        {{-- button done / undone --}}
                        @if($item->done == 0)
                    <form action="{{ route('todos.makedone', $item->id) }}" method="post">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-success mx-1" style="min-width: 90px;">done</button>
                            </form>
                        @else
                            <form action="{{ route('todos.makeundone', $item->id) }}" method="post">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-warning mx-1" style="min-width: 90px;">undone</button>
                            </form>
                        @endif
                        {{-- button edit --}}
                        @can('edit', $item)
                            <a name="" id="" class="btn btn-info mx-1" href="{{ route('todos.edit', $item->id) }}" role="button">Editer</a>
                        @elsecannot('edit',$item)
                            <a name="" id="" class="btn btn-info mx-1 disabled" href="{{ route('todos.edit', $item->id) }}" role="button">Editer</a>
                        @endcan
                        {{-- button delete --}}
                        @can('delete',$item)
                            <form action="{{ route('todos.destroy',$item->id)}}" method="post">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-1">effacer</button>
                            </form>
                        @elsecannot('delete',$item)
                            <form action="{{ route('todos.destroy',$item->id)}}" method="post">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-1" desabled>effacer</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach
            {{  $data->links() }}
    @endif
    
@endsection