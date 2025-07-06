<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherModel extends Model
{
    protected $table = "teachers";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyModel::class, 'FK_teacher_id', 'RECORD_id');
    }
}
