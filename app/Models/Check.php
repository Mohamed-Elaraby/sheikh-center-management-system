<?php

namespace App\Models;

use App\Observers\CheckObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Check extends Model
{
    protected $fillable = [
        'check_number' ,
        'counter_number' ,
        'chassis_number',
        'plate_number' ,
        'car_color',
        'car_status_report',
        'car_status_report_note',
        'car_images_note',
        'check_status_id',
        'client_id',
        'user_id',
        'branch_id',
        'car_exit_date',
        'fuel_level',
//        'technical_id',
        'engineer_id',
        'car_type',
        'car_size',
        'car_model',
        'car_engine',
        'car_development_code',
        'car_id',
        'driver_name',
        'management_notes'
    ];

    protected $hidden = ['pivot'];

    protected $casts = [
        'car_exit_date' => 'datetime',
    ];

    protected function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y h:i:s a');
    }


    protected function getCarStatusReportAttribute($value)
    {
        return nl2br($value);
    }

    protected function getCarStatusReportNoteAttribute($value)
    {
        return nl2br($value);
    }

    protected function getCarImagesNoteAttribute($value)
    {
        return nl2br($value);
    }

    protected function setChassisNumberAttribute($value)
    {
        return $this -> attributes['chassis_number'] = strtoupper($value);
    }

    protected static function boot()
    {
        parent::boot();
        Check::observe(CheckObserver::class);
    }


    public function client(): BelongsTo
    {
        return $this -> belongsTo(Client::class);
    }


    public function checkStatus(): BelongsTo
    {
        return $this -> belongsTo(CheckStatus::class);
    }

    public function user(): BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this -> hasMany(Images::class);
    }

    public function branch(): BelongsTo
    {
        return $this -> belongsTo(Branch::class);
    }

    public function status(): BelongsTo
    {
        return $this -> belongsTo(CheckStatus::class);
    }

    public function technicals(): BelongsToMany
    {
        return $this -> belongsToMany(Technical::class, 'relation_check_technicals', 'check_id', 'technical_id');
    }

    public function engineer(): BelongsTo
    {
        return $this -> belongsTo(Engineer::class);
    }

    public function carType(): BelongsTo
    {
        return $this -> belongsTo(CarType::class);
    }

    public function carSize(): BelongsTo
    {
        return $this -> belongsTo(CarSize::class);
    }

    public function carModel(): BelongsTo
    {
        return $this -> belongsTo(CarModel::class);
    }

    public function carEngine(): BelongsTo
    {
        return $this -> belongsTo(CarEngine::class);
    }

    public function carDevelopmentCode(): BelongsTo
    {
        return $this -> belongsTo(CarDevelopmentCode::class);
    }

    public function car(): BelongsTo
    {
        return $this -> belongsTo(Car::class);
    }

}
