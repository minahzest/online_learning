@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">

            @php
                $urlSegments = explode('/', url()->current());
                $lastTwoSegments = array_slice($urlSegments, -2);
                $final_url = implode('/', $lastTwoSegments);
            @endphp

            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link @if($final_url=='admin/dashboard') active @endif" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link @if($final_url=='admin/course') active @endif" href="{{ route('admin.course') }}">Manage Courses</a>
                <a class="nav-link @if($final_url=='admin/student') active @endif" href="{{ route('admin.student') }}">Manage Students</a>
            </div>

        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as admin!') }}
                    
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
