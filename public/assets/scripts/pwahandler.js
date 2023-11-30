async function registerServiceWorker() {

    if ("serviceWorker" in navigator) {
        const registration = await navigator.serviceWorker.register("/sw.js");
        console.log(registration);
        let subscription = await registration.pushManager.getSubscription();
        console.log(JSON.stringify(subscription));
        if (subscription) return;

        console.log("subscribe")

        subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: 'BLEnEhzMR6DyXkwFvSkF6ME7gFhKMsRT9rKH1Poxy83fMk0mVsbK9fvQ4USWm-aiNvODCv13fcMx0L0JpSDvBXU'
        })

        console.log(JSON.stringify(subscription));
    }
}


registerServiceWorker();


let installPrompt;
const pwaInstallButton = document.getElementById('pwainstall')

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    installPrompt = e;
    pwaInstallButton.removeAttribute('hidden');
})

pwaInstallButton.addEventListener('click', async () => {
    if (!installPrompt) return;

    const result = await installPrompt.prompt();
    Notification.requestPermission().then((result) => {
        if (result.state == "granted") {
            console.log("yipeee");
        } else {
            console.log(":(");
        }
    })

    installPrompt = null;
    pwaInstallButton.setAttribute('hidden');
})