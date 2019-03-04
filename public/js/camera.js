// Grab elements, create settings, etc.
var video = document.getElementById('video');

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    });
}

//  Legacy code below: getUserMedia
// else if(navigator.getUserMedia) { // Standard
//     navigator.getUserMedia({ video: true }, function(stream) {
//         video.src = stream;
//         video.play();
//     }, errBack);
// } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
//     navigator.webkitGetUserMedia({ video: true }, function(stream){
//         video.src = window.webkitURL.createObjectURL(stream);
//         video.play();
//     }, errBack);
// } else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
//     navigator.mozGetUserMedia({ video: true }, function(stream){
//         video.srcObject = stream;
//         video.play();
//     }, errBack);
// }


// Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var here = document.getElementById("here");
var snap = document.getElementById("snap");
var save_photo = document.getElementById("save");
var upload_photo = document.getElementById("file_icon");
var new_photo = document.getElementById("new");
var file_photo = document.getElementById("file");
var carous = document.getElementById("car");
var photos_field = document.getElementById("photos_field");

new_photo.addEventListener("click", function () {
    while( here.hasChildNodes() ){
        here.removeChild(here.lastChild);
    }
    video.classList.remove("hide");
    upload_photo.classList.remove("hide");
    snap.classList.remove("hide");
    save_photo.classList.add("hide");
    this.classList.add("hide");
    carous.classList.add("hide");
});

file_photo.onchange = function (evt) {
    upload_photo.classList.add("hide");
    snap.classList.add("hide");
    new_photo.classList.remove("hide");
    save_photo.classList.remove("hide");
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            var data = fr.result.split(':');
            var res = data[1].split(';');
            var type = res[0].split('/');
            console.log(type[0]);
            if (type[0] === "image") {
                carous.classList.remove("hide");
                var elem = document.createElement('img');
                elem.src = fr.result;
                elem.classList.add("back");
                here.appendChild(elem);
                video.classList.add("hide");
            }
            else {
                alert("Please select a valid image");
                upload_photo.classList.remove("hide");
                snap.classList.remove("hide");
                new_photo.classList.add("hide");
                save_photo.classList.add("hide");
            }
        };
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
};

snap.addEventListener("click", function() {
    carous.classList.remove("hide");
    while( here.hasChildNodes() ){
        here.removeChild(here.lastChild);
    }
    context.drawImage(video, 0, 0, 640, 480);
    var nUrl = canvas.toDataURL('image/png');
    var elem = document.createElement('img');
    elem.src = nUrl;
    elem.classList.add("back");
    here.appendChild(elem);
    video.classList.add("hide");
    snap.classList.add("hide");
    upload_photo.classList.add("hide");
    new_photo.classList.remove("hide");
    save_photo.classList.remove("hide");
});
save_photo.addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    var url = 'http://localhost:8100/camaphp/add_watermark';
    var data_photos = {};
    data_photos.main_photo = document.getElementsByClassName("back")[0].src;
    var watermark = document.getElementsByClassName("over");
    data_photos.watermark = [];
    for(var i = 0; i < watermark.length; i++) {
        data_photos.watermark[i] = {
            "src": watermark[i].src,
            "left": watermark[i].offsetLeft,
            "top": watermark[i].offsetTop
        };
    }
    var vars = "data="+JSON.stringify(data_photos);
    xhr.open("POST", url, true);

    xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText) {
                console.log(xhr.responseText);
                var return_data = xhr.responseText;
                var result = JSON.parse(return_data);
                show_user_photos(result.path);
                //TODO: Check and print errors of input data
            }
            else
                console.log("5555");
        }
    };
    xhr.send(vars);
});

function show_user_photos(path) {
    photos_field.classList.remove("hide");
    var list = document.getElementById("list");
    var fd = document.createElement("div");
    var img = document.createElement("img");
    var sd = document.createElement("div");
    var num = document.querySelectorAll(".usrphoto");
    fd.classList.add("usrphoto");
    sd.classList.add("usr-border");
    img.classList.add("myImages");
    img.src = path;
    sd.appendChild(img);
    fd.appendChild(sd);
    list.appendChild(fd);
    show_photo();
    hide_photo();
    if (num.length >= 3) {
        document.getElementById("arrow-left").classList.remove("hide");
        document.getElementById("arrow-right").classList.remove("hide");
    }


}
//____________________________________________________

// ___________________________________________________

/************************************/
/************************************/
/**********   Slideshow  ************/
/************************************/
/************************************/

var up = document.querySelector('.arrow-up');
var down = document.querySelector('.arrow-down');
var car = document.querySelector("#carous");
var items = document.querySelectorAll(".item");
var i = 0;

show(i);
up.addEventListener("click", function() {
    car.insertBefore(car.lastElementChild, car.firstElementChild);
    hide();
    show(i);
});

down.addEventListener("click", function() {
    car.appendChild(car.firstElementChild);
    hide();
    show(i);
});

function show(i) {
    let items = car.querySelectorAll(".item");
    i = 0;
    if (i >= items.length || i < 0)
        i = 0;
    for (var count = 0; count < 3; count++) {
        items[i].style.display = "block";
        i++;
    }
}

function hide() {
    let i = 3;
    let items = car.querySelectorAll(".item");
    if (i < 0 || i >= items.length) {
        i = 0;
    }
    for (var count = 0; count < 5; count++) {
        items[i].style.display = "none";
        i++;
    }
}

// add mask on photo

items.forEach(function(e) {
    e.onclick = function() {
        var elem = document.createElement('img');
        elem.classList.add("over");
        elem.src = this.firstElementChild.src;
        elem.onclick = move(elem);
        here.appendChild(elem);
        save_photo.classList.remove("hide");
    };
});

function move(elem) {
    var offset = [0,0];
    var isDown = false;
    elem.addEventListener('mousedown', function(e) {
        isDown = true;
        offset = [
            elem.offsetLeft - e.clientX,
            elem.offsetTop - e.clientY
        ];
    }, true);
    here.addEventListener('mouseup', function() {
        isDown = false;
    }, true);

    here.addEventListener('mousemove', function(e) {
        event.preventDefault();
        if (isDown) {
            elem.style.left = (e.clientX + offset[0]) + 'px';
            elem.style.top  = (e.clientY + offset[1]) + 'px';
        }
    }, true);
};

// _________________________________________

/************************************/
/************************************/
/**********   Photo slideshow  ******/
/************************************/
/************************************/

var left = document.querySelector('.arrow-left');
var right = document.querySelector('.arrow-right');
var list = document.getElementById("list");

left.addEventListener("click", function() {
    list.insertBefore(list.lastElementChild, list.firstElementChild);
    show_photo();
    hide_photo();
});

right.addEventListener("click", function() {
    list.appendChild(list.firstElementChild);
    show_photo();
    hide_photo();
});

function show_photo() {
    let items = list.querySelectorAll(".usrphoto");
    i = 0;
    for (var count = 0; count < items.length; count++) {
        items[i].style.display = "block";
        i++;
    }
}

function hide_photo() {
    let i = 3;
    let items = list.querySelectorAll(".usrphoto");
    if (i < 0 || i >= items.length) {
        i = 0;
    }
    for (var count = 0; count < (items.length - 3); count++) {
        items[i].style.display = "none";
        i++;
    }
}

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

window.onclick = function(event) {

    var cont = document.getElementById('drop_cont');

    if (event.target !== document.getElementById("dropacc")) {
        if (cont) {
            cont.classList.add("hidden");
        }
    }
};


