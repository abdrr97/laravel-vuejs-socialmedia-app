@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="app">
                <app></app>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Users you might follow
                </div>
                <div class="card-body">

                    @foreach ($users as $user)
                    <div class="row justify-content-center align-items-center">
                        <h5>{{ $user->name }}</h5>
                        <follow class="mx-5" :user-id="{{ $user->id }}"
                            :is-following="{{ $user->is_following() ? 'true' : 'false' }}" />
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
