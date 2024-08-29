<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStage extends Model
{
    protected $fillable = [
        'name',
        'pipeline_id',
        'created_by',
        'order',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

    public function lead()
{
    if(\Auth::user()->type == 'company'){
        return Lead::select('leads.*')
            ->where('leads.created_by', '=', \Auth::user()->creatorId())
            ->where('leads.stage_id', '=', $this->id)
            ->orderBy('leads.created_at', 'desc')  // Order by creation date first
            ->orderBy('leads.order')  // Then order by the specified order
            ->get();
    } else {
        return Lead::select('leads.*')
            ->join('user_leads', 'user_leads.lead_id', '=', 'leads.id')
            ->where('user_leads.user_id', '=', \Auth::user()->id)
            ->where('leads.stage_id', '=', $this->id)
            ->orderBy('leads.created_at', 'desc')  // Order by creation date first
            ->orderBy('leads.order')  // Then order by the specified order
            ->get();
    }
}

}
