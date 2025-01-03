<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;



    public static function batchUpdate(array $data, array $columns)
    {
        if (empty($data) || empty($columns)) {
            return false;
        }

        $tableName = (new static)->getTable();
        $cases = [];
        $ids = [];

        // Build the CASE statements for each column
        foreach ($columns as $column) {
            $columnCases = [];
            foreach ($data as $item) {
                if (isset($item['id'], $item[$column])) {
                    $id = $item['id'];
                    $value = $item[$column];
                    $columnCases[] = "WHEN id = {$id} THEN '{$value}'";
                    $ids[] = $id; // Collect IDs
                }
            }
            $cases[$column] = "SET {$column} = CASE " . implode(' ', $columnCases) . " END";
        }

        $idList = implode(',', array_unique($ids)); // Ensure unique IDs

        // Combine all CASE statements
        $setStatements = implode(', ', $cases);

        // Build the final SQL query
        $sql = "UPDATE {$tableName} {$setStatements} WHERE id IN ({$idList})";

        return DB::statement($sql);
    }
}
