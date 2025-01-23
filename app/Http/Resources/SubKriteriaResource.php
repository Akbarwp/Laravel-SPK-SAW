<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubKriteriaResource extends JsonResource
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
            'sub_kriteria' => $this->sub_kriteria,
            'bobot' => $this->bobot,
            'kriteria' => new KriteriaResource($this->kriteria_id),
        ];
    }
}
