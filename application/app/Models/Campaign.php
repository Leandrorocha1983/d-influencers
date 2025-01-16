<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'budget',
        'description',
        'start_date',
        'end_date',
    ];

    // Relacionamento muitos para muitos com Influencer
    public function influencers()
    {
        // Definindo explicitamente a tabela intermediária
        return $this->belongsToMany(Influencer::class, 'campaign_influencer');
    }
}
