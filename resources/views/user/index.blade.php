@extends('layouts.app')
<style>
    a {
        text-decoration: none;
    }

    button, input[type="submit"], input[type="reset"] {
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
    }
</style>
@section('content')
    <body class="">
    <div class="flex items-center justify-center w-full mt-12">
        <div class="flex grid lg:grid-cols-2 gap-20 mx-auto">
            @foreach($users as $user)
                <div class="row align-items-lg-center p-3 shadow align-content-center" style="max-width: 600px; margin: auto">
                    <div class="col-md-4 align">
                        <img src="{{ asset('storage/avatar.webp') }}" width="150" style="max-width: 100%">
                    </div>
                    <div class="col-md-4 text-center">
                        {{ $user->name }} ({{ $user->account_type }})
                        @if ($user->deleted_at)
                            <label class="alert-danger">deleted</label>
                        @endif
                    </div>
                    <div class="col-md-4 text-center">
                        @if ($user->deleted_at)
                            <form action="/users/{{ $user->id }}/restore" method="POST">
                                @csrf
                                <button style="text-decoration: none; color: rgb(0,0,0);">
                                    <i class="fa fa-undo"></i>
                                </button>
                            </form>
                        @else
                            <a href="/users/{{ $user->id }}/edit" style="text-decoration: none; color: rgb(0,0,0);">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
            <p></p>
            <div class="row">
                <div class="col-md-12 text-center border">
                    <h2>Users count: {{ $users->count() }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="/users/add" style="text-decoration: none; color: rgb(0,0,0);">
                        <i class="fa fs-1 fa-plus mt-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
@endsection
