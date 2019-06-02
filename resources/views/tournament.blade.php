@extends('layouts.skeleton')

@section('content')
    <div class="container">
        <div class="content">

            <p class="title">Tournament</p>

            <div class="show-cards">
                @foreach($matches as $round => $team)
                    <div class="card" style="width: 18rem; margin: 5px;">
                        <div class="card-header">
                            Round {{ ($round + 1) }}
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($team as $match)
                                <li class="list-group-item">
                                    ({{ $match['local']->id }}) {{ $match['local']->name }}
                                    vs
                                    {{ $match['visitant']->name }} ({{ $match['visitant']->id }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection