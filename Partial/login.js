// import { loadContentFromUrl } from "./fetch.js"; // Importer la fonction

// document.addEventListener("DOMContentLoaded", () => {
//   const loginForm = document.getElementById("form-login");
//   const loginButton = document.getElementById("connexion_button");
//   const messageContainer = document.getElementsByClassName("container"); // Utiliser l'élément avec la classe "container"

//   loginForm.addEventListener("submit", async (event) => {
//     event.preventDefault(); // Empêche le rechargement de la page

//     // Désactive temporairement le bouton pour éviter les multiples soumissions
//     loginButton.disabled = true;
//     loginButton.textContent = "Connexion en cours...";

//     // Récupère les données du formulaire
//     const formData = new FormData(loginForm);
//     const data = Object.fromEntries(formData);

//     try {
//       // Envoi de la requête au serveur
//       const response = await fetch("index.php?component=login", {

//         method: "POST",
//         headers: {
//           "Content-Type": "application/json"
//         },
//         body: JSON.stringify(data)
//       });

//       // Vérifie si la requête a réussi
//       if (!response.ok) {
//         console.error("Erreur HTTP :", response.status, response.statusText);
//         throw new Error(`Erreur serveur (HTTP ${response.status})`);
//       }

//       const jsonResponse = await response.json(); // Lecture de la réponse JSON

//       // Vérifie si la connexion est réussie
//       if (jsonResponse.success) {
//         // Change l'URL pour la redirection (optionnel)
//         const targetUrl = new URL(
//           "/index.php?component=home",
//           window.location.origin
//         ); // Remplace par l'URL souhaitée
//         history.pushState({}, "", targetUrl);

//         // Charge uniquement la partie dynamique dans le conteneur prévu
//         const mainContainer = document.getElementsByClassName("container"); // Utilise un conteneur spécifique
//         mainContainer.innerHTML = jsonResponse.content; // Insère le contenu dynamique du tableau de bord

//         // Optionnel : Affiche un message de succès dans la console
//         console.log("Connexion réussie, page mise à jour !");
//       } else {
//         // Affiche un message d'erreur si la connexion échoue
//         messageContainer.innerHTML = `<div class="alert alert-danger">${
//           jsonResponse.message || "Identifiants incorrects."
//         }</div>`;
//       }
//     } catch (error) {
//       console.error("Erreur détectée :", error);

//       // Affiche un message d'erreur général dans le conteneur
//       messageContainer.innerHTML =
//         '<div class="alert alert-danger">Une erreur s\'est produite. Veuillez réessayer plus tard.</div>';
//     } finally {
//       // Réactive toujours le bouton après traitement
//       loginButton.disabled = false;
//       loginButton.textContent = "Connexion";
//     }
//   });
// });
