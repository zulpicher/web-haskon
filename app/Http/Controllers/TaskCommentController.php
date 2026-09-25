<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskCommentController extends Controller
{
    public function store(
        Request $request,
        Task $task
    ) {
        $validated = $request->validate([
            'comment' => [
                'required',
                'string',
                'max:5000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,zip',
            ],
        ], [
            'comment.required' =>
                'Komentar wajib diisi.',

            'comment.max' =>
                'Komentar maksimal 5000 karakter.',

            'attachment.file' =>
                'Lampiran harus berupa file yang valid.',

            'attachment.max' =>
                'Ukuran lampiran maksimal 10 MB.',

            'attachment.mimes' =>
                'Format lampiran tidak didukung.',
        ]);

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentMime = null;
        $attachmentSize = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachmentPath = $file->store(
                'task-comments',
                'public'
            );

            $attachmentName = $file->getClientOriginalName();
            $attachmentMime = $file->getMimeType();
            $attachmentSize = $file->getSize();
        }

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_mime' => $attachmentMime,
            'attachment_size' => $attachmentSize,
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function attachment(TaskComment $comment)
    {
        abort_unless(
            $comment->attachment_path,
            404,
            'Lampiran tidak ditemukan.'
        );

        abort_unless(
            Storage::disk('public')->exists($comment->attachment_path),
            404,
            'File lampiran tidak ditemukan.'
        );

        $filePath = Storage::disk('public')->path(
            $comment->attachment_path
        );

        return response()->download(
            $filePath,
            $comment->attachment_name
        );
    }

    public function destroy(TaskComment $comment)
    {
        $user = request()->user();

        abort_unless(
            $user->isAdmin()
                || $comment->user_id === $user->id,
            403,
            'Anda tidak memiliki izin menghapus komentar ini.'
        );

        $task = $comment->task;

        if ($comment->attachment_path) {
            Storage::disk('public')->delete(
                $comment->attachment_path
            );
        }

        $comment->delete();

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Komentar berhasil dihapus.');
    }

}