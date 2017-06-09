<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Storage;
use Twitter;


class HomeController extends Controller
{
    //
    public function index(){
        return view('welcome');
    }

    public function saveHashTag(Request $request){
        $result['status'] = false;
        if ($request->has('hashTag')) {
            $hashTag = $request->hashTag;
            $result['status'] = $this->changeEnvironmentVariable('TWITTER_HASHTAG',$hashTag);
        }
        return view('hashTag')->with($result);
    }

    public function changeEnvironmentVariable($key,$value)
    {
        $path = base_path('.env');
        if(file_exists($path)&& env($key))
        {
            $old = env($key) ? env($key) : '';
            return file_put_contents($path, str_replace(
                "$key=".$old, "$key=".$value, file_get_contents($path)
            )) ? true : false;
        }
        return false;
    }

    public function getFollowList(){
        if (!empty(Twitter::getCredentials()))
            $data['followList'] = Twitter::getFollowers(['user_id' => Twitter::getCredentials()->id,'format' => 'array'])['users'];
        else $data['followList'] = [];
        return view('hashTag')->with($data);
    }
}
