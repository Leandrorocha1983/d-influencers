<?php

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $campaign = Campaign::create($request->all());

        return response()->json($campaign, 201);
    }

    public function index()
    {
        $campaigns = Campaign::all();
        return response()->json($campaigns);
    }

    public function addInfluencer(Request $request, $campaignId)
{
    $request->validate([
        'influencer_id' => 'required|exists:influencers,id',
    ]);

    $campaign = Campaign::findOrFail($campaignId);
    $campaign->influencers()->attach($request->influencer_id);

    return response()->json(['message' => 'Influencer added to campaign']);
}

}
