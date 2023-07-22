<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'lastName', 'phone', 'email', 'address', 'note'
    ];

    protected $id = ['id'];

    protected $table = 'contacts';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->phone = $model->phone ?? '';
            $model->email = $model->email ?? '';
            $model->address = $model->address ?? '';
            $model->note = $model->note ?? '';
        });
    }

}
