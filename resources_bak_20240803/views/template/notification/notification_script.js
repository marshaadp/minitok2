var box = document.getElementById("box");
var down = false;

function toggleNotifi() {
    if (down) {
        box.style.height = "0px";
        box.style.opacity = 0;
        box.style.zIndex = 0;
        down = false;
    } else {
        box.style.height = "510px";
        box.style.opacity = 1;
        box.style.zIndex = 1;
        down = true;
    }
}
const unreadHeader = document.getElementById("notifesHeader");
const unreadMain = document.getElementById("notifesMain");

const unreadMessages = document.querySelectorAll(".unread");
const markAll = document.getElementById("mark_all");

unreadHeader.innerText = unreadMessages.length;
unreadMain.innerText = unreadMessages.length;

unreadMessages.forEach((message) => {
    message.addEventListener("click", () => {
        message.classList.remove("unread");
        const newUnreadMessages = document.querySelectorAll(".unread");
        unreadHeader.innerText = newUnreadMessages.length;
        unreadMain.innerText = newUnreadMessages.length;
    });
});

markAll.addEventListener("click", () => {
    unreadMessages.forEach((message) => message.classList.remove("unread"));
    const newUnreadMessages = document.querySelectorAll(".unread");
    unreadHeader.innerText = newUnreadMessages.length;
    unreadMain.innerText = newUnreadMessages.length;
});
