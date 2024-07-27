@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
        <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="images/user.png" alt="" style="height: 70px;">
                        </div>
                        <div class="col-md-12 text-center">
                            <h4>{{ Auth::user()->f_name.' '.Auth::user()->l_name }}</h4>
                            <span>{{ Auth::user()->email }}</span><br>
                            <span>{{ Auth::user()->phone }}</span>
                        </div>
                    </div>                
                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->type == 1)
                        {{ __('You are logged in as a student!') }}
                    @else
                        {{ __('You have student and admin Panel access ') }}
                        <a class="btn btn-primary" href="{{ route('admin.dashboard') }}">{{ __('Go to admin Panel') }}</a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
