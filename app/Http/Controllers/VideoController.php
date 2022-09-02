<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class VideoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        request()->validate([
            'file'  => 'mimes:mp4,avi|max:256000'
        ]);

        $videoName = Str::random(6) . 'vi' .  time().'.'.$request->file->extension();  
        Storage::putFileAs('public/video', new File($request->file), $videoName);

        $post = \App\Post::whereId($id)->first();
        $user = \App\User::whereId($post->user_id)->first();

        $videos = Video::where('post_id', $id)->get();
        if(count($videos) >= 4){
            return 'Error';
        }

        $video = new Video;
        $video->user_id = $user->id;
        $video->post_id = $id;
        $video->active = 0;
        $video->url = "/video/" . $videoName;
        $video->save();

        return "Success";
    }

    public function getvideos($id)
    {
        $post = \App\Post::whereId($id)->first();
        $user = \App\User::whereId($post->user_id)->first();

        $videos = Video::where('post_id', $id)
        ->where('user_id', $user->id)
        ->limit(3)->get();

        return $videos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video= Video::find($id);
        Storage::delete('/public/' . $video->url);
        $video->delete();

        return 'Success';
    }
}
