document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("notificationDropdown").addEventListener("click", function () {
        fetch("{{ route('notifications.fetch') }}") // استبدل بمسار جلب الإشعارات
            .then(response => response.json())
            .then(data => {
                let notificationList = document.querySelector(".notifications-list");
                notificationList.innerHTML = "";
                if (data.length > 0) {
                    data.forEach(notification => {
                        let timestamp = new Date(notification.created_at);
                        let formattedTime = timestamp.toLocaleDateString('ar-EG', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        let item = `
                            <li class="dropdown-item">
                                <span>${notification.data.message}</span>
                                <span class="notification-time">${formattedTime}</span>
                            </li>`;
                        notificationList.innerHTML += item;
                    });
                } else {
                    notificationList.innerHTML = `<li class="dropdown-item text-center">لا توجد إشعارات جديدة</li>`;
                }
                document.getElementById("notificationCount").innerText = data.length;
            })
            .catch(error => console.error("Error fetching notifications:", error));
    });
});
