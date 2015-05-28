<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use \Session;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

	protected $table = 'users';
    public $timestamps = false;
	protected $hidden = ['password_hash', 'remember_token'];
	protected $dates = ['deleted_at'];
    public $primaryKey = 'user_id';

    protected $guarded = ['user_id']; 
    
    public static $validationRules = ['firstname'=>'required|name',
    									'lastname'=>'required|name',
    									'email' => 'required|email'];

    public static function profileData($id) {
        
        if( is_null($id) || !is_numeric($id) )
            return null;
        
        $user = DB::select('SELECT u.firstname, u.lastname, u.email, u.role, u.inscription_date, 
                            u.notes, g.group_name
                            FROM users u, groups g
                            WHERE g.group_id = u.group_id
                            AND u.user_id = ?', [ $id ]);
        
        if( count($user) == 0 )
            return null;
        
        return $user[0];
    }
    
    public function scopeActiveGroup($query) {
    	
    	return $query->join('groups', 'groups.group_id', '=', 'users.group_id')
		    			->where('groups.is_active', true);
	}
	
	public function scopeFromGroup($query) {
	
		return $query->where('group_id', Session::get('groupID') );
	}

}
