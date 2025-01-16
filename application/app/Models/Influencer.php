</php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $fillable = [
        'name',
        'instagram_username',
        'followers_count',
        'category',
    ];

    public function campaigns()
    {
        // Definindo explicitamente o nome da tabela intermediária
        return $this->belongsToMany(Campaign::class, 'campaign_influencer');
    }
}
