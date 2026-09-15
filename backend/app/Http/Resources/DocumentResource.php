<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    // file_path сюда намеренно не выводим — прямой ссылки на скачивание
    // пока нет (появится позже, отдельным authorized-эндпоинтом)
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ];
    }
}
