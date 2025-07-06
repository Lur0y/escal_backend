<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyStatusModel extends Model
{
    protected $table = "survey_status";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyModel::class, 'FK_survey_status_id', 'RECORD_id');
    }
}
