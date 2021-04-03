window.onload = function() {
    var i = 0;
    fsubmit = document.getElementById("UploadSubmit");
    op_form = document.getElementById("Upload_form");

    var details = {
        location: document.getElementById("file_location").value,
        fname: document.getElementById("fname").value
    }
    op_form.onsubmit = add_job(++i, details);

}

function add_job(i, details) {
    if (i != 0) {
        var id = "job" + i;
        var curent = new Date();
        var time = curent.toLocaleTimeString();

        var task_area = document.getElementById("task_area");
        task_area.innerHTML = task_area.innerHTML + "<div class = 'card card-body bg-light'> <div class='row'><div class='col'>" + details.fname + "</div><div class='col'>" + time + "</div></div></div></div><br>    ";
    }

}