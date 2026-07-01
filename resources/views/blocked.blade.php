<!DOCTYPE html>
<html>
<head>

<title>Blocked</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-6">

<div class="card shadow">

<div class="card-body text-center">

<h2 class="text-danger mb-4">
You are now blocked
</h2>

<h5 class="mb-3">
Remaining Time
</h5>

<h1 id="timer" class="text-primary"></h1>

<div id="message" class="mt-4"></div>

</div>

</div>

</div>

</div>

</div>

<script>

let seconds={{ $seconds }};

function timer(){

    if(seconds<=0){

        document.getElementById("timer").innerHTML="00:00";

        document.getElementById("message").innerHTML=
        "<div class='alert alert-success'><strong>Try to refresh the page.</strong></div>";

        return;
    }

    let minutes=Math.floor(seconds/60);

    let secs=seconds%60;

    document.getElementById("timer").innerHTML=
    String(minutes).padStart(2,'0')+":"+
    String(secs).padStart(2,'0');

    seconds--;

}

timer();

setInterval(timer,1000);

</script>

</body>
</html>