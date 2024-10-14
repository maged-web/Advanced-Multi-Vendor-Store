import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Echo from 'laravel-echo'


var channel = window.Echo.private(`App.Models.User.${userID}`);
channel.notification(function(data) {
    console.log(data)
    alert(JSON.stringify(data.body));
});