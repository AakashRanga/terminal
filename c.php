<!DOCTYPE html>
<html>
<head>
    <title>C Code Execution</title>
</head>
<body>
    <h1>C Code Execution</h1>
    <form method="post" action="">
        <label for="c_code">Enter C Code:</label><br>
        <textarea id="c_code" name="c_code" rows="10" cols="50"><?php echo isset($_POST['c_code']) ? htmlspecialchars($_POST['c_code']) : ''; ?></textarea><br>
        <button type="submit">Run C Code</button>
    </form>

    <h2>Output:</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['c_code'])) {
        $c_code = $_POST['c_code'];

        // Save the C code to a temporary file
        $temp_file = tempnam(sys_get_temp_dir(), 'c_code_') . '.c';
        $binary_file = tempnam(sys_get_temp_dir(), 'c_code_') . '.exe';
        file_put_contents($temp_file, $c_code);

        // Command to compile the C code
        $compile_command = "gcc " . escapeshellarg($temp_file) . " -o " . escapeshellarg($binary_file) . " 2>&1";
        $compile_output = shell_exec($compile_command);

        if ($compile_output) {
            echo "<pre style='color: red;'>Compilation Error: $compile_output</pre>";
        } else {
            // Set a timeout for the command execution
            $timeout = 60; // Increase timeout as needed

            // Command to run the compiled binary
            $command = escapeshellcmd($binary_file);
            $descriptorspec = [
                0 => ['pipe', 'r'], // stdin
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w']  // stderr
            ];
            $process = proc_open($command, $descriptorspec, $pipes);

            if (is_resource($process)) {
                $output = '';
                $errors = '';

                // Set stream timeouts to handle large output
                stream_set_timeout($pipes[1], $timeout);
                stream_set_timeout($pipes[2], $timeout);

                // Monitor the process
                while ($status = proc_get_status($process)) {
                    $output .= stream_get_contents($pipes[1]);
                    $errors .= stream_get_contents($pipes[2]);

                    if (!$status['running']) {
                        break;
                    }

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
        }

        // Clean up the temporary files
        unlink($temp_file);
        if (file_exists($binary_file)) {
            unlink($binary_file);
        }
    }
    ?>
</body>
</html>
