<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../Images/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include('navbar.php'); ?>

    <section class="fir-sec">
        <div class="container">
            <div class="row">
                <h1 class="solving">Problem Solving</h1>
            </div>
        </div>
    </section>

    <section class="secon-sec">
        <div class="container">
            <div class="row">
                <h3 class="py">Python</h3>
                <?php
                include("../conn.php");
               
                $topic = $_GET['topic'];
                $sql = "SELECT * FROM coding_test WHERE topic = '$topic'";
                $result = $db_connect->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="quest-pro">
                            <h3 class="if-els"><?php echo htmlspecialchars($row['qst_overview']); ?></h3>
                            <p> <?php echo htmlspecialchars($row['topic']); ?> (<?php echo htmlspecialchars($row['level']); ?>), Max Score: 10, Success Rate: 89.23%</p>
                            <div class="row">
                                <div class="col-12 col-md-8 col-lg-8 col-sm-12">
                                    <p>Practicing makes <?php echo htmlspecialchars($row['qst_overview']); ?>.</p>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-sm-12">
                                    <a href="codecompailer.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                    <button class="chal">Solve Challenge</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No challenges found for the selected topic.";
                }

                $db_connect->close();
                ?>


            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>