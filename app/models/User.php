<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $guarded = array('id');

	protected $fillable =array('username','password');

	protected $errors;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	* Validation rules for Users
	*/
	protected static $rules = array (
				'first_name' => 'required|max:40|alpha',
				'last_name' => 'required|max:40|alpha',
				'email' => array('unique:users', 'required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
				'password' => 'between:8,30',
				'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
				'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
		);

	// $validator = Validator::make(Input::all(), array(
	// 			'first_name' => 'required|max:40|alpha',
	// 			'last_name' => 'required|max:40|alpha',
	// 			'email' => array('unique:users', 'required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
	// 			'password' => 'required|between:8,30',
	// 			'extension' => 'between:3,12|regex:/^([0-9,])+$/i'
	// 		));

	// $validator = Validator::make(Input::all(), array(
	// 			'id' => 'same:id',
	// 			'password' => 'between:8,30',
	// 			'email' => array('required', 'max:40', 'email', 'regex:/^(.*?)+(@)+(insideout.com)/i'),
	// 			'first_name' => 'required|max:40|alpha',
	// 			'last_name' => 'required|max:40|alpha',
	// 			'extension' => 'between:3,12|regex:/^([0-9,])+$/i',
	// 			'cell_phone' => 'size:12|regex:/^([0-9-])+$/i',
	// 		));
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	* Load Model Event Listen
	*/
	public static function boot() {
		parent::boot();

		static::saving(function($model){
			return $model->validate();
		});
	}

	/**
	* Validate users on updating and creating
	*
	* @return boolean
	*/
	public function validate() {
		$validation = Validator::make($this->getAttributes(), static::$rules);

		if($validation->fails()) {
			$this->errors = $validation->messages();
			return false;
		}
		return true;
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	// Need to research more. Probably need to just remove
	// public function setPasswordAttribute($value)
	// {
	// 	$this->attributes['password'] = Hash::make($value);
	// }
}