<?php
function renderInputField($name, $label, $type, $value)
{
  ?>

    <div class="mb-4">
      <label for="<?php echo $name; ?>" class="form-label fw-bold"><?php echo $label; ?></label>
      <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>"
             value="<?php echo htmlentities($value); ?>"
             class="form-control shadow-sm border-secondary"
             >
    </div>
    <?php
}
?>
