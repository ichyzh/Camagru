var ROOT = location.pathname.split("/")[1];

var regModal = document.getElementById('regModal');
var logForm = document.getElementById('logForm');
var regForm = document.getElementById('regForm');
var resForm = document.getElementById('resForm');
var notReg = document.getElementById('notReg');
var resbtn = document.getElementById('resPwd');

function drop(e) {
    var cont = document.getElementById('drop_cont');
    if (cont.classList.contains("hidden")) {
        cont.classList.remove("hidden");
    }
    else {
        cont.classList.add("hidden");
    }
}

function logining() {
    regModal.style.display = "block";
    logForm.classList.remove('hidden-form');
    regForm.classList.add('hidden-form');
    resForm.classList.add('hidden-form');
}

function registration() {

    regModal.style.display = "block";
    logForm.classList.add('hidden-form');
    resForm.classList.add('hidden-form');
    regForm.classList.remove('hidden-form');
}

notReg.onclick = function() {
    regModal.style.display = "block";
    logForm.classList.add('hidden-form');
    resForm.classList.add('hidden-form');
    regForm.classList.remove('hidden-form');
};

resbtn.onclick = function() {
    regModal.style.display = "block";
    logForm.classList.add('hidden-form');
    regForm.classList.add('hidden-form');
    resForm.classList.remove('hidden-form');
};

var x = document.getElementsByClassName("hide")[0];

x.onclick = function() {
    regModal.style.display = "none";
};

var modal = document.getElementById('myModal');

function openModal() {
    document.getElementById('myModal').style.display = "block";
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
    modal.style.display = "none";
};

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

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
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
/****   AJAX REGISTRATION   *********/
/************************************/
/************************************/

var login = document.getElementById('loginr');
var pwd = document.getElementById('pwdr');
var pwd2 = document.getElementById('pwd2r');
var email = document.getElementById('email');

function ajax_reg(){

    var xhr = new XMLHttpRequest();
    var url = 'http://localhost:8100/' + ROOT + '/register';
    var submit = document.getElementById('sbmreg');
    var vars = "submit="+submit.value+"&login="+login.value+"&pwd="+pwd.value+"&pwd2="+pwd2.value+"&email="+email.value;
    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText) {
                var return_data = xhr.responseText;
                var result = JSON.parse(return_data);
                errors_parse(result);
            }
            else {
                location.reload();
            }
        }
    };
    xhr.send(vars);
}

function errors_parse(result) {
    login.classList.remove("is-invalid");
    pwd2.classList.remove("is-invalid");
    pwd.classList.remove("is-invalid");
    email.classList.remove("is-invalid");
    if (result['email'] !== undefined) {
        email.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['email'];
    }
    if (result['d_email'] !== undefined) {
        email.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['d_email'];
    }
    if (result['login'] !== undefined){
        login.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['login'];
    }
    if (result['d_login'] !== undefined) {
        login.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['d_login'];
    }
    if (result['pwd'] !== undefined){
        pwd2.classList.add("is-invalid");
        pwd.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['pwd'];
    }
    if (result['pwd2'] !== undefined) {
        pwd2.classList.add("is-invalid");
        pwd.classList.add("is-invalid");
        document.getElementById("status").innerHTML = result['pwd2'];
    }
}

/************************************/
/************************************/
/****        AJAX LOGIN     *********/
/************************************/
/************************************/


var loginl = document.getElementById('login');
var pwdl = document.getElementById('pwd');
function ajax_log(){

    var xhr = new XMLHttpRequest();
    var url = 'http://localhost:8100/' + ROOT + '/login';
    var submit = document.getElementById('sbml');
    var vars = "submit="+submit.value+"&login="+loginl.value+"&pwd="+pwdl.value;
    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText) {
                var return_data = xhr.responseText;
                var result = JSON.parse(return_data);
                if (result["login"] === undefined && result["all"] === undefined)
                    location.reload();
                else
                    check_errors(result);
            }
        }
    };
    xhr.send(vars);
    document.getElementById("statuslog").innerHTML = "KUKUSIKI";
}

function check_errors(result) {
    loginl.classList.remove("is-invalid");
    pwdl.classList.remove("is-invalid");
    if (result['login'] !== undefined){
        loginl.classList.add("is-invalid");
        document.getElementById("statuslog").innerHTML = result['login'];
    }
    if (result['all'] !== undefined){
        loginl.classList.add("is-invalid");
        pwdl.classList.add("is-invalid");
        document.getElementById("statuslog").innerHTML = result['all'];
    }
}

/************************************/
/************************************/
/****        AJAX RESET     *********/
/************************************/
/************************************/

var reset = document.getElementById('email-res');

function ajax_reset() {
    var xhr = new XMLHttpRequest();
    var url = 'http://localhost:8100/' + ROOT + '/reset';
    var submit = document.getElementById('sbmres');
    var vars = "submit="+submit.value+"&email="+reset.value;
    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText) {
                var return_data = xhr.responseText;
                var result = JSON.parse(return_data);
            }
        }
    };
    xhr.send(vars);

}

function fbOauth()
{
    var fwind = window.open("https://www.facebook.com/v3.2/dialog/oauth?client_id=" + FBID + "&display=popup&redirect_uri=http://localhost:8100/" + ROOT + "/fboauth&state={st=log,pr=pas345}&response_type=code&scope=email", '_blank', 'width=650,height=600,left=200,top=100, toolbar=1,resizable=0');
    var code = fwind.location.href;
    var rel = setInterval(function () {
        if (fwind.closed) {
            var xhr = new XMLHttpRequest();
            var url = 'http://localhost:8100/' + ROOT + '/fboauth';
            var vars = "code=" + code.value + "&submit=ok";
            xhr.open("POST", url, true);

            xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (this.responseText) {
                        var return_data = xhr.responseText;
                        var result = JSON.parse(return_data);
                    }
                }
            };
            xhr.send(vars);
            window.location.reload();
        }
    }, 1000);
}


function glOauth()
{
    var gwind = window.open("https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me&redirect_uri=http://localhost:8100/" + ROOT + "/googleoauth&response_type=code&client_id=" + GOOGLEID + "&access_type=online", '_blank', 'width=650,height=600,left=200,top=100, toolbar=1,resizable=0');
    var code = gwind.location.href;
    var rel = setInterval(function() {
        if (gwind.closed) {
            var xhr = new XMLHttpRequest();
            var url = 'http://localhost:8100/' + ROOT + '/googleoauth';
            var vars = "code=" + code.value + "&submit=ok";
            xhr.open("POST", url, true);

            xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText) {
                        var return_data = xhr.responseText;
                        var result = JSON.parse(return_data);
                    }
                }
            };
            xhr.send(vars);
            window.location.reload();
        }
    }, 1000);
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
                    if (document.cookie.indexOf('id') === -1 ) {
                        return ;
                    }
                    if (e.classList.contains("liked")) {
                        e.classList.remove("liked");
                        if ((parseInt(e.children[0].innerText) - 1) === 0) {
                            e.children[0].children[0].innerText = "";
                        }
                        else {
                            e.children[0].children[0].innerHTML = parseInt(e.children[0].innerText) - 1;
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
                }
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
    var img = result.usr_img;

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
    first_child_1_1.href = "http://localhost:8100/" +  + result.root + login;
    first_child_1_1_1.classList.add("mask-com");
    first_child_1_1_1.style.backgroundImage = 'url(' + img + ')';
    var second_child = document.createElement("div");
    var second_child_1 = document.createElement("a");
    var second_child_2 = document.createElement("p");
    second_child.classList.add("col-8", "col-md-10", "pl-0");
    second_child_1.href = "http://localhost:8100/" +  + result.root + login;
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
