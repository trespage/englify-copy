<?php

namespace App\Http\Controllers\siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\HasilQuiz;
use App\Models\ProgressMateri;
use App\Models\Quiz;

class SiswaController extends Controller
{
    public function index()
    {
        $materis = Materi::with('kategori')
                         ->where('status', 'Published')
                         ->orderBy('urutan', 'asc')
                         ->get();
        return view('siswa.dashboard', compact('materis'));
    }

    public function baca($id)
    {
        $materi = Materi::with('kategori')->findOrFail($id);
        if ($materi->status !== 'Published') abort(403);

        // Auto track progress materi dibaca
        $this->tandaiMateriDibaca($id);

        return view('siswa.baca-materi', compact('materi'));
    }

    public function progressSaya()
    {
        $user = auth()->user();
        $totalMateri = Materi::where('status', 'Published')->count();
        $materiDibaca = ProgressMateri::where('id_user', $user->id_user)->where('sudah_dibaca', true)->count();
        $totalQuiz = HasilQuiz::where('id_user', $user->id_user)->count();
        $totalSkor = HasilQuiz::where('id_user', $user->id_user)->sum('skor_diperoleh');
        $riwayat = HasilQuiz::where('id_user', $user->id_user)->with('quiz.materi')->latest()->get();

        return view('siswa.progress', compact('totalMateri', 'materiDibaca', 'totalQuiz', 'totalSkor', 'riwayat'));
    }

    public function kerjakanQuiz(Request $request, $id_quiz)
    {
        $request->validate(['jawaban' => 'required|in:A,B,C,D']);

        $quiz = Quiz::findOrFail($id_quiz);
        $user = auth()->user();

        $sudahMengerjakan = HasilQuiz::where('id_user', $user->id_user)->where('id_quiz', $id_quiz)->exists();
        if ($sudahMengerjakan) {
            return redirect()->back()->with('error', 'Kamu sudah mengerjakan quiz ini!');
        }

        $isCorrect = ($request->jawaban === $quiz->kunci_jawaban);
        $skor = $isCorrect ? $quiz->poin : 0;

        HasilQuiz::create([
            'id_user' => $user->id_user,
            'id_quiz' => $id_quiz,
            'jawaban_siswa' => $request->jawaban,
            'skor_diperoleh' => $skor,
            'is_correct' => $isCorrect,
        ]);

        return redirect()->route('siswa.progress')->with('success', 'Jawaban tersimpan! Skor: ' . $skor);
    }

    public function tandaiMateriDibaca($id_materi)
    {
        $user = auth()->user();
        ProgressMateri::updateOrCreate(
            ['id_user' => $user->id_user, 'id_materi' => $id_materi],
            ['status' => 'Started']
        );
        return redirect()->back();
    }
}
