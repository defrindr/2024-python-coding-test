<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ManualBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'file_path',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
