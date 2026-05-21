<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    // GET /tables — Lista todas las tablas
    public function index()
    {
        $results = DB::select('SHOW TABLES');
        $tables = array_map('current', array_map('get_object_vars', $results));
        return view('tables.index', compact('tables'));
    }

    // GET /tables/{tabla} — Muestra los datos de una tabla
    public function show(string $tabla)
    {
        $tabla = $this->sanitizeTableName($tabla);

        $rows = DB::select("SELECT * FROM `{$tabla}`");
        $rows = array_map(fn($r) => (array) $r, $rows);

        $columns = count($rows) > 0 ? array_keys($rows[0]) : [];
        $primaryKey = $columns[0] ?? null;

        return view('tables.show', compact('tabla', 'rows', 'columns', 'primaryKey'));
    }

    // GET /tables/{tabla}/create — Formulario de inserción
    public function create(string $tabla)
    {
        $tabla = $this->sanitizeTableName($tabla);

        $columnsInfo = [];
        foreach (DB::select("DESCRIBE `{$tabla}`") as $col) {
            $columnsInfo[$col->Field] = (array) $col;
        }

        // Claves foráneas
        $foreignKeys = [];
        $fks = DB::select("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL
            AND TABLE_SCHEMA = DATABASE()
        ", [$tabla]);

        foreach ($fks as $fk) {
            $refVals = DB::select("SELECT `{$fk->REFERENCED_COLUMN_NAME}` FROM `{$fk->REFERENCED_TABLE_NAME}` ORDER BY 1 ASC");
            $foreignKeys[$fk->COLUMN_NAME] = [
                'values' => array_column(array_map('get_object_vars', $refVals), $fk->REFERENCED_COLUMN_NAME),
            ];
        }

        // Calcular próximo ID
        $primaryKey = null;
        $nextId = null;
        foreach ($columnsInfo as $col => $info) {
            if ($info['Key'] === 'PRI') {
                $primaryKey = $col;
                $max = DB::selectOne("SELECT MAX(`{$col}`) as maxId FROM `{$tabla}`");
                $nextId = (($max->maxId ?? 0) + 1);
                break;
            }
        }

        return view('tables.create', compact('tabla', 'columnsInfo', 'foreignKeys', 'nextId'));
    }

    // POST /tables/{tabla}/store — Guarda el nuevo registro
    public function store(Request $request, string $tabla)
    {
        $tabla = $this->sanitizeTableName($tabla);

        $columnsInfo = [];
        foreach (DB::select("DESCRIBE `{$tabla}`") as $col) {
            $columnsInfo[$col->Field] = (array) $col;
        }

        $data = [];
        foreach ($columnsInfo as $col => $info) {
            if ($info['Key'] === 'PRI') continue;
            if ($request->has($col) && $request->input($col) !== '') {
                $data[$col] = $request->input($col);
            }
        }

        if (!empty($data)) {
            DB::table($tabla)->insert($data);
        }

        return redirect()->route('tables.show', $tabla)
            ->with('success', 'Registro insertado exitosamente.');
    }

    // GET /tables/{tabla}/{id}/edit — Formulario de edición (solo Products)
    public function edit(string $tabla, $id)
    {
        $tabla = $this->sanitizeTableName($tabla);
        abort_if($tabla !== 'Products', 403, 'Solo se pueden editar productos.');

        $product = DB::selectOne("SELECT PRO_id, PRO_name, PRO_description, PRO_price FROM Products WHERE PRO_id = ?", [$id]);
        abort_if(!$product, 404, 'Producto no encontrado.');

        $product = (array) $product;
        return view('tables.edit', compact('product'));
    }

    // PUT /tables/{tabla}/{id} — Actualiza el registro (solo Products)
    public function update(Request $request, string $tabla, $id)
    {
        abort_if($tabla !== 'Products', 403, 'Solo se pueden editar productos.');

        $request->validate([
            'PRO_name'        => 'required|string|max:255',
            'PRO_description' => 'required|string',
            'PRO_price'       => 'required|numeric|min:0',
        ]);

        DB::table('Products')->where('PRO_id', $id)->update([
            'PRO_name'        => trim($request->PRO_name),
            'PRO_description' => trim($request->PRO_description),
            'PRO_price'       => (float) $request->PRO_price,
        ]);

        return redirect()->route('tables.show', 'Products')
            ->with('success', '✅ Producto actualizado correctamente.');
    }

    // DELETE /tables/{tabla}/{id} — Elimina el registro
    public function destroy(string $tabla, $id)
    {
        $tabla = $this->sanitizeTableName($tabla);

        $columnsRaw = DB::select("SHOW COLUMNS FROM `{$tabla}`");
        $primaryKey = $columnsRaw[0]->Field;

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::delete("DELETE FROM `{$tabla}` WHERE `{$primaryKey}` = ?", [$id]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        return redirect()->route('tables.show', $tabla)
            ->with('success', 'Registro eliminado correctamente.');
    }

    // Sanitiza el nombre de la tabla (solo letras, números y guiones bajos)
    private function sanitizeTableName(string $tabla): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $tabla);
    }
}
