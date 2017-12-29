<?php
if($_SESSION['frl_idUser']){
unset($_SESSION['frl_idUser']);
}
?>
    <script> window.location = "<?=principal?>signin"; </script>
<?php
?>