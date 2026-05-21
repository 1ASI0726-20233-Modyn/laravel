<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseTableController extends Controller
{
    public function index()
    {
        $results = DB::select('SHOW TABLES');
        $tables  = array_map('current', array_map('get_object_vars', $results));

        return view('tables.table-list', compact('tables'));
    }

    public function show(string $tabla)
    {
        $tabla = $this->sanitize($tabla);

        $rows      = array_map(fn($r) => (array) $r, DB::select("SELECT * FROM `{$tabla}`"));
        $columns   = count($rows) > 0 ? array_keys($rows[0]) : [];
        $primaryKey = $columns[0] ?? null;

        return view('tables.table-records', compact('tabla', 'rows', 'columns', 'primaryKey'));
    }

    public function create(string $tabla)
    {
        $tabla = $this->sanitize($tabla);

        $columnsInfo = [];
        foreach (DB::select("DESCRIBE `{$tabla}`") as $col) {
            $columnsInfo[$col->Field] = (array) $col;
        }

        $foreignKeys = [];
        $fks = DB::select("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL AND TABLE_SCHEMA = DATABASE()
        ", [$tabla]);

        foreach ($fks as $fk) {
            $vals = DB::select("SELECT `{$fk->REFERENCED_COLUMN_NAME}` FROM `{$fk->REFERENCED_TABLE_NAME}` ORDER BY 1 ASC");
            $foreignKeys[$fk->COLUMN_NAME] = [
                'values' => array_column(array_map('get_object_vars', $vals), $fk->REFERENCED_COLUMN_NAME),
            ];
        }

        $nextId = null;
        foreach ($columnsInfo as $col => $info) {
            if ($info['Key'] === 'PRI') {
                $max    = DB::selectOne("SELECT MAX(`{$col}`) as maxId FROM `{$tabla}`");
                $nextId = ($max->maxId ?? 0) + 1;
                break;
            }
        }

        return view('tables.record-create', compact('tabla', 'columnsInfo', 'foreignKeys', 'nextId'));
    }

    public function store(Request $request, string $tabla)
    {
        $tabla = $this->sanitize($tabla);

        $data = [];
        foreach (DB::select("DESCRIBE `{$tabla}`") as $col) {
            if ($col->Key === 'PRI') continue;
            if ($request->filled($col->Field)) {
                $data[$col->Field] = $request->input($col->Field);
            }
        }

        if (!empty($data)) {
            DB::table($tabla)->insert($data);
        }

        return redirect()->route('tables.show', $tabla)
            ->with('success', 'Registro insertado exitosamente.');
    }

    public function edit(string $tabla, $id)
    {
        abort_if($tabla !== 'Products', 403, 'Solo se pueden editar productos.');

        $product = DB::selectOne(
            "SELECT PRO_id, PRO_name, PRO_description, PRO_price FROM Products WHERE PRO_id = ?",
            [$id]
        );
        abort_if(!$product, 404, 'Producto no encontrado.');

        $product = (array) $product;

        return view('tables.record-edit', compact('product'));
    }

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

    public function destroy(string $tabla, $id)
    {
        $tabla = $this->sanitize($tabla);

        $cols       = DB::select("SHOW COLUMNS FROM `{$tabla}`");
        $primaryKey = $cols[0]->Field;

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::delete("DELETE FROM `{$tabla}` WHERE `{$primaryKey}` = ?", [$id]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        return redirect()->route('tables.show', $tabla)
            ->with('success', 'Registro eliminado correctamente.');
    }

    private function sanitize(string $tabla): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $tabla);
    }
}
