<div class="container" style="margin-top: 8rem">
    <div class="row text-center">
        <?php $i = 0; ?>
        <?php foreach ($vars as $key => $val): ?>
        <?php $i++; ?>
        <div class="col-lg-4 col-md-6 pb-2 usrphoto" >
            <div class="row usrblock" style="background-color: white">
                <div class="col-5 user-field">
                    <a class="color-link" href="http://localhost:8100/<?php echo ROOT . "/profile/" . $val['login'] ?>">
                        <div class="usrimg" style="background-image: url(<?php echo $val['usr_img'] ?>);">
                        </div>
                        <p class="usrname"><?php echo $val['login'] ?></p>
                    </a>
                </div>
            </div>
            <div class="usr-border">
                <img src=<?php echo $val['src'] ?> class="w-100 myImages" onclick="openModal();currentSlide(<?php echo $i ?>)" id="myImg" alt=<?php $val['phid'] ?>>
                <div class="row pad-ico" style="border-radius: 5px">
                    <div class="col-9 p-0 text-right">
                        <?php if ($val['liked']): ?>
                            <?php echo "<button class='btn like liked' id='like' value=" . $val['phid'] . "><i class='far fa-heart io_size pr-1' ><p class='num_likes' style='font-size: 1rem'>" . $val['likes_count'] . "</p></i></button>" ?>
                        <?php else: ?>
                            <?php echo "<button class='btn like' id='like' value=" . $val['phid'] . "><i class='far fa-heart io_size pr-1' ><p class='num_likes'>" . $val['likes_count'] . "</p></i></button>" ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-2 p-0 text-right pr-2 ml-3">
                        <?php echo "<button class=\"btn like\"><span style=\"font-size: 0.8rem\" onclick=\"openModal();currentSlide($i)\"><i class=\"far fa-comment-alt io_size pr-1 pl-0\"></i>" . $val['comments_count'] . "</span></button>" ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if($pag['number_of_pages'] > 0): ?>
        <div class="row pagin">
            <nav aria-label="..." class="m-auto">
                <ul class="pagination pagination-lg">
                    <?php for($i = 0; $i < $pag['number_of_pages']; $i++): ?>
                        <li class="page-item">
                            <a class="page-link pag-link" href="/<?php echo ROOT ?>?page=<?php echo $i+1 ?>" tabindex="-1"><?php echo $i+1 ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
        <!--reg-->
        <div id="regModal" class="regForm">
            <div class="modal-content"">
            <div class="row mr-4" style="background-color: azure">
                <span class="hide">&times;</span>
                <div class="col-4 social text-center" style="background-color: azure; height: 394px">
                    <span>Login with social profiles</span>
                    <div class="row soc-row">
                        <div class="col-12 auth-btn">
                            <button type="submit" class="btn soc-btn" style="background-color: #405de6; color: white" onclick="fbOauth();"><i class="fab fa-facebook soc-icon"></i><span style="padding-left: 1rem">Submit</span></button>
                        </div>
                        <div class="col-12 auth-btn">
                            <button type="submit" class="btn btn-danger soc-btn" onclick="glOauth();"><i class="fab fa-google soc-icon"></i><span style="padding-left: 1rem">Submit</span></button>
                        </div>
                    </div>
                </div>
                <div class="col-8 w3-animate-right text-center" id="regForm">
                    <span>Registration</span>
                    <form class="regForm-content" method="post" id="register" onsubmit="return false;">
                        <div class="form-group row justify-content-center m-2" id="status"></div>
                        <div class="form-group row justify-content-center m-2">
                            <label class="col-sm-3 mr-4 mb-0 pt-1">Email</label>
                            <div class="col-sm-8 text-left">
                                <input type="email" class="form-control f-con" id="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center m-2">
                            <label class="col-sm-3 mr-4 mb-0 pt-1">Username</label>
                            <div class="col-sm-8 text-left">
                                <input type="text" class="form-control f-con" id="loginr" placeholder="Login">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center m-2">
                            <label class="col-sm-3 mr-4 mb-0 pt-1">Password</label>
                            <div class="col-sm-8 text-left">
                                <input type="password" class="form-control f-con" id="pwdr" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center m-2">
                            <label class="col-sm-3 mr-4 mb-0 pt-1">Password</label>
                            <div class="col-sm-8 text-left">
                                <input type="password" class="form-control f-con" id="pwd2r" placeholder="Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="ajax_reg()" id="sbmreg">Submit</button><br>
                    </form>
                </div>
                <div class="col-8 text-center" id="logForm">
                <span>Login</span>
                <form class="regForm-content" method="post" id="logining" onsubmit="return false;" >
                    <div class="form-group row justify-content-center m-2" id="statuslog"></div>
                    <div class="form-group row justify-content-center m-2">
                        <label class="col-sm-3 mr-4 mb-0 pt-1">Username</label>
                        <div class="col-sm-8 text-left">
                            <input type="text" class="form-control f-con" id="login" placeholder="Login">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center m-2">
                        <label class="col-sm-3 mr-4 mb-0 pt-1">Password</label>
                        <div class="col-sm-8 text-left">
                            <input type="password" class="form-control f-con" id="pwd" placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn m-2 bt-hov" onclick="ajax_log()" id="sbml">Submit</button><br>
                    <p class="nav-link" id="notReg" >Not registered yet?</p>
                    <p class="nav-link" id="resPwd">Forgot password?</p>
                </form>
            </div>
            <div class="col-8 w3-animate-right text-center" id="resForm">
                <span>Forgot password</span>
                <form class="regForm-content" method="post" id="reset" onsubmit="return false;">
                    <div class="form-group row justify-content-center m-2" id="statusres"></div>
                    <div class="form-group row justify-content-center m-2">
                        <label class="col-sm-3 mr-4 mb-0 pt-1">Username</label>
                        <div class="col-sm-8 text-left">
                            <input type="email" class="form-control f-con" id="email-res" placeholder="E-mail">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary m-2" onclick="ajax_reset()" id="sbmres">Send reset link</button><br>
                </form>
            </div>
        </div>
        </div>
    </div>
<!--reg-->

<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="row justify-content-center">
            <span class="close">&times;</span>
            <?php foreach ($vars as $key => $val): ?>
            <div class="mySlides" >
                <div class="col-9 img_p">
                    <img class="w-100 mainp" src=<?php echo $val['src'] ?> id="img01" alt=<?php echo $val['phid'] ?>>
                </div>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <div class="col-9 bod">
                    <div id="caption">
                        <div class="row border-bottom usrcap">
                            <div class="col-7 col-md-5">
                                <a class="color-link" href="http://localhost:8100/<?php echo ROOT . "/profile/" . $val['login'] ?>" title="username">
                                    <div class="mask" style="background-image: url(<?php echo $val['usr_img'] ?>);">
                                    </div>
                                    <p class="usrlog w-100"><?php echo $val['login'] ?></p>
                                </a>
                            </div>
                            <div class="col-5 col-md-7" id="under_buttons">
                                <div class="row float-right">
                                    <?php if ($val['liked']): ?>
                                    <?php echo "<div class=\"col-5 text-right\">" ?>
                                        <?php echo "<button class='btn like liked' id='like' value=" . $val['phid'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                    <?php echo "</div>" ?>
                                    <?php else: ?>
                                        <?php echo "<div class=\"col-5 text-right\">" ?>
                                        <?php echo "<button class='btn like' id='like' value=" . $val['phid'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                        <?php echo "</div>" ?>
                                    <?php endif; ?>
                                    <div class="col-5 text-right">
                                        <button class="btn like"><span style="font-size: 1rem"><i class="far fa-comment-alt io_size" style="font-size: 2rem"></i><?php echo $val['comments_count'] ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="comments<?php echo $val['phid'] ?>">
                    <?php if(isset($val['comments'])): ?>
                    <?php foreach ($val['comments'] as $com): ?>
                    <div class="row commentf">
                        <div class="row m-0 marpic">
                            <div class="col-2">
                                <a href="http://localhost:8100/<?php echo ROOT . "/profile/" . $com['usr_login'] ?>" title="username">
                                    <div class="mask-com" style="background-image: url(<?php echo $com['usr_img'] ?>)";>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-8 col-md-10 pl-0">
                            <a href="http://localhost:8100/<?php echo ROOT . "/" . $com['usr_login'] ?>" class="color-link"><?php echo $com['usr_login'] ?></a>
                            <p class="comtext"><?php echo $com['text'] ?></p>
                        </div>
                    </div>
                    <hr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                    <?php if(\application\models\User::checkCookies($_COOKIE)): ?>
                    <div class="row ml-3 mb-1 mr-3 mt-1">
                        <div class="row m-0 marpic">
                            <div class="col-2 leftcompic">
                                <a href="" title="username">
                                    <div class="mask-com" style="background-image: url(<?php echo "/" . ROOT . "/" . $_COOKIE['avatar'] ?>)";>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-9 leftcom">
                            <textarea name=<?php echo $val['phid'] ?> placeholder="Comment" class="form-control comment_field" style="height:60px;" ></textarea>
                        </div>
                        <div class="col-1 leftbtn">
                            <button class="btn btn-sm float-left send_comment" value=<?php echo $val['phid'] ?>>Send</button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="/<?php echo ROOT ?>/public/js/index.js"></script>