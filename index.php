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
    <style>
        a {
            text-decoration: none !important;
        }
        .algo-con{
            color: black !important; 
        }
     

.all-kit:hover{
    color: white; /* Change color to white on hover */
    /* background-color: blue; Optional: change background color */
}

    </style>

</head>

<body>

    <?php include('navbar.php'); ?>

    <section class="top-sec">
        <div class="container">
            <div class="row">
                <div class="program-head">
                    <h1 class="skil">Learn programming skills</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="preperation-sec">
        <div class="container">
            <div class="row">
                <h2 class="ur-pre">Your Preparation</h2>
                <div class="col-12 col-md-6 col-lg-6 col-sm-12">
                    <div class="basecard">
                        <h2 class="kit-prep">Prepare By Topic</h2>
                        <h1 class="inter-pre">Python</h1>
                        <div class="line"></div>
                        <p class="ready-for">86% (15 points to next star)</p>
                        <a class="all-kit" href="question.php?topic=Python">Continue Preparation</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-sm-12">
                    <div class="basecard">
                        <h2 class="kit-prep">Preparation kits</h2>
                        <h1 class="inter-pre">Interview Preparation Kit</h1>
                        <div class="line"></div>
                        <p class="ready-for">86% (15 points to next star)</p>
                        <a class="all-kit" href="">Continue Preparation</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="third-sec">
        <div class="container">
            <div class="row">
                <h2 class="by-topi">Prepare By Topics</h2>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Algorithms</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Data Structures</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Mathematics</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Artificial Intelligence</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">C</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">C++</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Java</h4>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <a href="question.php?topic=Python">
                        <h4 class="algo-con">Python</h4>
                    </a>
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-sm-6">
                    <h4 class="algo-con">Ruby</h4>
                </div>
            </div>
        </div>
    </section>

</body>

</html>