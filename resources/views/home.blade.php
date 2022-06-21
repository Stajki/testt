@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <p>Welcome in {{ config('app.name') }}!</p>
                    <p>You're logged as {{ \App\Models\User::findCurrent()->account_type }}!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
