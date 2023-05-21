<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaygroundSendRequest;
use App\Models\ProviderModel;
use App\Services\Ai\AiService;
use App\Services\Ai\Models\AiModelResolver;
use App\Services\Ai\Models\Gpt35TurboAiModel;
use App\Services\Ai\Models\Gpt4AiModel;
use App\Services\Ai\Models\NullAiModel;

class PlaygroundController extends Controller
{
    public function index()
    {
        $providerModels = ProviderModel::active()
            ->get()
            ->mapWithKeys(
                fn($providerModel) => [$providerModel->id => $providerModel->name . ' ( ' . $providerModel->input_format . ' -> ' . $providerModel->output_format . ' )']
            )
            ->toArray();

        return view('playground.index', ['providerModels' => $providerModels]);
    }

    public function send(PlaygroundSendRequest $request)
    {
        $query = $request->q;
        $providerModel = $request->provider_model;

        $aiModel = AiModelResolver::make($providerModel->slug)->resolve($query);
        if ($aiModel instanceof NullAiModel) {
            return response()->json(['result' => 2, 'answer' => 'Error: This model is not available yet']);
        }

        $answer = '';
        try {
            $client = AiService::createCompletionFactory();
            if ($aiModel instanceof Gpt4AiModel || $aiModel instanceof Gpt35TurboAiModel) {
                $client = AiService::createChatFactory();
            }
            $response = $client->send($aiModel->getData());
            if (empty($response->id)) {
                return response()->json(['result' => 2, 'answer' => 'Error: No answer from OpenAI']);
            }
            $answer = $client->getResult();
        } catch (\Exception $e) {
            return response()->json(['result' => 2, 'answer' => $e->getMessage()]);
        }

        return response()->json(['result' => 1, 'answer' => $answer]);
    }
}
