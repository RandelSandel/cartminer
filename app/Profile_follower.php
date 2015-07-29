<?php
namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
class Profile_follower extends Model
{
    protected $fillable = [
    	'user_id', // temporary for dev
    	'followers_id'
    ];
    public function user()
	{
		return $this->hasMany()->unique('App\User');
	}
	public function scopeDeleteSimiliar(){
		$lister []= Profile_follower::all()->toArray();
		return $lister;
		// DB::table('profile_followers')->where('user_id', '==', 'followers_id')->delete();
	}
}