<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    //「一覧表示処理」
    public function index()
    {
        $data = [];
        if (Auth::check()) { // 認証済みの場合
            // 認証済みユーザーを取得
            /** @var \App\Models\User|null $user */
            $user = Auth::user();

            // ユーザーの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        // welcomeビューでそれらを表示
        return view('welcome', $data);
    }

    //「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    //「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザー（閲覧者）のタスクとして作成
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        // トップページへリダイレクト
        return redirect('/');
    }

    //「取得表示処理」
    public function show(Request $request, string $id)
    {
        // ログインユーザーのタスクの中から、指定されたIDのタスクを探す
        $task = $request->user()->tasks()->find($id);

        // タスクが見つからない（＝存在しない、または他人のタスク）場合
        if (!$task) {
            // トップページへリダイレクト
            return redirect('/');
        }

        // メッセージ詳細ビューでそれを表示
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    //「更新画面表示処理」
    public function edit(Request $request, string $id)
    {
        // ログインユーザーのタスクの中から、指定されたIDのタスクを探す
        $task = $request->user()->tasks()->find($id);

        // タスクが見つからない（＝存在しない、または他人のタスク）場合
        if (!$task) {
            // トップページへリダイレクト
            return redirect('/');
        }

        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    //「更新処理」
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);

        // idの値でメッセージを検索して取得
        $task = $request->user()->tasks()->find($id);

        // タスクが見つからない（＝存在しない、または他人のタスク）場合
        if (!$task) {
            // トップページへリダイレクト
            return redirect('/');
        }

        // タスク更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクト
        return redirect('/');
    }

    //「削除処理」
    public function destroy(Request $request, string $id)
    {
        // ログインユーザーのタスクの中から、指定されたIDのタスクを探す
        $task = $request->user()->tasks()->find($id);

        // タスクが見つからない（＝存在しない、または他人のタスク）場合
        if (!$task) {
            // トップページへリダイレクト
            return redirect('/');
        }

        // メッセージを削除
        $task->delete();

        // トップページへリダイレクト
        return redirect('/');
    }
}

