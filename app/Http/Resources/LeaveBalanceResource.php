<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveBalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            // 'employee_id' => $this->employee_id,

            // 'employee' => $this->whenLoaded('employee', function () {
            //     return [
            //         'id' => $this->employee->id,
            //         'employee_number' => $this->employee->employee_number,
            //         'name' => $this->employee->name,
            //     ];
            // }),

            'employee_number' => $this->whenLoaded('employee', $this->employee->employee_number),
            'name' => $this->whenLoaded('employee', $this->employee->name),

            // 'year' => $this->year,
            'leave_quota' => $this->leave_quota,
            // 'leave_taken' => $this->leave_taken
        ];
    }
}
