<?php

namespace App\Models\Entry;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    protected $table = 'wp_wpforms_entries';


    public function scopeFilters($query, $search = null, $position = null)
    {
        if (!empty($search)) {
            return $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(fields, '$.\"1\".value')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(fields, '$.\"5\".value')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(fields, '$.\"9\".value')) LIKE ?", ["%{$search}%"]);
            });
        }

        if (!empty($position)) {
            return $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(fields, '$.\"2\".value')) = ?", [$position]);
        }
        
        return $query;
    }

}
