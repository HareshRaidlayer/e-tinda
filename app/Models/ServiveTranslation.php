<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PreventDemoModeChanges;

class ServiceTranslation extends Model
{

    protected $fillable = ['is', 'name', 'description'];

    public function service(){
      return $this->belongsTo(Service::class);
    }
}
