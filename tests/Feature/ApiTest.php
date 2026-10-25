<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_endpoint_publik_tidak_gagal(): void
    {
        foreach (['api.kategori', 'api.materi', 'api.quiz', 'api.monitoring', 'api.users'] as $route) {
            $res = $this->getJson(route($route));
            $res->assertOk();
            $res->assertJsonStructure(['status', 'message', 'data']);
        }
    }

    public function test_api_progress_siswa_mengembalikan_json(): void
    {
        $siswa = User::where('id_role', 3)->first();
        $this->assertNotNull($siswa);

        $res = $this->actingAs($siswa)->getJson(route('api.siswa.progress'));
        $res->assertOk();
        $res->assertJsonStructure(['status', 'message', 'data']);
    }

    public function test_api_progress_siswa_tidak_bisa_diakses_tanpa_login(): void
    {
        $this->getJson(route('api.siswa.progress'))->assertUnauthorized();
    }
}
