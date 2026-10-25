<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Smoke test: semua halaman GET harus bisa dirender (status 200)
 * untuk role yang sesuai.
 */
class RouteSmokeTest extends TestCase
{
    public function test_semua_halaman_get_bisa_dirender(): void
    {
        $users = [
            1 => User::where('id_role', 1)->first(),
            2 => User::where('id_role', 2)->first(),
            3 => User::where('id_role', 3)->first(),
        ];

        $this->assertNotNull($users[1], 'Butuh akun superadmin');
        $this->assertNotNull($users[2], 'Butuh akun admin divisi');
        $this->assertNotNull($users[3], 'Butuh akun siswa');

        // Siswa yang masih wajib ganti password akan dialihkan, nonaktifkan sementara.
        $mcpAsli = (bool) $users[3]->must_change_password;
        $users[3]->forceFill(['must_change_password' => false])->saveQuietly();

        $skipPrefix = ['login', 'up', 'api/', 'storage/', 'build/', 'vendor/', 'sanctum/'];

        // Route placeholder yang memang sengaja mengarahkan ke halaman lain
        $expectedRedirect = [
            'superadmin/users' => route('superadmin.adminDivisi'),
            'superadmin/divisi' => route('superadmin.adminDivisi'),
        ];

        $rusak = [];

        foreach (Route::getRoutes() as $route) {
            if (!count(array_intersect($route->methods(), ['GET', 'HEAD']))) {
                continue;
            }

            $uri = $route->uri();
            if (str_contains($uri, '{')) {
                continue;
            }
            foreach ($skipPrefix as $prefix) {
                if (str_starts_with($uri, $prefix)) {
                    continue 2;
                }
            }

            $role = match (true) {
                str_starts_with($uri, 'superadmin') => 1,
                str_starts_with($uri, 'admin')     => 2,
                str_starts_with($uri, 'siswa')     => 3,
                default                            => null,
            };

            if ($role === null) {
                continue;
            }

            try {
                $res = $this->actingAs($users[$role])->get('/' . $uri);
                $status = $res->getStatusCode();
            } catch (\Throwable $e) {
                $rusak[] = "[{$role}] {$uri} => EXCEPTION: " . get_class($e) . ': ' . substr($e->getMessage(), 0, 160);
                continue;
            }

            if ($status !== 200) {
                if ($status === 302 && ($expectedRedirect[$uri] ?? null) === $res->headers->get('Location')) {
                    continue;
                }
                $rusak[] = "[{$role}] {$uri} => status {$status}";
            }
        }

        $users[3]->forceFill(['must_change_password' => $mcpAsli])->saveQuietly();

        $this->assertSame([], $rusak, "Halaman rusak:\n- " . implode("\n- ", $rusak));
    }
}
