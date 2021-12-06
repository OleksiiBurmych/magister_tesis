const mix = require('laravel-mix');

mix
    .sass('./resources/scss/bootstrap.scss', './resources/dist/base.css', [])
    .js('./resources/js/user_chat.js', './resources/dist/user-chat.js')
    .js('./resources/js/admin_chat.js', './resources/dist/admin-chat.js')
