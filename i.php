<!DOCTYPE html>
<html>
<head>
    <title>Formulaire dynamique</title>
    <script>
        function afficherChampTexte() {
            var choix = document.getElementById("choix").value;
            var champPrixVente = document.getElementById("champ-prix-vente");
            var champPrixDepart = document.getElementById("champ-prix-depart");
            
            if (choix === "bids") {
                champPrixVente.style.display = "block";
                champPrixDepart.style.display = "none";
            } else if (choix === "auctions") {
                champPrixVente.style.display = "none";
                champPrixDepart.style.display = "block";
            } else {
                champPrixVente.style.display = "none";
                champPrixDepart.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h1>Formulaire dynamique</h1>
    <form>
        <label for="choix">Sell Type :</label>
        <select id="choix" onchange="afficherChampTexte()">
            <option value="">Sélectionnez une option</option>
            <option value="bids">Bids & Offer</option>
            <option value="auctions">Auctions</option>
        </select>
        <br><br>
        <div id="champ-prix-vente" style="display: none;">
            <label for="prix-vente">Prix de vente :</label>
            <input type="text" id="prix-vente">
        </div>
        <div id="champ-prix-depart" style="display: none;">
            <label for="prix-depart">Prix de départ :</label>
            <input type="text" id="prix-depart">
        </div>
    </form>
</body>
</html>
