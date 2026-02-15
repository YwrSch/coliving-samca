<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProprietarioOfertaController extends Controller
{
    public function create()
    {
        return view('publicar_oferta'); 
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'titulo_anuncio' => 'required|string|max:255',
            'tipo_imovel' => 'required|string',
            'bairro' => 'required|string',
            'rua' => 'required|string',
            'numero' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tipo_vaga' => 'required|string',
            'num_vagas' => 'required|integer|min:1',
            'preco_mensal' => 'required|numeric|min:50',
            'fotos' => 'required|array|min:3',
            'fotos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'complemento' => 'nullable|string',
            'custos' => 'nullable|array',
            'comodidades' => 'nullable|array',
            'regras' => 'nullable|array',
            'resumo_regras' => 'nullable|string',
        ]);

        $caminhosDasFotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $caminho = $foto->store('ofertas_fotos', 'public');
                $caminhosDasFotos[] = $caminho;
            }
        }

        $dadosParaSalvar = $dadosValidados;
        $dadosParaSalvar['user_id'] = Auth::id();
        $dadosParaSalvar['fotos'] = $caminhosDasFotos;
        Oferta::create($dadosParaSalvar);

        return redirect()->route('proprietario.dashboard')
                         ->with('status', 'Nova oferta publicada com sucesso!');
    }

    public function edit($id)
    {
        $oferta = Oferta::where('user_id', Auth::id())->findOrFail($id);
        return view('editar_oferta', ['oferta' => $oferta]);
    }

    public function update(Request $request, $id)
    {
        $oferta = Oferta::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'titulo_anuncio' => 'required|string|max:255',
            'preco_mensal' => 'required|numeric',
        ]);

        $oferta->titulo_anuncio = $request->titulo_anuncio;
        $oferta->preco_mensal = $request->preco_mensal;
        $oferta->bairro = $request->bairro;
        $oferta->rua = $request->rua;
        $oferta->numero = $request->numero;
        $oferta->tipo_vaga = $request->tipo_vaga;
        $oferta->num_vagas = $request->num_vagas;
        $oferta->resumo_regras = $request->resumo_regras;
        
        if($request->has('comodidades')) $oferta->comodidades = $request->comodidades;
        $oferta->save();

        return redirect()->route('proprietario.gerenciar')->with('success', 'Oferta atualizada com sucesso!');
    }

    public function toggleStatus($id)
    {
        $oferta = Oferta::where('user_id', Auth::id())->findOrFail($id);
        $oferta->ativa = !$oferta->ativa; 
        $oferta->save();
        $status = $oferta->ativa ? 'reativada' : 'pausada';
        return back()->with('success', "Oferta $status com sucesso!");
    }

    public function destroy($id)
    {
        $oferta = Oferta::where('user_id', Auth::id())->findOrFail($id);
        
        if (!empty($oferta->fotos)) {
            foreach ($oferta->fotos as $fotoPath) {
                if (Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
            }
        }

        $oferta->delete();
        return back()->with('success', 'Oferta e imagens removidas com sucesso.');
    }
}