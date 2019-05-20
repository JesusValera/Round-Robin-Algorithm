@extends('layouts.skeleton')

@section('content')
    <div class="container">
        <div class="content">

            <p class="title">Teams</p>

            <div class="show-cards">
                @foreach($teams as $team)
                    @if(count($team->images) === 0)
                        {{-- Teams without logo below. --}}
                        <div class="card bg-white text-black" style="width: 16rem; margin: 5px;">
                            <img class="card-img" src="https://dummyimage.com/300/fff/aaa" alt="Team logo">
                            <div class="card-img-overlay">
                                <h4 class="card-title">{{ $team->name }}</h4>
                            </div>
                        </div>
                    @else
                        @foreach($team->images as $image)
                            <div class="card bg-white text-black" style="width: 16rem; margin: 5px;">
                                <img class="card-img" src="{{ $image->source }}" alt="Team logo">
                                <div class="card-img-overlay">
                                    <h4 class="card-title">{{ $team->name }}</h4>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
