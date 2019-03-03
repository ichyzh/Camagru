<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],
    'register' => [
        'controller' => 'user',
        'action' => 'register'
    ],
    'verif' => [
        'controller' => 'user',
        'action' => 'verify'
    ],
    'login' => [
        'controller' => 'user',
        'action' => 'login'
    ],
    'reset' => [
        'controller' => 'user',
        'action' => 'sendReset'
    ],
    'resetpwd' => [
        'controller' => 'user',
        'action' => 'resetPwd'
    ],
    'fboauth' => [
        'controller' => 'user',
        'action' => 'facebookOauth'
    ],
    'googleoauth' => [
        'controller' => 'user',
        'action' => 'googleOauth'
    ],
    'create_photo' => [
        'controller' => 'camera',
        'action' => 'camera'
    ],
    'add_watermark' => [
        'controller' => 'camera',
        'action' => 'watermark'
    ],
    'like' => [
        'controller' => 'post',
        'action' => 'like'
    ],
    'comment' => [
        'controller' => 'post',
        'action' => 'comment'
    ],
    'profile/[a-zA-Z0-9]+(?:[_ -]?[a-zA-Z0-9])*' => [
        'controller' => 'profile',
        'action' => 'profile'
    ],
    'change_login' => [
        'controller' => 'user',
        'action' => 'changeLogin'
    ],
    'change_pwd' => [
        'controller' => 'user',
        'action' => 'changePassword'
    ],
    'change_picture' => [
        'controller' => 'user',
        'action' => 'changePicture'
    ],
    'change_email' => [
        'controller' => 'user',
        'action' => 'changeEmail'
    ],
    'delete_acc' => [
        'controller' => 'user',
        'action' => 'deleteAcc'
    ],
    'disable_notification' => [
        'controller' => 'user',
        'action' => 'notification'
    ],
    'logout' => [
        'controller' => 'user',
        'action' => 'logout'
    ],
    'delete_photo' => [
        'controller' => 'user',
        'action' => 'deletePhoto'
    ]
];
