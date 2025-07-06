<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VersionModel extends Model
{
    protected $table = "versions";
    protected $primaryKey = "version_number";
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function changelogs(): HasMany
    {
        return $this->hasMany(ChangelogModel::class, 'FK_version_number', 'version_number');
    }
}
