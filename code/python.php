<?php
include ("../conn.php");
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
        } elseif (isset($_POST['submit_code'])) {
            $code_output = $_POST['code_output'];

            if (empty($python_code)) {
                echo "<script type='text/javascript'>alert('Code cannot be empty');</script>";
            } else {
                // Check if the entry already exists
                $check_sql = "SELECT * FROM practise_code WHERE regno='21617' AND question_no='$course_id'";
                $check_result = $db_connect->query($check_sql);

                if ($check_result->num_rows > 0) {
                    // Update existing entry
                    $sql = "UPDATE practise_code SET code='$python_code', output='$code_output', topic='$topic' WHERE regno='21617' AND question_no='$course_id'";
                } else {
                    // Insert new entry
                    $sql = "INSERT INTO practise_code (regno, code, output, question_no, topic) VALUES ('21617', '$python_code', '$code_output', '$course_id', '$topic')";
                }

                if ($db_connect->query($sql) === TRUE) {
                    $result = "Code and output saved successfully.";
                } else {
                    $result = "Error: " . $sql . "<br>" . $db_connect->error;
                }
            }

            $db_connect->close();
        }
    }
    ?>
