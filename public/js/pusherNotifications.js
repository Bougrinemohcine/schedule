var notificationsWrapper = $(".notificationDiv");
var notificationsToggle = notificationsWrapper.find("button[data-toggle]");
var notificationsCountElem = notificationsToggle.find("span[data-count]");
var notificationsCount = parseInt(notificationsCountElem.data("count"));
var notifications = notificationsWrapper.find("div[data-simplebar");

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe("my-channel");
// Bind a function to a Event (the full Laravel class)
channel.bind("request-submitted", function (data) {
    var existingNotifications = notifications.html();
    var newNotificationHtml =
        `<a href="` +
        data.user_id +
        `" class="text-reset notification-item">
        <div class="d-flex align-items-start">
            <img src="assets/images/users/avatar-3.jpg"
                class="me-3 rounded-circle avatar-xs" alt="user-pic">
            <div class="flex-1">
                <h6 class="mt-0 mb-1">` +
        data.user_name +
        `</h6>
                <div class="font-size-12 text-muted">
                    <p class="mb-1">` +
        data.comment +
        ` .</p>
                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> ` +
        data.date +
        data.time +
        `</p>
                </div>
            </div>
        </div>`;

    notifications.html(newNotificationHtml + existingNotifications);
    notificationsCount += 1;
    notificationsCountElem.attr("data-count", notificationsCount);
    notificationsWrapper.find(".rounded-pill").text(notificationsCount);
    notificationsWrapper.show();
});
