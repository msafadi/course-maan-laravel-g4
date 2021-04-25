require('./bootstrap');

require('alpinejs');

window.Echo.private('User.Notifications.' + userId)
    .notification(function(e) {
        alert(e.body)
    })
