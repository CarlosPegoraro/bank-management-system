<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function getNotification()
    {
        // Obtém o usuário logado
        $user = Auth::user();

        // Encontra a notificação mais antiga não lida do tipo 'toast' dentro da coluna JSON 'data'
        $notification = $user->notifications()
            ->whereNull('read_at')
            ->whereRaw("data::json->>'channel' = 'toast'")
            ->oldest()
            ->first();

        if ($notification) {
            // Marca a notificação como lida
            $notification->update(['read_at' => Carbon::now()]);

            // Retornar a notificação encontrada
            return response()->json($notification);
        } else {
            // Caso não encontre nenhuma notificação
            return response()->json(['message' => 'Nenhuma notificação não lida encontrada'], 404);
        }
    }

}
