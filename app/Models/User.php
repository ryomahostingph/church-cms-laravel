<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use PresentableTrait;
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;

    protected $presenter = "App\Presenters\UserprofilePresenter";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'church_id' , 'usergroup_id' , 'ref_id' , 'name' , 'email' , 'password' , 'mobile_no' , 'is_activated' , 'email_verification_code' , 'email_verified' , 'email_verified_at' , 'is_reset' , 'platform_token' , 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with=['userprofile' ,'members','children'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at' , 'email_verified_at'];

    public function church()
    {
        return $this->belongsTo('App\Models\Church','church_id');
    }

    public function churchdetails()
    {
        return $this->belongsTo('App\Models\ChurchDetail','church_id');
    }

    public function userprofile()
    {
        return $this->hasOne('App\Models\Userprofile','user_id','id');
    }
     public function members()
    {
        //return $this->hasMany('App\Models\User','ref_id','id');
        return $this->hasMany(User::class, 'ref_id', 'id');
    }
     public function refer()
    {
        return $this->belongsTo(User::class,'ref_id');
    }

    public function children()
    {
       return $this->members()->whereHas('userprofile', function($query) {
              $query->where('relation', 'child');
          });
    }
    public function patner()
    {

         $patner=$this->members()->whereHas('userprofile', function($query) {
              $query->where('relation', 'patner');
          });

        return $patner;
    }
    public function father()
    {

         $father=$this->members()->whereHas('userprofile', function($query) {
              $query->where('relation', 'father');
          });

        return $father;
    }
    public function mother()
    {

         $mother=$this->members()->whereHas('userprofile', function($query) {
              $query->where('relation', 'mother');
          });

        return $mother;
    }

    public function usergroup()
    {
        return $this->belongsTo('App\Models\Usergroup','usergroup_id');
    }

    public function AauthAcessToken()
    {
       return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public function activitylog()
    {
        return $this->hasMany('App\Models\ActivityLog','causer_id','id');
    }

     public function notes()
    {
        return $this->hasMany('App\Models\Notes','entity_id','id');
    }

    public function subscription()
    {
        return $this->hasMany('App\Models\Subscription','user_id','id');
    }

    public function fund()
    {
        return $this->hasMany('App\Models\Fund','user_id','id');
    }

    /*public function parent()
    {
        return $this->belongsTo('App\Models\User','id');
    }

    public function child()
    {
        return $this->hasMany('App\Models\User','ref_id','id');
    }*/

    public function scopeByChurch($query,$church_id)
    {
        $query->where('church_id',$church_id);
        return $query;
    }

    public function scopeByRole($query,$usergroup_id)
    {
        $query->where('usergroup_id',$usergroup_id);
        return $query;
    }

    public function scopeByName($query , $name)
    {
        $query->where(function ($query) use($name)
            {
                $query->where('name','LIKE',$name.'%');
            });
        return $query;
    }

    public function scopeByFirstName($query , $firstname)
    {
        $query->wherehas('userprofile',function ($query) use($firstname)
            {
                $query->where('firstname','LIKE',$firstname.'%');
            });
        return $query;
    }

    public function scopeByLastName($query , $lastname)
    {
        $query->wherehas('userprofile',function ($query) use($lastname)
            {
                $query->where('lastname','LIKE',$lastname.'%');
            });
        return $query;
    }

    public function scopeByGender($query , $gender)
    {
        $query->wherehas('userprofile',function ($query) use($gender)
            {
                $query->where('gender','=',$gender);
            });
        return $query;
    }

    public function scopeByMembershipType($query , $membership_type)
    {
        $query->wherehas('userprofile',function ($query) use($membership_type)
            {
                $query->where('membership_type','Like','%'.$membership_type.'%');
            });
        return $query;
    }

    public function scopeByMarriageStatus($query , $marriage_status)
    {
        $query->wherehas('userprofile',function ($query) use($marriage_status)
            {
                $query->where('marriage_status','LIKE','%'.$marriage_status.'%');
            });
        return $query;
    }

    public function scopeByAge($query , $min_age , $max_age)
    {
        $query->wherehas('userprofile',function ($query) use($min_age , $max_age)
            {
                $query->whereYear('date_of_birth','<=',$min_age)
                      ->whereYear('date_of_birth','>=',$max_age);
            });
        return $query;
    }

    public function scopeByDateOfBirth($query , $date_of_birth)
    {
        $query->wherehas('userprofile',function ($query) use($date_of_birth)
            {
                $query->where(\DB::raw("(DATE_FORMAT(date_of_birth,'%m'))"),$date_of_birth);
            });
        return $query;
    }

    public function scopeByBaptism($query , $baptism)
    {
        $query->wherehas('userprofile',function ($query) use($baptism)
            {
                $query->where('was_baptized','LIKE','%'.$baptism.'%');
            });
        return $query;
    }

    public function scopeByFamily($query , $family)
    {
        $query->wherehas('userprofile',function ($query) use($family)
            {
                $query->where('family','LIKE',$family.'%');
            });
        return $query;
    }

    public function scopeByProfession($query , $profession)
    {
        $query->wherehas('userprofile',function ($query) use($profession)
            {
                $query->where('profession','LIKE',$profession);
            });
        return $query;
    }

    public function scopeByMobile_no($query , $mobile_no)
    {
        $query->wherehas('userprofile',function ($query) use($mobile_no)
            {
                $query->where('mobile_no','LIKE',$mobile_no.'%');
            });
        return $query;
    }

    public function scopeByEmail_id($query , $email)
    {
        $query->wherehas('userprofile',function ($query) use($email)
            {
                $query->where('email','LIKE',$email.'%');
            });
        return $query;
    }

    public function scopeByLocation($query , $location)
    {
        $query->wherehas('userprofile',function ($query) use($location)
            {
                $query->whereHas('state', function($que) use($location){
                    $que->where('name','LIKE',$location.'%');
                })->orWhereHas('city', function($q) use($location){
                    $q->where('name','LIKE',$location.'%');
                });
            });
        return $query;
    }

    public function scopeByStatus($query , $status)
    {
        $query->wherehas('userprofile',function ($query) use($status)
            {
                $query->where('status',$status);
            });
        return $query;
    }

    public function sermon()
    {
        return $this->hasMany('App\Models\Sermon');
    }

    public function sermonlink()
    {
        return $this->hasMany('App\Models\SermonLink','user_id','id');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Models\Sermon', 'likes', 'user_id', 'sermon_id');
    }

    public function groupLink()
    {
        return $this->hasMany('App\Models\GroupLink','user_id','id');
    }

    public function sendMail()
    {
        return $this->hasMany('App\Models\SendMail','user_id','id');
    }

    public function permissionUser()
    {
        return $this->hasMany('App\Models\PermissionUser','user_id','id');
    }

    public function userReminder()
    {
        return $this->hasMany('App\Models\Reminder', 'id' ,'entity_id')->where('entity_name','=','App\\Models\\User');
    }

    public function prayerRequest()
    {
        return $this->hasMany('App\Models\PrayerRequest','user_id','id');
    }

    public function prayerResponse()
    {
        return $this->hasMany('App\Models\PrayerResponse','user_id','id');
    }

    public function help()
    {
        return $this->hasMany('App\Models\Help','user_id','id');
    }

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance','user_id','id');
    }

    public function getFullNameAttribute()
    {
        return $this->userprofile->firstname.' '.$this->userprofile->lastname;
    }

    public function getChurchLogoAttribute()
    {
        return $this->church->churchDetailLogo;
    }

    public function getChurchLogoPathAttribute()
    {
        return $this->church->churchDetailLogo->LogoPath;
    }
}
