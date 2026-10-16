<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HasilQuiz;
use App\Models\ProgressMateri;

class MonitoringController extends Controller
{
    public function index()
    {
        $siswa = User::where('id_role', 3)
            ->withCount(['hasilQuiz as total_quiz_dikerjakan'])
            ->withSum('hasilQuiz as total_skor', 'skor_diperoleh')
            ->withCount(['progressMateri as materi_dibaca' => function($query) {
                $query->where('sudah_dibaca', true);
            }])
            ->get();

        return view('admin.monitoring', compact('siswa'));
    }

    public function detail($id_user)
    {
        $siswa = User::findOrFail($id_user);

        $riwayat_quiz = HasilQuiz::where('id_user', $id_user)
            ->with('quiz.materi')
            ->latest()
            ->get();

        $progress_materi = ProgressMateri::where('id_user', $id_user)
            ->with('materi')
            ->get();

        return view('admin.monitoring_detail', compact('siswa', 'riwayat_quiz', 'progress_materi'));
    }
}
