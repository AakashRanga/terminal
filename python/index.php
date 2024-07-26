<!DOCTYPE html>
<html>
<head>
    <title>Python Code Execution</title>
</head>
<body>
    <h1>Python Code Execution</h1>
    <form method="post" action="">
        <label for="python_code">Enter Python Code:</label><br>
        <textarea id="python_code" name="python_code" rows="10" cols="50"><?php echo isset($_POST['python_code']) ? htmlspecialchars($_POST['python_code']) : ''; ?></textarea><br>
        <button type="submit">Run Python Code</button>
    </form>

    <h2>Output:</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['python_code'])) {
        $python_code = $_POST['python_code'];

        // Save the Python code to a temporary file
        $temp_file = tempnam(sys_get_temp_dir(), 'python_code_') . '.py';
        file_put_contents($temp_file, $python_code);

        // Command to run the Python script
        $command = escapeshellcmd("python " . $temp_file);

        // Set a timeout for the command execution
        $timeout = 5; // seconds

        // Start the process
        $descriptorspec = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w']  // stderr
        ];
        $process = proc_open($command, $descriptorspec, $pipes);
        $start_time = microtime(true);

        if (is_resource($process)) {
            $output = '';
            $errors = '';

            // Monitor the process
            while (true) {
                $status = proc_get_status($process);
                $current_time = microtime(true);

                if (!$status['running']) {
                    break;
                }

                // Check if the timeout has been reached
                if (($current_time - $start_time) > $timeout) {
                    echo "<pre style='color: red;'>Execution timed out. Stopping process.</pre>";
                    proc_terminate($process);  // Terminate the process
                    break;
                }

                // Non-blocking read from stdout and stderr
                $output .= stream_get_contents($pipes[1]);
                $errors .= stream_get_contents($pipes[2]);

                // Sleep briefly to prevent busy waiting
                usleep(100000); // 100 ms
            }

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);

            // Display output or errors
            if (!empty($output)) {
                echo "<pre>$output</pre>";
            }
            if (!empty($errors)) {
                echo "<pre style='color: red;'>Error: $errors</pre>";
            }
        } else {
            echo "<pre style='color: red;'>Error opening process.</pre>";
        }

        // Clean up the temporary file
        unlink($temp_file);
    }
    ?>
</body>
</html>
