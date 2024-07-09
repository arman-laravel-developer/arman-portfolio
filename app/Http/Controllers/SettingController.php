<?php

namespace App\Http\Controllers;

use App\Models\VisitorInfo;
use Illuminate\Http\Request;
use ZipArchive;

class SettingController extends Controller
{
    public function testMail(Request $request)
    {
        if (env('MAIL_USERNAME') != null) {
            $data['email'] = $request->email;

            Mail::send('emails.test-mail', ['data' => $data], function ($message) use ($data){
                $message->to($data['email'])->subject('test mail');
            });
        }

        flash()->success('Test Mail', 'Test mail send successfull');
        return redirect()->back();
    }

    public function smtp()
    {
        return view('admin.setting.smtp');
    }

    public function smtpUpdate(Request $request)
    {
        $this->validate($request, [
            'MAIL_MAILER' => 'required|string',
            'MAIL_HOST' => 'required|string',
            'MAIL_PORT' => 'required|integer',
            'MAIL_USERNAME' => 'required|string',
            'MAIL_PASSWORD' => 'required|string',
            'MAIL_ENCRYPTION' => 'required|string',
            'MAIL_FROM_ADDRESS' => 'required|string|email',
            'MAIL_FROM_NAME' => 'required|string',
        ]);

        $data = [
            'MAIL_MAILER' => $request->input('MAIL_MAILER'),
            'MAIL_HOST' => $request->input('MAIL_HOST'),
            'MAIL_PORT' => $request->input('MAIL_PORT'),
            'MAIL_USERNAME' => $request->input('MAIL_USERNAME'),
            'MAIL_PASSWORD' => $request->input('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => $request->input('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => $request->input('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => $request->input('MAIL_FROM_NAME'),
        ];

        updateEnv($data);

        flash()->success('SMTP Update', 'SMTP settings updated successfully!');
        return redirect()->back();
    }

    public function backup()
    {
        // Database configuration
        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database_name = env('DB_DATABASE');

        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");

        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {

            // Prepare SQL script for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            $sqlScript .= "\n\n" . $row[1] . ";\n\n";

            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQL script for dumping data for each table
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "\n";
        }

        if (!empty($sqlScript)) {
            // Define the directory path within the public folder
            $backupDir = 'backups';
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0777, true);
            }

            // Define the backup file name
            $backupFileName = $backupDir . '/' . $database_name . '_backup_' . time() . '.sql';

            // Save the SQL script to the backup file
            file_put_contents($backupFileName, $sqlScript);

            // Create a zip file of the backup
            $zipFileName = $backupDir . '/' . $database_name . '_backup_' . time() . '.zip';
            $zip = new ZipArchive();
            if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($backupFileName, basename($backupFileName));
                $zip->close();

                // Optionally delete the .sql file after zipping
                unlink($backupFileName);
            }

            // Return the URL of the zip file
            return redirect('backups/' . basename($zipFileName));
        }

        return response()->json(['error' => 'No backup generated'], 500);
    }

    public function visitor()
    {
        $visitors = VisitorInfo::latest()->get();
        return view('admin.setting.visitor', compact('visitors'));
    }
}
