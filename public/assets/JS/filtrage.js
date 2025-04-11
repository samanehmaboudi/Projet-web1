document.addEventListener("DOMContentLoaded", function () {
    const filtres = {
        pays: document.getElementById("filtre-pays"),
        prix: document.getElementById("filtre-prix"),
        annee: document.getElementById("filtre-annee")
    };

    const cartes = document.querySelectorAll(".carte");

    function filtrer() {
        const paysChoisi = filtres.pays.value.toLowerCase();
        const prixMax = parseFloat(filtres.prix.value);
        const anneeMin = parseInt(filtres.annee.value);

        cartes.forEach(carte => {
            const prix = parseFloat(carte.dataset.prix);
            const pays = carte.dataset.pays;
            const annee = parseInt(carte.dataset.annee);

            let visible = true;

            if (paysChoisi && pays !== paysChoisi) visible = false;
            if (prix > prixMax) visible = false;
            if (annee < anneeMin) visible = false;

            carte.style.display = visible ? "block" : "none";
        });
    }

    filtres.pays.addEventListener("change", filtrer);
    filtres.prix.addEventListener("input", filtrer);
    filtres.annee.addEventListener("input", filtrer);
});
