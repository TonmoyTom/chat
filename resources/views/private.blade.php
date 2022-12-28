@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Private Chat</div>
                    <div class="card-body" >
                        <private-component :user="{{auth()->user()}}"></private-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
