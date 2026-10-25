<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CustomErrorHandlingTest extends TestCase
{
    /**
     * Memastikan 404 Web mengembalikan halaman kustom 404 Englify
     */
    public function test_custom_404_page_rendered(): void
    {
        $response = $this->get('/halaman-acak-yang-pasti-tidak-ada-123456');

        $response->assertStatus(404);
        $response->assertSee('404');
        $response->assertSee('Halaman Tidak Ditemukan');
    }

    /**
     * Memastikan 404 API mengembalikan respon JSON terstruktur
     */
    public function test_custom_404_api_json_response(): void
    {
        $response = $this->getJson('/api/endpoint-yang-tidak-ada-123456');

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'error',
            'code'   => 404,
        ]);
    }

    /**
     * Memastikan 403 Web mengembalikan halaman kustom 403 Englify
     */
    public function test_custom_403_page_rendered(): void
    {
        Route::get('/testing-error-403', function () {
            throw new AccessDeniedHttpException('Akses ditolak.');
        });

        $response = $this->get('/testing-error-403');

        $response->assertStatus(403);
        $response->assertSee('403');
        $response->assertSee('Akses Ditolak');
    }

    /**
     * Memastikan 500 Web mengembalikan halaman kustom 500 Englify
     */
    public function test_custom_500_page_rendered(): void
    {
        Route::get('/testing-error-500', function () {
            throw new HttpException(500, 'Internal Server Error.');
        });

        $response = $this->get('/testing-error-500');

        $response->assertStatus(500);
        $response->assertSee('500');
        $response->assertSee('Terjadi Kesalahan Server');
    }

    /**
     * Memastikan Database Connection Exception me-render view kustom errors.database
     */
    public function test_custom_database_connection_exception_rendered(): void
    {
        Route::get('/testing-error-db', function () {
            throw new \PDOException('SQLSTATE[HY000] [2002] Connection refused');
        });

        $response = $this->get('/testing-error-db');

        $response->assertStatus(500);
        $response->assertSee('Basis Data Sedang Tidak Tersedia');
        $response->assertSee('Koneksi Basis Data Terputus');
    }
}
