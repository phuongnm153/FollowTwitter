<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Session;
use Storage;
use Twitter;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->searchUsersByHashTag();
        })->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    public function searchUsersByHashTag(){
        $hashTag = env('TWITTER_HASHTAG');

        $data  = Twitter::getSearch([
            'q' => '#' . $hashTag,
//            'until' => '2017-06-07',
            'count' => 50,
            'result_type' => 'recent',
            'format' => 'array'
        ]);

        $userIds = [];
        foreach ($data['statuses'] as $d){
            $userIds[] = $d['user']['id'];
        }
        $this->saveUsersToFile(['ids' => $userIds]);
        $this->followUsersFromFile();
    }

    private function saveUsersToFile($data){
        $disk = Storage::disk('public');
        $exists = $disk->has('userList.json');
        if ($exists) {
            $oldData = $disk->get('userList.json') ? json_decode($disk->get('userList.json'),true) : ['ids' => []];
            $newData = ['ids' => array_merge($oldData['ids'], $data['ids'])];
            $data = $newData;
        }
        $disk->put('userList.json',json_encode($data));
    }

    private function getIDSFromFile(){
        $disk = Storage::disk('public');
        $exists = $disk->has('userList.json');
        if ($exists) {
            $data = $disk->get('userList.json');
            return json_decode($data,true);
        }
        return ['ids' => []];
    }

    private function followUsersFromFile(){
        $ids = $this->getIDSFromFile();
        $result = [];
        foreach ($ids['ids'] as $id){
            try {
                $result[$id] = Twitter::postFollow(['user_id' => $id,'format' => 'array']);
            } catch(\Exception $e) {
                // Do what you want with the error
                $e->getMessage();
            }
        }
        return $result;
    }


}
