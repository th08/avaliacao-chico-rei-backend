<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{

    public function index()
    {
        return Produto::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'      => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'preco'     => 'required|numeric',
            'imagem'    => 'required|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('imagem')) {
                $path = $request->file('imagem')->store('imagens', 'public');
                $validated['imagem'] = $path;
            }

            $product = Produto::create($validated);

            DB::commit();
            return response()->json($product, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao salvar o produto'], 500);
        }
    }

    public function show($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
            $path = Storage::disk('public')->path($produto->imagem);
            $imagemBase64 = base64_encode(file_get_contents($path));
            $produto->imagemUrl = "data:image/" . pathinfo($path, PATHINFO_EXTENSION) . ";base64," . $imagemBase64;
        } else {
            $produto->imagemUrl = null;
        }

        return response()->json($produto);
    }

    public function update(Request $request, $id)
    {
        $product = Produto::findOrFail($id);

        $validated = $request->validate([
            'nome'      => 'sometimes|required|string|max:100',
            'descricao' => 'sometimes|required|string|max:500',
            'preco'     => 'sometimes|required|numeric',
            'imagem'    => 'sometimes|required|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('imagem')) {
                if ($product->imagem && Storage::disk('public')->exists($product->imagem)) {
                    Storage::disk('public')->delete($product->imagem);
                }

                $path = $request->file('imagem')->store('imagens', 'public');
                $validated['imagem'] = $path;
            }

            $product->update($validated);

            DB::commit();
            return response()->json($product);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao atualizar o produto'], 500);
        }
    }

    public function destroy($id)
    {
        $product = Produto::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($product->imagem && Storage::disk('public')->exists($product->imagem)) {
                Storage::disk('public')->delete($product->imagem);
            }

            $product->delete();

            DB::commit();
            return response()->json(['message' => 'Produto deletado com sucesso!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao excluir o produto'], 500);
        }
    }
}
