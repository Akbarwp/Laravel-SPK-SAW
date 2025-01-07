<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenilaianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'alternatif_id' => $this->alternatif_id,
            'kriteria_id' => $this->kriteria_id,
            'sub_kriteria_id' => $this->sub_kriteria_id,
        ];
    }
}
