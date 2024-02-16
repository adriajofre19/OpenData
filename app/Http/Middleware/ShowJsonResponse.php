<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Comment;

class ShowJsonResponse
{
    public function handle(Request $request, Closure $next, $dataType)
    {
        if ($request->has('token')) {
            $token = $request->token;

            // Buscamos el usuario correspondiente al token
            $user = User::where('api_token', $token)->first();

            // Verificamos si el usuario existe
            if ($user) {
                // Obtenemos el ID del usuario autenticado
                $userId = auth()->id();

                // Verificamos el tipo de datos solicitados
                switch ($dataType) {
                    case 'plans':
                        // Obtenemos los planes del usuario por su ID
                        $data = Plan::getPlansById($userId);
                        break;
                    case 'comments':
                        // Obtenemos los comentarios del usuario por su ID
                        $data = Comment::getCommentsByIdUser($userId);
                        break;
                    default:
                        // Si se proporciona un tipo de datos inválido, retornamos un error
                        return response()->json(['error' => 'Tipo de datos no válido'], 400);
                }

                // Retornamos los datos solicitados como respuesta JSON
                return response()->json([$dataType => $data]);
            }
        }

        // Si el token es inválido o no se proporciona, continuamos con la solicitud
        return $next($request);
    }
}
