<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KriteriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kriteria' => $this->kriteria,
            'bobot' => $this->bobot,
            'jenis_kriteria' => $this->jenis_kriteria,
        ];
    }
}
