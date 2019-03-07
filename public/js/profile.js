var ROOT = location.pathname.split("/")[1];

var regModal = document.getElementById('regModal');
var logForm = document.getElementById('logForm');
var regForm = document.getElementById('regForm');
var resForm = document.getElementById('resForm');
var regbtn = document.getElementById('regbtn');
var logbtn = document.getElementById('logbtn');
var notReg = document.getElementById('notReg');
var resbtn = document.getElementById('resPwd');

var cont = document.getElementById('drop_cont');

function drop() {
    console.log(111);
    var cont = document.getElementById('drop_cont');
    if (cont.classList.contains("hidden")) {
        cont.classList.remove("hidden");
    }
    else {
        cont.classList.add("hidden");
    }
}

//________images_________________________//
// create references to the modal...
var modal = document.getElementById('myModal');
// to all images -- note I'm using a class!
var images = document.getElementsByClassName('myImages');
// the image in the modal
var modalImg = document.getElementById("img01");
// and the caption in the modal
var captionText = document.getElementById("caption");

function openModal() {
    document.getElementById('myModal').style.display = "block";
}

function span() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    var cont = document.getElementById('drop_cont');

    if (event.target === modal) {
        modal.style.display = "none";
    }
    else if (event.target === regModal) {
        regModal.style.display = "none";
    }
    else if (event.target !== document.getElementById("dropacc")) {
        if (cont) {
            cont.classList.add("hidden");
        }
    }
};



/************************************/
/************************************/
/****         SLIDESHOW     *********/
/************************************/
/************************************/

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    console.log(n);
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
}

/************************************/
/************************************/
/**********      Like     ***********/
/************************************/
/************************************/
var like = document.querySelectorAll("#like");
like.forEach(function(e) {
    e.onclick = function() {
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/like';
        var photo_id = e.value;
        var vars = "photo_id=" + photo_id;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    console.dir(e.children[0].children[0]);
                    if (e.classList.contains("liked")) {
                        e.classList.remove("liked");
                        if ((parseInt(e.children[0].innerText) - 1) === 0) {
                            e.children[0].children[0].innerText = "";
                        }
                    }
                    else {
                        e.classList.add("liked");
                        if (e.children[0].children[0].innerText === "") {
                            e.children[0].children[0].innerHTML = 1;
                        }
                        else {
                            e.children[0].children[0].innerHTML = parseInt(e.children[0].innerText) + 1;
                        }
                    }
                    console.dir(e.children[0]);
                }
                else
                    console.log("7777777");
            }
        };
        xhr.send(vars);
    };
});

/************************************/
/************************************/
/**********   Add Comment  **********/
/************************************/
/************************************/

var comment_text = document.querySelectorAll(".comment_field");
var send_btn = document.querySelectorAll(".send_comment");

send_btn.forEach(function(e) {
    e.onclick = function() {
        var photo_id = e.value;
        var n = find_text(photo_id);
        var comment = comment_text[n].value;
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/comment';
        var vars = "photo_id=" + photo_id + "&comment=" + comment;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    comment_text[n].value = "";
                    var result = JSON.parse(xhr.responseText);
                    if (result.error === undefined) {
                        addComment(result, photo_id);
                    }
                }
                else
                    console.log("7777777");
            }
        };
        xhr.send(vars);
    };
});

function find_text(id) {
    for (var i = 0; i < comment_text.length; i++) {
        if (comment_text[i].name === id) {
            return i;
        }
    }
    return null;
}

function addComment(result, photo_id) {
    var login = result.login;
    var comment = result.text;
    var img = "/" + result.root + result.usr_img;

    var field_to_add = document.getElementById("comments" + photo_id);
    var main_div = document.createElement("div");
    var first_child = document.createElement("div");
    var first_child_1 = document.createElement("div");
    var first_child_1_1 = document.createElement("a");
    var first_child_1_1_1 = document.createElement("div");
    var hr = document.createElement("hr");
    main_div.classList.add("row", "commentf");
    first_child.classList.add("row", "m-0", "marpic");
    first_child_1.classList.add("col-2");
    first_child_1_1.title = "username";
    first_child_1_1.href = "http://localhost:8100/" + result.root + login;
    first_child_1_1_1.classList.add("mask-com");
    first_child_1_1_1.style.backgroundImage = 'url(' + img + ')';
    var second_child = document.createElement("div");
    var second_child_1 = document.createElement("a");
    var second_child_2 = document.createElement("p");
    second_child.classList.add("col-10", "pl-0");
    second_child_1.href = "http://localhost:8100/" + result.root + login;
    second_child_1.innerHTML = login;
    second_child_1.style.color = "#00cc00";
    second_child_2.innerHTML = comment;
    second_child_2.classList.add("comtext");
    first_child_1_1.appendChild(first_child_1_1_1);
    first_child_1.appendChild(first_child_1_1);
    first_child.appendChild(first_child_1);
    second_child.appendChild(second_child_1);
    second_child.appendChild(second_child_2);
    main_div.appendChild(first_child);
    main_div.appendChild(second_child);
    field_to_add.appendChild(main_div);
    field_to_add.appendChild(hr);
}

/************************************/
/************************************/
/**********   Buttons  **************/
/************************************/
/************************************/

var form_login = document.getElementById("form-login-change");
var form_pw = document.getElementById("form-pw-change");
var form_email = document.getElementById("form-email-change");
var delete_photo = document.querySelectorAll(".delete_photo");


function change_login () {
    if (form_login.classList.contains("hidden")) {
        form_login.classList.remove("hidden");
    }
    else {
        form_login.classList.add("hidden");
    }
}

function change_email () {
    if (form_email.classList.contains("hidden")) {
        form_email.classList.remove("hidden");
    }
    else {
        form_email.classList.add("hidden");
    }
}

function change_pwd () {
    if (form_pw.classList.contains("hidden")) {
        form_pw.classList.remove("hidden");
    }
    else {
        form_pw.classList.add("hidden");
    }
}

function send_login () {
    var new_login = form_login.children[0].value;
    if (new_login !== "") {
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/change_login';
        var vars = "new_login=" + new_login + "&submit=OK";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.href = "http://localhost:8100/" + ROOT;
                if (xhr.responseText) {
                    var result = JSON.parse(xhr.responseText);
                }
            }
        };
        xhr.send(vars);
    }
}

function send_pwd () {
    var oldpw = form_pw.children[0].value;
    var newpw = form_pw.children[1].value;
    var reppw = form_pw.children[2].value;
    if (oldpw !== "" && newpw !== "" && reppw !== "") {
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/change_pwd';
        var vars = "old_pw=" + oldpw + "&new_pw=" + newpw + "&rep_pw=" + reppw + "&submit=OK";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.reload(false);
                if (xhr.responseText) {
                    var result = JSON.parse(xhr.responseText);
                }
            }
        };
        xhr.send(vars);
    }
}

function send_email () {
    var new_email = form_email.children[0].value;
    if (new_email !== "") {
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/change_email';
        var vars = "new_email=" + new_email + "&submit=OK";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.reload(false);
                if (xhr.responseText) {
                    var result = JSON.parse(xhr.responseText);
                }
            }
        };
        xhr.send(vars);
    }
}

function delete_acc(e) {
    var result = confirm("Are you sure?");
    if (result) {
        var id = e.title;
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/delete_acc';
        var vars = "submit=OK" + "&id=" + id;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    console.log(xhr.responseText);
                    var result = JSON.parse(xhr.responseText);
                    if (result.resp) {
                        window.location.href = result.resp;
                    }
                }
            }
        };
        xhr.send(vars);
    }
}

function disable_notif() {
    var xhr = new XMLHttpRequest();
    var url = 'http://localhost:8100/' + ROOT + '/disable_notification';
    var vars = "submit=OK";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText) {
                var result = JSON.parse(xhr.responseText);
            }
        }
    };
    xhr.send(vars);
}

delete_photo.forEach(function (e) {
   e.onclick = function () {
       var result = confirm("Are you sure?");
       if (result) {
           var photo_id = e.id;
           var xhr = new XMLHttpRequest();
           var url = 'http://localhost:8100/' + ROOT + '/delete_photo';
           var vars = "submit=OK" + "&phid=" + photo_id;
           xhr.open("POST", url, true);
           xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

           xhr.onreadystatechange = function () {
               if (xhr.readyState === 4 && xhr.status === 200) {
                   if (xhr.responseText) {
                       window.location.reload(false);
                   }
               }
           };
           xhr.send(vars);
       }
   };
});

function change_picture(e) {
    var id = e.id;
            var photo_id = e.id;
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/change_picture';
        var vars = "submit=OK" + "&phid=" + id;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                window.location.reload(false);
                if (xhr.responseText) {
                    var result = JSON.parse(xhr.responseText);
                }
            }
        };
        xhr.send(vars);
}

