<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherModel extends Model
{
    use SoftDeletes;

    protected $table = "teachers";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';
    const DELETED_AT = 'RECORD_deleted_at';

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyModel::class, 'FK_teacher_id', 'RECORD_id');
    }
}
