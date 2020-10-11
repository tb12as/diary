@extends('layouts.app')

@section('content')
<div class="loading">
    <div class="tengah">
        <div class="spinner-border text-primary" role="status" style="animation-duration: 1s; padding: 20px;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="tengah">
        <div class="spinner-border text-success" role="status" style="animation-duration: 1.5s; padding: 40px;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="tengah">
        <div class="spinner-border text-danger" role="status" style="animation-duration: 2s; padding: 60px;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
