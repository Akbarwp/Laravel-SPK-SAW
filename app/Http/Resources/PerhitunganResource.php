<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerhitunganResource extends JsonResource
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
            'alternatif_id' => new AlternatifResource($this->alternatif_id),
            'kriteria_id' => new KriteriaResource($this->kriteria_id),
            'nilai' => $this->nilai,
        ];
    }
}
