<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;

class Counter
{
    public function increment(string $key) : int
    {
        $sessionId = session()->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";
        $users = Cache::get($usersKey, []);
        $userUpdate = [];
        $views = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1){
                $views--;
            }else{
                $userUpdate[$session] = $lastVisit;
            }
        }
        if (!array_key_exists($sessionId,$users) || $now->diffInMinutes($users[$sessionId]) >=1 ){
            $views++;
        }
        $userUpdate[$sessionId] = $now;

        Cache::forever($usersKey,$userUpdate);

        if (!Cache::has($counterKey)){
            Cache::forever($counterKey,1);
        }else{
            Cache::increment($counterKey,$views);
        }

        $viewers = Cache::get($counterKey);
        return $views;
    }
}
