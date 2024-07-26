<?php
        $result = "";
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
                    usleep(10000); // 100 ms
                }

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
    ?>