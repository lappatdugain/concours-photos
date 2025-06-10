// pour les modals
function openImg(event) {
    // Récupérer l'élément cliqué (la div.grid-images)
    let element = event.currentTarget;
    // Récupérer l'attribut "data-modal" de l'élément cliqué
    let modalId = element.getAttribute("data-modal");
    // Récupérer la modal correspondante en utilisant la classe CSS
    let modal = document.querySelector("." + modalId);
    modal.style.display = "block";
  }
  
  function vote(event) {
    event.stopPropagation(); // Empêche l'appel de openImg
    // Code pour gérer le vote ici
    alert("Vote enregistré !");
  }
  
  // Lorsque l'utilisateur clique sur l'élément <span> (x), fermer la modal
  function closeImg(element) {
    // Récupérer l'élément parent de l'élément <span> (la div.modal-box)
    let modalBox = element.parentElement;
    // Récupérer l'élément parent de la div.modal-box (la div.modal)
    let modal = modalBox.parentElement;
    // Fermer la modal
    modal.style.display = "none";
  }
  