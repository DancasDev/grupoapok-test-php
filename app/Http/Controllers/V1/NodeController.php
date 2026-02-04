<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{

    /**
     * Crear nodo
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'parent' => 'nullable|exists:nodes,id'
        ]);
        
        $node = Node::create($validated);

        return response()->json([
            'message' => __('nodes.created'),
            'data' => $node
        ], 201);
    }

    /**
     * Listar nodos padre.
     * 
     * note: Esta no me quedo clara, asumo que es igual que "Listar nodos hijos a partir del padre" pero a la inversa (hacias arriba).
     *
     * todo: Revisar la documentación de "LaravelAdjacencyList" para verificar la forma correcta de contruir el árbol de padres. el metodo "toTree()" no representa el árbol de padres de manera correcta.
     * todo: Revisar la documentación de "LaravelAdjacencyList" para verificar el uso correcto del método "parents", ya que genera una excepción que indica que el método no está definido.
     */
    public function showParents(Request $request, string $id) {
        // Validar existencia
        try {
            $node = Node::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('nodes.not_found')
            ], 404);
        }

        // Listar
        $depth = $request->query('depth');
        if ($depth) {
            $nodes = $node->ancestors()->whereDepth('>=', $depth)->get();
            
            /*$toTree = ($request->query('toTree') == 'true');
            if ($toTree) {
                $nodes ->toTree();
            }*/
        }
        else {
            //$nodes = $node->parents();

            $nodes = $node->ancestors()->whereDepth('>=', '-1')->get();
            $nodes->each(function ($item) {
                unset($item->depth);
                unset($item->path);
            });
        }

        return response()->json($nodes, 200);
    }

    /**
     * Listar nodos padres (opcion 2).
     * 
     * Muestra los nodos raiz
     */
    public function showParents2(Request $request) {
        $nodes = Node::whereNull('parent')->get();

        return response()->json($nodes, 200);
    }


    /**
     * Listar nodos hijos a partir del padre
     */
    public function showChildren(Request $request, string $id) {
        // Validar existencia
        try {
            $node = Node::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('nodes.not_found')
            ], 404);
        }

        // Listar
        $depth = $request->query('depth');
        if ($depth) {
            $nodes = $node->descendants()->whereDepth('<=', $depth)->get();
            $toTree = ($request->query('toTree') == 'true');
            if ($toTree) {
                $nodes ->toTree();
            }
        } else {
            $nodes = $node->children;
        }

        return response()->json($nodes, 200);
    }

    /**
     * Eliminar nodo
     */
    public function destroy(string $id) {
        // Validar existencia
        try {
            $node = Node::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('nodes.not_found')
            ], 400);
        }

        // validar si no dejara hijos
        $total = $node->children()->exists();
        if ($total > 0) {
            return response()->json([
                'message' => __('nodes.has_children_not_delete')
            ], 400);
        }

        // Eliminar
        $node->delete();

        return response()->json([
            'message' => __('nodes.deleted')
        ], 200);
    }
}
