<?php
include ("../../conn.php");
$result = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $python_code = $_POST['python_code'];
    

    if (isset($_POST['run_code'])) {
        // Save the Python code to a temporary file
        $temp_file = tempnam(sys_get_temp_dir(), 'python_code_') . '.py';
        file_put_contents($temp_file, $python_code);

        // Command to run the Python script
        $command = escapeshellcmd("python " . $temp_file);

        // Start the process
        $descriptorspec = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w']  // stderr
        ];
        $process = proc_open($command, $descriptorspec, $pipes);

        if (is_resource($process)) {
            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            // Display output or errors
            if (!empty($output)) {
                $result = $output;
            }
            if (!empty($errors)) {
                $result = $errors;
            }
        } else {
            $result = "Error opening process.";
        }

        // Clean up the temporary file
        unlink($temp_file);
    }

    echo $result;
}
?>
