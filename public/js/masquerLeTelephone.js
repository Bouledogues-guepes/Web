

    const checkbox = document.getElementById("checkbox");
    const telAmasquer = document.getElementById("telAmasquer");


    checkbox.addEventListener("change", function() {

        if (checkbox.checked) {
            telAmasquer.style.display = "none";
            // Définir le cookie pour masquer
            document.cookie = "masquerNumero=true; expires=Thu, 01 Jan 2099 00:00:00 UTC; path=/";
        } else {
            telAmasquer.style.display = "block";
            // Supprimer le cookie
            document.cookie = "masquerNumero=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }
    });

    // Fonction pour récupérer la valeur d'un cookie par son nom
    function getCookie(name) {
        const cookies = document.cookie.split("; ");
        for (const cookie of cookies) {
            const [cookieName, cookieValue] = cookie.split("=");
            if (cookieName === name) {
                return cookieValue;
            }
        }
        return "";
    }

    // Lire le cookie au chargement de la page et mettre à jour la case à cocher
    window.addEventListener("load", function() {
        const masquerNumeroCookie = getCookie("masquerNumero");
        if (masquerNumeroCookie === "true") {
            checkbox.checked = true;
            telAmasquer.style.display = "none";
        } else {
            checkbox.checked = false;
            telAmasquer.style.display = "block";
        }
    });