<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;



class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function 正しい情報でログインするとtokenが返ってくる()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'), // パスワードをハッシュ化
        ]);

        // ログインリクエストを送信
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // 正常な認証の場合、ステータスコード200とトークンを期待
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

        // ユーザーが認証されていることを確認
        $this->assertAuthenticatedAs($user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function 間違った情報でログインするとエラーが返ってくる()
    {
        // ログインリクエストを送信（誤った認証情報）
        $response = $this->post('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ]);

        // 誤った認証情報の場合、ステータスコード401とエラーメッセージを期待
        $response->assertStatus(401);
        $response->assertJson(['error' => '認証に失敗しました。']);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }

     /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function ログイン時にログアウトできる()
    {
        // テスト用のユーザーを作成し、認証
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // ログアウトリクエストを送信
        $response = $this->post('/api/logout');

        // 正常なログアウトの場合、ステータスコード200とメッセージを期待
        $response->assertStatus(200);
        $response->assertJson(['message' => 'ログアウトしました。']);
    }
}
