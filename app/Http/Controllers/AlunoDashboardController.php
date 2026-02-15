<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Oferta;

class AlunoDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $perfilIncompleto = empty($user->curso) || empty($user->ingresso) || empty($user->genero);

        $mensagensNaoLidas = Message::where('to_id', $user->id)
            ->where('read', false)
            ->count();

        $ultimasMensagens = Message::where(function($q) use ($user) {
                $q->where('to_id', $user->id)->orWhere('from_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($msg) use ($user) {
                return $msg->from_id == $user->id ? $msg->to_id : $msg->from_id;
            })
            ->take(5);

        $todasOfertas = Oferta::where('ativa', true)->get();

        $sugestoes = $todasOfertas->map(function ($oferta) use ($user) {
            
            $score = 50;

            $regras = $oferta->regras ?? [];
            $comodidades = $oferta->comodidades ?? [];
            $caracteristicas = array_merge($regras, $comodidades);

            if ($user->pets) {
                if (in_array('pet', $caracteristicas) || in_array('animais', $caracteristicas)) {
                    $score += 30;
                } else {
                    $score = 0;
                }
            } else {
                if (in_array('pet', $caracteristicas)) $score += 5;
            }

            if ($user->fuma) {
                if (in_array('fumo', $caracteristicas) || in_array('pode_fumar', $caracteristicas)) {
                    $score += 20;
                } else {
                    $score -= 30;
                }
            } else {
                if (in_array('nao_fuma', $caracteristicas) || !in_array('fumo', $caracteristicas)) {
                    $score += 10;
                }
            }

            if ($user->silencio) {
                if (in_array('silencio', $caracteristicas)) {
                    $score += 20;
                } else if (in_array('festas', $caracteristicas)) {
                    $score -= 20;
                }
            }

            if ($score > 0) {
                $oferta->match_score = min(100, $score);
            } else {
                $oferta->match_score = 0;
            }
            
            return $oferta;
        });

        $sugestoes = $sugestoes->sortByDesc('match_score')->values();

        $melhorMatch = $sugestoes->first();
        $outrasSugestoes = $sugestoes->skip(1)->take(3);

        return view('dashboard_aluno', compact(
            'user', 
            'perfilIncompleto', 
            'mensagensNaoLidas', 
            'ultimasMensagens',
            'melhorMatch', 
            'outrasSugestoes'
        ));
    }
}