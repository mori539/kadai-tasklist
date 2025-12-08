@extends('layouts.app')

@section('content')

<!-- ここにページごとのコンテンツを書く -->
    <div class="prose ml-4">
        <h2 class="prose-lg">タスク 一覧</h2>
    </div>
    @if (isset($tasks))
        <table class="table table-zebra w-3/4 my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>ステータス</th>
                    <th><!-- 編集ボタン列 --></th>
                    <th><!-- 削除ボタン列 --></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td class="w-20">{{$task->id}}</td>
                <td><a class="link link-hover link-info" href="{{ route('tasks.show', $task->id) }}">{{ $task->content }}</a></td>
                <td class="w-40">{{$task->status}}</td>
                <td class="w-30"><a class="btn btn-primary btn-outline" href="{{ route('tasks.edit', $task->id) }}">編集</a></td>
                <td class="w-30">
                    {{-- タスク削除フォーム --}}
                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="my-2">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-error btn-outline"
                            onclick="return confirm('id = {{ $task->id }} のタスクを削除します。よろしいですか？')">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @endif

    {{-- タスク作成ページへのリンク --}}
    <a class="btn btn-primary" href="{{ route('tasks.create') }}">新規タスクの投稿</a>

@endsection