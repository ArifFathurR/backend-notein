<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesStoreRequest;
use App\Http\Requests\NotesUpdateRequest;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = auth()->user()
            ->notes()
            ->with('category')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data notes',
            'data' => $notes
        ], 200);
    }

    public function NoteTask() {
        $notes = Notes::with('tasks')
            ->where('id_user', Auth::id())
            ->whereHas('tasks')
            ->get();

        return response()->json([
            'message' => "Berhasil menampilkan catatan dengan task",
            'data' => $notes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotesStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('background_path')) {
            $file = $request->file('background_path');
            $path = $file->store('notes', 'public');
            $data['background_path'] = $path;
        }

        $note = Notes::create([
            ...$data,
            'id_user' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Berhasil tambah data',
            'data' => $note->load('category')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = auth()->user()
            ->notes()
            ->with('category')
            ->find($id);

        if (!$note) {
            return response()->json([
                'message' => 'Data note tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil data note',
            'data' => $note
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotesUpdateRequest $request, string $id)
    {
        $note = auth()->user()
            ->notes()
            ->find($id);

        if (!$note) {
            return response()->json([
                'message' => 'Data note tidak ditemukan'
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('background_path')) {
            $newPath = $request->file('background_path')
                ->store('notes', 'public');

            if ($note->background_path && Storage::disk('public')->exists($note->background_path)) {
                Storage::disk('public')->delete($note->background_path);
            }

            $data['background_path'] = $newPath;
        } else {
            if (array_key_exists('background_path', $data)) {
                if (is_null($data['background_path']) || $data['background_path'] === '') {
                    if ($note->background_path && Storage::disk('public')->exists($note->background_path)) {
                        Storage::disk('public')->delete($note->background_path);
                    }
                    $data['background_path'] = null;
                } else {
                    unset($data['background_path']);
                }
            }
        }

        $note->update($data);

        return response()->json([
            'message' => 'Berhasil memperbarui data',
            'data' => $note->fresh()->load('category'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = auth()->user()
            ->notes()
            ->find($id);

        if (!$note) {
            return response()->json([
                'message' => 'Data note tidak ditemukan'
            ], 404);
        }

        if ($note->background_path && Storage::disk('public')->exists($note->background_path)) {
            Storage::disk('public')->delete($note->background_path);
        }

        $note->delete();

        return response()->json([
            'message' => 'Berhasil menghapus note'
        ], 200);
    }
}
