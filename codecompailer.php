<?php
    include("../conn.php");
    $course_id = $_GET['id'];

    $sql = "SELECT * FROM coding_test WHERE id = '$course_id'";
    $result = $db_connect->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $topic = $row['topic'];
            $task = $row['task'];
            $qst_overview = $row['qst_overview'];
            $input_format = $row['input_format'];
            $constraints = $row['constraints'];
            $output_format = $row['output_format'];
            $sample_input_0 = $row['sample_input_0'];
            $sample_output_0 = $row['sample_output_0'];
            $explanation = $row['explanation'];
            $timing = $row['timing'];
            $code = $row['code'];

        }
    } else {
        echo "No challenges found for the selected topic.";
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="../Images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('#output').val().trim() !== '') {
                $('.rgtscrollable').animate({
                    scrollTop: $('.rgtscrollable')[0].scrollHeight
                }, 1000);
            }
        });
    </script>

</head>

<body>

    <?php include('navbar.php'); ?>

    <?php
        $result = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $python_code = $_POST['python_code'];

            if (isset($_POST['run_code'])) {
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
            } elseif (isset($_POST['submit_code'])) {
                $code_output = $_POST['code_output'];
        
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
        
                $db_connect->close();
            }
        }
        ?>

    <section class="main-secc">
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-lg-5 col-md-5 col-sm-12 scrollable">
                    <h4>Task</h4>
                    <p><?php echo $qst_overview; ?></p>
                    <ul>
                        <li><?php echo $task; ?></li>
                        <!-- <li>If n is even and in the inclusive range of 2 to 5, print "not weird".</li>
                        <li>If n is even and in the inclusive range of 6 to 20, print "weird".</li>
                        <li>If n is even and greater than 20, print "not weird".</li> -->
                    </ul>
                    <h3>Input Format</h3>
                    <p><?php echo $input_format; ?></p>
                    <h3>Constraints</h3>
                    <p><?php echo $constraints; ?></p>
                            <h3>Output Format</h3>
                            <p><?php echo $output_format; ?></p>
                            <h3>Sample Input 0</h3>
                            <p><?php echo $sample_input_0; ?></p>
                            <h3>Sample Output 0</h3>
                            <p><?php echo $sample_output_0; ?></p>
                            <h3>Explanation</h3>
                            <p><?php echo $explanation; ?></p>
                </div>
                <div class="col-12 col-lg-7 col-md-7 col-sm-12 scrollable rgtscrollable">
                    <div class="row">
                        <div class="col-4 lang">
                            <h4>Language</h4>
                        </div>
                        <div class="col-4 langg">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>Python</option>
                                <option value="1">Java</option>
                                <option value="2">C</option>
                                <option value="3">C++</option>
                                <option value="3">Javascript</option>
                            </select>
                        </div>
                        <div class="col-4 time">
                            <h4><Time><?php echo $timing; ?>:00</Time></h4>
                        </div>
                    </div>
                   
                    <form method="post" action="">
                    <textarea class="tex-chat" rows="10" cols="50" id="python_code" name="python_code" placeholder="code here..."><?php echo isset($_POST['python_code']) ? htmlspecialchars($_POST['python_code']) : ''; ?></textarea>
                    <input type="hidden" id="code_output" name="code_output" value="<?php echo $result; ?>">
                    <div class="row">
                        <div class="col-3">
                            <button type="submit" class="btn-cod" name="run_code">Run Code</button>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn-cod" name="submit_code">Submit Code</button>
                        </div>
                    </div>
                </form>
                <h3 class="otupt">Output</h3>
                <textarea class="tex-chat" id="output" readonly><?php echo $result; ?></textarea>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>