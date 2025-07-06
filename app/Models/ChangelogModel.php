<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangelogModel extends Model
{
    protected $table = "changelogs";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function version(): BelongsTo
    {
        return $this->belongsTo(VersionModel::class, 'FK_version_number', 'version_number');
    }
}
