<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\Process\Process;

class BackupRestoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $backupPath = storage_path('app/backups');   
        $files = Storage::disk('backups')->files();
        // dd($files);
        return view('backuprestore.backuprestore_index', compact('files'));
    }

    public function backupDB()
    {
        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = storage_path('app/backups');
        $backupFile = 'backup_' . now()->format('Y_m_d_H_i_s') . '.sql';

        // Ensure the backups directory exists
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0777, true);
        }
        // Use the path to mysqldump from the environment
        $mysqldumpPath = env('DB_MYSQLDUMP_PATH', 'mysqldump') . '\mysqldump.exe'; // Default to 'mysqldump' if not set
        // dd($mysqldumpPath);
        // Generate the mysqldump command
        $dumpCommand = "\"{$mysqldumpPath}\" -u {$username} -p{$password} -h {$host} {$databaseName} > \"{$backupPath}/{$backupFile}\"";

        // Execute the command
        $process = Process::fromShellCommandline($dumpCommand);
        $process->run();

        if ($process->isSuccessful()) {
            Alert::success('Success', ' Database backup completed successfully.');
            return redirect()->back();
            // return response()->json(['message' => 'Backup created successfully', 'file' => $backupFile]);
        }
        Alert::error('500 Error', 'Database backup failed. Error: ' . $process->getErrorOutput());
        return back();
        // return response()->json(['message' => 'Backup failed', 'error' => $process->getErrorOutput()], 500);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string', // The file name of the backup
        ]);

        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = storage_path('app/backups/' . $request->backup_file);

        // Check if the file exists
        if (!file_exists($backupPath)) {
            Alert::error('404 Error', 'Backup file not found.');
            return back();
            // return response()->json(['message' => 'Backup file not found'], 404);
        }

        // Generate the mysql import command
        $restoreCommand = "mysql -u {$username} -p{$password} -h {$host} {$databaseName} < {$backupPath}";

        // Execute the command
        $process = Process::fromShellCommandline($restoreCommand);
        $process->run();

        if ($process->isSuccessful()) {
            Alert::success('Success', ' Database backup restored successfully.');
            return redirect()->back();
            // return response()->json(['message' => 'Database restored successfully']);
        }
        Alert::error('500 Error', 'Restore failed. Error: ' . $process->getErrorOutput());
        return back();
        // return response()->json(['message' => 'Restore failed', 'error' => $process->getErrorOutput()], 500);
    }

    public function backupNow()
    {
        try {
            // Trigger the backup:run command
            Artisan::call('backup:run --only-db');
            // Return success message or handle response
            Alert::success('Success', 'Backup completed successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle errors
            Alert::error('Error', 'Backup failed. Error: ' . $e->getMessage());
            return back();
            // return response()->json(['message' => 'Backup failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function downloadBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required',
        ]);
        // $filePath = env('APP_NAME') . '/' . $request->backup_file;
        dd(Storage::download('backup_2024_11_14_11_44_51.sql'));
        if (Storage::disk('backups')->exists($request->backup_file)) {
            return Storage::download($request->backup_file);
        }

        Alert::error('404 Error', 'File not found');
        return back();
        // return response()->json(['error' => 'File not found.'], 404);
    }
}
