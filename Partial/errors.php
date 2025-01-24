<style>
  .fade-out {
    opacity: 1;
    transition: opacity 1s ease-out;
  }
  .fade-out.hidden {
    opacity: 0;
  }
</style>


<?php
if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])):
  ?>
  <div class="alert alert-danger fade-out" role="alert">
    <?php echo htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8'); ?>
  </div>
  <?php
  // Supprimer le message d'erreur après l'avoir affiché
  unset($_SESSION['error_message']);
endif;
?>



<script>
  document.addEventListener("DOMContentLoaded", function() {
    var alertBox = document.querySelector('.alert');
    if (alertBox) {
      setTimeout(function() {
        alertBox.classList.add('hidden');
        setTimeout(function() {
          alertBox.style.display = 'none';
        }, 1000); // Durée de l'animation de disparition
      }, 3000); // Temps avant que l'animation commence
    }
  });
</script>


