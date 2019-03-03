<div class="footer reset-footer">This footer will always be positioned at the bottom of the page, but <strong>not fixed</strong>.</div>
<script type="text/javascript">

    var regModal = document.getElementById('regModal');
    var logForm = document.getElementById('logForm');
    var regForm = document.getElementById('regForm');
    var resForm = document.getElementById('resForm');
    var regbtn = document.getElementById('regbtn');
    var logbtn = document.getElementById('logbtn');
    var notReg = document.getElementById('notReg');
    var resbtn = document.getElementById('resPwd');

    var drop = document.getElementById('dropacc');
    var cont = document.getElementById('drop_cont');

    drop.onclick = function() {
        cont.style.display = "block";
    };

    //login
    logbtn.onclick = function(evt) {
        regModal.style.display = "block";
        logForm.classList.remove('hidden-form');
        regForm.classList.add('hidden-form');
        resForm.classList.add('hidden-form');
    };

    regbtn.onclick = function(evt) {

        regModal.style.display = "block";
        logForm.classList.add('hidden-form');
        resForm.classList.add('hidden-form');
        regForm.classList.remove('hidden-form');
    };

    notReg.onclick = function(evt) {
        regModal.style.display = "block";
        logForm.classList.add('hidden-form');
        resForm.classList.add('hidden-form');
        regForm.classList.remove('hidden-form');
    };

    resbtn.onclick = function(evt) {
        regModal.style.display = "block";
        logForm.classList.add('hidden-form');
        regForm.classList.add('hidden-form');
        resForm.classList.remove('hidden-form');
    };

    var x = document.getElementsByClassName("hide")[0];

    x.onclick = function() {
        regModal.style.display = "none";
    };

    // window.onclick = function(ev) {
    // 	if (ev.target === regModal) {
    // 			regModal.style.display = "none";
    // 	}
    // }

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

    // Go through all of the images with our custom class
    // for (var i = 0; i < images.length; i++) {
    // 	var img = images[i];
    // 	// and attach our click listener for this image.
    // 	img.onclick = function(evt) {
    // 	// console.log(evt);
    // 	modal.style.display = "block";
    // 	modalImg.src = this.src;
    // 	captionText.innerHTML = this.alt;
    // 	}
    // }

    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {

        if (event.target === modal) {
            modal.style.display = "none";
        }
        else if (event.target === regModal) {
            regModal.style.display = "none";
        }
        else if (event.target !== cont && event.target !== drop) {
            cont.style.display = "none";
        }
    };



    /************************************/
    /************************************/
    /****         SLIDESHOW     *********/
    /************************************/
    /************************************/
    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
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

        console.log("PRIVET");
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/camaphp/register';
        var submit = document.getElementById('sbmreg');
        var vars = "submit="+submit.value+"&login="+login.value+"&pwd="+pwd.value+"&pwd2="+pwd2.value+"&email="+email.value;
        xhr.open("POST", url, true);

        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    var return_data = xhr.responseText;
                     console.log(return_data);
                    var result = JSON.parse(return_data);
                    errors_parse(result);
                    console.log(result);

                    //TODO: Check and print errors of input data
                    if (result['login'] !== undefined)
                        document.getElementById("status").innerHTML = result['login'];
                }
            }
        };
        xhr.send(vars);
        document.getElementById("status").innerHTML = "PRIVET";
    }

    function errors_parse(result) {
        login.classList.remove("is-invalid");
        pwd2.classList.remove("is-invalid");
        pwd.classList.remove("is-invalid");
        email.classList.remove("is-invalid");
        if (result['email'] !== undefined) {
            console.log("loh");
            email.classList.add("is-invalid");
            document.getElementById("status").innerHTML = result['email'];
        }
        if (result['d-email'] !== undefined) {
            email.classList.add("is-invalid");
            document.getElementById("status").innerHTML = result['d_email'];
        }
        if (result['login'] !== undefined){
            login.classList.add("is-invalid");
            document.getElementById("status").innerHTML = result['login'];
        }
        if (result['d-login'] !== undefined) {
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

        console.log("KUKUSIKI");
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/camaphp/login';
        var submit = document.getElementById('sbml');
        var vars = "submit="+submit.value+"&login="+loginl.value+"&pwd="+pwdl.value;
        xhr.open("POST", url, true);

        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    var return_data = xhr.responseText;
                    console.log(return_data);
                    var result = JSON.parse(return_data);
                     if (result["login"] === undefined && result["pwd"] === undefined)
                         location.reload();
                        //TODO: Check and print errors of input data
                     else
                         check_errors(result);
                }
                // else
                //     console.log("5555");
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
        if (result['pwd'] !== undefined){
            pwdl.classList.add("is-invalid");
            document.getElementById("statuslog").innerHTML = result['pwd'];
        }
    }

    /************************************/
    /************************************/
    /****        AJAX RESET     *********/
    /************************************/
    /************************************/

    var reset = document.getElementById('email-res');

    function ajax_reset() {
        console.log("NU ZDAROVA");
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/camaphp/reset';
        var submit = document.getElementById('sbmres');
        var vars = "submit="+submit.value+"&email="+reset.value;
        xhr.open("POST", url, true);

        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    var return_data = xhr.responseText;
                    console.log(return_data);
                    var result = JSON.parse(return_data);
                    if (result["email"] === undefined)
                        console.log("OTLICHNO");
                    //TODO: Check and print errors of input data
                    else
                        console.log("NE OTLICHNO");
                }
                // else
                //     console.log("5555");
            }
        };
        xhr.send(vars);
        document.getElementById("statusres").innerHTML = "NU ZDAROVA";

    }

</script>

</body>
</html>