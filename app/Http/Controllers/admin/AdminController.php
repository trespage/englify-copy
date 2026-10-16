<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\User;
use App\Models\Divisi;

class AdminController extends Controller
{
    public function index()
    {
        $totalMateri = Materi::where('status', 'Published')->count();
        $totalQuiz = Quiz::count();
        $totalSiswa = User::where('id_role', 3)->count();
        $rataSkor = round((float) HasilQuiz::avg('skor_total'), 1);
        $totalPoin = (int) Quiz::sum('poin');
        $materiTerbaru = Materi::with('kategori')
            ->where('status', 'Published')
            ->orderBy('urutan')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'materiDibaca' => $totalMateri,
            'totalQuiz' => $totalQuiz,
            'rataSkor' => $rataSkor,
            'totalPoin' => $totalPoin,
            'materiBelumDibaca' => $materiTerbaru,
            'streak' => $totalSiswa,
        ]);
    }

    // Halaman Kelola Soal Quiz (satu soal = satu baris, terhubung ke materi)
    public function quiz()
    {
        $quizzes = Quiz::with('materi.kategori')->latest('id_quiz')->paginate(10);
        $materis = Materi::with('kategori')->orderBy('urutan')->get();
        return view('admin.quiz', compact('quizzes', 'materis'));
    }

    // Simpan Soal Quiz
    public function storeQuiz(Request $request)
    {
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string|max:255',
            'pilihan_b' => 'required|string|max:255',
            'pilihan_c' => 'required|string|max:255',
            'pilihan_d' => 'required|string|max:255',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        Quiz::create($request->only([
            'id_materi', 'pertanyaan',
            'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
            'kunci_jawaban', 'poin',
        ]));

        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil ditambahkan!');
    }

    // Update Soal Quiz
    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string|max:255',
            'pilihan_b' => 'required|string|max:255',
            'pilihan_c' => 'required|string|max:255',
            'pilihan_d' => 'required|string|max:255',
            'kunci_jawaban' => 'required|in:A,B,C,D',
            'poin' => 'required|integer|min:1',
        ]);

        $quiz->update($request->only([
            'id_materi', 'pertanyaan',
            'pilihan_a', 'pilihan_b', 'pilihan_c', 'pilihan_d',
            'kunci_jawaban', 'poin',
        ]));

        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil diperbarui!');
    }

    // Hapus Soal Quiz
    public function destroyQuiz($id)
    {
        Quiz::findOrFail($id)->delete();
        return redirect()->route('admin.quiz')->with('success', 'Soal quiz berhasil dihapus!');
    }

    // Halaman Hasil Quiz (rekap skor per siswa per materi)
    public function hasilQuiz()
    {
        $hasilQuizzes = HasilQuiz::with(['user', 'materi'])
            ->latest('id_hasil')
            ->paginate(15);

        $totalQuiz = HasilQuiz::count();
        $averageScore = round((float) HasilQuiz::avg('skor_total'), 1);
        $totalCompleted = HasilQuiz::count();

        return view('admin.hasil-quiz', compact('hasilQuizzes', 'totalQuiz', 'averageScore', 'totalCompleted'));
    }

    // Detail Hasil Quiz
    public function detailHasilQuiz($id)
    {
        $hasil = HasilQuiz::with(['user', 'materi', 'jawaban.quiz'])->findOrFail($id);
        return view('admin.detail-hasil-quiz', compact('hasil'));
    }
}
