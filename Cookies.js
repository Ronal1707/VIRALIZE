function iniciarConsentimientoCookies() {
    const cookieBanner = document.getElementById("cookieConsent");
    const acceptBtn = document.getElementById("acceptCookies");
    const rejectBtn = document.getElementById("rejectCookies");

    if (cookieBanner && acceptBtn && rejectBtn) {
        cookieBanner.style.display = "flex";

        acceptBtn.addEventListener("click", function () {
            console.log("Cookies aceptadas.");
            cookieBanner.style.display = "none";
        });

        rejectBtn.addEventListener("click", function () {
            console.log("Cookies rechazadas.");
            cookieBanner.style.display = "none";
        });
    } else {
        setTimeout(iniciarConsentimientoCookies, 100);
    }
}
iniciarConsentimientoCookies();