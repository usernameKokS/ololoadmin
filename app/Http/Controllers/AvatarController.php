<?php

namespace App\Http\Controllers;

use App\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    public function getimages($id)
    {
        $post = \App\Post::whereId($id)->first();
        $user = \App\User::whereId($post->user_id)->first();
        $avatars = Avatar::where('post_id', $id)
        ->where('user_id', $user->id)
        ->limit(10)->get();

        return $avatars;
    }


    public function setactive(Request $request)
    {

        $post = \App\Post::whereId($request['post_id'])->first();
        $user = \App\User::whereId($post->user_id)->first();

        $avatars = Avatar::where('user_id', $user->id)
        ->where('post_id', $request['post_id'])
        ->get();

        foreach($avatars as $avatar){
            if($avatar->id == $request['id']){
                $avatar->active = 1;
                $avatar->save();
            } else {
                $avatar->active = 0;
                $avatar->save();
            }
        }

        return $avatars;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        $imageName = Str::random(6) . 'de' . time().'.'.$request->avatar->extension();  
            
		
        $r = Storage::putFileAs('public/avatar', new File($request->avatar), $imageName);

		$imageName = $this->convertImage($imageName);
		
        $post = \App\Post::whereId($id)->first();
        $user = \App\User::whereId($post->user_id)->first();

        $avatars = Avatar::where('post_id',$id)->get();
        if(count($avatars) >= 10){
            return 'Error';
        }

        $check_avatars = Avatar::where('post_id', $id)->get();
        if(count($check_avatars) == 0){
            $active_avatar = 1;
        } else {
            $active_avatar = 0;
        }
            
        $avatar = new Avatar;
        $avatar->user_id = $user->id;
        $avatar->post_id = $id;
        $avatar->active = $active_avatar;
        $avatar->url = "/avatar/" . $imageName;
        $avatar->save();

        return "Success";
    }

    function convertImage($originalImage)
    {
		$rootDir = $_SERVER['DOCUMENT_ROOT'] . '/storage/avatar/';
		
        // jpg, png, gif or bmp?
        $exploded = explode('.', $originalImage);
        $ext = $exploded[count($exploded) - 1]; 
		$outputImage = substr($originalImage, 0, strlen($originalImage) - strlen($ext)) . 'jpg';

        if (preg_match('/jpg|jpeg/i',$ext))
            $imageTmp=imagecreatefromjpeg($rootDir . $originalImage);
        else if (preg_match('/png/i',$ext))
            $imageTmp=imagecreatefrompng($rootDir . $originalImage);
        else if (preg_match('/gif/i',$ext))
            $imageTmp=imagecreatefromgif($rootDir . $originalImage);
        else if (preg_match('/bmp/i',$ext))
            $imageTmp=imagecreatefrombmp($rootDir . $originalImage);
        else
            return 0;
		
		list($width, $height) = getimagesize($rootDir . $originalImage);
		
		$maxLimitSize = 1000;
		
		if($width > $maxLimitSize || $height > $maxLimitSize)
		{
			if($width > $height)
			{
				$newWidth = 1000;
				$newHeight = (int)round(($height / $width) * $newWidth, 0);
			}
			else
			{
				// 100 < 150
				$newHeight = 1000;
				$newWidth = (int)round(($width / $height) * $newHeight, 0);
			}
			
			$tmp = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($tmp, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			
			 // quality is a value from 0 (worst) to 100 (best)
			imagejpeg($tmp, $rootDir . $outputImage, 100);
			imagedestroy($tmp);
		}
		else
		{
			 // quality is a value from 0 (worst) to 100 (best)
			imagejpeg($imageTmp, $rootDir . $outputImage, 100);
		}
		
		// unlink($rootDir . $originalImage);
        imagedestroy($imageTmp);
		

        return $outputImage;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$user = Auth::user();


        $avatar = Avatar::find($id);

        $post_id = $avatar->post_id;

        //if($avatar->user_id == $user->id){
            Storage::delete('/public/' . $avatar->url);
            $avatar->delete();

            $avatars = Avatar::where('user_id', $avatar->user_id)->where('post_id', $post_id)->get();

            foreach($avatars as $ava){
                if($ava->active == 1){
                    return $avatars;
                }
            }
            if(count($avatars) > 0){
                $avatars[0]->active = 1;
                $avatars[0]->save();
            }
            return $avatars;
        //} else {
        //    throw ValidationException::withMessages(['error1' => 'Error, you dont have permission.']);
       // }

        
    }
}
