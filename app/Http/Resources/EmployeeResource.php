<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employee_number' => $this->employee_number,
            'name' => $this->name,
            'address' => $this->address,
            'birth_date' => Carbon::parse($this->birth_date)->format('d M y'),
            'join_date' => Carbon::parse($this->join_date)->format('d M y'),
            'leaveBalances' => LeaveBalanceResource::collection($this->whenLoaded('leaveBalances')),
            'leaves' => LeaveResource::collection($this->whenLoaded('leaves'))
        ];
    }
}
