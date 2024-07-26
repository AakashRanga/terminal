<?php
include ("../conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $python_code = $_POST['python_code'];
    $code_output = $_POST['code_output'];
    $course_id = $_POST['course_id'];
    $topic = $_POST['topic'];
    $result = "";

    if (isset($_POST['submit_code'])) {
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

        echo $result;
    }
}
?>
