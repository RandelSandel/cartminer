<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Profile extends Model
{
    protected $fillable = [
		
		'user_id',    // user_id is added for testing purposes only
		'bio',
		'twitter_username',
		'facebook_username',
		
	];
	// creates a user method stating that the profile belongs to the user
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function scopewhereUserID($id)
    {
        $this->where('user_id', '==', $id);
    }
}