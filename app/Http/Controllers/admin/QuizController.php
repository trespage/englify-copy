<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Materi;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('materi')->orderBy('created_at', 'desc')->get();
        $materis = Materi::orderBy('id_kategori')->orderBy('urutan')->get();
        return view('admin.quiz', compact('quizzes', 'materis'));
    }

    public function apiIndex()
    {
        $quizzes = Quiz::with('materi')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil dimuat',
            'data'    => $quizzes,
        ]);
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

        $data = $request->all();
        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        Quiz::create($data);
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
        $data = $request->all();
        if (empty($data['id_bab']) && !empty($data['id_materi'])) {
            $materi = Materi::find($data['id_materi']);
            if ($materi) {
                $data['id_bab'] = $materi->id_bab;
            }
        }

        $quiz->update($data);
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil diupdate!');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return redirect()->route('admin.quiz')->with('success', 'Soal Quiz berhasil dihapus!');
    }
}
