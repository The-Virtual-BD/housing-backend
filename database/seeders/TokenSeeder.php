<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Approver;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personal_access_tokens')->insert([
            //admin
            //Emvdy0w4bw0KTRWFZPblOmYYbgmIIN2s1PLusYYT
            [
                'tokenable_type' => Admin::class,
                'tokenable_id' => 1,
                'name' => 'access_token',
                'token' => '1467fa5cab025f27da1a5433b66999c7e5466a9001919c10d34a9deb4148787c',
                'abilities' => '["*"]'
            ],
            //approver1
            //dvX2aIddkHTTj9xqq7oCOwb2TGRePf5fQca765Ru
            [
                'tokenable_type' => Approver::class,
                'tokenable_id' => 1,
                'name' => 'access_token',
                'token' => '605d341a97561a89ad84bc9d43a4d1ec9e89af5038bbdc4bda8f1e53d4fe8ed9',
                'abilities' => '["*"]'
            ],
            //approver2
            //B6gfUdHUYakPoJoZvCbAjFro4BaI73wmHUcFY0aC
            [
                'tokenable_type' => Approver::class,
                'tokenable_id' => 2,
                'name' => 'access_token',
                'token' => 'd8938e945fe5b4752d24f69ced0a7846b7b3dd928fd1f0b68a65354431523445',
                'abilities' => '["*"]'
            ],
            //manager1
            //gGgmrbdssRCVXmW0ito0J1h8ZAxTICwpHgUiAG95
            [
                'tokenable_type' => Manager::class,
                'tokenable_id' => 1,
                'name' => 'access_token',
                'token' => '78783f3560db94c86c7ab1e2e12edc8ae7703196f5a0a95f34c18486c9cca958',
                'abilities' => '["*"]'
            ],
            //manager2
            //8lc2TFrtVtS94Hxv7jzVrTExqAo8joOuLb5uR6Qp
            [
                'tokenable_type' => Manager::class,
                'tokenable_id' => 2,
                'name' => 'access_token',
                'token' => '9656fd7a3f078245b9ddc8c6e63bce6f6d12862769c48ba59bc669e48df0ee8d',
                'abilities' => '["*"]'
            ],
            //user1
            //O0vRp2nA5iFWM24MG05ZLSOG1BV03PkvinvWhdZ9
            [
                'tokenable_type' => User::class,
                'tokenable_id' => 1,
                'name' => 'access_token',
                'token' => '9f6309c6d75249fbfff4b50bd6bc400d3e55594e86d8b3994768fe00de975bbc',
                'abilities' => '["*"]'
            ],
            //user2
            //sBl1cnYch8Ay3gyoFGb6fqF9QMEXSUDAhihY33sK
            [
                'tokenable_type' => User::class,
                'tokenable_id' => 2,
                'name' => 'access_token',
                'token' => '479f9ad0872d32de0b27ce96a388d6d061fefbb0604d831e4dec6887ad50cf7e',
                'abilities' => '["*"]'
            ],
        ]);
    }
}
