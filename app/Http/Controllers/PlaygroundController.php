<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaygroundSendRequest;
use App\Models\ProviderModel;

class PlaygroundController extends Controller
{
    public function index()
    {
        $providerModels = ProviderModel::active()
            ->get()
            ->map(
                fn($providerModel) => $providerModel->name . ' ( ' . $providerModel->input_format . ' -> ' . $providerModel->output_format . ' )'
            )
            ->toArray();

        return view('playground.index', ['providerModels' => $providerModels]);
    }

    public function send(PlaygroundSendRequest $request)
    {
        $query = $request->q;
        $providerModel = $request->model_id;

        return response()->json(['result' => 1]);
    }
}
