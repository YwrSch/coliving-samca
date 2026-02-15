<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Oferta;
use App\Models\User;

class ProprietarioDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalImoveis = Oferta::where('user_id', $user->id)->count();
        $imoveisAtivos = Oferta::where('user_id', $user->id)->where('ativa', true)->count();

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

        $meusAnuncios = Oferta::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $minhasRegras = $meusAnuncios->pluck('regras')->flatten()->unique()->toArray();

        $alunosInteressados = User::where('role', 'estudante')
            ->get()
            ->filter(function($aluno) use ($minhasRegras) {
                $score = 0;

                if ($aluno->pets && (in_array('pet', $minhasRegras) || in_array('animais', $minhasRegras))) {
                    $score += 50;
                }
                
                if ($aluno->silencio && in_array('silencio', $minhasRegras)) {
                    $score += 30;
                }

                return $score > 0;
            })
            ->take(4);

        return view('dashboard_proprietario', compact(
            'user',
            'totalImoveis',
            'imoveisAtivos',
            'mensagensNaoLidas',
            'ultimasMensagens',
            'meusAnuncios',
            'alunosInteressados'
        ));
    }
}