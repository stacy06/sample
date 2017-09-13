<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加
        $users = User::all();
        $user = User::first();
        $user_id = $user->id;

        //获取除了1之外的所有id作为粉丝列表
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //1号用户关注除了自己以外的所有用户
        $user->follow($follower_ids);

        //除了1号用户其他用户都关注1号
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
