<?php

namespace App\Support;

use App\Models\HasilQuiz;
use App\Models\Materi;
use App\Models\User;
use App\Models\Bab;
use App\Models\PesanAdmin;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SystemNotifications
{
    /**
     * Notifikasi khusus siswa:
     * - Pesan / Reminder dari admin divisi
     * - Materi baru yang dipublikasikan admin
     * - Bab baru yang ditambahkan admin
     */
    public static function forSiswa($user, int $limit = 8): array
    {
        if (!$user) return [];

        $items = [];
        $userId = $user->id_user ?? $user->id;
        // Auto-filter: Hanya ambil notifikasi & materi dalam 7 hari terakhir agar tidak menumpuk/mengsampah
        $cutoff = Carbon::now()->subDays(7);

        // Cookie check: jika siswa pernah membersihkan semua notifikasi
        $clearedTimestamp = request()->cookie('englify_notifs_cleared_at');
        if ($clearedTimestamp && is_numeric($clearedTimestamp)) {
            $clearedCarbon = Carbon::createFromTimestamp((int)$clearedTimestamp);
            if ($clearedCarbon && $clearedCarbon > $cutoff) {
                $cutoff = $clearedCarbon;
            }
        }

        // Cookie check: ID notifikasi yang pernah dihapus satuan
        $dismissedCookie = request()->cookie('englify_dismissed_ids');
        $dismissedIds = [];
        if ($dismissedCookie) {
            $decoded = json_decode(urldecode($dismissedCookie), true);
            if (is_array($decoded)) {
                $dismissedIds = $decoded;
            }
        }

        // 1. Pesan / Reminder Admin (7 hari terakhir)
        PesanAdmin::where('id_user', $userId)
            ->where('created_at', '>=', $cutoff)
            ->with('admin:id_user,nama')
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->each(function (PesanAdmin $pesan) use (&$items) {
                $items[] = [
                    'id'          => 'reminder-' . $pesan->id,
                    'db_id'       => $pesan->id,
                    'type'        => 'reminder',
                    'title'       => 'Pengingat dari ' . ($pesan->admin->nama ?? 'Admin'),
                    'desc'        => Str::limit($pesan->pesan ?? 'Ada pesan pengingat baru untukmu.', 80),
                    'time'        => $pesan->created_at->toDateTimeString(),
                    'time_label'  => $pesan->created_at->diffForHumans(),
                    'url'         => route('siswa.reminder'),
                    'delete_url'  => route('siswa.reminder.destroy', $pesan->id),
                    'is_read'     => (bool)$pesan->is_read,
                    'badge'       => 'Reminder',
                    'badge_color' => 'bg-amber-100 text-amber-700',
                ];
            });

        // 2. Materi Baru (7 hari terakhir)
        Materi::with(['kategori:id_kategori,nama_kategori', 'babModel:id,judul,urutan'])
            ->where('status', 'Published')
            ->where('created_at', '>=', $cutoff)
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->each(function (Materi $m) use (&$items) {
                $babText = $m->babModel ? ('Bab ' . $m->babModel->urutan . ': ' . $m->babModel->judul) : 'Materi Pembelajaran';
                $katText = $m->kategori->nama_kategori ?? 'Umum';
                $isNew = $m->created_at >= Carbon::now()->subDays(2);

                $items[] = [
                    'id'          => 'materi-' . $m->id_materi,
                    'type'        => 'materi',
                    'title'       => 'Materi Baru: ' . $m->judul,
                    'desc'        => $babText . ' (' . $katText . ')',
                    'time'        => $m->created_at->toDateTimeString(),
                    'time_label'  => $m->created_at->diffForHumans(),
                    'url'         => route('siswa.materi.baca', $m->id_materi),
                    'is_read'     => !$isNew,
                    'badge'       => 'Materi Baru',
                    'badge_color' => 'bg-emerald-100 text-emerald-700',
                ];
            });

        // 3. Bab Baru (7 hari terakhir)
        Bab::with('kategori:id_kategori,nama_kategori')
            ->where('created_at', '>=', $cutoff)
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->each(function (Bab $b) use (&$items) {
                $katText = $b->kategori->nama_kategori ?? 'Umum';
                $isNew = $b->created_at >= Carbon::now()->subDays(2);

                $items[] = [
                    'id'          => 'bab-' . $b->id,
                    'type'        => 'bab',
                    'title'       => 'Bab Baru Ditambahkan',
                    'desc'        => 'Bab ' . $b->urutan . ': ' . $b->judul . ' (' . $katText . ')',
                    'time'        => $b->created_at->toDateTimeString(),
                    'time_label'  => $b->created_at->diffForHumans(),
                    'url'         => route('siswa.materi'),
                    'is_read'     => !$isNew,
                    'badge'       => 'Bab Baru',
                    'badge_color' => 'bg-blue-100 text-blue-700',
                ];
            });

        // Filter out items dismissed individually by the user
        if (!empty($dismissedIds)) {
            $items = array_values(array_filter($items, fn ($it) => !in_array($it['id'], $dismissedIds, true)));
        }

        // Cek jika siswa sudah pernah membuka popup notifikasi (seen timestamp)
        $seenTimestamp = request()->cookie('englify_last_seen_notif');
        if ($seenTimestamp && is_numeric($seenTimestamp)) {
            $seenCarbon = Carbon::createFromTimestamp((int)$seenTimestamp);
            foreach ($items as &$it) {
                if (isset($it['time']) && Carbon::parse($it['time']) <= $seenCarbon) {
                    $it['is_read'] = true;
                }
            }
            unset($it);
        }

        usort($items, fn ($a, $b) => strcmp($b['time'], $a['time']));

        return array_slice($items, 0, $limit);
    }
    /**
     * Notifikasi sistem yang dibangun dari data nyata di database:
     * - pendaftaran akun siswa / admin divisi baru
     * - quiz yang baru selesai dikerjakan siswa
     * - materi yang baru dipublikasikan
     *
     * @param  int|null  $limit
     * @param  array<int, string>|null  $types  filter tipe: 'siswa', 'admin', 'quiz', 'materi' (null = semua)
     * @return array<int, array{type:string,title:string,desc:string,time:string,time_label:string}>
     */
    public static function latest(int $limit = 10, ?array $types = null): array
    {
        $items = [];

        if ($types === null || array_intersect(['siswa', 'admin'], $types)) {
            User::whereIn('id_role', [2, 3])->latest('created_at')->limit($limit)->get()
                ->each(function (User $user) use (&$items, $types) {
                    $isSiswa = (int) $user->id_role === 3;
                    if ($types !== null && !in_array($isSiswa ? 'siswa' : 'admin', $types, true)) {
                        return;
                    }
                    $items[] = [
                        'type'       => $isSiswa ? 'siswa' : 'admin',
                        'title'      => $isSiswa ? 'Akun Siswa Baru Ditambahkan' : 'Akun Admin Divisi Baru Ditambahkan',
                        'desc'       => ($user->nama ?? 'Pengguna') . ' berhasil terdaftar di sistem.',
                        'time'       => $user->created_at->toDateTimeString(),
                        'time_label' => $user->created_at->diffForHumans(),
                    ];
                });
        }

        if ($types === null || in_array('quiz', $types, true)) {
            HasilQuiz::with(['user:id_user,nama', 'quiz.materi:id_materi,judul'])
                ->latest('created_at')->limit($limit)->get()
                ->each(function (HasilQuiz $hasil) use (&$items) {
                    $items[] = [
                        'type'       => 'quiz',
                        'title'      => 'Quiz Selesai Dikerjakan',
                        'desc'       => ($hasil->user->nama ?? 'Siswa')
                            . ' menyelesaikan quiz ' . ($hasil->quiz->materi->judul ?? 'tanpa judul')
                            . ' dengan skor ' . $hasil->skor_diperoleh . '.',
                        'time'       => $hasil->created_at->toDateTimeString(),
                        'time_label' => $hasil->created_at->diffForHumans(),
                    ];
                });
        }

        if ($types === null || in_array('materi', $types, true)) {
            Materi::with('admin:id_user,nama')->where('status', 'Published')
                ->latest('updated_at')->limit($limit)->get()
                ->each(function (Materi $materi) use (&$items) {
                    $items[] = [
                        'type'       => 'materi',
                        'title'      => 'Materi Dipublikasikan',
                        'desc'       => 'Materi "' . $materi->judul . '" dipublikasikan oleh '
                            . ($materi->admin->nama ?? 'admin') . '.',
                        'time'       => $materi->updated_at->toDateTimeString(),
                        'time_label' => $materi->updated_at->diffForHumans(),
                    ];
                });
        }

        usort($items, fn ($a, $b) => strcmp($b['time'], $a['time']));

        return array_slice($items, 0, $limit);
    }

    /**
     * Jumlah notifikasi baru (aktivitas dalam 24 jam terakhir).
     */
    public static function unreadCount(array $items): int
    {
        $threshold = Carbon::now()->subDay();

        return count(array_filter($items, fn (array $item) => Carbon::parse($item['time']) >= $threshold));
    }
}
