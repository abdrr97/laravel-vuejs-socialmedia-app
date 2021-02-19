@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="app">
                <app></app>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Users you might want to follow
                </div>
                <div class="card-body">
                    @foreach ($users as $user)
                    <div class="row align-items-center my-3">
                        <div class="col-auto mr-auto ">
                            {{ $user->name }}
                        </div>
                        <div class="col-auto">
                            <follow class="" :user-id="{{ $user->id }}"
                                :is-following="{{ $user->is_following() ? 'true' : 'false' }}" />
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</div>
@endsection