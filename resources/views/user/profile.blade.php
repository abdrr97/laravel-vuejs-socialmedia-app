@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card ">

                <div class="card-body text-center">
                    <h1>{{ $user->name }}</h1>
                    <small>{{$user->email}}</small>
                    <hr>
                    <follow :user-id="{{ $user->id }}" :is-following="{{ $user->is_following() ? 'true' : 'false' }}" />

                </div>
            </div>

            <div id="app" class="mt-5">
                <list-all-posts />
            </div>
        </div>
    </div>
</div>
@endsection
