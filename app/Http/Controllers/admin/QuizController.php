<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Materi;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('materi')->orderBy('created_at', 'desc')->get();
        $materis = Materi::where('status', 'Published')->get();
        return view('admin.quiz', compact('quizzes', 'materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        Quiz::create($request->all());
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil diupdate!');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil dihapus!');
    }
}
