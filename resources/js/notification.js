import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: true,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

if (window.authUser && window.authUser.id) {
    const userId = window.authUser.id; // استخراج ID المستخدم

    window.Echo.private(`users.${userId}`)
        .notification((notification) => {

            $.notify({
                title: `<strong>${notification.title}</strong><br>`,
                message: notification.message,
                icon: 'icon-bell' // يمكنك استخدام أيقونة أخرى إذا كنت تستخدم FontAwesome
            }, {
                type: 'secondary', // نوع الإشعار (success, danger, warning, info)
                allow_dismiss: true,
                newest_on_top: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: {
                    x: 20,
                    y: 70
                },
                spacing: 10,
                z_index: 1031,
                delay: 7000, // مدة الإشعار قبل الاختفاء
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
            });
        });
} else {
    console.error('User is not logged in or authUser is not defined.');
}


