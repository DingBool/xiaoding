<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
	/*
	 * @var UserRepository
	 */
	protected $user;
	/*
	 * FollowersController constructor.
	 * @param $user
	 */
	public function __construct(UserRepository $user)
	{
		$this->user = $user;
	}

	/*
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index($id)
	{
		$user = $this->user->byId($id);
		$followers = $user->followeds()->pluck('follower_id')->toArray();
		if(in_array(Auth::guard('api')->user()->id,$followers))
		{
			return response()->json(['followed' => true]);
		}
		return response()->json(['followed' => false]);
    }
	
	/*
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function follow()
	{
		$userToFollow = $this->user->byId(request('user'));
		$followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);
		if(count($followed['attached']) > 0 )
		{
			$userToFollow->notify(New NewUserFollowNotification());
			$userToFollow->increment('followers_count');
			return response()->json(['followed' => true]);
		}
		$userToFollow->decrement('followers_count');
		return response()->json(['followed' => false]);
	}
}
