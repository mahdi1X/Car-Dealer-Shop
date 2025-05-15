<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'like' => 'required|numeric|min:0|max:1', // since you want decimal, but max 1 for like
        ]);

        $user = $request->user();

        $like = Like::where('user_id', $user->id)
                    ->where('car_id', $request->car_id)
                    ->first();

        if ($like) {
            // If exists, update or delete - here we toggle: if like=1 then delete, else update to 1
            if ($like->like == 1) {
                $like->delete(); // remove like
                $liked = false;
            } else {
                $like->update(['like' => $request->like]);
                $liked = true;
            }
        } else {
            // Create new like
            Like::create([
                'user_id' => $user->id,
                'car_id' => $request->car_id,
                'like' => $request->like,
            ]);
            $liked = true;
        }

        // Get total likes count and average like
        $carLikes = Like::where('car_id', $request->car_id);
        $likesCount = $carLikes->count();
        $likesAvg = $carLikes->avg('like');

        if ($request->ajax()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $likesCount,
                'likes_avg' => $likesAvg,
            ]);
        }

        return back();
    }
}
