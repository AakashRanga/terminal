<?php
include ("../conn.php");
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

<?php $result = ""; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="../Images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('#output').val().trim() !== '') {
                $('.rgtscrollable').animate({
                    scrollTop: $('.rgtscrollable')[0].scrollHeight
                }, 1000);
            }

            $('#run_code').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'code/python.php',
                    type: 'POST',
                    data: {
                        python_code: $('#python_code').val(),
                        run_code: true
                    },
                    success: function (data) {
                        $('#output').val(data);
                    }
                });
            });

            $('#submit_code').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'submit_code.php',
                    type: 'POST',
                    data: {
                        python_code: $('#python_code').val(),
                        code_output: $('#output').val(),
                        course_id: '<?php echo $course_id; ?>',
                        topic: '<?php echo $topic; ?>',
                        submit_code: true
                    },
                    success: function (data) {
                        alert(data);
                    }
                });
            });
        });
    </script>

</head>

<body>

    <?php include ('navbar.php'); ?>

    <section class="main-secc">
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-lg-5 col-md-5 col-sm-12 scrollable">
                    <h4>Task</h4>
                    <p><?php echo $qst_overview; ?></p>
                    <ul>
                        <li><?php echo $task; ?></li>
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

                    <form id="code_form" method="post">
                        <textarea class="tex-chat" rows="10" cols="50" id="python_code" name="python_code"
                            placeholder="code here..."><?php echo isset($_POST['python_code']) ? htmlspecialchars($_POST['python_code']) : ''; ?></textarea>
                        <input type="hidden" id="code_output" name="code_output" value="<?php echo $result; ?>">
                        <div class="row">
                            <div class="col-3">
                                <button type="submit" class="btn-cod" id="run_code" name="run_code">Run Code</button>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn-cod" id="submit_code" name="submit_code">Submit
                                    Code</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>