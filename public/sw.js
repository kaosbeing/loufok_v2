
/* const cacheFirst = async ({ request, fallbackUrl }) => {
    const responseFromCache = await caches.match(request);
    if (responseFromCache) {
        return responseFromCache;
    }

    try {
        const responseFromNetwork = await fetch(request);
        const cache = await caches.open("cache");
        await cache.put(request, responseFromNetwork.clone());
        return responseFromNetwork;
    } catch (error) {
        const fallbackResponse = await caches.match(fallbackUrl);
        if (fallbackResponse) {
            return fallbackResponse;
        }

        return new Response("Network error", {
            status: 408,
            headers: { "Content-Type": "text/plain" }
        })
    }

}


self.addEventListener("fetch", (event) => {
    event.respondWith(
        cacheFirst({
            request: event.request,
            fallbackUrl: "fallback.html"
        })
    )
}); */

// sw.js

self.addEventListener("push", (event) => {
    console.log("push event", event);
    const data = event.data;
    event.waitUntil(self.registration.showNotification("Hello world", data));
})





