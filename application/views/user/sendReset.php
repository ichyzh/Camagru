
<div class="container">
    <div id="regModal" class="regForm" style="display: block">
        <div class="modal-content"">
        <div class="row mr-4">
            <div class="col-8 w3-animate-top" style="margin: auto;">
                <form class="resForm" method="post" id="reset" style="background-color: azure" onsubmit="return false;">
                    <div class="form-group row justify-content-center m-2" id="status"></div>
                    <div class="form-group row justify-content-center m-2">
                        <label class="col-sm-4 res-lable">New Password</label>
                        <div class="col-sm-5 text-left pl-0">
                            <input type="password" class="form-control f-con" id="pwdres" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center m-2">
                        <label class="col-sm-4 res-lable">Confirm Password</label>
                        <div class="col-sm-5 text-left pl-0 ">
                            <input type="password" class="form-control f-con" id="pwd2res" placeholder="Password">
                        </div>
                    </div>
                    <div class="text-center m-btn">
                        <button type="submit" class="btn btn-primary"  id="sbmreset" onclick="resetPwd();">Submit</button><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


<div class="footer reset-footer">This footer will always be positioned at the bottom of the page, but <strong>not fixed</strong>.</div>
<script type="text/javascript">

    var ROOT = location.pathname.split("/")[1];

    function resetPwd() {
        var pwd = document.getElementById('pwdres');
        var pwd2 = document.getElementById('pwd2res');
        var email = "<?php Print($_GET['email']) ?>";


        console.log("NU ZDAROVA");
        var xhr = new XMLHttpRequest();
        var url = 'http://localhost:8100/' + ROOT + '/resetpwd';
        var submit = document.getElementById('sbmreset');
        var vars = "submit="+submit.value+"&email="+email+"&pwd="+pwd.value+"&pwd2="+pwd2.value;
        xhr.open("POST", url, true);

        xhr.setRequestHeader("Content-type", 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText) {
                    var return_data = xhr.responseText;
                    console.log(return_data);
                    var result = JSON.parse(return_data);
                    if (result['ok'] !== undefined) {
                        document.getElementById("status").innerHTML = "NU ZDAROVA";
                        window.location.href = "http://localhost:8100/" + ROOT;
                    }
                }
            }
        };
        xhr.send(vars);

    }

</script>

</body>
</html>
