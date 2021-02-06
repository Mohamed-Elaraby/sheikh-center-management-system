<?php

namespace App\Models;

use App\Observers\CheckObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = [
        'check_number' ,
        'counter_number' ,
        'structure_number',
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
        'technical_id',
        'engineer_id',
        'car_type_id',
        'car_size_id',
        'car_model_id',
        'car_engine_id',
        'car_development_code_id',
        'driver_name',
        'management_notes'
    ];

    protected $casts = [
        'car_exit_date' => 'datetime',
    ];

    protected function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y h:i:s a');
    }

//    protected function setUpdatedAtAttribute($value)
//    {
////        return $value ->format('d/m/Y - h:i:s');
//        return $this->attributes['updated_at'] = (new Carbon($value)) -> format('d/m/Y - h:i:s a');
//    }

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

    protected function setStructureNumberAttribute($value)
    {
        return $this -> attributes['structure_number'] = strtoupper($value);
    }

    protected static function boot()
    {
        parent::boot();
        Check::observe(CheckObserver::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(Client::class);
    }


    public function checkStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CheckStatus::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this -> hasMany(Images::class);
    }

    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(Branch::class);
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CheckStatus::class);
    }

    public function technical(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(Technical::class);
    }

    public function engineer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(Engineer::class);
    }

    public function carType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CarType::class);
    }

    public function carSize(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CarSize::class);
    }

    public function carModel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CarModel::class);
    }

    public function carEngine(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CarEngine::class);
    }

    public function carDevelopmentCode(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo(CarDevelopmentCode::class);
    }

}
