<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Send a message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarMensaje(Request $request) {
        $nuevoMensaje = [
            'usuario' => $request->input('usuario'),
            'mensaje' => $request->input('mensaje'),
            'fecha' => now(),
        ];

        $mensajesActuales = json_decode(Storage::get('mensajes.json'), true) ?? [];
        $mensajesActuales[] = $nuevoMensaje;

        Storage::put('mensajes.json', json_encode($mensajesActuales));

        return response()->json(['mensaje' => 'Mensaje enviado con éxito']);
    }
}