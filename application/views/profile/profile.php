<div class="container">
    <div class="row ">
        <div class="col-3 p-4">
            <div class="row usrblock">
                <div class="col-3 p-0">
                    <!-- <div class="row usrblock"> -->
                    <div class="col-5 p-0">
                        <div class="profile_img" style="background-image: url(<?php echo "/" . ROOT . "/" . $vars[0]['usr_img'] ?>);">
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="col-3 align-middle">
            <p class="profile_login"><?php echo $vars[0]['login'] ?></p>
        </div>
    </div>
    <?php if($logged['this_user']): ?>
    <div class="row justify-content-center" id="button_row">
        <div class="col-2">
            <p class="nav-link change_btn" id="change_login" onclick="change_login();">Change Login</p>
            <form id="form-login-change" class="hidden" onsubmit="return false;">
                <input type="login" class="form-control f-con" id="login" placeholder="New Login">
                <button class="btn btn-sm button-change" value="Send" id="send-login" onclick="send_login();">Send</button>
            </form>
        </div>
        <div class="col-2">
            <p class="nav-link change_btn" id="change_pwd" onclick="change_pwd();">Change Password</p>
            <form id="form-pw-change" class="hidden" onsubmit="return false;">
                <input type="password" class="form-control f-con" id="oldpassword" placeholder="Old Password">
                <input type="password" class="form-control f-con" id="newpassword" placeholder="New Password">
                <input type="password" class="form-control f-con" id="repeatpassword" placeholder="New Password">
                <button class="btn btn-sm button-change" id="send-pw" onclick="send_pwd();">Send</button>
            </form>
        </div>
        <div class="col-2">
            <p class="nav-link change_btn" id="change_email" onclick="change_email();">Change E-mail</p>
            <form id="form-email-change" class="hidden" onsubmit="return false;">
                <input type="email" class="form-control f-con" id="email" placeholder="Enter email">
                <button class="btn btn-sm button-change" id="send-email" onclick="send_email();">Send</button>
            </form>
        </div>
        <?php endif; ?>
        <?php if($logged['this_user'] || $logged['adm']): ?>
        <div class="col-2">
            <p class="nav-link change_btn" id="delete_acc" title="<?php echo $logged['del_id'] ?> " onclick="delete_acc(this);" >Delete account</p>
        </div>
        <?php endif; ?>
        <?php if($logged['this_user']): ?>
        <div class="col-2">
            <input class="mr-1" id="checkbox" type="checkbox" name="news" value="ON" <?php echo $logged['checked'] ?>>
            <p class="nav-link change_btn" id="disable_notif" onclick="disable_notif();">Notifications</p>
        </div>
    </div>
    <hr>
    <?php endif; ?>
</div>
<div class="container">
    <div class="row text-center">
        <?php if(!isset($vars['empty'])): ?>
        <?php $i = 0; ?>
        <?php foreach ($vars as $key => $val): ?>
        <?php $i++; ?>
        <div class="col-md-4 pb-2 usrphoto" >
            <div class="usr-border">
                <img src=<?php echo "/" . ROOT . "/" . $val['src'] ?> class="w-100 myImages" id="myImg" alt="222" onclick="openModal();currentSlide(<?php echo $i ?>)">
                <div class="row pad-ico text-right" style="border-radius: 5px">
                    <?php if ($logged['this_user'] || $logged['adm']): ?>
                        <div class="col-1">
                            <span class="delete_photo" id="<?php echo $val['id']; ?>"><i class="fas fa-times"></i></span>
                        </div>
                    <?php endif; ?>
                    <div class="col-8 p-0 text-right">
                        <?php if ($val['liked']): ?>
                            <?php echo "<button class='btn like liked' id='like' value=" . $val['id'] . "><i class='far fa-heart io_size pr-1' ><p class='num_likes' style='font-size: 1rem'>" . $val['likes_count'] . "</p></i></button>" ?>
                        <?php else: ?>
                            <?php echo "<button class='btn like' id='like' value=" . $val['id'] . "><i class='far fa-heart io_size pr-1' ><p class='num_likes'>" . $val['likes_count'] . "</p></i></button>" ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-2 p-0 text-right pr-2 ml-3 ">
                        <?php echo "<button class=\"btn like\"><span style=\"font-size: 0.8rem\" onclick=\"openModal();currentSlide($i)\"><i class=\"far fa-comment-alt io_size pr-1 pl-0\"></i>" . $val['comments_count'] . "</span></button>" ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if (!isset($vars['empty'])): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="row justify-content-center">
                    <span class="close" onclick="span();">&times;</span>
                    <?php foreach ($vars as $key => $val): ?>
                        <div class="mySlides" >
                            <div class="col-9 img_p">
                                <img class="w-100 mainp" src=<?php echo "/" . ROOT . "/" . $val['src'] ?> id="img01" alt=<?php echo $val['id'] ?>>
                            </div>
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            <div class="col-9 bod">
                                <div id="caption">
                                    <div class="row border-bottom usrcap">
                                        <div class="col-3">
                                            <a href="http://localhost:8100/<?php echo ROOT . "/profile/" . $val['login'] ?>" title="username">
                                                <div class="mask" style="background-image: url(<?php echo "/" . ROOT . "/" . $val['usr_img'] ?>);">
                                                </div>
                                                <p class="usrlog w-100"><?php echo $val['login'] ?></p>
                                            </a>
                                        </div>
                                        <div class="col-9">
                                            <?php if($logged['this_user']): ?>
                                                <div class="row">
                                                    <div class="col-6 m-auto">
                                                        <button class="btn set_profile" id="<?php echo $val['id'] ?>" onclick="change_picture(this);">Set as profile picture</button>
                                                    </div>
                                                    <?php if ($val['liked']): ?>
                                                        <?php echo "<div class=\"col-3 text-right\">" ?>
                                                        <?php echo "<button class='btn like liked' id='like' value=" . $val['id'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                                        <?php echo "</div>" ?>
                                                    <?php else: ?>
                                                        <?php echo "<div class=\"col-3 text-right\">" ?>
                                                        <?php echo "<button class='btn like' id='like' value=" . $val['id'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                                        <?php echo "</div>" ?>
                                                    <?php endif; ?>
                                                    <div class="col-2 text-right">
                                                        <button class="btn like"><span style="font-size: 1rem"><i class="far fa-comment-alt io_size" style="font-size: 2rem"></i><?php echo $val['comments_count'] ?></span></button>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="row float-right">
                                                    <?php if ($val['liked']): ?>
                                                        <?php echo "<div class=\"col-6 \">" ?>
                                                        <?php echo "<button class='btn like liked' id='like' value=" . $val['id'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                                        <?php echo "</div>" ?>
                                                    <?php else: ?>
                                                        <?php echo "<div class=\"col-6 \">" ?>
                                                        <?php echo "<button class='btn like' id='like' value=" . $val['id'] . "><i class='far fa-heart pr-1 io_size' style='font-size: 2rem' ><p class='num_likes_mod'>" . $val['likes_count'] . "</p></i></button>" ?>
                                                        <?php echo "</div>" ?>
                                                    <?php endif; ?>
                                                    <div class="col-2 text-right">
                                                        <button class="btn like"><span style="font-size: 1rem"><i class="far fa-comment-alt io_size" style="font-size: 2rem"></i><?php echo $val['comments_count'] ?></span></button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="comments<?php echo $val['id'] ?>">
                                    <?php if(isset($val['comments'])): ?>
                                        <?php foreach ($val['comments'] as $com): ?>
                                            <div class="row commentf">
                                                <div class="row m-0 marpic">
                                                    <div class="col-2">
                                                        <a href="http://localhost:8100/<?php echo ROOT  . "/profile/" . $com['usr_login'] ?>" title="username">
                                                            <div class="mask-com" style="background-image: url(<?php echo "/" . ROOT . "/" . $com['usr_img'] ?>)";>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-10 pl-0">
                                                    <a href="http://localhost:8100/<?php echo ROOT . "/" . $com['usr_login'] ?>" style="color: #00cc00"><?php echo $com['usr_login'] ?></a>
                                                    <p class="comtext"><?php echo $com['text'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <?php if($logged['is_logged']): ?>
                                    <div class="row ml-3 mb-1 mr-3 mt-1">
                                        <div class="row m-0 marpic">
                                            <div class="col-2 leftcompic">
                                                <a href="" title="username">
                                                    <div class="mask-com" style="background-image: url(<?php echo $_COOKIE['avatar'] ?>)";>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-9 leftcom">
                                            <textarea name=<?php echo $val['id'] ?> placeholder="Comment" class="form-control comment_field" style="height:60px;" ></textarea>
                                        </div>
                                        <div class="col-1 leftbtn">
                                            <button class="btn btn-sm float-left send_comment" value=<?php echo $val['id'] ?>>Send</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript" src="<?php echo "/" . ROOT . "/" ."public/js/profile.js"; ?>"></script>
