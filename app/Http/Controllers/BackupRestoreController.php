<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use WatheqAlshowaiter\BackupTables\BackupTables;

class BackupRestoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $getFiles = Storage::disk('local')->files(env('APP_NAME'));
        $files = collect($getFiles)->map(function ($item) {
            return [
                'name' => basename($item),
                'created_at' => Carbon::parse(Storage::disk('local')->lastModified($item))->toDayDateTimeString(),
                'timestamp' => Storage::disk('local')->lastModified($item), // Store the timestamp for sorting
            ];
        })->sortByDesc('timestamp') // Sort by the timestamp in descending order
          ->values() // Reindex the collection
          ->toArray(); // Convert back to an array if needed

        return view('backuprestore.backuprestore_index', compact('files'));
    }

    private function generateInsertSql($data, $tableName)
    {
        $insertStatements = "INSERT INTO `$tableName` VALUES \n";

        foreach ($data as $record) {
            $values = array_map(fn($value) => is_null($value) ? 'NULL' : "'" . addslashes($value) . "'", (array)$record);
            $insertStatements .= "(" . implode(", ", $values) . "),\n";
        }

        // Remove the trailing comma and newline, and add a semicolon
        $insertStatements = rtrim($insertStatements, ",\n") . ";\n";

        return $insertStatements;
    }

    public function restore(Request $request)
    {
        Gate::authorize('is-manager');
        $request->validate([
            'backup_file' => 'required|file|mimetypes:text/plain,application/octet-stream',
        ]);

        $file = $request->file('backup_file');
        if ($file->getClientOriginalExtension() !== 'sql') {
            return back()->withErrors(['backup_file' => 'Only .sql files are allowed.']);
        }
        $path = Storage::putFile('temp', $file);

        try {
            DB::transaction(function () use ($path) {
                $sql = Storage::get($path);
                DB::unprepared($sql);
                Storage::disk('local')->delete($path);
            });
    
            Alert::success('Success', 'Database restored successfully!');
            return redirect()->route('backuprestore.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Database restore failed: ' . $e->getMessage());
            return back();
        }
    }

    public function downloadBackup(Request $request)
    {
        Gate::authorize('is-manager');
        $request->validate([
            'backup_file' => 'required|string',
        ]);
        $path = env('APP_NAME') . '/' . $request->backup_file;
        if (Storage::disk('local')->exists($path)) {
            return Storage::download($path);
        }

        Alert::error('404 Error', 'File not found');
        return back();
        // return response()->json(['error' => 'File not found.'], 404);
    }
}
