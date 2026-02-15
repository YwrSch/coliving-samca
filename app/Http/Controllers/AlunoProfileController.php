<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AlunoProfileController extends Controller
{

    public function show()
    {
        $user = Auth::user();
        return view('ver_perfil', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('configurar_perfil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'curso' => 'required|string',
            'ingresso' => 'required|string',
            'conclusao' => 'required|string',
            'genero' => 'required|string',
            'nascimento' => 'required|string',
        ]);

        $user->curso = $request->curso;
        $user->ingresso = $request->ingresso;
        $user->conclusao = $request->conclusao;
        $user->genero = $request->genero;

        try {
            $user->data_nascimento = Carbon::createFromFormat('d/m/Y', $request->nascimento)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['nascimento' => 'Formato de data inválido. Use dia/mês/ano.']);
        }

        $user->fuma = $request->has('fuma');
        $user->pets = $request->has('pets');
        $user->silencio = $request->has('silencio');
        $user->visitas = $request->has('visitas');
        $user->vegetariano = $request->has('vegetariano');

        $user->save();

        return redirect()->route('aluno.dashboard')->with('success', 'Perfil configurado com sucesso!');
    }
}