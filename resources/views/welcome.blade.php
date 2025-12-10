@extends('layouts.app')

@section('content')
    @auth
        @include('tasks.index')
    @else
        <div class="prose hero bg-base-200 mx-auto max-w-full rounded">
            <div class="hero-content text-center my-10">
                <div class="max-w-md mb-10">
                    <h2>Welcome to the taskBord</h2>
                    {{-- ユーザー登録ページへのリンク --}}
                    <a class="btn btn-primary btn-lg" href="{{ route('register') }}">ユーザー登録</a>
                </div>
            </div>
        </div>
    @endauth
@endsection