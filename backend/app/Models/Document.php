<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['application_id', 'uploaded_by', 'file_path', 'file_name', 'type'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
