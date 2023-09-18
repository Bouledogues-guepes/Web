

    // Obtenez une référence à la case à cocher et au paragraphe
    const checkbox = document.getElementById("checkbox");
    const telAmasquer = document.getElementById("telAmasquer");

    // Écoutez l'événement "change" sur la case à cocher
    checkbox.addEventListener("change", function() {
    // Si la case est cochée, masquez le paragraphe, sinon, affichez-le
    if (checkbox.checked) {
    telAmasquer.style.display = "none";
} else {
    telAmasquer.style.display = "block";
}
});