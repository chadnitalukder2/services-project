function showNotification(message, type = "success") {
    const notification = document.createElement('div');
    notification.style.marginTop = "0.5rem";
    notification.className = `fixed top-5 right-5 px-4 py-2 rounded shadow text-white z-50 transition-opacity duration-500 ${type === "success" ? "bg-green-500" : "bg-red-500"
        }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = "0";
    }, 2000);

    setTimeout(() => {
        notification.remove();
    }, 2500);
}