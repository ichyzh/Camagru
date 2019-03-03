<div class="container main ">
    <div class="row">
        <div class="col-8 photo_field">
            <div>
                <video id="video" width="640" height="480" autoplay></video>
                <div id="here" ></div>
            </div>
        </div>
        <div class="col-3 mask_field hide w3-animate-right text-center" id="car">
            <div class="arrow align-middle text-center">
                <span class="arrow-up"><i class="fas fa-angle-up"></i></span>
            </div>
            <div id="carous">
                <div class="item justify-content-center">
                    <img src="public/masks/likeaboss.png" alt="likeaboss">
                </div>
                <div class="item align-middle">
                    <img src="public/masks/42_Logo.png" alt="42_Logo">
                </div>
                <div class="item">
                    <img src="public/masks/doge.png" alt="doge">
                </div>
                <div class="item align-middle">
                    <img src="public/masks/logoUNIT.png" alt="logoUNIT">
                </div>
                <div class="item align-middle">
                    <img src="public/masks/wanted.png" alt="wanted">
                </div>
                <div class="item">
                    <img src="public/masks/chelsealogo.png" alt="chelsealogo">
                </div>
                <div class="item align-middle">
                    <img src="public/masks/unit-logo-white-vertical.png" alt="unit-logo-white-vertical">
                </div>
                <div class="item">
                    <img src="public/masks/pikachu.png" alt="pikachu">
                </div>
            </div>
            <div class="arrow align-middle text-center">
                <span class="arrow-down"><i class="fas fa-angle-down"></i></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-7 camera_buttons">
            <button id="save" class="hide"><i class="fas fa-save"><p>Save Photo</p></i></button>
            <button id="snap"><i class="fas fa-camera"><p>Snap Photo</p></i></button>
            <button id="new" class="hide"><i class="fas fa-redo-alt"><p>New Photo</p></i></button>
            <form>
                <input type="file" name="file" id="file" class="inputfile" />
                <label for="file" id="file_icon"><i class="fas fa-upload"><p>Upload Photo</p></i></label>
            </form>
        </div>
    </div>
</div>
<div class="container mt-4 hide" id="photos_field">
    <div class="col-12 text-center">
        <h1 >My photos</h1>
    </div>
    <hr>
    <div class="row mt-4">
        <div class="col-12" id="photos_prev">
            <div class="arrow hide" id="arrow-left">
                <span class="arrow-left"><i class="fas fa-angle-left"></i></span>
            </div>
            <div class="slides" id="list">

            </div>
            <div class="arrow hide" id="arrow-right">
                <span class="arrow-right"><i class="fas fa-angle-right"></i></i></span>
            </div>
        </div>
    </div>
</div>
<canvas id="canvas" width="640" height="480" style="display:none"></canvas>
<script src="public/js/camera.js"></script>
<link rel="stylesheet" href="public/css/camera.css">
